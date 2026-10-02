<?php

namespace App\Models;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Prodi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_prodi',
        'nama_prodi',
        'fakultas',
    ];

    /**
     * Relasi ke model Mahasiswa (One-to-Many).
     * Satu Program Studi memiliki banyak Mahasiswa.
     */
    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class);
    }
}