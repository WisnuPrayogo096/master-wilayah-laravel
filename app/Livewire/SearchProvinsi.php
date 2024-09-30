<?php

namespace App\Livewire;

use App\Models\Wilayah;
use Livewire\Component;
use App\Models\RsMWilayah;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SearchProvinsi extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedProvinsiId = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingProvinsiId = null;
    // public $wilayah;
    public string | null $modalType = 'info';
    public $form = [
        'kode' => '',
        'nama' => '',
        'ibu_kota' => '',
    ];

    protected $rules = [
        'form.kode' => 'required|string|max:255',
        'form.nama' => 'required|string|max:255',
        'form.ibu_kota' => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openInfoModal($provinsiId)
    {
        $this->modalType = 'info';
        $this->showModal =  true;
        $this->selectedProvinsiId = $provinsiId;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->modalType = 'create';
        $this->showModal = true;
    }

    public function openEditModal($provinsiId)
    {
        $this->editingProvinsiId = $provinsiId;
        $this->modalType = 'edit';
        $provinsi = Wilayah::findOrFail($provinsiId);
        $this->form = [
            'kode' => $provinsi->kode,
            'nama' => $provinsi->nama,
            'ibu_kota' => $provinsi->ibu_kota,
        ];
        $this->showModal = true;
    }

    public function confirmDelete($provinsiId)
    {
        $this->modalType = 'delete';
        $this->showModal = true;
        $this->editingProvinsiId = $provinsiId;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingProvinsiId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'kode' => '',
            'nama' => '',
            'ibu_kota' => '',
        ];
    }

    public function createProvinsi()
    {
        $this->validate();
        $existingKode = Wilayah::where('kode', $this->form['kode'])->first();

        if ($existingKode) {
            $this->dispatch('notify', 'Kode already exists in the database');
            return;
        }

        DB::beginTransaction();
        try {
            Wilayah::create([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                'ibu_kota' => $this->form['ibu_kota'],
                'type' => 1,
                'kategori_wilayah' => 'PROV.',
                'kode_negara' => 'ID',
                'created_by' => 0,
                'updated_by' => 0,
                'deleted_by' => 0,
                'restored_by' => 0,
                'created_at' => now()->setTimezone('Asia/Jakarta'),
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            RsMWilayah::create([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                'ibu_kota' => $this->form['ibu_kota'],
                'type' => 1,
                'kategori_wilayah' => 'PROV.',
                'kode_negara' => 'ID',
                'ket' => null,
                'update_time' => now()->setTimezone('Asia/Jakarta'),
            ]);

            DB::commit();
            $this->closeModal();
            $this->dispatch('notify', 'Created successfully');
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'Error creating: ' . $e->getMessage());
        }
    }

    public function updateProvinsi()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $provinsi = Wilayah::findOrFail($this->editingProvinsiId);
            $oldKode = $provinsi->kode;
            $provinsi->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                'ibu_kota' => $this->form['ibu_kota'],
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            RsMWilayah::where('kode', $oldKode)->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                'ibu_kota' => $this->form['ibu_kota'],
                'update_time' => now()->setTimezone('Asia/Jakarta'),
            ]);

            DB::commit();
            $this->closeModal();
            $this->dispatch('notify', 'Updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'Error updating: ' . $e->getMessage());
        }
    }

    public function deleteProvinsi()
    {
        DB::beginTransaction();
        try {
            $provinsi = Wilayah::findOrFail($this->editingProvinsiId);
            $provinsi->delete();

            RsMWilayah::where('kode', $provinsi->kode)->delete();

            DB::commit();
            $this->closeModal();
            $this->dispatch('notify', 'Deleted successfully');
        } catch (\Exception $e) {
            DB::rollback();
            $this->dispatch('notify', 'Error deleting: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $wilayah= Wilayah::where(function($query) {
                $query->where('nama', 'like', '%'.$this->search.'%');
            })
            ->where('type', 1)
            ->whereNull('deleted_at')
            ->orderBy('nama', 'asc')
            ->paginate(25);

        return view('livewire.search-provinsi', [
            'wilayahs' => $wilayah,
            'selectedProvinsi' => $this->selectedProvinsiId ? Wilayah::find($this->selectedProvinsiId) : null,
        ]);
    }
}