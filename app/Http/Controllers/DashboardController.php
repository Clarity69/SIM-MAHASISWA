<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    /**
     * Menampilkan statistik ringkasan dan data terbaru di Dashboard.
     */
    public function index()
    {
        $totalMahasiswa = Mahasiswa::count();
        
        /* 
         | LOGIKA PANAH TREN (NAIK/TURUN) 
         | Membandingkan total saat ini dengan total kunjungan sebelumnya di Cache
         */
        $lastTotal = Cache::get('last_total_mahasiswa', $totalMahasiswa);
        
        $trend = 'neutral';
        if ($totalMahasiswa > $lastTotal) {
            $trend = 'up';
        } elseif ($totalMahasiswa < $lastTotal) {
            $trend = 'down';
        }
        
        // Perbarui cache dengan total terbaru
        Cache::put('last_total_mahasiswa', $totalMahasiswa);

        $totalLakiLaki = Mahasiswa::where('jenis_kelamin', 'Laki-laki')->count();
        $totalPerempuan = Mahasiswa::where('jenis_kelamin', 'Perempuan')->count();
        $totalProdi = Prodi::count();

        // 5 Mahasiswa yang baru ditambahkan
        $mahasiswaTerbaru = Mahasiswa::with('prodi')
            ->latest()
            ->take(5)
            ->get();

        // Rekapitulasi jumlah mahasiswa per Program Studi
        $mahasiswaPerProdi = Prodi::withCount('mahasiswas')
            ->orderByDesc('mahasiswas_count')
            ->get();

        return view('dashboard', compact(
            'totalMahasiswa',
            'trend',
            'totalLakiLaki',
            'totalPerempuan',
            'totalProdi',
            'mahasiswaTerbaru',
            'mahasiswaPerProdi'
        ));
    }
}