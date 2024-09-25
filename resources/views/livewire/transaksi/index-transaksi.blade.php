<div>
    <div class="row">
        <div class="col-md-4">
            <form wire:submit.prevent="store">
                <div class="mb-3">
                    <label for="kendaraan_id" class="form-label">Kendaraan</label>
                    <select class="form-select" id="kendaraan_id" wire:model="kendaraan_id">
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach ($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}">{{ $kendaraan->merk }} - {{ $kendaraan->plat }}
                            </option>
                        @endforeach
                    </select>
                    @error('kendaraan_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" id="tanggal" wire:model="tanggal">
                    @error('tanggal')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="lama_sewa" class="form-label">Lama Sewa</label>
                    <input type="number" class="form-control" id="lama_sewa" wire:model="lama_sewa">
                    @error('lama_sewa')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kendaraan</th>
                        <th>Tanggal</th>
                        <th>Lama Sewa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaksi->kendaraan->merk }} - {{ $transaksi->kendaraan->plat }}</td>
                            <td>{{ $transaksi->tanggal }}</td>
                            <td>{{ $transaksi->lama_sewa }} Hari</td>
                            <td>
                                <span
                                    class="badge rounded-pill bg-{{ $transaksi->status == 'Proses' ? 'warning' : 'success' }} text-light">
                                    {{ ucfirst($transaksi->status) }}
                                </span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary"
                                    wire:click="edit({{ $transaksi->id }})">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger"
                                    wire:click="delete({{ $transaksi->id }})">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
