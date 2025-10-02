<?php
// app/Models/Jurnal.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurnal extends Model
{
    use HasFactory;
    protected $fillable = ['dosen_id', 'nama_jurnal', 'tahun_rilis', 'link_jurnal'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }
}