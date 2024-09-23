<?php

namespace App\Livewire\Kendaraan;

use App\Models\Kendaraan;
use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Component;

class IndexKendaraan extends Component
{
    public $kendaraans, $users;

    #[Validate('required')]
    public $merk;

    #[Validate('required')]
    public $tipe;

    #[Validate('required')]
    public $pemilik;

    #[Validate('required')]
    public $status;

    #[Validate('required')]
    public $plat;

    public function render()
    {
        $this->kendaraans = Kendaraan::all();
        $this->users = User::all();

        return view(
            'livewire.kendaraan.index-kendaraan',
            [
                'kendaraans' => $this->kendaraans,
                'users' => $this->users
            ]
        );
    }

    public function store()
    {
        // dd($this->all());
        $this->validate();
        Kendaraan::create([
            'user_id' => $this->pemilik,
            'plat' => $this->plat,
            'merk' => $this->merk,
            'tipe' => $this->tipe,
            'status' => 'Tersedia'
        ]);

        $this->reset();
        $this->dispatch('stored');
    }
}
