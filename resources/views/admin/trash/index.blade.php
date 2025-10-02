@extends('admin.layouts.app')

@section('title', 'Tempat Sampah')

@section('content')
<style>
    .trash-card {
        border-radius: 1.2rem;
        border: none;
        box-shadow: 0 4px 24px 0 rgba(44,62,80,0.09);
        background: #fff;
        margin-bottom: 2rem;
    }
    .trash-header {
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
        border-radius: 1.2rem 1.2rem 0 0;
        padding: 1.2rem 2rem 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .trash-header h5 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2563eb;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .filter-form .input-group-text {
        background: #f3f6fa;
        border-radius: .7rem 0 0 .7rem;
        border: 1px solid #d1d5db;
        color: #2563eb;
    }
    .filter-form .form-select {
        border-radius: 0 .7rem .7rem 0;
        border: 1px solid #d1d5db;
        min-width: 160px;
    }
    .trash-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 0.7rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(44,62,80,0.04);
    }
    .trash-table th, .trash-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 1rem;
        vertical-align: middle;
    }
    .trash-table th {
        background: #f3f6fa;
        color: #2563eb;
        font-weight: 700;
        text-align: center;
    }
    .trash-table td {
        text-align: center;
    }
    .badge-soft {
        padding: .45em .9em;
        font-size: .85em;
        font-weight: 600;
        border-radius: 1em;
        background: linear-gradient(90deg, #e0e7ff 60%, #c7d2fe 100%);
        color: #3730a3;
        border: none;
    }
    .badge-soft-danger {
        background: linear-gradient(90deg, #fee2e2 60%, #fecaca 100%);
        color: #b91c1c;
    }
    .btn-action {
        min-width: 90px;
        font-size: 0.95em;
        padding: 0.35rem 0.9rem;
        border-radius: .7rem;
        margin-bottom: 2px;
    }
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #b0b8c1;
    }
    .empty-state i {
        font-size: 2.7rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }
    @media (max-width: 768px) {
        .trash-header { flex-direction: column; align-items: flex-start; gap: 10px; padding: 1rem 1rem 0.7rem 1rem;}
        .trash-table th, .trash-table td { padding: 10px 7px; font-size: 0.97rem; }
    }
    .aksi-btn-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        align-items: center;
    }
    .aksi-btn {
        display: block;
        min-width: 70px;
        font-size: 0.95em;
        font-weight: 600;
        border: none;
        border-radius: 7px;
        padding: 4px 16px;
        text-align: center;
        cursor: pointer;
        transition: background 0.18s, color 0.18s;
        box-shadow: 0 1px 4px rgba(44,62,80,0.07);
    }
    .aksi-btn-restore {
        background: #a7f3d0;
        color: #065f46;
    }
    .aksi-btn-restore:hover {
        background: #22c55e;
        color: #fff;
    }
    .aksi-btn-hapus {
        background: #fecaca;
        color: #b91c1c;
        margin-top: 2px;
    }
    .aksi-btn-hapus:hover {
        background: #ef4444;
        color: #fff;
    }
</style>

<div class="container-fluid px-4 py-4">
    <div class="trash-card">
        <div class="trash-header">
            <h5>
                <i class="fas fa-trash-alt"></i>
                Tempat Sampah
            </h5>
            <form action="{{ route('admin.trash.index') }}" method="GET" class="filter-form">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-filter"></i></span>
                    <select name="filter" class="form-select" onchange="this.form.submit()">
                        <option value="" {{ !$filter ? 'selected' : '' }}>Tampilkan Semua</option>
                        <option value="Dosen" {{ $filter == 'Dosen' ? 'selected' : '' }}>Hanya Dosen</option>
                        <option value="Admin" {{ $filter == 'Admin' ? 'selected' : '' }}>Hanya Admin</option>
                    </select>
                </div>
            </form>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="trash-table">
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:30%;">Nama Item</th>
                            <th style="width:15%;">Tipe Data</th>
                            <th style="width:20%;">Tanggal Dihapus</th>
                            <th style="width:30%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($trashedItems as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td style="text-align:left;">{{ $item->displayName }}</td>
                                <td>
                                    <span class="badge-soft{{ $item->type == 'Admin' ? ' badge-soft-danger' : '' }}">
                                        {{ $item->type }}
                                    </span>
                                </td>
                                <td>{{ $item->deleted_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <div class="aksi-btn-group">
                                        <form action="{{ route('admin.trash.restore', ['type' => $item->type, 'id' => $item->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="aksi-btn aksi-btn-restore" title="Pulihkan">
                                                Pulihkan
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.trash.forceDelete', ['type' => $item->type, 'id' => $item->id]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin hapus permanen? Data ini tidak akan bisa dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="aksi-btn aksi-btn-hapus" title="Hapus Permanen">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="fas fa-box-open"></i>
                                        <div class="fw-bold">Tempat sampah kosong.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection