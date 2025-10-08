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
    /**
     * Menampilkan halaman laporan utama dengan filter, pencarian, dan pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $filterProdi = $request->input('prodi');
        $filterTahun = $request->input('tahun', 'all'); // default all

        // === Dropdown data ===
        $prodiOptions = Dosen::select('prodi')
            ->whereNotNull('prodi')
            ->where('prodi', '!=', '')
            ->distinct()
            ->orderBy('prodi')
            ->get();

        $jurnalYears = Jurnal::select(DB::raw('DISTINCT tahun_rilis as year'))->pluck('year');
        $pkmYears = Pkm::select(DB::raw('DISTINCT YEAR(created_at) as year'))->pluck('year');
        $yearOptions = $jurnalYears->concat($pkmYears)->unique()->sortDesc();

        // === Query dasar ===
        $query = Dosen::query();

        // === Filter tahun untuk relasi jurnal dan pkm ===
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

        // === Hitung jumlah jurnal dan pkm ===
        $query->withCount([
            'jurnals' => $jurnalDateFilter,
            'pkms' => $pkmDateFilter,
        ]);

        // === Filter pencarian & prodi ===
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', '%' . $search . '%')
                    ->orWhere('nidn', 'like', '%' . $search . '%');
            });
        }

        if ($filterProdi) {
            $query->where('prodi', $filterProdi);
        }

        // === Pagination & sorting ===
        $dosens = $query->orderBy('nama_dosen', 'asc')
            ->paginate(10)
            ->withQueryString(); // agar filter tetap aktif saat pindah halaman

        // === Helper teks filter tahun ===
        $filterTahunText = $this->getTahunFilterText($filterTahun);

        // === Cetak jika parameter 'cetak' ada ===
        if ($request->has('cetak')) {
            return view('admin.laporan.cetak', compact('dosens', 'search', 'filterProdi', 'filterTahunText'));
        }

        return view('admin.laporan.index', compact(
            'dosens',
            'prodiOptions',
            'yearOptions',
            'search',
            'filterProdi',
            'filterTahun'
        ));
    }

    /**
     * Menampilkan detail laporan per dosen.
     */
    public function detail(Dosen $dosen)
    {
        // Memuat relasi jurnal, pkm, dan luarannya
        $dosen->load('jurnals', 'pkms.luarans');
        
        // ✅ SOLUSI SINKRONISASI DATA:
        // Tambahkan baris ini untuk membuat properti 'jurnals_count' dan 'pkms_count'
        // agar datanya sama (sinkron) dengan di halaman daftar.
        $dosen->loadCount(['jurnals', 'pkms']);

        // Mengubah satu dosen menjadi collection agar sesuai dengan loop @forelse di view.
        $dosens = collect([$dosen]);

        return view('admin.laporan.detail', compact('dosens'));
    }

    /**
     * Cetak laporan keseluruhan.
     */
    public function cetak(Request $request)
    {
        $search = $request->input('search');
        $filterProdi = $request->input('prodi');
        $filterTahun = $request->input('tahun', 'all');

        $query = Dosen::withCount(['jurnals', 'pkms']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', '%' . $search . '%')
                    ->orWhere('nidn', 'like', '%' . $search . '%');
            });
        }

        if ($filterProdi) {
            $query->where('prodi', $filterProdi);
        }

        $dosens = $query->orderBy('nama_dosen', 'asc')->get();

        $filterTahunText = $this->getTahunFilterText($filterTahun);
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');

        return view('admin.laporan.cetak', compact('dosens', 'search', 'filterProdi', 'filterTahunText', 'tanggalCetak'));
    }

    /**
     * Cetak detail satu dosen.
     */
    public function cetakDetail(Dosen $dosen)
    {
        $dosen->load(['jurnals', 'pkms']);
        $dosen->loadCount(['jurnals', 'pkms']); // <-- Tambahkan juga di sini agar data cetak detail sinkron
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');
        return view('admin.laporan.cetak-detail', compact('dosen', 'tanggalCetak'));
    }

    /**
     * Menampilkan daftar dosen inaktif (tanpa jurnal & PKM).
     */
    public function inaktif(Request $request)
    {
        $search = $request->input('search');

        $query = Dosen::whereDoesntHave('jurnals')->whereDoesntHave('pkms');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', '%' . $search . '%')
                    ->orWhere('nidn', 'like', '%' . $search . '%');
            });
        }

        $dosenInaktif = $query->orderBy('nama_dosen')
            ->paginate(10)
            ->withQueryString();

        return view('admin.laporan.inaktif', compact('dosenInaktif', 'search'));
    }
    
    /**
     * Cetak daftar dosen inaktif.
     */
    public function cetakInaktif(Request $request)
    {
        $search = $request->input('search');

        $query = Dosen::whereDoesntHave('jurnals')->whereDoesntHave('pkms');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dosen', 'like', '%' . $search . '%')
                    ->orWhere('nidn', 'like', '%' . $search . '%');
            });
        }

        $dosenInaktif = $query->orderBy('nama_dosen')->get();
        $tanggalCetak = Carbon::now()->translatedFormat('d F Y');

        return view('admin.laporan.cetak-inaktif', compact('dosenInaktif', 'tanggalCetak'));
    }
    
    /**
     * Helper: ubah nilai filter tahun jadi teks untuk ditampilkan di view.
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
