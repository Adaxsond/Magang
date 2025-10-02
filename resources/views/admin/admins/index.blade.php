@extends('admin.layouts.app')

@section('title', 'Kelola Admin')

@section('content')
<div class="card" style="padding: 25px; border-radius: 16px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
    {{-- Header Title + Button --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1 style="margin: 0; font-size: 22px; color: #333;">👤 Daftar Admin</h1>
        @can('manage-admins')
        <div>
            <a href="{{ route('admin.admins.create') }}" class="btn btn-primary" 
               style="padding: 8px 14px; border-radius: 8px; font-weight: 500;">
                + Tambah Admin Baru
            </a>
        </div>
        @endcan
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="alert alert-success" style="padding: 12px 16px; background: #d4edda; color: #155724; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="padding: 12px 16px; background: #f8d7da; color: #721c24; border-radius: 8px; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Search Form --}}
    <div class="search-form" style="margin-bottom: 20px;">
        <form action="{{ route('admin.admins.index') }}" method="GET">
            <div style="display: flex; gap: 10px;">
                <input type="text" name="search" placeholder="Cari Nama atau Email..." 
                    class="form-control" 
                    value="{{ request('search') }}" 
                    style="flex: 1; max-width: 300px; padding: 10px 12px; border: 1px solid #ddd; border-radius: 8px;">
                <button type="submit" class="btn btn-primary" 
                    style="padding: 10px 16px; border-radius: 8px; font-weight: 500;">Cari</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; border-radius: 12px; overflow: hidden;">
            <thead>
                <tr style="background: #f8f9fa; text-align: left;">
                    <th style="padding: 14px; text-align: center; width: 5%;">#</th>
                    <th style="padding: 14px;">Nama</th>
                    <th style="padding: 14px;">Email</th>
                    <th style="padding: 14px;">Peran</th>
                    @can('manage-admins')
                        <th style="padding: 14px; text-align: center;">Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse ($admins as $admin)
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 14px; text-align: center;">{{ $loop->iteration + $admins->firstItem() - 1 }}</td>
                        <td style="padding: 14px;">{{ $admin->name }}</td>
                        <td style="padding: 14px;">{{ $admin->email }}</td>
                        <td style="padding: 14px;">
                            <span class="badge" 
                                style="padding: 6px 10px; border-radius: 6px; 
                                background-color: {{ $admin->role === 'superadmin' ? '#dc3545' : '#007bff' }}; 
                                color: #fff;">
                                {{ Str::ucfirst($admin->role) }}
                            </span>
                        </td>
                        @can('manage-admins')
                        <td style="padding: 14px; text-align: center; white-space: nowrap;">
                            <div class="aksi-btn-group">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                   class="aksi-btn aksi-btn-edit">Edit</a>
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}"
                                      method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus admin ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="aksi-btn aksi-btn-hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                        @endcan
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding: 20px; color: #888;">
                            @if(request('search'))
                                Admin dengan nama/email "<strong>{{ request('search') }}</strong>" tidak ditemukan.
                            @else
                                Tidak ada data admin.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div style="margin-top:20px;">
        {{ $admins->links() }}
    </div>
</div>

<style>
.aksi-btn-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
    align-items: center;
}
.aksi-btn {
    display: block;
    min-width: 60px;
    font-size: 0.95em;
    font-weight: 600;
    border: none;
    border-radius: 7px;
    padding: 4px 16px;
    text-align: center;
    cursor: pointer;
    transition: background 0.18s, color 0.18s;
    box-shadow: 0 1px 4px rgba(44,62,80,0.07);
}
.aksi-btn-edit {
    background: #a5b4fc;
    color: #222;
}
.aksi-btn-edit:hover {
    background: #6366f1;
    color: #fff;
}
.aksi-btn-hapus {
    background: #fecaca;
    color: #b91c1c;
    margin-top: 2px;
}
.aksi-btn-hapus:hover {
    background: #ef4444;
    color: #fff;
}
</style>
@endsection
