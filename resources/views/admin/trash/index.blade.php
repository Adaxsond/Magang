@extends('admin.layouts.app')
@section('title', 'Tempat Sampah')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .trash-index-wrapper {
        background: #ffffff;
        border-radius: 1.2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 2.5rem;
        margin: 0;
        max-width: 100%;
    }

    /* === HEADER === */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .page-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.75rem;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .page-title i {
        color: #2563eb;
        margin-right: 0.5rem;
    }

    /* === FILTER FORM === */
    .filter-form {
        display: flex;
        align-items: center;
        gap: 0;
    }

    .filter-icon {
        background: #f3f6fa;
        padding: 0.65rem 1rem;
        border: 1px solid #d1d5db;
        border-right: none;
        border-radius: 0.5rem 0 0 0.5rem;
        color: #2563eb;
        display: flex;
        align-items: center;
    }

    .filter-select {
        border: 1px solid #d1d5db;
        border-radius: 0 0.5rem 0.5rem 0;
        padding: 0.65rem 1rem;
        font-size: 0.95rem;
        min-width: 180px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
    }

    .filter-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
    }

    /* === ALERT === */
    .alert {
        padding: 1rem 1.25rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        border: none;
    }

    .alert-success {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        border-left: 4px solid #10b981;
    }

    /* === TABLE === */
    .table-wrapper {
        overflow-x: auto;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .table thead {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    }

    .table thead th {
        padding: 1rem;
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
    }

    .table thead th:nth-child(1) {
        text-align: center;
        width: 5%;
    }

    .table thead th:nth-child(2) {
        text-align: left;
        width: 30%;
    }

    .table thead th:nth-child(3) {
        text-align: center;
        width: 15%;
    }

    .table thead th:nth-child(4) {
        text-align: center;
        width: 20%;
    }

    .table thead th:nth-child(5) {
        text-align: center;
        width: 30%;
    }

    .table tbody tr {
        border-bottom: 1px solid #e5e7eb;
        transition: background 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f8fafc;
    }

    .table tbody tr:last-child {
        border-bottom: none;
    }

    .table tbody td {
        padding: 1rem;
        color: #334155;
        font-size: 0.95rem;
    }

    .table tbody td:nth-child(1) {
        text-align: center;
        font-weight: 600;
        color: #64748b;
    }

    .table tbody td:nth-child(2) {
        text-align: left;
    }

    .table tbody td:nth-child(3) {
        text-align: center;
    }

    .table tbody td:nth-child(4) {
        text-align: center;
    }

    .table tbody td:nth-child(5) {
        text-align: center;
    }

    /* === BADGE TYPE === */
    .badge-type {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 1rem;
        display: inline-block;
    }

    .badge-admin {
        background: linear-gradient(90deg, #fee2e2 60%, #fecaca 100%);
        color: #b91c1c;
    }

    .badge-dosen {
        background: linear-gradient(90deg, #e0e7ff 60%, #c7d2fe 100%);
        color: #3730a3;
    }

    /* === ACTION BUTTONS === */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-action {
        width: 110px;
        padding: 0.5rem 1rem;
        border-radius: 0.4rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
    }

    .btn-restore {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }

    .btn-restore:hover {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
        color: #991b1b;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        transform: translateY(-1px);
    }

    /* === EMPTY STATE === */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .trash-index-wrapper {
            padding: 1.5rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .filter-form {
            width: 100%;
        }

        .filter-select {
            width: 100%;
        }

        .table-wrapper {
            border: none;
        }

        .table {
            font-size: 0.875rem;
        }

        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
        }

        .action-buttons {
            width: 100%;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="trash-index-wrapper">
    
    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-trash-alt"></i>
            Tempat Sampah
        </h1>
        
        <form action="{{ route('admin.trash.index') }}" method="GET" class="filter-form">
            <span class="filter-icon">
                <i class="fas fa-filter"></i>
            </span>
            <select name="filter" class="filter-select" onchange="this.form.submit()">
                <option value="" {{ !$filter ? 'selected' : '' }}>Tampilkan Semua</option>
                <option value="Dosen" {{ $filter == 'Dosen' ? 'selected' : '' }}>Hanya Dosen</option>
                <option value="Admin" {{ $filter == 'Admin' ? 'selected' : '' }}>Hanya Admin</option>
            </select>
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Item</th>
                    <th>Tipe Data</th>
                    <th>Tanggal Dihapus</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($trashedItems as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->displayName }}</td>
                        <td>
                            <span class="badge-type {{ $item->type == 'Admin' ? 'badge-admin' : 'badge-dosen' }}">
                                {{ $item->type }}
                            </span>
                        </td>
                        <td>{{ $item->deleted_at->format('d M Y, H:i') }}</td>
                        <td>
                            <div class="action-buttons">
                                <form action="{{ route('admin.trash.restore', ['type' => $item->type, 'id' => $item->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-action btn-restore" title="Pulihkan">
                                        <i class="fas fa-undo"></i>
                                        Pulihkan
                                    </button>
                                </form>
                                <form action="{{ route('admin.trash.forceDelete', ['type' => $item->type, 'id' => $item->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin hapus permanen? Data ini tidak akan bisa dikembalikan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus Permanen">
                                        <i class="fas fa-trash"></i>
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
                                <p>Tempat sampah kosong.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection