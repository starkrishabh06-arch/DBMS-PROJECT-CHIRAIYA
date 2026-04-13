<?php
session_start();
error_reporting(0);
include('database.php');

$sessionValid = !empty($_SESSION['detsuid']);
$hasToken = false;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExpenseHeist – Dashboard</title>

  <!-- Fonts (matches index.php theme) -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- Icons -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.min.css">
  <!-- Bootstrap (layout utilities kept) -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/auth.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<!-- ░░░░░░░  SIDEBAR  ░░░░░░░ -->
<div class="eh-sidebar" id="eh-sidebar">
  <div class="eh-sidebar__logo">
    <i class='bx bx-album'></i>
    <span class="eh-sidebar__logo-name">ExpenseHeist</span>
  </div>
  <ul class="eh-sidebar__links">
    <li>
      <a href="#" class="active">
        <i class='bx bx-grid-alt'></i>
        <span>Dashboard</span>
      </a>
    </li>
    <li><a href="add-expenses.php"><i class='bx bx-box'></i><span>Expenses</span></a></li>
    <li><a href="add-income.php"><i class='bx bx-box'></i><span>Income</span></a></li>
    <li><a href="manage-transaction.php"><i class='bx bx-list-ul'></i><span>Manage List</span></a></li>
    <li><a href="lending.php"><i class='bx bx-money'></i><span>Lending</span></a></li>
    <li><a href="manage-lending.php"><i class='bx bx-coin-stack'></i><span>Manage Lending</span></a></li>
    <li><a href="analytics.php"><i class='bx bx-pie-chart-alt-2'></i><span>Analytics</span></a></li>
    <li><a href="report.php"><i class="bx bx-file"></i><span>Report</span></a></li>
    <li><a href="user_profile.php"><i class='bx bx-cog'></i><span>Settings</span></a></li>
    <li class="eh-sidebar__logout">
      <a href="logout.php"><i class='bx bx-log-out'></i><span>Log Out</span></a>
    </li>
  </ul>
</div>

<!-- ░░░░░░░  MAIN  ░░░░░░░ -->
<section class="eh-main" id="eh-main">

  <!-- ── TOP NAV ── -->
  <nav class="eh-topnav">
    <div class="eh-topnav__left">
      <button class="eh-sidebar-toggle" id="eh-sidebarToggle">
        <i class='bx bx-menu' id="eh-sidebarIcon"></i>
      </button>
      <span class="eh-topnav__title">Dashboard</span>
    </div>

    <div class="eh-topnav__search">
      <i class='bx bx-search'></i>
      <input type="text" id="search-input" placeholder="Search…">
    </div>

    <div class="eh-topnav__profile" id="eh-profileWrap">
      <img src="images/maex.png" alt="avatar" class="eh-topnav__avatar">
      <span class="eh-topnav__name" id="user-name">Loading…</span>
      <i class='bx bx-chevron-down' id="eh-profileToggle"></i>
      <ul class="eh-profile-dropdown" id="eh-profileDropdown">
        <li><a href="user_profile.php"><i class="fas fa-user-circle"></i> User Profile</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </nav>

  <!-- ── CONTENT ── -->
  <div class="eh-content">

    <!-- overview cards -->
    <div class="eh-overview">

      <div class="eh-stat-card">
        <div class="eh-stat-card__body">
          <p class="eh-stat-card__label">Today Expense</p>
          <p class="eh-stat-card__value" id="today-expense">0</p>
          <p class="eh-stat-card__sub"><i class='bx bx-up-arrow-alt'></i> Up from Today</p>
        </div>
        <div class="eh-stat-card__icon"><i class="fas fa-circle-plus"></i></div>
      </div>

      <div class="eh-stat-card eh-stat-card--two">
        <div class="eh-stat-card__body">
          <p class="eh-stat-card__label">Yesterday Expense</p>
          <p class="eh-stat-card__value" id="yesterday-expense">0</p>
          <p class="eh-stat-card__sub"><i class='bx bx-up-arrow-alt'></i> Up from Yesterday</p>
        </div>
        <div class="eh-stat-card__icon"><i class="fas fa-wallet"></i></div>
      </div>

      <div class="eh-stat-card eh-stat-card--three">
        <div class="eh-stat-card__body">
          <p class="eh-stat-card__label">Last 30 Day Expense</p>
          <p class="eh-stat-card__value" id="monthly-expense">0</p>
          <p class="eh-stat-card__sub"><i class='bx bx-up-arrow-alt'></i> Up from Last 30 Days</p>
        </div>
        <div class="eh-stat-card__icon"><i class="fas fa-history"></i></div>
      </div>

      <div class="eh-stat-card eh-stat-card--four">
        <div class="eh-stat-card__body">
          <p class="eh-stat-card__label">Total Expense</p>
          <p class="eh-stat-card__value" id="total-expense">0</p>
          <p class="eh-stat-card__sub"><i class='bx bx-up-arrow-alt'></i> Up from Year</p>
        </div>
        <div class="eh-stat-card__icon"><i class="fas fa-piggy-bank"></i></div>
      </div>

    </div><!-- /overview -->

    <!-- chart card -->
    <div class="eh-card">
      <div class="eh-card__header">
        <p class="eh-card__eyebrow">Analytics</p>
        <h5 class="eh-card__title">Expense Chart</h5>
      </div>
      <div class="eh-card__body eh-card__body--chart">
        <canvas id="myChart"></canvas>
      </div>
    </div>

    <!-- category table card -->
    <div class="eh-card">
      <div class="eh-card__header">
        <p class="eh-card__eyebrow">Breakdown</p>
        <h5 class="eh-card__title">Category Table</h5>
      </div>
      <div class="eh-card__body">
        <table class="eh-table">
          <thead>
            <tr>
              <th>Percentage</th>
              <th>Category</th>
              <th>Amount</th>
            </tr>
          </thead>
          <tbody id="expense-table-body"></tbody>
          <tfoot>
            <tr>
              <th></th>
              <th>Total</th>
              <th>Rs. <span id="category-total">0</span></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>

  </div><!-- /content -->
</section><!-- /main -->

<!-- FAB -->
<button id="add-button" title="Add Expense"><i class="fas fa-plus"></i></button>

<!-- ░░░░░░░  SCRIPTS  ░░░░░░░ -->
<script>
var chart;

/* ── Auth check (backend unchanged) ── */
function checkAuthAndRedirect() {
  var hasToken  = localStorage.getItem('access_token');
  var hasSession = <?php echo $sessionValid ? 'true' : 'false'; ?>;
  if (!hasToken && !hasSession) {
    window.location.href = 'index.php';
    return false;
  }
  return true;
}

/* ── Load dashboard data (backend unchanged) ── */
function loadDashboardData() {
  if (!checkAuthAndRedirect()) return;
  $.ajax({
    url: 'api/dashboard.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        var data = response.data;
        $('#user-name').text(data.user.name || 'User');
        $('#today-expense').text(data.today_expense || 0);
        $('#yesterday-expense').text(data.yesterday_expense || 0);
        $('#monthly-expense').text(data.monthly_expense || 0);
        $('#total-expense').text(data.total_expense || 0);
        updateChart(data.chart.labels, data.chart.data);
        updateCategoryTable(data.categories);
      } else {
        console.error('Dashboard error:', response.message);
        if (response.message && response.message.includes('Unauthorized')) {
          localStorage.removeItem('access_token');
          window.location.href = 'index.php';
        }
      }
    },
    error: function(xhr) {
      console.error('Dashboard request failed');
      if (xhr.status === 401) {
        localStorage.removeItem('access_token');
        window.location.href = 'index.php';
      } else {
        $('#user-name').text('Error loading data. Please refresh.');
      }
    }
  });
}

/* ── Chart (backend data unchanged) ── */
function updateChart(labels, data) {
  var ctx = document.getElementById('myChart').getContext('2d');
  if (chart) chart.destroy();
  chart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Expenses',
        data: data,
        backgroundColor: 'rgba(200,30,30,0.35)',
        borderColor: '#c81e1e',
        borderWidth: 1,
        borderRadius: 3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { labels: { color: '#9994a0', font: { family: 'Oswald' } } }
      },
      scales: {
        x: {
          ticks: { color: '#9994a0' },
          grid:  { color: 'rgba(255,255,255,0.04)' }
        },
        y: {
          beginAtZero: true,
          ticks: { color: '#9994a0' },
          grid:  { color: 'rgba(255,255,255,0.04)' }
        }
      }
    }
  });
}

/* ── Category table (backend data unchanged) ── */
function updateCategoryTable(categories) {
  var total  = categories.reduce(function(acc, curr) { return acc + curr.total_expense; }, 0);
  var colors = ['#c81e1e','#e05260','#d4a04a','#8E44AD','#3498DB','#FFA07A','#6B8E23','#FF00FF','#FFD700','#00FFFF'];
  var rows = categories.map(function(item, i) {
    var pct   = total > 0 ? ((item.total_expense / total) * 100).toFixed(2) : 0;
    var color = colors[i % colors.length];
    return '<tr>' +
      '<td><span class="eh-badge" style="background:' + color + '">' + pct + '%</span></td>' +
      '<td>' + item.category + '</td>' +
      '<td>Rs. ' + item.total_expense.toFixed(2) + '</td>' +
    '</tr>';
  }).join('');
  $('#expense-table-body').html(rows);
  $('#category-total').text(total.toFixed(2));
}

$(document).ready(function() {
  loadDashboardData();
  setInterval(loadDashboardData, 30000);

  $('#search-input').on('keyup', function() {
    var val = $(this).val().toLowerCase();
    $('table tbody tr').filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
    });
  });
});

/* ── Sidebar toggle ── */
var sidebar     = document.getElementById('eh-sidebar');
var mainSection = document.getElementById('eh-main');
var sidebarIcon = document.getElementById('eh-sidebarIcon');
document.getElementById('eh-sidebarToggle').addEventListener('click', function() {
  sidebar.classList.toggle('collapsed');
  mainSection.classList.toggle('expanded');
  if (sidebar.classList.contains('collapsed')) {
    sidebarIcon.classList.replace('bx-menu', 'bx-menu-alt-right');
  } else {
    sidebarIcon.classList.replace('bx-menu-alt-right', 'bx-menu');
  }
});

/* ── Profile dropdown ── */
document.getElementById('eh-profileToggle').addEventListener('click', function() {
  document.getElementById('eh-profileDropdown').classList.toggle('show');
});

/* ── FAB ── */
document.getElementById('add-button').addEventListener('click', function() {
  this.style.transform = 'translateX(50px)';
  setTimeout(function() { window.location.href = 'add-expenses.php'; }, 200);
});
</script>

<!-- ░░░░░░░  STYLES  ░░░░░░░ -->
<style>
/* ═══════════════════════════════════════════════════
   EXPENSEHEIST — DASHBOARD  (Money Heist dark theme)
═══════════════════════════════════════════════════ */
:root {
  --eh-red:          #c81e1e;
  --eh-red-dark:     #8f0f0f;
  --eh-red-glow:     rgba(200,30,30,0.28);
  --eh-red-subtle:   rgba(200,30,30,0.08);
  --eh-gold:         #d4a04a;
  --eh-bg-void:      #060608;
  --eh-bg-surface:   #0e0e14;
  --eh-bg-elevated:  #151520;
  --eh-bg-card:      #111118;
  --eh-border:       rgba(255,255,255,0.06);
  --eh-border-red:   rgba(200,30,30,0.35);
  --eh-text-bright:  #f5f0e8;
  --eh-text-mid:     #9994a0;
  --eh-text-dim:     #4e4a58;
  --eh-sidebar-w:    250px;
  --eh-sidebar-coll: 68px;
  --eh-topnav-h:     60px;
  --eh-font-display: 'Bebas Neue', sans-serif;
  --eh-font-heading: 'Oswald', sans-serif;
  --eh-font-body:    'Barlow', sans-serif;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: var(--eh-font-body);
  background: var(--eh-bg-void);
  color: var(--eh-text-bright);
  overflow-x: hidden;
  min-height: 100vh;
}

ul { list-style: none; }
a  { text-decoration: none; color: inherit; }
button { background: none; border: none; cursor: pointer; }

/* ──────────── SIDEBAR ──────────── */
.eh-sidebar {
  position: fixed; top: 0; left: 0;
  width: var(--eh-sidebar-w); height: 100vh;
  background: var(--eh-bg-surface);
  border-right: 1px solid var(--eh-border-red);
  display: flex; flex-direction: column;
  transition: width 0.3s ease;
  z-index: 200;
  overflow: hidden;
}
.eh-sidebar.collapsed { width: var(--eh-sidebar-coll); }

/* logo row */
.eh-sidebar__logo {
  display: flex; align-items: center; gap: 12px;
  padding: 0 18px;
  height: var(--eh-topnav-h);
  border-bottom: 1px solid var(--eh-border-red);
  white-space: nowrap; overflow: hidden;
}
.eh-sidebar__logo i {
  font-size: 26px; color: var(--eh-red); flex-shrink: 0;
}
.eh-sidebar__logo-name {
  font-family: var(--eh-font-display);
  font-size: 20px; letter-spacing: 2px;
  color: var(--eh-text-bright);
  transition: opacity 0.2s;
}
.eh-sidebar.collapsed .eh-sidebar__logo-name { opacity: 0; width: 0; }

/* links */
.eh-sidebar__links {
  flex: 1; overflow-y: auto; padding: 12px 0;
}
.eh-sidebar__links li a {
  display: flex; align-items: center; gap: 14px;
  padding: 12px 18px;
  font-family: var(--eh-font-heading);
  font-size: 13px; letter-spacing: 1px; text-transform: uppercase;
  color: var(--eh-text-mid);
  white-space: nowrap;
  transition: background 0.2s, color 0.2s, border-left 0.2s;
  border-left: 3px solid transparent;
  position: relative;
}
.eh-sidebar__links li a i {
  font-size: 20px; flex-shrink: 0;
  transition: color 0.2s;
}
.eh-sidebar__links li a span { transition: opacity 0.2s; }
.eh-sidebar.collapsed .eh-sidebar__links li a span { opacity: 0; width: 0; overflow: hidden; }

.eh-sidebar__links li a:hover,
.eh-sidebar__links li a.active {
  background: var(--eh-red-subtle);
  color: var(--eh-text-bright);
  border-left-color: var(--eh-red);
}
.eh-sidebar__links li a:hover i,
.eh-sidebar__links li a.active i { color: var(--eh-red); }

.eh-sidebar__logout { margin-top: auto; border-top: 1px solid var(--eh-border); }

/* ──────────── MAIN SECTION ──────────── */
.eh-main {
  margin-left: var(--eh-sidebar-w);
  transition: margin-left 0.3s ease;
  min-height: 100vh;
  display: flex; flex-direction: column;
}
.eh-main.expanded { margin-left: var(--eh-sidebar-coll); }

/* ──────────── TOP NAV ──────────── */
.eh-topnav {
  position: sticky; top: 0; z-index: 100;
  height: var(--eh-topnav-h);
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 24px;
  background: rgba(6,6,8,0.9);
  backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--eh-border-red);
}
.eh-topnav::after {
  content: '';
  position: absolute; bottom: 0; left: 0;
  width: 100%; height: 1px;
  background: linear-gradient(90deg, transparent, var(--eh-red), transparent);
  animation: eh-shimmer 4s linear infinite;
}
@keyframes eh-shimmer {
  0%   { transform: translateX(-100%); }
  100% { transform: translateX(100%);  }
}

.eh-topnav__left { display: flex; align-items: center; gap: 14px; }
.eh-sidebar-toggle { font-size: 22px; color: var(--eh-text-bright); }
.eh-topnav__title {
  font-family: var(--eh-font-display);
  font-size: 22px; letter-spacing: 3px;
  color: var(--eh-text-bright);
}

/* search */
.eh-topnav__search {
  display: flex; align-items: center; gap: 8px;
  background: var(--eh-bg-elevated);
  border: 1px solid var(--eh-border);
  border-radius: 6px;
  padding: 0 12px;
  height: 36px;
}
.eh-topnav__search i { color: var(--eh-text-dim); font-size: 16px; }
.eh-topnav__search input {
  background: none; border: none; outline: none;
  color: var(--eh-text-bright);
  font-family: var(--eh-font-body); font-size: 13px;
  width: 180px;
}
.eh-topnav__search input::placeholder { color: var(--eh-text-dim); }

/* profile */
.eh-topnav__profile {
  position: relative; display: flex; align-items: center; gap: 10px;
  cursor: pointer;
}
.eh-topnav__avatar {
  width: 34px; height: 34px;
  border-radius: 50%;
  border: 1px solid var(--eh-border-red);
  object-fit: cover;
}
.eh-topnav__name {
  font-family: var(--eh-font-heading);
  font-size: 13px; letter-spacing: 1px; text-transform: uppercase;
  color: var(--eh-text-mid);
}
#eh-profileToggle { color: var(--eh-text-dim); font-size: 18px; }

.eh-profile-dropdown {
  display: none; position: absolute; top: calc(100% + 10px); right: 0;
  background: var(--eh-bg-elevated);
  border: 1px solid var(--eh-border-red);
  border-radius: 6px; min-width: 170px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.5);
  overflow: hidden; z-index: 999;
}
.eh-profile-dropdown.show { display: block; }
.eh-profile-dropdown li a {
  display: flex; align-items: center; gap: 10px;
  padding: 11px 16px;
  font-family: var(--eh-font-heading);
  font-size: 12px; letter-spacing: 1px; text-transform: uppercase;
  color: var(--eh-text-mid);
  transition: background 0.2s, color 0.2s;
}
.eh-profile-dropdown li a i { color: var(--eh-red); }
.eh-profile-dropdown li a:hover {
  background: var(--eh-red-subtle); color: var(--eh-text-bright);
}

/* ──────────── CONTENT ──────────── */
.eh-content {
  padding: 28px 24px;
  flex: 1;
}

/* ── Stat cards ── */
.eh-overview {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 28px;
}
.eh-stat-card {
  background: var(--eh-bg-card);
  border: 1px solid var(--eh-border-red);
  border-radius: 8px;
  padding: 22px 20px;
  display: flex; align-items: center; justify-content: space-between;
  position: relative; overflow: hidden;
  transition: transform 0.25s, box-shadow 0.25s;
}
.eh-stat-card::before {
  content: '';
  position: absolute; top: 0; left: 0;
  width: 0; height: 2px; background: var(--eh-red);
  transition: width 0.4s;
}
.eh-stat-card:hover::before { width: 100%; }
.eh-stat-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 32px rgba(200,30,30,0.12);
}

.eh-stat-card__label {
  font-family: var(--eh-font-heading);
  font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
  color: var(--eh-text-dim);
  margin-bottom: 8px;
}
.eh-stat-card__value {
  font-family: var(--eh-font-display);
  font-size: 32px; letter-spacing: 2px;
  color: var(--eh-text-bright);
  margin-bottom: 6px;
}
.eh-stat-card__sub {
  font-size: 11px; color: var(--eh-text-dim);
  display: flex; align-items: center; gap: 4px;
}
.eh-stat-card__sub i { color: var(--eh-red); }
.eh-stat-card__icon {
  font-size: 32px; opacity: 0.18;
}
.eh-stat-card--two   .eh-stat-card__icon { color: var(--eh-gold); }
.eh-stat-card--three .eh-stat-card__icon { color: #3498DB; }
.eh-stat-card--four  .eh-stat-card__icon { color: var(--eh-red); }

/* ── Cards ── */
.eh-card {
  background: var(--eh-bg-card);
  border: 1px solid var(--eh-border-red);
  border-radius: 8px;
  margin-bottom: 24px;
  overflow: hidden;
}
.eh-card__header {
  padding: 18px 22px 14px;
  border-bottom: 1px solid var(--eh-border);
}
.eh-card__eyebrow {
  font-family: var(--eh-font-heading);
  font-size: 10px; letter-spacing: 3px; text-transform: uppercase;
  color: var(--eh-red); margin-bottom: 4px;
}
.eh-card__title {
  font-family: var(--eh-font-display);
  font-size: 22px; letter-spacing: 2px;
  color: var(--eh-text-bright);
}
.eh-card__body {
  padding: 22px;
}
.eh-card__body--chart {
  height: 400px;
  padding: 16px 22px;
}
.eh-card__body--chart canvas {
  width: 100% !important;
  height: 100% !important;
}

/* ── Table ── */
.eh-table {
  width: 100%; border-collapse: collapse;
  font-family: var(--eh-font-body); font-size: 14px;
}
.eh-table th {
  font-family: var(--eh-font-heading);
  font-size: 11px; letter-spacing: 2px; text-transform: uppercase;
  color: var(--eh-text-dim);
  padding: 10px 16px;
  border-bottom: 1px solid var(--eh-border-red);
  text-align: left;
}
.eh-table td {
  padding: 12px 16px;
  border-bottom: 1px solid var(--eh-border);
  color: var(--eh-text-mid);
}
.eh-table tbody tr:hover td { background: var(--eh-red-subtle); color: var(--eh-text-bright); }
.eh-table tfoot th {
  color: var(--eh-text-bright);
  border-top: 1px solid var(--eh-border-red);
  border-bottom: none;
}

.eh-badge {
  display: inline-block;
  font-family: var(--eh-font-heading);
  font-size: 11px; letter-spacing: 1px; text-transform: uppercase;
  padding: 4px 10px; border-radius: 3px;
  color: #fff;
}

/* ── FAB ── */
#add-button {
  position: fixed; bottom: 24px; right: 24px;
  border-radius: 50%;
  background: var(--eh-red);
  width: 60px; height: 60px;
  display: flex; align-items: center; justify-content: center;
  box-shadow: 0 4px 20px var(--eh-red-glow);
  transition: all 0.2s ease;
  z-index: 999;
}
#add-button:hover {
  transform: translateY(-3px);
  background: #a51818;
  box-shadow: 0 8px 32px var(--eh-red-glow);
}
#add-button i { font-size: 22px; color: #fff; transition: transform 0.2s; }
#add-button:hover i { transform: rotate(-45deg); }

/* ── RESPONSIVE ── */
@media (max-width: 1100px) {
  .eh-overview { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
  .eh-sidebar { width: var(--eh-sidebar-coll); }
  .eh-sidebar .eh-sidebar__logo-name,
  .eh-sidebar .eh-sidebar__links li a span { opacity: 0; width: 0; overflow: hidden; }
  .eh-main { margin-left: var(--eh-sidebar-coll); }
  .eh-main.expanded { margin-left: var(--eh-sidebar-coll); }
  .eh-overview { grid-template-columns: 1fr; }
  .eh-topnav__search { display: none; }
  .eh-card__body--chart { height: 280px; }
}
@media (max-width: 480px) {
  .eh-content { padding: 16px 14px; }
  .eh-stat-card__value { font-size: 26px; }
}
</style>

</body>
</html>
