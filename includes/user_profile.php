<?php
session_start();
error_reporting(0);
include('database.php');
if (empty($_SESSION['detsuid'])) {
  header('location:logout.php');
  exit;
}

$userid = $_SESSION['detsuid'];

// Fetch user data
$sql    = "SELECT * FROM users WHERE id = $userid";
$result = mysqli_query($db, $sql);
$row    = mysqli_fetch_assoc($result);
$name   = $row['name'];
$email  = $row['email'];
$phone  = $row['phone'];
$created_at = $row['created_at'];

// Password change logic
$old_password     = "";
$new_password     = "";
$confirm_password = "";
$errors           = [];
$pw_success       = "";

if (isset($_POST['submit'])) {
    $old_password     = $_POST['old_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($old_password))     $errors[] = "Please enter your old password.";
    if (empty($new_password))     $errors[] = "Please enter a new password.";
    elseif (strlen($new_password) < 8) $errors[] = "New password must be at least 8 characters.";
    if (empty($confirm_password)) $errors[] = "Please confirm your new password.";
    elseif ($new_password != $confirm_password) $errors[] = "New passwords do not match.";

    if (empty($errors)) {
        $q = mysqli_query($db, "SELECT password FROM users WHERE id = $userid");
        $r = mysqli_fetch_assoc($q);
        if (!password_verify($old_password, $r['password'])) {
            $errors[] = "Old password is incorrect.";
        }
    }

    if (empty($errors)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $upd    = "UPDATE users SET password='$hashed' WHERE id=$userid";
        if (mysqli_query($db, $upd)) {
            $pw_success = "Password updated successfully.";
        } else {
            $errors[] = "Error updating password: " . mysqli_error($db);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ExpenseHeist – Settings</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
      --sidebar-w:   260px;
      --font-display:'Bebas Neue', sans-serif;
      --font-heading:'Oswald', sans-serif;
      --font-body:   'Barlow', sans-serif;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: var(--font-body);
      background-color: var(--bg-void);
      background-image:
        radial-gradient(ellipse 65% 55% at 80% 15%, rgba(200,30,30,0.06) 0%, transparent 65%),
        radial-gradient(ellipse 45% 40% at 10% 90%, rgba(100,15,15,0.05) 0%, transparent 55%);
      color: var(--text-bright);
      overflow-x: hidden;
      min-height: 100vh;
    }

    #particles-canvas {
      position: fixed; inset: 0; z-index: 0; pointer-events: none;
    }

    a { text-decoration: none; color: inherit; }
    button { cursor: pointer; }
    ul { list-style: none; }

    /* ═══════════════════════════
       SIDEBAR
    ═══════════════════════════ */
    .sidebar {
      position: fixed; top: 0; left: 0;
      width: var(--sidebar-w);
      height: 100vh;
      background: var(--bg-card);
      border-right: 1px solid var(--border-red);
      z-index: 100;
      display: flex; flex-direction: column;
      transition: width 0.3s ease;
      overflow: hidden;
    }

    .sidebar.collapsed { width: 70px; }

    .logo-details {
      height: 64px;
      display: flex; align-items: center;
      padding: 0 20px; gap: 12px;
      border-bottom: 1px solid var(--border-red);
      flex-shrink: 0;
    }
    .logo-details i { font-size: 24px; color: var(--red); flex-shrink: 0; }
    .logo-details .logo_name {
      font-family: var(--font-display);
      font-size: 22px; letter-spacing: 3px;
      color: var(--text-bright);
      white-space: nowrap; overflow: hidden;
      transition: opacity 0.2s;
    }
    .sidebar.collapsed .logo_name { opacity: 0; pointer-events: none; }

    .nav-links {
      flex: 1; overflow-y: auto; overflow-x: hidden;
      padding: 12px 0;
    }
    .nav-links::-webkit-scrollbar { width: 3px; }
    .nav-links::-webkit-scrollbar-thumb { background: var(--border-red); }

    .nav-links li a {
      display: flex; align-items: center;
      height: 50px; padding: 0 20px; gap: 14px;
      font-family: var(--font-heading);
      font-size: 13px; letter-spacing: 1.5px; text-transform: uppercase;
      color: var(--text-mid);
      white-space: nowrap;
      transition: color 0.2s, background 0.2s;
      position: relative;
    }
    .nav-links li a::before {
      content: ''; position: absolute; left: 0; top: 0;
      width: 3px; height: 100%; background: var(--red);
      transform: scaleY(0); transition: transform 0.2s;
    }
    .nav-links li a:hover,
    .nav-links li a.active {
      color: var(--text-bright);
      background: var(--red-subtle);
    }
    .nav-links li a:hover::before,
    .nav-links li a.active::before { transform: scaleY(1); }
    .nav-links li a i { font-size: 20px; flex-shrink: 0; color: var(--text-dim); transition: color 0.2s; }
    .nav-links li a:hover i,
    .nav-links li a.active i { color: var(--red); }
    .nav-links .links_name { transition: opacity 0.2s; }
    .sidebar.collapsed .links_name { opacity: 0; }

    .nav-links .log_out { margin-top: auto; border-top: 1px solid var(--border); }

    /* ═══════════════════════════
       TOPBAR
    ═══════════════════════════ */
    .topbar {
      position: fixed; top: 0;
      left: var(--sidebar-w); right: 0;
      height: 64px;
      background: rgba(6,6,8,0.90);
      backdrop-filter: blur(14px);
      border-bottom: 1px solid var(--border-red);
      z-index: 99;
      display: flex; align-items: center;
      justify-content: space-between;
      padding: 0 2rem;
      transition: left 0.3s ease;
    }
    .topbar.collapsed { left: 70px; }
    .topbar::after {
      content: ''; position: absolute; bottom: 0; left: 0;
      width: 100%; height: 1px;
      background: linear-gradient(90deg, transparent, var(--red), transparent);
      animation: shimmer 4s linear infinite;
    }
    @keyframes shimmer { 0%{transform:translateX(-100%)} 100%{transform:translateX(100%)} }

    .topbar-left { display: flex; align-items: center; gap: 14px; }
    .sidebar-toggle {
      background: none; border: none;
      font-size: 22px; color: var(--text-mid);
      transition: color 0.2s;
    }
    .sidebar-toggle:hover { color: var(--red); }
    .page-title {
      font-family: var(--font-display);
      font-size: 22px; letter-spacing: 3px;
      color: var(--text-bright);
    }

    .topbar-right { display: flex; align-items: center; gap: 1rem; position: relative; }
    .user-chip {
      display: flex; align-items: center; gap: 10px;
      padding: 6px 14px 6px 6px;
      background: var(--bg-elevated);
      border: 1px solid var(--border-red);
      border-radius: 30px;
      cursor: pointer;
      transition: border-color 0.2s;
    }
    .user-chip:hover { border-color: var(--red); }
    .user-avatar {
      width: 34px; height: 34px; border-radius: 50%;
      background: var(--red-subtle);
      border: 1px solid var(--border-red);
      display: flex; align-items: center; justify-content: center;
      font-family: var(--font-display);
      font-size: 16px; color: var(--red);
    }
    .user-name {
      font-family: var(--font-heading);
      font-size: 13px; letter-spacing: 1px;
      color: var(--text-bright);
    }
    .chevron { font-size: 16px; color: var(--text-dim); transition: transform 0.2s; }
    .chevron.open { transform: rotate(180deg); }

    .profile-dropdown {
      position: absolute; top: calc(100% + 10px); right: 0;
      min-width: 180px;
      background: var(--bg-elevated);
      border: 1px solid var(--border-red);
      border-radius: 6px;
      overflow: hidden;
      display: none;
      z-index: 200;
      box-shadow: 0 8px 32px rgba(0,0,0,0.5);
    }
    .profile-dropdown.show { display: block; }
    .profile-dropdown a {
      display: flex; align-items: center; gap: 10px;
      padding: 12px 16px;
      font-family: var(--font-heading);
      font-size: 12px; letter-spacing: 1.5px; text-transform: uppercase;
      color: var(--text-mid);
      transition: background 0.2s, color 0.2s;
    }
    .profile-dropdown a:hover { background: var(--red-subtle); color: var(--text-bright); }
    .profile-dropdown a i { font-size: 15px; color: var(--red); }

    /* ═══════════════════════════
       MAIN CONTENT
    ═══════════════════════════ */
    .main {
      margin-left: var(--sidebar-w);
      padding-top: 64px;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
      position: relative; z-index: 1;
    }
    .main.collapsed { margin-left: 70px; }

    .content-area {
      padding: 2.5rem 2rem;
      max-width: 900px;
    }

    /* ═══════════════════════════
       SETTINGS LAYOUT
    ═══════════════════════════ */
    .settings-wrap {
      display: grid;
      grid-template-columns: 220px 1fr;
      gap: 1.5rem;
      align-items: start;
    }

    /* left panel */
    .settings-panel {
      background: var(--bg-card);
      border: 1px solid var(--border-red);
      border-radius: 8px;
      overflow: hidden;
    }
    .panel-topbar {
      height: 3px;
      background: linear-gradient(90deg, var(--red-dark), var(--red), var(--gold), var(--red), var(--red-dark));
    }

    .avatar-block {
      padding: 1.8rem 1.2rem 1.2rem;
      display: flex; flex-direction: column; align-items: center; gap: 10px;
      border-bottom: 1px solid var(--border);
    }
    .avatar-wrap { position: relative; cursor: pointer; }
    .big-avatar {
      width: 80px; height: 80px; border-radius: 50%;
      background: var(--red-subtle);
      border: 2px solid var(--border-red);
      display: flex; align-items: center; justify-content: center;
      font-family: var(--font-display);
      font-size: 36px; color: var(--red);
      overflow: hidden;
    }
    .big-avatar img {
      width: 100%; height: 100%; object-fit: cover; border-radius: 50%;
    }
    .avatar-overlay {
      position: absolute; inset: 0; border-radius: 50%;
      background: rgba(0,0,0,0.65);
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.25s;
    }
    .avatar-wrap:hover .avatar-overlay { opacity: 1; }
    .avatar-overlay i { color: #fff; font-size: 20px; }
    input[type="file"] { display: none; }

    .panel-name {
      font-family: var(--font-heading);
      font-size: 15px; font-weight: 600;
      color: var(--text-bright); text-align: center;
    }
    .panel-email {
      font-size: 12px; color: var(--text-dim);
      text-align: center; word-break: break-all;
    }

    .panel-nav { padding: 8px 0; }
    .panel-nav-item {
      display: flex; align-items: center; gap: 10px;
      padding: 13px 20px;
      font-family: var(--font-heading);
      font-size: 12px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--text-mid);
      cursor: pointer;
      border-left: 3px solid transparent;
      transition: all 0.2s;
    }
    .panel-nav-item i { font-size: 16px; color: var(--text-dim); transition: color 0.2s; }
    .panel-nav-item:hover,
    .panel-nav-item.active {
      color: var(--text-bright);
      background: var(--red-subtle);
      border-left-color: var(--red);
    }
    .panel-nav-item:hover i,
    .panel-nav-item.active i { color: var(--red); }

    /* right panel */
    .settings-card {
      background: var(--bg-card);
      border: 1px solid var(--border-red);
      border-radius: 8px;
      overflow: hidden;
    }

    .tab-pane { display: none; }
    .tab-pane.active { display: block; }

    .card-header-strip {
      height: 3px;
      background: linear-gradient(90deg, var(--red-dark), var(--red), var(--gold), var(--red), var(--red-dark));
    }
    .card-head {
      padding: 1.6rem 2rem 1.2rem;
      border-bottom: 1px solid var(--border);
    }
    .card-eyebrow {
      font-family: var(--font-heading);
      font-size: 11px; letter-spacing: 3px; text-transform: uppercase;
      color: var(--red); margin-bottom: 0.3rem;
    }
    .card-title {
      font-family: var(--font-display);
      font-size: 30px; letter-spacing: 3px; color: var(--text-bright);
    }

    .card-body-inner { padding: 1.8rem 2rem 2rem; }

    /* form elements */
    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.2rem;
    }
    .form-row.single { grid-template-columns: 1fr; }

    .form-group { margin-bottom: 1.2rem; }
    .form-label {
      display: flex; align-items: center; gap: 7px;
      font-family: var(--font-heading);
      font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--text-dim); margin-bottom: 0.45rem;
    }
    .form-label i { font-size: 13px; color: var(--red); }

    .form-input {
      width: 100%; height: 46px;
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
    .form-input[readonly] {
      color: var(--text-dim);
      cursor: not-allowed;
    }

    .form-divider {
      height: 1px;
      background: linear-gradient(90deg, transparent, var(--border-red), transparent);
      margin: 1.4rem 0;
    }

    .btn-row { display: flex; gap: 10px; }

    .btn-primary {
      height: 46px; padding: 0 28px;
      background: var(--red);
      border: 1px solid rgba(200,30,30,0.6);
      border-radius: 4px;
      font-family: var(--font-heading);
      font-size: 12px; font-weight: 600; letter-spacing: 2px; text-transform: uppercase;
      color: #fff;
      display: inline-flex; align-items: center; gap: 7px;
      box-shadow: 0 0 20px var(--red-glow);
      transition: all 0.25s;
    }
    .btn-primary:hover {
      background: #e52222;
      transform: translateY(-2px);
      box-shadow: 0 0 34px var(--red-glow);
    }

    .btn-ghost {
      height: 46px; padding: 0 22px;
      background: transparent;
      border: 1px solid var(--border);
      border-radius: 4px;
      font-family: var(--font-heading);
      font-size: 12px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--text-mid);
      transition: all 0.2s;
    }
    .btn-ghost:hover { border-color: var(--border-red); color: var(--text-bright); }

    /* toasts */
    .toast {
      display: flex; align-items: center; gap: 10px;
      padding: 11px 16px; border-radius: 4px; margin-bottom: 1.2rem;
      font-family: var(--font-heading);
      font-size: 12px; letter-spacing: 1px;
      border-left: 3px solid;
      animation: fadeUp 0.35s ease;
    }
    .toast-success { background: rgba(20,60,20,0.4); border-color: #2e7d32; color: #81c784; }
    .toast-error   { background: rgba(60,10,10,0.4); border-color: var(--red); color: #ef9a9a; }
    .toast i { font-size: 16px; }
    @keyframes fadeUp { from{opacity:0;transform:translateY(-6px)} to{opacity:1;transform:translateY(0)} }

    /* info row (read-only field with label) */
    .info-field {
      padding: 12px 14px;
      background: var(--bg-surface);
      border: 1px solid var(--border);
      border-radius: 4px;
      margin-bottom: 1.2rem;
    }
    .info-field-label {
      font-family: var(--font-heading);
      font-size: 10px; letter-spacing: 2px; text-transform: uppercase;
      color: var(--text-dim); margin-bottom: 3px;
    }
    .info-field-val {
      font-size: 14px; color: var(--text-mid);
    }

    /* ═══════════════════════════
       RESPONSIVE
    ═══════════════════════════ */
    @media (max-width: 900px) {
      .settings-wrap { grid-template-columns: 1fr; }
      .settings-panel { display: flex; align-items: center; gap: 0; flex-direction: column; }
      .avatar-block { flex-direction: row; align-items: center; gap: 16px; width: 100%; }
      .panel-nav { display: flex; flex-wrap: wrap; width: 100%; padding: 4px; }
      .panel-nav-item { border-left: none; border-bottom: 3px solid transparent; }
      .panel-nav-item.active,
      .panel-nav-item:hover { border-bottom-color: var(--red); border-left-color: transparent; }
    }
    @media (max-width: 700px) {
      :root { --sidebar-w: 0px; }
      .sidebar { transform: translateX(-100%); width: 260px; }
      .sidebar.mobile-open { transform: translateX(0); }
      .topbar { left: 0 !important; }
      .main  { margin-left: 0 !important; }
      .form-row { grid-template-columns: 1fr; }
      .content-area { padding: 1.5rem 1rem; }
    }
  </style>
</head>
<body>

<canvas id="particles-canvas"></canvas>

<!-- ░░░ SIDEBAR ░░░ -->
<div class="sidebar" id="sidebar">
  <div class="logo-details">
    <i class='bx bx-mask'></i>
    <span class="logo_name">Expense<span style="color:var(--red)">Heist</span></span>
  </div>
  <ul class="nav-links">
    <li><a href="home.php"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
    <li><a href="add-expenses.php"><i class='bx bx-box'></i><span class="links_name">Expenses</span></a></li>
    <li><a href="add-income.php"><i class='bx bx-trending-up'></i><span class="links_name">Income</span></a></li>
    <li><a href="manage-transaction.php"><i class='bx bx-list-ul'></i><span class="links_name">Manage List</span></a></li>
    <li><a href="lending.php"><i class='bx bx-money'></i><span class="links_name">Lending</span></a></li>
    <li><a href="manage-lending.php"><i class='bx bx-coin-stack'></i><span class="links_name">Manage Lending</span></a></li>
    <li><a href="analytics.php"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Analytics</span></a></li>
    <li><a href="report.php"><i class='bx bx-file'></i><span class="links_name">Report</span></a></li>
    <li><a href="user_profile.php" class="active"><i class='bx bx-cog'></i><span class="links_name">Settings</span></a></li>
    <li class="log_out"><a href="logout.php"><i class='bx bx-log-out'></i><span class="links_name">Log Out</span></a></li>
  </ul>
</div>

<!-- ░░░ TOPBAR ░░░ -->
<div class="topbar" id="topbar">
  <div class="topbar-left">
    <button class="sidebar-toggle" id="sidebarToggle"><i class='bx bx-menu'></i></button>
    <span class="page-title">Settings</span>
  </div>
  <div class="topbar-right">
    <div class="user-chip" id="userChip">
      <div class="user-avatar"><?php echo strtoupper(substr($name, 0, 1)); ?></div>
      <span class="user-name"><?php echo htmlspecialchars($name); ?></span>
      <i class='bx bx-chevron-down chevron' id="chevron"></i>
    </div>
    <div class="profile-dropdown" id="profileDropdown">
      <a href="user_profile.php"><i class="ri-user-line"></i> Profile</a>
      <a href="logout.php"><i class="ri-logout-box-line"></i> Logout</a>
    </div>
  </div>
</div>

<!-- ░░░ MAIN ░░░ -->
<div class="main" id="main">
  <div class="content-area">
    <div class="settings-wrap">

      <!-- LEFT PANEL -->
      <div class="settings-panel">
        <div class="panel-topbar"></div>
        <div class="avatar-block">
          <label for="avatarInput">
            <div class="avatar-wrap">
              <div class="big-avatar" id="bigAvatar">
                <?php echo strtoupper(substr($name, 0, 1)); ?>
              </div>
              <div class="avatar-overlay"><i class="ri-camera-line"></i></div>
            </div>
          </label>
          <input type="file" id="avatarInput" accept="image/*">
          <div class="panel-name"><?php echo htmlspecialchars($name); ?></div>
          <div class="panel-email"><?php echo htmlspecialchars($email); ?></div>
        </div>
        <nav class="panel-nav">
          <div class="panel-nav-item active" data-tab="account">
            <i class="ri-user-settings-line"></i> Account
          </div>
          <div class="panel-nav-item" data-tab="password">
            <i class="ri-lock-password-line"></i> Password
          </div>
        </nav>
      </div>

      <!-- RIGHT PANEL -->
      <div class="settings-card">

        <!-- ACCOUNT TAB -->
        <div class="tab-pane active" id="tab-account">
          <div class="card-header-strip"></div>
          <div class="card-head">
            <p class="card-eyebrow">Operative File</p>
            <h2 class="card-title">Account Settings</h2>
          </div>
          <div class="card-body-inner">
            <form method="POST" action="update_user.php">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label"><i class="ri-user-line"></i> Username</label>
                  <input type="text" class="form-input" name="name"
                    value="<?php echo htmlspecialchars($name); ?>" required>
                </div>
                <div class="form-group">
                  <label class="form-label"><i class="ri-mail-line"></i> Email</label>
                  <input type="email" class="form-input" name="email"
                    value="<?php echo htmlspecialchars($email); ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label"><i class="ri-phone-line"></i> Phone Number</label>
                  <input type="text" class="form-input" name="phone"
                    value="<?php echo htmlspecialchars($phone); ?>">
                </div>
                <div class="form-group">
                  <label class="form-label"><i class="ri-calendar-line"></i> Registered Date</label>
                  <input type="text" class="form-input" readonly
                    value="<?php echo date('F j, Y', strtotime($created_at)); ?>">
                </div>
              </div>
              <div class="form-divider"></div>
              <div class="btn-row">
                <button type="submit" name="update_user" class="btn-primary">
                  <i class="ri-save-line"></i> Save Changes
                </button>
                <button type="reset" class="btn-ghost">Reset</button>
              </div>
            </form>
          </div>
        </div>

        <!-- PASSWORD TAB -->
        <div class="tab-pane" id="tab-password">
          <div class="card-header-strip"></div>
          <div class="card-head">
            <p class="card-eyebrow">Security Clearance</p>
            <h2 class="card-title">Change Password</h2>
          </div>
          <div class="card-body-inner">

            <?php if (!empty($pw_success)): ?>
              <div class="toast toast-success">
                <i class="ri-checkbox-circle-line"></i>
                <?php echo htmlspecialchars($pw_success); ?>
              </div>
            <?php endif; ?>

            <?php if (!empty($errors)): ?>
              <div class="toast toast-error">
                <i class="ri-error-warning-line"></i>
                <div>
                  <?php foreach ($errors as $e): ?>
                    <div><?php echo htmlspecialchars($e); ?></div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>

            <form method="POST" action="">
              <div class="form-row single">
                <div class="form-group">
                  <label class="form-label"><i class="ri-lock-line"></i> Old Password</label>
                  <input type="password" class="form-input" name="old_password"
                    placeholder="Enter current password" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label"><i class="ri-lock-2-line"></i> New Password</label>
                  <input type="password" class="form-input" name="new_password"
                    placeholder="Min. 8 characters" required>
                </div>
                <div class="form-group">
                  <label class="form-label"><i class="ri-lock-2-line"></i> Confirm Password</label>
                  <input type="password" class="form-input" name="confirm_password"
                    placeholder="Repeat new password" required>
                </div>
              </div>
              <div class="form-divider"></div>
              <div class="btn-row">
                <button type="submit" name="submit" class="btn-primary">
                  <i class="ri-shield-check-line"></i> Update Password
                </button>
                <button type="reset" class="btn-ghost">Clear</button>
              </div>
            </form>
          </div>
        </div>

      </div><!-- /settings-card -->
    </div><!-- /settings-wrap -->
  </div>
</div>

<script>
  /* ── Particle canvas ── */
  const canvas = document.getElementById('particles-canvas');
  const ctx    = canvas.getContext('2d');
  let W, H, pts = [];
  function resize() { W = canvas.width = window.innerWidth; H = canvas.height = window.innerHeight; }
  function init() {
    pts = [];
    for (let i = 0; i < 55; i++)
      pts.push({ x: Math.random()*W, y: Math.random()*H,
        r: Math.random()*1.4+0.4, vx:(Math.random()-0.5)*0.35,
        vy:(Math.random()-0.5)*0.35, a:Math.random()*0.5+0.15 });
  }
  function draw() {
    ctx.clearRect(0,0,W,H);
    pts.forEach(p => {
      p.x+=p.vx; p.y+=p.vy;
      if(p.x<0)p.x=W; if(p.x>W)p.x=0;
      if(p.y<0)p.y=H; if(p.y>H)p.y=0;
      ctx.beginPath(); ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
      ctx.fillStyle=`rgba(200,30,30,${p.a})`; ctx.fill();
    });
    for(let i=0;i<pts.length;i++) for(let j=i+1;j<pts.length;j++){
      const dx=pts[i].x-pts[j].x,dy=pts[i].y-pts[j].y,d=Math.sqrt(dx*dx+dy*dy);
      if(d<130){
        ctx.beginPath();ctx.moveTo(pts[i].x,pts[i].y);ctx.lineTo(pts[j].x,pts[j].y);
        ctx.strokeStyle=`rgba(200,30,30,${0.12*(1-d/130)})`;ctx.lineWidth=0.6;ctx.stroke();
      }
    }
    requestAnimationFrame(draw);
  }
  resize(); init(); draw();
  window.addEventListener('resize',()=>{resize();init();});

  /* ── Sidebar toggle ── */
  const sidebar       = document.getElementById('sidebar');
  const topbar        = document.getElementById('topbar');
  const mainEl        = document.getElementById('main');
  const toggleBtn     = document.getElementById('sidebarToggle');
  let collapsed       = false;
  toggleBtn.addEventListener('click', () => {
    collapsed = !collapsed;
    sidebar.classList.toggle('collapsed', collapsed);
    topbar.classList.toggle('collapsed', collapsed);
    mainEl.classList.toggle('collapsed', collapsed);
    toggleBtn.querySelector('i').className = collapsed ? 'bx bx-menu-alt-right' : 'bx bx-menu';
    // mobile
    sidebar.classList.toggle('mobile-open', !collapsed && window.innerWidth <= 700);
  });

  /* ── Profile dropdown ── */
  const chip    = document.getElementById('userChip');
  const dropdown= document.getElementById('profileDropdown');
  const chevron = document.getElementById('chevron');
  chip.addEventListener('click', () => {
    dropdown.classList.toggle('show');
    chevron.classList.toggle('open');
  });
  document.addEventListener('click', e => {
    if (!chip.contains(e.target)) { dropdown.classList.remove('show'); chevron.classList.remove('open'); }
  });

  /* ── Tab switching ── */
  const navItems = document.querySelectorAll('.panel-nav-item');
  const tabPanes = document.querySelectorAll('.tab-pane');
  navItems.forEach(item => {
    item.addEventListener('click', () => {
      navItems.forEach(n => n.classList.remove('active'));
      tabPanes.forEach(p => p.classList.remove('active'));
      item.classList.add('active');
      document.getElementById('tab-' + item.dataset.tab).classList.add('active');
    });
  });

  <?php if (!empty($errors) || !empty($pw_success)): ?>
  // Auto-switch to password tab if there are password errors/success
  document.querySelector('[data-tab="password"]').click();
  <?php endif; ?>

  /* ── Avatar preview ── */
  document.getElementById('avatarInput').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
      const av = document.getElementById('bigAvatar');
      av.innerHTML = `<img src="${e.target.result}" alt="avatar">`;
    };
    reader.readAsDataURL(file);
  });
</script>
</body>
</html>
<?php?>
