<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes; // <-- Tambahkan ini
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes; // <-- Tambahkan SoftDeletes
    // ...
// <-- HAPUS , SoftDeletes DARI SINI

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];
    // ...



    protected $hidden = [
        'password',
        'remember_token',
    ];
}