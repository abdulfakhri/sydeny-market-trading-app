<!DOCTYPE html>
<html>
<head>
<title>Table with database</title>
<style>
table {
border-collapse: collapse;
width: 100%;
color: #588c7e;
font-family: monospace;
font-size: 25px;
text-align: left;
}
th {
background-color: #588c7e;
color: white;
}
tr:nth-child(even) {background-color: #f2f2f2}
</style>
</head>
<body>
<table>
<tr>
<th>No</th>
<th>Date</th>
<th>Close</th>
<th>Volume</th>
<th>CompanyCode</th>
<th>Share Issues</th>
<th>Market Capt</th>
</tr>
<?php
include_once 'database.php';

$sql = "SELECT * FROM gdata";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
// output data of each row
$cr=1;

while($row = $result->fetch_assoc()) {

$rowDatas=explode("\n",$row["file_contents"]);  

$cn=count($rowDatas);

for($i=0;$i<$cn;$i++) {
//echo $rowDatas[$i]."<br/>";
$sql = "INSERT INTO companydata(file_contents) VALUES('$rowDatas[$i]')";
if(mysqli_query($conn, $sql)) {
  echo "New record created successfully";
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

}


}

} else { 
    echo "0 results"; 
}
$conn->close();
?>
</table>
</body>
</html>