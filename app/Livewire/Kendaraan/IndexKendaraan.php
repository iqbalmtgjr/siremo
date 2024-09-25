<?php

namespace App\Livewire\Kendaraan;

use App\Models\User;
use Livewire\Component;
use App\Models\Kendaraan;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class IndexKendaraan extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $users, $kendaraan, $total, $paginate = 10;

    public $search;

    #[Rule('required', as: 'Merk')]
    public $merk;

    #[Rule('required', as: 'Tipe')]
    public $tipe;

    #[Rule('required', as: 'Pemilik')]
    public $pemilik;

    public $status;

    #[Rule('required', as: 'Plat Kendaraan')]
    public $plat;

    #[Rule('required', as: 'Alamat Kendaraan')]
    public $alamat;

    #[On('updateModal')]
    public function render()
    {
        $this->total = Kendaraan::all()->count();
        $this->users = User::where('role', '<>', 'super_admin')->get();

        return view(
            'livewire.kendaraan.index-kendaraan',
            [
                'kendaraans'  => $this->search === null ?
                    Kendaraan::paginate($this->paginate) :
                    Kendaraan::where(function ($query) {
                        $query->where('merk', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('plat', 'LIKE', '%' . $this->search . '%')
                            ->orWhereHas('user', function ($query) {
                                $query->where('nama', 'LIKE', '%' . $this->search . '%');
                            });
                    })->paginate($this->paginate),
                'users' => $this->users,
                'total' => $this->total
            ]
        );
    }

    public function store()
    {
        $this->validate();
        Kendaraan::create([
            'user_id' => $this->pemilik,
            'plat' => $this->plat,
            'merk' => $this->merk,
            'tipe' => $this->tipe,
            'alamat' => $this->alamat,
            'status' => 'Tersedia'
        ]);

        toastr()->success('Kendaraan berhasil ditambahkan');
        $this->reset();
        $this->dispatch('created');
    }

    public function edit($id)
    {
        $this->kendaraan = Kendaraan::find($id);

        $this->pemilik = $this->kendaraan->user_id;
        $this->plat = $this->kendaraan->plat;
        $this->merk = $this->kendaraan->merk;
        $this->tipe = $this->kendaraan->tipe;
        $this->alamat = $this->kendaraan->alamat;
        $this->status = $this->kendaraan->status;
    }

    public function update()
    {
        $this->validate();
        $this->kendaraan->update([
            'user_id' => $this->pemilik,
            'plat' => $this->plat,
            'merk' => $this->merk,
            'tipe' => $this->tipe,
            'alamat' => $this->alamat,
            'status' => $this->status
        ]);

        toastr()->success('Kendaraan berhasil diperbarui');
        $this->dispatch('edited');
    }

    public function delete($id)
    {
        $kendaraan = Kendaraan::find($id);
        $kendaraan->delete();
        toastr()->success('Kendaraan berhasil di hapus');
        $this->dispatch('deleted');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetInput()
    {
        $this->reset();
    }
}
