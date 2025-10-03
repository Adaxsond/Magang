    @extends('admin.layouts.app')
    @section('title', 'Laporan Detail Kinerja Dosen')

    @push('styles')
    <style>
        .laporan-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .laporan-header { padding: 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb; }
        .laporan-title { font-size: 1.3rem; font-weight: 700; color: #1e3a8a; margin: 0; }
        .filter-form { padding: 1.5rem; background-color: #f8fafc; }
        .form-label { font-weight: 600; color: #475569; }
        .btn-primary { background-color: #2563eb; border-color: #2563eb; }
        .btn-primary:hover { background-color: #1d4ed8; border-color: #1d4ed8; }
        .dosen-detail-card {
            margin: 1.5rem;
            padding: 1.5rem;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background-color: #fff;
        }
        .dosen-header { border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem; margin-bottom: 1rem; }
        .dosen-name { font-size: 1.2rem; font-weight: 700; color: #1e3a8a; }
        .dosen-meta { font-size: 0.9rem; color: #64748b; }
        .detail-table th { background-color: #f1f5f9; font-weight: 600; }
    </style>
    @endpush

    @section('content')
    <div class="laporan-card">
        <div class="laporan-header">
            <h5 class="laporan-title"><i class="fas fa-list-alt me-2"></i> Laporan Detail Kinerja Dosen</h5>
            <button onclick="cetakLaporan()" class="btn btn-primary"><i class="fas fa-print me-1"></i> Cetak Laporan</button>
        </div>
        <div class="filter-form">
            <form action="{{ route('admin.laporan.detail') }}" method="GET">
                 <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="search" class="form-label">Cari Nama/NIDN:</label>
                            <input type="text" name="search" id="search" class="form-control" value="{{ $search ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <label for="prodi" class="form-label">Program Studi:</label>
                            <select name="prodi" id="prodi" class="form-select">
                                <option value="">Semua</option>
                                @foreach($prodiOptions as $option)
                                    <option value="{{ $option->prodi }}" {{ ($filterProdi ?? '') == $option->prodi ? 'selected' : '' }}>{{ $option->prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tahun" class="form-label">Periode:</label>
                            <select name="tahun" id="tahun" class="form-select">
                                <option value="all" {{ $filterTahun == 'all' ? 'selected' : '' }}>Semua Waktu</option>
                                <option value="1_year" {{ $filterTahun == '1_year' ? 'selected' : '' }}>Setahun Terakhir</option>
                                <option value="3_years" {{ $filterTahun == '3_years' ? 'selected' : '' }}>3 Tahun Terakhir</option>
                                <option value="5_years" {{ $filterTahun == '5_years' ? 'selected' : '' }}>5 Tahun Terakhir</option>
                                 @if($yearOptions->count() > 0)
                                    <optgroup label="Tahun Spesifik">
                                        @foreach($yearOptions as $year)
                                            <option value="{{ $year }}" {{ $filterTahun == $year ? 'selected' : '' }}>{{ $year }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
            </form>
        </div>

        <div class="laporan-body">
            @forelse ($dosens as $dosen)
                @if($dosen->jurnals->count() > 0 || $dosen->pkms->count() > 0)
                    <div class="dosen-detail-card">
                        <div class="dosen-header">
                            <h6 class="dosen-name">{{ $dosen->nama_dosen }}</h6>
                            <span class="dosen-meta">NIDN: {{ $dosen->nidn }} | Program Studi: {{ $dosen->prodi }}</span>
                        </div>
                        
                        <h6><i class="fas fa-book-open me-2"></i> Detail Jurnal ({{ $dosen->jurnals->count() }})</h6>
                        @if($dosen->jurnals->count() > 0)
                        <table class="table table-sm table-bordered table-striped detail-table">
                            <thead><tr><th>No</th><th>Nama Jurnal</th><th>Tahun</th><th>Link</th></tr></thead>
                            <tbody>
                                @foreach($dosen->jurnals as $jurnal)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $jurnal->nama_jurnal }}</td>
                                    <td>{{ $jurnal->tahun_rilis }}</td>
                                    <td><a href="{{ $jurnal->link_jurnal }}" target="_blank">Kunjungi</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted small">Tidak ada data jurnal pada periode ini.</p>
                        @endif

                        <h6 class="mt-4"><i class="fas fa-lightbulb me-2"></i> Detail PKM ({{ $dosen->pkms->count() }})</h6>
                         @if($dosen->pkms->count() > 0)
                        <table class="table table-sm table-bordered table-striped detail-table">
                            <thead><tr><th>No</th><th>Jenis PKM</th><th>Luaran</th></tr></thead>
                            <tbody>
                               @foreach($dosen->pkms as $pkm)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pkm->jenis_pkm }}</td>
                                    <td>
                                        @forelse($pkm->luarans as $luaran)
                                            - {{ Str::ucfirst($luaran->tipe) }}: 
                                            @if($luaran->tipe == 'jurnal')
                                                <a href="{{ $luaran->link_jurnal }}" target="_blank">{{ $luaran->nama_jurnal }} ({{$luaran->tahun_rilis}})</a>
                                            @else
                                                <a href="{{ asset('storage/' . $luaran->path_foto) }}" target="_blank">Lihat Foto</a>
                                            @endif
                                            <br>
                                        @empty
                                            <span class="text-muted small">Belum ada luaran.</span>
                                        @endforelse
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p class="text-muted small">Tidak ada data PKM pada periode ini.</p>
                        @endif
                    </div>
                @endif
            @empty
                <p class="text-center p-5">Tidak ada data dosen yang cocok dengan filter yang diterapkan.</p>
            @endforelse
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        function cetakLaporan() {
            const search = document.getElementById('search').value;
            const prodi = document.getElementById('prodi').value;
            const tahun = document.getElementById('tahun').value;
            const url = new URL("{{ route('admin.laporan.detail') }}");
            url.searchParams.append('cetak', 'true');
            if (search) url.searchParams.append('search', search);
            if (prodi) url.searchParams.append('prodi', prodi);
            if (tahun) url.searchParams.append('tahun', tahun);
            window.open(url.toString(), '_blank');
        }
    </script>
    @endpush
    

