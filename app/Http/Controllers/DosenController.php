<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\JenisPkm;      // <-- Mengambil data dari model
use App\Models\ProgramStudi; // <-- Mengambil data dari model
use App\Models\Pkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class DosenController extends Controller
{
    /**
     * Menampilkan formulir utama dengan data dinamis.
     */
    public function create()
    {
        // Mengambil data dinamis dari database untuk ditampilkan di dropdown
        $programStudis = ProgramStudi::orderBy('nama')->get();
        $pkmTypes = JenisPkm::orderBy('nama')->get();

        // Mengirim data ke view
        return view('dosen.form', compact('programStudis', 'pkmTypes'));
    }

    /**
     * Memvalidasi dan menyimpan data Jurnal ke database.
     */
    public function storeJurnal(Request $request)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|max:20',
            'prodi' => 'required|string|exists:program_studis,nama', // Diubah: Validasi prodi dari tabel
            'email' => 'required|email',
            'jurnals' => 'required|array|min:1',
            'jurnals.*.nama_jurnal' => 'required|string|max:255',
            'jurnals.*.tahun_rilis' => 'required|integer|min:1900|max:' . date('Y'),
            'jurnals.*.link_jurnal' => 'required|url',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $dosen = Dosen::updateOrCreate(
                    ['nidn' => $validated['nidn']],
                    [
                        'nama_dosen' => $validated['nama_dosen'],
                        'prodi' => $validated['prodi'],
                        'email' => $validated['email'],
                    ]
                );
                foreach ($validated['jurnals'] as $jurnalData) {
                    $dosen->jurnals()->create($jurnalData);
                }
            });
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['db_error' => 'Gagal menyimpan data ke database: ' . $e->getMessage()])->withInput();
        }

        return redirect()->route('dosen.success');
    }

    /**
     * Memvalidasi dan menyimpan data PKM ke database.
     */
    public function storePkm(Request $request)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|max:20',
            'prodi' => 'required|string|exists:program_studis,nama', // Diubah: Validasi prodi dari tabel
            'email' => 'required|email',
            'jenis_pkm' => 'required|string|exists:jenis_pkms,nama', // Validasi jenis_pkm dari tabel
            'luaran' => 'required|array|min:1',
            'luaran.*.tipe' => 'required|in:foto,jurnal',
            'luaran.*.nama_jurnal' => 'required_if:luaran.*.tipe,jurnal|nullable|string|max:255',
            'luaran.*.tahun_rilis' => 'required_if:luaran.*.tipe,jurnal|nullable|integer|min:1900|max:' . date('Y'),
            'luaran.*.link_jurnal' => 'required_if:luaran.*.tipe,jurnal|nullable|url',
            'luaran.*.file' => ['required_if:luaran.*.tipe,foto', 'nullable', File::image()->max(2 * 1024)],
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                $dosen = Dosen::updateOrCreate(
                    ['nidn' => $validated['nidn']],
                    [
                        'nama_dosen' => $validated['nama_dosen'],
                        'prodi' => $validated['prodi'],
                        'email' => $validated['email'],
                    ]
                );
                $pkm = $dosen->pkms()->create(['jenis_pkm' => $validated['jenis_pkm']]);
                foreach ($validated['luaran'] as $key => $luaranData) {
                    if ($luaranData['tipe'] === 'foto') {
                        $path = $request->file("luaran.{$key}.file")->store('pkm_photos', 'public');
                        $pkm->luarans()->create(['tipe' => 'foto', 'path_foto' => $path]);
                    } else {
                        $pkm->luarans()->create([
                            'tipe' => 'jurnal',
                            'nama_jurnal' => $luaranData['nama_jurnal'],
                            'tahun_rilis' => $luaranData['tahun_rilis'],
                            'link_jurnal' => $luaranData['link_jurnal'],
                        ]);
                    }
                }
            });
        } catch (\Exception $e) {
            return Redirect::back()->withErrors(['db_error' => 'Gagal menyimpan data ke database: ' . $e->getMessage()])->withInput();
        }

        return redirect()->route('dosen.success');
    }
}
