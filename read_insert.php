<?php
include_once 'database.php';

$sql = "SELECT * FROM gdata";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

// output data of each row
while($row = $result->fetch_assoc()) {

$rowDatas=explode(",",$row["file_contents"]);  

//echo $rowDatas."<br>";

foreach($rowDatas as $rd){

    echo $rd[0]." ".$rd[1]." ".$rd[2]." ".$rd[3]."</br>";

}



}

} else { 
    echo "0 results"; 
}
$conn->close();
?>