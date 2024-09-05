<?php
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();
include('../config/koneksi.php');
$kode = $_GET['kode'];

$time = date('Y-m-d H:i:s');
$count_data = $koneksi->query("SELECT * FROM tblBayarPiutang WHERE ByrInvoiceNo='$kode' ");
$row = mysqli_fetch_row($count_data);
$result["total"] = $row[0];
$get_data = $koneksi->query("SELECT * FROM tblBayarPiutang WHERE ByrInvoiceNo='$kode' 
								LIMIT $offset,$rows");
$items = array();
while($row = mysqli_fetch_object($get_data)){
    //$row->OTH = number_format($row->InvoicePack_IDR+$row->InvoiceIns_IDR+$row->InvoiceOther_IDR);
	//$row->NET = number_format($row->InvoiceAmmount_IDR-$row->InvoiceDisc_IDR);
    array_push($items, $row);
}
$result["rows"] = $items;
echo json_encode($result);
?>