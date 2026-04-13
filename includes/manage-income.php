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
  <title>ExpenseHeist – Manage Income</title>
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
    <li><a href="manage-income.php" class="active"><i class='bx bx-coin-stack'></i><span>Manage Income</span></a></li>
    <li><a href="lending.php"><i class='bx bx-money'></i><span>Lending</span></a></li>
    <li><a href="manage-lending.php"><i class='bx bx-coin-stack'></i><span>Manage Lending</span></a></li>
    <li><a href="analytics.php"><i class='bx bx-pie-chart-alt-2'></i><span>Analytics</span></a></li>
    <li><a href="report.php"><i class="bx bx-file"></i><span>Report</span></a></li>
    <li><a href="user_profile.php"><i class='bx bx-cog'></i><span>Settings</span></a></li>
    <li class="eh-sidebar__logout"><a href="logout.php"><i class='bx bx-log-out'></i><span>Log Out</span></a></li>
  </ul>
</div>

<section class="eh-main" id="eh-main">
  <nav class="eh-topnav">
    <div class="eh-topnav__left">
      <button class="eh-sidebar-toggle" id="eh-sidebarToggle"><i class='bx bx-menu' id="eh-sidebarIcon"></i></button>
      <span class="eh-topnav__title">Manage Income</span>
    </div>
    <div class="eh-topnav__search">
      <i class='bx bx-search'></i>
      <input type="text" id="search-input" placeholder="Search…">
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
    <div class="eh-summary-row">
      <div class="eh-summary-box">
        <p>Total Income</p>
        <h4>Rs. <span id="total-income">0.00</span></h4>
      </div>
    </div>

    <div class="eh-card">
      <div class="eh-card__header">
        <div class="eh-card__header-left">
          <p class="eh-card__eyebrow">Records</p>
          <h5 class="eh-card__title">Manage Income</h5>
        </div>
        <div class="eh-toolbar">
          <label style="font-family:var(--eh-font-heading);font-size:11px;letter-spacing:1px;color:var(--eh-text-dim);margin:0;">
            Show
            <select class="eh-select-sm mx-1" id="select-entries">
              <option value="10">10</option><option value="25">25</option>
              <option value="50">50</option><option value="100">100</option>
            </select>
            entries
          </label>
        </div>
      </div>
      <div class="eh-card__body" style="padding:0;">
        <div style="overflow-x:auto;">
          <table class="eh-table">
            <thead>
              <tr><th>#</th><th>Category</th><th>Amount</th><th>Description</th><th>Date</th><th>Action</th></tr>
            </thead>
            <tbody id="income-tbody">
              <tr><td colspan="6" style="text-align:center;padding:40px;color:var(--eh-text-dim);"><i class="fas fa-spinner fa-spin"></i> Loading…</td></tr>
            </tbody>
          </table>
        </div>
        <div style="padding:16px 22px;">
          <ul class="pagination eh-pagination justify-content-end" id="pagination"></ul>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="eh-layout.js"></script>
<script>
var currentPage = 1, currentLimit = 10;

function checkAuth() {
  var hasToken = localStorage.getItem('access_token');
  var hasSession = <?= $sessionValid ? 'true' : 'false' ?>;
  if (!hasToken && !hasSession) { window.location.href = 'index.php'; return false; }
  return true;
}

function loadIncome() {
  if (!checkAuth()) return;
  $.ajax({
    url: 'api/transactions.php', type: 'GET',
    data: { page: currentPage, limit: currentLimit, type: 'income' }, dataType: 'json',
    success: function(r) {
      if (r.status === 'success') renderIncome(r.data.transactions, r.data.pagination);
      else $('#income-tbody').html('<tr><td colspan="6" style="text-align:center;color:#e05260;">' + r.message + '</td></tr>');
    },
    error: function(xhr) {
      if (xhr.status === 401) { localStorage.removeItem('access_token'); window.location.href = 'index.php'; }
      else $('#income-tbody').html('<tr><td colspan="6" style="text-align:center;color:#e05260;">Error loading data</td></tr>');
    }
  });
}

function renderIncome(income, pagination) {
  if (!income.length) {
    $('#income-tbody').html('<tr><td colspan="6" style="text-align:center;color:var(--eh-text-dim);padding:30px;">No income records found</td></tr>');
    $('#pagination').html(''); $('#total-income').text('0.00'); return;
  }
  var start = (pagination.current_page - 1) * pagination.limit + 1;
  var total = 0;
  var html = income.map(function(item, i) {
    total += parseFloat(item.amount) || 0;
    return '<tr>' +
      '<td>' + (start + i) + '</td>' +
      '<td>' + (item.category || '-') + '</td>' +
      '<td>Rs. ' + parseFloat(item.amount).toFixed(2) + '</td>' +
      '<td>' + (item.description || '-') + '</td>' +
      '<td>' + item.date + '</td>' +
      '<td><button class="eh-btn eh-btn--danger eh-btn--sm delete-btn" data-id="' + item.id + '"><i class="fas fa-trash-alt"></i> Delete</button></td>' +
    '</tr>';
  }).join('');
  $('#income-tbody').html(html);
  $('#total-income').text(total.toFixed(2));

  var pg = '';
  pg += '<li class="page-item' + (pagination.current_page <= 1 ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (pagination.current_page - 1) + '">Prev</a></li>';
  for (var i = 1; i <= pagination.total_pages; i++)
    pg += '<li class="page-item' + (pagination.current_page === i ? ' active' : '') + '"><a class="page-link" href="#" data-page="' + i + '">' + i + '</a></li>';
  pg += '<li class="page-item' + (pagination.current_page >= pagination.total_pages ? ' disabled' : '') + '"><a class="page-link" href="#" data-page="' + (pagination.current_page + 1) + '">Next</a></li>';
  $('#pagination').html(pg);
}

$(document).ready(function() {
  var ud = localStorage.getItem('user_data');
  if (ud) $('#user-name').text(JSON.parse(ud).name || 'User');
  loadIncome();

  $('#select-entries').on('change', function() { currentLimit = +$(this).val(); currentPage = 1; loadIncome(); });
  $(document).on('click', '.page-link', function(e) { e.preventDefault(); var p = +$(this).data('page'); if (p > 0) { currentPage = p; loadIncome(); } });

  $(document).on('click', '.delete-btn', function() {
    var id = $(this).data('id');
    if (!confirm('Delete this income record?')) return;
    $.ajax({
      url: 'api/delete-income.php', type: 'POST', data: { id: id }, dataType: 'json',
      success: function(r) { if (r.status === 'success') { alert(r.message); loadIncome(); } else alert(r.message); },
      error: function() { alert('An error occurred while deleting.'); }
    });
  });

  $('#search-input').on('keyup', function() {
    var v = $(this).val().toLowerCase();
    $('#income-tbody tr').filter(function() { $(this).toggle($(this).text().toLowerCase().includes(v)); });
  });
});
</script>
</body>
</html>
