<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    /**
     * Menampilkan daftar dosen dengan fitur pencarian dan filter prodi.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $prodiFilter = $request->input('prodi');
        $query = Dosen::query();

        if ($search) {
            $query->where('nama_dosen', 'like', '%' . $search . '%')
                  ->orWhere('nidn', 'like', '%' . $search . '%');
        }

        if ($prodiFilter) {
            $query->where('prodi', $prodiFilter);
        }

        $prodiOptions = Dosen::select('prodi')->distinct()->orderBy('prodi')->get();

        $dosens = $query->oldest()->simplePaginate(10)->appends($request->query());

        return view('admin.dosen.index', compact('dosens', 'search', 'prodiOptions', 'prodiFilter'));
    }

    /**
     * Menampilkan form untuk menambahkan data dosen.
     */
    public function create()
    {
        $programStudis = ProgramStudi::orderBy('nama')->get();
        return view('admin.dosen.create', compact('programStudis'));
    }

    /**
     * Menyimpan data dosen baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => 'required|string|max:20|unique:dosens,nidn',
            'prodi' => 'required|string|max:100',
            'email' => 'required|email|max:255',
        ]);

        Dosen::create($validated);

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail lengkap dari satu dosen.
     */
    public function show(Dosen $dosen)
    {
        $dosen->load('jurnals', 'pkms.luarans');
        return view('admin.dosen.show', compact('dosen'));
    }

    /**
     * Menampilkan form untuk mengedit data dosen.
     */
    public function edit(Dosen $dosen)
    {
        $programStudis = ProgramStudi::orderBy('nama')->get();
        return view('admin.dosen.edit', compact('dosen', 'programStudis'));
    }

    /**
     * Memperbarui data dosen yang sudah ada.
     */
    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nama_dosen' => 'required|string|max:255',
            'nidn' => ['required', 'string', 'max:20', Rule::unique('dosens')->ignore($dosen->id)],
            'prodi' => 'required|string|max:100',
            'email' => 'required|email|max:255',
        ]);

        $dosen->update($validated);

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil diperbarui.');
    }

    /**
     * Menghapus data dosen (soft delete).
     */
    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil dihapus.');
    }
}
