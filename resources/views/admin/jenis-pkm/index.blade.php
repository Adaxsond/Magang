@extends('admin.layouts.app')
@section('title', 'Kelola Jenis PKM')

@push('styles')
<style>
    /* Mengambil semua gaya dari halaman Data Dosen */
    .custom-card {
        border-radius: 1.2rem;
        border: none;
        box-shadow: 0 4px 24px 0 rgba(44,62,80,0.09);
        background: #fff;
        padding: 2.2rem 2rem;
        margin-bottom: 2rem;
    }
    .custom-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .custom-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2563eb;
        margin: 0;
    }
    .custom-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 0.7rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(44,62,80,0.04);
    }
    .custom-table th, .custom-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 1rem;
        vertical-align: middle;
    }
    .custom-table th {
        background: #f3f6fa;
        color: #2563eb;
        font-weight: 700;
        text-align: center; /* Membuat header rata tengah */
    }
    .custom-table td {
        text-align: center; /* Membuat semua sel rata tengah secara default */
    }
    .actions-group {
        display: flex;
        gap: 8px;
        justify-content: center; /* Membuat tombol aksi rata tengah */
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        min-width: 80px;
        font-size: 0.95em;
        font-weight: 600;
        border: none;
        border-radius: 7px;
        padding: 5px 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: 0 1px 4px rgba(44,62,80,0.07);
    }
    .action-btn-edit {
        background: #a5b4fc;
        color: #3730a3;
    }
    .action-btn-edit:hover {
        background: #6366f1;
        color: #fff;
    }
    .action-btn-hapus {
        background: #fecaca;
        color: #b91c1c;
    }
    .action-btn-hapus:hover {
        background: #ef4444;
        color: #fff;
    }
    .empty-state {
        text-align: center;
        padding: 2.5rem 1rem;
        color: #b0b8c1;
    }
    .empty-state i {
        font-size: 2.2rem;
        margin-bottom: 1rem;
        color: #cbd5e1;
    }
    .input-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    .input-group-text {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 2rem 0 0 2rem;
        font-size: 1.1rem;
        padding: 0.6rem 1rem;
        display: flex;
        align-items: center;
    }
    .input-group .form-control {
        border-radius: 0 2rem 2rem 0;
        border: 1px solid #e5e7eb;
        background: #f8fafc;
        font-size: 1rem;
        padding: 0.6rem 1.2rem;
        transition: box-shadow 0.2s;
    }
    .input-group .form-control:focus {
        box-shadow: 0 0 0 2px #2563eb33;
        border-color: #2563eb;
        background: #fff;
    }
    .input-group .btn-primary {
        border-radius: 2rem;
        font-size: 1.05rem;
        padding: 0.6rem 1.5rem;
        background: #2563eb;
        color: #fff;
        border: none;
        font-weight: 600;
        transition: background 0.2s, transform 0.2s;
    }
    .input-group .btn-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<div class="custom-card">
    {{-- Header Halaman --}}
    <div class="custom-header">
        <h1><i class="fas fa-lightbulb me-2"></i> Kelola Jenis PKM</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">Nama Jenis PKM yang Anda masukkan sudah ada.</div>
    @endif

    {{-- Form Tambah di Atas --}}
    <form action="{{ route('admin.jenis-pkm.store') }}" method="POST" class="mb-4 pb-3 border-bottom">
        @csrf
        <label class="form-label fw-bold">Tambah Jenis PKM Baru:</label>
        
        {{-- ============================================= --}}
        {{--           BAGIAN YANG DIPERBAIKI ADA DI SINI      --}}
        {{-- ============================================= --}}
        <div class="input-group">
            <span class="input-group-text"><i class="fas fa-plus"></i></span>
            <input type="text" name="nama" class="form-control" placeholder="Ketik nama jenis PKM..." required>
            <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
    </form>

    {{-- Tabel Daftar Jenis PKM --}}
    <div class="table-responsive">
        <table class="custom-table">
            <thead>
                <tr>
                    <th style="width: 60px;">No</th>
                    <th style="text-align: left;">Nama Jenis PKM</th>
                    <th style="width: 200px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisPkms as $i => $pkm)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td style="text-align: left;">{{ $pkm->nama }}</td>
                        <td>
                            <div class="actions-group">
                                <a href="{{ route('admin.jenis-pkm.edit', $pkm) }}" class="action-btn action-btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.jenis-pkm.destroy', $pkm) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-hapus" title="Hapus">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">
                            <div class="empty-state">
                                <i class="fas fa-box-open"></i>
                                <div class="fw-bold">Belum ada data jenis PKM.</div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection