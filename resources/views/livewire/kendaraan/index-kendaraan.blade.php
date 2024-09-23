<div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="app-content-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3 class="mb-0">Kelola Kendaraan</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="app-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mb-3">
                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#tambah">
                                        <i class="bi bi-plus-circle"></i> Tambah
                                    </a>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Pemilik</th>
                                                    <th>Tipe</th>
                                                    <th>Merk</th>
                                                    <th>Plat</th>
                                                    <th>Status</th>
                                                    <th style="width: 200px">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($kendaraans->count() > 0)
                                                    @foreach ($kendaraans as $kendaraan)
                                                        <tr class="align-middle">
                                                            <td>{{ $loop->iteration }}.</td>
                                                            <td>{{ isset($kendaraan->user) ? $kendaraan->user->name : '' }}
                                                            </td>
                                                            <td>{{ $kendaraan->tipe }}</td>
                                                            <td>{{ $kendaraan->merk }}</td>
                                                            <td>{{ $kendaraan->plat }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge rounded-pill bg-{{ $kendaraan->status === 'tersedia' ? 'success' : 'warning' }} text-dark">
                                                                    {{ ucfirst($kendaraan->status) }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="btn btn-success btn-sm"
                                                                    wire:click="showEditModal({{ $kendaraan->id }})">
                                                                    <i class="bi bi-pencil-square"></i> Edit
                                                                </a>
                                                                <a href="#" class="btn btn-danger btn-sm"
                                                                    wire:click="showDeleteModal({{ $kendaraan->id }})">
                                                                    <i class="bi bi-trash3"></i> Hapus
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="7" class="text-center">
                                                            Tidak ada data ditemukan
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('livewire.kendaraan.modal-create')
    {{-- @include('livewire.kendaraan.modal-edit')
    @include('livewire.kendaraan.modal-delete') --}}
