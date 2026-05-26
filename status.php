<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>YK2 Gaming — Rental PS Terbaik di Manado</title>
<meta name="description" content="Rental PS3, PS4, PS5 terbaik di Manado. Game terupdate, harga terjangkau. Cek status unit secara real-time.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700;900&family=Rajdhani:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{
  --bg:#050508;--card:#0d0d1a;--blue:#00d4ff;--pink:#ff0080;--green:#00ff88;--purple:#a855f7;--orange:#ff6b00;
  --text:#fff;--muted:#94a3b8;--border:rgba(0,212,255,0.15);
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
::-webkit-scrollbar{width:6px}::-webkit-scrollbar-track{background:#0a0a0f}::-webkit-scrollbar-thumb{background:var(--blue);border-radius:3px}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);overflow-x:hidden}

/* NAVBAR */
.nav{position:fixed;top:0;left:0;width:100%;z-index:1000;padding:18px 5%;display:flex;justify-content:space-between;align-items:center;transition:all .3s}
.nav.solid{background:rgba(5,5,8,.95);backdrop-filter:blur(12px);border-bottom:1px solid var(--border)}
.nav-logo{font-family:'Orbitron',sans-serif;font-size:1.4rem;font-weight:900;text-decoration:none}
.nav-logo .yk2{color:var(--blue);text-shadow:0 0 15px rgba(0,212,255,.6)}
.nav-logo .gam{color:#fff}
.nav-links{display:flex;gap:28px;list-style:none}
.nav-links a{color:var(--muted);text-decoration:none;font-size:.9rem;font-weight:500;transition:.3s;font-family:'Rajdhani',sans-serif;letter-spacing:1px}
.nav-links a:hover{color:var(--blue)}
.hamburger{display:none;flex-direction:column;gap:5px;cursor:pointer;background:none;border:none}
.hamburger span{display:block;width:24px;height:2px;background:#fff;transition:.3s}
.mob-menu{display:none;position:fixed;top:70px;left:0;width:100%;background:rgba(5,5,8,.98);padding:20px;z-index:999;border-bottom:1px solid var(--border)}
.mob-menu.open{display:block}
.mob-menu a{display:block;padding:12px 0;color:var(--muted);text-decoration:none;font-family:'Rajdhani',sans-serif;font-size:1.1rem;letter-spacing:1px;border-bottom:1px solid rgba(255,255,255,.05)}
.mob-menu a:hover{color:var(--blue)}

/* HERO */
#hero{height:100vh;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;position:relative;overflow:hidden;padding:0 20px;background:radial-gradient(ellipse at center,#0d0d2a 0%,var(--bg) 70%)}
.scanlines{position:absolute;inset:0;background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,212,255,.015) 2px,rgba(0,212,255,.015) 4px);pointer-events:none;z-index:1}
.particles{position:absolute;inset:0;overflow:hidden;z-index:0}
.p{position:absolute;border-radius:50%;animation:float linear infinite}
@keyframes float{0%{transform:translateY(100vh) scale(0);opacity:0}10%{opacity:1}90%{opacity:.6}100%{transform:translateY(-100px) scale(1);opacity:0}}
.hero-content{position:relative;z-index:2}
.hero-badge{display:inline-block;padding:6px 16px;background:rgba(0,212,255,.1);border:1px solid rgba(0,212,255,.3);border-radius:20px;font-size:.8rem;letter-spacing:2px;color:var(--blue);font-family:'Rajdhani',sans-serif;margin-bottom:24px}
.hero-h1{font-family:'Orbitron',sans-serif;font-size:clamp(3rem,10vw,7rem);font-weight:900;line-height:1;margin-bottom:16px}
.h1-blue{color:var(--blue);text-shadow:0 0 30px rgba(0,212,255,.7),0 0 60px rgba(0,212,255,.3);display:block}
.h1-white{color:#fff;display:block}
.hero-sub{color:var(--muted);font-size:clamp(.95rem,2vw,1.15rem);max-width:580px;margin:0 auto 36px;line-height:1.7}
.hero-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
.btn-grad{display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:8px;font-weight:600;text-decoration:none;font-family:'Rajdhani',sans-serif;letter-spacing:1px;font-size:1rem;background:linear-gradient(135deg,var(--blue),var(--pink));color:#fff;box-shadow:0 4px 20px rgba(0,212,255,.3);transition:all .3s;border:none;cursor:pointer}
.btn-grad:hover{transform:translateY(-2px);box-shadow:0 8px 30px rgba(0,212,255,.5)}
.btn-out{display:inline-flex;align-items:center;gap:8px;padding:13px 28px;border-radius:8px;font-weight:600;text-decoration:none;font-family:'Rajdhani',sans-serif;letter-spacing:1px;font-size:1rem;background:transparent;color:#fff;border:1px solid rgba(255,255,255,.3);transition:all .3s}
.btn-out:hover{border-color:var(--blue);color:var(--blue);transform:translateY(-2px)}
.hero-corner-left{position:absolute;bottom:30px;left:30px;z-index:2;font-family:'Rajdhani',sans-serif;font-size:.85rem;color:var(--green);letter-spacing:1px;background:rgba(0,255,136,.1);border:1px solid rgba(0,255,136,.3);padding:6px 12px;border-radius:6px}
.hero-corner-right{position:absolute;bottom:30px;right:30px;z-index:2;color:var(--muted);font-size:.85rem;text-decoration:none;transition:.3s}
.hero-corner-right:hover{color:var(--pink)}
.scroll-ind{position:absolute;bottom:80px;left:50%;transform:translateX(-50%);z-index:2;display:flex;flex-direction:column;align-items:center;gap:6px;color:var(--muted);font-size:.75rem}
.arr{width:20px;height:20px;border-right:2px solid var(--blue);border-bottom:2px solid var(--blue);transform:rotate(45deg);animation:bounce .8s infinite alternate}
@keyframes bounce{from{transform:rotate(45deg) translateY(-4px)}to{transform:rotate(45deg) translateY(4px)}}

/* STATS */
#stats{padding:60px 5%;background:rgba(13,13,26,.5)}
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;max-width:1000px;margin:0 auto}
.stat-card{background:rgba(255,255,255,.03);backdrop-filter:blur(10px);border:1px solid var(--border);border-radius:14px;padding:28px 20px;text-align:center;transition:.3s}
.stat-card:hover{border-color:rgba(0,212,255,.4);box-shadow:0 0 20px rgba(0,212,255,.1);transform:translateY(-3px)}
.stat-icon{font-size:2rem;margin-bottom:10px}
.stat-val{font-family:'Orbitron',sans-serif;font-size:1.3rem;font-weight:700;color:var(--blue);margin-bottom:4px}
.stat-lbl{color:var(--muted);font-size:.8rem;line-height:1.4}

/* SECTION COMMON */
.sec{padding:80px 5%}
.sec-head{text-align:center;margin-bottom:50px}
.sec-badge{display:inline-block;padding:5px 14px;border-radius:20px;font-size:.75rem;letter-spacing:2px;font-family:'Rajdhani',sans-serif;margin-bottom:14px}
.badge-live{background:rgba(255,0,0,.1);border:1px solid rgba(255,0,0,.3);color:#ff4444}
.badge-live .dot{display:inline-block;width:7px;height:7px;background:#ff4444;border-radius:50%;margin-right:6px;animation:pulse 1s infinite}
@keyframes pulse{0%,100%{box-shadow:0 0 0 0 rgba(255,68,68,.7)}50%{box-shadow:0 0 0 6px rgba(255,68,68,0)}}
.badge-blue{background:rgba(0,212,255,.1);border:1px solid rgba(0,212,255,.3);color:var(--blue)}
.badge-pink{background:rgba(255,0,128,.1);border:1px solid rgba(255,0,128,.3);color:var(--pink)}
.sec-title{font-family:'Orbitron',sans-serif;font-size:clamp(1.8rem,4vw,2.8rem);font-weight:700;line-height:1.2;margin-bottom:12px}
.sec-sub{color:var(--muted);font-size:.95rem;max-width:560px;margin:0 auto}
.accent-blue{color:var(--blue)}
.accent-pink{color:var(--pink)}

/* STATUS UNIT */
#status{background:var(--bg)}
.grid-units{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:18px;max-width:1100px;margin:0 auto}
.unit-card{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:22px 18px;position:relative;overflow:hidden;transition:.3s}
.unit-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:var(--c);box-shadow:0 0 10px var(--c)}
.unit-card:hover{transform:translateY(-4px);box-shadow:0 8px 30px rgba(0,212,255,.1)}
.unit-name{font-family:'Rajdhani',sans-serif;font-size:1.9rem;font-weight:700;margin-bottom:6px}
.unit-status{font-size:.7rem;font-weight:700;text-transform:uppercase;padding:4px 10px;border-radius:8px;display:inline-block;margin-bottom:14px;letter-spacing:1px;font-family:'Rajdhani',sans-serif}
.timer{font-family:'Orbitron',sans-serif;font-size:1.3rem;font-weight:700;letter-spacing:1px}
.st-avail{--c:var(--green)}.st-avail .unit-status{background:rgba(0,255,136,.12);color:var(--green);box-shadow:0 0 10px rgba(0,255,136,.2)}
.st-occ{--c:var(--blue)}.st-occ .unit-status{background:rgba(0,212,255,.12);color:var(--blue);box-shadow:0 0 10px rgba(0,212,255,.2)}.st-occ .timer{color:var(--blue);text-shadow:0 0 10px rgba(0,212,255,.5)}
.st-warn{--c:var(--orange)}.st-warn .unit-status{background:rgba(255,107,0,.12);color:var(--orange);box-shadow:0 0 10px rgba(255,107,0,.2)}.st-warn .timer{color:var(--orange);animation:blink 1s infinite}
@keyframes blink{50%{opacity:.3}}
.unit-icon{position:absolute;top:16px;right:16px;font-size:1.3rem;opacity:.3}
.auto-note{text-align:center;color:var(--muted);font-size:.8rem;margin-top:20px;max-width:1100px;margin-left:auto;margin-right:auto}

/* PILIHAN UNIT */
#unit{background:rgba(13,13,26,.6)}
.unit-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;max-width:1100px;margin:0 auto}
.ucard{background:var(--card);border:1px solid var(--border);border-radius:16px;padding:26px;transition:.3s;position:relative;overflow:hidden}
.ucard::after{content:'';position:absolute;inset:0;border-radius:16px;opacity:0;transition:.3s;pointer-events:none}
.ucard:hover{transform:translateY(-5px)}.ucard.ps3:hover{border-color:rgba(148,163,184,.5);box-shadow:0 10px 30px rgba(148,163,184,.1)}.ucard.ps4:hover{border-color:rgba(0,212,255,.5);box-shadow:0 10px 30px rgba(0,212,255,.12)}.ucard.ps5:hover{border-color:rgba(168,85,247,.5);box-shadow:0 10px 30px rgba(168,85,247,.12)}
.ucard-head{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px}
.ucard-title{font-family:'Rajdhani',sans-serif;font-size:1.5rem;font-weight:700}
.ps-badge{padding:4px 10px;border-radius:6px;font-size:.75rem;font-weight:700;font-family:'Rajdhani',sans-serif;letter-spacing:1px}
.ps3-b{background:rgba(148,163,184,.15);color:#94a3b8}.ps4-b{background:rgba(0,212,255,.15);color:var(--blue)}.ps5-b{background:rgba(168,85,247,.15);color:var(--purple)}
.ucard-price{color:var(--blue);font-weight:700;font-size:1rem;margin-bottom:14px;font-family:'Rajdhani',sans-serif}
.ucard-ctl{font-size:1.5rem;line-height:1}
.game-list{list-style:none;margin-bottom:20px}
.game-list li{padding:6px 0;color:var(--muted);font-size:.88rem;border-bottom:1px solid rgba(255,255,255,.04);display:flex;align-items:center;gap:8px}
.game-list li::before{content:'🎮';font-size:.7rem;flex-shrink:0}
.ucard-cta{display:block;text-align:center;padding:9px;background:rgba(0,212,255,.08);border:1px solid rgba(0,212,255,.2);border-radius:8px;color:var(--blue);text-decoration:none;font-size:.85rem;font-family:'Rajdhani',sans-serif;letter-spacing:1px;transition:.3s}
.ucard-cta:hover{background:rgba(0,212,255,.15)}

/* GALERI */
#galeri{background:var(--bg)}
.gal-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;max-width:1100px;margin:0 auto}
.gal-item{position:relative;border-radius:12px;overflow:hidden;aspect-ratio:4/3;cursor:pointer}
.gal-item img{width:100%;height:100%;object-fit:cover;transition:.5s}
.gal-item:hover img{transform:scale(1.08)}
.gal-overlay{position:absolute;inset:0;background:rgba(0,0,0,.6);display:flex;align-items:center;justify-content:center;opacity:0;transition:.3s}
.gal-item:hover .gal-overlay{opacity:1}
.gal-overlay span{font-family:'Orbitron',sans-serif;font-size:.9rem;color:#fff;letter-spacing:2px}
.gal-cta{text-align:center;margin-top:30px}

/* LOKASI */
#lokasi{background:rgba(13,13,26,.6)}
.lokasi-wrap{display:grid;grid-template-columns:1fr 1fr;gap:30px;max-width:1000px;margin:0 auto;align-items:start}
.lokasi-info{display:flex;flex-direction:column;gap:22px}
.info-card{background:var(--card);border:1px solid var(--border);border-radius:14px;padding:20px 22px}
.info-card h4{font-family:'Rajdhani',sans-serif;font-size:1.1rem;color:var(--blue);margin-bottom:6px;display:flex;align-items:center;gap:8px}
.info-card p{color:var(--muted);font-size:.9rem;line-height:1.6}
.info-card .btn-wa{display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:9px 18px;background:rgba(0,212,255,.1);border:1px solid rgba(0,212,255,.3);border-radius:8px;color:var(--blue);text-decoration:none;font-size:.85rem;font-family:'Rajdhani',sans-serif;letter-spacing:1px;transition:.3s}
.info-card .btn-wa:hover{background:rgba(0,212,255,.2)}
.info-card .btn-ig{display:inline-flex;align-items:center;gap:6px;margin-top:10px;padding:9px 18px;background:rgba(255,0,128,.1);border:1px solid rgba(255,0,128,.3);border-radius:8px;color:var(--pink);text-decoration:none;font-size:.85rem;font-family:'Rajdhani',sans-serif;letter-spacing:1px;transition:.3s}
.info-card .btn-ig:hover{background:rgba(255,0,128,.2)}
.map-frame{border-radius:14px;overflow:hidden;border:1px solid var(--border)}
.map-frame iframe{display:block;width:100%;height:380px;border:0}

/* TOKEN */
#token{background:linear-gradient(135deg,#07071a 0%,#0d0d1a 100%);position:relative}
#token::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(0,212,255,.03) 1px,transparent 1px),linear-gradient(90deg,rgba(0,212,255,.03) 1px,transparent 1px);background-size:40px 40px;pointer-events:none}
.token-wrap{position:relative;z-index:1;max-width:500px;margin:0 auto}
.token-intro{text-align:center;color:var(--muted);margin-bottom:30px;line-height:1.8;font-size:.95rem}
.token-card{background:rgba(255,255,255,.03);backdrop-filter:blur(10px);border:1px solid rgba(0,212,255,.2);border-radius:18px;padding:32px;position:relative;overflow:hidden;box-shadow:0 0 40px rgba(0,212,255,.05)}
.token-card::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--blue),var(--pink))}
.form-group{margin-bottom:18px}
.form-input{width:100%;padding:17px;background:rgba(0,0,0,.5);border:1px solid rgba(0,212,255,.2);border-radius:10px;color:#fff;font-size:1.2rem;text-align:center;text-transform:uppercase;letter-spacing:4px;font-family:'Orbitron',sans-serif;font-weight:700;transition:.3s}
.form-input:focus{border-color:var(--blue);outline:none;box-shadow:0 0 20px rgba(0,212,255,.15)}
.form-input::placeholder{color:#333;letter-spacing:2px;font-size:.9rem}
.btn-cek{width:100%;padding:15px;font-size:1.1rem;font-family:'Rajdhani',sans-serif;font-weight:700;letter-spacing:2px}
.token-result{display:none;margin-top:22px;padding:22px;background:rgba(0,212,255,.04);border:1px solid rgba(0,212,255,.15);border-radius:12px;animation:slideUp .4s ease}
@keyframes slideUp{from{opacity:0;transform:translateY(15px)}to{opacity:1;transform:translateY(0)}}
.res-header{text-align:center;font-family:'Orbitron',sans-serif;font-size:1.1rem;color:var(--blue);margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid rgba(0,212,255,.15)}
.res-row{display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px dashed rgba(255,255,255,.05);font-size:.88rem}
.res-row:last-of-type{border-bottom:none}
.res-lbl{color:var(--muted)}.res-val{font-weight:600;color:#fff}.res-val.mono{font-family:'Orbitron',sans-serif;color:var(--blue);font-size:.95rem;letter-spacing:1px}
.error-msg{display:none;margin-top:16px;padding:12px;background:rgba(255,0,128,.08);border:1px solid rgba(255,0,128,.2);border-radius:8px;color:var(--pink);font-size:.88rem;text-align:center;animation:slideUp .3s ease}
.btn-pdf{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;padding:12px;margin-top:16px;background:transparent;border:1px solid rgba(0,212,255,.3);border-radius:8px;color:var(--blue);font-family:'Rajdhani',sans-serif;font-size:.95rem;letter-spacing:1px;cursor:pointer;transition:.3s}
.btn-pdf:hover{background:rgba(0,212,255,.1)}

/* FOOTER */
footer{background:#020204;padding:60px 5% 30px;border-top:1px solid;border-image:linear-gradient(90deg,var(--blue),var(--pink)) 1}
.footer-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:40px;margin-bottom:40px}
.footer-logo{font-family:'Orbitron',sans-serif;font-size:1.5rem;font-weight:900;margin-bottom:12px}
.footer-logo .yk2{color:var(--blue);text-shadow:0 0 10px rgba(0,212,255,.5)}
.footer-desc{color:var(--muted);font-size:.88rem;line-height:1.7}
.footer-title{font-family:'Rajdhani',sans-serif;font-size:1rem;letter-spacing:2px;color:var(--blue);margin-bottom:14px}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:8px}
.footer-links a{color:var(--muted);text-decoration:none;font-size:.88rem;transition:.3s}
.footer-links a:hover{color:var(--blue)}
.footer-contact{display:flex;flex-direction:column;gap:10px}
.footer-contact a{color:var(--muted);text-decoration:none;font-size:.88rem;display:flex;align-items:center;gap:8px;transition:.3s}
.footer-contact a:hover{color:var(--blue)}
.footer-bottom{text-align:center;padding-top:24px;border-top:1px solid rgba(255,255,255,.05);color:var(--muted);font-size:.8rem}

/* FADE IN ANIMATION */
.fade-in{opacity:0;transform:translateY(30px);transition:opacity .7s ease,transform .7s ease}
.fade-in.visible{opacity:1;transform:translateY(0)}

/* RESPONSIVE */
@media(max-width:900px){
  .stats-grid{grid-template-columns:repeat(2,1fr)}
  .unit-grid{grid-template-columns:repeat(2,1fr)}
  .lokasi-wrap{grid-template-columns:1fr}
  .footer-grid{grid-template-columns:1fr}
}
@media(max-width:600px){
  .nav-links{display:none}
  .hamburger{display:flex}
  .unit-grid{grid-template-columns:1fr}
  .gal-grid{grid-template-columns:1fr}
  .stats-grid{grid-template-columns:1fr 1fr}
  .grid-units{grid-template-columns:repeat(2,1fr)}
}
@media print{body *{visibility:hidden}.token-result,.token-result *{visibility:visible}.token-result{position:absolute;left:0;top:0;width:100%;background:#fff;color:#000;padding:20px}}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="nav" id="navbar">
  <a href="#" class="nav-logo"><span class="yk2">YK2</span><span class="gam"> GAMING</span></a>
  <ul class="nav-links">
    <li><a href="#status">Status</a></li>
    <li><a href="#unit">Unit</a></li>
    <li><a href="#galeri">Galeri</a></li>
    <li><a href="#lokasi">Lokasi</a></li>
    <li><a href="#token">Cek Token</a></li>
  </ul>
  <button class="hamburger" id="hamburger" aria-label="Menu">
    <span></span><span></span><span></span>
  </button>
</nav>
<div class="mob-menu" id="mob-menu">
  <a href="#status" onclick="closeMob()">Status Unit</a>
  <a href="#unit" onclick="closeMob()">Pilihan Unit</a>
  <a href="#galeri" onclick="closeMob()">Galeri</a>
  <a href="#lokasi" onclick="closeMob()">Lokasi</a>
  <a href="#token" onclick="closeMob()">Cek Token</a>
</div>

<!-- HERO -->
<section id="hero">
  <div class="scanlines"></div>
  <div class="particles" id="particles"></div>
  <div class="hero-content fade-in">
    <div class="hero-badge">🎮 RENTAL PS TERBAIK DI MANADO</div>
    <h1 class="hero-h1">
      <span class="h1-blue">LEVEL UP</span>
      <span class="h1-white">YOUR GAME</span>
    </h1>
    <p class="hero-sub">Main PS3, PS4, PS5 dengan game terupdate. Harga terjangkau, vibes maksimal.</p>
    <div class="hero-btns">
      <a href="#status" class="btn-grad">Lihat Status Unit →</a>
      <a href="https://wa.me/6281235374566" target="_blank" class="btn-out">Hubungi Kami</a>
    </div>
  </div>
  <div class="hero-corner-left">● OPEN 09.00 – 23.00</div>
  <a href="https://www.instagram.com/yk2.gaming/" target="_blank" class="hero-corner-right">📸 @yk2.gaming</a>
  <div class="scroll-ind"><div class="arr"></div><span>SCROLL</span></div>
</section>

<!-- STATS -->
<section id="stats" class="fade-in">
  <div class="stats-grid">
    <div class="stat-card"><div class="stat-icon">🎮</div><div class="stat-val">5 UNIT</div><div class="stat-lbl">PS3, PS4 &amp; PS5<br>Siap Dipakai</div></div>
    <div class="stat-card"><div class="stat-icon">⚡</div><div class="stat-val">UPDATED</div><div class="stat-lbl">Game Selalu Update<br>Tiap Bulan</div></div>
    <div class="stat-card"><div class="stat-icon">💰</div><div class="stat-val">10K/JAM</div><div class="stat-lbl">Harga Bersahabat<br>Mulai Rp 8.000</div></div>
    <div class="stat-card"><div class="stat-icon">🕐</div><div class="stat-val">TIAP HARI</div><div class="stat-lbl">Buka 09.00 – 23.00<br>Termasuk Hari Libur</div></div>
  </div>
</section>

<!-- STATUS UNIT REAL-TIME -->
<section class="sec" id="status">
  <div class="sec-head fade-in">
    <div class="sec-badge badge-live"><span class="dot"></span>LIVE</div>
    <h2 class="sec-title">STATUS <span class="accent-blue">UNIT</span></h2>
    <p class="sec-sub">Cek ketersediaan unit sebelum datang — update otomatis tiap 30 detik</p>
  </div>
  <div class="grid-units fade-in" id="unit-grid">
    <div style="grid-column:1/-1;text-align:center;color:var(--muted);padding:40px;font-family:'Orbitron',sans-serif;font-size:.9rem;letter-spacing:2px">MEMUAT DATA...</div>
  </div>
  <p class="auto-note fade-in">🔄 Data diperbarui otomatis setiap 30 detik</p>
</section>

<!-- PILIHAN UNIT -->
<section class="sec" id="unit">
  <div class="sec-head fade-in">
    <div class="sec-badge badge-blue">KONSOL</div>
    <h2 class="sec-title">PILIHAN <span class="accent-blue">UNIT</span> KAMI</h2>
    <p class="sec-sub">Setiap unit dilengkapi game terlengkap dan terupdate</p>
  </div>
  <div class="unit-grid fade-in">
    <div class="ucard ps3">
      <div class="ucard-head"><div><div class="ucard-title">PS3 Unit 1</div><div class="ucard-price">Rp 8.000 / jam</div></div><div><span class="ucard-ctl">🎮</span><br><span class="ps-badge ps3-b">PS3</span></div></div>
      <ul class="game-list"><li>eFootball PES 2019</li><li>Grand Theft Auto V</li><li>God of War 3</li><li>Mortal Kombat</li><li>Tekken 6</li><li>WWE 2K19</li></ul>
      <a href="#status" class="ucard-cta">Cek Ketersediaan →</a>
    </div>
    <div class="ucard ps3">
      <div class="ucard-head"><div><div class="ucard-title">PS3 Unit 2</div><div class="ucard-price">Rp 8.000 / jam</div></div><div><span class="ucard-ctl">🎮</span><br><span class="ps-badge ps3-b">PS3</span></div></div>
      <ul class="game-list"><li>eFootball PES 2019</li><li>Grand Theft Auto V</li><li>God of War 3</li><li>Tekken 6</li><li>Naruto Storm 4</li><li>FIFA 19</li></ul>
      <a href="#status" class="ucard-cta">Cek Ketersediaan →</a>
    </div>
    <div class="ucard ps4">
      <div class="ucard-head"><div><div class="ucard-title">PS4 Unit 3</div><div class="ucard-price">Rp 10.000 / jam</div></div><div><span class="ucard-ctl">🕹️</span><br><span class="ps-badge ps4-b">PS4</span></div></div>
      <ul class="game-list"><li>eFootball PES 2025</li><li>Grand Theft Auto V</li><li>Mortal Kombat 11</li><li>Spider-Man</li><li>God of War</li><li>UFC 4</li></ul>
      <a href="#status" class="ucard-cta">Cek Ketersediaan →</a>
    </div>
    <div class="ucard ps4">
      <div class="ucard-head"><div><div class="ucard-title">PS4 Unit 4</div><div class="ucard-price">Rp 10.000 / jam</div></div><div><span class="ucard-ctl">🕹️</span><br><span class="ps-badge ps4-b">PS4</span></div></div>
      <ul class="game-list"><li>EA FC 25</li><li>Grand Theft Auto V</li><li>Mortal Kombat 11</li><li>Spider-Man Miles Morales</li><li>Tekken 7</li><li>Red Dead Redemption 2</li></ul>
      <a href="#status" class="ucard-cta">Cek Ketersediaan →</a>
    </div>
    <div class="ucard ps5">
      <div class="ucard-head"><div><div class="ucard-title">PS5 Unit 64</div><div class="ucard-price">Rp 20.000 / jam</div></div><div><span class="ucard-ctl">✨</span><br><span class="ps-badge ps5-b">PS5</span></div></div>
      <ul class="game-list"><li>EA FC 25</li><li>GTA V Enhanced</li><li>Spider-Man 2</li><li>God of War Ragnarök</li><li>Mortal Kombat 1</li><li>UFC 5</li></ul>
      <a href="#status" class="ucard-cta">Cek Ketersediaan →</a>
    </div>
  </div>
</section>

<!-- GALERI -->
<section class="sec" id="galeri">
  <div class="sec-head fade-in">
    <div class="sec-badge badge-pink">FOTO ASLI</div>
    <h2 class="sec-title">SUASANA <span class="accent-pink">YK2 GAMING</span></h2>
    <p class="sec-sub">Vibes yang nyata, langsung dari tempat kami</p>
  </div>
  <div class="gal-grid fade-in">
    <div class="gal-item">
      <img src="img/gaming_room.webp" alt="Ruangan Gaming YK2 dengan LED biru dan dua TV" loading="lazy">
      <div class="gal-overlay"><span>GAMING ROOM</span></div>
    </div>
    <div class="gal-item">
      <img src="img/ps4_pes.webp" alt="PS4 dengan PES 2025 di YK2 Gaming" loading="lazy">
      <div class="gal-overlay"><span>PS4 — PES 2025</span></div>
    </div>
    <div class="gal-item">
      <img src="img/exterior_night.png" alt="Tampak luar YK2 Gaming malam hari dengan LED warna-warni" loading="lazy">
      <div class="gal-overlay"><span>TAMPAK LUAR</span></div>
    </div>
    <div class="gal-item" style="grid-column:span 3">
      <img src="img/exterior_day.webp" alt="Tampak luar YK2 Gaming siang hari" loading="lazy" style="max-height:320px;width:100%;object-fit:cover">
      <div class="gal-overlay"><span>AREA SANTAI</span></div>
    </div>
  </div>
  <div class="gal-cta fade-in">
    <a href="https://www.instagram.com/yk2.gaming/" target="_blank" class="btn-out" style="display:inline-flex">📸 Follow @yk2.gaming di Instagram →</a>
  </div>
</section>

<!-- LOKASI -->
<section class="sec" id="lokasi">
  <div class="sec-head fade-in">
    <div class="sec-badge badge-blue">LOKASI</div>
    <h2 class="sec-title">TEMUKAN <span class="accent-blue">KAMI</span></h2>
  </div>
  <div class="lokasi-wrap fade-in">
    <div class="lokasi-info">
      <div class="info-card"><h4>📍 Alamat</h4><p>Manado, Sulawesi Utara<br>Teling Atas, Wanea</p></div>
      <div class="info-card"><h4>🕐 Jam Buka</h4><p>Setiap Hari — 09.00 sampai 23.00 WITA</p></div>
      <div class="info-card">
        <h4>📱 WhatsApp</h4><p>0812-3537-4566</p>
        <a href="https://wa.me/6281235374566" target="_blank" class="btn-wa">💬 Chat WhatsApp</a>
      </div>
      <div class="info-card">
        <h4>📸 Instagram</h4><p>@yk2.gaming</p>
        <a href="https://www.instagram.com/yk2.gaming/" target="_blank" class="btn-ig">📸 Buka Instagram</a>
      </div>
    </div>
    <div class="map-frame fade-in">
      <iframe src="https://maps.google.com/maps?q=1.5084685,124.8929679&z=17&output=embed" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

<!-- CEK TOKEN -->
<section class="sec" id="token">
  <div class="sec-head fade-in">
    <div class="sec-badge badge-blue">FITUR</div>
    <h2 class="sec-title">PUNYA SISA JAM MAIN? <span class="accent-blue">🎮</span></h2>
  </div>
  <div class="token-wrap fade-in">
    <p class="token-intro">Mau simpan sisa jam mainmu? Gampang banget!<br>Tinggal minta token ke kasir di admin, terus masukin kodenya di sini.<br><strong style="color:var(--blue)">Sisa jammu aman tersimpan selama 30 hari. 🔒</strong></p>
    <div class="token-card">
      <form id="token-form">
        <div class="form-group">
          <input type="text" id="token-input" class="form-input" placeholder="YK2-XXXX" maxlength="8" required autocomplete="off">
        </div>
        <button type="submit" class="btn-grad btn-cek" id="btn-cek">CEK TOKEN</button>
      </form>
      <div id="token-error" class="error-msg"></div>
      <div id="token-result" class="token-result">
        <div class="res-header">YK2 GAMING — STRUK TOKEN</div>
        <div class="res-row"><span class="res-lbl">Kode Token</span><span class="res-val mono" id="res-code"></span></div>
        <div class="res-row"><span class="res-lbl">Pelanggan</span><span class="res-val" id="res-cust"></span></div>
        <div class="res-row"><span class="res-lbl">Unit Terakhir</span><span class="res-val" id="res-unit"></span></div>
        <div class="res-row"><span class="res-lbl">Sisa Waktu</span><span class="res-val" id="res-time" style="color:var(--green)"></span></div>
        <div class="res-row"><span class="res-lbl">Kedaluwarsa</span><span class="res-val" id="res-exp" style="color:var(--pink);font-size:.82rem"></span></div>
        <button class="btn-pdf" id="btn-download-pdf">⬇️ Download Struk PDF</button>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div class="footer-grid">
    <div>
      <div class="footer-logo"><span class="yk2">YK2</span> GAMING</div>
      <p class="footer-desc">Rental PS terbaik di Manado dengan game terupdate. PS3, PS4, dan PS5 tersedia dengan harga terjangkau.</p>
    </div>
    <div>
      <div class="footer-title">QUICK LINKS</div>
      <ul class="footer-links">
        <li><a href="#status">Status Unit Live</a></li>
        <li><a href="#unit">Pilihan Unit</a></li>
        <li><a href="#galeri">Galeri</a></li>
        <li><a href="#lokasi">Lokasi</a></li>
        <li><a href="#token">Cek Token</a></li>
      </ul>
    </div>
    <div>
      <div class="footer-title">KONTAK</div>
      <div class="footer-contact">
        <a href="https://wa.me/6281235374566" target="_blank">💬 0812-3537-4566</a>
        <a href="https://www.instagram.com/yk2.gaming/" target="_blank">📸 @yk2.gaming</a>
        <a href="#lokasi">📍 Manado, Sulawesi Utara</a>
        <a href="#">🕐 09.00 – 23.00 WITA</a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">© 2026 YK2 Gaming — Manado. Dibuat dengan ❤️ untuk para gamer Manado</div>
</footer>

<script>
// NAVBAR SCROLL
const nav=document.getElementById('navbar');
window.addEventListener('scroll',()=>nav.classList.toggle('solid',window.scrollY>50));

// HAMBURGER
const hbg=document.getElementById('hamburger');const mob=document.getElementById('mob-menu');
hbg.addEventListener('click',()=>mob.classList.toggle('open'));
function closeMob(){mob.classList.remove('open')}

// PARTICLES
(function(){
  const c=document.getElementById('particles');
  const cols=['rgba(0,212,255,','rgba(255,0,128,','rgba(0,255,136,','rgba(168,85,247,'];
  for(let i=0;i<25;i++){
    const p=document.createElement('div');p.className='p';
    const s=Math.random()*4+2;const col=cols[Math.floor(Math.random()*cols.length)];
    p.style.cssText=`left:${Math.random()*100}%;width:${s}px;height:${s}px;background:${col}0.6);animation-duration:${Math.random()*15+8}s;animation-delay:${Math.random()*10}s`;
    c.appendChild(p);
  }
})();

// INTERSECTION OBSERVER
new IntersectionObserver((entries)=>{entries.forEach(e=>{if(e.isIntersecting)e.target.classList.add('visible')})},{threshold:0.1})
  .observe.call(new IntersectionObserver(()=>{}),document.createElement('div'));
(()=>{const io=new IntersectionObserver((entries)=>{entries.forEach(e=>{if(e.isIntersecting)e.target.classList.add('visible')})},{threshold:0.1});document.querySelectorAll('.fade-in').forEach(el=>io.observe(el))})();

// TIMER HELPERS
function formatTime(s){if(s<=0)return'00:00:00';const h=Math.floor(s/3600),m=Math.floor((s%3600)/60),sc=Math.floor(s%60);return`${String(h).padStart(2,'0')}:${String(m).padStart(2,'0')}:${String(sc).padStart(2,'0')}`}
function parseDate(s){if(!s)return new Date();return new Date(s.replace(' ','T'))}

// TIMER ENGINE
function updateTimers(){
  const now=new Date();
  document.querySelectorAll('.timer[data-end]').forEach(el=>{
    const dur=parseInt(el.getAttribute('data-dur'));
    if(dur===0){el.innerText='OPEN';return}
    const diff=Math.floor((parseDate(el.getAttribute('data-end'))-now)/1000);
    el.innerText=diff>0?formatTime(diff):'00:00:00';
    const card=el.closest('.unit-card');
    if(diff<300&&!card.classList.contains('st-warn')){card.className='unit-card st-warn';card.querySelector('.unit-status').innerText='Warning'}
  });
}

// FETCH & RENDER
let unitsData=[],sessionsData=[];
async function fetchStatus(){
  try{
    const d=await(await fetch('api.php?action=fetch_all&t='+Date.now())).json();
    unitsData=(d.units||[]).filter(u=>u.mode==='ps');
    sessionsData=d.sessions||[];
    renderGrid();
  }catch(e){console.error(e)}
}
function renderGrid(){
  const grid=document.getElementById('unit-grid');grid.innerHTML='';
  unitsData.forEach(u=>{
    const sess=sessionsData.find(s=>s.unit_id===u.id);
    let stCls='st-avail',stTxt='Available',timer=`<div class="timer" style="color:var(--muted);font-family:'Orbitron',sans-serif">--:--:--</div>`;
    if(sess){
      const dur=parseInt(sess.duration_minutes);
      if(dur===0){stCls='st-occ';stTxt='Occupied';timer=`<div class="timer" data-end="${sess.end_time}" data-dur="0" style="font-family:'Orbitron',sans-serif">OPEN</div>`}
      else{
        const diff=Math.floor((parseDate(sess.end_time)-new Date())/1000);
        stCls=diff<300?'st-warn':'st-occ';stTxt=diff<=0?'Habis':diff<300?'Warning':'Occupied';
        timer=`<div class="timer" data-end="${sess.end_time}" data-dur="${dur}" style="font-family:'Orbitron',sans-serif">${formatTime(diff)}</div>`;
      }
    }
    const card=document.createElement('div');card.className=`unit-card ${stCls}`;
    card.innerHTML=`<span class="unit-icon">🎮</span><div class="unit-name">${u.tipe} ${u.nomor}</div><div class="unit-status">${stTxt}</div>${timer}`;
    grid.appendChild(card);
  });
  updateTimers();
}
fetchStatus();setInterval(fetchStatus,30000);setInterval(updateTimers,1000);

// CEK TOKEN
document.getElementById('token-form').addEventListener('submit',async(e)=>{
  e.preventDefault();
  const inp=document.getElementById('token-input');
  let code=inp.value.trim().toUpperCase();
  if(code.length===4&&!code.startsWith('YK2-'))code='YK2-'+code;
  inp.value=code;
  const err=document.getElementById('token-error'),res=document.getElementById('token-result'),btn=document.getElementById('btn-cek');
  err.style.display='none';res.style.display='none';
  if(!code.startsWith('YK2-')||code.length!==8){err.innerText='Format tidak valid! Contoh: YK2-ABCD';err.style.display='block';return}
  try{
    btn.textContent='Mengecek...';btn.disabled=true;btn.style.opacity='.7';
    const fd=new FormData();fd.append('action','get_token_detail');fd.append('token_code',code);
    const data=await(await fetch('api.php',{method:'POST',body:fd})).json();
    if(data.error){err.innerText=data.error;err.style.display='block'}
    else{
      document.getElementById('res-code').innerText=data.token_code;
      document.getElementById('res-cust').innerText=data.customer_name;
      document.getElementById('res-unit').innerText=data.unit_name;
      const rm=data.remaining_minutes,h=Math.floor(rm/60),m=rm%60;
      document.getElementById('res-time').innerText=h>0?`${h} Jam ${m} Menit`:`${m} Menit`;
      const exp=new Date(data.expired_at.replace(' ','T'));
      document.getElementById('res-exp').innerText=exp.toLocaleString('id-ID',{day:'2-digit',month:'short',year:'numeric',hour:'2-digit',minute:'2-digit'});
      res.style.display='block';
      document.getElementById('btn-download-pdf').onclick=()=>window.location.href='generate_pdf.php?token_code='+encodeURIComponent(data.token_code);
    }
  }catch(e){err.innerText='Terjadi kesalahan jaringan!';err.style.display='block'}
  finally{btn.textContent='CEK TOKEN';btn.disabled=false;btn.style.opacity='1'}
});

// INPUT AUTO UPPERCASE
document.getElementById('token-input').addEventListener('input',function(){this.value=this.value.toUpperCase()});
</script>
</body>
</html>
