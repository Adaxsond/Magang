@extends('admin.layouts.app')

@section('title', 'Tambah Dosen Baru')

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-user-plus me-2"></i>
                        Formulir Tambah Dosen Baru
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.dosen.store') }}" method="POST">
                        @csrf

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <h6 class="alert-heading fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Error Validasi</h6>
                                <p class="mb-0">Harap periksa kembali isian Anda pada kolom yang ditandai merah.</p>
                            </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="nama_dosen" class="form-label fw-bold">Nama Lengkap Dosen</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                <input type="text" 
                                       id="nama_dosen" 
                                       name="nama_dosen" 
                                       class="form-control @error('nama_dosen') is-invalid @enderror" 
                                       value="{{ old('nama_dosen') }}" 
                                       placeholder="Masukkan nama lengkap..."
                                       required>
                            </div>
                            @error('nama_dosen')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nidn" class="form-label fw-bold">NIDN</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    <input type="text" 
                                           id="nidn" 
                                           name="nidn" 
                                           class="form-control @error('nidn') is-invalid @enderror" 
                                           value="{{ old('nidn') }}"
                                           placeholder="Contoh: 0412345678"
                                           required>
                                </div>
                                @error('nidn')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- ============================================= --}}
                            {{--           BAGIAN YANG DIUBAH ADA DI SINI        --}}
                            {{-- ============================================= --}}
                            <div class="col-md-6 mb-3">
                                <label for="prodi" class="form-label fw-bold">Program Studi</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    {{-- Mengubah <select> menjadi <input type="text"> --}}
                                    <input type="text"
                                           id="prodi"
                                           name="prodi"
                                           class="form-control @error('prodi') is-invalid @enderror"
                                           value="{{ old('prodi') }}"
                                           placeholder="Masukkan Program Studi..."
                                           required>
                                </div>
                                @error('prodi')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}"
                                       placeholder="Contoh: dosen@kampus.ac.id"
                                       required>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card-footer bg-white text-end border-0 pt-3 px-0">
                            <a href="{{ route('admin.dosen.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-times me-1"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>
                                Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection