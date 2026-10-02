<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProdiController extends Controller
{
    /**
     * Menampilkan daftar program studi beserta jumlah mahasiswa dan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = Prodi::withCount('mahasiswas');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('kode_prodi', 'like', "%{$search}%")
                  ->orWhere('nama_prodi', 'like', "%{$search}%")
                  ->orWhere('fakultas', 'like', "%{$search}%");
            });
        }

        $prodis = $query->orderBy('nama_prodi', 'asc')
                        ->paginate(10)
                        ->withQueryString();

        return view('prodi.index', compact('prodis'));
    }

    /**
     * Form tambah program studi.
     */
    public function create()
    {
        return view('prodi.create');
    }

    /**
     * Menyimpan data program studi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_prodi' => [
                'required',
                'string',
                'max:20',
                'unique:prodis,kode_prodi',
            ],
            'nama_prodi' => [
                'required',
                'string',
                'max:255',
            ],
            'fakultas' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        Prodi::create($validated);

        return redirect()
            ->route('prodi.index')
            ->with('success', 'Program studi berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail program studi beserta daftar mahasiswanya.
     */
    public function show(Prodi $prodi)
    {
        $prodi->load('mahasiswas');

        return view('prodi.show', compact('prodi'));
    }

    /**
     * Form edit program studi.
     */
    public function edit(Prodi $prodi)
    {
        return view('prodi.edit', compact('prodi'));
    }

    /**
     * Mengubah data program studi di database.
     */
    public function update(Request $request, Prodi $prodi)
    {
        $validated = $request->validate([
            'kode_prodi' => [
                'required',
                'string',
                'max:20',
                Rule::unique('prodis', 'kode_prodi')->ignore($prodi->id),
            ],
            'nama_prodi' => [
                'required',
                'string',
                'max:255',
            ],
            'fakultas' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $prodi->update($validated);

        return redirect()
            ->route('prodi.index')
            ->with('success', 'Program studi berhasil diperbarui.');
    }

    /**
     * Menghapus program studi (dengan validasi relasi mahasiswa).
     */
    public function destroy(Prodi $prodi)
    {
        if ($prodi->mahasiswas()->exists()) {
            return back()->with(
                'error',
                'Prodi tidak dapat dihapus karena masih digunakan mahasiswa.'
            );
        }

        $prodi->delete();

        return redirect()
            ->route('prodi.index')
            ->with('success', 'Program studi berhasil dihapus.');
    }
}