<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua admin.
     */
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * Menampilkan form untuk membuat admin baru.
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    /**
     * Menyimpan admin baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'role' => 'required|in:superadmin,admin',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit admin.
     */
    public function edit(Admin $admin)
    {
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * Memperbarui data admin di database.
     */
    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'role' => 'required|in:superadmin,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->role = $validated['role'];

        if ($request->filled('password')) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('admin.admins.index')->with('success', 'Data admin berhasil diperbarui.');
    }

    /**
     * Menghapus admin dari database (soft delete).
     */
    public function destroy(Admin $admin)
    {
        if (Auth::guard('admin')->id() == $admin->id) {
            return redirect()->route('admin.admins.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin->delete();

        return redirect()->route('admin.admins.index')->with('success', 'Admin berhasil dihapus (tersimpan di Trash).');
    }

    /*
    |--------------------------------------------------------------------------
    | FUNGSI BARU UNTUK SOFT DELETES
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan daftar admin yang sudah di-soft delete.
     */
    
}
