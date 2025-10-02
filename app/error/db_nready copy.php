<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Kesalahan Koneksi Database</title>
  <style>
    :root{
      --bg: #0f1724;      /* dark slate */
      --card: #0b1220;
      --accent: #ffb86b;  /* warm accent */
      --muted: #94a3b8;
      --white: #e6eef8;
      --glass: rgba(255,255,255,0.03);
      --shadow: 0 8px 24px rgba(3,10,18,0.6);
      --radius: 12px;
      --mono: "Inter", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue";
    }

    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family:var(--mono);
      background:
        radial-gradient(1200px 600px at 10% 10%, rgba(255,184,110,0.06), transparent 10%),
        radial-gradient(900px 400px at 90% 90%, rgba(57,123,255,0.04), transparent 10%),
        var(--bg);
      color:var(--white);
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:28px;
    }

    .card{
      width:100%;
      max-width:900px;
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:28px;
      display:grid;
      grid-template-columns: 120px 1fr;
      gap:20px;
      align-items:center;
      border: 1px solid var(--glass);
    }

    /* icon area */
    .icon-wrap{
      width:120px;
      height:120px;
      border-radius:14px;
      background: linear-gradient(135deg, rgba(255,184,107,0.12), rgba(57,123,255,0.04));
      display:flex;
      align-items:center;
      justify-content:center;
      flex-direction:column;
    }
    .icon-wrap svg{width:62px;height:62px;display:block;opacity:0.98}

    /* content */
    h1{
      margin:0 0 6px 0;
      font-size:20px;
      letter-spacing:0.2px;
    }
    p.lead{
      margin:0 0 12px 0;
      color:var(--muted);
      font-size:14px;
      line-height:1.5;
    }

    .meta{
      display:flex;
      gap:8px;
      flex-wrap:wrap;
      align-items:center;
      margin-bottom:14px;
    }
    .badge{
      background:rgba(255,255,255,0.03);
      border:1px solid rgba(255,255,255,0.03);
      padding:6px 10px;
      border-radius:8px;
      color:var(--muted);
      font-size:13px;
    }

    .actions{
      display:flex;
      gap:10px;
      align-items:center;
      flex-wrap:wrap;
    }

    .btn{
      display:inline-flex;
      align-items:center;
      gap:8px;
      padding:10px 14px;
      border-radius:10px;
      text-decoration:none;
      font-weight:600;
      font-size:14px;
      cursor:pointer;
      border:0;
    }
    .btn--primary{
      background: linear-gradient(90deg,var(--accent), #ff9c3b);
      color:#08121a;
      box-shadow: 0 6px 18px rgba(255,160,80,0.12);
    }
    .btn--ghost{
      background:transparent;
      color:var(--muted);
      border:1px solid rgba(255,255,255,0.04);
    }

    .small{
      font-size:13px;color:var(--muted);margin-top:6px;
    }

    /* responsive */
    @media (max-width:700px){
      .card{grid-template-columns: 1fr; text-align:center}
      .icon-wrap{margin:0 auto}
      .actions{justify-content:center}
    }

    /* subtle pulsing */
    @keyframes pulse {
      0% { transform: translateY(0); opacity:1 }
      50% { transform: translateY(-4px); opacity:0.95 }
      100% { transform: translateY(0); opacity:1 }
    }
    .icon-wrap{animation: pulse 3.8s ease-in-out infinite}
  </style>
</head>
<body>
  <main class="card" role="alert" aria-live="polite">
    <div class="icon-wrap" aria-hidden="true">
      <!-- simple DB / cloud warning SVG -->
      <svg viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <ellipse cx="32" cy="17" rx="22" ry="7" fill="rgba(255,255,255,0.06)"/>
        <path d="M10 17v9c0 3.9 9.9 7 22 7s22-3.1 22-7V17" fill="rgba(255,184,107,0.06)"/>
        <path d="M10 26v9c0 3.9 9.9 7 22 7s22-3.1 22-7V26" fill="rgba(255,255,255,0.02)"/>
        <circle cx="32" cy="44" r="8" fill="rgba(255,184,107,0.14)"/>
        <path d="M31 39l2 6-5-3" stroke="#08121a" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
        <rect x="40" y="10" width="12" height="10" rx="2" fill="#ffb86b" opacity="0.95"/>
        <path d="M44 13v4" stroke="#08121a" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
    </div>

    <div>
      <h1>Database belum siap</h1>
      <p class="lead">
        Sistem tidak dapat terhubung ke database saat ini. Mohon cek konfigurasi koneksi atau hubungi administrator.
      </p>

      <div class="meta" aria-hidden="true">
        <div class="badge">Status: <strong style="color:var(--white);margin-left:6px">Tidak Terhubung</strong></div>
        <div class="badge">Kode: <strong style="color:var(--white);margin-left:6px">DB_CONN_ERR</strong></div>
        <div class="badge">Waktu: <strong style="color:var(--white);margin-left:6px">
          <!-- server-side bisa ganti tanggal -->
          <?php echo date('d M Y, H:i'); ?>
        </strong></div>
      </div>

      <div class="actions">
        <!-- tombol bisa diarahkan ulang / diproses di server -->
        <button class="btn btn--primary" onclick="location.reload()" title="Coba kembali">Coba Kembali</button>
        <a class="btn btn--ghost" href="mailto:admin@contoh.local?subject=DB%20Connection%20Error" title="Hubungi admin">Laporkan ke Admin</a>
      </div>

      <div class="small">
        Tip: periksa konfigurasi host/database/username/password. Jika kamu menjalankan migrasi/seed, tunggu sampai proses selesai.
      </div>
    </div>
  </main>
</body>
</html>
