<?php

namespace Database\Seeders;

use App\Models\Prodi;
use Illuminate\Database\Seeder;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodis = [
            [
                'kode_prodi' => 'TI',
                'nama_prodi' => 'Teknik Informatika',
                'fakultas'   => 'Teknologi Informasi',
            ],
            [
                'kode_prodi' => 'SI',
                'nama_prodi' => 'Sistem Informasi',
                'fakultas'   => 'Teknologi Informasi',
            ],
            [
                'kode_prodi' => 'TE',
                'nama_prodi' => 'Teknik Elektro',
                'fakultas'   => 'Teknik',
            ],
            [
                'kode_prodi' => 'TS',
                'nama_prodi' => 'Teknik Sipil',
                'fakultas'   => 'Teknik',
            ],
        ];

        foreach ($prodis as $prodi) {
            Prodi::create($prodi);
        }
    }
}