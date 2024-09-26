<?php

namespace App\Livewire\Riwayat;

use App\Models\User;
use Livewire\Component;
use App\Models\Kendaraan;
use App\Models\Transaksi;
use Livewire\WithPagination;

class IndexRiwayat extends Component
{
    use WithPagination;

    public $paginate = 10;
    public $search;
    public $total;

    public function render()
    {
        $this->total = Transaksi::where('status', 'selesai')->get()->count();

        return view(
            'livewire.riwayat.index-riwayat',
            [
                'transaksis'  => $this->search === null ?
                    Transaksi::where('status', 'selesai')
                    ->where('mitra_id', auth()->user()->mitra_id)
                    ->orderBy('id', 'DESC')
                    ->paginate($this->paginate) :
                    Transaksi::whereHas('user', function ($query) {
                        $query->where('nama', 'LIKE', '%' . $this->search . '%');
                    })->orderBy('id', 'DESC')->paginate($this->paginate),
                'total' => $this->total,
            ]
        );
    }
}
