<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa beserta pencarian, filter prodi, dan pagination.
     */
    public function index(Request $request)
    {
        $query = Mahasiswa::with('prodi');

        // Fitur Pencarian NIM atau Nama
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        // Fitur Filter Program Studi
        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->input('prodi_id'));
        }

        $mahasiswas = $query->latest()
                            ->paginate(10)
                            ->withQueryString();

        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        return view('mahasiswa.index', compact('mahasiswas', 'prodis'));
    }

    /**
     * Form tambah data mahasiswa.
     */
    public function create()
    {
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        return view('mahasiswa.create', compact('prodis'));
    }

    /**
     * Menyimpan data mahasiswa baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nim' => [
                'required',
                'string',
                'max:30',
                'unique:mahasiswas,nim',
            ],
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'jenis_kelamin' => [
                'required',
                Rule::in(['Laki-laki', 'Perempuan']),
            ],
            'tanggal_lahir' => [
                'nullable',
                'date',
            ],
            'alamat' => [
                'nullable',
                'string',
            ],
            'telepon' => [
                'nullable',
                'string',
                'max:20',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
            'prodi_id' => [
                'required',
                'integer',
                'exists:prodis,id',
            ],
        ]);

        Mahasiswa::create($validated);

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail mahasiswa.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load('prodi');

        return view('mahasiswa.show', compact('mahasiswa'));
    }

    /**
     * Form edit data mahasiswa.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        $prodis = Prodi::orderBy('nama_prodi', 'asc')->get();

        return view('mahasiswa.edit', compact('mahasiswa', 'prodis'));
    }

    /**
     * Mengubah data mahasiswa.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nim' => [
                'required',
                'string',
                'max:30',
                Rule::unique('mahasiswas', 'nim')->ignore($mahasiswa->id),
            ],
            'nama' => [
                'required',
                'string',
                'max:255',
            ],
            'jenis_kelamin' => [
                'required',
                Rule::in(['Laki-laki', 'Perempuan']),
            ],
            'tanggal_lahir' => [
                'nullable',
                'date',
            ],
            'alamat' => [
                'nullable',
                'string',
            ],
            'telepon' => [
                'nullable',
                'string',
                'max:20',
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
            ],
            'prodi_id' => [
                'required',
                'integer',
                'exists:prodis,id',
            ],
        ]);

        $mahasiswa->update($validated);

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    /**
     * Menghapus data mahasiswa.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();

        return redirect()
            ->route('mahasiswa.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    /**
     * Export laporan PDF mengikuti filter yang aktif.
     */
    public function pdf(Request $request)
    {
        $query = Mahasiswa::with('prodi');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        if ($request->filled('prodi_id')) {
            $query->where('prodi_id', $request->input('prodi_id'));
        }

        $mahasiswas = $query->latest()->get();

        $namaProdi = 'Semua Program Studi';
        if ($request->filled('prodi_id')) {
            $prodi = Prodi::find($request->input('prodi_id'));
            if ($prodi) {
                $namaProdi = $prodi->nama_prodi;
            }
        }

        $pdf = Pdf::loadView('mahasiswa.pdf', [
            'mahasiswas' => $mahasiswas,
            'namaProdi'  => $namaProdi,
            'search'     => $request->input('search'),
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('data-mahasiswa.pdf');
    }
}