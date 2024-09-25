<?php

namespace App\Livewire\Mitra;

use App\Models\Mitra;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class IndexMitra extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $mitra, $total, $paginate = 10;

    public $search;

    #[Validate('required', as: 'Nama Mitra')]
    public $nama;

    #[Validate('required', as: 'Alamat Mitra')]
    public $alamat;

    #[Validate('required', as: 'No Hp Mitra')]
    public $no_hp;

    #[Validate(['logo.*' => 'image|max:1024'])]
    public $logo;

    public function render()
    {
        $this->total = Mitra::all()->count();

        return view(
            'livewire.mitra.index-mitra',
            [
                'mitras'  => $this->search === null ?
                    Mitra::paginate($this->paginate) :
                    Mitra::where(function ($query) {
                        $query->where('nama', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('alamat', 'LIKE', '%' . $this->search . '%')
                            ->orWhere('no_hp', 'LIKE', '%' . $this->search . '%');
                    })->paginate($this->paginate),
                'total' => $this->total
            ]
        );
    }

    public function store()
    {
        // dd($this->all());
        $this->validate();
        if ($this->logo != null) {
            $filename = time() . rand(1, 200) . '.' . $this->logo->extension();
            $this->logo->storeAs('public/mitra/logo/', $filename);
            Mitra::create([
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'no_hp' => $this->no_hp,
                'status' => 'buka',
                'logo' => $filename
            ]);
        } else {
            Mitra::create([
                'nama' => $this->nama,
                'alamat' => $this->alamat,
                'no_hp' => $this->no_hp,
                'status' => 'buka',
            ]);
        }

        toastr()->success('Mitra berhasil ditambahkan');
        $this->reset();
        $this->dispatch('created');
    }

    public function edit($id)
    {
        $this->mitra = Mitra::find($id);

        $this->nama = $this->mitra->nama;
        $this->alamat = $this->mitra->alamat;
        $this->no_hp = $this->mitra->no_hp;
    }

    public function update()
    {
        $this->validate();
        $this->mitra->update([
            'nama' => $this->nama,
            'alamat' => $this->alamat,
            'no_telp' => $this->no_telp,
            'email' => $this->email
        ]);

        toastr()->success('Mitra berhasil diperbarui');
        $this->dispatch('edited');
    }

    public function delete($id)
    {
        $mitra = Mitra::find($id);
        $mitra->delete();
        toastr()->success('Mitra berhasil di hapus');
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
