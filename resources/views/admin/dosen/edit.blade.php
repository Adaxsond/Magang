@extends('admin.layouts.app')

@section('title', 'Edit Data Dosen')

{{-- Menambahkan style khusus untuk halaman ini --}}
@push('styles')
<style>
    .card-header {
        padding-bottom: 15px;
        margin-bottom: 25px;
        border-bottom: 1px solid #e9ecef;
    }
    .card-header h1 {
        margin: 0;
        font-size: 24px;
        color: #343a40;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #495057;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
        box-sizing: border-box;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .form-error {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 6px;
    }
    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px; /* Memberi jarak antar tombol */
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .btn-secondary:hover {
        background-color: #5a6268;
    }
</style>
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Edit Data Dosen</h1>
    </div>

    <form action="{{ route('admin.dosen.update', $dosen->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama_dosen">Nama Dosen</label>
            <input type="text" id="nama_dosen" name="nama_dosen" class="form-control" value="{{ old('nama_dosen', $dosen->nama_dosen) }}" required>
            @error('nama_dosen') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="nidn">NIDN</label>
            <input type="text" id="nidn" name="nidn" class="form-control" value="{{ old('nidn', $dosen->nidn) }}" required>
            @error('nidn') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="prodi">Program Studi</label>
            <input type="text" id="prodi" name="prodi" class="form-control" value="{{ old('prodi', $dosen->prodi) }}" required>
            @error('prodi') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $dosen->email) }}" required>
            @error('email') <div class="form-error">{{ $message }}</div> @enderror
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Perbarui</button>
            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection