<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Tambahkan use statement ini

class Dosen extends Model
{
    use HasFactory, SoftDeletes; // 2. Tambahkan SoftDeletes di sini

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_dosen',
        'nidn',
        'prodi',
        'email'
    ];

    /**
     * Get the jurnals for the dosen.
     */
    public function jurnals()
    {
        return $this->hasMany(Jurnal::class);
    }

    /**
     * Get the pkms for the dosen.
     */
    public function pkms()
    {
        return $this->hasMany(Pkm::class);
    }
}