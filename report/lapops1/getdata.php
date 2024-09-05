<?php
$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];

include('../../config/koneksi.php');
$rs = mysql_query(“SELECT count(*) FROM tblconnote WHERE ConnoteDate between '$start_date' and '$end_date'");
$row = mysql_fetch_row($rs);
$result[“total”] = $row[0];

$rs = mysql_query(“SELECT * FROM tblConnote WHERE ConnoteDate between ‘$start_date’ and ‘$end_date'”);

$items = array();
while($row = mysql_fetch_object($rs)){
array_push($items, $row);
}
$result[“rows”] = $items;

$rs = mysql_query(“SELECT SUM(Jumlah) AS value_sum FROM penjualan WHERE Tanggal between ‘$start_date’ and ‘$end_date'”);
$rw = mysql_fetch_assoc($rs);
$sum = $rw[‘value_sum’];

$result[“footer”]=array(array(“Nama” => “Total”,’Jumlah’ => $sum));

echo json_encode($result);
?>