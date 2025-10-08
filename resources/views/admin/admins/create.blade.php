@extends('admin.layouts.app')

@section('title', 'Tambah Admin Baru')

@push('styles')
<style>
    /* === WRAPPER UTAMA === */
    .create-admin-wrapper {
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
    .create-admin-profile {
        text-align: center;
        padding-right: 32px;
        border-right: 1px solid #e2e8f0;
        position: sticky;
        top: 2rem;
    }

    .admin-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 3rem;
        margin: 0 auto 1.5rem;
        box-shadow: 0 8px 24px rgba(99,102,241,0.2);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .admin-avatar:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(99,102,241,0.25);
    }

    .profile-title {
        font-weight: 700;
        color: #312e81;
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
    .create-admin-form-area {
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
    .text-danger {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.4rem;
        display: block;
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

    .btn-light {
        background: #f1f5f9;
        color: #475569;
        font-weight: 600;
        border-radius: 0.5rem;
        padding: 0.7rem 1.6rem;
        border: 1px solid #e2e8f0;
        transition: all 0.2s ease;
    }

    .btn-light:hover {
        background: #e2e8f0;
        color: #334155;
        transform: translateY(-1px);
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .create-admin-wrapper {
            grid-template-columns: 1fr;
            padding: 2rem 1.5rem;
            gap: 32px;
        }

        .create-admin-profile {
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 2rem;
            padding-right: 0;
            text-align: center;
            position: static;
        }

        .create-admin-form-area {
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
        .create-admin-wrapper {
            margin: 0;
            padding: 1.5rem 1rem;
        }

        .create-title {
            font-size: 1.5rem;
        }

        .admin-avatar {
            width: 90px;
            height: 90px;
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="create-admin-wrapper">
    {{-- Area Profil --}}
    <div class="create-admin-profile">
        <div class="admin-avatar">
            <i class="fas fa-user-plus"></i>
        </div>
        <h3 class="profile-title">Formulir Admin Baru</h3>
        <p class="profile-subtitle">
            Pastikan data yang diinput sudah benar. Admin baru akan mendapatkan akses ke sistem sesuai role yang dipilih.
        </p>
    </div>

    {{-- Area Formulir --}}
    <div class="create-admin-form-area">
        <h2 class="create-title">Tambah Admin Baru</h2>
        <p class="create-subtitle">Isi informasi lengkap untuk admin baru di bawah ini.</p>

        <form action="{{ route('admin.admins.store') }}" method="POST" autocomplete="off">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user fa-fw"></i></span>
                        <input type="text" id="name" name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama lengkap..." required>
                    </div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope fa-fw"></i></span>
                        <input type="email" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            placeholder="Contoh: admin@kampus.ac.id" required>
                    </div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Peran (Role)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user-shield fa-fw"></i></span>
                    <select name="role" id="role"
                        class="form-select @error('role') is-invalid @enderror" required>
                        <option value="" disabled {{ old('role') ? '' : 'selected' }}>-- Pilih Peran --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                    </select>
                </div>
                @error('role')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock fa-fw"></i></span>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter" required>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock fa-fw"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password" required>
                    </div>
                </div>
            </div>

            <div class="btn-action-group">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-light">
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