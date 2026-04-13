<?php
session_start();
include('database.php');

if (empty($_SESSION['detsuid'])) {
    header('location:index.php');
    exit;
}

$message = "";
$messageType = "";

if (isset($_POST['update_user'])) {
    $userid   = $_SESSION['detsuid'];
    $username = mysqli_real_escape_string($db, $_POST['name']);
    $email    = mysqli_real_escape_string($db, $_POST['email']);
    $phone    = mysqli_real_escape_string($db, $_POST['phone']);

    $update_query = "UPDATE users SET name='$username', email='$email', phone='$phone' WHERE id=$userid";
    $result = mysqli_query($db, $update_query);

    if ($result) {
        $message     = "Profile updated successfully.";
        $messageType = "success";
    } else {
        $message     = "Error updating profile: " . mysqli_error($db);
        $messageType = "error";
    }
}

// Fetch current user data
$userid    = $_SESSION['detsuid'];
$userQuery = mysqli_query($db, "SELECT * FROM users WHERE id=$userid");
$user      = mysqli_fetch_assoc($userQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include "includes/header.php" ?>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ExpenseHeist – Update Profile</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css"/>
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --red:         #c81e1e;
      --red-dark:    #8f0f0f;
      --red-glow:    rgba(200,30,30,0.28);
      --red-subtle:  rgba(200,30,30,0.08);
      --gold:        #d4a04a;
      --bg-void:     #060608;
      --bg-surface:  #0e0e14;
      --bg-elevated: #151520;
      --bg-card:     #111118;
      --border:      rgba(255,255,255,0.06);
      --border-red:  rgba(200,30,30,0.35);
      --text-bright: #f5f0e8;
      --text-mid:    #9994a0;
      --text-dim:    #4e4a58;
      --font-display:'Bebas Neue', sans-serif;
      --font-heading:'Oswald', sans-serif;
      --font-body:   'Barlow', sans-serif;
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

    #particles-canvas {
      position: fixed; inset: 0; z-index: 0; pointer-events: none;
    }

    a { text-decoration: none; }
    button { background: transparent; border: none; outline: none; cursor: pointer; }
    ul li  { list-style: none; }

    /* ── HEADER ── */
    .header {
      position: sticky; top: 0; z-index: 100;
      height: 4.25rem; padding: 0 1.7rem;
      background: rgba(6,6,8,0.88);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border-red);
    }
    .header::after {
      content: ''; position: absolute; bottom: 0; left: 0;
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
      font-size: 28px; letter-spacing: 2px; color: var(--text-bright);
    }
    .logo h2 span { color: var(--red); }

    .nav_menu_list { display: flex; align-items: center; }
    .nav_menu_item  { margin: 0 1.8rem; }
    .nav_menu_link {
      font-family: var(--font-heading);
      font-size: 13px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--text-mid); transition: color 0.2s;
      position: relative; padding-bottom: 2px;
    }
    .nav_menu_link::after {
      content: ''; position: absolute; bottom: 0; left: 0;
      width: 0; height: 1px; background: var(--red); transition: width 0.25s;
    }
    .nav_menu_link:hover { color: var(--text-bright); }
    .nav_menu_link:hover::after { width: 100%; }

    .toggle_btn { font-size: 22px; color: var(--text-bright); z-index: 4; }
    .nav_menu, .close_btn { display: none; }

    /* ── PAGE WRAPPER ── */
    .page-wrapper {
      position: relative; z-index: 2;
      padding: 4rem 1.7rem 6rem;
      display: flex; justify-content: center;
    }

    /* ── PROFILE CARD ── */
    .profile-card {
      width: 100%; max-width: 540px;
      background: var(--bg-card);
      border: 1px solid var(--border-red);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 0 60px rgba(200,30,30,0.10), 0 0 120px rgba(0,0,0,0.7);
    }

    .card-topbar {
      height: 3px;
      background: linear-gradient(90deg, var(--red-dark), var(--red), var(--gold), var(--red), var(--red-dark));
    }

    .card-header {
      padding: 2rem 2rem 1.2rem;
      border-bottom: 1px solid var(--border);
      position: relative;
    }
    .card-header::before {
      content: ''; position: absolute;
      bottom: 0; left: 0; width: 100%; height: 1px;
      background: linear-gradient(90deg, transparent, var(--border-red), transparent);
    }

    .card-eyebrow {
      font-family: var(--font-heading);
      font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
      color: var(--red); margin-bottom: 0.4rem;
    }
    .card-title {
      font-family: var(--font-display);
      font-size: 36px; letter-spacing: 3px;
      color: var(--text-bright);
    }
    .card-sub {
      font-size: 13px; color: var(--text-dim);
      font-weight: 300; margin-top: 0.3rem; letter-spacing: 0.5px;
    }

    /* avatar area */
    .avatar-row {
      display: flex; align-items: center; gap: 1rem;
      padding: 1.5rem 2rem;
      border-bottom: 1px solid var(--border);
    }
    .avatar-circle {
      width: 58px; height: 58px; border-radius: 50%;
      background: var(--red-subtle);
      border: 1px solid var(--border-red);
      display: flex; align-items: center; justify-content: center;
      font-family: var(--font-display);
      font-size: 26px; color: var(--red);
      flex-shrink: 0;
    }
    .avatar-info span {
      font-family: var(--font-heading);
      font-size: 16px; font-weight: 600;
      color: var(--text-bright); display: block;
    }
    .avatar-info small {
      font-size: 12px; color: var(--text-dim);
      letter-spacing: 1px;
    }

    /* ── FORM ── */
    .card-body { padding: 1.8rem 2rem 2rem; }

    .form-group { margin-bottom: 1.4rem; }

    .form-label {
      display: flex; align-items: center; gap: 7px;
      font-family: var(--font-heading);
      font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--text-dim); margin-bottom: 0.5rem;
    }
    .form-label i { font-size: 13px; color: var(--red); }

    .form-input {
      width: 100%; height: 48px;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 4px;
      padding: 0 14px;
      font-family: var(--font-body);
      font-size: 14px; color: var(--text-bright);
      outline: none;
      transition: border-color 0.25s, box-shadow 0.25s;
    }
    .form-input::placeholder { color: var(--text-dim); }
    .form-input:focus {
      border-color: var(--border-red);
      box-shadow: 0 0 0 3px rgba(200,30,30,0.10);
    }

    .form-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--border-red), transparent);
      margin: 1.6rem 0;
    }

    .submit-btn {
      width: 100%; height: 52px;
      background: var(--red);
      border: 1px solid rgba(200,30,30,0.6);
      border-radius: 4px;
      font-family: var(--font-heading);
      font-size: 13px; font-weight: 600;
      letter-spacing: 2px; text-transform: uppercase;
      color: #fff;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      box-shadow: 0 0 28px var(--red-glow), inset 0 1px 0 rgba(255,255,255,0.08);
      cursor: pointer;
      transition: all 0.25s;
    }
    .submit-btn:hover {
      background: #e52222;
      transform: translateY(-2px);
      box-shadow: 0 0 42px var(--red-glow);
    }

    .back-link {
      display: flex; align-items: center; gap: 6px;
      font-family: var(--font-heading);
      font-size: 12px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--text-dim); margin-top: 1rem;
      transition: color 0.2s;
      width: fit-content;
    }
    .back-link:hover { color: var(--red); }
    .back-link i { font-size: 15px; }

    /* ── TOAST ── */
    .toast {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 16px;
      border-radius: 4px;
      font-family: var(--font-heading);
      font-size: 13px; letter-spacing: 1px;
      margin-bottom: 1.4rem;
      border-left: 3px solid;
      animation: fadeIn 0.4s ease;
    }
    .toast-success {
      background: rgba(20,60,20,0.4);
      border-color: #2e7d32;
      color: #81c784;
    }
    .toast-error {
      background: rgba(60,10,10,0.4);
      border-color: var(--red);
      color: #ef9a9a;
    }
    @keyframes fadeIn { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

    /* ── FOOTER ── */
    footer {
      height: 3px;
      background: linear-gradient(90deg, var(--red-dark), var(--red), var(--gold), var(--red), var(--red-dark));
      opacity: 0.8;
    }

    /* ── RESPONSIVE ── */
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
        border-radius: 8px; padding: 2rem;
        transition: right 0.3s ease; z-index: 200;
      }
      .close_btn {
        display: flex; justify-content: flex-end;
        font-size: 22px; color: var(--text-bright); margin-bottom: 1.5rem;
      }
      .nav_menu_list { flex-direction: column; gap: 1.2rem; }
      .nav_menu_item  { margin: 0; }
      .show { right: 3% !important; }
    }
  </style>
</head>

<body>

<canvas id="particles-canvas"></canvas>

<!-- HEADER -->
<header class="header">
  <div class="container">
    <nav class="nav">
      <div class="logo">
        <h2>Expense<span>Heist</span></h2>
      </div>
      <button class="toggle_btn"><i class="ri-menu-3-line"></i></button>
      <div class="nav_menu" id="navMenu">
        <button class="close_btn" id="closeBtn"><i class="ri-close-line"></i></button>
        <ul class="nav_menu_list">
          <li class="nav_menu_item"><a href="#" class="nav_menu_link">The Plan</a></li>
          <li class="nav_menu_item"><a href="#" class="nav_menu_link">Mission</a></li>
          <li class="nav_menu_item"><a href="#" class="nav_menu_link">The Crew</a></li>
          <li class="nav_menu_item"><a href="#" class="nav_menu_link">Contact</a></li>
        </ul>
      </div>
    </nav>
  </div>
</header>

<!-- PAGE CONTENT -->
<div class="page-wrapper">
  <div class="profile-card">
    <div class="card-topbar"></div>

    <div class="card-header">
      <p class="card-eyebrow">Operative File</p>
      <h1 class="card-title">Update Profile</h1>
      <p class="card-sub">Modify your operative credentials below</p>
    </div>

    <!-- Avatar row -->
    <div class="avatar-row">
      <div class="avatar-circle">
        <?php echo strtoupper(substr($user['name'] ?? 'U', 0, 1)); ?>
      </div>
      <div class="avatar-info">
        <span><?php echo htmlspecialchars($user['name'] ?? 'Operative'); ?></span>
        <small><?php echo htmlspecialchars($user['email'] ?? ''); ?></small>
      </div>
    </div>

    <div class="card-body">

      <?php if (!empty($message)): ?>
        <div class="toast toast-<?php echo $messageType; ?>">
          <i class="ri-<?php echo $messageType === 'success' ? 'checkbox-circle-line' : 'error-warning-line'; ?>"></i>
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="">
        <div class="form-group">
          <label class="form-label" for="name">
            <i class="ri-user-line"></i> Full Name
          </label>
          <input
            type="text"
            id="name"
            name="name"
            class="form-input"
            placeholder="Enter operative name"
            value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
            required
          />
        </div>

        <div class="form-group">
          <label class="form-label" for="email">
            <i class="ri-mail-line"></i> Email Address
          </label>
          <input
            type="email"
            id="email"
            name="email"
            class="form-input"
            placeholder="Enter secure email"
            value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
            required
          />
        </div>

        <div class="form-group">
          <label class="form-label" for="phone">
            <i class="ri-phone-line"></i> Phone Number
          </label>
          <input
            type="tel"
            id="phone"
            name="phone"
            class="form-input"
            placeholder="Enter contact number"
            value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
          />
        </div>

        <div class="form-divider"></div>

        <button type="submit" name="update_user" class="submit-btn">
          <i class="ri-save-line"></i> Confirm Update
        </button>
      </form>

      <a href="user_profile.php" class="back-link">
        <i class="ri-arrow-left-line"></i> Back to Profile
      </a>
    </div>
  </div>
</div>

<?php include "includes/footer.php" ?>

<script>
  const toggleBtn = document.querySelector('.toggle_btn');
  const navMenu   = document.getElementById('navMenu');
  const closeBtn  = document.getElementById('closeBtn');
  if (toggleBtn) toggleBtn.addEventListener('click', () => navMenu.classList.add('show'));
  if (closeBtn)  closeBtn.addEventListener('click',  () => navMenu.classList.remove('show'));

  const canvas = document.getElementById('particles-canvas');
  const ctx    = canvas.getContext('2d');
  let W, H, pts = [];
  function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
  function init() {
    pts = [];
    for (let i = 0; i < 55; i++) {
      pts.push({ x: Math.random()*W, y: Math.random()*H,
        r: Math.random()*1.4+0.4, vx:(Math.random()-0.5)*0.35,
        vy:(Math.random()-0.5)*0.35, a:Math.random()*0.5+0.15 });
    }
  }
  function draw() {
    ctx.clearRect(0,0,W,H);
    pts.forEach(p => {
      p.x += p.vx; p.y += p.vy;
      if(p.x<0)p.x=W; if(p.x>W)p.x=0;
      if(p.y<0)p.y=H; if(p.y>H)p.y=0;
      ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
      ctx.fillStyle=`rgba(200,30,30,${p.a})`; ctx.fill();
    });
    for(let i=0;i<pts.length;i++) for(let j=i+1;j<pts.length;j++) {
      const dx=pts[i].x-pts[j].x, dy=pts[i].y-pts[j].y, d=Math.sqrt(dx*dx+dy*dy);
      if(d<130){
        ctx.beginPath(); ctx.moveTo(pts[i].x,pts[i].y); ctx.lineTo(pts[j].x,pts[j].y);
        ctx.strokeStyle=`rgba(200,30,30,${0.12*(1-d/130)})`; ctx.lineWidth=0.6; ctx.stroke();
      }
    }
    requestAnimationFrame(draw);
  }
  resize(); init(); draw();
  window.addEventListener('resize',()=>{resize();init();});
</script>
</body>
</html>
