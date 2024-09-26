<div wire:ignore.self class="modal fade" id="edit" tabindex="-1" aria-labelledby="modalEditHargaSewaLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditHargaSewaLabel">Edit Harga Sewa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="update">
                    @csrf
                    <div class="mb-3">
                        <label for="kendaraan" class="form-label">Kendaraan</label>
                        <select class="form-select" id="kendaraan" wire:model="kendaraan_id">
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach ($kendaraans as $kendaraan)
                                <option value="{{ $kendaraan->id }}">{{ $kendaraan->merk }} - {{ $kendaraan->plat }}
                                </option>
                            @endforeach
                        </select>
                        @error('kendaraan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="harga_sewa" class="form-label">Harga Sewa</label>
                        <input type="number" class="form-control" id="harga_sewa" wire:model="harga_sewa">
                        @error('harga_sewa')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" wire:click="update">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
