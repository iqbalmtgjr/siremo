<div wire:ignore.self class="modal fade" id="tambah" tabindex="-1" aria-labelledby="modalCreateKendaraanLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCreateKendaraanLabel">Tambah Kendaraan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="mb-3">
                        <label for="pemilik" class="form-label">Pemilik</label>
                        <select class="form-select" id="pemilik" wire:model="pemilik">
                            <option value="">-- Cari Pemilik --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('pemilik')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe</label>
                        <select class="form-select" id="tipe" wire:model="tipe">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="Mobil">Mobil</option>
                            <option value="Motor">Motor</option>
                        </select>
                        @error('tipe')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="merk" class="form-label">Merk</label>
                        <input type="text" class="form-control" id="merk" wire:model="merk">
                        @error('merk')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="plat" class="form-label">Plat</label>
                        <input type="text" class="form-control" id="plat" wire:model="plat">
                        @error('plat')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" wire:click="store">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
