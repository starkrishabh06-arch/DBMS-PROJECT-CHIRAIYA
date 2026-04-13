<head>
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"/>
  <!-- Remix Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet"/>
  <!-- MDB -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.css" rel="stylesheet"/>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.1.0/mdb.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<canvas id="particles-canvas"></canvas>

<section class="signup-section">
  <div class="signup-container">

    <!-- LEFT PANEL -->
    <div class="signup-left">
      <div class="brand-block">
        <div class="overline-tag">
          <span class="live-dot"></span>
          <span>Operation Initiated — 2026</span>
        </div>
        <h1 class="brand-title">Expense<span>Heist</span></h1>
        <p class="brand-sub">Track. Manage. Control Your Expense.</p>
      </div>

      <div class="card-visual">
        <div class="card-scanline"></div>
        <img src="images/lacasa1.jpg" alt="La Casa de Papel" class="hero-img"/>
        <div class="img-overlay"></div>
        <div class="card-badge top-left">
          <i class="ri-shield-keyhole-fill"></i><span>Encrypted</span>
        </div>
        <div class="card-badge bottom-right">
          <span>Operation Active</span><span class="live-dot"></span>
        </div>
        <div class="card-foot">
          <span class="foot-label">LA CASA DE</span>
          <span class="foot-val">PAPEL</span>
        </div>
      </div>

      <div class="bella-strip">
        <span>BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp; BELLA CIAO &nbsp;·&nbsp;</span>
      </div>
    </div>

    <!-- RIGHT PANEL — form -->
    <div class="signup-right">
      <div class="form-header">
        <p class="form-eyebrow"><span class="live-dot"></span> Enlist Now</p>
        <h2 class="form-title">Join the Crew</h2>
        <p class="form-subtitle">Create your operative account</p>
      </div>

      <p id="error-msg"   class="msg-box error-box"   style="display:none"></p>
      <p id="success-msg" class="msg-box success-box" style="display:none"></p>

      <form id="signupForm" class="heist-form" autocomplete="off">

        <div class="field-group">
          <label><i class="ri-user-line"></i> Operative Name</label>
          <input type="text"  id="name"             name="name"             class="heist-input" placeholder="Your full name" required/>
        </div>

        <div class="field-group">
          <label><i class="ri-mail-line"></i> Encrypted Channel</label>
          <input type="email" id="email"            name="email"            class="heist-input" placeholder="your@email.com" required/>
        </div>

        <div class="field-group">
          <label><i class="ri-phone-line"></i> Contact Frequency</label>
          <input type="text"  id="phone"            name="phone"            class="heist-input" placeholder="Mobile number" required/>
        </div>

        <div class="field-group">
          <label><i class="ri-lock-2-line"></i> Access Code</label>
          <div class="input-wrap">
            <input type="password" id="password"         name="password"         class="heist-input" placeholder="Create password" required/>
            <i class="bx bx-hide show-hide"></i>
          </div>
        </div>

        <div class="field-group">
          <label><i class="ri-key-2-line"></i> Confirm Access Code</label>
          <div class="input-wrap">
            <input type="password" id="confirm_password" name="confirm_password" class="heist-input" placeholder="Repeat password" required/>
            <i class="bx bx-hide show-hide"></i>
          </div>
        </div>

        <div class="terms-row">
          <input class="heist-check" type="checkbox" id="terms" required/>
          <label for="terms" class="terms-label">I agree to the <a href="#" onclick="openVideo()">Terms of Service</a></label>
        </div>

        <div id="videoModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.9); z-index:999; justify-content:center; align-items:center;">
  
          <video id="termsVideo" width="70%" controls>
            <source src="images/a.mp4" type="video/mp4">
          </video>

          <button onclick="closeVideo()" style="position:absolute; top:20px; right:30px; font-size:30px; background:none; border:none; color:white;">✕</button>

        </div>

        <button type="submit" id="signupBtn" class="heist-btn">
          <span id="signupText"><i class="ri-user-add-line"></i> Create Account</span>
          <span id="signupSpinner" class="spinner-border spinner-border-sm" role="status" style="display:none;"></span>
        </button>

        <p class="login-link">Already enlisted? <a href="index.php">Login here <i class="ri-arrow-right-line"></i></a></p>

      </form>
    </div>

  </div>
</section>

<!-- ── Boxicons for show/hide ── -->
<link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet"/>

<style>
/* ═══════════════════════════════════════════
   MONEY HEIST — SIGNUP PAGE
═══════════════════════════════════════════ */
@import url("https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500;600&display=swap");

*, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

:root {
  --red:        #c81e1e;
  --red-dark:   #8f0f0f;
  --red-glow:   rgba(200,30,30,0.28);
  --red-subtle: rgba(200,30,30,0.08);
  --gold:       #d4a04a;
  --bg-void:    #060608;
  --bg-surface: #0e0e14;
  --bg-elevated:#151520;
  --bg-card:    #111118;
  --border:     rgba(255,255,255,0.06);
  --border-red: rgba(200,30,30,0.35);
  --text-bright:#f5f0e8;
  --text-mid:   #9994a0;
  --text-dim:   #4e4a58;
}

html,body { height:100%; }

body {
  font-family:'Barlow',sans-serif;
  background-color: var(--bg-void);
  background-image:
    radial-gradient(ellipse 65% 55% at 80% 15%, rgba(200,30,30,0.07) 0%, transparent 65%),
    radial-gradient(ellipse 45% 40% at 10% 90%, rgba(100,15,15,0.06) 0%, transparent 55%);
  color: var(--text-bright);
  overflow-x: hidden;
}

/* particles */
#particles-canvas {
  position: fixed; inset:0; z-index:0; pointer-events:none;
}

/* ── Layout ── */
.signup-section {
  position: relative; z-index:2;
  min-height: 100vh;
  display: flex; align-items: center; justify-content: center;
  padding: 40px 20px;
}
.signup-container {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 0;
  max-width: 1000px;
  width: 100%;
  background: var(--bg-surface);
  border: 1px solid var(--border-red);
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 0 80px rgba(200,30,30,0.1), 0 0 160px rgba(0,0,0,0.8);
}

/* ── LEFT ── */
.signup-left {
  background: var(--bg-card);
  border-right: 1px solid var(--border-red);
  padding: 40px 36px;
  display: flex; flex-direction: column; gap: 28px;
  position: relative;
  overflow: hidden;
}
.signup-left::before {
  content:'';
  position:absolute; top:0; left:0; right:0; height:2px;
  background: linear-gradient(90deg, transparent, var(--red), transparent);
  animation: shimmer 4s linear infinite;
}
@keyframes shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }

.overline-tag {
  display:inline-flex; align-items:center; gap:8px;
  font-family:'Oswald',sans-serif; font-size:11px; letter-spacing:3px; text-transform:uppercase;
  color: var(--red);
}
.live-dot {
  width:7px; height:7px; border-radius:50%;
  background:var(--red); box-shadow:0 0 6px var(--red);
  animation: pulse 1.6s ease-in-out infinite; flex-shrink:0;
}
@keyframes pulse { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:0.5;transform:scale(0.8)} }

.brand-title {
  font-family:'Bebas Neue',sans-serif; font-size:42px; letter-spacing:3px;
  color: var(--text-bright); line-height:1;
}
.brand-title span { color: var(--red); }
.brand-sub {
  font-family:'Oswald',sans-serif; font-size:13px; letter-spacing:2px; text-transform:uppercase;
  color: var(--gold); margin-top:6px;
}

/* card visual */
.card-visual {
  position:relative; border-radius:6px; overflow:hidden;
  border:1px solid var(--border-red);
  aspect-ratio: 4/3;
  box-shadow: 0 0 40px rgba(200,30,30,0.1);
}
.card-scanline {
  position:absolute; inset:0; z-index:4; pointer-events:none;
  background: repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,0,0,0.04) 2px,rgba(0,0,0,0.04) 4px);
}
.hero-img {
  width:100%; height:100%; object-fit:cover;
  filter:grayscale(20%) contrast(1.08) brightness(0.85);
  transition: transform 6s ease;
}
.card-visual:hover .hero-img { transform:scale(1.04); }
.img-overlay {
  position:absolute; inset:0;
  background: linear-gradient(to bottom, rgba(200,30,30,0.05) 0%, rgba(6,6,8,0) 40%, rgba(6,6,8,0.8) 100%);
}
.card-badge {
  position:absolute; z-index:5;
  display:flex; align-items:center; gap:6px;
  background:rgba(6,6,8,0.78); backdrop-filter:blur(8px);
  border:1px solid var(--border-red); border-radius:4px;
  padding:5px 10px;
  font-family:'Oswald',sans-serif; font-size:10px; letter-spacing:1.5px; text-transform:uppercase;
  color:var(--text-bright);
}
.card-badge i { color:var(--red); font-size:13px; }
.top-left  { top:12px; left:12px; }
.bottom-right { bottom:54px; right:12px; }
.card-foot {
  position:absolute; bottom:0; left:0; right:0; z-index:5;
  display:flex; align-items:baseline; justify-content:space-between;
  padding:8px 14px;
  background:rgba(6,6,8,0.85); border-top:1px solid var(--border-red);
}
.foot-label { font-family:'Oswald',sans-serif; font-size:10px; letter-spacing:3px; text-transform:uppercase; color:var(--text-dim); }
.foot-val   { font-family:'Bebas Neue',sans-serif; font-size:20px; letter-spacing:4px; color:var(--red); }

/* bella strip */
.bella-strip {
  font-family:'Bebas Neue',sans-serif; font-size:10px; letter-spacing:4px;
  color:var(--text-dim); overflow:hidden; white-space:nowrap;
}
.bella-strip span { display:inline-block; animation:ticker 14s linear infinite; }
@keyframes ticker { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }

/* ── RIGHT (form) ── */
.signup-right {
  padding: 40px 40px;
  display: flex; flex-direction: column; gap: 24px;
  overflow-y: auto; max-height: 100vh;
}
.form-eyebrow {
  display:inline-flex; align-items:center; gap:8px;
  font-family:'Oswald',sans-serif; font-size:11px; letter-spacing:3px; text-transform:uppercase;
  color:var(--red);
}
.form-title {
  font-family:'Bebas Neue',sans-serif; font-size:38px; letter-spacing:3px;
  color:var(--text-bright); line-height:1;
}
.form-subtitle {
  font-family:'Oswald',sans-serif; font-size:13px; letter-spacing:1px;
  color:var(--text-mid); margin-top:4px;
}

/* messages */
.msg-box {
  padding:10px 14px; border-radius:4px;
  font-family:'Oswald',sans-serif; font-size:13px; letter-spacing:0.5px;
  text-align:center;
}
.error-box   { background:rgba(200,30,30,0.12); border:1px solid rgba(200,30,30,0.4); color:#ff7070; }
.success-box { background:rgba(30,150,50,0.12); border:1px solid rgba(30,150,50,0.4); color:#4eca7f; }

/* form */
.heist-form { display:flex; flex-direction:column; gap:16px; }

.field-group { display:flex; flex-direction:column; gap:6px; }
.field-group label {
  font-family:'Oswald',sans-serif; font-size:11px; font-weight:600;
  letter-spacing:2px; text-transform:uppercase;
  color:var(--text-mid);
  display:flex; align-items:center; gap:6px;
}
.field-group label i { color:var(--red); font-size:13px; }

.input-wrap { position:relative; }
.heist-input {
  width:100%; background:var(--bg-elevated);
  border:1px solid var(--border-red); border-radius:4px;
  color:var(--text-bright);
  font-family:'Barlow',sans-serif; font-size:14px;
  padding:10px 14px; outline:none;
  transition:border-color 0.2s, box-shadow 0.2s;
}
.heist-input::placeholder { color:var(--text-dim); }
.heist-input:focus {
  border-color:var(--red);
  box-shadow:0 0 0 3px rgba(200,30,30,0.2);
}
.input-wrap .heist-input { padding-right:42px; }
.show-hide {
  position:absolute; right:13px; top:50%; transform:translateY(-50%);
  font-size:18px; color:var(--text-dim); cursor:pointer;
  transition:color 0.2s;
}
.show-hide:hover { color:var(--gold); }

/* terms */
.terms-row { display:flex; align-items:center; gap:10px; margin-top:4px; }
.heist-check { accent-color:var(--red); width:15px; height:15px; cursor:pointer; flex-shrink:0; }
.terms-label {
  font-family:'Oswald',sans-serif !important; font-size:12px !important;
  letter-spacing:1px !important; text-transform:uppercase !important;
  color:var(--text-mid) !important; margin:0 !important;
}
.terms-label a { color:var(--gold); transition:color 0.2s; }
.terms-label a:hover { color:var(--red); }

/* submit */
.heist-btn {
  width:100%; padding:14px;
  background:var(--red);
  border:1px solid rgba(200,30,30,0.6);
  border-radius:4px;
  color:#fff;
  font-family:'Oswald',sans-serif; font-size:14px; font-weight:600;
  letter-spacing:3px; text-transform:uppercase;
  box-shadow:0 0 28px var(--red-glow), inset 0 1px 0 rgba(255,255,255,0.08);
  transition:all 0.25s; cursor:pointer;
  display:flex; align-items:center; justify-content:center; gap:8px;
  margin-top:4px;
}
.heist-btn:hover {
  background:#e52222;
  transform:translateY(-2px);
  box-shadow:0 0 42px var(--red-glow);
}
.heist-btn:disabled { opacity:0.6; transform:none; cursor:not-allowed; }

.login-link {
  text-align:center;
  font-family:'Oswald',sans-serif; font-size:13px; letter-spacing:1px;
  color:var(--text-mid);
}
.login-link a { color:var(--gold); transition:color 0.2s; }
.login-link a:hover { color:var(--red); }

/* Responsive */
@media(max-width:768px) {
  .signup-container { grid-template-columns:1fr; }
  .signup-left { display:none; }
  .signup-right { padding:32px 24px; max-height:none; }
}
</style>

<script>
/* ── particle canvas ── */
const canvas = document.getElementById('particles-canvas');
if (canvas) {
  const ctx = canvas.getContext('2d');
  let W, H, pts = [];
  function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
  function init() {
    pts = [];
    for (let i=0;i<55;i++) pts.push({x:Math.random()*W,y:Math.random()*H,r:Math.random()*1.4+0.4,vx:(Math.random()-0.5)*0.35,vy:(Math.random()-0.5)*0.35,a:Math.random()*0.5+0.15});
  }
  function draw() {
    ctx.clearRect(0,0,W,H);
    pts.forEach(p=>{p.x+=p.vx;p.y+=p.vy;if(p.x<0)p.x=W;if(p.x>W)p.x=0;if(p.y<0)p.y=H;if(p.y>H)p.y=0;ctx.beginPath();ctx.arc(p.x,p.y,p.r,0,Math.PI*2);ctx.fillStyle=`rgba(200,30,30,${p.a})`;ctx.fill();});
    for(let i=0;i<pts.length;i++)for(let j=i+1;j<pts.length;j++){const dx=pts[i].x-pts[j].x,dy=pts[i].y-pts[j].y,d=Math.sqrt(dx*dx+dy*dy);if(d<130){ctx.beginPath();ctx.moveTo(pts[i].x,pts[i].y);ctx.lineTo(pts[j].x,pts[j].y);ctx.strokeStyle=`rgba(200,30,30,${0.12*(1-d/130)})`;ctx.lineWidth=0.6;ctx.stroke();}}
    requestAnimationFrame(draw);
  }
  resize(); init(); draw();
  window.addEventListener('resize',()=>{resize();init();});
}

/* ── show/hide password ── */
document.querySelectorAll(".show-hide").forEach(icon=>{
  icon.addEventListener("click",()=>{
    const inp=icon.parentElement.querySelector("input");
    if(inp.type==="password"){icon.classList.replace("bx-hide","bx-show");inp.type="text";}
    else{icon.classList.replace("bx-show","bx-hide");inp.type="password";}
  });
});

/* ── signup form submit (original logic preserved) ── */
document.querySelector("#signupForm").addEventListener("submit",function(e){
  e.preventDefault();
  var name=document.querySelector("#name").value;
  var email=document.querySelector("#email").value;
  var phone=document.querySelector("#phone").value;
  var password=document.getElementById("password").value;
  var confirm_password=document.getElementById("confirm_password").value;
  var signupBtn=document.getElementById("signupBtn");
  var signupText=document.getElementById("signupText");
  var signupSpinner=document.getElementById("signupSpinner");
  var errorMsg=document.getElementById("error-msg");
  var successMsg=document.getElementById("success-msg");

  errorMsg.textContent=""; errorMsg.style.display="none";
  successMsg.textContent=""; successMsg.style.display="none";
  signupBtn.disabled=true;
  signupText.style.display="none";
  signupSpinner.style.display="inline-block";

  fetch("api/signup.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({name,email,phone,password,confirm_password})})
  .then(r=>r.json())
  .then(data=>{
    if(data.status==="success"){
      successMsg.textContent=data.message; successMsg.style.display="block";
      setTimeout(()=>window.location.href="index.php",1500);
    } else {
      errorMsg.textContent=data.message||"An error occurred"; errorMsg.style.display="block";
      signupBtn.disabled=false; signupText.style.display="flex"; signupSpinner.style.display="none";
    }
  })
  .catch(()=>{
    errorMsg.textContent="A network error occurred. Please try again."; errorMsg.style.display="block";
    signupBtn.disabled=false; signupText.style.display="flex"; signupSpinner.style.display="none";
  });
});
</script>
<script>
function openVideo() {
  document.getElementById("videoModal").style.display = "flex";
  document.getElementById("termsVideo").play();
}

function closeVideo() {
  const video = document.getElementById("termsVideo");
  video.pause();
  video.currentTime = 0;
  document.getElementById("videoModal").style.display = "none";
}
</script>