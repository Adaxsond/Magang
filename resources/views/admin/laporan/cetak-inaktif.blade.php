<!DOCTYPE html>
<html>
<head>
    <title>Cetak Laporan Dosen Inaktif</title>
    {{-- (Copy style dari file cetak lainnya, contoh: cetak.blade.php) --}}
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h3, .header p { margin: 0; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h3>Laporan Dosen Belum Melakukan Penelitian dan PKM</h3>
        <p>Tanggal Cetak: {{ $tanggalCetak }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>Nama Dosen</th>
                <th>NIDN</th>
                <th>Program Studi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($dosenInaktif as $dosen)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dosen->nama_dosen }}</td>
                    <td>{{ $dosen->nidn }}</td>
                    <td>{{ $dosen->prodi }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data dosen inaktif.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <script type="text/javascript">
        window.print();
    </script>
</body>
</html>