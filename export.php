<?php
//include_once 'database.php';
$connect = new PDO("mysql:host=localhost;dbname=u587940520_gary", "u587940520_gray", "!@#123qweasdZXC");

$start_date_error = '';
$end_date_error = '';

if(isset($_POST["export"])){

 if(empty($_POST["start_date"])){

  $start_date_error = '<label class="text-danger">Start Date is required</label>';

 }else if(empty($_POST["end_date"])){

  $end_date_error = '<label class="text-danger">End Date is required</label>';

 }else{

  $file_name = 'HistoryData.csv';
  header("Content-Description: File Transfer");
  header("Content-Disposition: attachment; filename=$file_name");
  header("Content-Type: application/csv;");

  $file = fopen('php://output', 'w');

  $header = array("Date", "Close", "Volume","Company Code","Share Issues","Market Cap");

  fputcsv($file, $header);

  $query = "
  SELECT * FROM historydata 
  WHERE Hdate >= '".$_POST["start_date"]."' 
  AND Hdate  <= '".$_POST["end_date"]."'
  ORDER BY ID DESC
  ";
  $statement = $connect->prepare($query);
  $statement->execute();
  $result = $statement->fetchAll();
  $i=1;
  foreach($result as $row){
   $data = array();
   $data[] = $row["Hdate"];
   $data[] = $row["PriceClose"];
   $data[] = $row["Volume"];
   $data[] = $row["CompanyCode"];
   $data[] = $row["Volume"];
   $data[] = $row["CompanyCode"];
   fputcsv($file, $data);
  }
  fclose($file);
  exit;
 }
}

$query = "
SELECT * FROM historydata 
ORDER BY Hdate DESC;
";

$statement = $connect->prepare($query);
$statement->execute();
$result = $statement->fetchAll();

?>

<html>
 <head>
  <title>Export ASX Companies History</title>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
 </head>
 <body>
  <div class="container box">
   <h1 align="center">Export ASX Companies History</h1>
   <br />
   <div class="table-responsive">
    <br />
    <div class="row">
     <form method="post">
      <div class="input-daterange">
       <div class="col-md-4">
           <lable>Start Date:</lable>
        <input type="text" name="start_date" class="form-control" readonly />
        <?php echo $start_date_error; ?>
       </div>
       <div class="col-md-4">
            <lable>End Date:</lable>
        <input type="text" name="end_date" class="form-control" readonly />
        <?php echo $end_date_error; ?>
       </div>
      </div>
      <div class="col-md-2">
       <input type="submit" name="export" value="Export" class="btn btn-info" />
      </div>
     </form>
    </div>
    <br />
    <table class="table table-bordered table-striped">
     <thead>
      <tr>
       <th>Date</th>
       <th>Close</th>
       <th>Volume</th>
       <th>CompanyCode</th>
      </tr>
     </thead>
     <tbody>
      <?php
    
      foreach($result as $row){
       echo '
       <tr>
        <td>'.$row["Hdate"].'</td>
        <td>'.$row["PriceClose"].'</td>
        <td>'.$row["Volume"].'</td>
        <td>'.$row["CompanyCode"].'</td>
       </tr>
       ';
      }
      ?>
     </tbody>
    </table>
    <br />
    <br />
   </div>
  </div>
 </body>
</html>

<script>

$(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format: "yyyy-mm-dd",
  autoclose: true
 });
});

</script>

