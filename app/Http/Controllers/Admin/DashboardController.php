<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurnal;
use App\Models\Pkm;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'dosen' => Dosen::count(),
            'jurnal' => Jurnal::count(),
            'pkm' => Pkm::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}