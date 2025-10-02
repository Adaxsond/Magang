@extends('admin.layouts.app')
@section('title', 'Laporan Kinerja Dosen')

@push('styles')
<style>
    .laporan-card {
        width: 100%;
        max-width: none;
        margin: 0;
        background: #fff;
        border-radius: 0;
        box-shadow: none;
        border: none;
        padding: 0;
    }
    .laporan-header {
        padding: 2rem 3vw 1.2rem 3vw;
        display: flex;
        align-items: center;
        gap: 1rem;
        border-radius: 0;
        background: none;
        border-bottom: none;
        justify-content: space-between;
    }
    .laporan-title {
        font-size: 1.35rem;
        font-weight: 700;
        color: #2563eb;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    .print-button {
        font-weight: 600;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        font-size: 1rem;
        background: #2563eb;
        color: #fff;
        border: none;
        transition: background 0.2s;
    }
    .print-button:hover {
        background: #1d4ed8;
    }
    .filter-form {
        padding: 1.2rem 3vw 2rem 3vw; /* tambah padding atas bawah */
        background: none;
        border: none;
        margin-bottom: 0;
    }
    .filter-form .form-label {
        margin-bottom: 0.7rem; /* tambah jarak bawah label */
        margin-top: 0.7rem;    /* tambah jarak atas label */
        margin-right: 12px;
    }
    .filter-form .form-control,
    .filter-form .form-select {
        margin-right: 16px;
    }
    .form-label {
        font-weight: 600;
        color: #2563eb;
        margin-bottom: 0.3rem;
    }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #d1d5db;
        background: #f9fafb;
        font-size: 1rem;
    }
    .btn-primary {
        border-radius: 8px;
        font-weight: 600;
        background: #2563eb;
        color: #fff;
        border: none;
        transition: background 0.2s;
    }
    .btn-primary:hover {
        background: #1d4ed8;
    }
    .table-responsive {
        padding: 0 3vw 2.5rem 3vw;
    }
    .table {
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 0;
        box-shadow: 0 2px 8px rgba(37,99,235,0.04);
        width: 100%;
    }
    .table thead th {
        background: #e0e7ff;
        color: #2563eb;
        font-weight: 700;
        border-bottom: 2px solid #e5e7eb;
        text-align: center;
        vertical-align: middle;
        padding: 0.85rem 0.5rem;
    }
    .table tbody td {
        text-align: center;
        vertical-align: middle;
        background: #fff;
        padding: 0.7rem 0.5rem;
    }
    .table-hover tbody tr:hover {
        background: #f1f5f9;
    }
    .filter-form .col-md-6,
    .filter-form .col-md-4 {
        margin-bottom: 0,5rem;
        margin-top: 0.5rem;
    }
    @media (max-width: 900px) {
        .laporan-header, .filter-form, .table-responsive { padding: 1rem; }
    }
    @media (max-width: 600px) {
        .laporan-header, .filter-form, .table-responsive { padding: 0.5rem; }
        .table thead th, .table tbody td { font-size: 0.95rem; }
        .laporan-header { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
        .print-button { margin-left: 0; }
    }
</style>
@endpush

@section('content')
<div class="laporan-card">
    <div class="laporan-header">
        <h5 class="laporan-title">
            <i class="fas fa-chart-pie me-2 text-primary"></i> Laporan Kinerja Dosen
        </h5>
        {{-- Ganti tombol print lama --}}
        {{-- <button onclick="window.print()" class="print-button">
            <i class="fas fa-print me-1"></i> Cetak
        </button> --}}

        {{-- Tambahkan tombol baru --}}
        <button onclick="cetakLaporan()" class="btn btn-sm btn-outline-primary print-button">
            <i class="fas fa-print me-1"></i> Cetak Laporan
        </button>
    </div>
    <div class="card-body" style="padding:0;">
        <div class="filter-form">
            <form action="{{ route('admin.laporan.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="search" class="form-label fw-bold">Cari Nama atau NIDN:</label>
                        <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}" placeholder="Ketik di sini...">
                    </div>
                    <div class="col-md-4">
                        <label for="prodi" class="form-label fw-bold">Saring per Program Studi:</label>
                        <select name="prodi" id="prodi" class="form-select">
                            <option value="">-- Semua Program Studi --</option>
                            @foreach($prodiOptions as $option)
                                <option value="{{ $option->prodi }}" {{ ($filterProdi ?? '') == $option->prodi ? 'selected' : '' }}>
                                    {{ $option->prodi }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th style="text-align: left;">Nama Dosen</th>
                        <th>NIDN</th>
                        <th>Program Studi</th>
                        <th class="text-center">Jumlah Jurnal</th>
                        <th class="text-center">Jumlah PKM</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $dosen)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td style="text-align: left;">{{ $dosen->nama_dosen }}</td>
                        <td class="text-center">{{ $dosen->nidn }}</td>
                        <td class="text-center">{{ $dosen->prodi }}</td>
                        <td class="text-center">{{ $dosen->jurnals_count }}</td>
                        <td class="text-center">{{ $dosen->pkms_count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            Data tidak ditemukan sesuai kriteria filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Tambahkan script ini di bagian paling bawah file laporan/index.blade.php --}}
@push('scripts')
<script>
    function cetakLaporan() {
        // Ambil nilai filter saat ini dari form
        const search = document.getElementById('search').value;
        const prodi = document.getElementById('prodi').value;

        // Buat URL baru dengan parameter filter dan parameter 'cetak=true'
        const url = new URL("{{ route('admin.laporan.index') }}");
        url.searchParams.append('cetak', 'true');
        if (search) {
            url.searchParams.append('search', search);
        }
        if (prodi) {
            url.searchParams.append('prodi', prodi);
        }

        // Buka URL tersebut di tab baru (yang akan otomatis membuka dialog cetak)
        window.open(url.toString(), '_blank');
    }
</script>
@endpush
@endsection