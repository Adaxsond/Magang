<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Kinerja Dosen</title>
    <style>
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            color: #333;
        }
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .report-header img {
            height: 80px;
            margin-bottom: 10px;
        }
        .report-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .report-header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #555;
        }
        .filter-info {
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
    </style>
</head>
<body onload="window.print()">

    <div class="report-header">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo Universitas">
        <h1>Laporan Kinerja Dosen</h1>
        <p>Universitas Sehati Indonesia</p>
    </div>

    <div class="filter-info">
        <strong>Filter Aktif:</strong>
        @if($search)
            <span>Pencarian "{{ $search }}"</span>
        @endif
        @if($filterProdi)
            <span>| Program Studi "{{ $filterProdi }}"</span>
        @endif
        @if(!$search && !$filterProdi)
            <span>Tidak ada</span>
        @endif
        <br>
        <span>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</span>
    </div>

    <table>
        <thead>
            <tr> 
                <th class="text-center" style="width:5%;">No</th> 
                <th class="text-left">Nama Dosen</th> 
                <th class="text-center">NIDN</th> 
                <th class="text-center">Program Studi</th> 
                <th class="text-center">Jumlah Jurnal</th> 
                <th class="text-center">Jumlah PKM</th> 
            </tr>
        </thead>
        <tbody>
            @forelse ($dosens as $dosen)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $dosen->nama_dosen }}</td>
                <td class="text-center">{{ $dosen->nidn }}</td>
                <td class="text-center">{{ $dosen->prodi }}</td>
                <td class="text-center">{{ $dosen->jurnals_count }}</td>
                <td class="text-center">{{ $dosen->pkms_count }}</td>
            </tr>
            @empty
            <tr> 
                <td colspan="6" class="text-center">Data tidak ditemukan.</td> 
            </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>