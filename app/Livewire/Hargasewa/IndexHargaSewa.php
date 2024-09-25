<?php

namespace App\Livewire\Hargasewa;

use App\Models\User;
use Livewire\Component;
use App\Models\Hargasewa;
use App\Models\Kendaraan;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class IndexHargaSewa extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $kendaraans, $total, $paginate = 10;

    public $search;

    #[Rule('required', as: 'Merk')]
    public $merk;

    #[Rule('required', as: 'Tipe')]
    public $tipe;

    #[Rule('required', as: 'Kendaraan')]
    public $kendaraan;

    #[Rule('required', as: 'Lama Sewa')]
    public $lama_sewa;

    #[Rule('required', as: 'Harga Sewa')]
    public $harga_sewa;

    #[On('updateModal')]
    public function render()
    {
        $this->total = Hargasewa::all()->count();
        $this->kendaraans = Kendaraan::all();

        return view(
            'livewire.hargasewa.index-harga-sewa',
            [
                'hargasewis'  => $this->search === null ?
                    Hargasewa::paginate($this->paginate) :
                    Hargasewa::where(function ($query) {
                        $query->where('merk', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('tipe', 'LIKE', '%' . $this->search . '%')
                            ->orWhereHas('user', function ($query) {
                                $query->where('name', 'LIKE', '%' . $this->search . '%');
                            });
                    })->paginate($this->paginate),
                'kendaraans' => $this->kendaraans,
                'total' => $this->total
            ]
        );
    }

    public function store()
    {
        $this->validate();
        Hargasewa::create([
            'kendaraan_id' => $this->kendaraan,
            'merk' => $this->merk,
            'tipe' => $this->tipe,
            'lama_sewa' => $this->lama_sewa,
            'harga_sewa' => $this->harga,
        ]);

        toastr()->success('Harga Sewa berhasil ditambahkan');
        $this->reset();
        $this->dispatch('created');
    }

    public function edit($id)
    {
        $this->kendaraan = Hargasewa::find($id);

        $this->kendaraan = $this->kendaraan->kendaraan_id;
        $this->merk = $this->kendaraan->merk;
        $this->tipe = $this->kendaraan->tipe;
        $this->lama_sewa = $this->kendaraan->lama_sewa;
        $this->harga_sewa = $this->kendaraan->harga;
    }

    public function update()
    {
        $this->validate();
        $this->kendaraan->update([
            'kendaraan_id' => $this->kendaraan,
            'merk' => $this->merk,
            'tipe' => $this->tipe,
            'lama_sewa' => $this->lama_sewa,
            'harga_sewa' => $this->harga,
        ]);

        toastr()->success('Harga sewa berhasil diperbarui');
        $this->dispatch('edited');
    }

    public function delete($id)
    {
        $kendaraan = Hargasewa::find($id);
        $kendaraan->delete();
        toastr()->success('Harga sewa berhasil di hapus');
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
