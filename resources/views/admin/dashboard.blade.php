@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="card" style="padding: 25px; border-radius: 16px; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
        <h1 style="margin-bottom: 10px; font-size: 22px; color: #333;">Dashboard</h1>
        <p style="margin-bottom: 20px; color: #666;">Statistik Data Saat Ini:</p>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <div style="background: linear-gradient(135deg,#667eea,#764ba2); color: #fff; padding: 20px; border-radius: 12px; text-align: center;">
                <h3 style="margin: 0; font-size: 16px;">Jumlah Dosen Terdaftar</h3>
                <p style="margin: 10px 0 0; font-size: 24px; font-weight: bold;">{{ $stats['dosen'] }}</p>
            </div>

            <div style="background: linear-gradient(135deg,#36d1dc,#5b86e5); color: #fff; padding: 20px; border-radius: 12px; text-align: center;">
                <h3 style="margin: 0; font-size: 16px;">Jumlah Jurnal Terinput</h3>
                <p style="margin: 10px 0 0; font-size: 24px; font-weight: bold;">{{ $stats['jurnal'] }}</p>
            </div>

            <div style="background: linear-gradient(135deg,#ff9966,#ff5e62); color: #fff; padding: 20px; border-radius: 12px; text-align: center;">
                <h3 style="margin: 0; font-size: 16px;">Jumlah PKM Terinput</h3>
                <p style="margin: 10px 0 0; font-size: 24px; font-weight: bold;">{{ $stats['pkm'] }}</p>
            </div>
        </div>
    </div>
@endsection
