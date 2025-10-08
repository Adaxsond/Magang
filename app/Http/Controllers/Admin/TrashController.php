<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Dosen;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $admins = collect();
        $dosens = collect();

        if ($filter === 'Admin' || !$filter) {
            $admins = Admin::onlyTrashed()->get()->map(function ($item) {
                $item->type = 'Admin';
                $item->displayName = $item->name;
                return $item;
            });
        }

        if ($filter === 'Dosen' || !$filter) {
            $dosens = Dosen::onlyTrashed()->get()->map(function ($item) {
                $item->type = 'Dosen';
                $item->displayName = $item->nama_dosen;
                return $item;
            });
        }

        $trashedItems = $admins->concat($dosens)->sortByDesc('deleted_at');

        return view('admin.trash.index', compact('trashedItems', 'filter'));
    }

    /**
     * Mengembalikan data dari tempat sampah.
     * METHOD INI YANG SEBELUMNYA HILANG.
     */
    public function restore(Request $request, $type, $id)
    {
        $modelClass = $this->getModelClass($type);
        $modelClass::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.trash.index')->with('success', "Data $type berhasil dipulihkan.");
    }

    /**
     * Menghapus data secara permanen.
     * METHOD INI JUGA KEMUNGKINAN HILANG.
     */
    public function forceDelete(Request $request, $type, $id)
    {
        $modelClass = $this->getModelClass($type);
        $modelClass::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.trash.index')->with('success', "Data $type berhasil dihapus permanen.");
    }

    /**
     * Helper function untuk mendapatkan class model berdasarkan string type.
     */
    private function getModelClass($type)
    {
        $map = [
            'Admin' => Admin::class,
            'Dosen' => Dosen::class,
        ];

        if (!array_key_exists($type, $map)) {
            abort(404, 'Tipe data tidak valid.');
        }

        return $map[$type];
    }
}