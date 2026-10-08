@extends('layouts.app')

@section('title', 'Program Studi')
@section('page-title', 'Program Studi')

@section('content')
{{-- HEADER HALAMAN --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Program Studi</h2>
        <p class="text-muted mb-0">Kelola data program studi dan fakultas.</p>
    </div>
    <a href="{{ route('prodi.create') }}" class="btn btn-primary shadow-sm">
        <i class="bi bi-plus-circle me-1"></i> Tambah Prodi
    </a>
</div>

{{-- PENCARIAN --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('prodi.index') }}" method="GET">
            <div class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari kode, nama prodi, atau fakultas..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL DATA --}}
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4" style="width: 70px;">#</th>
                        <th style="width: 120px;">Kode</th>
                        <th>Nama Program Studi</th>
                        <th>Fakultas</th>
                        <th>Jumlah Mahasiswa</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prodis as $prodi)
                        <tr>
                            <td class="px-4 text-muted">{{ $prodis->firstItem() + $loop->index }}</td>
                            <td>
                                <span class="badge bg-primary px-3 py-2 fw-bold">{{ $prodi->kode_prodi }}</span>
                            </td>
                            <td class="fw-bold">{{ $prodi->nama_prodi }}</td>
                            <td>{{ $prodi->fakultas ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info px-3 py-2 rounded-pill fw-bold">
                                    <i class="bi bi-people me-1"></i>{{ $prodi->mahasiswas_count }} Mahasiswa
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('prodi.show', $prodi) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('prodi.edit', $prodi) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('prodi.destroy', $prodi) }}" method="POST" class="d-inline form-hapus" data-nama="{{ $prodi->nama_prodi }}" data-jenis="program studi">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-center">
                                    <i class="bi bi-building fs-1 text-muted d-block mb-2"></i>
                                    <h5 class="fw-bold">Data Program Studi Tidak Ditemukan</h5>
                                    <p class="text-muted small">Belum ada data program studi terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION MANUAL --}}
        @if($prodis->hasPages())
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <div class="text-muted small">
                    Menampilkan <strong>{{ $prodis->firstItem() }}</strong> - <strong>{{ $prodis->lastItem() }}</strong> dari <strong>{{ $prodis->total() }}</strong> prodi
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        @if($prodis->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $prodis->previousPageUrl() }}">&laquo;</a></li>
                        @endif

                        @foreach($prodis->getUrlRange(max(1, $prodis->currentPage() - 2), min($prodis->lastPage(), $prodis->currentPage() + 2)) as $page => $url)
                            @if($page == $prodis->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        @if($prodis->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $prodis->nextPageUrl() }}">&raquo;</a></li>
                        @else
                            <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif
    </div>
</div>
@endsection