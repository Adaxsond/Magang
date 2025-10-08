@extends('admin.layouts.app')
@section('title', 'Laporan Kinerja Dosen')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .laporan-index-wrapper {
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

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
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

    .btn-warning {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
        box-shadow: 0 2px 8px rgba(245,158,11,0.2);
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245,158,11,0.3);
    }

    .btn-outline-primary {
        background: #fff;
        color: #2563eb;
        border: 2px solid #2563eb;
        box-shadow: 0 2px 8px rgba(37,99,235,0.1);
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37,99,235,0.3);
    }

    /* === FILTER SECTION === */
    .filter-section {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 0.75rem;
        border: 1px solid #e5e7eb;
    }

    .filter-wrapper {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        position: relative;
    }

    .filter-group i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
        z-index: 1;
    }

    .filter-input,
    .filter-select {
        width: 100%;
        padding: 0.65rem 1rem 0.65rem 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .filter-input:focus,
    .filter-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        background: #fafbff;
    }

    .filter-input::placeholder {
        color: #94a3b8;
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

    .table tbody td:nth-child(2) {
        text-align: left;
        font-weight: 500;
    }

    /* === STATUS BADGE === */
    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 1rem;
    }

    .status-badge.sudah {
        background: linear-gradient(90deg, #d1fae5 60%, #a7f3d0 100%);
        color: #065f46;
    }

    .status-badge.belum {
        background: linear-gradient(90deg, #fee2e2 60%, #fecaca 100%);
        color: #991b1b;
    }

    /* === ACTION BUTTONS === */
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
        text-decoration: none;
    }

    .btn-info {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }

    .btn-info:hover {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
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

    /* === PAGINATION === */
    .pagination-wrapper {
        margin-top: 1.5rem;
        display: flex;
        justify-content: center;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .laporan-index-wrapper {
            padding: 1.5rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
            justify-content: center;
        }

        .filter-wrapper {
            grid-template-columns: 1fr;
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
    }
</style>
@endpush

@section('content')
<div class="laporan-index-wrapper">

    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-chart-pie"></i>
            Laporan Kinerja Dosen
        </h1>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.inaktif') }}" class="btn btn-warning">
                <i class="fas fa-user-slash"></i>
                Dosen Inaktif
            </a>
            <a href="{{ route('admin.laporan.cetak', request()->query()) }}" class="btn btn-outline-primary" target="_blank">
                <i class="fas fa-print"></i>
                Cetak Laporan
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <form action="{{ route('admin.laporan.index') }}" method="GET" class="filter-section">
        <div class="filter-wrapper">
            {{-- Search Input --}}
            <div class="filter-group">
                <i class="fas fa-search"></i>
                <input type="text" name="search" class="filter-input" value="{{ $search ?? '' }}" placeholder="Cari Nama atau NIDN...">
            </div>

            {{-- Prodi Select --}}
            <div class="filter-group">
                <i class="fas fa-graduation-cap"></i>
                <select name="prodi" class="filter-select">
                    <option value="">Semua Program Studi</option>
                    @foreach($prodiOptions as $option)
                        <option value="{{ $option->prodi }}" {{ ($prodiFilter ?? '') == $option->prodi ? 'selected' : '' }}>
                            {{ $option->prodi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tahun Filter --}}
            <div class="filter-group">
                <i class="fas fa-calendar-alt"></i>
                <select name="tahun" class="filter-select">
                    <option value="all" @if($filterTahun == 'all') selected @endif>Semua Waktu</option>
                    <option value="1_year" @if($filterTahun == '1_year') selected @endif>Tahun Ini</option>
                    <option value="3_years" @if($filterTahun == '3_years') selected @endif>3 Tahun Terakhir</option>
                    <option value="5_years" @if($filterTahun == '5_years') selected @endif>5 Tahun Terakhir</option>
                    @if($yearOptions->isNotEmpty())
                        <optgroup label="Tahun Spesifik">
                            @foreach($yearOptions as $year)
                                <option value="{{ $year }}" @if($filterTahun == $year) selected @endif>{{ $year }}</option>
                            @endforeach
                        </optgroup>
                    @endif
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i>
                Filter
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
                    <th>Jumlah Jurnal</th>
                    <th>Jumlah PKM</th>
                    <th>Status</th>
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
                    <td>{{ $dosen->jurnals_count }}</td>
                    <td>{{ $dosen->pkms_count }}</td>
                    <td>
                        @if ($dosen->jurnals_count > 0 || $dosen->pkms_count > 0)
                            <span class="status-badge sudah">Sudah</span>
                        @else
                            <span class="status-badge belum">Belum</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.laporan.detail', $dosen->id) }}" class="btn-action btn-info">
                            <i class="fas fa-eye"></i>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8">
                        <div class="empty-state">
                            <i class="fas fa-info-circle"></i>
                            <p>Data tidak ditemukan.</p>
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