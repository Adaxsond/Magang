@extends('admin.layouts.app')

@section('title', 'Data Dosen')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .dosen-index-wrapper {
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

    /* === FILTER FORM === */
    .filter-wrapper {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 12px;
        align-items: center;
        margin-bottom: 2rem;
    }

    .search-input-group {
        position: relative;
    }

    .search-input-group i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
    }

    .search-input {
        width: 100%;
        padding: 0.65rem 1rem 0.65rem 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        background: #fafbff;
    }

    .search-input::placeholder {
        color: #94a3b8;
    }

    .select-input-group {
        position: relative;
        min-width: 240px;
    }

    .select-input-group i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        pointer-events: none;
        z-index: 1;
    }

    .filter-select {
        width: 100%;
        padding: 0.65rem 2.5rem 0.65rem 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        appearance: none;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2364748b' d='M6 9L1 4h10z'/%3E%3C/svg%3E") no-repeat right 1rem center;
        background-color: white;
    }

    .filter-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        background-color: #fafbff;
    }

    /* === BUTTONS === */
    .btn {
        padding: 0.65rem 1.4rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        box-shadow: 0 2px 8px rgba(37,99,235,0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37,99,235,0.3);
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
        text-align: left;
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
    }

    .table thead th:first-child {
        text-align: center;
        width: 60px;
    }

    .table thead th:last-child {
        text-align: center;
        width: 200px;
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

    .table tbody td:first-child {
        text-align: center;
        font-weight: 600;
        color: #64748b;
    }

    .table tbody td:last-child {
        text-align: center;
    }

    /* === ACTION BUTTONS === */
    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: nowrap;
    }

    .btn-action {
        padding: 0.5rem 0.85rem;
        border-radius: 0.4rem;
        font-weight: 600;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        white-space: nowrap;
    }

    .btn-detail {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .btn-detail:hover {
        background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-edit {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #fff;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
        color: #991b1b;
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
    }

    /* === PAGINATION === */
    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .dosen-index-wrapper {
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

        .filter-wrapper {
            grid-template-columns: 1fr;
            width: 100%;
        }

        .select-input-group {
            min-width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
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
            flex-direction: column;
            width: 100%;
        }

        .btn-action {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="dosen-index-wrapper">
    
    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-chalkboard-teacher"></i>
            Data Dosen
        </h1>
        <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Dosen
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Form --}}
    <form action="{{ route('admin.dosen.index') }}" method="GET">
        <div class="filter-wrapper">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-input"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari berdasarkan nama atau NIDN...">
            </div>

            <div class="select-input-group">
                <i class="fas fa-graduation-cap"></i>
                <select name="prodi" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Program Studi</option>
                    @foreach($prodiOptions as $option)
                        <option value="{{ $option->prodi }}"
                            {{ ($prodiFilter ?? '') == $option->prodi ? 'selected' : '' }}>
                            {{ $option->prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Cari
            </button>
        </div>
    </form>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dosen</th>
                    <th>NIDN</th>
                    <th>Program Studi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosens as $dosen)
                    <tr>
                        <td>{{ $loop->iteration + ($dosens->currentPage() - 1) * $dosens->perPage() }}</td>
                        <td>{{ $dosen->nama_dosen }}</td>
                        <td>{{ $dosen->nidn }}</td>
                        <td>{{ $dosen->prodi }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.dosen.show', $dosen->id) }}" class="btn-action btn-detail">
                                    <i class="fas fa-eye"></i>
                                    Detail
                                </a>
                                <a href="{{ route('admin.dosen.edit', $dosen->id) }}" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');"
                                      style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete">
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
                                <i class="fas fa-inbox"></i>
                                <p>
                                    @if(request('search') || request('prodi'))
                                        Data dosen tidak ditemukan.
                                    @else
                                        Belum ada data dosen yang ditambahkan.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($dosens->hasPages())
        <div class="pagination-wrapper">
            {{ $dosens->links() }}
        </div>
    @endif
</div>
@endsection