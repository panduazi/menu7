<?php
$time = date('Y-m-d H:i:s');
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();

include('../config/koneksi.php');
$count_data = $koneksi->query("SELECT * FROM tblCOA WHERE AccDetail=1");
$row = mysqli_fetch_row($count_data);
$result["total"] = $row[0];
$get_data = $koneksi->query("SELECT * FROM tblCOA WHERE AccDetail=1 ORDER BY AccNo LIMIT $offset,$rows");
$items = array();
while($row = mysqli_fetch_object($get_data)){
    array_push($items, $row);
}
$result["rows"] = $items;
echo json_encode($result);

?>