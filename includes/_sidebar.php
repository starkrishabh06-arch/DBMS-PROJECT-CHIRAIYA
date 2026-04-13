<?php
/* _sidebar.php — Money Heist themed sidebar + nav
   Include this at the top of every dashboard page.
   Requires: $db, $_SESSION['detsuid'], $active_page variable set before include.
   e.g. $active_page = 'dashboard'; 
*/
$uid  = $_SESSION['detsuid'];
$ret  = mysqli_query($db, "SELECT name FROM users WHERE id='$uid'");
$row  = mysqli_fetch_array($ret);
$name = $row['name'];
?>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet"/>
<link rel="stylesheet" href="css/style.css"/>
<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

<div class="sidebar" id="sidebar">
  <div class="logo-details">
    <i class='bx bx-mask'></i>
    <span class="logo_name">ExpenseHeist</span>
  </div>
  <ul class="nav-links">
    <li><a href="home.php" <?= ($active_page??'')==='dashboard'?'class="active"':'' ?>>
      <i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
    <li><a href="add-expenses.php" <?= ($active_page??'')==='expenses'?'class="active"':'' ?>>
      <i class='bx bx-trending-down'></i><span class="links_name">Expenses</span></a></li>
    <li><a href="add-income.php" <?= ($active_page??'')==='income'?'class="active"':'' ?>>
      <i class='bx bx-trending-up'></i><span class="links_name">Income</span></a></li>
    <li><a href="manage-transaction.php" <?= ($active_page??'')==='manage'?'class="active"':'' ?>>
      <i class='bx bx-list-ul'></i><span class="links_name">Manage List</span></a></li>
    <li><a href="lending.php" <?= ($active_page??'')==='lending'?'class="active"':'' ?>>
      <i class='bx bx-money'></i><span class="links_name">Lending</span></a></li>
    <li><a href="manage-lending.php" <?= ($active_page??'')==='manage-lending'?'class="active"':'' ?>>
      <i class='bx bx-coin-stack'></i><span class="links_name">Manage Lending</span></a></li>
    <li><a href="analytics.php" <?= ($active_page??'')==='analytics'?'class="active"':'' ?>>
      <i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Analytics</span></a></li>
    <li><a href="report.php" <?= ($active_page??'')==='report'?'class="active"':'' ?>>
      <i class='bx bx-file'></i><span class="links_name">Report</span></a></li>
    <li><a href="user_profile.php" <?= ($active_page??'')==='settings'?'class="active"':'' ?>>
      <i class='bx bx-cog'></i><span class="links_name">Settings</span></a></li>
    <li class="log_out"><a href="logout.php">
      <i class='bx bx-log-out'></i><span class="links_name">Log Out</span></a></li>
  </ul>
</div>

<section class="home-section">
  <nav>
    <div class="sidebar-button">
      <i class='bx bx-menu sidebarBtn'></i>
      <span class="dashboard"><?= htmlspecialchars($page_title ?? 'ExpenseHeist') ?></span>
    </div>
    <div class="search-box">
      <input type="text" id="search-input" class="form-control" placeholder="Search intel…">
      <i class='bx bx-search'></i>
    </div>
    <div class="profile-details">
      <img src="images/maex.png" alt="">
      <span class="admin_name"><?= htmlspecialchars($name) ?></span>
      <i class='bx bx-chevron-down' id='profile-options-toggle'></i>
      <ul class="profile-options" id='profile-options'>
        <li><a href="user_profile.php"><i class="fas fa-user-circle"></i> User Profile</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </nav>
<?php /* home-section left open — close </section> at end of page */ ?>
<script>
(function(){
  const toggleBtn=document.getElementById('profile-options-toggle');
  const profileOptions=document.getElementById('profile-options');
  if(toggleBtn) toggleBtn.addEventListener('click',()=>profileOptions.classList.toggle('show'));

  const sidebar=document.getElementById('sidebar');
  const sidebarBtn=document.querySelector('.sidebarBtn');
  if(sidebarBtn) sidebarBtn.onclick=function(){
    sidebar.classList.toggle('active');
    sidebarBtn.classList.contains('bx-menu')
      ? sidebarBtn.classList.replace('bx-menu','bx-menu-alt-right')
      : sidebarBtn.classList.replace('bx-menu-alt-right','bx-menu');
  };
})();
</script>
