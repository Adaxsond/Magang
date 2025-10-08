@extends('admin.layouts.app')
@section('title', 'Kelola Jenis PKM')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .prodi-index-wrapper {
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

    .alert-danger {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
        border-left: 4px solid #ef4444;
    }

    /* === FORM TAMBAH === */
    .form-add-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-label-custom {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: block;
    }

    .add-input-wrapper {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 12px;
        align-items: center;
    }

    .add-input-group {
        position: relative;
    }

    .add-input-group i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #64748b;
    }

    .add-input {
        width: 100%;
        padding: 0.65rem 1rem 0.65rem 2.5rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .add-input:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        background: #fafbff;
    }

    .add-input::placeholder {
        color: #94a3b8;
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

    .btn-edit {
        background: linear-gradient(135deg, #ddd6fe 0%, #c4b5fd 100%);
        color: #5b21b6;
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
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

    /* === VALIDATION ERROR === */
    .text-danger {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.4rem;
        display: block;
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .prodi-index-wrapper {
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

        .add-input-wrapper {
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
<div class="prodi-index-wrapper">
    
    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-lightbulb"></i>
            Kelola Jenis PKM
        </h1>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle me-2"></i>
            Nama Jenis PKM yang Anda masukkan sudah ada.
        </div>
    @endif

    {{-- Form Tambah --}}
    <form action="{{ route('admin.jenis-pkm.store') }}" method="POST" class="form-add-section">
        @csrf
        <label class="form-label-custom">Tambah Jenis PKM Baru:</label>
        <div class="add-input-wrapper">
            <div class="add-input-group">
                <i class="fas fa-plus"></i>
                <input type="text" name="nama" class="add-input" 
                    placeholder="Ketik nama jenis PKM..." required>
            </div>
            <button class="btn btn-primary" type="submit">
                <i class="fas fa-save"></i>
                Tambah
            </button>
        </div>
        @error('nama')
            <div class="text-danger">{{ $message }}</div>
        @enderror
    </form>

    {{-- Table --}}
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Jenis PKM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jenisPkms as $i => $pkm)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $pkm->nama }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.jenis-pkm.edit', $pkm) }}" class="btn-action btn-edit">
                                    <i class="fas fa-edit"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.jenis-pkm.destroy', $pkm) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Yakin hapus?')">
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
                        <td colspan="3">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Belum ada data jenis PKM.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection