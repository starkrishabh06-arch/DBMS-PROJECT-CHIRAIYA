<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExpenseHeist – Login</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
  <script src="js/auth.js"></script>
</head>
<body>

<canvas id="particles-canvas"></canvas>

<!-- ░░░░░░░░░░  HEADER  ░░░░░░░░░░ -->
<header class="header">
  <div class="container">
    <nav class="nav">
      <div class="logo">
        <h2><a href="../index.php" style="text-decoration:none;color:inherit;">Expense<span>Heist</span></a></h2>
      </div>
      <button class="toggle_btn"><i class="ri-menu-3-line"></i></button>
      <div class="nav_menu" id="navMenu">
        <button class="close_btn" id="closeBtn"><i class="ri-close-line"></i></button>
        <ul class="nav_menu_list">
          <li class="nav_menu_item"><a href="../the-plan.php" class="nav_menu_link">The Plan</a></li>
          <li class="nav_menu_item"><a href="../mission.php" class="nav_menu_link">Mission</a></li>
          <li class="nav_menu_item"><a href="../the-crew.php" class="nav_menu_link">The Crew</a></li>
        </ul>
      </div>
    </nav>
  </div>
</header>

<section class="login-section">
  <div class="login-container">

    <!-- LEFT — visual card -->
    <div class="login-left">
      <div class="brand-block">
        <div class="overline-tag">
          <span class="live-dot"></span>
          <span>Operation Initiated — 2026</span>
        </div>
        <h1 class="brand-title">Expense<span>Heist</span></h1>
        <p class="brand-sub">Track. Manage. Control Your Expense.</p>
      </div>

      <div class="stats-row">
        <div class="stat-item"><span class="stat-num">100%</span><span class="stat-lbl">Secure</span></div>
        <div class="stat-div"></div>
        <div class="stat-item"><span class="stat-num">0%</span><span class="stat-lbl">Leakage</span></div>
        <div class="stat-div"></div>
        <div class="stat-item"><span class="stat-num">24/7</span><span class="stat-lbl">Control</span></div>
      </div>

      <div class="card-visual">
        <div class="card-scanline"></div>
        <img src="images/kaka.jpg" alt="ExpenseHeist" class="hero-img"/>
        <div class="img-overlay"></div>
        <div class="card-badge top-left"><i class="ri-shield-keyhole-fill"></i><span>Encrypted</span></div>
        <div class="card-badge bottom-right"><span>Operation Active</span><span class="live-dot"></span></div>
        <div class="card-foot">
          <span class="foot-label">LA CASA DE</span>
          <span class="foot-val">PAPEL</span>
        </div>
      </div>

      <div class="bella-strip">
        <span>BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp;</span>
      </div>
    </div>

    <!-- RIGHT — login form -->
    <div class="login-right">
      <div class="form-header">
        <p class="form-eyebrow"><span class="live-dot"></span> Secure Access</p>
        <h2 class="form-title">Enter the Vault</h2>
        <p class="form-subtitle">Identify yourself, operative</p>
      </div>

      <p id="error-msg"   class="msg-box error-box"   style="display:none"></p>
      <p id="success-msg" class="msg-box success-box" style="display:none"></p>

      <form id="loginForm" class="heist-form">

        <div class="field-group">
          <label><i class="ri-mail-line"></i> Encrypted Channel</label>
          <input type="email" id="email" name="email" class="heist-input" placeholder="your@email.com" required/>
        </div>

        <div class="field-group">
          <label><i class="ri-lock-2-line"></i> Access Code</label>
          <div class="input-wrap">
            <input type="password" id="password" name="password" class="heist-input" placeholder="Enter password" required/>
            <i class="bx bx-hide show-hide"></i>
          </div>
        </div>

        <div class="form-extras">
          <label class="check-row">
            <input class="heist-check" type="checkbox" id="rememberMe"/>
            <span class="check-label">Remember me</span>
          </label>
          <a href="#!" class="forgot-link">Forgot password?</a>
        </div>

        <button type="submit" id="loginBtn" class="heist-btn">
          <span id="loginText"><i class="ri-login-box-line"></i> Enter the Vault</span>
          <span id="loginSpinner" class="spinner-border spinner-border-sm" role="status" style="display:none;"></span>
        </button>

        <p class="signup-link">No account yet? <a href="signup.php">Enlist now <i class="ri-arrow-right-line"></i></a></p>

      </form>
    </div>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
  if (typeof AuthManager !== 'undefined' && AuthManager.isAuthenticated()) {
    window.location.href = 'home.php';
  }
});

/* show/hide password */
document.querySelectorAll(".show-hide").forEach(icon=>{
  icon.addEventListener("click",()=>{
    const inp=icon.parentElement.querySelector("input");
    if(inp.type==="password"){icon.classList.replace("bx-hide","bx-show");inp.type="text";}
    else{icon.classList.replace("bx-show","bx-hide");inp.type="password";}
  });
});

/* login submit — original logic */
document.getElementById('loginForm').addEventListener('submit',function(e){
  e.preventDefault();
  var email=document.getElementById('email').value;
  var password=document.getElementById('password').value;
  var errorMsg=document.getElementById('error-msg');
  var successMsg=document.getElementById('success-msg');
  var loginBtn=document.getElementById('loginBtn');
  var loginText=document.getElementById('loginText');
  var loginSpinner=document.getElementById('loginSpinner');
  errorMsg.textContent=''; errorMsg.style.display='none';
  successMsg.textContent=''; successMsg.style.display='none';
  loginBtn.disabled=true;
  loginText.style.display='none';
  loginSpinner.style.display='inline-block';
  $.ajax({
    url:'api/login.php', type:'POST', contentType:'application/json',
    data:JSON.stringify({email,password}), dataType:'json',
    success:function(response){
      if(response.status==='success'){
        localStorage.setItem('access_token',response.access_token);
        localStorage.setItem('user_data',JSON.stringify(response.user));
        successMsg.textContent='Access granted! Entering vault…'; successMsg.style.display='block';
        setTimeout(()=>window.location.href='home.php',500);
      } else {
        errorMsg.textContent=response.message||'Invalid credentials'; errorMsg.style.display='block';
        loginBtn.disabled=false; loginText.style.display='flex'; loginSpinner.style.display='none';
      }
    },
    error:function(xhr){
      var message='An error occurred. Please try again.';
      try{var r=JSON.parse(xhr.responseText);message=r.message||message;}catch(e){}
      errorMsg.textContent=message; errorMsg.style.display='block';
      loginBtn.disabled=false; loginText.style.display='flex'; loginSpinner.style.display='none';
    }
  });
});

/* mobile nav */
const toggleBtn = document.querySelector('.toggle_btn');
const navMenu   = document.getElementById('navMenu');
const closeBtn  = document.getElementById('closeBtn');
if (toggleBtn) toggleBtn.addEventListener('click', () => navMenu.classList.add('show'));
if (closeBtn)  closeBtn.addEventListener('click',  () => navMenu.classList.remove('show'));

/* ── particle canvas ── */
const canvas=document.getElementById('particles-canvas');
if(canvas){
  const ctx=canvas.getContext('2d');
  let W,H,pts=[];
  function resize(){W=canvas.width=window.innerWidth;H=canvas.height=window.innerHeight;}
  function init(){pts=[];for(let i=0;i<55;i++)pts.push({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.4+0.4,vx:(Math.random()-0.5)*0.35,vy:(Math.random()-0.5)*0.35,a:Math.random()*0.5+0.15});}
  function draw(){ctx.clearRect(0,0,W,H);pts.forEach(p=>{p.x+=p.vx;p.y+=p.vy;if(p.x<0)p.x=W;if(p.x>W)p.x=0;if(p.y<0)p.y=H;if(p.y>H)p.y=0;ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);ctx.fillStyle=`rgba(200,30,30,${p.a})`;ctx.fill();});for(let i=0;i<pts.length;i++)for(let j=i+1;j<pts.length;j++){const dx=pts[i].x-pts[j].x,dy=pts[i].y-pts[j].y,d=Math.sqrt(dx*dx+dy*dy);if(d<130){ctx.beginPath();ctx.moveTo(pts[i].x,pts[i].y);ctx.lineTo(pts[j].x,pts[j].y);ctx.strokeStyle=`rgba(200,30,30,${0.12*(1-d/130)})`;ctx.lineWidth=0.6;ctx.stroke();}}requestAnimationFrame(draw);}
  resize();init();draw();window.addEventListener('resize',()=>{resize();init();});
}
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500;600&display=swap");
*,*::before,*::after{margin:0;padding:0;box-sizing:border-box;}
:root{--red:#c81e1e;--red-dark:#8f0f0f;--red-glow:rgba(200,30,30,0.28);--red-subtle:rgba(200,30,30,0.08);--gold:#d4a04a;--bg-void:#060608;--bg-surface:#0e0e14;--bg-elevated:#151520;--bg-card:#111118;--border:rgba(255,255,255,0.06);--border-red:rgba(200,30,30,0.35);--text-bright:#f5f0e8;--text-mid:#9994a0;--text-dim:#4e4a58;}
html,body{height:100%;}
body{font-family:'Barlow',sans-serif;background-color:var(--bg-void);background-image:radial-gradient(ellipse 65% 55% at 80% 15%,rgba(200,30,30,0.07) 0%,transparent 65%),radial-gradient(ellipse 45% 40% at 10% 90%,rgba(100,15,15,0.06) 0%,transparent 55%);color:var(--text-bright);overflow-x:hidden;}
#particles-canvas{position:fixed;inset:0;z-index:0;pointer-events:none;}
/* HEADER */
.container{max-width:1200px;margin:0 auto;padding:0 1.7rem;position:relative;z-index:2;}
.header{position:fixed;top:0;left:0;right:0;z-index:100;height:4.25rem;background:rgba(6,6,8,0.85);backdrop-filter:blur(14px);border-bottom:1px solid var(--border);}
.nav{display:flex;align-items:center;justify-content:space-between;height:4.25rem;}
.logo h2{font-family:'Bebas Neue',sans-serif;font-size:26px;letter-spacing:3px;text-transform:uppercase;color:var(--text-bright);}
.logo h2 span{color:var(--red);}
.nav_menu_list{display:flex;align-items:center;gap:2.5rem;list-style:none;}
.nav_menu_link{font-family:'Oswald',sans-serif;font-size:13px;letter-spacing:2px;text-transform:uppercase;color:var(--text-mid);text-decoration:none;transition:color 0.2s;}
.nav_menu_link:hover,.nav_menu_link.active{color:var(--red);}
.toggle_btn{display:none;background:none;border:none;color:var(--text-bright);font-size:22px;cursor:pointer;}
.close_btn{display:none;background:none;border:none;color:var(--text-mid);font-size:22px;cursor:pointer;}
@media(min-width:768px){.toggle_btn{display:none;}.nav_menu{display:block;}}
@media(max-width:768px){
  .logo h2{font-size:22px;}
  .nav_menu{position:fixed;width:93%;height:100%;display:block;top:2.5%;right:-100%;background:var(--bg-surface);border:1px solid var(--border-red);padding:3rem;border-radius:12px;box-shadow:0 0 60px rgba(200,30,30,0.15);z-index:50;transition:0.35s;}
  .nav_menu.show{right:3.5%;}
  .nav_menu_list{flex-direction:column;align-items:flex-start;margin-top:4rem;}
  .nav_menu_list .nav_menu_item{margin:1rem 0;}
  .nav_menu_item .nav_menu_link{font-size:18px;}
  .close_btn{display:block;position:absolute;right:10%;font-size:25px;color:var(--text-mid);}
}
/* LOGIN */
.login-section{position:relative;z-index:2;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:calc(4.25rem + 40px) 20px 40px;}
.login-container{display:grid;grid-template-columns:1fr 1fr;max-width:960px;width:100%;background:var(--bg-surface);border:1px solid var(--border-red);border-radius:8px;overflow:hidden;box-shadow:0 0 80px rgba(200,30,30,0.1),0 0 160px rgba(0,0,0,0.8);}
/* LEFT */
.login-left{background:var(--bg-card);border-right:1px solid var(--border-red);padding:44px 36px;display:flex;flex-direction:column;gap:24px;position:relative;overflow:hidden;}
.login-left::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--red),transparent);animation:shimmer 4s linear infinite;}
@keyframes shimmer{0%{transform:translateX(-100%)}100%{transform:translateX(100%)}}
.overline-tag{display:inline-flex;align-items:center;gap:8px;font-family:'Oswald',sans-serif;font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--red);}
.live-dot{width:7px;height:7px;border-radius:50%;background:var(--red);box-shadow:0 0 6px var(--red);animation:pulse 1.6s ease-in-out infinite;flex-shrink:0;}
@keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:0.5;transform:scale(0.8)}}
.brand-title{font-family:'Bebas Neue',sans-serif;font-size:40px;letter-spacing:3px;color:var(--text-bright);line-height:1;}
.brand-title span{color:var(--red);}
.brand-sub{font-family:'Oswald',sans-serif;font-size:12px;letter-spacing:2px;text-transform:uppercase;color:var(--gold);margin-top:6px;}
.stats-row{display:flex;align-items:center;gap:20px;}
.stat-item{display:flex;flex-direction:column;}
.stat-num{font-family:'Bebas Neue',sans-serif;font-size:26px;letter-spacing:2px;color:var(--text-bright);}
.stat-lbl{font-family:'Oswald',sans-serif;font-size:10px;letter-spacing:2px;text-transform:uppercase;color:var(--text-dim);}
.stat-div{width:1px;height:32px;background:var(--border-red);}
.card-visual{position:relative;border-radius:6px;overflow:hidden;border:1px solid var(--border-red);aspect-ratio:4/3;box-shadow:0 0 40px rgba(200,30,30,0.1);}
.card-scanline{position:absolute;inset:0;z-index:4;pointer-events:none;background:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,0,0,0.04) 2px,rgba(0,0,0,0.04) 4px);}
.hero-img{width:100%;height:100%;object-fit:cover;filter:grayscale(20%) contrast(1.08) brightness(0.85);transition:transform 6s ease;}
.card-visual:hover .hero-img{transform:scale(1.04);}
.img-overlay{position:absolute;inset:0;background:linear-gradient(to bottom,rgba(200,30,30,0.05) 0%,rgba(6,6,8,0) 40%,rgba(6,6,8,0.8) 100%);}
.card-badge{position:absolute;z-index:5;display:flex;align-items:center;gap:6px;background:rgba(6,6,8,0.78);backdrop-filter:blur(8px);border:1px solid var(--border-red);border-radius:4px;padding:5px 10px;font-family:'Oswald',sans-serif;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:var(--text-bright);}
.card-badge i{color:var(--red);font-size:13px;}
.top-left{top:12px;left:12px;}.bottom-right{bottom:54px;right:12px;}
.card-foot{position:absolute;bottom:0;left:0;right:0;z-index:5;display:flex;align-items:baseline;justify-content:space-between;padding:8px 14px;background:rgba(6,6,8,0.85);border-top:1px solid var(--border-red);}
.foot-label{font-family:'Oswald',sans-serif;font-size:10px;letter-spacing:3px;text-transform:uppercase;color:var(--text-dim);}
.foot-val{font-family:'Bebas Neue',sans-serif;font-size:20px;letter-spacing:4px;color:var(--red);}
.bella-strip{font-family:'Bebas Neue',sans-serif;font-size:10px;letter-spacing:4px;color:var(--text-dim);overflow:hidden;white-space:nowrap;}
.bella-strip span{display:inline-block;animation:ticker 14s linear infinite;}
@keyframes ticker{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
/* RIGHT */
.login-right{padding:44px 44px;display:flex;flex-direction:column;justify-content:center;gap:24px;}
.form-eyebrow{display:inline-flex;align-items:center;gap:8px;font-family:'Oswald',sans-serif;font-size:11px;letter-spacing:3px;text-transform:uppercase;color:var(--red);}
.form-title{font-family:'Bebas Neue',sans-serif;font-size:42px;letter-spacing:3px;color:var(--text-bright);line-height:1;}
.form-subtitle{font-family:'Oswald',sans-serif;font-size:13px;letter-spacing:1px;color:var(--text-mid);margin-top:4px;}
.msg-box{padding:10px 14px;border-radius:4px;font-family:'Oswald',sans-serif;font-size:13px;letter-spacing:0.5px;text-align:center;}
.error-box{background:rgba(200,30,30,0.12);border:1px solid rgba(200,30,30,0.4);color:#ff7070;}
.success-box{background:rgba(30,150,50,0.12);border:1px solid rgba(30,150,50,0.4);color:#4eca7f;}
.heist-form{display:flex;flex-direction:column;gap:18px;}
.field-group{display:flex;flex-direction:column;gap:6px;}
.field-group label{font-family:'Oswald',sans-serif;font-size:11px;font-weight:600;letter-spacing:2px;text-transform:uppercase;color:var(--text-mid);display:flex;align-items:center;gap:6px;}
.field-group label i{color:var(--red);font-size:13px;}
.input-wrap{position:relative;}
.heist-input{width:100%;background:var(--bg-elevated);border:1px solid var(--border-red);border-radius:4px;color:var(--text-bright);font-family:'Barlow',sans-serif;font-size:14px;padding:11px 14px;outline:none;transition:border-color 0.2s,box-shadow 0.2s;}
.heist-input::placeholder{color:var(--text-dim);}
.heist-input:focus{border-color:var(--red);box-shadow:0 0 0 3px rgba(200,30,30,0.2);}
.input-wrap .heist-input{padding-right:42px;}
.show-hide{position:absolute;right:13px;top:50%;transform:translateY(-50%);font-size:18px;color:var(--text-dim);cursor:pointer;transition:color 0.2s;}
.show-hide:hover{color:var(--gold);}
.form-extras{display:flex;align-items:center;justify-content:space-between;}
.check-row{display:flex;align-items:center;gap:8px;cursor:pointer;}
.heist-check{accent-color:var(--red);width:14px;height:14px;}
.check-label{font-family:'Oswald',sans-serif;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:var(--text-mid);}
.forgot-link{font-family:'Oswald',sans-serif;font-size:11px;letter-spacing:1px;text-transform:uppercase;color:var(--gold);text-decoration:none;transition:color 0.2s;}
.forgot-link:hover{color:var(--red);}
.heist-btn{width:100%;padding:14px;background:var(--red);border:1px solid rgba(200,30,30,0.6);border-radius:4px;color:#fff;font-family:'Oswald',sans-serif;font-size:14px;font-weight:600;letter-spacing:3px;text-transform:uppercase;box-shadow:0 0 28px var(--red-glow),inset 0 1px 0 rgba(255,255,255,0.08);transition:all 0.25s;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;}
.heist-btn:hover{background:#e52222;transform:translateY(-2px);box-shadow:0 0 42px var(--red-glow);}
.heist-btn:disabled{opacity:0.6;transform:none;cursor:not-allowed;}
.signup-link{text-align:center;font-family:'Oswald',sans-serif;font-size:13px;letter-spacing:1px;color:var(--text-mid);}
.signup-link a{color:var(--gold);text-decoration:none;transition:color 0.2s;}
.signup-link a:hover{color:var(--red);}
@media(max-width:768px){.login-container{grid-template-columns:1fr;}.login-left{display:none;}.login-right{padding:36px 24px;}}
</style>
</body>
</html>
