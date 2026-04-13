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
  <title>ExpenseHeist – Add Expense</title>
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

<!-- SIDEBAR -->
<div class="eh-sidebar" id="eh-sidebar">
  <div class="eh-sidebar__logo">
    <i class='bx bx-album'></i>
    <span class="eh-sidebar__logo-name">ExpenseHeist</span>
  </div>
  <ul class="eh-sidebar__links">
    <li><a href="home.php"><i class='bx bx-grid-alt'></i><span>Dashboard</span></a></li>
    <li><a href="add-expenses.php" class="active"><i class='bx bx-box'></i><span>Expenses</span></a></li>
    <li><a href="add-income.php"><i class='bx bx-box'></i><span>Income</span></a></li>
    <li><a href="manage-transaction.php"><i class='bx bx-list-ul'></i><span>Manage List</span></a></li>
    <li><a href="lending.php"><i class='bx bx-money'></i><span>Lending</span></a></li>
    <li><a href="manage-lending.php"><i class='bx bx-coin-stack'></i><span>Manage Lending</span></a></li>
    <li><a href="analytics.php"><i class='bx bx-pie-chart-alt-2'></i><span>Analytics</span></a></li>
    <li><a href="report.php"><i class="bx bx-file"></i><span>Report</span></a></li>
    <li><a href="user_profile.php"><i class='bx bx-cog'></i><span>Settings</span></a></li>
    <li class="eh-sidebar__logout"><a href="logout.php"><i class='bx bx-log-out'></i><span>Log Out</span></a></li>
  </ul>
</div>

<!-- MAIN -->
<section class="eh-main" id="eh-main">
  <nav class="eh-topnav">
    <div class="eh-topnav__left">
      <button class="eh-sidebar-toggle" id="eh-sidebarToggle"><i class='bx bx-menu' id="eh-sidebarIcon"></i></button>
      <span class="eh-topnav__title">Add Expense</span>
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
          <p class="eh-card__eyebrow">Finance</p>
          <h5 class="eh-card__title">Add Expense</h5>
        </div>
        <div>
          <button type="button" class="eh-btn eh-btn--outline" data-toggle="modal" data-target="#add-category-modal">
            <i class="fas fa-plus-circle"></i> Add Category
          </button>
        </div>
      </div>
      <div class="eh-card__body">
        <form id="expenseForm">
          <div class="eh-form-group">
            <label for="dateexpense">Date of Expense</label>
            <input class="eh-form-control" type="date" id="dateexpense" name="dateexpense" value="<?= date('Y-m-d') ?>">
          </div>
          <div class="eh-form-group">
            <label for="category">Category</label>
            <select class="eh-form-control" id="category" name="category" required>
              <option value="" selected disabled>Choose Category</option>
            </select>
          </div>
          <div class="eh-form-group">
            <label for="costitem">Cost of Item</label>
            <input class="eh-form-control" type="number" id="costitem" name="costitem" required>
          </div>
          <div class="eh-form-group">
            <label for="category-description">Description</label>
            <textarea class="eh-form-control" id="category-description" name="category-description" required></textarea>
          </div>
          <div class="eh-form-group">
            <button type="submit" class="eh-btn eh-btn--primary">Add Expense</button>
          </div>
        </form>
        <div id="success-message" class="eh-alert eh-alert--success" style="display:none;">Expense added successfully.</div>
      </div>
    </div>
  </div>
</section>

<!-- Add Category Modal -->
<div class="modal fade eh-modal" id="add-category-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="add-category-form">
        <div class="modal-header">
          <h5 class="modal-title">Add Category</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="eh-form-group">
            <label for="category-name">Category Name</label>
            <input type="text" class="eh-form-control" id="category-name" name="category-name" required>
            <input type="hidden" name="mode" value="expense">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="eh-btn eh-btn--outline" data-dismiss="modal">Cancel</button>
          <button type="submit" class="eh-btn eh-btn--primary">Add Category</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="eh-layout.js"></script>
<script>
$(document).ready(function() {
  loadCategories();

  function loadCategories() {
    $.ajax({
      url: 'api/get-categories.php', type: 'GET', data: { mode: 'expense' }, dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          var opts = '<option value="" selected disabled>Choose Category</option>';
          $.each(response.data, function(i, c) {
            opts += '<option value="' + c.categoryid + '">' + c.categoryname + '</option>';
          });
          $('#category').html(opts);
        }
      }
    });
  }

  $('#expenseForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'api/add-expense.php', type: 'POST', data: $(this).serialize(), dataType: 'json',
      success: function(r) {
        if (r.status === 'success') { alert(r.message); window.location.href = 'manage-transaction.php'; }
        else alert(r.message);
      },
      error: function() { alert('An error occurred while processing your request.'); }
    });
  });

  $('#add-category-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'api/add-category.php', type: 'POST', data: $(this).serialize(), dataType: 'json',
      success: function(r) {
        if (r.status === 'success') {
          alert(r.message); $('#add-category-modal').modal('hide');
          $('#add-category-form')[0].reset(); loadCategories();
        } else alert(r.message);
      },
      error: function() { alert('An error occurred while adding the category.'); }
    });
  });
});
</script>
</body>
</html>
