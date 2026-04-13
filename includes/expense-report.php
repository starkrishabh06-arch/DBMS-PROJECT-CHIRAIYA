<?php
session_start();
error_reporting(0);
include('database.php');
if (strlen($_SESSION['detsuid']==0)) {
  header('location:logout.php');
} else {
$active_page = 'report';
$page_title  = 'Expense Report';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ExpenseHeist – Expense Report</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php include('_sidebar.php'); ?>

<script>
$(document).ready(function(){
  var originalTableHtml=$('table tbody').html();
  $('#search-input').on('keyup',function(){
    var value=$(this).val().toLowerCase();
    var found=false;
    if(value){
      $('table tbody tr').filter(function(){
        var matches=$(this).text().toLowerCase().indexOf(value)>-1;
        $(this).toggle(matches);
        if(matches) found=true;
      });
    } else { $('table tbody').html(originalTableHtml); found=true; }
    if(!found) $('table tbody').html('<tr><td colspan="7" style="text-align:center;color:var(--text-mid);padding:20px;">No intel found</td></tr>');
  });
});
</script>

<script>
function printReport(){
  $('#filter-form').off('submit');
  var printableContent=$('#printable').clone();
  printableContent.find('.url').remove();
  var currentDate=new Date().toISOString().slice(0,10);
  var nw=window.open('','_blank','width=900,height=600');
  nw.document.write('<html><head><title>Expense Report - '+currentDate+'</title></head><body>');
  nw.document.write('<style>body{font-family:Arial,sans-serif;color:#111;} table{border-collapse:collapse;width:100%;} td,th{border:1px solid #333;padding:6px 10px;} thead th{background:#8f0f0f;color:#fff;} h5{color:#8f0f0f;}</style>');
  nw.document.write(printableContent.html());
  nw.document.write('</body></html>');
  nw.document.close(); nw.focus();
  setTimeout(function(){nw.print();setTimeout(function(){nw.close();},500);},500);
}
</script>

<?php
session_start();
$fdate = $_GET['startDate'];
$tdate = $_GET['endDate'];
$rtype = $_GET['reportType'];
?>

<div class="home-content">
  <div class="overview-boxes">
    <div class="col-md-12">
      <br>
      <div class="card">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-md-6">
              <h4 class="card-title"><i class="bx bx-trending-down" style="color:var(--red);margin-right:8px;"></i>Expense Report</h4>
            </div>
            <div class="col-md-6 text-right">
              <button class="btn btn-primary" onclick="printReport()">
                <i class="bx bx-printer"></i> Print Report
              </button>
            </div>
          </div>
        </div>
        <div class="card-body" id="printable">
          <div class="report-heading">
            <span class="report-label">Datewise <?= ucfirst($rtype) ?> Report</span>
            <span class="report-range">
              <i class="bx bx-calendar"></i>
              <?= $fdate ?> &nbsp;<i class="bx bx-right-arrow-alt"></i>&nbsp; <?= $tdate ?>
            </span>
          </div>
          <hr style="border-color:var(--border-red);margin:16px 0;">
          <?php
          $userid = $_SESSION['detsuid'];
          $ret = mysqli_query($db, "SELECT ExpenseDate,category,Description,NoteDate,SUM(ExpenseCost) as totaldaily FROM `tblexpense` where (ExpenseDate BETWEEN '$fdate' and '$tdate') && (UserId='$userid') group by ExpenseDate, category");
          if (mysqli_num_rows($ret) > 0) { ?>
          <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Date</th>
                <th>Category</th>
                <th>Description</th>
                <th>Registered Date</th>
                <th><?= ucfirst($rtype) ?> Amount</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $cnt=1; $totalsexp=0;
              while ($row=mysqli_fetch_array($ret)) { ?>
              <tr>
                <td><?= $cnt ?></td>
                <td><?= $row['ExpenseDate'] ?></td>
                <td><?= $row['category'] ?></td>
                <td><?= $row['Description'] ?></td>
                <td><?= $row['NoteDate'] ?></td>
                <td><?= $ttlsl=$row['totaldaily'] ?></td>
              </tr>
              <?php $totalsexp+=$ttlsl; $cnt++; } ?>
              <tr>
                <th colspan="5" style="text-align:center;letter-spacing:2px;">GRAND TOTAL</th>
                <td><b><?= number_format($totalsexp, 2) ?></b></td>
              </tr>
            </tbody>
          </table>
          </div>
          <?php } else { echo "<p class='no-data'><i class='bx bx-info-circle'></i> No intel found for this date range.</p>"; } ?>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
.report-heading{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
.report-label{font-family:var(--font-display);font-size:20px;letter-spacing:3px;color:var(--gold);}
.report-range{font-family:var(--font-heading);font-size:13px;letter-spacing:1px;color:var(--text-mid);display:flex;align-items:center;gap:6px;}
.report-range i{color:var(--red);}
.no-data{text-align:center;font-family:var(--font-heading);font-size:14px;letter-spacing:1px;color:var(--text-mid);padding:40px 0;display:flex;align-items:center;justify-content:center;gap:8px;}
.no-data i{color:var(--red);font-size:18px;}
</style>

</section>
<?php } ?>
