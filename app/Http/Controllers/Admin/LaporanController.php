<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua input filter
        $search = $request->input('search');
        $filterProdi = $request->input('prodi');

        // 2. Ambil data untuk dropdown filter
        $prodiOptions = Dosen::select('prodi')->distinct()->orderBy('prodi')->get();

        // 3. Bangun query dasar
        $query = Dosen::withCount(['jurnals', 'pkms']);

        // 4. Terapkan filter jika ada
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', '%' . $search . '%')
                  ->orWhere('nidn', 'like', '%' . $search . '%');
            });
        }
        if ($filterProdi) {
            $query->where('prodi', $filterProdi);
        }

        // 5. Ambil data
        $dosens = $query->orderBy('nama_dosen', 'asc')->get();

        // 6. Cek apakah ini adalah permintaan untuk mencetak
        if ($request->has('cetak')) {
            // Jika ya, tampilkan view khusus untuk cetak
            return view('admin.laporan.cetak', compact('dosens', 'search', 'filterProdi'));
        }

        // 7. Jika tidak, tampilkan halaman laporan interaktif seperti biasa
        return view('admin.laporan.index', compact('dosens', 'prodiOptions', 'search', 'filterProdi'));
    }
}