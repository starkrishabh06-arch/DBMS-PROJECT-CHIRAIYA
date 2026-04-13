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
  <title>ExpenseHeist – Manage Transactions</title>
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
    <li><a href="manage-transaction.php" class="active"><i class='bx bx-list-ul'></i><span>Manage List</span></a></li>
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
      <span class="eh-topnav__title">Manage Transactions</span>
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
    <div class="eh-card">
      <div class="eh-card__header">
        <div class="eh-card__header-left">
          <p class="eh-card__eyebrow">Records</p>
          <h5 class="eh-card__title">Manage Transactions</h5>
        </div>
        <div class="eh-toolbar">
          <a href="api/export-csv.php?type=all" class="eh-btn eh-btn--success eh-btn--sm"><i class="fas fa-download"></i> Export CSV</a>
          <button type="button" class="eh-btn eh-btn--info eh-btn--sm" data-toggle="modal" data-target="#import-csv-modal"><i class="fas fa-upload"></i> Import CSV</button>
          <label style="font-family:var(--eh-font-heading);font-size:11px;letter-spacing:1px;color:var(--eh-text-dim);margin:0;">
            Show
            <select class="eh-select-sm mx-1" id="select-entries">
              <option value="10">10</option><option value="25">25</option>
              <option value="50">50</option><option value="100">100</option>
            </select>
            entries
          </label>
          <select class="eh-select-sm" id="type-filter">
            <option value="all">All</option>
            <option value="expense">Expenses</option>
            <option value="income">Income</option>
          </select>
        </div>
      </div>
      <div class="eh-card__body" style="padding:0;">
        <div style="overflow-x:auto;">
          <table class="eh-table">
            <thead>
              <tr>
                <th>#</th><th>Type</th><th>Category</th>
                <th>Amount</th><th>Description</th><th>Date</th><th>Action</th>
              </tr>
            </thead>
            <tbody id="transactions-tbody">
              <tr><td colspan="7" style="text-align:center;padding:40px;color:var(--eh-text-dim);">
                <i class="fas fa-spinner fa-spin"></i> Loading…
              </td></tr>
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

<!-- Import CSV Modal -->
<div class="modal fade eh-modal" id="import-csv-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="import-csv-form" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Import CSV</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="eh-alert eh-alert--info"><strong>CSV Format:</strong> Date, Particulars, Expense, Income, Category, Is_Lending</div>
          <div class="eh-form-group" style="margin-top:14px;">
            <label for="csv-file">Select CSV File</label>
            <input type="file" class="eh-form-control" id="csv-file" name="csv-file" accept=".csv" required
              style="padding:6px 10px;cursor:pointer;">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="eh-btn eh-btn--outline" data-dismiss="modal">Cancel</button>
          <button type="submit" class="eh-btn eh-btn--primary">Import</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="eh-layout.js"></script>
<script>
var currentPage = 1, currentLimit = 10, currentType = 'all';

function checkAuth() {
  var hasToken = localStorage.getItem('access_token');
  var hasSession = <?= $sessionValid ? 'true' : 'false' ?>;
  if (!hasToken && !hasSession) { window.location.href = 'index.php'; return false; }
  return true;
}

function loadTransactions() {
  if (!checkAuth()) return;
  $.ajax({
    url: 'api/transactions.php', type: 'GET',
    data: { page: currentPage, limit: currentLimit, type: currentType },
    dataType: 'json',
    success: function(r) {
      if (r.status === 'success') renderTransactions(r.data.transactions, r.data.pagination);
      else $('#transactions-tbody').html('<tr><td colspan="7" style="text-align:center;color:#e05260;">' + r.message + '</td></tr>');
    },
    error: function(xhr) {
      if (xhr.status === 401) { localStorage.removeItem('access_token'); window.location.href = 'index.php'; }
      else $('#transactions-tbody').html('<tr><td colspan="7" style="text-align:center;color:#e05260;">Error loading transactions</td></tr>');
    }
  });
}

function renderTransactions(transactions, pagination) {
  if (!transactions.length) {
    $('#transactions-tbody').html('<tr><td colspan="7" style="text-align:center;color:var(--eh-text-dim);padding:30px;">No transactions found</td></tr>');
    $('#pagination').html(''); return;
  }
  var start = (pagination.current_page - 1) * pagination.limit + 1;
  var html = transactions.map(function(item, i) {
    var badgeCls = item.type === 'Income' ? 'eh-badge--green' : 'eh-badge--red';
    return '<tr>' +
      '<td>' + (start + i) + '</td>' +
      '<td><span class="eh-badge ' + badgeCls + '">' + item.type + '</span></td>' +
      '<td>' + (item.category || '-') + '</td>' +
      '<td>' + item.amount + '</td>' +
      '<td>' + (item.description || '-') + '</td>' +
      '<td>' + item.date + '</td>' +
      '<td><button class="eh-btn eh-btn--danger eh-btn--sm delete-btn" data-id="' + item.id + '" data-type="' + item.type + '"><i class="fas fa-trash-alt"></i> Delete</button></td>' +
    '</tr>';
  }).join('');
  $('#transactions-tbody').html(html);

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
  loadTransactions();

  $('#select-entries').on('change', function() { currentLimit = +$(this).val(); currentPage = 1; loadTransactions(); });
  $('#type-filter').on('change', function() { currentType = $(this).val(); currentPage = 1; loadTransactions(); });

  $(document).on('click', '.page-link', function(e) {
    e.preventDefault();
    var p = +$(this).data('page');
    if (p > 0) { currentPage = p; loadTransactions(); }
  });

  $(document).on('click', '.delete-btn', function() {
    var id = $(this).data('id'), type = $(this).data('type');
    if (!confirm('Delete this ' + type + '?')) return;
    $.ajax({
      url: 'api/delete-transaction.php', type: 'POST', data: { id: id, type: type }, dataType: 'json',
      success: function(r) { if (r.status === 'success') { alert(r.message); loadTransactions(); } else alert(r.message); },
      error: function() { alert('An error occurred while deleting.'); }
    });
  });

  $('#search-input').on('keyup', function() {
    var v = $(this).val().toLowerCase();
    $('#transactions-tbody tr').filter(function() { $(this).toggle($(this).text().toLowerCase().includes(v)); });
  });

  $('#import-csv-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'api/import-csv.php', type: 'POST',
      data: new FormData(this), processData: false, contentType: false, dataType: 'json',
      success: function(r) {
        if (r.status === 'success') { alert(r.message); $('#import-csv-modal').modal('hide'); loadTransactions(); }
        else alert(r.message);
      },
      error: function() { alert('An error occurred while importing the CSV file.'); }
    });
  });
});
</script>
</body>
</html>
