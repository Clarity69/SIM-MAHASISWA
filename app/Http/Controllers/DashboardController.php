<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;

class DashboardController extends Controller
{
    /**
     * Menampilkan statistik ringkasan dan data terbaru di Dashboard.
     */
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        
        $totalLakiLaki = Mahasiswa::where('jenis_kelamin', 'Laki-laki')->count();
        
        $totalPerempuan = Mahasiswa::where('jenis_kelamin', 'Perempuan')->count();
        
        $totalProdi = Prodi::count();

        // 5 Mahasiswa yang baru ditambahkan
        $mahasiswaTerbaru = Mahasiswa::with('prodi')
            ->latest()
            ->take(5)
            ->get();

        // Rekapitulasi jumlah mahasiswa per Program Studi (untuk statistik & grafik)
        $mahasiswaPerProdi = Prodi::withCount('mahasiswas')
            ->orderByDesc('mahasiswas_count')
            ->get();

        return view('dashboard', compact(
            'totalMahasiswa',
            'totalLakiLaki',
            'totalPerempuan',
            'totalProdi',
            'mahasiswaTerbaru',
            'mahasiswaPerProdi'
        ));
    }
}