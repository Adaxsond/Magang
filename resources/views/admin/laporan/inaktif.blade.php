@extends('admin.layouts.app')
@section('title', 'Laporan Dosen Inaktif')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .inaktif-index-wrapper {
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
        flex-wrap: wrap;
        gap: 1rem;
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
        text-decoration: none;
    }

    .btn-danger {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
        color: #991b1b;
        box-shadow: 0 2px 8px rgba(239,68,68,0.2);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239,68,68,0.3);
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
        color: #fff;
    }

    /* === SEARCH SECTION === */
    .search-section {
        margin-bottom: 2rem;
    }

    .search-wrapper {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .search-input-group {
        position: relative;
        flex: 1;
    }

    .search-input-group i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 1;
    }

    .search-input {
        width: 100%;
        padding: 0.65rem 1rem 0.65rem 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #fff;
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

    .btn-search {
        padding: 0.65rem 1.2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        box-shadow: 0 2px 8px rgba(37,99,235,0.2);
    }

    .btn-search:hover {
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
        text-align: center;
        font-weight: 600;
        color: #475569;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
    }

    .table thead th:nth-child(2) {
        text-align: left;
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
        text-align: center;
    }

    .table tbody td:nth-child(1) {
        font-weight: 600;
        color: #64748b;
    }

    .table tbody td:nth-child(2) {
        text-align: left;
        font-weight: 500;
    }

    /* === EMPTY STATE === */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #64748b;
    }

    .empty-state i {
        font-size: 3rem;
        color: #10b981;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #065f46;
    }

    /* === PAGINATION === */
    .pagination-wrapper {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .inaktif-index-wrapper {
            padding: 1.5rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }

        .search-wrapper {
            flex-direction: column;
        }

        .btn-search {
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
    }
</style>
@endpush

@section('content')
<div class="inaktif-index-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-slash"></i>
            Dosen Belum Input Data
        </h1>
        <a href="{{ route('admin.laporan.cetakInaktif', ['search' => $search]) }}" class="btn btn-danger" target="_blank">
            <i class="fas fa-print"></i>
            Cetak Laporan
        </a>
    </div>

    {{-- Search --}}
    <form action="{{ route('admin.laporan.inaktif') }}" method="GET" class="search-section">
        <div class="search-wrapper">
            <div class="search-input-group">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="search-input" placeholder="Cari Nama atau NIDN..." value="{{ $search ?? '' }}">
            </div>
            <button class="btn-search" type="submit">
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
                </tr>
            </thead>
            <tbody>
                @forelse ($dosenInaktif as $dosen)
                    <tr>
                        <td>{{ $loop->iteration + ($dosenInaktif->currentPage() - 1) * $dosenInaktif->perPage() }}</td>
                        <td>{{ $dosen->nama_dosen }}</td>
                        <td>{{ $dosen->nidn }}</td>
                        <td>{{ $dosen->prodi }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="empty-state">
                                <i class="fas fa-check-circle"></i>
                                <p>Semua dosen sudah aktif menginput data.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination --}}
    @if ($dosenInaktif->hasPages())
        <div class="pagination-wrapper">
            {{ $dosenInaktif->links() }}
        </div>
    @endif

</div>
@endsection