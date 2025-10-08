@extends('admin.layouts.app')
@section('title', 'Edit Jenis PKM')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .edit-pkm-wrapper {
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

    /* === FORM === */
    .form-section {
        max-width: 600px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: block;
    }

    .form-control {
        width: 100%;
        padding: 0.65rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        background: #fff;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        background: #fafbff;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    /* === VALIDATION ERROR === */
    .text-danger {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.4rem;
        display: block;
    }

    /* === BUTTONS === */
    .button-group {
        display: flex;
        gap: 0.75rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

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

    .btn-secondary {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        color: #475569;
        box-shadow: 0 2px 8px rgba(71,85,105,0.1);
    }

    .btn-secondary:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
        color: #1e293b;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(71,85,105,0.15);
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .edit-pkm-wrapper {
            padding: 1.5rem;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-section {
            max-width: 100%;
        }

        .button-group {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-pkm-wrapper">
    
    {{-- Header --}}
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-edit"></i>
            Edit Jenis PKM
        </h1>
    </div>

    {{-- Form --}}
    <div class="form-section">
        <form action="{{ route('admin.jenis-pkm.update', $jenisPkm) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nama" class="form-label">Nama Jenis PKM</label>
                <input 
                    type="text" 
                    name="nama" 
                    id="nama"
                    class="form-control"
                    value="{{ old('nama', $jenisPkm->nama) }}" 
                    placeholder="Masukkan nama jenis PKM..."
                    required>
                @error('nama')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-group">
                <a href="{{ route('admin.jenis-pkm.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Perbarui
                </button>
            </div>
        </form>
    </div>

</div>
@endsection