<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode Perawatan - SimOrgDes</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #070b14;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
            overflow: hidden;
        }
        .container {
            text-align: center;
            padding: 2rem;
            max-width: 500px;
        }
        .icon {
            width: 120px; height: 120px;
            margin: 0 auto 2rem;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 2rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 3.5rem;
            box-shadow: 0 0 60px rgba(245, 158, 11, 0.3);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); box-shadow: 0 0 60px rgba(245, 158, 11, 0.3); }
            50% { transform: scale(1.05); box-shadow: 0 0 80px rgba(245, 158, 11, 0.5); }
        }
        h1 { font-size: 2rem; font-weight: 800; margin-bottom: 1rem; background: linear-gradient(to right, #f59e0b, #ef4444); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        p { color: #94a3b8; line-height: 1.8; font-size: 1rem; }
        .badge { display: inline-block; margin-top: 2rem; padding: 0.5rem 1.5rem; background: rgba(245, 158, 11, 0.1); border: 1px solid rgba(245, 158, 11, 0.3); border-radius: 999px; color: #f59e0b; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.15em; text-transform: uppercase; }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🔧</div>
        <h1>Mode Perawatan</h1>
        <p>Sistem SimOrgDes sedang dalam proses pemeliharaan untuk meningkatkan kualitas layanan. Silakan kembali beberapa saat lagi.</p>
        <div class="badge">Maintenance Mode Active</div>
    </div>
</body>
</html>
