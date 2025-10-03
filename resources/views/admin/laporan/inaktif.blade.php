    @extends('admin.layouts.app')
    @section('title', 'Laporan Dosen Belum Mengisi')

    @push('styles')
    <style>
        .laporan-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .laporan-header { padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb; }
        .laporan-title { font-size: 1.3rem; font-weight: 700; color: #1e3a8a; margin: 0; }
        .filter-form { padding: 1.5rem; background-color: #f8fafc; }
        .form-label { font-weight: 600; color: #475569; }
        .btn-primary { background-color: #2563eb; border-color: #2563eb; }
        .btn-primary:hover { background-color: #1d4ed8; border-color: #1d4ed8; }
    </style>
    @endpush

    @section('content')
    <div class="laporan-card">
        <div class="laporan-header">
            <h5 class="laporan-title"><i class="fas fa-user-clock me-2"></i> Laporan Dosen Belum Mengisi</h5>
            <button onclick="cetakLaporan()" class="btn btn-primary"><i class="fas fa-print me-1"></i> Cetak Laporan</button>
        </div>
        <div class="filter-form">
            <form action="{{ route('admin.laporan.inaktif') }}" method="GET">
                 <div class="row g-3 align-items-end">
                        <div class="col-md-5">
                            <label for="prodi" class="form-label">Program Studi:</label>
                            <select name="prodi" id="prodi" class="form-select">
                                <option value="">Semua Program Studi</option>
                                @foreach($prodiOptions as $option)
                                    <option value="{{ $option->prodi }}" {{ $filterProdi == $option->prodi ? 'selected' : '' }}>{{ $option->prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="tahun" class="form-label">Periode Belum Mengisi:</label>
                            <select name="tahun" id="tahun" class="form-select">
                                <option value="1_year" {{ $filterTahun == '1_year' ? 'selected' : '' }}>Setahun Terakhir</option>
                                <option value="3_years" {{ $filterTahun == '3_years' ? 'selected' : '' }}>3 Tahun Terakhir</option>
                                <option value="5_years" {{ $filterTahun == '5_years' ? 'selected' : '' }}>5 Tahun Terakhir</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
            </form>
        </div>

        <div class="laporan-body p-4">
            <p class="text-muted">Menampilkan daftar dosen yang tidak memiliki data Jurnal **dan** PKM pada periode yang dipilih.</p>
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Dosen</th>
                        <th>NIDN</th>
                        <th>Program Studi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dosens as $dosen)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $dosen->nama_dosen }}</td>
                        <td>{{ $dosen->nidn }}</td>
                        <td>{{ $dosen->prodi }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center p-4">Semua dosen telah mengisi data pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        function cetakLaporan() {
            const prodi = document.getElementById('prodi').value;
            const tahun = document.getElementById('tahun').value;
            const url = new URL("{{ route('admin.laporan.inaktif') }}");
            url.searchParams.append('cetak', 'true');
            if (prodi) url.searchParams.append('prodi', prodi);
            if (tahun) url.searchParams.append('tahun', tahun);
            window.open(url.toString(), '_blank');
        }
    </script>
    @endpush
    

