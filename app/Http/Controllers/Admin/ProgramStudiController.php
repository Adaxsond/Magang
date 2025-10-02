<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramStudiController extends Controller
{
    public function index()
    {
        $programStudis = ProgramStudi::orderBy('nama')->get();
        return view('admin.program-studi.index', compact('programStudis'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:program_studis']);
        ProgramStudi::create($request->only('nama'));
        return back()->with('success', 'Program Studi baru berhasil ditambahkan.');
    }

    public function edit(ProgramStudi $programStudi)
    {
        return view('admin.program-studi.edit', compact('programStudi'));
    }

    public function update(Request $request, ProgramStudi $programStudi)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('program_studis')->ignore($programStudi->id)],
        ]);
        $programStudi->update($validated);
        return redirect()->route('admin.program-studi.index')->with('success', 'Program Studi berhasil diperbarui.');
    }

    public function destroy(ProgramStudi $programStudi)
    {
        $programStudi->delete();
        return back()->with('success', 'Program Studi berhasil dihapus.');
    }
}