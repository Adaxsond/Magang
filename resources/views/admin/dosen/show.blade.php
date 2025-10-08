@extends('admin.layouts.app')
@section('title', 'Detail Dosen')

@push('styles')
<style>
    /* CARD */
    .card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 6px 24px rgba(44,62,80,0.09);
        padding: 28px 28px 22px 28px;
        margin-bottom: 28px;
        border: none;
    }

    /* HEADER */
    .back-link {
        text-decoration: none;
        color: #2563eb;
        font-weight: 600;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
        transition: color 0.2s;
    }
    .back-link:hover {
        color: #1d4ed8;
        text-decoration: underline;
    }

    /* TAB NAVIGATION */
    .tab-buttons {
        display: flex;
        flex-wrap: wrap;
        border-bottom: 2.5px solid #e5e7eb;
        margin-bottom: 1.2rem;
        gap: 8px;
    }
    .tab-button {
        padding: 12px 22px;
        cursor: pointer;
        border: none;
        background: transparent;
        font-size: 1.08rem;
        font-weight: 700;
        color: #64748b;
        border-bottom: 3px solid transparent;
        border-radius: 8px 8px 0 0;
        transition: all 0.22s;
        letter-spacing: 0.2px;
    }
    .tab-button:hover {
        color: #2563eb;
        background-color: #f3f6fa;
    }
    .tab-button.active {
        color: #2563eb;
        border-bottom: 3px solid #2563eb;
        background: #f8fafc;
    }

    /* TAB CONTENT */
    .tab-pane {
        display: none;
    }
    .tab-pane.active {
        display: block;
        animation: fadeIn 0.22s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(8px);}
        to { opacity: 1; transform: translateY(0);}
    }

    /* TABLE */
    .table-wrapper {
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
        min-width: 500px;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
    }
    th, td {
        padding: 13px 15px;
        border-bottom: 1px solid #e5e7eb;
        text-align: left;
        font-size: 15px;
    }
    th {
        background: #f3f6fa;
        font-weight: 700;
        color: #2563eb;
    }
    tr:hover {
        background-color: #f8fafc;
    }

    /* BUTTON */
    .btn-link {
        padding: 7px 16px;
        background: linear-gradient(90deg, #2563eb 60%, #4f8cff 100%);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        border-radius: 7px;
        text-decoration: none;
        white-space: nowrap;
        transition: 0.22s;
        border: none;
        display: inline-block;
    }
    .btn-link:hover {
        background: linear-gradient(90deg, #1d4ed8 60%, #2563eb 100%);
        color: #fff;
        text-decoration: none;
    }

    /* PKM CARD */
    .pkm-card {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px 18px 10px 18px;
        margin-bottom: 18px;
        background: #f8fafc;
        transition: 0.22s;
        box-shadow: 0 2px 8px rgba(44,62,80,0.04);
    }
    .pkm-card:hover {
        background: #f3f4f6;
    }
    .pkm-card h4 {
        font-size: 1.08rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 8px;
    }
    .pkm-card h5 {
        font-size: 1rem;
        font-weight: 600;
        margin-top: 10px;
        margin-bottom: 7px;
        color: #374151;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .card { padding: 14px 7px 10px 7px; }
        .tab-buttons { gap: 4px; }
        .tab-button { font-size: 14px; padding: 8px 10px; }
        th, td { font-size: 13px; padding: 9px; }
        .btn-link { font-size: 12px; padding: 5px 10px; }
        .pkm-card { padding: 10px 7px 7px 7px; }
    }
</style>
@endpush

@section('content')
    {{-- PROFIL DOSEN --}}
    <div class="card">
        <a href="{{ route('admin.dosen.index') }}" class="back-link">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Dosen
        </a>
        <hr>
        <h2 style="margin-bottom:18px; color:#2563eb; font-weight:700;">Profil Dosen</h2>
        <div style="font-size:1.08rem;">
            <p><strong>Nama:</strong> {{ $dosen->nama_dosen }}</p>
            <p><strong>NIDN:</strong> {{ $dosen->nidn }}</p>
            <p><strong>Program Studi:</strong> {{ $dosen->prodi }}</p>
            <p><strong>Email:</strong> {{ $dosen->email }}</p>
        </div>
    </div>

    {{-- TAB DATA --}}
    <div class="card">
        <div class="tab-buttons">
            <button class="tab-button active" onclick="openTab(event, 'jurnal')">
                <i class="fas fa-book-open me-1"></i> Publikasi Jurnal ({{ $dosen->jurnals->count() }})
            </button>
            <button class="tab-button" onclick="openTab(event, 'pkm')">
                <i class="fas fa-lightbulb me-1"></i> Kegiatan PKM ({{ $dosen->pkms->count() }})
            </button>
        </div>

        {{-- JURNAL --}}
        <div id="jurnal" class="tab-pane active">
            <h3 style="color:#2563eb; font-weight:700;">Daftar Publikasi Jurnal</h3>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Jurnal</th>
                            <th>Tahun</th>
                            <th>Link</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dosen->jurnals as $jurnal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $jurnal->nama_jurnal }}</td>
                                <td>{{ $jurnal->tahun_rilis }}</td>
                                <td>
                                    <a href="{{ $jurnal->link_jurnal }}" target="_blank" class="btn-link">
                                        <i class="fas fa-external-link-alt"></i> Kunjungi
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" style="text-align:center;">Tidak ada data jurnal.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PKM --}}
        <div id="pkm" class="tab-pane">
            <h3 style="color:#2563eb; font-weight:700;">Daftar Kegiatan PKM</h3>
            @forelse ($dosen->pkms as $pkm)
                <div class="pkm-card">
                    <h4>{{ $loop->iteration }}. {{ $pkm->jenis_pkm }}</h4>
                    <h5>Luaran:</h5>
                    <div class="table-wrapper">
                        <table>
                            <tbody>
                                @forelse ($pkm->luarans as $luaran)
                                    <tr>
                                        <td style="width: 160px;"><strong>Tipe Luaran</strong></td>
                                        <td>{{ Str::ucfirst($luaran->tipe) }}</td>
                                    </tr>
                                    @if ($luaran->tipe == 'jurnal')
                                        <tr><td><strong>Nama Jurnal</strong></td><td>{{ $luaran->nama_jurnal ?? '-' }}</td></tr>
                                        <tr><td><strong>Tahun</strong></td><td>{{ $luaran->tahun_rilis ?? '-' }}</td></tr>
                                        <tr>
                                            <td><strong>Link</strong></td>
                                            <td>
                                                <a href="{{ $luaran->link_jurnal }}" target="_blank" class="btn-link">
                                                    <i class="fas fa-external-link-alt"></i> Kunjungi
                                                </a>
                                            </td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td><strong>Foto</strong></td>
                                            <td>
                                                <a href="{{ asset('storage/' . $luaran->path_foto) }}" target="_blank" class="btn-link">
                                                    <i class="fas fa-image"></i> Lihat Foto
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr><td colspan="2">Tidak ada data luaran untuk PKM ini.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <p style="color:#888;">Tidak ada data PKM.</p>
            @endforelse
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openTab(evt, tabName) {
        let tabPanes = document.getElementsByClassName("tab-pane");
        for (let i = 0; i < tabPanes.length; i++) {
            tabPanes[i].style.display = "none";
            tabPanes[i].classList.remove("active");
        }

        let tabButtons = document.getElementsByClassName("tab-button");
        for (let i = 0; i < tabButtons.length; i++) {
            tabButtons[i].classList.remove("active");
        }

        document.getElementById(tabName).style.display = "block";
        document.getElementById(tabName).classList.add("active");
        evt.currentTarget.classList.add("active");
    }

    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector(".tab-button").click();
    });
</script>
@endpush