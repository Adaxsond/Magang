<?php
// app/Models/PkmLuaran.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PkmLuaran extends Model
{
    use HasFactory;
    protected $fillable = ['pkm_id', 'tipe', 'path_foto', 'nama_jurnal', 'tahun_rilis', 'link_jurnal'];

    public function pkm()
    {
        return $this->belongsTo(Pkm::class);
    }
}