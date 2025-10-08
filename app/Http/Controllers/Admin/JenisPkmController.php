<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPkm;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisPkmController extends Controller
{
    public function index()
    {
        $jenisPkms = JenisPkm::orderBy('nama')->get();
        return view('admin.jenis-pkm.index', compact('jenisPkms'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:jenis_pkms']);
        JenisPkm::create($request->only('nama'));
        return back()->with('success', 'Jenis PKM baru berhasil ditambahkan.');
    }

    public function edit(JenisPkm $jenisPkm)
    {
        return view('admin.jenis-pkm.edit', compact('jenisPkm'));
    }

    public function update(Request $request, JenisPkm $jenisPkm)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255', Rule::unique('jenis_pkms')->ignore($jenisPkm->id)],
        ]);
        $jenisPkm->update($validated);
        return redirect()->route('admin.jenis-pkm.index')->with('success', 'Jenis PKM berhasil diperbarui.');
    }

    public function destroy(JenisPkm $jenisPkm)
    {
        $jenisPkm->delete();
        return back()->with('success', 'Jenis PKM berhasil dihapus.');
    }
}