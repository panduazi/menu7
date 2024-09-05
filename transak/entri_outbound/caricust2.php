<?php
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

if(isset($_GET['cust'])){
	$cust_name = $_GET['cust'];
}else{
	$cust_name = '';
}

include('../../config/koneksi.php');

$count_data = mysql_query("SELECT COUNT(*) FROM tblCustomer WHERE CustomerName LIKE '%$cust_name%' ");

$row = mysql_fetch_row($count_data);

$result["total"] = $row[0];

$get_data = mysql_query("SELECT * FROM tblCustomer WHERE CustomerName LIKE '%$cust_name%'  ORDER BY CustomerName limit $offset,$rows");



$items = array();
while($row = mysql_fetch_object($get_data)){
    array_push($items, $row);
}
$result["rows"] = $items;

echo json_encode($result);

?>