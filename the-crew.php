<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/header.php" ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>The Crew – ExpenseHeist</title>
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
          <li class="nav_menu_item"><a href="the-plan.php" class="nav_menu_link">The Plan</a></li>
          <li class="nav_menu_item"><a href="mission.php" class="nav_menu_link">Mission</a></li>
          <li class="nav_menu_item"><a href="the-crew.php" class="nav_menu_link active">The Crew</a></li>
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
      <span>CSE-B — Five Members</span>
    </div>
    <h1 class="page-title">The Crew</h1>
    <p class="page-subtitle">The operatives behind the operation. Every heist needs its people.</p>
  </div>
</section>

<!-- ░░░░░░░░░░  CREW CARDS  ░░░░░░░░░░ -->
<section class="crew-section">
  <div class="container">

    <div class="crew-grid">

      <!-- Member 1 -->
      <div class="crew-card">
        <div class="card-scanline"></div>
        <div class="crew-avatar">RK</div>
        <div class="crew-info">
          <span class="crew-id">B124095</span>
          <h3 class="crew-name">Rishabh Kannaujiya</h3>
          <span class="crew-branch">CSE — Section B</span>
        </div>
        <div class="crew-badge"><i class="ri-shield-user-line"></i></div>
      </div>

      <!-- Member 2 -->
      <div class="crew-card">
        <div class="card-scanline"></div>
        <div class="crew-avatar">RN</div>
        <div class="crew-info">
          <span class="crew-id">B124100</span>
          <h3 class="crew-name">Ritesh Neti</h3>
          <span class="crew-branch">CSE — Section B</span>
        </div>
        <div class="crew-badge"><i class="ri-shield-user-line"></i></div>
      </div>

      <!-- Member 3 -->
      <div class="crew-card">
        <div class="card-scanline"></div>
        <div class="crew-avatar">RK</div>
        <div class="crew-info">
          <span class="crew-id">B124101</span>
          <h3 class="crew-name">Rohit Kumar</h3>
          <span class="crew-branch">CSE — Section B</span>
        </div>
        <div class="crew-badge"><i class="ri-shield-user-line"></i></div>
      </div>

      <!-- Member 4 -->
      <div class="crew-card">
        <div class="card-scanline"></div>
        <div class="crew-avatar">TA</div>
        <div class="crew-info">
          <span class="crew-id">B124145</span>
          <h3 class="crew-name">Tanishq Ahuja</h3>
          <span class="crew-branch">CSE — Section B</span>
        </div>
        <div class="crew-badge"><i class="ri-shield-user-line"></i></div>
      </div>

      <!-- Member 5 -->
      <div class="crew-card">
        <div class="card-scanline"></div>
        <div class="crew-avatar">YB</div>
        <div class="crew-info">
          <span class="crew-id">B124155</span>
          <h3 class="crew-name">Yuvraj Biswal</h3>
          <span class="crew-branch">CSE — Section B</span>
        </div>
        <div class="crew-badge"><i class="ri-shield-user-line"></i></div>
      </div>

    </div>

    <!-- Team stat bar -->
    <div class="team-bar">
      <div class="team-bar-item">
        <span class="tb-num">5</span>
        <span class="tb-label">Operatives</span>
      </div>
      <div class="team-bar-divider"></div>
      <div class="team-bar-item">
        <span class="tb-num">CSE-B</span>
        <span class="tb-label">Section</span>
      </div>
      <div class="team-bar-divider"></div>
      <div class="team-bar-item">
        <span class="tb-num">DBMS</span>
        <span class="tb-label">Course</span>
      </div>
      <div class="team-bar-divider"></div>
      <div class="team-bar-item">
        <span class="tb-num">2026</span>
        <span class="tb-label">Operation Year</span>
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
html { scroll-behavior:smooth; }
body { background:var(--bg-void); color:var(--text-bright); font-family:var(--font-body); overflow-x:hidden; }
#particles-canvas { position:fixed; inset:0; z-index:0; pointer-events:none; }
.container { max-width:1200px; margin:0 auto; padding:0 1.7rem; position:relative; z-index:2; }

.header { position:fixed; top:0; left:0; right:0; z-index:100; height:var(--fixed-header);
  background:rgba(6,6,8,0.85); backdrop-filter:blur(14px); border-bottom:1px solid var(--border); }
.nav { display:flex; align-items:center; justify-content:space-between; height:var(--fixed-header); }
.logo h2 { font-family:var(--font-display); font-size:26px; letter-spacing:3px; text-transform:uppercase; color:var(--text-bright); }
.logo h2 span { color:var(--red); }
.nav_menu_list { display:flex; align-items:center; gap:2.5rem; list-style:none; }
.nav_menu_link { font-family:var(--font-heading); font-size:13px; letter-spacing:2px; text-transform:uppercase;
  color:var(--text-mid); text-decoration:none; transition:color 0.2s; }
.nav_menu_link:hover, .nav_menu_link.active { color:var(--red); }
.toggle_btn { display:none; background:none; border:none; color:var(--text-bright); font-size:22px; cursor:pointer; }
.close_btn { display:none; background:none; border:none; color:var(--text-mid); font-size:22px; cursor:pointer; }

.overline-tag { display:flex; align-items:center; gap:8px; margin-bottom:1.2rem; }
.dot { width:7px; height:7px; border-radius:50%; background:var(--red); box-shadow:0 0 6px var(--red); animation:pulse 1.5s ease-in-out infinite; }
.overline-tag span:last-child { font-family:var(--font-heading); font-size:12px; letter-spacing:3px; text-transform:uppercase; color:var(--text-mid); }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.4} }

.page-hero { padding:calc(var(--fixed-header) + 4rem) 1.7rem 3rem; position:relative; z-index:2; }
.page-title { font-family:var(--font-display); font-size:clamp(60px,10vw,110px); letter-spacing:6px; color:var(--text-bright); line-height:0.9; }
.page-subtitle { font-family:var(--font-body); font-size:16px; color:var(--text-mid); margin-top:1rem; font-weight:300; max-width:500px; }

.crew-section { padding:2rem 1.7rem 6rem; position:relative; z-index:2; }

/* CREW GRID — 5 cards: 3 on top, 2 centered below */
.crew-grid {
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:1.5rem;
  margin-bottom:3rem;
}
.crew-grid .crew-card:nth-child(4) { grid-column: 1; }
.crew-grid .crew-card:nth-child(5) { grid-column: 2; }

/* CREW CARD */
.crew-card {
  background:var(--bg-card); border:1px solid var(--border); border-radius:8px;
  padding:2rem 1.5rem; position:relative; overflow:hidden;
  display:flex; flex-direction:column; align-items:center; text-align:center; gap:1rem;
  transition:border-color 0.3s, transform 0.3s;
}
.crew-card:hover { border-color:var(--border-red); transform:translateY(-6px); }
.crew-card::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:var(--red); transform:scaleX(0); transition:transform 0.4s; }
.crew-card:hover::before { transform:scaleX(1); }

.card-scanline { position:absolute; inset:0; pointer-events:none;
  background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,0,0,0.03) 2px,rgba(0,0,0,0.03) 4px); }

.crew-avatar {
  width:72px; height:72px; border-radius:50%;
  background:var(--red-subtle); border:2px solid var(--border-red);
  display:flex; align-items:center; justify-content:center;
  font-family:var(--font-display); font-size:22px; letter-spacing:2px; color:var(--red);
  position:relative; z-index:1;
}

.crew-info { position:relative; z-index:1; }
.crew-id { font-family:var(--font-heading); font-size:11px; letter-spacing:3px; text-transform:uppercase; color:var(--text-dim); display:block; margin-bottom:6px; }
.crew-name { font-family:var(--font-heading); font-size:19px; font-weight:600; color:var(--text-bright); letter-spacing:0.5px; margin-bottom:6px; }
.crew-branch { font-size:13px; color:var(--text-mid); font-weight:300; }

.crew-badge { position:absolute; top:14px; right:14px; z-index:2; color:var(--text-dim); font-size:16px; }
.crew-card:hover .crew-badge { color:var(--red); }

/* TEAM BAR */
.team-bar {
  display:flex; align-items:center; justify-content:center; gap:0;
  background:var(--bg-surface); border:1px solid var(--border); border-radius:8px;
  padding:2rem; flex-wrap:wrap; gap:1rem;
}
.team-bar-item { display:flex; flex-direction:column; align-items:center; gap:4px; padding:0 2rem; }
.tb-num { font-family:var(--font-display); font-size:28px; letter-spacing:3px; color:var(--red); }
.tb-label { font-family:var(--font-heading); font-size:11px; letter-spacing:2px; text-transform:uppercase; color:var(--text-dim); }
.team-bar-divider { width:1px; height:40px; background:var(--border); }

footer { height:3px; background:linear-gradient(90deg,var(--red-dark),var(--red),var(--gold),var(--red),var(--red-dark)); opacity:0.8; }

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
  .crew-grid { grid-template-columns:1fr; }
  .crew-grid .crew-card:nth-child(4),
  .crew-grid .crew-card:nth-child(5) { grid-column:1; }
  .team-bar-divider { display:none; }
}
@media (max-width:991px) and (min-width:769px) {
  .crew-grid { grid-template-columns:repeat(2,1fr); }
  .crew-grid .crew-card:nth-child(4) { grid-column:1; }
  .crew-grid .crew-card:nth-child(5) { grid-column:2; }
}
</style>
