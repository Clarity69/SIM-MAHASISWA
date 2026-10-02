@extends('layouts.app')

@section('title', 'Data Mahasiswa')
@section('page-title', 'Data Mahasiswa')

@section('content')
{{-- HEADER HALAMAN --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Data Mahasiswa</h2>
        <p class="text-muted mb-0">Kelola data mahasiswa terdaftar.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('mahasiswa.pdf', request()->query()) }}" class="btn btn-danger shadow-sm" target="_blank">
            <i class="bi bi-file-earmark-pdf me-1"></i> Print PDF
        </a>
        <a href="{{ route('mahasiswa.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Mahasiswa
        </a>
    </div>
</div>

{{-- FILTER & PENCARIAN --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('mahasiswa.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-lg-6 col-md-6">
                    <label class="form-label fw-semibold">Pencarian</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Cari NIM atau nama mahasiswa..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <label class="form-label fw-semibold">Program Studi</label>
                    <select name="prodi_id" class="form-select">
                        <option value="">Semua Program Studi</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi->id }}" {{ (string) request('prodi_id') === (string) $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 d-flex align-items-end">
                    <div class="d-flex gap-2 w-100">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="bi bi-search me-1"></i> Cari
                        </button>
                        @if(request('search') || request('prodi_id'))
                            <a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        @endif
                    </div>
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
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Program Studi</th>
                        <th>Jenis Kelamin</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $mahasiswa)
                        <tr>
                            <td class="px-4 text-muted">{{ $mahasiswas->firstItem() + $loop->index }}</td>
                            <td class="fw-semibold">{{ $mahasiswa->nim }}</td>
                            <td class="fw-bold">{{ $mahasiswa->nama }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $mahasiswa->prodi->nama_prodi ?? '-' }}
                                </span>
                            </td>
                            <td>
                                @if($mahasiswa->jenis_kelamin === 'Laki-laki')
                                    <span class="badge bg-info bg-opacity-10 text-info rounded-pill">
                                        <i class="bi bi-person-fill me-1"></i>Laki-laki
                                    </span>
                                @else
                                    <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">
                                        <i class="bi bi-person-heart me-1"></i>Perempuan
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('mahasiswa.show', $mahasiswa) }}" class="btn btn-sm btn-outline-info" title="Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('mahasiswa.edit', $mahasiswa) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('mahasiswa.destroy', $mahasiswa) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?')">
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
                                    <i class="bi bi-people fs-1 text-muted d-block mb-2"></i>
                                    <h5 class="fw-bold">Data Mahasiswa Tidak Ditemukan</h5>
                                    <p class="text-muted small">
                                        @if(request('search') || request('prodi_id'))
                                            Tidak ada data yang sesuai dengan kriteria pencarian.
                                        @else
                                            Belum ada data mahasiswa terdaftar.
                                        @endif
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- NAVIGASI PAGINATION MANUAL BOOTSTRAP --}}
        @if($mahasiswas->hasPages())
            <div class="d-flex justify-content-between align-items-center p-3 border-top">
                <div class="text-muted small">
                    Menampilkan <strong>{{ $mahasiswas->firstItem() }}</strong> - <strong>{{ $mahasiswas->lastItem() }}</strong> dari <strong>{{ $mahasiswas->total() }}</strong> data
                </div>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        {{-- PREVIOUS LINK --}}
                        @if($mahasiswas->onFirstPage())
                            <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $mahasiswas->previousPageUrl() }}">&laquo;</a></li>
                        @endif

                        {{-- NUMERIC PAGE LINKS --}}
                        @foreach($mahasiswas->getUrlRange(max(1, $mahasiswas->currentPage() - 2), min($mahasiswas->lastPage(), $mahasiswas->currentPage() + 2)) as $page => $url)
                            @if($page == $mahasiswas->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach

                        {{-- NEXT LINK --}}
                        @if($mahasiswas->hasMorePages())
                            <li class="page-item"><a class="page-link" href="{{ $mahasiswas->nextPageUrl() }}">&raquo;</a></li>
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