@extends('admin.layouts.app')

@section('title', 'Tambah Dosen Baru')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .create-dosen-wrapper {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 48px;
        background: #ffffff;
        border-radius: 1.2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        padding: 3rem 3rem 2.5rem;
        margin: 0;
        max-width: 100%;
        align-items: start;
    }

    /* === AREA PROFIL KIRI === */
    .create-dosen-profile {
        text-align: center;
        padding-right: 32px;
        border-right: 1px solid #e2e8f0;
        position: sticky;
        top: 2rem;
    }

    .dosen-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 24px rgba(37,99,235,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .dosen-avatar:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(37,99,235,0.25);
    }

    .profile-title {
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
        letter-spacing: -0.01em;
    }

    .profile-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    /* === AREA FORM === */
    .create-dosen-form-area {
        flex: 1;
        padding-left: 32px;
    }

    .create-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.75rem;
        margin-bottom: 0.5rem;
        letter-spacing: -0.02em;
    }

    .create-subtitle {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    /* === FORM INPUT === */
    .form-label {
        font-weight: 600;
        color: #334155;
        margin-bottom: 0.6rem;
        font-size: 0.95rem;
    }

    .input-group {
        margin-bottom: 1.5rem;
    }

    .input-group-text {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-right: 0;
        color: #64748b;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem 0 0 0.5rem;
        padding: 0.65rem 1rem;
    }

    .form-control, .form-select {
        border-left: 0;
        border-color: #e2e8f0;
        border-radius: 0 0.5rem 0.5rem 0;
        padding: 0.65rem 1rem;
        font-size: 0.95rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 0.2rem rgba(37,99,235,0.15);
        background: #fafbff;
    }

    .form-control::placeholder {
        color: #94a3b8;
    }

    .row {
        margin-bottom: 0.5rem;
    }

    .row .col-md-6 {
        margin-bottom: 1rem;
    }

    /* === VALIDASI ERROR === */
    .invalid-feedback {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.4rem;
    }

    .is-invalid {
        border-color: #fca5a5 !important;
    }

    /* === TOMBOL AKSI === */
    .btn-action-group {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 2.5rem;
        border-top: 1px solid #e5e7eb;
        padding-top: 1.5rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        border: none;
        font-weight: 600;
        border-radius: 0.5rem;
        padding: 0.7rem 1.6rem;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(37,99,235,0.2);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(37,99,235,0.3);
    }

    .btn-secondary {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        border-radius: 0.5rem;
        padding: 0.7rem 1.6rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .btn-secondary:hover {
        background: #e2e8f0;
        color: #334155;
        transform: translateY(-1px);
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .create-dosen-wrapper {
            grid-template-columns: 1fr;
            padding: 2rem 1.5rem;
            gap: 32px;
        }

        .create-dosen-profile {
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 2rem;
            padding-right: 0;
            text-align: center;
            position: static;
        }

        .create-dosen-form-area {
            padding-left: 0;
        }

        .btn-action-group {
            flex-direction: column-reverse;
        }

        .btn-action-group .btn {
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .create-dosen-wrapper {
            margin: 0;
            padding: 1.5rem 1rem;
        }

        .create-title {
            font-size: 1.5rem;
        }

        .dosen-avatar {
            width: 90px;
            height: 90px;
            font-size: 2.5rem;
        }
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
        <h3 class="profile-title">Formulir Data Dosen</h3>
        <p class="profile-subtitle">
            Pastikan semua data yang diinput sudah benar. Data dosen akan digunakan
            untuk keperluan akademik, jurnal, dan PKM.
        </p>
    </div>

    {{-- Area Formulir --}}
    <div class="create-dosen-form-area">
        <h2 class="create-title">Tambah Dosen Baru</h2>
        <p class="create-subtitle">Isi informasi lengkap untuk dosen baru di bawah ini.</p>

        <form action="{{ route('admin.dosen.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_dosen" class="form-label">Nama Lengkap Dosen</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-tie fa-fw"></i></span>
                    <input type="text" id="nama_dosen" name="nama_dosen"
                        class="form-control @error('nama_dosen') is-invalid @enderror"
                        value="{{ old('nama_dosen') }}" placeholder="Masukkan nama lengkap..." required>
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
                        <input type="text" id="nidn" name="nidn"
                            class="form-control @error('nidn') is-invalid @enderror"
                            value="{{ old('nidn') }}" placeholder="Contoh: 0412345678" required>
                    </div>
                    @error('nidn')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-graduation-cap fa-fw"></i></span>
                        <select id="prodi" name="prodi"
                            class="form-select @error('prodi') is-invalid @enderror" required>
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
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="Contoh: dosen@kampus.ac.id" required>
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