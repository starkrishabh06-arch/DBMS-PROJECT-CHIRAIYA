<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/header.php" ?>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mission – ExpenseHeist</title>
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
          <li class="nav_menu_item"><a href="mission.php" class="nav_menu_link active">Mission</a></li>
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
      <span>Objective — Active</span>
    </div>
    <h1 class="page-title">Mission</h1>
    <p class="page-subtitle">Know where every rupee goes. Execute with precision.</p>
  </div>
</section>

<!-- ░░░░░░░░░░  MISSION CONTENT  ░░░░░░░░░░ -->
<section class="mission-section">
  <div class="container">

    <!-- Brief intro block -->
    <div class="brief-block">
      <div class="brief-label"><i class="ri-file-text-line"></i> Classified Brief</div>
      <h2 class="brief-heading">Personal Expense Tracker</h2>
      <p class="brief-opening">
        Say it's the end of the month, and you're wondering <em>"Where did all my money go?"</em>
        You remember spending on food, shopping, maybe a few online orders… but you don't have a clear picture.
        That's where the Personal Expense Tracker comes in.
      </p>
    </div>

    <!-- Mission body -->
    <div class="mission-body">
      <div class="mission-text-col">
        <p class="mission-para">
          In this project, you will design and develop a Personal Expense Tracker — a system that helps users
          efficiently manage and analyze their daily expenses. The application allows users to register and log in,
          after which they can record their expenses under different categories such as food, travel, shopping, and more.
          Users can also view, update, and delete their expense records as needed.
        </p>
        <p class="mission-para">
          A key requirement is to enable users to analyze their spending patterns. The system supports features like
          sorting and filtering expenses based on categories and time periods — daily, monthly, and yearly. It also
          generates basic reports and summaries to provide insights into user spending behaviour.
        </p>
        <p class="mission-para">
          The final outcome is a functional and user-friendly application that demonstrates how databases can be used
          to manage personal financial data effectively.
        </p>
      </div>

      <div class="mission-stats-col">
        <div class="mission-stat-card">
          <i class="ri-user-line"></i>
          <span class="stat-label">User Auth</span>
          <span class="stat-desc">Register &amp; Login</span>
        </div>
        <div class="mission-stat-card">
          <i class="ri-price-tag-3-line"></i>
          <span class="stat-label">Categories</span>
          <span class="stat-desc">Food, Travel, Shopping…</span>
        </div>
        <div class="mission-stat-card">
          <i class="ri-bar-chart-2-line"></i>
          <span class="stat-label">Reports</span>
          <span class="stat-desc">Daily / Monthly / Yearly</span>
        </div>
        <div class="mission-stat-card">
          <i class="ri-database-2-line"></i>
          <span class="stat-label">DBMS Core</span>
          <span class="stat-desc">Structured Data System</span>
        </div>
      </div>
    </div>

    <!-- Objectives strip -->
    <div class="objectives-block">
      <p class="section-eyebrow">Key Objectives</p>
      <div class="objectives-grid">
        <div class="obj-item">
          <div class="obj-icon"><i class="ri-login-circle-line"></i></div>
          <div>
            <span class="obj-title">Authentication</span>
            <p class="obj-desc">User registration and secure login system.</p>
          </div>
        </div>
        <div class="obj-item">
          <div class="obj-icon"><i class="ri-add-circle-line"></i></div>
          <div>
            <span class="obj-title">Expense Logging</span>
            <p class="obj-desc">Record, update, and delete expenses across categories.</p>
          </div>
        </div>
        <div class="obj-item">
          <div class="obj-icon"><i class="ri-filter-3-line"></i></div>
          <div>
            <span class="obj-title">Sort &amp; Filter</span>
            <p class="obj-desc">Filter by category and time period for targeted insights.</p>
          </div>
        </div>
        <div class="obj-item">
          <div class="obj-icon"><i class="ri-pie-chart-2-line"></i></div>
          <div>
            <span class="obj-title">Reports &amp; Summaries</span>
            <p class="obj-desc">Generate spending reports to understand financial behaviour.</p>
          </div>
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

.mission-section { padding:2rem 1.7rem 6rem; position:relative; z-index:2; }

/* BRIEF BLOCK */
.brief-block {
  background:var(--bg-surface); border:1px solid var(--border-red); border-radius:8px;
  padding:2.5rem; margin-bottom:3rem; position:relative; overflow:hidden;
}
.brief-block::before { content:''; position:absolute; top:0; left:0; right:0; height:2px; background:var(--red); }
.brief-label { display:inline-flex; align-items:center; gap:6px; font-family:var(--font-heading); font-size:11px;
  letter-spacing:3px; text-transform:uppercase; color:var(--red); margin-bottom:1rem; }
.brief-label i { font-size:14px; }
.brief-heading { font-family:var(--font-display); font-size:clamp(28px,5vw,44px); letter-spacing:3px; color:var(--text-bright); margin-bottom:1.2rem; }
.brief-opening { font-size:16px; line-height:1.8; color:var(--text-mid); font-weight:300; }
.brief-opening em { color:var(--gold); font-style:italic; }

/* MISSION BODY */
.mission-body { display:grid; grid-template-columns:1fr 320px; gap:3rem; margin-bottom:4rem; align-items:start; }
.mission-para { font-size:15px; line-height:1.85; color:var(--text-mid); font-weight:300; margin-bottom:1.4rem; }
.mission-para:last-child { margin-bottom:0; }

.mission-stats-col { display:flex; flex-direction:column; gap:1rem; }
.mission-stat-card { background:var(--bg-card); border:1px solid var(--border); border-radius:8px;
  padding:1.2rem 1.4rem; display:flex; flex-direction:column; gap:4px;
  transition:border-color 0.3s; }
.mission-stat-card:hover { border-color:var(--border-red); }
.mission-stat-card i { font-size:20px; color:var(--red); margin-bottom:4px; }
.stat-label { font-family:var(--font-heading); font-size:15px; font-weight:600; color:var(--text-bright); }
.stat-desc { font-size:13px; color:var(--text-dim); }

/* OBJECTIVES */
.objectives-block { border-top:1px solid var(--border); padding-top:3.5rem; }
.section-eyebrow { font-family:var(--font-heading); font-size:11px; letter-spacing:4px; text-transform:uppercase; color:var(--red); margin-bottom:0.5rem; }
.objectives-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:1.5rem; margin-top:2rem; }
.obj-item { display:flex; gap:1.2rem; align-items:flex-start;
  background:var(--bg-surface); border:1px solid var(--border); border-radius:8px; padding:1.5rem;
  transition:border-color 0.3s; }
.obj-item:hover { border-color:var(--border-red); }
.obj-icon { width:40px; height:40px; flex-shrink:0; border-radius:8px;
  background:var(--red-subtle); border:1px solid var(--border-red);
  display:flex; align-items:center; justify-content:center; }
.obj-icon i { font-size:18px; color:var(--red); }
.obj-title { font-family:var(--font-heading); font-size:15px; font-weight:600; color:var(--text-bright); display:block; margin-bottom:4px; }
.obj-desc { font-size:13px; color:var(--text-mid); line-height:1.6; }

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
  .mission-body { grid-template-columns:1fr; }
  .objectives-grid { grid-template-columns:1fr; }
}
</style>
