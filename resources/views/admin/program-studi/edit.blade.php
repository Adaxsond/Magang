@extends('admin.layouts.app')
@section('title', 'Edit Program Studi')

@push('styles')
<style>
    body, html {
        width: 100vw;
        max-width: 100vw;
        overflow-x: hidden;
    }
    /* ===== Container ===== */
    .edit-prodi-container {
        min-height: 85vh;
        width: 100vw;
        max-width: 100vw;
        background: #f8fafc;
        padding: 0;
        margin: 0;
        overflow-x: hidden;
    }

    /* ===== Card ===== */
    .edit-prodi-card {
        width: 100vw;
        max-width: 100vw;
        border-radius: 0;
        box-shadow: none;
        background: #fff;
        margin: 0;
        border: none;
        padding: 0;
        overflow-x: hidden;
    }

    .edit-prodi-header,
    .edit-prodi-body {
        padding: 2rem 4vw 1.5rem 4vw; /* atas kanan bawah kiri */
        box-sizing: border-box;
    }

    .edit-prodi-header {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    .edit-prodi-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2563eb;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ===== Form ===== */
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control {
        border-radius: 10px;
        background: #f9fafb;
        border: 1px solid #d1d5db;
        font-size: 1rem;
        padding: 0.65rem 1rem;
        transition: all 0.2s;
        width: 100%;
        margin-bottom: 0.5rem;
        box-sizing: border-box;
    }
    .form-control:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
        background: #fff;
    }

    .text-danger {
        font-size: 0.9rem;
        margin-top: 0.25rem;
    }

    .d-flex {
        display: flex;
        gap: 16px;
        justify-content: flex-start;
        margin-top: 2rem;
    }

    /* ===== Buttons ===== */
    .btn-primary, .btn-secondary {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.6rem 1.4rem;
        border: none;
        transition: all 0.2s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 1rem;
    }

    .btn-primary {
        background: #2563eb;
        color: #fff;
    }
    .btn-primary:hover {
        background: #1d4ed8;
    }

    .btn-secondary {
        background: #e2e8f0;
        color: #1e3a8a;
    }
    .btn-secondary:hover {
        background: #cbd5e1;
    }

    /* ===== Responsive ===== */
    @media (max-width: 600px) {
        .edit-prodi-header,
        .edit-prodi-body {
            padding: 1rem 3vw 1rem 3vw;
        }
        .d-flex {
            flex-direction: column;
            gap: 10px;
            margin-top: 1.2rem;
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-prodi-container">
    <div class="edit-prodi-card">
        <!-- Header -->
        <div class="edit-prodi-header">
            <h5 class="edit-prodi-title">
                <i class="fas fa-edit"></i> Edit Program Studi
            </h5>
        </div>

        <!-- Body -->
        <div class="edit-prodi-body">
            <form action="{{ route('admin.program-studi.update', $programStudi) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-4">
                    <label for="nama" class="form-label">Nama Program Studi</label>
                    <input type="text" name="nama" id="nama"
                        class="form-control"
                        value="{{ old('nama', $programStudi->nama) }}" required>
                    @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex">
                    <a href="{{ route('admin.program-studi.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
