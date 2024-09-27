<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Kendaraan;
use App\Models\Transaksi;

class Dashboard extends Component
{
    public $semuaTransaksi, $sedangProses, $jumlaKendaraan, $pendapatan;
    public function mount()
    {
        if (auth()->user()->role == 'super_admin') {
            $this->semuaTransaksi = Transaksi::all()->count();
            $this->sedangProses = Transaksi::where('status', 'proses')->count();
            $this->jumlaKendaraan = Kendaraan::all()->count();
            $this->pendapatan = Transaksi::where('status', 'selesai')->sum('total_harga');
        } else {
            $this->semuaTransaksi = Transaksi::where('mitra_id', auth()->user()->mitra_id)->count();
            $this->sedangProses = Transaksi::where('mitra_id', auth()->user()->mitra_id)->where('status', 'proses')->count();
            $this->jumlaKendaraan = Kendaraan::where('mitra_id', auth()->user()->mitra_id)->count();
            $this->pendapatan = Transaksi::where('mitra_id', auth()->user()->mitra_id)->where('status', 'selesai')->sum('total_harga');
        }
    }
    public function render()
    {
        return view('livewire.dashboard', [
            'semuaTransaksi' => $this->semuaTransaksi,
            'sedangProses' => $this->sedangProses,
            'jumlaKendaraan' => $this->jumlaKendaraan,
            'pendapatan' => $this->pendapatan
        ]);
    }
}
