<?php
include('../../config/koneksi.php');
$rs = mysql_query("SELECT CustomerNo,CustomerName FROM tblCustomer WHERE CustomerCategory=2 ORDER BY CustomerName");
$result = array();
while($row = mysql_fetch_object($rs)){
array_push($result, $row);
}
echo json_encode($result);
?>

