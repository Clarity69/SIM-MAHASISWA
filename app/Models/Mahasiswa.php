<?php

namespace App\Models;

use App\Models\Prodi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nim',
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'telepon',
        'email',
        'prodi_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * Relasi ke model Prodi (Many to One).
     * Setiap Mahasiswa dimiliki oleh satu Prodi.
     */
    public function prodi(): BelongsTo
    {
        return $this->belongsTo(Prodi::class);
    }
}