<?php require_once 'session_check.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Cache-Control" content="post-check=0, pre-check=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>YK2 Gaming Admin Panel</title>

  <!-- Backend: api.php (MySQL via XAMPP) -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link
    href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=DM+Sans:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap"
    rel="stylesheet">

  <style>
    /* -- VARIABLES  -- */
    :root {
      --bg: #06080f;
      --surface: #0b0e18;
      --surface2: #10141f;
      --surface3: #151b28;
      --border: #1a2035;
      --border2: #222a3f;
      --ps: #e63950;
      --ps-glow: rgba(230, 57, 80, .25);
      --ps-dim: rgba(230, 57, 80, .11);
      --pc: #3b82f6;
      --pc-glow: rgba(59, 130, 246, .25);
      --pc-dim: rgba(59, 130, 246, .11);
      --gold: #f59e0b;
      --green: #10b981;
      --amber: #f97316;
      --purple: #a78bfa;
      --text: #e2e8f0;
      --muted: #3d4d6b;
      --muted2: #637089;
      --ac: var(--ps);
      --ac-glow: var(--ps-glow);
      --ac-dim: var(--ps-dim);
      --sidebar-w: 240px;
    }

    body.mode-pc {
      --ac: var(--pc);
      --ac-glow: var(--pc-glow);
      --ac-dim: var(--pc-dim);
    }

    /* -- RESET  -- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box
    }

    html {
      scroll-behavior: smooth
    }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      overflow-x: hidden
    }

    body::before {
      content: '';
      position: fixed;
      inset: 0;
      pointer-events: none;
      z-index: 0;
      background: radial-gradient(ellipse 60% 50% at -5% 5%, rgba(230, 57, 80, .06), transparent 55%),
        radial-gradient(ellipse 50% 60% at 105% 95%, rgba(59, 130, 246, .05), transparent 55%);
      transition: background .6s
    }

    button {
      cursor: pointer;
      font-family: 'DM Sans', sans-serif
    }

    input,
    select,
    textarea {
      font-family: 'DM Sans', sans-serif
    }

    a {
      text-decoration: none
    }

    /* -- LAYOUT  -- */
    .app {
      display: flex;
      min-height: 100vh;
      position: relative;
      z-index: 1
    }

    /* -- SIDEBAR  -- */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--surface);
      border-right: 1px solid var(--border);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      z-index: 200;
      transition: transform .3s cubic-bezier(.4, 0, .2, 1);
    }

    .sidebar-logo {
      padding: 22px 20px 16px;
      border-bottom: 1px solid var(--border)
    }

    .logo-name {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.75rem;
      letter-spacing: 3px;
      line-height: 1
    }

    .logo-name span {
      color: var(--ac);
      transition: color .4s
    }

    .logo-sub {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 4px
    }

    .logo-sub-txt {
      font-size: .62rem;
      color: var(--muted2);
      letter-spacing: 2px;
      text-transform: uppercase
    }

    .logo-ver {
      font-size: .58rem;
      background: rgba(167, 139, 250, .15);
      color: var(--purple);
      border: 1px solid rgba(167, 139, 250, .3);
      padding: 2px 7px;
      border-radius: 4px;
      letter-spacing: 1px
    }

    .mode-switcher {
      display: flex;
      margin: 14px 14px 6px;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 10px;
      overflow: hidden
    }

    .mode-btn {
      flex: 1;
      padding: 9px 8px;
      border: none;
      background: transparent;
      color: var(--muted2);
      font-family: 'Bebas Neue', sans-serif;
      font-size: .95rem;
      letter-spacing: 2px;
      transition: all .25s
    }

    .mode-btn.active {
      color: #fff
    }

    .mode-btn.ps-btn.active {
      background: var(--ps);
      border-radius: 8px
    }

    .mode-btn.pc-btn.active {
      background: var(--pc);
      border-radius: 8px
    }

    .mode-sub {
      text-align: center;
      font-size: .62rem;
      color: var(--muted);
      letter-spacing: 1px;
      margin-bottom: 12px;
      text-transform: uppercase
    }

    .nav-sec {
      padding: 12px 20px 5px;
      font-size: .6rem;
      color: var(--muted);
      text-transform: uppercase;
      letter-spacing: 2px
    }

    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 10px 20px;
      font-size: .84rem;
      color: var(--muted2);
      transition: all .2s;
      border-left: 3px solid transparent;
      position: relative;
      cursor: pointer;
    }

    .nav-item:hover {
      color: var(--text);
      background: rgba(255, 255, 255, .025)
    }

    .nav-item.active {
      color: var(--ac);
      border-left-color: var(--ac);
      background: var(--ac-dim);
      transition: color .4s, border-color .4s, background .4s
    }

    .nav-icon {
      font-size: 1rem;
      width: 20px;
      text-align: center;
      flex-shrink: 0
    }

    .nav-badge {
      margin-left: auto;
      background: var(--purple);
      color: #fff;
      font-size: .62rem;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 10px;
      min-width: 20px;
      text-align: center;
      display: none;
    }

    .nav-badge.show {
      display: inline-block
    }

    .nav-badge.amber {
      background: var(--amber);
      color: #000
    }

    .sidebar-bottom {
      margin-top: auto;
      padding: 14px 20px;
      border-top: 1px solid var(--border);
      font-size: .7rem;
      color: var(--muted)
    }

    .conn-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 6px
    }

    .dot-online {
      display: inline-block;
      width: 7px;
      height: 7px;
      background: var(--green);
      border-radius: 50%;
      animation: blink 2s infinite;
      margin-right: 5px
    }

    .dot-offline {
      display: inline-block;
      width: 7px;
      height: 7px;
      background: var(--amber);
      border-radius: 50%;
      margin-right: 5px
    }

    .dot-demo {
      display: inline-block;
      width: 7px;
      height: 7px;
      background: var(--purple);
      border-radius: 50%;
      margin-right: 5px;
      animation: blink 3s infinite
    }

    .btn-settings {
      background: rgba(255, 255, 255, .05);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 5px 10px;
      font-size: .72rem;
      color: var(--muted2);
      display: flex;
      align-items: center;
      gap: 5px;
      transition: all .2s;
    }

    .btn-settings:hover {
      border-color: var(--border2);
      color: var(--text)
    }

    /* - OVERLAY (mobile sidebar) - */
    #sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .7);
      z-index: 150;
      backdrop-filter: blur(2px)
    }

    #sidebar-overlay.show {
      display: block
    }

    /* -- MAIN  -- */
    .main {
      flex: 1;
      padding: 30px 32px;
      margin-left: var(--sidebar-w);
      min-height: 100vh
    }

    /* -- MOBILE HEADER  -- */
    .mob-header {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 100;
      background: rgba(11, 14, 24, .92);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border);
      padding: 12px 16px;
      align-items: center;
      gap: 12px;
    }

    .mob-logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.4rem;
      letter-spacing: 3px;
      flex: 1
    }

    .mob-logo span {
      color: var(--ac);
      transition: color .4s
    }

    .mob-mode-toggle {
      display: flex;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 8px;
      overflow: hidden
    }

    .mob-mbtn {
      padding: 6px 12px;
      border: none;
      background: transparent;
      font-family: 'Bebas Neue', sans-serif;
      font-size: .82rem;
      letter-spacing: 1px;
      color: var(--muted2);
      transition: all .2s
    }

    .mob-mbtn.active {
      color: #fff
    }

    .mob-mbtn.mob-ps.active {
      background: var(--ps)
    }

    .mob-mbtn.mob-pc.active {
      background: var(--pc)
    }

    .ham-btn {
      width: 38px;
      height: 38px;
      border: 1px solid var(--border2);
      background: var(--surface2);
      border-radius: 8px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 5px;
    }

    .ham-btn span {
      display: block;
      width: 18px;
      height: 2px;
      background: var(--muted2);
      border-radius: 2px;
      transition: all .3s
    }

    /* - BOTTOM NAV (mobile) - */
    .bottom-nav {
      display: none;
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      z-index: 100;
      background: rgba(11, 14, 24, .97);
      backdrop-filter: blur(14px);
      border-top: 1px solid var(--border);
      padding: 4px 0 env(safe-area-inset-bottom);
    }

    .bottom-nav-inner {
      display: flex
    }

    .bnav-item {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 8px 4px 4px;
      gap: 3px;
      font-size: .62rem;
      color: var(--muted);
      transition: color .2s;
      cursor: pointer;
      position: relative;
    }

    .bnav-item.active {
      color: var(--ac)
    }

    .bnav-item .bnav-line {
      position: absolute;
      top: 0;
      left: 10%;
      right: 10%;
      height: 2px;
      background: var(--ac);
      border-radius: 0 0 3px 3px;
      opacity: 0;
      transition: opacity .2s
    }

    .bnav-item.active .bnav-line {
      opacity: 1
    }

    .bnav-icon {
      font-size: 1.25rem;
      line-height: 1
    }

    .bnav-badge {
      position: absolute;
      top: 4px;
      right: 50%;
      transform: translateX(120%);
      background: var(--purple);
      color: #fff;
      font-size: .55rem;
      font-weight: 700;
      width: 16px;
      height: 16px;
      border-radius: 50%;
      display: none;
      align-items: center;
      justify-content: center;
    }

    .bnav-badge.show {
      display: flex
    }

    /* -- PAGES  -- */
    .page {
      display: none
    }

    .page.active {
      display: block
    }

    .page-hdr {
      margin-bottom: 24px
    }

    .page-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2rem;
      letter-spacing: 2px;
      line-height: 1
    }

    .page-sub {
      font-size: .8rem;
      color: var(--muted2);
      margin-top: 4px
    }

    .mode-badge {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 4px 14px;
      border-radius: 6px;
      font-size: .7rem;
      font-weight: 700;
      letter-spacing: 1px;
      text-transform: uppercase;
      margin-bottom: 18px;
      transition: all .4s;
    }

    .mode-badge.ps {
      background: var(--ps-dim);
      color: var(--ps);
      border: 1px solid rgba(230, 57, 80, .3)
    }

    .mode-badge.pc {
      background: var(--pc-dim);
      color: var(--pc);
      border: 1px solid rgba(59, 130, 246, .3)
    }

    /* -- STATS  -- */
    .stats-row {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 12px;
      margin-bottom: 24px
    }

    .stat-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 18px 20px;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      gap: 14px;
    }

    .stat-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--c, var(--muted)), transparent);
    }

    .stat-icon-wrap {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, .04);
      border: 1px solid var(--border);
      font-size: 1.2rem;
      flex-shrink: 0;
    }

    .stat-info {
      flex: 1;
      min-width: 0
    }

    .stat-val {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.9rem;
      line-height: 1;
      color: var(--c, var(--text))
    }

    .stat-lbl {
      font-size: .67rem;
      color: var(--muted2);
      text-transform: uppercase;
      letter-spacing: .5px;
      margin-top: 3px
    }

    .s-green {
      --c: var(--green);
      border-color: rgba(16, 185, 129, .2)
    }

    .s-red {
      --c: var(--ps);
      border-color: rgba(230, 57, 80, .2)
    }

    .s-amber {
      --c: var(--amber);
      border-color: rgba(249, 115, 22, .2)
    }

    .s-gold {
      --c: var(--gold);
      border-color: rgba(245, 158, 11, .2)
    }

    .s-blue {
      --c: var(--pc);
      border-color: rgba(59, 130, 246, .2)
    }

    .s-purple {
      --c: var(--purple);
      border-color: rgba(167, 139, 250, .2)
    }

    /* -- SECTION HEADER  -- */
    .sec-hdr {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 16px;
      gap: 10px;
      flex-wrap: wrap
    }

    .sec-lbl {
      font-family: 'Bebas Neue', sans-serif;
      font-size: .95rem;
      letter-spacing: 3px;
      color: var(--muted2)
    }

    /* -- UNIT GRID  -- */
    .grid-units {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(248px, 1fr));
      gap: 14px
    }

    .unit-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 18px;
      position: relative;
      overflow: hidden;
      transition: transform .2s, box-shadow .2s;
    }

    .unit-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, .3)
    }

    .unit-card::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--uc, var(--muted)), transparent);
    }

    .unit-card.available {
      --uc: var(--green);
      border-color: rgba(16, 185, 129, .2)
    }

    .unit-card.occupied {
      --uc: var(--ps);
      border-color: rgba(230, 57, 80, .2)
    }

    .unit-card.occupied.pc-mode {
      --uc: var(--pc);
      border-color: rgba(59, 130, 246, .2)
    }

    .unit-card.warning {
      --uc: var(--amber);
      border-color: rgba(249, 115, 22, .35);
      animation: pulse-warn 2s ease-in-out infinite
    }

    .unit-card.saved {
      --uc: var(--purple);
      border-color: rgba(167, 139, 250, .3)
    }

    @keyframes pulse-warn {

      0%,
      100% {
        box-shadow: 0 0 0 rgba(249, 115, 22, 0)
      }

      50% {
        box-shadow: 0 0 22px rgba(249, 115, 22, .22)
      }
    }

    .card-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 10px
    }

    .unit-num {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.8rem;
      line-height: 1
    }

    .unit-num small {
      display: block;
      font-family: 'DM Sans', sans-serif;
      font-size: .67rem;
      color: var(--muted2);
      letter-spacing: 1px;
      text-transform: uppercase
    }

    .status-chip {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: .7rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: .5px
    }

    .status-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      flex-shrink: 0
    }

    .chip-avail {
      color: var(--green)
    }

    .chip-avail .status-dot {
      background: var(--green);
      box-shadow: 0 0 6px var(--green);
      animation: blink 2s infinite
    }

    .chip-occ {
      color: var(--ps)
    }

    .chip-occ .status-dot {
      background: var(--ps);
      box-shadow: 0 0 6px var(--ps)
    }

    .chip-occ.pc-mode {
      color: var(--pc)
    }

    .chip-occ.pc-mode .status-dot {
      background: var(--pc);
      box-shadow: 0 0 6px var(--pc)
    }

    .chip-warn {
      color: var(--amber)
    }

    .chip-warn .status-dot {
      background: var(--amber);
      box-shadow: 0 0 6px var(--amber);
      animation: blink 1s infinite
    }

    .chip-saved {
      color: var(--purple)
    }

    .chip-saved .status-dot {
      background: var(--purple);
      box-shadow: 0 0 6px var(--purple)
    }

    @keyframes blink {

      0%,
      100% {
        opacity: 1
      }

      50% {
        opacity: .25
      }
    }

    .unit-price {
      font-family: 'JetBrains Mono', monospace;
      font-size: .67rem;
      color: var(--muted2);
      margin-top: 2px
    }

    /* Saved Banner */
    .saved-banner {
      background: rgba(167, 139, 250, .07);
      border: 1px solid rgba(167, 139, 250, .2);
      border-radius: 10px;
      padding: 11px;
      margin-bottom: 10px;
      display: none;
    }

    .saved-ban-title {
      font-size: .64rem;
      font-weight: 700;
      color: var(--purple);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 6px
    }

    .saved-sisa {
      font-family: 'JetBrains Mono', monospace;
      font-size: 1.1rem;
      color: var(--purple);
      font-weight: 700;
      text-align: center;
      margin-top: 4px
    }

    /* Countdown */
    .countdown-block {
      background: rgba(0, 0, 0, .3);
      border-radius: 10px;
      padding: 12px;
      margin-bottom: 10px;
      display: none
    }

    .unit-card.occupied .countdown-block,
    .unit-card.warning .countdown-block {
      display: block
    }

    .sess-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 8px
    }

    .cust-name {
      font-size: .82rem;
      color: var(--text)
    }

    .end-time-lbl {
      font-size: .67rem;
      color: var(--muted2)
    }

    .timer-disp {
      font-family: 'JetBrains Mono', monospace;
      font-size: 1.55rem;
      font-weight: 700;
      text-align: center;
      margin-bottom: 8px;
      letter-spacing: 2px
    }

    .t-ok {
      color: var(--green)
    }

    .t-warn {
      color: var(--amber)
    }

    .t-over {
      color: var(--ps);
      animation: blink .5s infinite
    }

    .prog-bar {
      height: 3px;
      background: var(--border);
      border-radius: 2px;
      overflow: hidden;
      margin-bottom: 6px
    }

    .prog-fill {
      height: 100%;
      border-radius: 2px;
      transition: width 1s linear, background 1s
    }

    .prog-meta {
      display: flex;
      justify-content: space-between;
      font-size: .62rem;
      color: var(--muted)
    }

    /* Card Actions */
    .card-actions {
      display: flex;
      gap: 7px;
      flex-wrap: wrap;
      align-items: stretch
    }

    .cbtn {
      flex: 1;
      padding: 9px 6px;
      border: none;
      border-radius: 8px;
      font-size: .78rem;
      font-weight: 600;
      transition: all .2s;
      min-width: 0
    }

    .cbtn-start {
      background: var(--ac);
      color: #fff;
      transition: background .4s
    }

    .cbtn-start:hover {
      filter: brightness(1.12)
    }

    .cbtn-resume {
      background: rgba(167, 139, 250, .15);
      color: var(--purple);
      border: 1px solid rgba(167, 139, 250, .3)
    }

    .cbtn-resume:hover {
      background: rgba(167, 139, 250, .25)
    }

    .cbtn-add {
      background: rgba(249, 115, 22, .12);
      color: var(--amber);
      border: 1px solid rgba(249, 115, 22, .3);
      
    }

    .cbtn-add:hover {
      background: rgba(249, 115, 22, .22)
    }

    .cbtn-stop {
      background: rgba(255, 255, 255, .06);
      color: var(--muted2);
      border: 1px solid var(--border)
    }

    .cbtn-stop:hover {
      background: rgba(230, 57, 80, .12);
      color: var(--ps);
      border-color: rgba(230, 57, 80, .3)
    }

    .cbtn-save {
      background: rgba(167, 139, 250, .1);
      color: var(--purple);
      border: 1px solid rgba(167, 139, 250, .25);
      flex: 0 0 42px;
      padding: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1rem
    }

    .cbtn-save:hover {
      background: rgba(167, 139, 250, .22)
    }

    .cbtn-clear {
      background: rgba(230, 57, 80, .08);
      color: var(--ps);
      border: 1px solid rgba(230, 57, 80, .2);
      flex: 0;
      padding: 9px 10px
    }

    .cbtn-clear:hover {
      background: rgba(230, 57, 80, .15)
    }

    /* -- TABLE  -- */
    .tbl-wrap {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
      overflow-x: auto
    }

    table {
      width: 100%;
      border-collapse: collapse;
      min-width: 500px
    }

    thead th {
      padding: 12px 16px;
      text-align: left;
      font-size: .67rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      color: var(--muted);
      border-bottom: 1px solid var(--border);
      background: var(--surface2)
    }

    tbody td {
      padding: 12px 16px;
      font-size: .84rem;
      border-bottom: 1px solid var(--border)
    }

    tbody tr:last-child td {
      border-bottom: none
    }

    tbody tr:hover {
      background: rgba(255, 255, 255, .013)
    }

    .mono {
      font-family: 'JetBrains Mono', monospace;
      font-size: .77rem
    }

    .tag-mode {
      font-size: .6rem;
      font-weight: 700;
      padding: 2px 7px;
      border-radius: 4px;
      text-transform: uppercase;
      letter-spacing: 1px
    }

    .tag-ps {
      background: var(--ps-dim);
      color: var(--ps);
      border: 1px solid rgba(230, 57, 80, .25)
    }

    .tag-pc {
      background: var(--pc-dim);
      color: var(--pc);
      border: 1px solid rgba(59, 130, 246, .25)
    }

    .tag-selesai {
      background: rgba(16, 185, 129, 0.12);
      color: var(--green);
      border: 1px solid rgba(16, 185, 129, 0.25);
    }

    .tag-simpan-jam {
      background: rgba(167, 139, 250, 0.12);
      color: var(--purple);
      border: 1px solid rgba(167, 139, 250, 0.25);
    }

    .tag-gray {
      background: rgba(99, 112, 137, 0.12);
      color: var(--muted2);
      border: 1px solid rgba(99, 112, 137, 0.25);
    }

    /* -- LAPORAN  -- */
    .rep-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
      gap: 12px;
      margin-bottom: 24px
    }

    .rep-card {
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 18px 20px
    }

    .rep-lbl {
      font-size: .67rem;
      color: var(--muted2);
      text-transform: uppercase;
      letter-spacing: .5px;
      margin-bottom: 8px
    }

    .rep-val {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.7rem
    }

    /* Bar Chart */
    .bar-row {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 8px
    }

    .bar-lbl {
      font-size: .72rem;
      color: var(--muted2);
      width: 75px;
      flex-shrink: 0;
      text-align: right
    }

    .bar-bg {
      flex: 1;
      height: 9px;
      background: var(--surface2);
      border-radius: 5px;
      overflow: hidden
    }

    .bar-fill {
      height: 100%;
      border-radius: 5px;
      background: linear-gradient(90deg, var(--ac), color-mix(in srgb, var(--ac) 70%, white));
      transition: width .7s ease, background .4s
    }

    .bar-val {
      font-size: .72rem;
      color: var(--text);
      width: 95px;
      flex-shrink: 0;
      font-family: 'JetBrains Mono', monospace
    }

    /* -- SAVED SESSIONS PAGE  -- */
    .saved-list {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 14px
    }

    .saved-card {
      background: var(--surface);
      border: 1px solid rgba(167, 139, 250, .3);
      border-radius: 14px;
      padding: 18px;
      position: relative;
      overflow: hidden;
    }

    .saved-card::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--purple), transparent)
    }

    .sv-head {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 12px
    }

    .sv-unit {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.5rem;
      letter-spacing: 1px;
      color: var(--purple)
    }

    .sv-badge {
      font-size: .62rem;
      background: rgba(167, 139, 250, .15);
      border: 1px solid rgba(167, 139, 250, .3);
      color: var(--purple);
      padding: 3px 8px;
      border-radius: 5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px
    }

    .sv-cust {
      font-size: .84rem;
      margin-bottom: 6px
    }

    .sv-time {
      font-family: 'JetBrains Mono', monospace;
      font-size: 1.8rem;
      color: var(--purple);
      font-weight: 700;
      text-align: center;
      margin: 12px 0
    }

    .sv-meta {
      font-size: .7rem;
      color: var(--muted2);
      text-align: center;
      margin-bottom: 14px
    }

    .sv-actions {
      display: flex;
      gap: 8px
    }

    /* -- MODALS  -- */
    .overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .88);
      z-index: 500;
      align-items: center;
      justify-content: center;
      padding: 16px
    }

    .overlay.show {
      display: flex
    }

    .modal {
      background: var(--surface);
      border: 1px solid var(--border2);
      border-radius: 18px;
      padding: 28px;
      width: 100%;
      max-width: 440px;
      animation: modal-in .22s ease;
      max-height: 92vh;
      overflow-y: auto
    }

    @keyframes modal-in {
      from {
        opacity: 0;
        transform: scale(.93)
      }

      to {
        opacity: 1;
        transform: scale(1)
      }
    }

    .modal-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.4rem;
      letter-spacing: 2px;
      margin-bottom: 18px
    }

    .form-grp {
      margin-bottom: 15px
    }

    .form-lbl {
      display: block;
      font-size: .7rem;
      color: var(--muted2);
      text-transform: uppercase;
      letter-spacing: .5px;
      margin-bottom: 7px
    }

    .form-input,
    .form-sel {
      width: 100%;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: 9px;
      padding: 10px 14px;
      color: var(--text);
      font-size: .9rem;
      outline: none;
      transition: border-color .2s;
    }

    .form-input:focus,
    .form-sel:focus {
      border-color: var(--ac)
    }

    .form-sel option {
      background: var(--surface2)
    }

    .form-input::placeholder {
      color: var(--muted)
    }

    .console-grid {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-bottom: 8px
    }

    .console-btn {
      padding: 7px 16px;
      border: 1px solid var(--border2);
      border-radius: 8px;
      background: var(--surface2);
      color: var(--muted2);
      font-size: .8rem;
      transition: all .2s;
    }

    .console-btn:hover {
      border-color: var(--ac);
      color: var(--text)
    }

    .console-btn.sel-ps3 {
      background: rgba(16, 185, 129, .1);
      border-color: var(--green);
      color: var(--green)
    }

    .console-btn.sel-ps4 {
      background: rgba(139, 92, 246, .12);
      border-color: #a78bfa;
      color: #a78bfa
    }

    .console-btn.sel-ps5 {
      background: rgba(230, 57, 80, .1);
      border-color: var(--ps);
      color: var(--ps)
    }

    .dur-picker {
      display: flex;
      align-items: center;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: 12px;
      overflow: hidden
    }

    .dur-btn {
      width: 52px;
      height: 54px;
      border: none;
      background: transparent;
      color: var(--text);
      font-size: 1.5rem;
      transition: background .2s;
      flex-shrink: 0
    }

    .dur-btn:hover {
      background: rgba(255, 255, 255, .07)
    }

    .dur-val {
      flex: 1;
      text-align: center;
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.1rem;
      color: var(--ac);
      letter-spacing: 2px;
      transition: color .4s;
      border-left: 1px solid var(--border2);
      border-right: 1px solid var(--border2)
    }

    .dur-hint {
      text-align: center;
      font-size: .7rem;
      color: var(--muted);
      margin-top: 7px
    }

    .pkg-grid {
      display: flex;
      gap: 8px;
      flex-wrap: wrap
    }

    .pkg-btn {
      padding: 7px 14px;
      border: 1px solid var(--border2);
      border-radius: 8px;
      background: var(--surface2);
      color: var(--muted2);
      font-size: .8rem;
      transition: all .2s
    }

    .pkg-btn:hover {
      border-color: var(--ac);
      color: var(--text)
    }

    .pkg-btn.sel {
      background: var(--ac-dim);
      border-color: var(--ac);
      color: var(--ac);
      transition: background .4s, border-color .4s
    }

    .total-prev {
      background: rgba(0, 0, 0, .22);
      border: 1px solid var(--border2);
      border-radius: 11px;
      padding: 14px 18px;
      margin-top: 12px;
      display: flex;
      justify-content: space-between;
      align-items: center
    }

    .total-lbl {
      font-size: .78rem;
      color: var(--muted2)
    }

    .total-val {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.6rem;
      color: var(--ac);
      transition: color .4s
    }

    .resume-box {
      background: rgba(167, 139, 250, .06);
      border: 1px solid rgba(167, 139, 250, .2);
      border-radius: 11px;
      padding: 14px 16px;
      margin-bottom: 14px
    }

    .resume-box-title {
      font-size: .64rem;
      font-weight: 700;
      color: var(--purple);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 8px
    }

    .res-row {
      display: flex;
      justify-content: space-between;
      font-size: .83rem;
      margin-bottom: 4px;
      color: var(--muted2)
    }

    .res-row span:last-child {
      color: var(--text);
      font-weight: 600
    }

    .modal-actions {
      display: flex;
      gap: 10px;
      margin-top: 18px
    }

    .mbtn {
      flex: 1;
      padding: 11px;
      border-radius: 9px;
      font-size: .88rem;
      transition: all .2s;
      font-weight: 600;
      border: none
    }

    .mbtn-cancel {
      background: var(--surface2);
      border: 1px solid var(--border2);
      color: var(--muted2)
    }

    .mbtn-cancel:hover {
      color: var(--text)
    }

    .mbtn-ok {
      background: var(--ac);
      color: #fff;
      flex: 2;
      transition: background .4s
    }

    .mbtn-ok:hover {
      filter: brightness(1.12)
    }

    .mbtn-warn {
      background: var(--amber);
      color: #000;
      flex: 2
    }

    .mbtn-warn:hover {
      background: #fba94c
    }

    .mbtn-purple {
      background: var(--purple);
      color: #fff;
      flex: 2
    }

    .mbtn-purple:hover {
      filter: brightness(1.12)
    }

    .mbtn-red {
      background: var(--ps);
      color: #fff;
    }

    .mbtn-red:hover {
      filter: brightness(1.12)
    }

    /* -- STRUK  -- */
    .struk-wrap {
      background: #fff;
      color: #111;
      border-radius: 18px;
      padding: 28px 28px 22px;
      max-width: 360px;
      width: 100%;
      margin: auto;
      text-align: center
    }

    .struk-logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2rem;
      letter-spacing: 3px;
      margin-bottom: 2px
    }

    .struk-logo .sl-c {
      color: var(--ps)
    }

    body.mode-pc .struk-logo .sl-c {
      color: var(--pc)
    }

    .struk-tag {
      font-size: .65rem;
      color: #999;
      letter-spacing: 1px;
      margin-bottom: 4px
    }

    .struk-badge {
      display: inline-block;
      font-size: .65rem;
      font-weight: 700;
      padding: 3px 12px;
      border-radius: 20px;
      margin-bottom: 14px;
      letter-spacing: 1px;
      text-transform: uppercase
    }

    .sb-awal {
      background: #e8f5e9;
      color: #1a7a1a
    }

    .sb-tambah {
      background: #fff3e0;
      color: #e65100
    }

    .sb-resume {
      background: #ede9fe;
      color: #6d28d9
    }

    .struk-hr {
      border: none;
      border-top: 1px dashed #ddd;
      margin: 11px 0
    }

    .struk-row {
      display: flex;
      justify-content: space-between;
      font-size: .84rem;
      margin-bottom: 6px
    }

    .struk-total {
      font-size: 1.1rem;
      font-weight: 700;
      color: #1a7a1a
    }

    body.mode-pc .struk-total {
      color: #1d4ed8
    }

    .struk-note {
      font-size: .68rem;
      color: #aaa;
      margin-top: 10px
    }

    .struk-actions {
      display: flex;
      gap: 10px;
      margin-top: 16px
    }

    .struk-print {
      flex: 1;
      padding: 11px;
      background: #111;
      color: #fff;
      border: none;
      border-radius: 9px;
      font-size: .88rem;
      font-weight: 600
    }

    .struk-close {
      flex: 1;
      padding: 11px;
      background: #f0f0f0;
      color: #444;
      border: none;
      border-radius: 9px;
      font-size: .88rem
    }

    /* -- TOAST  -- */
    #toast-container {
      position: fixed;
      bottom: 24px;
      right: 24px;
      z-index: 9999;
      display: flex;
      flex-direction: column;
      gap: 8px;
      pointer-events: none
    }

    .toast {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 18px;
      border-radius: 12px;
      font-size: .84rem;
      font-weight: 600;
      pointer-events: auto;
      animation: toast-in .3s ease forwards;
      max-width: 310px;
      box-shadow: 0 8px 24px rgba(0, 0, 0, .4);
    }

    .toast.t-ok {
      background: var(--green);
      color: #fff
    }

    .toast.t-err {
      background: var(--ps);
      color: #fff
    }

    .toast.t-info {
      background: var(--amber);
      color: #000
    }

    .toast.t-purple {
      background: var(--purple);
      color: #fff
    }

    @keyframes toast-in {
      from {
        transform: translateX(80px);
        opacity: 0
      }

      to {
        transform: translateX(0);
        opacity: 1
      }
    }

    @keyframes toast-out {
      from {
        opacity: 1;
        transform: translateX(0)
      }

      to {
        opacity: 0;
        transform: translateX(80px)
      }
    }

    /* -- LOADING  -- */
    #loading-screen {
      position: fixed;
      inset: 0;
      background: var(--bg);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 14px;
      z-index: 9999
    }

    .loader {
      width: 40px;
      height: 40px;
      border: 3px solid var(--border);
      border-top-color: var(--ac);
      border-radius: 50%;
      animation: spin 1s linear infinite
    }

    @keyframes spin {
      to {
        transform: rotate(360deg)
      }
    }

    .loader-txt {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.1rem;
      letter-spacing: 3px;
      color: var(--muted2)
    }

    /* -- SETUP WIZARD  -- */
    #setup-wizard {
      position: fixed;
      inset: 0;
      background: rgba(6, 8, 15, .97);
      backdrop-filter: blur(10px);
      z-index: 8888;
      display: flex;
      align-items: flex-start;
      justify-content: center;
      padding: 20px;
      overflow-y: auto;
    }

    .wizard-card {
      background: var(--surface);
      border: 1px solid var(--border2);
      border-radius: 20px;
      padding: 36px;
      width: 100%;
      max-width: 520px;
      animation: modal-in .3s ease;
      margin: auto;
    }

    .wizard-logo {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 2.2rem;
      letter-spacing: 4px;
      margin-bottom: 4px;
      text-align: center
    }

    .wizard-logo span {
      color: var(--ps)
    }

    .wizard-ver {
      text-align: center;
      font-size: .65rem;
      background: rgba(167, 139, 250, .15);
      color: var(--purple);
      border: 1px solid rgba(167, 139, 250, .3);
      padding: 3px 12px;
      border-radius: 20px;
      display: inline-block;
      margin-bottom: 20px;
      letter-spacing: 2px
    }

    .wizard-title {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 1.35rem;
      letter-spacing: 2px;
      margin-bottom: 6px;
      color: var(--text)
    }

    .wizard-sub {
      font-size: .82rem;
      color: var(--muted2);
      margin-bottom: 24px;
      line-height: 1.5
    }

    .wbtn {
      flex: 1;
      padding: 12px;
      border-radius: 10px;
      font-size: .9rem;
      font-weight: 700;
      border: none;
      transition: all .2s
    }

    .wbtn-demo {
      background: var(--surface2);
      border: 1px solid var(--border2);
      color: var(--muted2)
    }

    .wbtn-demo:hover {
      border-color: var(--purple);
      color: var(--purple)
    }

    .wbtn-test {
      background: rgba(59, 130, 246, .12);
      border: 1px solid rgba(59, 130, 246, .3);
      color: var(--pc)
    }

    .wbtn-test:hover {
      background: rgba(59, 130, 246, .22)
    }

    .wbtn-save {
      background: var(--ac);
      color: #fff;
      flex: 2;
      transition: background .4s
    }

    .wbtn-save:hover {
      filter: brightness(1.12)
    }

    .wbtn-saving {
      opacity: .6;
      cursor: not-allowed
    }

    .test-result {
      font-size: .78rem;
      padding: 8px 12px;
      border-radius: 8px;
      margin-top: 8px;
      display: none
    }

    .test-result.ok {
      background: rgba(16, 185, 129, .1);
      border: 1px solid rgba(16, 185, 129, .3);
      color: var(--green)
    }

    .test-result.err {
      background: rgba(230, 57, 80, .1);
      border: 1px solid rgba(230, 57, 80, .3);
      color: var(--ps)
    }

    /* -- SETTINGS MODAL  -- */
    .settings-section {
      margin-bottom: 20px
    }

    .settings-section-title {
      font-size: .7rem;
      font-weight: 700;
      color: var(--muted2);
      text-transform: uppercase;
      letter-spacing: 2px;
      margin-bottom: 12px;
      padding-bottom: 8px;
      border-bottom: 1px solid var(--border)
    }

    .settings-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 8px 0;
      border-bottom: 1px solid var(--border)
    }

    .settings-row:last-child {
      border-bottom: none
    }

    .settings-key {
      font-size: .82rem;
      color: var(--muted2)
    }

    .settings-val {
      font-family: 'JetBrains Mono', monospace;
      font-size: .75rem;
      color: var(--text);
      max-width: 180px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap
    }

    .conn-badge {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      font-size: .72rem;
      padding: 3px 10px;
      border-radius: 6px;
      font-weight: 700
    }

    .conn-badge.live {
      background: rgba(16, 185, 129, .1);
      border: 1px solid rgba(16, 185, 129, .3);
      color: var(--green)
    }

    .conn-badge.demo {
      background: rgba(167, 139, 250, .1);
      border: 1px solid rgba(167, 139, 250, .3);
      color: var(--purple)
    }

    /* -- ADD UNIT BTN  -- */
    .btn-add {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: var(--ac);
      color: #fff;
      border: none;
      border-radius: 9px;
      padding: 9px 18px;
      font-size: .84rem;
      font-weight: 700;
      transition: background .4s, filter .2s;
    }

    .btn-add:hover {
      filter: brightness(1.12)
    }

    .btn-outline {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: transparent;
      color: var(--muted2);
      border: 1px solid var(--border2);
      border-radius: 9px;
      padding: 8px 16px;
      font-size: .82rem;
      font-weight: 600;
      transition: all .2s;
    }

    .btn-outline:hover {
      color: var(--text);
      border-color: var(--border2)
    }

    /* Info box PC */
    .info-box {
      background: rgba(59, 130, 246, .07);
      border: 1px solid rgba(59, 130, 246, .2);
      border-radius: 10px;
      padding: 12px 15px;
      margin-bottom: 18px;
      font-size: .8rem;
      color: var(--pc);
      display: none
    }

    body.mode-pc .info-box {
      display: block
    }

    /* Action btns */
    .del-btn {
      background: rgba(230, 57, 80, .08);
      color: var(--ps);
      border: 1px solid rgba(230, 57, 80, .2);
      border-radius: 6px;
      padding: 5px 10px;
      font-size: .78rem;
      font-weight: 600;
      transition: all .2s
    }

    .del-btn:hover {
      background: rgba(230, 57, 80, .18)
    }

    .edit-btn {
      background: rgba(255, 255, 255, .04);
      color: var(--muted2);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 5px 10px;
      font-size: .78rem;
      font-weight: 600;
      transition: all .2s
    }

    .edit-btn:hover {
      background: rgba(255, 255, 255, .08);
      color: var(--text)
    }

    /* Search bar */
    .search-bar {
      display: flex;
      align-items: center;
      gap: 8px;
      background: var(--surface2);
      border: 1px solid var(--border2);
      border-radius: 9px;
      padding: 7px 13px;
      flex: 1;
      min-width: 160px;
    }

    .search-bar input {
      background: transparent;
      border: none;
      outline: none;
      color: var(--text);
      font-size: .84rem;
      width: 100%
    }

    .search-bar input::placeholder {
      color: var(--muted)
    }

    .search-icon {
      font-size: .9rem;
      color: var(--muted)
    }

    /* -- PRINT  -- */
    @media print {
      body * {
        visibility: hidden
      }

      .struk-wrap,
      .struk-wrap * {
        visibility: visible
      }

      .struk-wrap {
        position: fixed;
        inset: 0;
        margin: auto;
        border-radius: 0;
        max-width: 100%
      }

      .struk-actions {
        display: none
      }
    }

    /* -- RESPONSIVE  -- */
    @media(max-width:1100px) {
      .stats-row {
        grid-template-columns: repeat(2, 1fr)
      }
    }

    @media(max-width:768px) {
      .sidebar {
        transform: translateX(-110%)
      }

      .sidebar.open {
        transform: translateX(0)
      }

      .main {
        margin-left: 0;
        padding: 16px 14px 90px;
        padding-top: 72px
      }

      .mob-header {
        display: flex
      }

      .bottom-nav {
        display: block
      }

      .grid-units {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px
      }

      .unit-card {
        padding: 13px
      }

      .unit-num {
        font-size: 2.2rem
      }

      .stats-row {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px
      }

      .stat-card {
        padding: 14px 14px
      }

      #toast-container {
        bottom: 80px;
        right: 12px;
        left: 12px;
        align-items: flex-end
      }

      .wizard-card {
        padding: 24px 20px
      }

      .saved-list {
        grid-template-columns: 1fr
      }
    }

    @media(max-width:400px) {
      .grid-units {
        grid-template-columns: 1fr
      }

      .stats-row {
        grid-template-columns: 1fr 1fr
      }
    }
  </style>
</head>

<body class="mode-ps">
  <a href="logout.php" style="position: fixed; top: 20px; right: 30px; z-index: 1000; background: var(--surface2); color: var(--text); padding: 8px 16px; border-radius: 8px; font-weight: bold; text-decoration: none; border: 1px solid var(--border2); transition: all 0.2s;" onmouseover="this.style.background='var(--ps)'; this.style.borderColor='var(--ps)';" onmouseout="this.style.background='var(--surface2)'; this.style.borderColor='var(--border2)';">Logout</a>

  <!-- Loading Screen -->
  <div id="loading-screen" style="display:none">
    <div class="loader"></div>
    <div class="loader-txt">Memuat YK2 Gaming...</div>
  </div>

  <!-- Toast -->
  <div id="toast-container"></div>

  <!-- App langsung terhubung ke MySQL via api.php -->

  </div>

  <!-- - MOBILE HEADER - -->
  <header class="mob-header" id="mob-header">
    <button class="ham-btn" onclick="toggleSidebar()" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
    <div class="mob-logo">YK2 <span>Gaming</span></div>
    
  </header>

  <!-- Sidebar Overlay -->
  <div id="sidebar-overlay" onclick="closeSidebar()"></div>

  <div class="app">

    <!-- - SIDEBAR - -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-logo">
        <div class="logo-name">YK2 <span>Gaming</span></div>
        <div class="logo-sub">
          <span class="logo-sub-txt">Admin Panel</span>
          <span class="logo-ver">v9</span>
        </div>
      </div>
      
      <div class="nav-sec">Menu</div>
      <div class="nav-item active" id="nav-dashboard" onclick="showPage('dashboard')">
        <span class="nav-icon">📊</span> Dashboard
      </div>
      <div class="nav-item" id="nav-unit" onclick="showPage('unit')">
        <span class="nav-icon" id="nav-unit-icon">🎮</span>
        <span id="nav-unit-label">Kelola PS</span>
      </div>
      <div class="nav-item" id="nav-saved" onclick="showPage('saved')">
        <span class="nav-icon">💾</span> Sesi Tersimpan
        <span class="nav-badge amber" id="badge-saved">0</span>
      </div>
      <div class="nav-item" id="nav-riwayat" onclick="showPage('riwayat')">
        <span class="nav-icon">🕒</span> Riwayat Sesi
        <span class="nav-badge" id="badge-riwayat">0</span>
      </div>
      <div class="nav-item" id="nav-laporan" onclick="showPage('laporan')">
        <span class="nav-icon">📄</span> Laporan
      </div>
      <div class="nav-item" id="nav-token" onclick="showPage('token')">
        <span class="nav-icon">🎟️</span> Verifikasi Token
      </div>
      <div class="nav-sec">Sistem</div>
      <div class="nav-item" onclick="showSettings()">
        <span class="nav-icon">⚙️</span> Pengaturan
      </div>
      <div class="sidebar-bottom">
        <div class="conn-row">
          <div id="conn-status"><span class="dot-online"></span> MySQL / XAMPP</div>
          <button class="btn-settings" onclick="fetchAll()">🔄</button>
        </div>
        <div style="font-size:.62rem;color:var(--muted);margin-top:2px" id="conn-url-display">adminpoli @ localhost
        </div>
        <div style="margin-top:4px;font-size:.62rem;color:var(--muted)">Auto-refresh: 10 detik</div>
      </div>
    </aside>

    <!-- - MAIN - -->
    <main class="main">

      <!-- - DASHBOARD - -->
      <div class="page active" id="page-dashboard">
        <div class="page-hdr">
          <div class="page-title">Dashboard</div>
          <div class="page-sub" id="tgl-display"></div>
        </div>
        <div id="dash-mode-badge" class="mode-badge ps">🎮 Mode PlayStation</div>
        <div class="stats-row">
          <div class="stat-card s-green">
            <div class="stat-icon-wrap">✅</div>
            <div class="stat-info">
              <div class="stat-val" id="d-avail"></div>
              <div class="stat-lbl" id="d-avail-lbl">PS Tersedia</div>
            </div>
          </div>
          <div class="stat-card s-red">
            <div class="stat-icon-wrap">🕹️</div>
            <div class="stat-info">
              <div class="stat-val" id="d-active"></div>
              <div class="stat-lbl" id="d-active-lbl">PS Aktif</div>
            </div>
          </div>
          <div class="stat-card s-amber">
            <div class="stat-icon-wrap">⏳</div>
            <div class="stat-info">
              <div class="stat-val" id="d-warn"></div>
              <div class="stat-lbl">Hampir Habis</div>
            </div>
          </div>
          <div class="stat-card s-gold">
            <div class="stat-icon-wrap">💰</div>
            <div class="stat-info">
              <div class="stat-val" id="d-rev"></div>
              <div class="stat-lbl">Pendapatan Hari Ini</div>
            </div>
          </div>
        </div>
        <div class="sec-hdr" style="margin-bottom:14px">
          <div class="sec-lbl" id="sec-lbl-dash">Status Unit PS</div>
          <button onclick="fetchAll()" class="btn-outline" style="font-size:.78rem;padding:7px 14px">-
            Refresh</button>
        </div>
        <div id="dash-grid" class="grid-units"></div>
      </div>

      <!-- - KELOLA UNIT - -->
      <div class="page" id="page-unit">
        <div class="page-hdr">
          <div class="page-title" id="unit-title">Kelola PS</div>
          <div class="page-sub" id="unit-sub">Manajemen unit PlayStation</div>
        </div>
        <div class="sec-hdr">
          <div class="sec-lbl">Daftar Unit</div>
          <button class="btn-add" onclick="showModalUnit()">+ Tambah Unit</button>
        </div>
        <div class="tbl-wrap" style="margin-bottom:28px">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Tipe</th>
                <th>Harga/Jam</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody id="tbl-unit"></tbody>
          </table>
        </div>
        <div class="sec-hdr">
          <div class="sec-lbl" id="sec-lbl-cards">Unit PS</div>
        </div>
        <div id="unit-grid" class="grid-units"></div>
      </div>

      <!-- - RIWAYAT - -->
      <div class="page" id="page-riwayat">
        <div class="page-hdr">
          <div class="page-title">Riwayat Sesi</div>
          <div class="page-sub">Semua transaksi yang telah selesai</div>
        </div>
        <div class="sec-hdr" style="gap:8px;flex-wrap:wrap">
          <div style="font-size:.82rem;color:var(--muted2)" id="riwayat-count"></div>
          <div style="display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-left:auto">
            <div class="search-bar" style="min-width:180px">
              <span class="search-icon"></span>
              <input type="text" id="riwayat-search" placeholder="Cari nama, unit..." oninput="renderRiwayat()">
            </div>
            <select id="riwayat-filter" class="form-sel" style="width:auto;padding:7px 12px;font-size:.8rem"
              onchange="renderRiwayat()">
              <option value="ps">- PS</option>
            </select>
            <button onclick="exportCSV()" class="btn-outline"
              style="gap:5px;font-size:.8rem;padding:7px 12px;white-space:nowrap">- Export CSV</button>
            <button onclick="hapusSemuaRiwayat()"
              style="background:rgba(230,57,80,.1);color:var(--ps);border:1px solid rgba(230,57,80,.2);border-radius:9px;padding:7px 14px;font-size:.8rem;font-weight:700;white-space:nowrap">-
              Hapus Semua</button>
          </div>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Unit</th>
                <th>Mode</th>
                <th>Status</th>
                <th>Pelanggan</th>
                <th>Durasi</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Total</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="tbl-riwayat"></tbody>
          </table>
        </div>
      </div>

      <!-- - VERIFIKASI TOKEN - -->
      <div class="page" id="page-token">
        <div class="page-hdr">
          <div class="page-title">Verifikasi Token</div>
          <div class="page-sub">Validasi & gunakan kode token pelanggan untuk memulai sesi baru</div>
        </div>

        <!-- Input Form -->
        <div style="max-width:520px">
          <div style="display:flex;gap:10px;margin-bottom:24px">
            <input type="text" id="vt-input" placeholder="Contoh: YK2-A1B2" maxlength="8"
              style="flex:1;background:var(--surface2);border:1px solid var(--border2);border-radius:9px;padding:12px 16px;color:var(--text);font-size:1.1rem;font-family:'JetBrains Mono',monospace;text-transform:uppercase;letter-spacing:3px;outline:none"
              oninput="this.value=this.value.toUpperCase()" onkeydown="if(event.key==='Enter')verifikasiToken()">
            <button onclick="verifikasiToken()" id="vt-btn"
              style="background:var(--purple);color:#fff;border:none;border-radius:9px;padding:12px 22px;font-weight:700;font-size:.9rem;white-space:nowrap;cursor:pointer;transition:filter .2s"
              onmouseover="this.style.filter='brightness(1.15)'" onmouseout="this.style.filter=''">🔍 Verifikasi</button>
          </div>

          <!-- Loading -->
          <div id="vt-loading" style="display:none;text-align:center;padding:30px;color:var(--muted)">Memeriksa token...</div>

          <!-- Error -->
          <div id="vt-error" style="display:none;background:rgba(230,57,80,.08);border:1px solid rgba(230,57,80,.25);border-radius:12px;padding:18px 20px;margin-bottom:16px">
            <div style="font-weight:700;color:var(--red);font-size:1rem;margin-bottom:4px">❌ Token Tidak Valid</div>
            <div id="vt-error-msg" style="color:var(--muted);font-size:.9rem"></div>
          </div>

          <!-- Result Card -->
          <div id="vt-result" style="display:none;background:var(--surface);border:1px solid rgba(16,185,129,.3);border-radius:14px;overflow:hidden">
            <!-- Header hijau -->
            <div style="background:rgba(16,185,129,.1);padding:16px 20px;border-bottom:1px solid rgba(16,185,129,.2);display:flex;align-items:center;justify-content:space-between">
              <div style="font-weight:700;color:var(--green);font-size:1rem">✅ Token Valid</div>
              <div id="vt-code-disp" style="font-family:'JetBrains Mono',monospace;font-size:1.3rem;font-weight:700;color:var(--green);letter-spacing:3px"></div>
            </div>
            <!-- Detail rows -->
            <div style="padding:20px">
              <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px">
                <div style="background:var(--surface2);border-radius:10px;padding:14px">
                  <div style="font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:5px">Pelanggan</div>
                  <div id="vt-cust" style="font-weight:700;font-size:1rem"></div>
                </div>
                <div style="background:var(--surface2);border-radius:10px;padding:14px">
                  <div style="font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:5px">Unit Terakhir</div>
                  <div id="vt-unit" style="font-weight:700;font-size:1rem"></div>
                </div>
                <div style="background:rgba(167,139,250,.08);border:1px solid rgba(167,139,250,.2);border-radius:10px;padding:14px;grid-column:1/-1;text-align:center">
                  <div style="font-size:.65rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:5px">Sisa Waktu Tersimpan</div>
                  <div id="vt-time" style="font-family:'JetBrains Mono',monospace;font-size:2rem;font-weight:700;color:var(--purple)"></div>
                </div>
              </div>

              <!-- Pilih unit untuk resume -->
              <div id="vt-unit-select-wrap" style="margin-bottom:16px">
                <label style="display:block;font-size:.72rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Pilih Unit untuk Sesi Baru</label>
                <select id="vt-unit-sel" style="width:100%;background:var(--surface2);border:1px solid var(--border2);border-radius:9px;padding:10px 14px;color:var(--text);font-size:.9rem;outline:none">
                  <option value="">-- Pilih unit --</option>
                </select>
              </div>

              <button id="vt-use-btn" onclick="gunakanToken()"
                style="width:100%;padding:14px;background:var(--green);color:#fff;border:none;border-radius:10px;font-weight:700;font-size:1rem;cursor:pointer;transition:filter .2s"
                onmouseover="this.style.filter='brightness(1.1)'" onmouseout="this.style.filter=''">
                ▶ Gunakan Token — Mulai Sesi Baru
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- - LAPORAN - -->
      <div class="page" id="page-laporan">
        <div class="page-hdr">
          <div class="page-title">Laporan Pendapatan</div>
          <div class="page-sub">Rekap harian, mingguan & per mode</div>
        </div>
        <div class="rep-grid">
          <div class="rep-card">
            <div class="rep-lbl">Hari Ini (Semua)</div>
            <div class="rep-val" id="lap-hari" style="color:var(--gold)"></div>
          </div>
          <div class="rep-card">
            <div class="rep-lbl">Minggu Ini</div>
            <div class="rep-val" id="lap-minggu" style="color:var(--gold)"></div>
          </div>
          <div class="rep-card">
            <div class="rep-lbl">PS Hari Ini</div>
            <div class="rep-val" id="lap-ps" style="color:var(--ps)"></div>
          </div>
          <div class="rep-card">
            <div class="rep-lbl">Total Sesi Hari Ini</div>
            <div class="rep-val" id="lap-sesi" style="color:var(--green)"></div>
          </div>
          <div class="rep-card">
            <div class="rep-lbl">Rata-rata Durasi</div>
            <div class="rep-val" id="lap-avg" style="color:var(--purple)"></div>
          </div>
        </div>
        <div class="sec-hdr">
          <div class="sec-lbl">Pendapatan 7 Hari Terakhir</div>
        </div>
        <div id="chart-bars"
          style="background:var(--surface);border:1px solid var(--border);border-radius:14px;padding:20px;margin-bottom:24px">
        </div>
        <div class="sec-hdr">
          <div class="sec-lbl">Transaksi Hari Ini</div>
          <button onclick="exportCSV('today')" class="btn-outline" style="font-size:.78rem;padding:7px 12px">-
            Export</button>
        </div>
        <div class="tbl-wrap">
          <table>
            <thead>
              <tr>
                <th>Unit</th>
                <th>Mode</th>
                <th>Pelanggan</th>
                <th>Durasi</th>
                <th>Total</th>
              </tr>
            </thead>
            <tbody id="tbl-laporan"></tbody>
          </table>
        </div>
      </div>

    </main>
  </div>

  <!-- - BOTTOM NAV (mobile) - -->
  <nav class="bottom-nav">
    <div class="bottom-nav-inner">
      <div class="bnav-item active" id="bnav-dashboard" onclick="showPage('dashboard')">
        <div class="bnav-line"></div>
        <div class="bnav-icon"></div>
        <div>Dashboard</div>
      </div>
      <div class="bnav-item" id="bnav-unit" onclick="showPage('unit')">
        <div class="bnav-line"></div>
        <div class="bnav-icon" id="bnav-unit-icon"></div>
        <div>Kelola</div>
      </div>
      <div class="bnav-item" id="bnav-riwayat" onclick="showPage('riwayat')">
        <div class="bnav-line"></div>
        <div class="bnav-icon"></div>
        <div>Riwayat</div>
        <div class="bnav-badge" id="bnav-badge-riwayat">0</div>
      </div>
      <div class="bnav-item" id="bnav-laporan" onclick="showPage('laporan')">
        <div class="bnav-line"></div>
        <div class="bnav-icon"></div>
        <div>Laporan</div>
      </div>
    </div>
  </nav>

  <!-- - MODALS - -->

  <!-- Modal Mulai Sesi -->
  <div class="overlay" id="modal-mulai">
    <div class="modal" style="max-width:500px">
      <div class="modal-title">- Mulai Sesi</div>

      <div class="form-grp">
        <label class="form-lbl">Unit</label>
        <input class="form-input" id="mi-unit" readonly style="opacity:.5">
      </div>
      <div class="form-grp">
        <label class="form-lbl">Nama Pelanggan</label>
        <input class="form-input" id="mi-nama" placeholder="Nama pelanggan (opsional)" autocomplete="off">
      </div>

      <div class="form-grp">
        <label class="form-lbl">Paket Cepat</label>
        <div class="pkg-grid" id="mi-pkg"></div>
      </div>
      <div class="form-grp">
        <label class="form-lbl">Pilih Manual (maks 12 jam)</label>
        <div class="dur-picker">
          <button class="dur-btn" onclick="changeJam('mi',-1)"></button>
          <div class="dur-val" id="mi-jam-disp">1 JAM</div>
          <button class="dur-btn" onclick="changeJam('mi',1)">+</button>
        </div>
        <div class="dur-hint" id="mi-jam-hint"></div>
      </div>
      <div class="total-prev">
        <span class="total-lbl">Total Bayar (di depan)</span>
        <span class="total-val" id="mi-total">Rp 0</span>
      </div>

      <!-- ── METODE PEMBAYARAN ── -->
      <div style="margin-top:18px">
        <label class="form-lbl">METODE PEMBAYARAN</label>
        <div style="display:flex; gap:8px; margin-bottom:14px;">
          <button id="mi-pay-cash-btn"
            onclick="setMiPayMethod('tunai')"
            style="flex:1; padding:10px; border-radius:9px; font-size:.88rem; font-weight:700; border:2px solid var(--green); background:var(--green); color:white; cursor:pointer; transition:all .2s;">
            💵 Cash
          </button>
          <button id="mi-pay-qris-btn"
            onclick="setMiPayMethod('qris')"
            style="flex:1; padding:10px; border-radius:9px; font-size:.88rem; font-weight:700; border:2px solid var(--border2); background:var(--surface2); color:var(--muted2); cursor:pointer; transition:all .2s;">
            📱 QRIS
          </button>
        </div>

        <!-- Panel Cash -->
        <div id="mi-pay-cash-panel">
          <div class="form-grp" style="margin-bottom:0">
            <label class="form-lbl">Nominal Uang Diterima</label>
            <div style="display:flex; gap:8px; align-items:stretch;">
              <input class="form-input" id="mi-nominal" type="number" min="0" placeholder="Masukkan nominal..."
                style="flex:1"
                oninput="const u=units.find(x=>x.id===miUnitId); if(u) miHitungKembalian(miJam*u.harga, parseFloat(this.value)||0)">
              <button onclick="miUangPas()"
                style="padding:10px 14px; border-radius:9px; background:var(--surface3); border:1px solid var(--border2); color:var(--text); font-size:.82rem; font-weight:600; cursor:pointer; white-space:nowrap; transition:background .2s;"
                onmouseover="this.style.borderColor='var(--green)'" onmouseout="this.style.borderColor='var(--border2)'">
                ✓ Uang Pas
              </button>
            </div>
            <div id="mi-kembalian" style="margin-top:7px; font-size:.8rem; color:var(--muted2); min-height:18px;"></div>
          </div>
        </div>

        <!-- Panel QRIS -->
        <div id="mi-pay-qris-panel" style="display:none; text-align:center;">
          <div style="background:white; padding:12px; border-radius:10px; display:inline-block; margin-bottom:10px; border:1px solid var(--border2);">
            <img src="img/qris-dana.png" alt="QRIS DANA" style="max-width:180px; display:block; margin:0 auto;">
          </div>
          <div style="font-size:.82rem; color:var(--muted2); margin-bottom:4px;">Scan QRIS menggunakan DANA atau e-wallet lainnya</div>
          <div id="mi-qris-nominal" style="font-family:'Bebas Neue',sans-serif; font-size:1.5rem; color:var(--pc); letter-spacing:1px;">Rp 0</div>
        </div>
      </div>
      <!-- ── END METODE PEMBAYARAN ── -->

      <div class="modal-actions">
        <button class="mbtn mbtn-cancel" onclick="closeModal('modal-mulai')">Batal</button>
        <button class="mbtn mbtn-ok" id="mi-submit-btn" onclick="konfirmasiMulai()">- Mulai & Bayar Cash</button>
      </div>
    </div>
  </div>

  <!-- Modal Tambah Jam -->
  <div class="overlay" id="modal-tambah">
    <div class="modal">
      <div class="modal-title" style="color:var(--amber)">- Tambah Waktu</div>
      <div class="form-grp">
        <label class="form-lbl">Unit</label>
        <input class="form-input" id="tj-unit" readonly style="opacity:.5">
      </div>
      <div class="form-grp">
        <label class="form-lbl">Tambah Durasi</label>
        <div class="dur-picker">
          <button class="dur-btn" onclick="changeJam('tj',-1)">-</button>
          <div class="dur-val" id="tj-jam-disp" style="color:var(--amber)">1 JAM</div>
          <button class="dur-btn" onclick="changeJam('tj',1)">+</button>
        </div>
      </div>
      <div class="total-prev" style="border-color:rgba(249,115,22,.3);background:rgba(249,115,22,.05)">
        <span class="total-lbl">Bayar Tambahan</span>
        <span class="total-val" id="tj-total" style="color:var(--amber)">Rp 0</span>
      </div>
      <div class="modal-actions">
        <button class="mbtn mbtn-cancel" onclick="closeModal('modal-tambah')">Batal</button>
        <button class="mbtn mbtn-warn" onclick="konfirmasiTambah()">- Tambah & Cetak Struk</button>
      </div>
    </div>
  </div>

  <!-- Modal Stop Sesi -->
  <div class="overlay" id="modal-stop">
    <div class="modal">
      <div class="modal-title" style="color:var(--ps)">🛑 Selesaikan Sesi</div>
      <div class="resume-box" style="background:rgba(230,57,80,.05);border-color:rgba(230,57,80,.2)">
        <div class="resume-box-title" style="color:var(--ps)">- Info Sesi</div>
        <div class="res-row"><span>Unit</span><span id="stop-unit"></span></div>
        <div class="res-row"><span>Pelanggan</span><span id="stop-nama"></span></div>
        <div class="res-row"><span>Mulai</span><span id="stop-mulai"></span></div>
        <div class="res-row"><span>Sisa</span><span id="stop-sisa" style="color:var(--amber)"></span></div>
      </div>
      <div class="modal-actions">
        <button class="mbtn mbtn-cancel" onclick="closeModal('modal-stop')">Batal</button>
        <button class="mbtn mbtn-red" onclick="konfirmasiStop()">- Selesaikan</button>
      </div>
    </div>
  </div>

  <!-- Modal Pilihan Pembayaran -->
  <div class="overlay" id="modal-pembayaran">
    <div class="modal" style="max-width:400px">
      <div class="modal-title" style="color:var(--green)">💰 Metode Pembayaran</div>
      <p style="margin:0 0 15px 0; color:var(--text); font-size:0.95rem;">
        Pilih metode pembayaran untuk menyelesaikan sesi <strong id="pay-unit-name"></strong>.
      </p>
      
      <div class="resume-box" style="background:rgba(16,185,129,.05); border-color:rgba(16,185,129,.2); margin-bottom:20px;">
        <div class="res-row" style="font-size:1.1rem; font-weight:bold;">
          <span>Total Tagihan</span>
          <span id="pay-total-amount" style="color:var(--green)"></span>
        </div>
      </div>

      <!-- State 1: Pilihan Metode -->
      <div id="pay-state-select">
        <div style="display:flex; flex-direction:column; gap:12px; margin-bottom:20px;">
          <button class="mbtn" style="background:var(--green); color:white; padding:14px; font-size:1rem; display:flex; align-items:center; justify-content:center; gap:8px;" onclick="bayarStopSesi('tunai')">
            💵 Tunai (Cash)
          </button>
          <button class="mbtn" style="background:var(--pc); color:white; padding:14px; font-size:1rem; display:flex; align-items:center; justify-content:center; gap:8px;" onclick="tampilkanQrisSesi()">
            📱 QRIS - DANA
          </button>
        </div>
        <div class="modal-actions">
          <button class="mbtn mbtn-cancel" onclick="closeModal('modal-pembayaran')" style="width:100%">Batal</button>
        </div>
      </div>

      <!-- State 2: QRIS DANA -->
      <div id="pay-state-qris" style="display:none; text-align:center;">
        <div style="background: white; padding: 15px; border-radius: 12px; display: inline-block; margin-bottom: 15px; border: 1px solid var(--border2);">
          <img src="img/qris-dana.png" alt="QRIS DANA" style="max-width:200px; display:block; margin:0 auto;">
        </div>
        <p style="font-size:0.85rem; color:var(--muted2); margin-bottom:20px;">
          Silakan scan QRIS di atas menggunakan aplikasi DANA atau e-wallet lainnya.
        </p>
        <div class="modal-actions" style="display:flex; gap:10px;">
          <button class="mbtn mbtn-cancel" onclick="kembaliKePilihanBayar()" style="flex:1">Kembali</button>
          <button class="mbtn" style="background:var(--green); color:white; flex:1.5" onclick="bayarStopSesi('qris')">
            ✅ Pembayaran Diterima
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Tambah/Edit Unit -->
  <div class="overlay" id="modal-unit">
    <div class="modal">
      <div class="modal-title" id="mu-title">+ Tambah Unit</div>
      <input type="hidden" id="eu-id">
      <div class="form-grp">
        <label class="form-lbl">Nomor Unit</label>
        <input type="number" class="form-input" id="eu-no" placeholder="Contoh: 5" min="1">
      </div>
      <div class="form-grp">
        <label class="form-lbl">Tipe / Konsol</label>
        <div id="eu-quick-ps" class="console-grid" style="margin-bottom:8px">
          <button class="console-btn" onclick="euSelConsole('PS3')">PS3</button>
          <button class="console-btn" onclick="euSelConsole('PS4')">PS4</button>
          <button class="console-btn" onclick="euSelConsole('PS5')">PS5</button>
        </div>
        
        <input class="form-input" id="eu-tipe" placeholder="Atau ketik manual: PS4, VIP...">
      </div>
      <div class="form-grp">
        <label class="form-lbl">Harga per Jam (Rp)</label>
        <input type="number" class="form-input" id="eu-harga" placeholder="Contoh: 10000" min="0">
      </div>
      <div class="modal-actions">
        <button class="mbtn mbtn-cancel" onclick="closeModal('modal-unit')">Batal</button>
        <button class="mbtn mbtn-ok" onclick="simpanUnit()">- Simpan Unit</button>
      </div>
    </div>
  </div>

  <!-- Modal Generate Token -->
  <div class="overlay" id="modal-token">
    <div class="modal" style="max-width:400px">
      <div class="modal-title">🎟️ Simpan Jam ke Token</div>
      <p style="color:var(--muted);font-size:.85rem;margin-bottom:18px">Sisa waktu pelanggan akan disimpan ke kode token yang bisa ditukar kapan saja dalam 30 hari.</p>
      <div style="background:rgba(167,139,250,.08);border:1px solid rgba(167,139,250,.25);border-radius:10px;padding:16px;margin-bottom:18px">
        <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:.85rem">
          <span style="color:var(--muted)">Unit</span><span id="tk-unit" style="font-weight:700"></span>
        </div>
        <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:.85rem">
          <span style="color:var(--muted)">Pelanggan</span><span id="tk-cust" style="font-weight:700"></span>
        </div>
        <div style="display:flex;justify-content:space-between;font-size:.85rem">
          <span style="color:var(--muted)">Sisa Waktu</span><span id="tk-sisa" style="font-weight:700;color:var(--purple)"></span>
        </div>
      </div>
      <div id="tk-result" style="display:none;text-align:center;padding:20px;background:rgba(16,185,129,.07);border:1px solid rgba(16,185,129,.25);border-radius:10px;margin-bottom:18px">
        <div style="font-size:.7rem;color:var(--muted);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px">Kode Token Berhasil Dibuat</div>
        <div id="tk-code" style="font-family:'JetBrains Mono',monospace;font-size:2rem;font-weight:700;color:var(--green);letter-spacing:4px"></div>
        <div style="font-size:.75rem;color:var(--muted);margin-top:8px">Berlaku 30 hari — Tunjukkan ke kasir</div>
      </div>
      <div class="modal-actions">
        <button class="mbtn mbtn-cancel" onclick="closeModal('modal-token')" id="tk-btn-batal">Batal</button>
        <button class="mbtn mbtn-purple" id="tk-btn-generate" onclick="doGenerateToken()">🎟️ Generate Token</button>
      </div>
    </div>
  </div>

  <!-- Modal Settings -->
  <div class="overlay" id="modal-settings">
    <div class="modal" style="max-width:480px">
      <div class="modal-title">- Pengaturan</div>

      <div class="settings-section">
        <div class="settings-section-title">Status Koneksi</div>
        <div class="settings-row">
          <span class="settings-key">Database</span>
          <span class="conn-badge live">- MySQL / XAMPP</span>
        </div>
        <div class="settings-row">
          <span class="settings-key">Host</span>
          <span class="settings-val">localhost / adminpoli</span>
        </div>
      </div>

      <div class="settings-section">
        <div class="settings-section-title">Info Aplikasi</div>
        <div class="settings-row"><span class="settings-key">Versi</span><span class="settings-val">YK2 Gaming</span>
        </div>
        <div class="settings-row"><span class="settings-key">Backend</span><span class="settings-val">api.php (PHP +
            MySQL)</span></div>
        <div class="settings-row"><span class="settings-key">Mode Saat Ini</span><span class="settings-val"
            id="set-mode-display"></span></div>
        <div class="settings-row"><span class="settings-key">Unit Terdaftar</span><span class="settings-val"
            id="set-unit-count"></span></div>
      </div>

      <div class="modal-actions">
        <button class="mbtn mbtn-cancel" onclick="closeModal('modal-settings')">Tutup</button>
      </div>
    </div>
  </div>

  <!-- Modal Struk -->
  <div class="overlay" id="modal-struk">
    <div class="struk-wrap">
      <div class="struk-logo">YK2 <span class="sl-c">Gaming</span></div>
      <div class="struk-tag">STRUK PEMBAYARAN</div>
      <div class="struk-badge sb-awal" id="s-badge">PEMBAYARAN AWAL</div>
      <hr class="struk-hr">
      <div class="struk-row"><span>Unit</span><span id="s-unit"></span></div>
      <div class="struk-row"><span>Mode</span><span id="s-mode"></span></div>
      <div class="struk-row" id="s-konsol-row"><span>Konsol</span><span id="s-konsol"></span></div>
      <div class="struk-row"><span>Pelanggan</span><span id="s-nama"></span></div>
      <div class="struk-row"><span>Waktu Mulai</span><span id="s-mulai"></span></div>
      <div class="struk-row"><span>Durasi</span><span id="s-durasi"></span></div>
      <div class="struk-row"><span>Berakhir Pukul</span><span id="s-berakhir"></span></div>
      <hr class="struk-hr">
      <div class="struk-row struk-total"><span>TOTAL BAYAR</span><span id="s-total"></span></div>
      <div class="struk-note">Terima kasih sudah bermain di YK2 Gaming! </div>
      <div class="struk-actions">
        <button class="struk-print" onclick="window.print()">🖨️ Cetak</button>
        <button class="struk-close" onclick="closeModal('modal-struk')">Tutup</button>
      </div>
    </div>
  </div>

  <!-- - SCRIPT - -->
  <script>
    'use strict';

    // - FORMAT HELPERS -
    const rp = n => 'Rp ' + Number(n).toLocaleString('id-ID');
    const fmtTime = iso => new Date(iso).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    const fmtDate = iso => new Date(iso).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' });
    const fmtDur = mins => { const h = Math.floor(mins / 60), m = mins % 60; return h > 0 ? `${h}j${m > 0 ? ' ' + m + 'm' : ''}` : `${m}m`; };
    const fmtCountdown = secs => { const h = Math.floor(secs / 3600), m = Math.floor((secs % 3600) / 60), s = secs % 60; return `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`; };
    const today = () => new Date().toDateString();
    const isToday = iso => new Date(iso).toDateString() === today();
    const startOfWeek = () => { const d = new Date(); d.setDate(d.getDate() - d.getDay()); d.setHours(0, 0, 0, 0); return d; };
    const genId = () => 'local-' + Math.random().toString(36).substr(2, 9) + Date.now();
    const esc = s => { const d = document.createElement('div'); d.textContent = s || ''; return d.innerHTML; };

    // - TOAST -
    function toast(msg, type = 'info', dur = 3000) {
      const tc = document.getElementById('toast-container');
      const el = document.createElement('div');
      const icons = { ok: '✅ ', err: '❌ ', info: 'ℹ️ ', purple: '✨ ' };
      el.className = 'toast t-' + type;
      el.innerHTML = `<span>${icons[type] || ''}</span><span>${esc(msg)}</span>`;
      tc.appendChild(el);
      setTimeout(() => { el.style.animation = 'toast-out .3s ease forwards'; setTimeout(() => el.remove(), 320); }, dur);
    }

    function renderAll() {
      if (curPage === 'dashboard') renderDashboard();
      if (curPage === 'unit') renderUnitPage();
      if (curPage === 'saved') renderSavedPage();
      if (curPage === 'riwayat') renderRiwayat();
      if (curPage === 'laporan') renderLaporan();
      if (curPage === 'token') renderTokenPage();
      updateBadges();
      startTimers(); // Jalankan/restart timer ticker setelah setiap render
    }

    function updateBadges() {
      const sv = savedSess.length;
      const rw = historyData.length;
      const bbadge = document.getElementById('badge-saved');
      if(bbadge) { bbadge.textContent = sv; bbadge.classList.toggle('show', sv > 0); }
      const rbadge = document.getElementById('badge-riwayat');
      if(rbadge) { rbadge.textContent = rw; rbadge.classList.toggle('show', rw > 0); }
      const bnavSaved = document.getElementById('bnav-badge-saved');
      if (bnavSaved) { bnavSaved.textContent = sv; bnavSaved.classList.toggle('show', sv > 0); }
      const bnavRiwayat = document.getElementById('bnav-badge-riwayat');
      if (bnavRiwayat) { bnavRiwayat.textContent = rw; bnavRiwayat.classList.toggle('show', rw > 0); }
    }

    // - HELPERS -
    const getSess = uid => sessions.find(s => s.unit_id === uid) || null;
    const getSaved = uid => savedSess.find(s => s.unit_id === uid) || null;
    const modeUnits = () => units;

    function remainingSecs(sess) {
      // Pastikan format aman (YYYY-MM-DDTHH:MM:SS) agar tidak NaN di browser tertentu
      const safeEnd = sess.end_time.replace(' ', 'T');
      return Math.floor((new Date(safeEnd) - new Date()) / 1000);
    }

    function unitStatus(u) {
      const s = getSess(u.id);
      if (s) { const rem = remainingSecs(s); return rem <= 0 ? 'warning' : (rem <= 300 ? 'warning' : 'occupied'); }
      return 'available';
    }

    // - NAVIGATION -
    function showPage(p) {
      curPage = p;
      document.querySelectorAll('.page').forEach(el => el.classList.remove('active'));
      const pel = document.getElementById('page-' + p);
      if(pel) pel.classList.add('active');
      ['dashboard', 'unit', 'saved', 'riwayat', 'laporan', 'token'].forEach(x => {
        const nx = document.getElementById('nav-' + x);
        if(nx) nx.classList.toggle('active', x === p);
        const bx = document.getElementById('bnav-' + x);
        if(bx) bx.classList.toggle('active', x === p);
      });
      closeSidebar();
      renderAll();
    }

    function toggleSidebar() { document.getElementById('sidebar').classList.toggle('open'); document.getElementById('sidebar-overlay').classList.toggle('show'); }
    function closeSidebar() { document.getElementById('sidebar').classList.remove('open'); document.getElementById('sidebar-overlay').classList.remove('show'); }

    // - TIMER SYSTEM -
    const timerIds = {};

    function startTimers() {
      Object.values(timerIds).forEach(clearInterval);
      Object.keys(timerIds).forEach(k => delete timerIds[k]);
      sessions.forEach(sess => {
        tickTimer(sess);
        timerIds[sess.id] = setInterval(() => tickTimer(sess), 1000);
      });
    }

    function tickTimer(sess) {
      // Gunakan querySelectorAll agar semua elemen timer (dashboard + kelola ps)
      // yang menampilkan sesi ini terupdate, bukan hanya elemen pertama dari getElementById
      const els = document.querySelectorAll(`[data-sess-id="${sess.id}"]`);
      const pbs = document.querySelectorAll(`[data-pb-id="${sess.id}"]`);
      if (!els.length) return;
      const rem = remainingSecs(sess);
      const tot = sess.duration_minutes * 60;
      const elapsed = tot - rem;
      const pct = Math.min(100, Math.max(0, (elapsed / tot) * 100));
      const cls = rem <= 0 ? 't-over' : rem <= 300 ? 't-warn' : 't-ok';
      const txt = rem <= 0 ? 'WAKTU HABIS' : fmtCountdown(Math.max(0, rem));
      const pbBg = rem <= 0 ? 'var(--ps)' : rem <= 300 ? 'var(--amber)' : 'var(--green)';
      els.forEach(el => { el.className = 'timer-disp ' + cls; el.textContent = txt; });
      pbs.forEach(pb => { pb.style.width = pct + '%'; pb.style.background = pbBg; });
    }

    // - RENDER DASHBOARD -
    function renderDashboard() {
      const mu = modeUnits();
      const ms = sessions;
      const todayH = historyData.filter(h => isToday(h.created_at));
      const rev = todayH.reduce((a, h) => a + Number(h.total || 0), 0);
      const warns = ms.filter(s => { const r = remainingSecs(s); return r <= 300 && r > 0; });

      const tg = document.getElementById('tgl-display');
      if(tg) tg.textContent = new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
      document.getElementById('d-avail').textContent = mu.filter(u => unitStatus(u) === 'available').length;
      document.getElementById('d-active').textContent = ms.length;
      document.getElementById('d-warn').textContent = warns.length;
      document.getElementById('d-rev').textContent = rp(rev);

      const grid = document.getElementById('dash-grid');
      if(!grid) return;
      grid.innerHTML = '';
      mu.forEach(u => {
        const st = unitStatus(u);
        const sess = getSess(u.id);
        let inner = '';
        if (sess) {
          const rem = remainingSecs(sess);
          const tot = sess.duration_minutes * 60;
          const pct = Math.min(100, Math.max(0, ((tot - rem) / tot) * 100));
          const cls = rem <= 0 ? 't-over' : rem <= 300 ? 't-warn' : 't-ok';
          inner = `
        <div class="countdown-block" style="display:block">
          <div class="sess-info">
            <span class="cust-name">${esc(sess.customer)}</span>
            <span class="end-time-lbl">s/d ${fmtTime(sess.end_time)}</span>
          </div>
          <div class="timer-disp ${cls}" data-sess-id="${sess.id}">${rem <= 0 ? 'WAKTU HABIS' : fmtCountdown(rem)}</div>
          <div class="prog-bar"><div class="prog-fill" data-pb-id="${sess.id}" style="width:${pct}%;background:${rem <= 0 ? 'var(--ps)' : rem <= 300 ? 'var(--amber)' : 'var(--green)'}"></div></div>
          <div class="prog-meta"><span>${fmtTime(sess.start_time)}</span><span>${fmtTime(sess.end_time)}</span></div>
        </div>`;
        }
        const stLabel = { available: 'Tersedia', occupied: 'Aktif', warning: 'Hampir Habis' }[st] || st;
        const chipCls = { available: 'chip-avail', occupied: 'chip-occ', warning: 'chip-warn' }[st] || 'chip-avail';
        grid.innerHTML += `
      <div class="unit-card ${st}" style="cursor:default">
        <div class="card-head">
          <div><div class="unit-num">${u.nomor}<small>${u.tipe}</small></div><div class="unit-price">${rp(u.harga)}/jam</div></div>
          <div class="status-chip ${chipCls}"><div class="status-dot"></div>${stLabel}</div>
        </div>
        ${inner}
      </div>`;
      });
      startTimers();
    }

    // - RENDER KELOLA UNIT -
    function renderUnitPage() {
      const mu = modeUnits();
      const tb = document.getElementById('tbl-unit');
      if(tb) {
          tb.innerHTML = mu.map(u => {
            const st = unitStatus(u);
            const stClr = { available: 'var(--green)', occupied: 'var(--ps)', warning: 'var(--amber)' }[st] || 'var(--muted2)';
            const stLbl = { available: 'Tersedia', occupied: 'Aktif', warning: 'Hampir Habis' }[st] || st;
            return `<tr>
          <td class="mono">${u.nomor}</td>
          <td><strong>${esc(u.tipe)}</strong></td>
          <td class="mono">${rp(u.harga)}</td>
          <td><span style="color:${stClr};font-weight:700;font-size:.82rem"> ${stLbl}</span></td>
          <td style="display:flex;gap:6px;flex-wrap:wrap">
            <button class="edit-btn" data-id="${u.id}" onclick="showModalUnit(this.getAttribute('data-id'))">📝 Edit</button>
            <button class="del-btn" data-id="${u.id}" data-name="${esc(u.tipe)} ${u.nomor}" onclick="hapusUnit(this.getAttribute('data-id'), this.getAttribute('data-name'))">🗑️</button>
          </td>
        </tr>`;
          }).join('') || '<tr><td colspan="5" style="text-align:center;color:var(--muted);padding:20px">Belum ada unit</td></tr>';
      }

      // Cards
      const grid = document.getElementById('unit-grid');
      if(!grid) return;
      grid.innerHTML = '';
      mu.forEach(u => {
        const st = unitStatus(u);
        const sess = getSess(u.id);
        let inner = '';
        if (sess) {
          const rem = remainingSecs(sess);
          const tot = sess.duration_minutes * 60;
          const pct = Math.min(100, Math.max(0, ((tot - rem) / tot) * 100));
          inner = `
        <div class="countdown-block" style="display:block">
          <div class="sess-info">
            <span class="cust-name">${esc(sess.customer)}</span>
            <span class="end-time-lbl">s/d ${fmtTime(sess.end_time)}</span>
          </div>
          <div class="timer-disp t-ok" data-sess-id="${sess.id}">${fmtCountdown(Math.max(0, rem))}</div>
          <div class="prog-bar"><div class="prog-fill" data-pb-id="${sess.id}" style="width:${pct}%;background:var(--green)"></div></div>
        </div>`;
        }
        
        const stLabel = { available: 'Tersedia', occupied: 'Aktif', warning: 'Hampir Habis' }[st] || st;
        const chipCls = { available: 'chip-avail', occupied: 'chip-occ', warning: 'chip-warn' }[st] || 'chip-avail';

        let actions = '';
        if (st === 'available') {
          actions = `<button class="cbtn cbtn-start" onclick="showModalMulai('${u.id}')">▶ Mulai Sesi</button>`;
        } else {
          const purchasedMins = sess ? sess.duration_minutes : 0;
          const remMins = Math.max(0, Math.floor(remainingSecs(sess) / 60));
          actions = `
        <button class="cbtn cbtn-add" onclick="showModalTambah('${u.id}')">⏱️ +Jam</button>
        <button class="cbtn cbtn-stop" onclick="showModalStop('${u.id}')">🛑 Selesai</button>
        <button class="cbtn cbtn-save" title="Simpan Jam ke Token" onclick="showModalToken('${u.id}', ${purchasedMins}, ${remMins})">🎟️</button>`;
        }

        grid.innerHTML += `
      <div class="unit-card ${st}">
        <div class="card-head">
          <div><div class="unit-num">${u.nomor}<small>${u.tipe}</small></div><div class="unit-price">${rp(u.harga)}/jam</div></div>
          <div class="status-chip ${chipCls}"><div class="status-dot"></div>${stLabel}</div>
        </div>
        ${inner}
        <div class="card-actions">${actions}</div>
      </div>`;
      });
      startTimers();
    }

    function renderSavedPage() {
      const list = document.getElementById('saved-list');
      const empty = document.getElementById('saved-empty');
      if(list) list.innerHTML = ''; 
      if(empty) empty.style.display = 'block';
    }

    function renderRiwayat() {
      const filterEl = document.getElementById('riwayat-filter');
      const searchEl = document.getElementById('riwayat-search');
      const search = (searchEl ? searchEl.value : '').toLowerCase();
      let data = historyData;
      if (search) data = data.filter(h => (h.customer || '').toLowerCase().includes(search) || (h.unit_name || '').toLowerCase().includes(search));
      const rc = document.getElementById('riwayat-count');
      if(rc) rc.textContent = `${data.length} transaksi`;
      const tb = document.getElementById('tbl-riwayat');
      if(!tb) return;
      if (!data.length) { tb.innerHTML = '<tr><td colspan="10" style="text-align:center;color:var(--muted);padding:24px">Belum ada riwayat</td></tr>'; return; }
      tb.innerHTML = data.map((h, i) => {
        let badgeHTML = '';
        if (h.tipe_struk === 'selesai') {
          badgeHTML = '<span class="tag-mode tag-selesai">✅ Selesai</span>';
        } else if (h.tipe_struk === 'simpan_jam') {
          badgeHTML = '<span class="tag-mode tag-simpan-jam">🎟️ Simpan Jam</span>';
        } else {
          badgeHTML = '<span class="tag-mode tag-gray">—</span>';
        }

        let custHTML = esc(h.customer);
        if (h.tipe_struk === 'simpan_jam' && Number(h.saved_minutes || 0) > 0) {
          const tokenText = h.token_code ? `TOKEN: ${esc(h.token_code)}` : 'token tidak ditemukan';
          custHTML += `<br><small style="color:var(--muted2);font-size:0.75rem">Sisa ${h.saved_minutes} menit &rarr; ${tokenText}</small>`;
        }

        return `
    <tr>
      <td class="mono">${data.length - i}</td>
      <td>${esc(h.unit_name)}</td>
      <td><span class="tag-mode tag-ps">PS</span></td>
      <td>${badgeHTML}</td>
      <td>${custHTML}</td>
      <td>${fmtDur(h.duration_minutes)}</td>
      <td class="mono">${fmtTime(h.start_time)}</td>
      <td class="mono">${fmtTime(h.end_time)}</td>
      <td class="mono" style="color:var(--gold);font-weight:700">${rp(h.total)}</td>
      <td><button class="del-btn" data-id="${h.id}" onclick="hapusSatuRiwayat(this.getAttribute('data-id'))">🗑️</button></td>
    </tr>`;
      }).join('');
    }

    // - RENDER LAPORAN -
    function renderLaporan() {
      const todayH = historyData.filter(h => isToday(h.created_at));
      const weekH = historyData.filter(h => new Date(h.created_at) >= startOfWeek());
      const revH = todayH.reduce((a, h) => a + Number(h.total || 0), 0);
      const revW = weekH.reduce((a, h) => a + Number(h.total || 0), 0);
      const avgD = todayH.length ? Math.round(todayH.reduce((a, h) => a + Number(h.duration_minutes || 0), 0) / todayH.length) : 0;

      const lh = document.getElementById('lap-hari'); if(lh) lh.textContent = rp(revH);
      const lm = document.getElementById('lap-minggu'); if(lm) lm.textContent = rp(revW);
      const lps = document.getElementById('lap-ps'); if(lps) lps.textContent = todayH.length + ' sesi';
      const lpc = document.getElementById('lap-pc'); if(lpc) lpc.textContent = '0 sesi';
      const ls = document.getElementById('lap-sesi'); if(ls) ls.textContent = todayH.length + ' sesi';
      const la = document.getElementById('lap-avg'); if(la) la.textContent = fmtDur(avgD);

      // Bar chart 7 hari
      const chart = document.getElementById('chart-bars');
      if(chart) {
        const days = [];
        for (let i = 6; i >= 0; i--) {
          const d = new Date(); d.setDate(d.getDate() - i); d.setHours(0, 0, 0, 0);
          const dayH = historyData.filter(h => { const hd = new Date(h.created_at); hd.setHours(0, 0, 0, 0); return hd.getTime() === d.getTime(); });
          days.push({ label: d.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric' }), rev: dayH.reduce((a, h) => a + Number(h.total || 0), 0) });
        }
        const maxRev = Math.max(...days.map(d => d.rev), 1);
        chart.innerHTML = days.map(d => `
      <div class="bar-row">
        <div class="bar-lbl">${d.label}</div>
        <div class="bar-bg"><div class="bar-fill" style="width:${(d.rev / maxRev * 100).toFixed(1)}%"></div></div>
        <div class="bar-val">${d.rev > 0 ? rp(d.rev) : ''}</div>
      </div>`).join('');
      }

      // Table hari ini
      const tb = document.getElementById('tbl-laporan');
      if(!tb) return;
      if (!todayH.length) { tb.innerHTML = '<tr><td colspan="5" style="text-align:center;color:var(--muted);padding:20px">Belum ada transaksi hari ini</td></tr>'; return; }
      tb.innerHTML = todayH.map(h => `
    <tr>
      <td>${esc(h.unit_name)}</td>
      <td><span class="tag-mode tag-ps">PS</span></td>
      <td>${esc(h.customer)}</td>
      <td>${fmtDur(h.duration_minutes)}</td>
      <td class="mono" style="color:var(--gold);font-weight:700">${rp(h.total)}</td>
    </tr>`).join('');
    }

    // - EXPORT CSV -
    function exportCSV(scope) {
      const data = scope === 'today' ? historyData.filter(h => isToday(h.created_at)) : historyData;
      if (!data.length) { toast('Tidak ada data untuk diekspor', 'err'); return; }
      const rows = [['No', 'Unit', 'Mode', 'Pelanggan', 'Durasi (menit)', 'Mulai', 'Selesai', 'Total']];
      data.forEach((h, i) => rows.push([i + 1, h.unit_name, 'PS', h.customer, h.duration_minutes, fmtTime(h.start_time), fmtTime(h.end_time), h.total]));
      const csv = rows.map(r => r.join(',')).join('\n');
      const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
      const link = document.createElement('a');
      link.href = URL.createObjectURL(blob);
      link.download = `YK2 Gaming-riwayat-${new Date().toLocaleDateString('id-ID').replace(/\//g, '-')}.csv`;
      link.click();
      toast('CSV berhasil diunduh!', 'ok');
    }

    // - MODAL MULAI -
    function showModalMulai(unitId) {
      const u = units.find(x => x.id === unitId);
      if (!u) return;
      miUnitId = unitId; miJam = 1; miConsole = u.tipe || 'PS3';
      document.getElementById('mi-unit').value = `${u.tipe} ${u.nomor} — ${rp(u.harga)}/jam`;
      document.getElementById('mi-nama').value = '';
      document.getElementById('mi-console-custom')?.remove();
      buildPkgBtns('mi', u.harga);
      updateJamDisplay('mi', miJam, u.harga);
      // Reset metode pembayaran ke Cash saat modal dibuka
      miPayMethod = 'tunai';
      setMiPayMethod('tunai');
      openModal('modal-mulai');
    }

    function buildPkgBtns(prefix, harga) {
      const el = document.getElementById(prefix + '-pkg');
      if (!el) return;
      el.innerHTML = [1, 2, 3, 4, 6, 8].map(j => `<button class="pkg-btn" onclick="setPkg('${prefix}',${j})">${j} Jam</button>`).join('');
    }

    function setPkg(prefix, jam) {
      if (prefix === 'mi') miJam = jam; else tjJam = jam;
      const u = units.find(x => x.id === (prefix === 'mi' ? miUnitId : tjUnitId));
      updateJamDisplay(prefix, jam, u?.harga || 10000);
      document.querySelectorAll(`#${prefix}-pkg .pkg-btn`).forEach((b, i) => b.classList.toggle('sel', [1, 2, 3, 4, 6, 8][i] === jam));
    }

    function changeJam(prefix, delta) {
      if (prefix === 'mi') { miJam = Math.max(1, Math.min(12, miJam + delta)); }
      else { tjJam = Math.max(1, Math.min(8, tjJam + delta)); }
      const jam = prefix === 'mi' ? miJam : tjJam;
      const u = units.find(x => x.id === (prefix === 'mi' ? miUnitId : tjUnitId));
      updateJamDisplay(prefix, jam, u?.harga || 10000);
      document.querySelectorAll(`#${prefix}-pkg .pkg-btn`).forEach(b => b.classList.remove('sel'));
    }

    function updateJamDisplay(prefix, jam, harga) {
      const total = jam * harga;
      const endTime = new Date(Date.now() + jam * 3600 * 1000);
      const jd = document.getElementById(prefix + '-jam-disp');
      if(jd) jd.textContent = jam + ' JAM';
      const hint = document.getElementById(prefix + '-jam-hint');
      if (hint) hint.textContent = `Selesai pukul ${fmtTime(endTime.toISOString())} — Bayar ${rp(total)}`;
      const totEl = document.getElementById(prefix + '-total');
      if (totEl) totEl.textContent = rp(total);
      // Sync QRIS nominal (hanya untuk prefix 'mi')
      if (prefix === 'mi') {
        const qrisNom = document.getElementById('mi-qris-nominal');
        if (qrisNom) qrisNom.textContent = rp(total);
        // Sync kembalian jika nominal sudah diisi
        const nomEl = document.getElementById('mi-nominal');
        if (nomEl && nomEl.value) miHitungKembalian(total, parseFloat(nomEl.value));
      }
    }

    function setMiPayMethod(method) {
      miPayMethod = method;
      const cashBtn  = document.getElementById('mi-pay-cash-btn');
      const qrisBtn  = document.getElementById('mi-pay-qris-btn');
      const cashPanel = document.getElementById('mi-pay-cash-panel');
      const qrisPanel = document.getElementById('mi-pay-qris-panel');
      const submitBtn = document.getElementById('mi-submit-btn');
      if (!cashBtn || !qrisBtn) return;
      if (method === 'tunai') {
        cashBtn.style.cssText  = 'flex:1; padding:10px; border-radius:9px; font-size:.88rem; font-weight:700; border:2px solid var(--green); background:var(--green); color:white; cursor:pointer; transition:all .2s;';
        qrisBtn.style.cssText  = 'flex:1; padding:10px; border-radius:9px; font-size:.88rem; font-weight:700; border:2px solid var(--border2); background:var(--surface2); color:var(--muted2); cursor:pointer; transition:all .2s;';
        if (cashPanel) cashPanel.style.display = 'block';
        if (qrisPanel) qrisPanel.style.display = 'none';
        if (submitBtn) submitBtn.textContent = '- Mulai & Bayar Cash';
      } else {
        qrisBtn.style.cssText  = 'flex:1; padding:10px; border-radius:9px; font-size:.88rem; font-weight:700; border:2px solid var(--pc); background:var(--pc); color:white; cursor:pointer; transition:all .2s;';
        cashBtn.style.cssText  = 'flex:1; padding:10px; border-radius:9px; font-size:.88rem; font-weight:700; border:2px solid var(--border2); background:var(--surface2); color:var(--muted2); cursor:pointer; transition:all .2s;';
        if (cashPanel) cashPanel.style.display = 'none';
        if (qrisPanel) qrisPanel.style.display = 'block';
        if (submitBtn) submitBtn.textContent = '- Mulai & Konfirmasi QRIS';
        // Sync nominal QRIS
        const u = units.find(x => x.id === miUnitId);
        if (u) {
          const nom = document.getElementById('mi-qris-nominal');
          if (nom) nom.textContent = rp(miJam * u.harga);
        }
      }
    }

    function miUangPas() {
      const u = units.find(x => x.id === miUnitId);
      if (!u) return;
      const total = miJam * u.harga;
      const nomEl = document.getElementById('mi-nominal');
      if (nomEl) { nomEl.value = total; miHitungKembalian(total, total); }
    }

    function miHitungKembalian(total, diterima) {
      const el = document.getElementById('mi-kembalian');
      if (!el) return;
      const kembalian = diterima - total;
      if (isNaN(diterima) || diterima === '') { el.textContent = ''; return; }
      if (kembalian < 0) {
        el.style.color = 'var(--ps)';
        el.textContent = `Kurang: Rp ${Math.abs(kembalian).toLocaleString('id-ID')}`;
      } else {
        el.style.color = 'var(--green)';
        el.textContent = kembalian === 0 ? 'Uang pas ✔' : `Kembalian: Rp ${kembalian.toLocaleString('id-ID')}`;
      }
    }

    function selConsole(type, prefix) { miConsole = type; updateConsoleBtns(prefix, type); const cc = document.getElementById(prefix + '-console-custom'); if(cc) cc.value = ''; }
    function setConsoleCustom(prefix) { const val = document.getElementById(prefix + '-console-custom').value; if (val) { miConsole = val; updateConsoleBtns(prefix, null); } }
    function updateConsoleBtns(prefix, sel) {
      const btns = document.querySelectorAll('#' + prefix + '-console-btns .console-btn');
      const map = ['PS3', 'PS4', 'PS5'];
      btns.forEach((b, i) => { b.className = 'console-btn'; if (sel && sel === map[i]) b.className = 'console-btn sel-' + sel.toLowerCase(); });
    }

    function showStruk({ type, unit, konsol, nama, mulai, durasi, berakhir, total }) {
      const badgeCls = { awal: 'sb-awal', tambah: 'sb-tambah', resume: 'sb-resume' }[type] || 'sb-awal';
      const badgeTxt = { awal: 'PEMBAYARAN AWAL', tambah: 'TAMBAH WAKTU', resume: 'LANJUT SESI' }[type] || '';
      document.getElementById('s-badge').className = 'struk-badge ' + badgeCls;
      document.getElementById('s-badge').textContent = badgeTxt;
      document.getElementById('s-unit').textContent = unit;
      document.getElementById('s-mode').textContent = 'PlayStation';
      document.getElementById('s-nama').textContent = nama;
      document.getElementById('s-mulai').textContent = fmtTime(mulai instanceof Date ? mulai.toISOString() : mulai);
      document.getElementById('s-durasi').textContent = fmtDur(durasi);
      document.getElementById('s-berakhir').textContent = fmtTime(berakhir instanceof Date ? berakhir.toISOString() : berakhir);
      document.getElementById('s-total').textContent = total > 0 ? rp(total) : 'GRATIS';
      const kr = document.getElementById('s-konsol-row');
      if (konsol) { kr.style.display = 'flex'; document.getElementById('s-konsol').textContent = konsol; }
      else kr.style.display = 'none';
      openModal('modal-struk');
    }

    function showModalUnit(id) {
      const u = id ? units.find(x => x.id == id) : null;
      editingUnitId = id || null;
      document.getElementById('mu-title').textContent = u ? '📝 Edit Unit' : '+ Tambah Unit';
      document.getElementById('eu-no').value = u ? u.nomor : '';
      document.getElementById('eu-tipe').value = u ? u.tipe : '';
      document.getElementById('eu-harga').value = u ? u.harga : '';
      openModal('modal-unit');
    }
    
    function euSelConsole(tipe) {
      document.getElementById('eu-tipe').value = tipe;
    }

    function showModalTambah(unitId) {
      const u = units.find(x => x.id == unitId);
      const s = getSess(unitId);
      if (!u || !s) return;
      tjUnitId = u.id; tjSessId = s.id; tjJam = 1;
      document.getElementById('tj-unit').value = `${u.tipe} ${u.nomor} — ${rp(u.harga)}/jam`;
      updateJamDisplay('tj', tjJam, u.harga);
      openModal('modal-tambah');
    }

    function showModalStop(unitId) {
      const u = units.find(x => x.id == unitId);
      const s = getSess(unitId);
      if (!u || !s) return;
      stopUnitId = u.id; stopSessId = s.id;
      document.getElementById('stop-unit').textContent = `${u.tipe} ${u.nomor}`;
      document.getElementById('stop-nama').textContent = s.customer;
      document.getElementById('stop-mulai').textContent = fmtTime(s.start_time);
      const rem = remainingSecs(s);
      const cls = rem <= 0 ? 't-over' : rem <= 300 ? 't-warn' : 't-ok';
      const rEl = document.getElementById('stop-sisa');
      rEl.textContent = rem <= 0 ? 'WAKTU HABIS' : fmtCountdown(Math.max(0,rem));
      rEl.className = cls;
      openModal('modal-stop');
    }

    // - MODAL GENERATE TOKEN -
    let _tkUnitId = null, _tkRemMins = 0;
    function showModalToken(unitId, purchasedMins, remMins) {
      if (purchasedMins < 15) {
        toast('Sisa waktu terlalu sedikit untuk disimpan ke token (minimal 15 menit)', 'err');
        return;
      }
      const u = units.find(x => x.id === unitId);
      const s = getSess(unitId);
      if (!u || !s) return;
      _tkUnitId = unitId;
      _tkRemMins = purchasedMins;  // store purchased duration, not countdown
      document.getElementById('tk-unit').textContent = `${u.tipe} ${u.nomor}`;
      document.getElementById('tk-cust').textContent = s.customer;
      const h = Math.floor(remMins / 60), m = remMins % 60;
      document.getElementById('tk-sisa').textContent = (h > 0 ? `${h} jam ` : '') + `${m} menit`;
      document.getElementById('tk-result').style.display = 'none';
      
      const btnGen = document.getElementById('tk-btn-generate');
      btnGen.style.display = '';
      btnGen.disabled = false;
      btnGen.textContent = '🎟️ Generate Token';
      
      document.getElementById('tk-btn-batal').textContent = 'Batal';
      openModal('modal-token');
    }

    async function doGenerateToken() {
      const btn = document.getElementById('tk-btn-generate');
      btn.disabled = true;
      btn.textContent = 'Menyimpan...';
      try {
        const u = units.find(x => x.id === _tkUnitId);
        const s = getSess(_tkUnitId);
        if (!u || !s) throw new Error('Data unit/sesi tidak ditemukan');

        // 1. Generate token (simpan sisa jam)
        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'generate_token', unit_id: _tkUnitId, remaining_minutes: _tkRemMins })
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);

        // 2. Akhiri sesi (hapus dari sessions, masuk ke history dengan tipe_struk = 'simpan_jam')
        const endNow = new Date();
        const durationMin = s.duration_minutes;
        const total = (durationMin / 60) * u.harga;  // prepaid: exact integer, no rounding
        await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'stop_session',
            session_id: s.id,
            unit_id: u.id,
            unit_name: `${u.tipe} ${u.nomor}`,
            mode: 'ps',
            tipe: u.tipe,
            customer: s.customer,
            duration_minutes: durationMin,
            remaining_minutes: _tkRemMins,
            total: total,
            start_time: s.start_time,
            end_time: toLocalSQL(endNow),
            tipe_struk: 'simpan_jam'
          })
        });

        // 3. Tampilkan kode token & refresh UI
        document.getElementById('tk-code').textContent = data.token_code;
        document.getElementById('tk-result').style.display = 'block';
        btn.style.display = 'none';
        document.getElementById('tk-btn-batal').textContent = 'Tutup';
        toast(`Token ${data.token_code} dibuat. Sesi ${u.tipe} ${u.nomor} selesai.`, 'purple', 5000);
        await fetchAll();
      } catch(e) {
        toast('Gagal generate token: ' + e.message, 'err');
        btn.disabled = false;
        btn.textContent = '🎟️ Generate Token';
      }
    }

    // - VERIFIKASI TOKEN PAGE -
    let _vtTokenData = null;

    function renderTokenPage() {
      // Populate unit dropdown dengan unit yang available
      const sel = document.getElementById('vt-unit-sel');
      if (!sel) return;
      const availUnits = units.filter(u => unitStatus(u) === 'available');
      sel.innerHTML = '<option value="">-- Pilih unit --</option>' +
        availUnits.map(u => `<option value="${u.id}">${u.tipe} ${u.nomor} — ${rp(u.harga)}/jam</option>`).join('');
    }

    async function verifikasiToken() {
      let code = (document.getElementById('vt-input').value || '').trim().toUpperCase();
      // Auto-prefix
      if (code.length === 4 && !code.startsWith('YK2-')) code = 'YK2-' + code;
      document.getElementById('vt-input').value = code;

      const errBox   = document.getElementById('vt-error');
      const errMsg   = document.getElementById('vt-error-msg');
      const resBox   = document.getElementById('vt-result');
      const loading  = document.getElementById('vt-loading');
      const btn      = document.getElementById('vt-btn');

      errBox.style.display  = 'none';
      resBox.style.display  = 'none';
      loading.style.display = 'block';
      btn.disabled = true;

      if (!code.startsWith('YK2-') || code.length !== 8) {
        loading.style.display = 'none';
        btn.disabled = false;
        errMsg.textContent = 'Format tidak valid. Harus YK2-XXXX (4 karakter setelah YK2-)';
        errBox.style.display = 'block';
        return;
      }

      try {
        const res = await fetch(`api.php?action=verify_token&token_code=${encodeURIComponent(code)}`);
        const data = await res.json();
        loading.style.display = 'none';
        btn.disabled = false;

        if (data.error) {
          errMsg.textContent = data.error;
          errBox.style.display = 'block';
          _vtTokenData = null;
          return;
        }

        _vtTokenData = data;
        document.getElementById('vt-code-disp').textContent = data.token_code;
        document.getElementById('vt-cust').textContent = data.customer_name;
        document.getElementById('vt-unit').textContent = data.unit_name;
        const rm = data.remaining_minutes;
        const h = Math.floor(rm / 60), m = rm % 60;
        document.getElementById('vt-time').textContent = (h > 0 ? `${h} JAM ` : '') + `${m} MENIT`;

        // Refresh dropdown unit available
        renderTokenPage();
        resBox.style.display = 'block';

      } catch(e) {
        loading.style.display = 'none';
        btn.disabled = false;
        errMsg.textContent = 'Terjadi kesalahan jaringan: ' + e.message;
        errBox.style.display = 'block';
      }
    }

    async function gunakanToken() {
      if (!_vtTokenData) return;
      const unitSel = document.getElementById('vt-unit-sel');
      const unitId  = unitSel?.value;
      if (!unitId) { toast('Pilih unit terlebih dahulu!', 'err'); return; }

      const u = units.find(x => x.id === unitId);
      if (!u) { toast('Unit tidak ditemukan!', 'err'); return; }

      const useBtn = document.getElementById('vt-use-btn');
      useBtn.disabled = true;
      useBtn.textContent = 'Memproses...';

      try {
        // Hitung start & end dari JS (waktu lokal WIB), bukan dari PHP server
        const startNow = new Date();
        const endTime  = new Date(startNow.getTime() + _vtTokenData.remaining_minutes * 60 * 1000);

        const res = await fetch('api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            action: 'use_token',
            token_code: _vtTokenData.token_code,
            unit_id: unitId,
            start_time: toLocalSQL(startNow),
            end_time: toLocalSQL(endTime)
          })
        });
        const data = await res.json();
        if (data.error) throw new Error(data.error);

        toast(`✅ Token digunakan! Sesi ${u.tipe} ${u.nomor} dimulai (${_vtTokenData.remaining_minutes} menit)`, 'ok', 5000);

        // Reset semua state agar bisa dipakai lagi
        _vtTokenData = null;
        document.getElementById('vt-input').value = '';
        document.getElementById('vt-result').style.display = 'none';
        document.getElementById('vt-error').style.display  = 'none';
        useBtn.disabled = false;
        useBtn.textContent = '▶ Gunakan Token — Mulai Sesi Baru';

        await fetchAll();
        showPage('dashboard');

      } catch(e) {
        toast('Gagal: ' + e.message, 'err');
        useBtn.disabled = false;
        useBtn.textContent = '▶ Gunakan Token — Mulai Sesi Baru';
      }
    }

    // - MODAL HELPERS -
    function openModal(id) { const el = document.getElementById(id); if(el) el.classList.add('show'); }
    function closeModal(id) { const el = document.getElementById(id); if(el) el.classList.remove('show'); }
    document.querySelectorAll('.overlay').forEach(o => o.addEventListener('click', e => { if (e.target === o) o.classList.remove('show'); }));

  </script>
  <script src="app.js?v=1778541406"></script>
</body>

</html>
