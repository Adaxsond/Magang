    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Cetak Laporan Dosen Belum Mengisi</title>
        <style>
            body { font-family: 'Segoe UI', Arial, sans-serif; color: #333; font-size: 10pt; }
            .report-header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
            .report-header img { height: 70px; }
            .report-header h1 { margin: 0; font-size: 18pt; }
            .filter-info { margin-bottom: 15px; font-size: 9pt; color: #555; }
            table { width: 100%; border-collapse: collapse; font-size: 9pt; }
            th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
            th { background-color: #f2f2f2; font-weight: bold; }
            @page { size: A4; margin: 2cm; }
        </style>
    </head>
    <body onload="window.print()">

        <div class="report-header">
            <img src="{{ public_path('images/logo.jpg') }}" alt="Logo Universitas">
            <h1>Laporan Dosen Belum Mengisi</h1>
            <p>Daftar dosen yang belum menginput data Jurnal dan PKM</p>
        </div>

        <div class="filter-info">
            <strong>Filter Aktif:</strong>
            @if($filterProdi) <span>Program Studi "{{ $filterProdi }}"</span> @endif
            @if($filterTahunText) <span>| Periode "{{ $filterTahunText }}"</span> @endif
            <br>
            <span>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</span>
        </div>

        <table>
            <thead>
                <tr> 
                    <th style="width:5%;">No</th> 
                    <th>Nama Dosen</th> 
                    <th>NIDN</th> 
                    <th>Program Studi</th> 
                </tr>
            </thead>
            <tbody>
                @forelse ($dosens as $dosen)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ $dosen->nama_dosen }}</td>
                    <td>{{ $dosen->nidn }}</td>
                    <td>{{ $dosen->prodi }}</td>
                </tr>
                @empty
                <tr> 
                    <td colspan="4" style="text-align: center;">Tidak ada dosen inaktif yang ditemukan sesuai filter.</td> 
                </tr>
                @endforelse
            </tbody>
        </table>

    </body>
    </html>
    

