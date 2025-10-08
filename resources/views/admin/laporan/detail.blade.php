<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Kinerja Dosen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* === GENERAL STYLING === */
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f1f5f9; /* Light gray background for screen view */
            color: #334155;
            margin: 0;
            padding: 2rem;
        }

        /* === WRAPPER UTAMA (CARD) === */
        .report-wrapper {
            background: #ffffff;
            border-radius: 1.2rem;
            box-shadow: 0 4px R20px rgba(0,0,0,0.06);
            padding: 2.5rem;
            margin: 0 auto;
            max-width: 1200px; /* Limit width on screen for better readability */
        }

        /* === HEADER === */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .page-title {
            font-weight: 700;
            color: #1e293b;
            font-size: 1.75rem;
            margin: 0;
            letter-spacing: -0.02em;
        }

        .page-title i {
            color: #2563eb;
            margin-right: 0.75rem;
        }

        .page-subtitle {
            font-size: 1rem;
            color: #64748b;
            text-align: right;
        }

        /* === TABLE STYLING === */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .table thead {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .table thead th {
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #475569;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid #e5e7eb;
        }

        .table tbody tr {
            border-bottom: 1px solid #e5e7eb;
            transition: background 0.2s ease;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .table tbody tr:last-child {
            border-bottom: none;
        }

        .table tbody td {
            padding: 1rem;
            color: #334155;
            font-size: 0.95rem;
            vertical-align: middle;
        }
        
        /* === UTILITY CLASSES === */
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        
        /* === EMPTY STATE === */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #64748b;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
            display: block;
        }

        .empty-state p {
            margin: 0;
            font-size: 1rem;
        }
        
        /* === PRINT STYLES === */
        @media print {
            body {
                background-color: #fff;
                padding: 0;
                font-size: 10pt; /* Adjust font size for print */
            }
            .report-wrapper {
                box-shadow: none;
                border: none;
                padding: 0;
                margin: 0;
                max-width: 100%;
                border-radius: 0;
            }
            .page-header {
                justify-content: center; /* Center header content for print */
                flex-direction: column;
                text-align: center;
            }
            .table, .table-wrapper {
                border: none;
            }
            .table thead {
                background: #f2f2f2 !important; /* Simple background for print, important to override gradient */
                -webkit-print-color-adjust: exact; /* Ensures background color prints in Chrome/Safari */
                color-adjust: exact; /* Ensures background color prints in Firefox */
            }
            .table th, .table td {
                border: 1px solid #ddd !important;
                padding: 8px;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="report-wrapper">
    
        <div class="page-header">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-file-alt"></i>
                    Laporan Kinerja Dosen
                </h1>
            </div>
            <div class="page-subtitle">
                <strong>Tanggal Cetak:</strong> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </div>
        </div>

        <div class="table-wrapper">
            <table class="table">
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
                        <td colspan="7">
                             <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Data kinerja dosen tidak ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>