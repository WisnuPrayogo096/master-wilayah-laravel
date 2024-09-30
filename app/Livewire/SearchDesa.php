<?php

namespace App\Livewire;

use App\Models\Wilayah;
use Livewire\Component;
use App\Models\RsMWilayah;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SearchDesa extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDesaId = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingDesaId = null;
    public string | null $modalType = 'info';

    public $kode;
    public $form = [
        'kode' => '',
        'nama' => '',
        // 'ibu_kota' => '',
        'kategori_wilayah' => '',
    ];

    protected $rules = [
        'form.kode' => 'required|string|max:255',
        'form.nama' => 'required|string|max:255',
        // 'form.ibu_kota' => 'required|string|max:255',
        'form.kategori_wilayah' => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openInfoModal($desaId)
    {
        $this->modalType = 'info';
        $this->showModal =  true;
        $this->selectedDesaId = $desaId;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->modalType = 'create';
        $this->showModal = true;
    }

    public function openEditModal($desaId)
    {
        $this->editingDesaId = $desaId;
        $this->modalType = 'edit';
        $desa = Wilayah::findOrFail($desaId);
        $this->form = [
            'kode' => $desa->kode,
            'nama' => $desa->nama,
            // 'ibu_kota' => $desa->ibu_kota,
            'kategori_wilayah' => $desa->kategori_wilayah,
        ];
        $this->showModal = true;
    }

    public function confirmDelete($desaId)
    {
        $this->modalType = 'delete';
        $this->showModal = true;
        $this->editingDesaId = $desaId;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingDesaId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'kode' => $this->kode . '.',
            'nama' => '',
            // 'ibu_kota' => '',
            'kategori_wilayah' => '',
        ];
    }

    public function backPage()
    {
        $merge = explode('.', $this->kode);
        $kodeKecamatan = $merge[0] . '.' . $merge[1];

        return url('kecamatan/' . $kodeKecamatan);
    }

    public function createDesa()
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
                'ibu_kota' => '',
                'type' => 4,
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
                'ibu_kota' => '',
                'type' => 4,
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

    public function updateDesa()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $desa = Wilayah::findOrFail($this->editingDesaId);
            $oldKode = $desa->kode;
            $desa->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                // 'ibu_kota' => $this->form['ibu_kota'],
                'kategori_wilayah' => $this->form['kategori_wilayah'],
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            RsMWilayah::where('kode', $oldKode)->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                // 'ibu_kota' => $this->form['ibu_kota'],
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

    public function deleteDesa()
    {
        DB::beginTransaction();
        try {
            $desa = Wilayah::findOrFail($this->editingDesaId);
            $desa->delete();

            RsMWilayah::where('kode', $desa->kode)->delete();

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
            ->where('type', 4)
            ->whereNull('deleted_at')
            ->orderBy('nama', 'asc')
            ->paginate(25);

        return view('livewire.search-desa', [
            'wilayahs' => $wilayahs,
            'selectedDesa' => $this->selectedDesaId ? Wilayah::find($this->selectedDesaId) : null,
        ]);
    }
}