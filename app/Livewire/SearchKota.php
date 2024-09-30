<?php

namespace App\Livewire;

use App\Models\Wilayah;
use Livewire\Component;
use App\Models\RsMWilayah;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SearchKota extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedKotaId = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingKotaId = null;
    public string | null $modalType = 'info';

    public $kode;
    public $form = [
        'kode' => '',
        'nama' => '',
        'ibu_kota' => '',
        'kategori_wilayah' => '',
    ];

    protected $rules = [
        'form.kode' => 'required|string|max:255',
        'form.nama' => 'required|string|max:255',
        'form.ibu_kota' => 'required|string|max:255',
        'form.kategori_wilayah' => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openInfoModal($kotaId)
    {
        $this->modalType = 'info';
        $this->showModal =  true;
        $this->selectedKotaId = $kotaId;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->modalType = 'create';
        $this->showModal = true;
    }

    public function openEditModal($kotaId)
    {
        $this->editingKotaId = $kotaId;
        $this->modalType = 'edit';
        $kota = Wilayah::findOrFail($kotaId);
        $this->form = [
            'kode' => $kota->kode,
            'nama' => $kota->nama,
            'ibu_kota' => $kota->ibu_kota,
            'kategori_wilayah' => $kota->kategori_wilayah,
        ];
        $this->showModal = true;
    }

    public function confirmDelete($kotaId)
    {
        $this->modalType = 'delete';
        $this->showModal = true;
        $this->editingKotaId = $kotaId;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingKotaId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'kode' => $this->kode . '.',
            'nama' => '',
            'ibu_kota' => '',
            'kategori_wilayah' => '',
        ];
    }

    public function createKota()
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
                'type' => 2,
                'kategori_wilayah' => $this->form['kategori_wilayah'],
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
                'type' => 2,
                'kategori_wilayah' => $this->form['kategori_wilayah'],
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

    public function updateKota()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $kota = Wilayah::findOrFail($this->editingKotaId);
            $oldKode = $kota->kode;
            $kota->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                'ibu_kota' => $this->form['ibu_kota'],
                'kategori_wilayah' => $this->form['kategori_wilayah'],
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            RsMWilayah::where('kode', $oldKode)->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                'ibu_kota' => $this->form['ibu_kota'],
                'kategori_wilayah' => $this->form['kategori_wilayah'],
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

    public function deleteKota()
    {
        DB::beginTransaction();
        try {
            $kota = Wilayah::findOrFail($this->editingKotaId);
            $kota->delete();

            RsMWilayah::where('kode', $kota->kode)->delete();

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
        $wilayahs = Wilayah::where('kode', 'like', $this->kode . '%')
            ->where(function($query) {
                $query->where('nama', 'like', '%'.$this->search.'%');
            })
            ->where('type', 2)
            ->whereNull('deleted_at')
            ->orderBy('nama', 'asc')
            ->paginate(25);

        return view('livewire.search-kota', [
            'wilayahs' => $wilayahs,
            'selectedKota' => $this->selectedKotaId ? Wilayah::find($this->selectedKotaId) : null,
        ]);
    }
}