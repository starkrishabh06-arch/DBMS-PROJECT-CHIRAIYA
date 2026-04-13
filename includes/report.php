<?php
session_start();
error_reporting(0);
include('database.php');
$sessionValid = !empty($_SESSION['detsuid']);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExpenseHeist – Report</title>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Oswald:wght@300;400;500;600;700&family=Barlow:wght@300;400;500&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="eh-style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="js/auth.js"></script>
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
    <li><a href="analytics.php"><i class='bx bx-pie-chart-alt-2'></i><span>Analytics</span></a></li>
    <li><a href="report.php" class="active"><i class="bx bx-file"></i><span>Report</span></a></li>
    <li><a href="user_profile.php"><i class='bx bx-cog'></i><span>Settings</span></a></li>
    <li class="eh-sidebar__logout"><a href="logout.php"><i class='bx bx-log-out'></i><span>Log Out</span></a></li>
  </ul>
</div>

<section class="eh-main" id="eh-main">
  <nav class="eh-topnav">
    <div class="eh-topnav__left">
      <button class="eh-sidebar-toggle" id="eh-sidebarToggle"><i class='bx bx-menu' id="eh-sidebarIcon"></i></button>
      <span class="eh-topnav__title">Report</span>
    </div>
    <div class="eh-topnav__profile">
      <img src="images/maex.png" alt="avatar" class="eh-topnav__avatar">
      <span class="eh-topnav__name" id="user-name">User</span>
      <i class='bx bx-chevron-down' id="eh-profileToggle"></i>
      <ul class="eh-profile-dropdown" id="eh-profileDropdown">
        <li><a href="user_profile.php"><i class="fas fa-user-circle"></i> User Profile</a></li>
        <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
      </ul>
    </div>
  </nav>

  <div class="eh-content">

    <!-- Generate form card -->
    <div class="eh-card">
      <div class="eh-card__header">
        <div class="eh-card__header-left">
          <p class="eh-card__eyebrow">Intelligence</p>
          <h5 class="eh-card__title">Generate Report</h5>
        </div>
      </div>
      <div class="eh-card__body">
        <form id="reportForm">
          <div class="row">
            <div class="col-md-3">
              <div class="eh-form-group">
                <label for="reportType">Report Type</label>
                <select class="eh-form-control" id="reportType" name="reportType" required>
                  <option value="" disabled selected>Select type</option>
                  <option value="expense">Expense Report</option>
                  <option value="income">Income Report</option>
                  <option value="pending">Pending Lending</option>
                  <option value="received">Received Lending</option>
                </select>
              </div>
            </div>
            <div class="col-md-3">
              <div class="eh-form-group">
                <label for="startDate">Start Date</label>
                <input type="date" class="eh-form-control" id="startDate" name="startDate" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="eh-form-group">
                <label for="endDate">End Date</label>
                <input type="date" class="eh-form-control" id="endDate" name="endDate" required>
              </div>
            </div>
            <div class="col-md-3">
              <div class="eh-form-group">
                <label>&nbsp;</label><br>
                <button type="submit" class="eh-btn eh-btn--primary eh-btn--block" id="generateBtn">
                  <span id="btnText">Generate Report</span>
                  <span id="btnSpinner" class="spinner-border spinner-border-sm" style="display:none;"></span>
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <!-- Results card (hidden until report generated) -->
    <div id="report-results" style="display:none;">
      <div class="eh-summary-row">
        <div class="eh-summary-box">
          <p>Total Records</p>
          <h4 id="total-records">0</h4>
        </div>
        <div class="eh-summary-box">
          <p>Total Amount</p>
          <h4>Rs. <span id="total-amount">0</span></h4>
        </div>
      </div>

      <div class="eh-card">
        <div class="eh-card__header">
          <div class="eh-card__header-left">
            <p class="eh-card__eyebrow">Results</p>
            <h5 class="eh-card__title" id="report-title">Report</h5>
          </div>
          <span style="font-family:var(--eh-font-heading);font-size:11px;letter-spacing:1px;color:var(--eh-text-dim);" id="date-range"></span>
        </div>
        <div class="eh-card__body" style="padding:0;">
          <div style="overflow-x:auto;">
            <table class="eh-table">
              <thead id="report-thead"></thead>
              <tbody id="report-tbody"></tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>

<script src="eh-layout.js"></script>
<script>
function checkAuth() {
  var hasToken = localStorage.getItem('access_token');
  var hasSession = <?= $sessionValid ? 'true' : 'false' ?>;
  if (!hasToken && !hasSession) { window.location.href = 'index.php'; return false; }
  return true;
}

$(document).ready(function() {
  if (!checkAuth()) return;
  var ud = localStorage.getItem('user_data');
  if (ud) $('#user-name').text(JSON.parse(ud).name || 'User');

  var today = new Date(), ago = new Date(today - 30*86400000);
  $('#endDate').val(today.toISOString().split('T')[0]);
  $('#startDate').val(ago.toISOString().split('T')[0]);

  $('#reportForm').on('submit', function(e) {
    e.preventDefault();
    var type = $('#reportType').val(), start = $('#startDate').val(), end = $('#endDate').val();
    if (!type || !start || !end) { alert('Please fill in all fields'); return; }
    $('#generateBtn').prop('disabled', true); $('#btnText').hide(); $('#btnSpinner').show();

    $.ajax({
      url: 'api/report.php', type: 'GET',
      data: { type: type, start_date: start, end_date: end }, dataType: 'json',
      success: function(r) {
        if (r.status === 'success') displayReport(r);
        else alert(r.message || 'Error generating report');
      },
      error: function(xhr) {
        if (xhr.status === 401) { localStorage.removeItem('access_token'); window.location.href = 'index.php'; }
        else alert('Error generating report. Please try again.');
      },
      complete: function() { $('#generateBtn').prop('disabled', false); $('#btnText').show(); $('#btnSpinner').hide(); }
    });
  });
});

function displayReport(r) {
  var titles = { expense:'Expense Report', income:'Income Report', pending:'Pending Lending Report', received:'Received Lending Report' };
  $('#report-title').text(titles[r.report_type] || 'Report');
  $('#date-range').text(r.date_range.start + ' — ' + r.date_range.end);
  $('#total-records').text(r.summary.total_records || 0);
  var amt = r.summary.total_amount || r.summary.total_pending || r.summary.total_received || 0;
  $('#total-amount').text(parseFloat(amt).toFixed(2));

  var thead = '<tr>', tbody = '';
  if (r.report_type === 'expense' || r.report_type === 'income') {
    thead += '<th>#</th><th>Date</th><th>Category</th><th>Amount</th><th>Description</th></tr>';
    tbody = r.data.length
      ? r.data.map(function(item, i) {
          return '<tr><td>'+(i+1)+'</td><td>'+item.date+'</td><td>'+(item.category||'-')+'</td><td>Rs. '+parseFloat(item.amount).toFixed(2)+'</td><td>'+(item.description||'-')+'</td></tr>';
        }).join('')
      : '<tr><td colspan="5" style="text-align:center;color:var(--eh-text-dim);padding:30px;">No data found</td></tr>';
  } else {
    thead += '<th>#</th><th>Name</th><th>Date</th><th>Amount</th><th>Description</th><th>Status</th></tr>';
    tbody = r.data.length
      ? r.data.map(function(item, i) {
          var badge = item.status === 'received'
            ? '<span class="eh-badge eh-badge--green">Received</span>'
            : '<span class="eh-badge eh-badge--gold">Pending</span>';
          return '<tr><td>'+(i+1)+'</td><td>'+item.name+'</td><td>'+item.date+'</td><td>Rs. '+parseFloat(item.amount).toFixed(2)+'</td><td>'+(item.description||'-')+'</td><td>'+badge+'</td></tr>';
        }).join('')
      : '<tr><td colspan="6" style="text-align:center;color:var(--eh-text-dim);padding:30px;">No data found</td></tr>';
  }
  $('#report-thead').html(thead);
  $('#report-tbody').html(tbody);
  $('#report-results').show();
  $('html,body').animate({ scrollTop: $('#report-results').offset().top - 20 }, 400);
}
</script>
</body>
</html>
