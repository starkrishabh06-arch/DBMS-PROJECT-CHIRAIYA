<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/header.php" ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ExpenseHeist – Track. Manage. Control.</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>
</head>

<body>

<canvas id="particles-canvas"></canvas>

<section class="wrapper">
  <div class="container">
    <div class="grid-cols-2">

  
      <div class="grid-item-1">
        <div class="overline-tag">
          <span class="dot"></span>
          <span>Operation Initiated — 2026</span>
        </div>

        <h1 class="main-heading">
          <span class="title-line line-1">Expense</span>
          <span class="title-line line-2">Tracking</span>
        </h1>
        <p class="sub-heading">Track. Manage. Control Your Expense.</p>
        <p class="info-text">
          Developed as part of DBMS coursework. Optimising expense tracking through structured data system — with the precision of a master heist.
        </p>

        <div class="stats-row">
          <div class="stat-item">
            <span class="stat-num">100%</span>
            <span class="stat-lbl">Secure</span>
          </div>
          <div class="stat-divider"></div>
          <div class="stat-item">
            <span class="stat-num">0%</span>
            <span class="stat-lbl">Leakage</span>
          </div>
          <div class="stat-divider"></div>
          <div class="stat-item">
            <span class="stat-num">24/7</span>
            <span class="stat-lbl">Control</span>
          </div>
        </div>

        <div class="btn_wrapper">
          <a href="includes/index.php">
            <button class="btn view_more_btn">
              Start now <i class="ri-arrow-right-line"></i>
            </button>
          </a>
          <a href="includes/signup.php">
            <button class="btn documentation_btn">Sign Up</button>
          </a>
        </div>

      
        <div class="bella-ciao-strip">
          <span>BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp;</span>
        </div>
      </div>

     
      <div class="grid-item-2">
        <div class="building-card">
          <div class="card-scanline"></div>

         
          <div class="building-img-wrap">
            <img src="./images/lacasadepapel.jpg" alt="La Casa de Papel" class="building-img"/>
            <div class="img-red-overlay"></div>
          </div>

          <div class="badge badge-top-left">
            <i class="ri-shield-keyhole-fill"></i>
            <span>Encrypted</span>
          </div>
          <div class="badge badge-bottom-right">
            <span>Operation Active</span>
            <span class="live-dot"></span>
          </div>

          <div class="card-footer">
            <span class="card-footer-label">LA CASA DE</span>
            <span class="card-footer-value">PAPEL</span>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<section class="features-section">
  <div class="container">
    <p class="section-eyebrow">The Arsenal</p>
    <h2 class="section-title">Built for the Bold</h2>
    <div class="grid-cols-3">
      <div class="grid-col-item feature-card">
        <div class="feature-icon"><i class="ri-eye-2-line"></i></div>
        <div class="featured_info">
          <span>Full Visibility</span>
          <p>Every transaction tracked and catalogued. Nothing moves without your knowledge — the Professor sees all.</p>
        </div>
      </div>
      <div class="grid-col-item feature-card featured-highlight">
        <div class="feature-icon"><i class="ri-lock-2-line"></i></div>
        <div class="featured_info">
          <span>Zero Leaks</span>
          <p>Airtight budget controls with alert systems. Your funds stay exactly where planned — like a perfect heist.</p>
        </div>
        <div class="highlight-badge">Core</div>
      </div>
      <div class="grid-col-item feature-card">
        <div class="feature-icon"><i class="ri-line-chart-line"></i></div>
        <div class="featured_info">
          <span>Real-time Intel</span>
          <p>Live analytics updated every second. Stay ahead of your spending before the situation escalates.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include "includes/footer.php" ?>


<script>

const toggleBtn = document.querySelector('.toggle_btn');
const navMenu   = document.getElementById('navMenu');
const closeBtn  = document.getElementById('closeBtn');
if (toggleBtn) toggleBtn.addEventListener('click', () => navMenu.classList.add('show'));
if (closeBtn)  closeBtn.addEventListener('click',  () => navMenu.classList.remove('show'));


const canvas = document.getElementById('particles-canvas');
const ctx = canvas.getContext('2d');
let W, H, pts = [];

function resize() {
  W = canvas.width  = window.innerWidth;
  H = canvas.height = window.innerHeight;
}

function init() {
  pts = [];
  for (let i = 0; i < 55; i++) {
    pts.push({
      x: Math.random() * W,
      y: Math.random() * H,
      r: Math.random() * 1.4 + 0.4,
      vx: (Math.random() - 0.5) * 0.35,
      vy: (Math.random() - 0.5) * 0.35,
      a: Math.random() * 0.5 + 0.15,
    });
  }
}

function draw() {
  ctx.clearRect(0, 0, W, H);
  pts.forEach(p => {
    p.x += p.vx; p.y += p.vy;
    if (p.x < 0) p.x = W; if (p.x > W) p.x = 0;
    if (p.y < 0) p.y = H; if (p.y > H) p.y = 0;
    ctx.beginPath();
    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
    ctx.fillStyle = `rgba(200,30,30,${p.a})`;
    ctx.fill();
  });
  /* connection lines */
  for (let i = 0; i < pts.length; i++) {
    for (let j = i + 1; j < pts.length; j++) {
      const dx = pts[i].x - pts[j].x;
      const dy = pts[i].y - pts[j].y;
      const d  = Math.sqrt(dx*dx + dy*dy);
      if (d < 130) {
        ctx.beginPath();
        ctx.moveTo(pts[i].x, pts[i].y);
        ctx.lineTo(pts[j].x, pts[j].y);
        ctx.strokeStyle = `rgba(200,30,30,${0.12 * (1 - d/130)})`;
        ctx.lineWidth = 0.6;
        ctx.stroke();
      }
    }
  }
  requestAnimationFrame(draw);
}

resize(); init(); draw();
window.addEventListener('resize', () => { resize(); init(); });

/* ── staggered heading entrance ── */
document.querySelectorAll('.title-line').forEach((el, i) => {
  el.style.animationDelay = (i * 0.18) + 's';
});
</script>
</body>
</html>

<style>
/* ═══════════════════════════════════════════════
   MONEY HEIST THEME — EXPENSE TRACKER
═══════════════════════════════════════════════ */
@import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap");

*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

:root {
  --red:          #c81e1e;
  --red-dark:     #8f0f0f;
  --red-glow:     rgba(200,30,30,0.28);
  --red-subtle:   rgba(200,30,30,0.08);
  --gold:         #d4a04a;
  --gold-dim:     rgba(212,160,74,0.15);
  --bg-void:      #060608;
  --bg-surface:   #0e0e14;
  --bg-elevated:  #151520;
  --bg-card:      #111118;
  --border:       rgba(255,255,255,0.06);
  --border-red:   rgba(200,30,30,0.35);
  --text-bright:  #f5f0e8;
  --text-mid:     #9994a0;
  --text-dim:     #4e4a58;
  --fixed-header: 4.25rem;
  --font-display: 'Bebas Neue', sans-serif;
  --font-heading: 'Oswald', sans-serif;
  --font-body:    'Barlow', sans-serif;
}

html { scroll-behavior: smooth; }

body {
  font-family: var(--font-body);
  background-color: var(--bg-void);
  background-image:
    radial-gradient(ellipse 65% 55% at 80% 15%, rgba(200,30,30,0.07) 0%, transparent 65%),
    radial-gradient(ellipse 45% 40% at 10% 90%, rgba(100,15,15,0.06) 0%, transparent 55%);
  color: var(--text-bright);
  overflow-x: hidden;
  min-height: 100vh;
}

/* ── particle canvas ── */
#particles-canvas {
  position: fixed;
  inset: 0;
  z-index: 0;
  pointer-events: none;
}

ul li { list-style: none; }
a { text-decoration: none; }
button { background: transparent; border: none; outline: none; cursor: pointer; }

.container { width: 100%; position: relative; z-index: 2; }
@media (min-width: 1040px) { .container { width: 1040px; margin: 0 auto; } }

/* ═══ HEADER ═══ */
.header {
  position: sticky; top: 0; z-index: 100;
  height: var(--fixed-header);
  padding: 0 1.7rem;
  background: rgba(6,6,8,0.88);
  backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--border-red);
}

/* red underline shimmer */
.header::after {
  content: '';
  position: absolute; bottom: 0; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, transparent, var(--red), transparent);
  animation: shimmer 4s linear infinite;
}
@keyframes shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }

.nav {
  width: 100%; height: 100%;
  display: flex; align-items: center; justify-content: space-between;
}
.logo h2 {
  font-family: var(--font-display);
  font-size: 28px; letter-spacing: 2px;
  color: var(--text-bright);
}
.logo h2 span { color: var(--red); }

.nav_menu_list { display: flex; align-items: center; }
.nav_menu_list .nav_menu_item { margin: 0 1.8rem; }
.nav_menu_item .nav_menu_link {
  font-family: var(--font-heading);
  font-size: 13px; letter-spacing: 2px; text-transform: uppercase;
  color: var(--text-mid);
  transition: color 0.2s;
  position: relative; padding-bottom: 2px;
}
.nav_menu_link::after {
  content: ''; position: absolute; bottom: 0; left: 0;
  width: 0; height: 1px; background: var(--red);
  transition: width 0.25s;
}
.nav_menu_link:hover { color: var(--text-bright); }
.nav_menu_link:hover::after { width: 100%; }
.toggle_btn { font-size: 22px; color: var(--text-bright); z-index: 4; }
.nav_menu, .close_btn { display: none; }
.show { right: 3% !important; }

/* ═══ HERO ═══ */
.wrapper {
  width: 100%; padding: 5rem 1.7rem 3rem;
  position: relative; z-index: 2;
}
.grid-cols-2 {
  width: 100%;
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 3.5rem;
  align-items: center;
}

/* left col */
.grid-item-1 { padding-top: 2rem; }

.overline-tag {
  display: inline-flex; align-items: center; gap: 8px;
  font-family: var(--font-heading);
  font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
  color: var(--red);
  margin-bottom: 1.6rem;
}
.dot {
  width: 6px; height: 6px; border-radius: 50%; background: var(--red);
  box-shadow: 0 0 6px var(--red);
  animation: pulse 1.8s ease-in-out infinite;
}
@keyframes pulse {
  0%,100%{ opacity:1; transform:scale(1); }
  50%{ opacity:0.5; transform:scale(0.8); }
}

/* big display heading */
.main-heading {
  display: block;
  line-height: 0.9;
  margin-bottom: 1.2rem;
}
.title-line {
  display: block;
  font-family: var(--font-display);
  letter-spacing: 4px;
  text-transform: uppercase;
  opacity: 0;
  transform: translateY(22px);
  animation: slideIn 0.7s cubic-bezier(0.22,1,0.36,1) forwards;
}
.line-1 {
  font-size: clamp(52px, 8vw, 88px);
  color: var(--text-bright);
}
.line-2 {
  font-size: clamp(52px, 8vw, 88px);
  color: var(--red);
  -webkit-text-stroke: 0px;
}
@keyframes slideIn {
  to { opacity:1; transform:translateY(0); }
}

.sub-heading {
  font-family: var(--font-heading);
  font-size: 15px; font-weight: 400;
  letter-spacing: 2px; text-transform: uppercase;
  color: var(--gold);
  margin-bottom: 1rem;
}

.info-text {
  font-size: 15px; line-height: 1.8;
  color: var(--text-mid); font-weight: 300;
  max-width: 440px;
}

/* stats row */
.stats-row {
  display: flex; align-items: center; gap: 1.5rem;
  margin: 2rem 0;
}
.stat-item { display: flex; flex-direction: column; }
.stat-num {
  font-family: var(--font-display);
  font-size: 28px; letter-spacing: 2px;
  color: var(--text-bright);
}
.stat-lbl {
  font-family: var(--font-heading);
  font-size: 10px; letter-spacing: 2px;
  text-transform: uppercase; color: var(--text-dim);
}
.stat-divider {
  width: 1px; height: 36px;
  background: var(--border-red);
}

/* buttons */
.btn_wrapper { display: flex; gap: 12px; margin-bottom: 2.5rem; }

.btn {
  display: inline-flex; align-items: center; justify-content: center;
  font-family: var(--font-heading);
  font-size: 13px; font-weight: 600;
  letter-spacing: 2px; text-transform: uppercase;
  border-radius: 4px;
  transition: all 0.25s ease;
  color: #fff;
}
.view_more_btn {
  padding: 0 28px; height: 52px;
  background: var(--red);
  border: 1px solid rgba(200,30,30,0.6);
  box-shadow: 0 0 28px var(--red-glow), inset 0 1px 0 rgba(255,255,255,0.08);
}
.view_more_btn:hover {
  background: #e52222;
  transform: translateY(-2px);
  box-shadow: 0 0 42px var(--red-glow);
}
.view_more_btn i { margin-left: 8px; font-size: 16px; }

.documentation_btn {
  padding: 0 24px; height: 52px;
  background: transparent;
  border: 1px solid var(--border-red);
  color: var(--text-bright);
}
.documentation_btn:hover {
  background: var(--red-subtle);
  border-color: rgba(200,30,30,0.6);
  transform: translateY(-2px);
}

/* bella ciao ticker */
.bella-ciao-strip {
  font-family: var(--font-display);
  font-size: 11px; letter-spacing: 4px;
  color: var(--text-dim);
  overflow: hidden; white-space: nowrap;
}
.bella-ciao-strip span {
  display: inline-block;
  animation: ticker 12s linear infinite;
}
@keyframes ticker {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}

/* ═══ RIGHT — building card ═══ */
.grid-item-2 {
  display: flex; align-items: center; justify-content: center;
}

.building-card {
  position: relative;
  width: 100%; max-width: 480px;
  aspect-ratio: 3/4;
  background: var(--bg-card);
  border: 1px solid var(--border-red);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 60px rgba(200,30,30,0.12), 0 0 120px rgba(0,0,0,0.7);
}

/* scanline overlay */
.card-scanline {
  position: absolute; inset: 0; z-index: 4;
  background: repeating-linear-gradient(
    0deg,
    transparent,
    transparent 2px,
    rgba(0,0,0,0.04) 2px,
    rgba(0,0,0,0.04) 4px
  );
  pointer-events: none;
}

/* the image */
.building-img-wrap {
  position: absolute; inset: 0;
  overflow: hidden;
}
.building-img {
  width: 100%; height: 100%;
  object-fit: cover;
  object-position: center bottom;
  filter: grayscale(20%) contrast(1.08) brightness(0.92);
  transition: transform 6s ease;
}
.building-card:hover .building-img { transform: scale(1.04); }

/* red tint overlay */
.img-red-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(
    to bottom,
    rgba(200,30,30,0.06) 0%,
    rgba(6,6,8,0.0) 40%,
    rgba(6,6,8,0.75) 100%
  );
}

/* floating badges */
.badge {
  position: absolute; z-index: 5;
  display: flex; align-items: center; gap: 6px;
  background: rgba(6,6,8,0.78);
  backdrop-filter: blur(8px);
  border: 1px solid var(--border-red);
  border-radius: 4px;
  padding: 6px 11px;
  font-family: var(--font-heading);
  font-size: 11px; letter-spacing: 1.5px; text-transform: uppercase;
  color: var(--text-bright);
}
.badge i { color: var(--red); font-size: 14px; }
.badge-top-left { top: 14px; left: 14px; }
.badge-bottom-right { bottom: 70px; right: 14px; }
.live-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: var(--red);
  box-shadow: 0 0 6px var(--red);
  animation: pulse 1.5s ease-in-out infinite;
}

/* card footer */
.card-footer {
  position: absolute; bottom: 0; left: 0; right: 0; z-index: 5;
  display: flex; align-items: baseline; justify-content: space-between;
  padding: 12px 16px;
  background: rgba(6,6,8,0.82);
  border-top: 1px solid var(--border-red);
}
.card-footer-label {
  font-family: var(--font-heading);
  font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
  color: var(--text-dim);
}
.card-footer-value {
  font-family: var(--font-display);
  font-size: 24px; letter-spacing: 5px;
  color: var(--red);
}

/* ═══ FEATURES SECTION ═══ */
.features-section {
  padding: 5rem 1.7rem 6rem;
  position: relative; z-index: 2;
  border-top: 1px solid var(--border);
}
.features-section::before {
  content: '';
  position: absolute; top: 0; left: 0; right: 0; height: 1px;
  background: linear-gradient(90deg, transparent, var(--red-dark), transparent);
}

.section-eyebrow {
  font-family: var(--font-heading);
  font-size: 11px; letter-spacing: 4px; text-transform: uppercase;
  color: var(--red); margin-bottom: 0.5rem;
}
.section-title {
  font-family: var(--font-display);
  font-size: clamp(32px, 5vw, 52px); letter-spacing: 3px;
  color: var(--text-bright); margin-bottom: 3rem;
}

.grid-cols-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 1.5rem;
}

.feature-card {
  background: var(--bg-surface);
  border: 1px solid var(--border);
  border-radius: 6px;
  padding: 1.8rem 1.5rem;
  position: relative; overflow: hidden;
  transition: border-color 0.3s, transform 0.3s;
}
.feature-card:hover {
  border-color: var(--border-red);
  transform: translateY(-4px);
}
.feature-card::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 0; height: 2px; background: var(--red);
  transition: width 0.4s;
}
.feature-card:hover::before { width: 100%; }

.featured-highlight {
  border-color: var(--border-red);
  background: linear-gradient(135deg, var(--bg-elevated), var(--bg-surface));
}
.featured-highlight::before { width: 100%; }

.highlight-badge {
  position: absolute; top: 14px; right: 14px;
  background: var(--red);
  color: #fff;
  font-family: var(--font-heading);
  font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
  padding: 3px 9px; border-radius: 3px;
}

.feature-icon {
  width: 44px; height: 44px; border-radius: 8px;
  background: var(--red-subtle);
  border: 1px solid var(--border-red);
  display: flex; align-items: center; justify-content: center;
  margin-bottom: 1.2rem;
}
.feature-icon i { font-size: 20px; color: var(--red); }

.featured_info span {
  font-family: var(--font-heading);
  font-size: 17px; font-weight: 600; letter-spacing: 0.5px;
  color: var(--text-bright);
  display: block; margin-bottom: 0.6rem;
}
.featured_info p {
  font-size: 14px; line-height: 1.7;
  color: var(--text-mid); font-weight: 300;
}

/* ═══ FOOTER ═══ */
footer {
  height: 3px;
  background: linear-gradient(90deg, var(--red-dark), var(--red), var(--gold), var(--red), var(--red-dark));
  opacity: 0.8;
}

/* ═══ RESPONSIVE ═══ */
@media (min-width: 768px) {
  .toggle_btn { display: none; }
  .nav_menu   { display: block; }
}

@media (max-width: 768px) {
  .logo h2 { font-size: 22px; }
  .nav_menu {
    position: fixed; width: 93%; height: 100%;
    display: block; top: 2.5%; right: -100%;
    background: var(--bg-surface);
    border: 1px solid var(--border-red);
    padding: 3rem; border-radius: 12px;
    box-shadow: 0 0 60px rgba(200,30,30,0.15);
    z-index: 50; transition: 0.35s;
  }
  .nav_menu_list { flex-direction: column; align-items: flex-start; margin-top: 4rem; }
  .nav_menu_list .nav_menu_item { margin: 1rem 0; }
  .nav_menu_item .nav_menu_link { font-size: 18px; }
  .close_btn { display: block; position: absolute; right: 10%; font-size: 25px; color: var(--text-mid); }
  .bella-ciao-strip { font-size: 9px; }
}

@media (max-width: 991px) {
  .wrapper { padding-top: 3rem; }
  .grid-cols-2 { grid-template-columns: 1fr; }
  .grid-item-1 {
    order: 2;
    display: flex; flex-direction: column; align-items: center; text-align: center;
    padding-top: 0;
  }
  .line-1, .line-2 { font-size: clamp(52px, 12vw, 70px); }
  .info-text { font-size: 15px; }
  .stats-row { justify-content: center; }
  .btn_wrapper { justify-content: center; }
  .grid-item-2 { order: 1; }
  .building-card { max-width: 340px; }
  .grid-cols-3 { grid-template-columns: 1fr; }
}
</style>
