<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\ProgramStudi;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Dosen::query();

        if ($search) {
            $query->where('nama_dosen', 'like', '%' . $search . '%')
                  ->orWhere('nidn', 'like', '%' . $search . '%');
        }

        $dosens = $query->latest()->paginate(10)->appends(['search' => $search]);
        return view('admin.dosen.index', compact('dosens'));
    }

    public function create()
    {
        // Mengambil semua data program studi dari database
        $programStudis = ProgramStudi::orderBy('nama')->get();

        // Mengirim data tersebut ke view
        return view('admin.dosen.create', compact('programStudis'));
    }

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

    public function show(Dosen $dosen)
    {
        $dosen->load('jurnals', 'pkms.luarans');
        return view('admin.dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen)
    {
        return view('admin.dosen.edit', compact('dosen'));
    }

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

    public function destroy(Dosen $dosen)
    {
        $dosen->delete(); // Ini otomatis soft delete
        return redirect()->route('admin.dosen.index')->with('success', 'Data Dosen berhasil dihapus.');
    }

   // ... (method index, create, store, edit, update, destroy)

   
}
