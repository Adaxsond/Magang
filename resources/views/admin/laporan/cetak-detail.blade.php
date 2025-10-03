    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Cetak Laporan Detail Kinerja Dosen</title>
        <style>
            body { font-family: 'Segoe UI', Arial, sans-serif; color: #333; font-size: 10pt; }
            .report-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
            .report-header img { height: 70px; }
            .report-header h1 { margin: 0; font-size: 18pt; }
            .filter-info { margin-bottom: 15px; font-size: 9pt; color: #555; }
            .dosen-block { margin-bottom: 20px; page-break-inside: avoid; }
            .dosen-header { background-color: #f2f2f2; padding: 8px; font-weight: bold; border: 1px solid #ccc; border-radius: 5px 5px 0 0; }
            table { width: 100%; border-collapse: collapse; font-size: 9pt; }
            th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
            th { background-color: #f9f9f9; font-weight: bold; }
            h4 { font-size: 11pt; margin-top: 15px; margin-bottom: 5px; }
            .no-data { color: #888; font-style: italic; }
            @page { size: A4; margin: 2cm; }
        </style>
    </head>
    <body onload="window.print()">

        <div class="report-header">
            <img src="{{ public_path('images/logo.jpg') }}" alt="Logo Universitas">
            <h1>Laporan Detail Kinerja Dosen</h1>
        </div>

        <div class="filter-info">
            <strong>Filter Aktif:</strong>
            @if($search) <span>Pencarian "{{ $search }}"</span> @endif
            @if($filterProdi) <span>| Program Studi "{{ $filterProdi }}"</span> @endif
            @if($filterTahunText) <span>| Periode "{{ $filterTahunText }}"</span> @endif
            <br>
            <span>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</span>
        </div>

        @forelse ($dosens as $dosen)
             @if($dosen->jurnals->count() > 0 || $dosen->pkms->count() > 0)
            <div class="dosen-block">
                <div class="dosen-header">
                    {{ $dosen->nama_dosen }} (NIDN: {{ $dosen->nidn }}) - {{ $dosen->prodi }}
                </div>
                
                <h4>Publikasi Jurnal</h4>
                @if($dosen->jurnals->count() > 0)
                <table>
                    <thead><tr><th style="width:5%;">No</th><th>Nama Jurnal</th><th style="width:15%;">Tahun</th></tr></thead>
                    <tbody>
                        @foreach($dosen->jurnals as $jurnal)
                        <tr><td>{{ $loop->iteration }}</td><td>{{ $jurnal->nama_jurnal }}</td><td>{{ $jurnal->tahun_rilis }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="no-data">Tidak ada data jurnal pada periode ini.</p>
                @endif

                <h4>Kegiatan PKM</h4>
                @if($dosen->pkms->count() > 0)
                <table>
                    <thead><tr><th style="width:5%;">No</th><th>Jenis PKM</th><th>Detail Luaran</th></tr></thead>
                    <tbody>
                        @foreach($dosen->pkms as $pkm)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pkm->jenis_pkm }}</td>
                            <td>
                                 @forelse($pkm->luarans as $luaran)
                                    - {{ Str::ucfirst($luaran->tipe) }}: 
                                    @if($luaran->tipe == 'jurnal')
                                        {{ $luaran->nama_jurnal }} ({{$luaran->tahun_rilis}})
                                    @else
                                        Foto Dokumentasi
                                    @endif
                                    <br>
                                @empty
                                    <span class="no-data">Belum ada luaran.</span>
                                @endforelse
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="no-data">Tidak ada data PKM pada periode ini.</p>
                @endif
            </div>
            @endif
        @empty
            <p>Tidak ada data dosen yang ditemukan sesuai filter.</p>
        @endforelse

    </body>
    </html>
    

