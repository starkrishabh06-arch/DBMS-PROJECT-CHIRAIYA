<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/header.php" ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>The Plan – ExpenseHeist</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>
</head>

<body>

<canvas id="particles-canvas"></canvas>

<!-- ░░░░░░░░░░  HEADER  ░░░░░░░░░░ -->
<header class="header">
  <div class="container">
    <nav class="nav">
      <div class="logo">
        <h2><a href="index.php" style="text-decoration:none;color:inherit;">Expense<span>Heist</span></a></h2>
      </div>
      <button class="toggle_btn"><i class="ri-menu-3-line"></i></button>
      <div class="nav_menu" id="navMenu">
        <button class="close_btn" id="closeBtn"><i class="ri-close-line"></i></button>
        <ul class="nav_menu_list">
          <li class="nav_menu_item"><a href="the-plan.php" class="nav_menu_link active">The Plan</a></li>
          <li class="nav_menu_item"><a href="mission.php" class="nav_menu_link">Mission</a></li>
          <li class="nav_menu_item"><a href="the-crew.php" class="nav_menu_link">The Crew</a></li>
        </ul>
      </div>
    </nav>
  </div>
</header>

<!-- ░░░░░░░░░░  PAGE HERO  ░░░░░░░░░░ -->
<section class="page-hero">
  <div class="container">
    <div class="overline-tag">
      <span class="dot"></span>
      <span>Blueprint — Classified</span>
    </div>
    <h1 class="page-title">The Plan</h1>
    <p class="page-subtitle">Every great heist starts with a plan. Ours is no different.</p>
  </div>
</section>

<!-- ░░░░░░░░░░  PLAN CONTENT  ░░░░░░░░░░ -->
<section class="plan-section">
  <div class="container">

    <div class="plan-grid">

      <!-- Phase 1 -->
      <div class="plan-card">
        <div class="plan-number">01</div>
        <div class="plan-card-body">
          <div class="plan-icon"><i class="ri-radar-line"></i></div>
          <h3 class="plan-card-title">Phase I — Reconnaissance</h3>
          <p class="plan-card-text">Coming soon. The briefing room is being set up.</p>
          <div class="plan-status pending">
            <span class="status-dot"></span>Pending
          </div>
        </div>
      </div>

      <!-- Phase 2 -->
      <div class="plan-card">
        <div class="plan-number">02</div>
        <div class="plan-card-body">
          <div class="plan-icon"><i class="ri-database-2-line"></i></div>
          <h3 class="plan-card-title">Phase II — Infrastructure</h3>
          <p class="plan-card-text">Details to be filled in. Stand by.</p>
          <div class="plan-status pending">
            <span class="status-dot"></span>Pending
          </div>
        </div>
      </div>

      <!-- Phase 3 -->
      <div class="plan-card">
        <div class="plan-number">03</div>
        <div class="plan-card-body">
          <div class="plan-icon"><i class="ri-code-s-slash-line"></i></div>
          <h3 class="plan-card-title">Phase III — Execution</h3>
          <p class="plan-card-text">The operation begins. Updates incoming.</p>
          <div class="plan-status pending">
            <span class="status-dot"></span>Pending
          </div>
        </div>
      </div>

      <!-- Phase 4 -->
      <div class="plan-card">
        <div class="plan-number">04</div>
        <div class="plan-card-body">
          <div class="plan-icon"><i class="ri-checkbox-circle-line"></i></div>
          <h3 class="plan-card-title">Phase IV — Extraction</h3>
          <p class="plan-card-text">Final delivery. The vault is almost open.</p>
          <div class="plan-status pending">
            <span class="status-dot"></span>Pending
          </div>
        </div>
      </div>

    </div>

    <!-- Timeline placeholder -->
    <div class="timeline-block">
      <p class="section-eyebrow">Timeline</p>
      <h2 class="section-title">Operation Schedule</h2>
      <div class="timeline-placeholder">
        <i class="ri-time-line"></i>
        <p>Timeline details will be updated soon.</p>
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

/* particle canvas */
const canvas = document.getElementById('particles-canvas');
const ctx = canvas.getContext('2d');
let W, H, pts = [];
function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
function init() {
  pts = [];
  for (let i = 0; i < 55; i++) {
    pts.push({ x: Math.random()*W, y: Math.random()*H, r: Math.random()*1.4+0.4,
      vx: (Math.random()-0.5)*0.35, vy: (Math.random()-0.5)*0.35, a: Math.random()*0.5+0.15 });
  }
}
function draw() {
  ctx.clearRect(0,0,W,H);
  pts.forEach(p => {
    p.x+=p.vx; p.y+=p.vy;
    if(p.x<0)p.x=W; if(p.x>W)p.x=0; if(p.y<0)p.y=H; if(p.y>H)p.y=0;
    ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
    ctx.fillStyle=`rgba(200,30,30,${p.a})`; ctx.fill();
  });
  for(let i=0;i<pts.length;i++) for(let j=i+1;j<pts.length;j++) {
    const dx=pts[i].x-pts[j].x, dy=pts[i].y-pts[j].y, d=Math.sqrt(dx*dx+dy*dy);
    if(d<130){ ctx.beginPath(); ctx.moveTo(pts[i].x,pts[i].y); ctx.lineTo(pts[j].x,pts[j].y);
      ctx.strokeStyle=`rgba(200,30,30,${0.12*(1-d/130)})`; ctx.lineWidth=0.6; ctx.stroke(); }
  }
  requestAnimationFrame(draw);
}
resize(); init(); draw();
window.addEventListener('resize',()=>{ resize(); init(); });
</script>
</body>
</html>

<style>
@import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap");
*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }
:root {
  --red:#c81e1e; --red-dark:#8f0f0f; --red-glow:rgba(200,30,30,0.28);
  --red-subtle:rgba(200,30,30,0.08); --gold:#d4a04a;
  --bg-void:#060608; --bg-surface:#0e0e14; --bg-elevated:#151520; --bg-card:#111118;
  --border:rgba(255,255,255,0.06); --border-red:rgba(200,30,30,0.35);
  --text-bright:#f5f0e8; --text-mid:#9994a0; --text-dim:#4e4a58;
  --fixed-header:4.25rem;
  --font-display:'Bebas Neue',sans-serif;
  --font-heading:'Oswald',sans-serif;
  --font-body:'Barlow',sans-serif;
}
html { scroll-behavior: smooth; }
body { background: var(--bg-void); color: var(--text-bright); font-family: var(--font-body); overflow-x: hidden; }
#particles-canvas { position:fixed; inset:0; z-index:0; pointer-events:none; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 1.7rem; position: relative; z-index: 2; }

/* HEADER */
.header { position:fixed; top:0; left:0; right:0; z-index:100; height:var(--fixed-header);
  background:rgba(6,6,8,0.85); backdrop-filter:blur(14px);
  border-bottom:1px solid var(--border); }
.nav { display:flex; align-items:center; justify-content:space-between; height:var(--fixed-header); }
.logo h2 { font-family:var(--font-display); font-size:26px; letter-spacing:3px; text-transform:uppercase; color:var(--text-bright); }
.logo h2 span { color:var(--red); }
.nav_menu_list { display:flex; align-items:center; gap:2.5rem; list-style:none; }
.nav_menu_link { font-family:var(--font-heading); font-size:13px; letter-spacing:2px; text-transform:uppercase;
  color:var(--text-mid); text-decoration:none; transition:color 0.2s; }
.nav_menu_link:hover, .nav_menu_link.active { color:var(--red); }
.toggle_btn { display:none; background:none; border:none; color:var(--text-bright); font-size:22px; cursor:pointer; }
.close_btn { display:none; background:none; border:none; color:var(--text-mid); font-size:22px; cursor:pointer; }

/* OVERLINE TAG */
.overline-tag { display:flex; align-items:center; gap:8px; margin-bottom:1.2rem; }
.dot { width:7px; height:7px; border-radius:50%; background:var(--red); box-shadow:0 0 6px var(--red); animation:pulse 1.5s ease-in-out infinite; }
.overline-tag span:last-child { font-family:var(--font-heading); font-size:12px; letter-spacing:3px; text-transform:uppercase; color:var(--text-mid); }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

/* PAGE HERO */
.page-hero { padding: calc(var(--fixed-header) + 4rem) 1.7rem 3rem; position:relative; z-index:2; }
.page-title { font-family:var(--font-display); font-size:clamp(60px,10vw,110px); letter-spacing:6px; color:var(--text-bright); line-height:0.9; }
.page-subtitle { font-family:var(--font-body); font-size:16px; color:var(--text-mid); margin-top:1rem; font-weight:300; max-width:500px; }

/* PLAN SECTION */
.plan-section { padding: 3rem 1.7rem 6rem; position:relative; z-index:2; }

.plan-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:1.5rem; margin-bottom:5rem; }

.plan-card {
  background:var(--bg-surface); border:1px solid var(--border); border-radius:8px;
  padding:2rem; position:relative; overflow:hidden;
  transition:border-color 0.3s, transform 0.3s;
}
.plan-card:hover { border-color:var(--border-red); transform:translateY(-4px); }
.plan-card::before { content:''; position:absolute; top:0; left:0; width:0; height:2px; background:var(--red); transition:width 0.4s; }
.plan-card:hover::before { width:100%; }

.plan-number { font-family:var(--font-display); font-size:72px; letter-spacing:4px; color:var(--border); position:absolute; top:0.5rem; right:1.2rem; line-height:1; pointer-events:none; }

.plan-icon { width:44px; height:44px; border-radius:8px; background:var(--red-subtle); border:1px solid var(--border-red);
  display:flex; align-items:center; justify-content:center; margin-bottom:1.2rem; }
.plan-icon i { font-size:20px; color:var(--red); }

.plan-card-title { font-family:var(--font-heading); font-size:18px; font-weight:600; letter-spacing:0.5px; color:var(--text-bright); margin-bottom:0.6rem; }
.plan-card-text { font-size:14px; line-height:1.7; color:var(--text-mid); font-weight:300; margin-bottom:1.2rem; }

.plan-status { display:inline-flex; align-items:center; gap:6px; font-family:var(--font-heading); font-size:11px; letter-spacing:2px; text-transform:uppercase; }
.plan-status.pending { color:#9994a0; }
.plan-status.active { color:var(--red); }
.status-dot { width:6px; height:6px; border-radius:50%; background:currentColor; }

/* TIMELINE */
.timeline-block { border-top:1px solid var(--border); padding-top:4rem; }
.section-eyebrow { font-family:var(--font-heading); font-size:11px; letter-spacing:4px; text-transform:uppercase; color:var(--red); margin-bottom:0.5rem; }
.section-title { font-family:var(--font-display); font-size:clamp(32px,5vw,52px); letter-spacing:3px; color:var(--text-bright); margin-bottom:2rem; }

.timeline-placeholder { display:flex; flex-direction:column; align-items:center; justify-content:center;
  gap:1rem; padding:4rem; border:1px dashed var(--border-red); border-radius:8px; text-align:center; }
.timeline-placeholder i { font-size:40px; color:var(--text-dim); }
.timeline-placeholder p { font-family:var(--font-heading); font-size:14px; letter-spacing:2px; text-transform:uppercase; color:var(--text-dim); }

footer { height:3px; background:linear-gradient(90deg,var(--red-dark),var(--red),var(--gold),var(--red),var(--red-dark)); opacity:0.8; }

/* MOBILE NAV */
@media (min-width:768px) { .toggle_btn{display:none;} .nav_menu{display:block;} }
@media (max-width:768px) {
  .logo h2 { font-size:22px; }
  .nav_menu { position:fixed; width:93%; height:100%; display:block; top:2.5%; right:-100%;
    background:var(--bg-surface); border:1px solid var(--border-red); padding:3rem;
    border-radius:12px; box-shadow:0 0 60px rgba(200,30,30,0.15); z-index:50; transition:0.35s; }
  .nav_menu.show { right:3.5%; }
  .nav_menu_list { flex-direction:column; align-items:flex-start; margin-top:4rem; }
  .nav_menu_list .nav_menu_item { margin:1rem 0; }
  .nav_menu_item .nav_menu_link { font-size:18px; }
  .close_btn { display:block; position:absolute; right:10%; font-size:25px; color:var(--text-mid); }
  .plan-grid { grid-template-columns:1fr; }
}
</style>
