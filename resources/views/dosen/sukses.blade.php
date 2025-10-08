<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sukses</title>
    <style>
        body { display: flex; justify-content: center; align-items: center; height: 100vh; font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; }
        .card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #28a745; }
        a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>✅ Data Berhasil Dikirim!</h1>
        <p>Terima kasih telah melakukan input data.</p>
        <a href="{{ route('dosen.form.create') }}">Kembali ke Formulir</a>
    </div>
</body>
</html>