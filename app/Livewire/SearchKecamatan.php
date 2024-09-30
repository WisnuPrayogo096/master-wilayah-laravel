<?php

namespace App\Livewire;

use App\Models\Wilayah;
use Livewire\Component;
use App\Models\RsMWilayah;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class SearchKecamatan extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedKecamatanId = null;
    public $showModal = false;
    public $showDeleteModal = false;
    public $editingKecamatanId = null;
    public string | null $modalType = 'info';

    public $kode;
    public $form = [
        'kode' => '',
        'nama' => '',
        // 'ibu_kota' => '',
    ];

    protected $rules = [
        'form.kode' => 'required|string|max:255',
        'form.nama' => 'required|string|max:255',
        // 'form.ibu_kota' => 'required|string|max:255',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openInfoModal($kecamatanId)
    {
        $this->modalType = 'info';
        $this->showModal =  true;
        $this->selectedKecamatanId = $kecamatanId;
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->modalType = 'create';
        $this->showModal = true;
    }

    public function openEditModal($kecamatanId)
    {
        $this->editingKecamatanId = $kecamatanId;
        $this->modalType = 'edit';
        $kecamatan = Wilayah::findOrFail($kecamatanId);
        $this->form = [
            'kode' => $kecamatan->kode,
            'nama' => $kecamatan->nama,
            // 'ibu_kota' => $kecamatan->ibu_kota,
        ];
        $this->showModal = true;
    }

    public function confirmDelete($kecamatanId)
    {
        $this->modalType = 'delete';
        $this->showModal = true;
        $this->editingKecamatanId = $kecamatanId;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->editingKecamatanId = null;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->form = [
            'kode' => $this->kode . '.',
            'nama' => '',
            // 'ibu_kota' => '',
        ];
    }

    public function backPage()
    {
        $kodeKota = explode('.', $this->kode)[0];

        return url('kota/' . $kodeKota);
    }

    public function createKecamatan()
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
                'type' => 3,
                'kategori_wilayah' => 'KEC.',
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
                'type' => 3,
                'kategori_wilayah' => 'KEC.',
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

    public function updateKecamatan()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $kecamatan = Wilayah::findOrFail($this->editingKecamatanId);
            $oldKode = $kecamatan->kode;
            $kecamatan->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                // 'ibu_kota' => $this->form['ibu_kota'],
                'updated_at' => now()->setTimezone('Asia/Jakarta'),
            ]);

            RsMWilayah::where('kode', $oldKode)->update([
                'kode' => $this->form['kode'],
                'nama' => $this->form['nama'],
                // 'ibu_kota' => $this->form['ibu_kota'],
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

    public function deleteKecamatan()
    {
        DB::beginTransaction();
        try {
            $kecamatan = Wilayah::findOrFail($this->editingKecamatanId);
            $kecamatan->delete();

            RsMWilayah::where('kode', $kecamatan->kode)->delete();

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
            ->where('type', 3)
            ->whereNull('deleted_at')
            ->orderBy('nama', 'asc')
            ->paginate(25);

        return view('livewire.search-kecamatan', [
            'wilayahs' => $wilayahs,
            'selectedKecamatan' => $this->selectedKecamatanId ? Wilayah::find($this->selectedKecamatanId) : null,
        ]);
    }
}