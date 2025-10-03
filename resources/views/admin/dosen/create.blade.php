@extends('admin.layouts.app')

@section('title', 'Tambah Dosen Baru')

@push('styles')
<style>
    .create-dosen-wrapper {
        display: flex;
        gap: 32px;
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 2.5rem 2rem 2rem 2rem;
        margin-bottom: 2rem;
        align-items: flex-start;
        width: 100%;
        max-width: 100%;
        margin: 0 auto;
        justify-content: center;
        box-sizing: border-box;
    }
    .create-dosen-profile {
        flex: 0 0 280px;
        border-right: 1px solid #e5e7eb;
        padding-right: 32px;
        text-align: center;
    }
    .dosen-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 60%, #4f8cff 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2.8rem;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 12px rgba(37,99,235,0.2);
    }
    .profile-title {
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
    }
    .profile-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    .create-dosen-form-area {
        flex: 1;
        padding-left: 32px;
        max-width: 600px;
    }
    .create-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }
    .create-subtitle {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    .form-label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,.15);
    }
    .input-group {
        margin-bottom: 1.5rem;
    }
    .input-group-text {
        background: #f1f5f9;
        border-right: 0;
        border-color: #e2e8f0;
        color: #64748b;
    }
    .input-group .form-control, .input-group .form-select {
        border-left: 0;
    }
    .btn-action-group {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
        padding-top: 1.5rem;
    }
    .btn-primary {
        background: #2563eb;
        border: none;
        font-weight: 600;
    }
    .btn-primary:hover {
        background: #1d4ed8;
    }
    .btn-secondary {
        background: #e2e8f0;
        border-color: #e2e8f0;
        color: #475569;
        font-weight: 600;
    }
    .btn-secondary:hover {
        background: #cbd5e1;
    }

    @media (max-width: 992px) {
        .create-dosen-wrapper {
            flex-direction: column;
            padding: 1.5rem 1rem;
        }
        .create-dosen-profile {
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            padding-right: 0;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: left;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 0 0 auto;
            width: 100%;
        }
        .create-dosen-form-area {
            padding-left: 0;
            width: 100%;
        }
        .dosen-avatar { margin: 0; }
    }
</style>
@endpush

@section('content')
<div class="create-dosen-wrapper">
    {{-- Area Profil --}}
    <div class="create-dosen-profile">
        <div class="dosen-avatar">
            <i class="fas fa-user-plus"></i>
        </div>
        <div>
            <h3 class="profile-title">Formulir Data Dosen</h3>
            <p class="profile-subtitle">Pastikan semua data yang diinput sudah benar. Data dosen akan digunakan sebagai referensi untuk input jurnal dan PKM.</p>
        </div>
    </div>

    {{-- Area Formulir --}}
    <div class="create-dosen-form-area">
        <h2 class="create-title">Tambah Dosen Baru</h2>
        <p class="create-subtitle">Isi detail informasi untuk dosen baru di bawah ini.</p>

        <form action="{{ route('admin.dosen.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nama_dosen" class="form-label">Nama Lengkap Dosen</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tie fa-fw"></i></span>
                    <input type="text" id="nama_dosen" name="nama_dosen" class="form-control @error('nama_dosen') is-invalid @enderror" value="{{ old('nama_dosen') }}" placeholder="Masukkan nama lengkap..." required>
                </div>
                @error('nama_dosen')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="nidn" class="form-label">NIDN</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card fa-fw"></i></span>
                        <input type="text" id="nidn" name="nidn" class="form-control @error('nidn') is-invalid @enderror" value="{{ old('nidn') }}" placeholder="Contoh: 0412345678" required>
                    </div>
                    @error('nidn')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-graduation-cap fa-fw"></i></span>
                        <select id="prodi" name="prodi" class="form-select @error('prodi') is-invalid @enderror" required>
                            <option value="" disabled selected>-- Pilih Program Studi --</option>
                            @foreach($programStudis as $prodi)
                                <option value="{{ $prodi->nama }}" {{ old('prodi') == $prodi->nama ? 'selected' : '' }}>
                                    {{ $prodi->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('prodi')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope fa-fw"></i></span>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Contoh: dosen@kampus.ac.id" required>
                </div>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="btn-action-group">
                <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
