<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Jurnal;
use App\Models\Pkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua input filter
        $search = $request->input('search');
        $filterProdi = $request->input('prodi');
        $filterTahun = $request->input('tahun', 'all'); // Default ke 'all'

        // 2. Ambil data untuk dropdown filter
        $prodiOptions = Dosen::select('prodi')->whereNotNull('prodi')->where('prodi', '!=', '')->distinct()->orderBy('prodi')->get();

        // Ambil rentang tahun yang tersedia untuk filter dari data jurnal dan pkm
        $jurnalYears = Jurnal::select(DB::raw('DISTINCT tahun_rilis as year'))->pluck('year');
        $pkmYears = Pkm::select(DB::raw('DISTINCT YEAR(created_at) as year'))->pluck('year');
        $yearOptions = $jurnalYears->concat($pkmYears)->unique()->sortDesc();

        // 3. Bangun query dasar
        $query = Dosen::query();

        // 4. Siapkan closure untuk filter tanggal pada relasi Jurnal
        $jurnalDateFilter = function ($query) use ($filterTahun) {
            if ($filterTahun === 'all' || !$filterTahun) return;

            if ($filterTahun === '1_year') {
                $query->where('tahun_rilis', '>=', Carbon::now()->subYear()->year);
            } elseif ($filterTahun === '3_years') {
                $query->where('tahun_rilis', '>=', Carbon::now()->subYears(2)->year);
            } elseif ($filterTahun === '5_years') {
                $query->where('tahun_rilis', '>=', Carbon::now()->subYears(4)->year);
            } elseif (is_numeric($filterTahun)) {
                $query->where('tahun_rilis', $filterTahun);
            }
        };

        // Siapkan closure untuk filter tanggal pada relasi PKM
        $pkmDateFilter = function ($query) use ($filterTahun) {
            if ($filterTahun === 'all' || !$filterTahun) return;

            if ($filterTahun === '1_year') {
                $query->whereYear('created_at', '>=', Carbon::now()->subYear()->year);
            } elseif ($filterTahun === '3_years') {
                $query->whereYear('created_at', '>=', Carbon::now()->subYears(2)->year);
            } elseif ($filterTahun === '5_years') {
                $query->whereYear('created_at', '>=', Carbon::now()->subYears(4)->year);
            } elseif (is_numeric($filterTahun)) {
                $query->whereYear('created_at', $filterTahun);
            }
        };

        // Muat jumlah relasi (jurnal & pkm) dengan filter tanggal yang sudah disiapkan
        $query->withCount(['jurnals' => $jurnalDateFilter, 'pkms' => $pkmDateFilter]);

        // 5. Terapkan filter pada data Dosen (pencarian nama & prodi)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', '%' . $search . '%')
                  ->orWhere('nidn', 'like', '%' . $search . '%');
            });
        }
        if ($filterProdi) {
            $query->where('prodi', $filterProdi);
        }

        // 6. Ambil data
        $dosens = $query->orderBy('nama_dosen', 'asc')->get();
        
        // Helper untuk teks filter di view cetak
        $filterTahunText = $this->getTahunFilterText($filterTahun);

        // 7. Cek apakah ini adalah permintaan untuk mencetak
        if ($request->has('cetak')) {
            return view('admin.laporan.cetak', compact('dosens', 'search', 'filterProdi', 'filterTahunText'));
        }

        // 8. Jika tidak, tampilkan halaman laporan interaktif
        return view('admin.laporan.index', compact('dosens', 'prodiOptions', 'yearOptions', 'search', 'filterProdi', 'filterTahun'));
    }

    /**
     * Helper untuk mengubah nilai filter tahun menjadi teks yang mudah dibaca.
     */
    private function getTahunFilterText($filterTahun)
    {
        switch ($filterTahun) {
            case '1_year':
                return 'Setahun Terakhir';
            case '3_years':
                return '3 Tahun Terakhir';
            case '5_years':
                return '5 Tahun Terakhir';
            case 'all':
            case null:
                return 'Semua Waktu';
            default:
                if (is_numeric($filterTahun)) {
                    return 'Tahun ' . $filterTahun;
                }
                return 'Tidak Diketahui';
        }
    }
}
