<?php
// database/seeders/AdminSeeder.php
namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    // database/seeders/AdminSeeder.php
    public function run(): void
{
    Admin::create([
        'name' => 'Administrator',
        'email' => 'admin@mail.com',
        'password' => Hash::make('password'),
        'role' => 'superadmin', // <-- TAMBAHKAN INI
    ]);
}
}