@extends('admin.layouts.app')

@section('title', 'Data Dosen')

@section('content')
<style>
    .dosen-card {
        border-radius: 1.2rem;
        border: none;
        box-shadow: 0 4px 24px 0 rgba(44,62,80,0.09);
        background: #fff;
        padding: 2.2rem 2rem;
        margin-bottom: 2rem;
    }
    .dosen-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .dosen-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2563eb;
        margin: 0;
    }
    .search-form {
        margin-bottom: 22px;
    }
    .search-form .form-control {
        border-radius: 0.7rem;
        border: 1px solid #d1d5db;
        background: #f9fafb;
        min-width: 220px;
    }
    .search-form .btn {
        border-radius: 0.7rem;
        font-weight: 600;
        padding: 0.5rem 1.2rem;
    }
    .dosen-table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 0.7rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(44,62,80,0.04);
    }
    .dosen-table th, .dosen-table td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 1rem;
        vertical-align: middle;
    }
    .dosen-table th {
        background: #f3f6fa;
        color: #2563eb;
        font-weight: 700;
        text-align: center;
    }
    .dosen-table td {
        text-align: center;
    }

    /* Tombol Aksi Vertikal */
    .btn-action-text {
        display: block;
        width: 75px;
        text-align: center;
        font-size: 0.85rem;
        font-weight: 600;
        padding: 5px 0;
        margin: 3px auto;
        border: none;
        border-radius: 6px;
        transition: all 0.2s ease-in-out;
        color: #fff;
        cursor: pointer;
    }
    .btn-detail {
        background-color: #0dcaf0;
    }
    .btn-detail:hover {
        background-color: #0bb1d4;
    }
    .btn-edit {
        background-color: #2563eb;
    }
    .btn-edit:hover {
        background-color: #1e4ed8;
    }
    .btn-delete {
        background-color: #dc3545;
    }
    .btn-delete:hover {
        background-color: #bb2d3b;
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
    @media (max-width: 768px) {
        .dosen-header { flex-direction: column; align-items: flex-start; gap: 10px; }
        .dosen-table th, .dosen-table td { padding: 10px 7px; font-size: 0.97rem; }
    }

    .aksi-btn-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        align-items: center;
    }
    .aksi-btn {
        display: block;
        min-width: 80px;
        font-size: 0.95em;
        font-weight: 600;
        border: none;
        border-radius: 7px;
        padding: 4px 16px;
        text-align: center;
        cursor: pointer;
        transition: background 0.18s, color 0.18s;
        box-shadow: 0 1px 4px rgba(44,62,80,0.07);
        color: #222;
        background: #f3f4f6;
    }
    .aksi-btn i {
        margin-right: 4px;
    }
    .aksi-btn-detail {
        background: #a5f3fc;
        color: #0369a1;
    }
    .aksi-btn-detail:hover {
        background: #38bdf8;
        color: #fff;
    }
    .aksi-btn-edit {
        background: #a5b4fc;
        color: #3730a3;
    }
    .aksi-btn-edit:hover {
        background: #6366f1;
        color: #fff;
    }
    .aksi-btn-hapus {
        background: #fecaca;
        color: #b91c1c;
    }
    .aksi-btn-hapus:hover {
        background: #ef4444;
        color: #fff;
    }
</style>

<div class="dosen-card">
    {{-- Header Title + Button --}}
    <div class="dosen-header">
        <h1><i class="fas fa-users mr-2"></i> Daftar Dosen</h1>
        <div style="display: flex; gap: 10px;">
            {{-- <a href="{{ route('admin.dosen.create') }}" class="btn btn-primary" style="padding: 8px 14px; border-radius: 8px; font-weight: 500;">Tambah Dosen Baru</a> --}}
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="alert alert-success" style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Form --}}
    <div class="search-form">
        <form action="{{ route('admin.dosen.index') }}" method="GET" class="d-flex flex-wrap gap-2">
            <input type="text" name="search" placeholder="Cari Nama atau NIDN..." 
                class="form-control" 
                value="{{ request('search') }}" 
                style="flex: 1; max-width: 300px;">
            <button type="submit" class="btn btn-primary">Cari</button>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="dosen-table">
            <thead>
                <tr>
                    <th style="width:5%;">No</th>
                    <th>Nama Dosen</th>
                    <th>NIDN</th>
                    <th>Program Studi</th>
                    <th style="width:15%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($dosens as $dosen)
                    <tr>
                        <td>{{ $loop->iteration + $dosens->firstItem() - 1 }}</td>
                        <td style="text-align:left;">{{ $dosen->nama_dosen }}</td>
                        <td>{{ $dosen->nidn }}</td>
                        <td>{{ $dosen->prodi }}</td>
                        <td>
                            <div class="aksi-btn-group">
                                <a href="{{ route('admin.dosen.show', $dosen->id) }}"
                                   class="aksi-btn aksi-btn-detail"
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.dosen.edit', $dosen->id) }}"
                                   class="aksi-btn aksi-btn-edit"
                                   data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.dosen.destroy', $dosen->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="aksi-btn aksi-btn-hapus"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Hapus">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <i class="fas fa-user-slash"></i>
                                <div class="fw-bold mt-2">
                                    @if(request('search'))
                                        Dosen dengan nama atau NIDN "<strong>{{ request('search') }}</strong>" tidak ditemukan.
                                    @else
                                        Tidak ada data.
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:20px;">
        {{ $dosens->links() }}
    </div>
</div>
@endsection
