<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Input Jurnal dan PKM Dosen - USINDO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <style>
        :root {
            --usindo-yellow: #ffd100;
            --usindo-red: #e4002b;
            --usindo-dark: #212529;
            --usindo-gray: #f8f9fa;
        }
        body {
            font-family: 'Segoe UI', 'Roboto', Arial, sans-serif;
            background-color: #f4f7f9;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        .page-header {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            align-items: center;
            gap: 15px;
            border-bottom: 3px solid var(--usindo-yellow);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .page-header img {
            height: 50px;
        }
        .page-header .title {
            font-weight: 600;
            color: var(--usindo-dark);
        }
        .container {
            width: 100%;
            max-width: 880px;
            background: #fff;
            padding: 38px 32px 32px 32px;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44,62,80,0.13);
            margin: 30px auto;
            border-top: 5px solid var(--usindo-yellow);
        }
        h1 { text-align: center; color: var(--usindo-dark); font-size: 2rem; font-weight: 800; margin-bottom: 10px; }
        h2 { color: var(--usindo-dark); font-size: 1.25rem; font-weight: 700; margin-top: 18px; margin-bottom: 10px; border-left: 4px solid var(--usindo-yellow); padding-left: 10px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 7px; font-weight: 600; color: #374151; }
        input[type="text"], input[type="email"], input[type="url"], input[type="number"], select, input[type="file"] {
            width: 100%; padding: 12px 14px; border: 1.5px solid #d1d5db; border-radius: 8px; box-sizing: border-box; font-size: 1rem; background: #f8fafc; transition: border-color 0.18s, box-shadow 0.18s;
        }
        input:focus, select:focus {
            border-color: var(--usindo-yellow);
            outline: none; background: #fff; box-shadow: 0 0 0 3px rgba(255, 209, 0, 0.25);
        }
        .radio-group { display: flex; gap: 28px; justify-content: center; margin-bottom: 25px; }
        .radio-group label { font-weight: 600; color: var(--usindo-dark); font-size: 1.08rem; cursor: pointer; display: flex; align-items: center; gap: 7px; }
        .radio-group input[type="radio"] { accent-color: var(--usindo-yellow); width: 18px; height: 18px; }
        
        .dynamic-entry { background: #fff9e6; border: 1.5px dashed #ffe082; padding: 22px 18px 18px 18px; margin-top: 15px; border-radius: 9px; position: relative; }
        .dynamic-entry h4 { margin: 0 0 10px 0; color: var(--usindo-dark); font-size: 1.08rem; font-weight: 700; }
        
        .btn { padding: 10px 22px; border: none; border-radius: 7px; cursor: pointer; font-size: 1rem; font-weight: 600; transition: all 0.2s; }
        .btn-add { background: var(--usindo-red); color: #fff; margin-top: 8px; }
        .btn-add:hover { background: #c00024; }
        .btn-remove { background: #fee2e2; color: #b91c1c; padding: 5px 13px; font-size: 13px; position: absolute; top: 14px; right: 14px; border-radius: 6px; font-weight: 700; }
        .btn-remove:hover { background: var(--usindo-red); color: #fff; }
        .btn-submit { background: var(--usindo-yellow); color: var(--usindo-dark); width: 100%; padding: 15px; font-size: 1.13rem; font-weight: 700; border-radius: 9px; margin-top: 10px; margin-bottom: 8px; border: 1px solid #e6b800; }
        .btn-submit:hover { background: #e6b800; }
        
        fieldset { border: 1.5px solid #e5e7eb; border-radius: 8px; padding: 22px 18px 12px 18px; margin-top: 22px; margin-bottom: 8px; }
        legend { font-weight: 700; color: var(--usindo-dark); padding: 0 10px; font-size: 1.08rem; }
        
        .alert-danger { color: #b91c1c; background-color: #fef2f2; border-color: #fecaca; border-radius: 7px; padding: 15px; margin-bottom: 20px; }
        .alert-danger ul { margin-bottom: 0; padding-left: 20px; }
        
        .page-footer { text-align: center; margin-top: 30px; padding: 20px; color: #6c757d; font-size: 0.9em; }
    </style>
</head>
<body>
    <header class="page-header">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo USINDO">
        <span class="title">Universitas Sehati Indonesia</span>
    </header>

    <div class="container">
        <h1><i class="fas fa-file-signature"></i> Formulir Data Dosen</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong><i class="fas fa-exclamation-triangle"></i> Whoops!</strong> Terdapat kesalahan input:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="form-group">
            <label>Pilih jenis data yang akan diinput:</label>
            <div class="radio-group">
                <label><input type="radio" name="form_choice" value="jurnal" onchange="showForm()" {{ old('form_choice_memory') == 'jurnal' ? 'checked' : '' }}> <i class="fas fa-book-open"></i> Jurnal</label>
                <label><input type="radio" name="form_choice" value="pkm" onchange="showForm()" {{ old('form_choice_memory') == 'pkm' ? 'checked' : '' }}> <i class="fas fa-lightbulb"></i> PKM</label>
            </div>
        </div>

        {{-- Form Jurnal --}}
        <form id="form-jurnal" action="{{ route('dosen.form.store.jurnal') }}" method="POST" style="display:none;">
            @csrf
            <input type="hidden" name="form_choice_memory" value="jurnal">
            <h2>Formulir Pengerjaan Jurnal</h2>
            <fieldset>
                <legend>Data Diri Dosen</legend>
                <div class="form-group"><label><i class="fas fa-user"></i> Nama Dosen</label><input type="text" name="nama_dosen" value="{{ old('nama_dosen') }}" required></div>
                <div class="form-group"><label><i class="fas fa-id-card"></i> NIDN</label><input type="text" name="nidn" value="{{ old('nidn') }}" required></div>
                
                {{-- DROPDOWN PROGRAM STUDI --}}
                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Program Studi</label>
                    <select name="prodi" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($programStudis as $prodi)
                            <option value="{{ $prodi->nama }}" {{ old('prodi') == $prodi->nama ? 'selected' : '' }}>
                                {{ $prodi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group"><label><i class="fas fa-envelope"></i> Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
            </fieldset>
            <fieldset>
                <legend>Data Publikasi Jurnal</legend>
                <div id="jurnal-entries-container"></div>
                <button type="button" class="btn btn-add" onclick="addJurnalEntry()"><i class="fas fa-plus"></i> Tambah Jurnal Lain</button>
            </fieldset>
            <button type="submit" class="btn btn-submit"><i class="fas fa-paper-plane"></i> Kirim Data Jurnal</button>
        </form>

        {{-- Form PKM --}}
        <form id="form-pkm" action="{{ route('dosen.form.store.pkm') }}" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            <input type="hidden" name="form_choice_memory" value="pkm">
            <h2>Formulir Pengerjaan PKM</h2>
            <fieldset>
                <legend>Data Diri Dosen</legend>
                <div class="form-group"><label><i class="fas fa-user"></i> Nama Dosen</label><input type="text" name="nama_dosen" value="{{ old('nama_dosen') }}" required></div>
                <div class="form-group"><label><i class="fas fa-id-card"></i> NIDN</label><input type="text" name="nidn" value="{{ old('nidn') }}" required></div>
                
                {{-- DROPDOWN PROGRAM STUDI --}}
                <div class="form-group">
                    <label><i class="fas fa-graduation-cap"></i> Program Studi</label>
                    <select name="prodi" required>
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach($programStudis as $prodi)
                            <option value="{{ $prodi->nama }}" {{ old('prodi') == $prodi->nama ? 'selected' : '' }}>
                                {{ $prodi->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group"><label><i class="fas fa-envelope"></i> Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
            </fieldset>
            <fieldset>
                <legend>Data Kegiatan PKM</legend>
                <div class="form-group">
                    <label for="jenis_pkm"><i class="fas fa-lightbulb"></i> Jenis PKM</label>
                    {{-- DROPDOWN JENIS PKM --}}
                    <select name="jenis_pkm" id="jenis_pkm" required>
                        <option value="">-- Pilih Jenis PKM --</option>
                        @foreach ($pkmTypes as $type)
                            <option value="{{ $type->nama }}" {{ old('jenis_pkm') == $type->nama ? 'selected' : '' }}>
                                {{ $type->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </fieldset>
            <fieldset>
                <legend>Luaran PKM</legend>
                <div id="pkm-entries-container"></div>
                <button type="button" class="btn btn-add" onclick="addPkmEntry()"><i class="fas fa-plus"></i> Tambah Luaran Lain</button>
            </fieldset>
            <button type="submit" class="btn btn-submit"><i class="fas fa-paper-plane"></i> Kirim Data PKM</button>
        </form>
    </div>

    <footer class="page-footer">
        &copy; {{ date('Y') }} Universitas Sehati Indonesia. All Rights Reserved.
    </footer>

    <script>
        // ... (JavaScript tidak berubah)
        let jurnalEntryCount = 0;
        let pkmEntryCount = 0;
        document.addEventListener('DOMContentLoaded', function() {
            const checkedRadio = document.querySelector('input[name="form_choice"]:checked');
            if (checkedRadio) {
                showForm();
            }
        });
        function showForm() {
            const choice = document.querySelector('input[name="form_choice"]:checked').value;
            document.getElementById('form-jurnal').style.display = (choice === 'jurnal') ? 'block' : 'none';
            document.getElementById('form-pkm').style.display = (choice === 'pkm') ? 'block' : 'none';
            if (choice === 'jurnal' && jurnalEntryCount === 0) addJurnalEntry();
            if (choice === 'pkm' && pkmEntryCount === 0) addPkmEntry();
        }
        function addJurnalEntry() {
            jurnalEntryCount++;
            const container = document.getElementById('jurnal-entries-container');
            const newEntry = document.createElement('div');
            newEntry.className = 'dynamic-entry';
            newEntry.id = 'jurnal_entry_' + jurnalEntryCount;
            newEntry.innerHTML = `<h4><i class='fas fa-book'></i> Publikasi #${jurnalEntryCount}</h4> ${jurnalEntryCount > 1 ? '<button type="button" class="btn btn-remove" onclick="removeEntry(\'jurnal_entry_' + jurnalEntryCount + '\')"><i class=\'fas fa-trash\'></i> Hapus</button>' : ''}<div class="form-group"><label><i class="fas fa-book-open"></i> Nama Jurnal</label><input type="text" name="jurnals[${jurnalEntryCount}][nama_jurnal]" required></div><div class="form-group"><label><i class="fas fa-calendar-alt"></i> Tahun Rilis</label><input type="number" name="jurnals[${jurnalEntryCount}][tahun_rilis]" required></div><div class="form-group"><label><i class="fas fa-link"></i> Link Jurnal</label><input type="url" name="jurnals[${jurnalEntryCount}][link_jurnal]" required></div>`;
            container.appendChild(newEntry);
        }
        function addPkmEntry() {
            pkmEntryCount++;
            const container = document.getElementById('pkm-entries-container');
            const newEntry = document.createElement('div');
            newEntry.className = 'dynamic-entry';
            newEntry.id = 'pkm_entry_' + pkmEntryCount;
            newEntry.innerHTML = `<h4><i class='fas fa-lightbulb'></i> Luaran #${pkmEntryCount}</h4> ${pkmEntryCount > 1 ? '<button type="button" class="btn btn-remove" onclick="removeEntry(\'pkm_entry_' + pkmEntryCount + '\')"><i class=\'fas fa-trash\'></i> Hapus</button>' : ''}<div class="form-group"><label><i class="fas fa-list-ul"></i> Pilih Jenis Luaran</label><select name="luaran[${pkmEntryCount}][tipe]" onchange="togglePkmOutput(this, ${pkmEntryCount})" required><option value="">-- Pilih --</option><option value="foto">Foto Dokumentasi</option><option value="jurnal">Publikasi Jurnal</option></select></div><div id="pkm_output_content_${pkmEntryCount}"></div>`;
            container.appendChild(newEntry);
        }
        function togglePkmOutput(select, id) {
            const contentDiv = document.getElementById(`pkm_output_content_${id}`);
            if (select.value === 'foto') {
                contentDiv.innerHTML = `<div class="form-group"><label><i class="fas fa-image"></i> Upload Foto</label><input type="file" name="luaran[${id}][file]" accept="image/*" required></div>`;
            } else if (select.value === 'jurnal') {
                contentDiv.innerHTML = `<div class="form-group"><label><i class="fas fa-book-open"></i> Nama Jurnal</label><input type="text" name="luaran[${id}][nama_jurnal]" required></div><div class="form-group"><label><i class="fas fa-calendar-alt"></i> Tahun Rilis</label><input type="number" name="luaran[${id}][tahun_rilis]" required></div><div class="form-group"><label><i class="fas fa-link"></i> Link Jurnal</label><input type="url" name="luaran[${id}][link_jurnal]" required></div>`;
            } else {
                contentDiv.innerHTML = '';
            }
        }
        function removeEntry(id) { document.getElementById(id)?.remove(); }
    </script>
</body>
</html>