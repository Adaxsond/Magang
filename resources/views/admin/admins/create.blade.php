@extends('admin.layouts.app')

@section('title', 'Tambah Admin Baru')

@section('content')
<style>
    .create-admin-wrapper {
        display: flex;
        gap: 32px;
        background: #fff;
        border-radius: 0;
        box-shadow: none;
        padding: 2.5rem 4vw 2rem 4vw;
        margin-bottom: 0;
        align-items: flex-start;
        width: 100%;
        max-width: 100%;
        margin: 0;
        justify-content: center;
        box-sizing: border-box;
    }
    body, .create-admin-wrapper, .create-admin-profile, .create-admin-form-area {
        overflow-x: hidden;
    }
    .create-admin-profile {
        min-width: 260px;
        max-width: 320px;
        border-right: 1.5px solid #f1f5f9;
        padding-right: 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 18px;
    }
    .admin-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6366f1 60%, #2563eb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 2.5rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(44,62,80,0.09);
        margin-bottom: 10px;
    }
    .admin-name {
        font-size: 1.18rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 2px;
        text-align: center;
    }
    .admin-email {
        font-size: 1.02rem;
        color: #64748b;
        margin-bottom: 0;
        text-align: center;
    }
    .admin-role {
        display: inline-block;
        font-size: 0.98rem;
        padding: 4px 16px;
        border-radius: 1em;
        background: #e0e7ff;
        color: #3730a3;
        font-weight: 600;
        margin-top: 4px;
        text-align: center;
    }
    .create-admin-form-area {
        flex: 1;
        padding-left: 32px;
    }
    .create-title {
        font-weight: 700;
        color: #22223b;
        font-size: 1.35rem;
        margin-bottom: 0.5rem;
        letter-spacing: 0.2px;
    }
    .create-subtitle {
        color: #64748b;
        font-size: 1.05rem;
        margin-bottom: 1.7rem;
    }
    .form-label {
        font-weight: 600;
        color: #34495e;
        margin-bottom: 6px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4f8cff;
        box-shadow: 0 0 0 0.15rem rgba(79,140,255,.15);
    }
    .input-group-modern {
        position: relative;
        margin-bottom: 1.5rem;
    }
    .input-group-modern .icon-input {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #b0b8c1;
        font-size: 1.1em;
        z-index: 2;
    }
    .input-group-modern input,
    .input-group-modern select {
        padding-left: 2.2rem !important;
        border-radius: 0.7rem;
        min-height: 44px;
        background: #f8fafc;
        border: 1px solid #e3e6f0;
        transition: border-color 0.2s;
    }
    .input-group-modern input:focus,
    .input-group-modern select:focus {
        background: #fff;
    }
    .input-group-modern label {
        margin-bottom: 0.35rem;
        display: block;
        padding-left: 2px;
    }
    .btn-action-group {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 8px;
    }
    .btn-primary {
        background: linear-gradient(90deg, #4f8cff 60%, #2563eb 100%);
        border: none;
        font-weight: 600;
    }
    .btn-primary:hover {
        background: linear-gradient(90deg, #2563eb 60%, #4f8cff 100%);
    }
    @media (max-width: 900px) {
        .create-admin-wrapper {
            flex-direction: column;
            padding: 1.2rem 0.5rem;
        }
        .create-admin-profile {
            border-right: none;
            border-bottom: 1.5px solid #f1f5f9;
            padding-right: 0;
            padding-bottom: 18px;
            margin-bottom: 18px;
            flex-direction: row;
            justify-content: flex-start;
            gap: 18px;
        }
        .create-admin-form-area {
            padding-left: 0;
        }
    }
    @media (max-width: 576px) {
        .create-admin-wrapper { padding: 0.5rem 0.2rem; }
        .create-admin-profile { flex-direction: column; gap: 10px; align-items: flex-start; }
        .btn-action-group { flex-direction: column; gap: 8px; }
    }
</style>
<div class="create-admin-wrapper">
    {{-- Profil Admin Placeholder --}}
    <div class="create-admin-profile">
        <div>
            <div class="admin-avatar">
                <i class="fas fa-user-plus"></i>
            </div>
            <div class="admin-name">Admin Baru</div>
            <div class="admin-email text-muted">Belum ada email</div>
            <span class="admin-role">Belum dipilih</span>
        </div>
    </div>
    <div class="create-admin-form-area">
        <div class="create-title"><i class="fas fa-user-plus me-2"></i>Tambah Admin Baru</div>
        <div class="create-subtitle">Isi data admin dengan benar dan lengkap.</div>

        <form action="{{ route('admin.admins.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="row g-4">
                <!-- Nama -->
                <div class="col-md-6">
                    <div class="input-group-modern">
                        <label for="name" class="form-label">Nama</label>
                        <span class="icon-input"><i class="fas fa-user"></i></span>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name') }}" required placeholder="Nama lengkap">
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <div class="input-group-modern">
                        <label for="email" class="form-label">Email</label>
                        <span class="icon-input"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email') }}" required placeholder="Alamat email aktif">
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Role -->
                <div class="col-md-6">
                    <div class="input-group-modern">
                        <label for="role" class="form-label">Peran (Role)</label>
                        <span class="icon-input"><i class="fas fa-user-shield"></i></span>
                        <select name="role" id="role" class="form-select" required>
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Pilih peran...</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                        @error('role') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Password -->
                <div class="col-md-6">
                    <div class="input-group-modern">
                        <label for="password" class="form-label">Password</label>
                        <span class="icon-input"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control"
                            required placeholder="Minimal 8 karakter">
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Konfirmasi Password -->
                <div class="col-md-6">
                    <div class="input-group-modern">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <span class="icon-input"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" required placeholder="Ulangi password">
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="btn-action-group">
                <a href="{{ route('admin.admins.index') }}" class="btn btn-light shadow-sm px-4">
                    <i class="fas fa-times"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary shadow-sm px-4">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
