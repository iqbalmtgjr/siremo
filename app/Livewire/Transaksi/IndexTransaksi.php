<?php

namespace App\Livewire\Transaksi;

use App\Models\User;
use Livewire\Component;
use App\Models\Hargasewa;
use App\Models\Kendaraan;
use App\Models\Transaksi;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class IndexTransaksi extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $transaksii, $users, $kendaraans, $total, $paginate = 10;

    public $search;

    #[Validate('required', as: 'Kendaraan')]
    public $kendaraan;

    public $pengguna;

    #[Validate('required', as: 'Lama Sewa')]
    public $lama_sewa;

    #[Validate(['ktp.*' => 'image|max:1024'], as: 'Upload KTP')]
    public $ktp;

    #[Validate('required', as: 'Pembayaran')]
    public $pembayaran;

    public $status;
    public $total_harga;

    public function render()
    {
        $this->total = Transaksi::all()->count();
        $this->kendaraans = Kendaraan::all();
        $this->users = User::where('role', '<>', 'super_admin')->get();

        return view(
            'livewire.transaksi.index-transaksi',
            [
                'transaksis'  => $this->search === null ?
                    Transaksi::paginate($this->paginate) :
                    Transaksi::whereHas('user', function ($query) {
                        $query->where('nama', 'LIKE', '%' . $this->search . '%');
                    })->paginate($this->paginate),
                'kendaraans' => $this->kendaraans,
                'total' => $this->total,
                'users' => $this->users
            ]
        );
    }

    public function store()
    {
        $this->validate();
        $harga_sewaa = Hargasewa::where('kendaraan_id', $this->kendaraan)->first()->harga;
        $total_hargaa = $this->lama_sewa * $harga_sewaa;
        if ($this->ktp != null) {
            $filename = $this->ktp->hashName();
            $this->ktp->storeAs('pengguna/ktp/', $filename, 'public');
            Transaksi::create([
                'kendaraan_id' => $this->kendaraan,
                'user_id' => $this->pengguna,
                'lama_sewa' => $this->lama_sewa,
                'total_harga' => $total_hargaa,
                'pembayaran' => $this->pembayaran,
                'status' => 'proses',
                'ktp' => $filename
            ]);
        } else {
            Transaksi::create([
                'kendaraan_id' => $this->kendaraan,
                'user_id' => $this->pengguna,
                'lama_sewa' => $this->lama_sewa,
                'total_harga' => $total_hargaa,
                'pembayaran' => $this->pembayaran,
                'status' => 'proses',
            ]);
        }

        toastr()->success('Transaksi berhasil ditambahkan');
        $this->reset();
        $this->dispatch('created');
    }

    public function edit($id)
    {
        $this->transaksii = Transaksi::find($id);

        $this->kendaraan = $this->transaksii->kendaraan_id;
        $this->pengguna = $this->transaksii->user_id;
        $this->lama_sewa = $this->transaksii->lama_sewa;
        $this->pembayaran = $this->transaksii->pembayaran;
        $this->status = $this->transaksii->status;
    }

    public function update()
    {
        $this->validate();
        // $validatedData = $this->validate([
        //     'kendaraan' => ['required', 'exists:kendaraan,id'],
        //     'pengguna' => ['required', 'exists:users,id'],
        //     'lama_sewa' => ['required'],
        //     'pembayaran' => ['required'],
        //     'status' => ['required'],
        // ]);
        $harga_sewaa = Hargasewa::where('kendaraan_id', $this->kendaraan)->first()->harga;
        $total_hargaa = $this->lama_sewa * $harga_sewaa;

        if ($this->ktp != null) {
            $filename = $this->ktp->hashName();
            $this->ktp->storeAs('pengguna/ktp/', $filename, 'public');
            Transaksi::where('id', $this->transaksii->id)->update([
                'kendaraan_id' => $this->kendaraan,
                'user_id' => $this->pengguna,
                'lama_sewa' => $this->lama_sewa,
                'pembayaran' => $this->pembayaran,
                'status' => $this->status,
                'total_harga' => $total_hargaa,
                'ktp' => $filename
            ]);
        } else {
            Transaksi::where('id', $this->transaksii->id)->update([
                'kendaraan_id' => $this->kendaraan,
                'user_id' => $this->pengguna,
                'lama_sewa' => $this->lama_sewa,
                'pembayaran' => $this->pembayaran,
                'status' => $this->status,
                'total_harga' => $total_hargaa
            ]);
        }

        toastr()->success('Transaksi berhasil diperbarui');
        $this->dispatch('edited');
    }

    public function delete($id)
    {
        $kendaraan = Transaksi::find($id);
        $kendaraan->delete();
        toastr()->success('Transaksi berhasil di hapus');
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
