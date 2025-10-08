<?php
// app/Models/Pkm.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pkm extends Model
{
    use HasFactory;
    protected $fillable = ['dosen_id', 'jenis_pkm'];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function luarans()
    {
        return $this->hasMany(PkmLuaran::class);
    }
}