<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Kinerja Dosen</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .report-header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .report-header h2, .report-header p {
            margin: 0;
        }
        .report-header h2 {
            font-size: 18px;
        }
        .report-header p {
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table thead th {
            background-color: #f2f2f2;
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-weight: bold;
        }
        table tbody td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .footer {
            text-align: right;
            font-size: 12px;
            margin-top: 40px;
        }
    </style>
</head>
<body onload="window.print()">

    <div class="report-header">
        <h2>Laporan Kinerja Dosen</h2>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
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
                <th class="text-center">Status</th>
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
                <td class="text-center">
                    @if ($dosen->jurnals_count > 0 || $dosen->pkms_count > 0)
                        Sudah
                    @else
                        Belum
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data tidak ditemukan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>