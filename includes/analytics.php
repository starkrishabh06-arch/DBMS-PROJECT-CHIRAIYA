<?php
session_start();
error_reporting(0);
include('database.php');

if (empty($_SESSION['detsuid'])) {
  header('location:logout.php');
  exit;
}

$uid = $_SESSION['detsuid'];
$ret = mysqli_query($db, "SELECT name FROM users WHERE id='$uid'");
$row = mysqli_fetch_array($ret);
$name = htmlspecialchars($row['name'] ?? 'User');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExpenseHeist – Analytics</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="eh-style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/auth.js"></script>
  <style>
    /* Custom legend injected by chart plugin */
    .chart-legend {
      display: flex; flex-wrap: wrap; gap: 10px;
      margin-top: 18px; padding: 0 4px;
    }
    .chart-legend-item {
      display: flex; align-items: center; gap: 7px;
      font-family: var(--eh-font-heading);
      font-size: 11px; letter-spacing: 1px; text-transform: uppercase;
      color: var(--eh-text-mid);
    }
    .chart-legend-color-box {
      width: 10px; height: 10px; border-radius: 2px; flex-shrink: 0;
    }
  </style>
</head>
<body>

<div class="eh-sidebar" id="eh-sidebar">
  <div class="eh-sidebar__logo">
    <i class='bx bx-album'></i>
    <span class="eh-sidebar__logo-name">ExpenseHeist</span>
  </div>
  <ul class="eh-sidebar__links">
    <li><a href="home.php"><i class='bx bx-grid-alt'></i><span>Dashboard</span></a></li>
    <li><a href="add-expenses.php"><i class='bx bx-box'></i><span>Expenses</span></a></li>
    <li><a href="add-income.php"><i class='bx bx-box'></i><span>Income</span></a></li>
    <li><a href="manage-transaction.php"><i class='bx bx-list-ul'></i><span>Manage List</span></a></li>
    <li><a href="lending.php"><i class='bx bx-money'></i><span>Lending</span></a></li>
    <li><a href="manage-lending.php"><i class='bx bx-coin-stack'></i><span>Manage Lending</span></a></li>
    <li><a href="analytics.php" class="active"><i class='bx bx-pie-chart-alt-2'></i><span>Analytics</span></a></li>
    <li><a href="report.php"><i class="bx bx-file"></i><span>Report</span></a></li>
    <li><a href="user_profile.php"><i class='bx bx-cog'></i><span>Settings</span></a></li>
    <li class="eh-sidebar__logout"><a href="logout.php"><i class='bx bx-log-out'></i><span>Log Out</span></a></li>
  </ul>
</div>

<section class="eh-main" id="eh-main">
  <nav class="eh-topnav">
    <div class="eh-topnav__left">
      <button class="eh-sidebar-toggle" id="eh-sidebarToggle"><i class='bx bx-menu' id="eh-sidebarIcon"></i></button>
      <span class="eh-topnav__title">Analytics</span>
    </div>
    <div class="eh-topnav__profile">
      <img src="images/maex.png" alt="avatar" class="eh-topnav__avatar">
      <span class="eh-topnav__name"><?= $name ?></span>
      <i class='bx bx-chevron-down' id="eh-profileToggle"></i>
      <ul class="eh-profile-dropdown" id="eh-profileDropdown">
        <li><a href="user_profile.php"><i class="fas fa-user-circle"></i> User Profile</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="eh-content">
    <div class="eh-card">
      <div class="eh-card__header">
        <div class="eh-card__header-left">
          <p class="eh-card__eyebrow">Breakdown</p>
          <h5 class="eh-card__title">Expense Analytics</h5>
        </div>
      </div>
      <div class="eh-card__body eh-card__body--chart">
        <canvas id="myChart"></canvas>
      </div>
    </div>
  </div>
</section>

<script src="eh-layout.js"></script>
<script>
/* Backend data fetch — unchanged */
fetch('pie-data.php')
  .then(r => r.json())
  .then(data => {
    if (data.length === 0) {
      document.getElementById('myChart').replaceWith(
        Object.assign(document.createElement('p'), {
          textContent: 'No data found.',
          style: 'color:var(--eh-text-mid);font-family:var(--eh-font-heading);letter-spacing:2px;padding:20px;'
        })
      );
      return;
    }

    const labels      = data.map(i => i.category);
    const values      = data.map(i => i.total_expense);
    const total       = values.reduce((a, b) => a + b, 0);
    const percentages = values.map(v => ((v / total) * 100).toFixed(2));
    const COLORS = ['#c81e1e','#d4a04a','#3498DB','#8E44AD','#27ae60','#e67e22','#16a085','#e74c3c','#f39c12','#2980b9'];

    const ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, {
      type: 'pie',
      data: {
        labels,
        datasets: [{ data: values, backgroundColor: COLORS, borderColor: 'rgba(6,6,8,0.6)', borderWidth: 2 }]
      },
      options: {
        responsive: true, maintainAspectRatio: false,
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(ctx) {
                return ctx.label + ': ' + percentages[ctx.dataIndex] + '% — Rs ' + ctx.raw;
              }
            }
          }
        }
      },
      plugins: [{
        afterRender(chart) {
          if (document.querySelector('.chart-legend')) return;
          const legend = document.createElement('div');
          legend.className = 'chart-legend';
          labels.forEach((lbl, i) => {
            const item = document.createElement('div');
            item.className = 'chart-legend-item';
            const box = document.createElement('div');
            box.className = 'chart-legend-color-box';
            box.style.backgroundColor = COLORS[i % COLORS.length];
            const txt = document.createElement('span');
            txt.textContent = lbl + ': ' + percentages[i] + '% — Rs ' + values[i];
            item.appendChild(box); item.appendChild(txt);
            legend.appendChild(item);
          });
          chart.canvas.closest('.eh-card__body').appendChild(legend);
        }
      }]
    });
  });
</script>
</body>
</html>
