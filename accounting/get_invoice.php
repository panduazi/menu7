<?php
$time = date('Y-m-d H:i:s');
$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$offset = ($page-1)*$rows;
$result = array();
if(isset($_GET['kode'])){
	$kode = $_GET['kode'];
}else{
	$kode = '';
}

include('../config/koneksi.php');
$count_data = $koneksi->query("SELECT * FROM tblInvoice WHERE InvoiceSaldo_IDR > 0 
								AND InvoiceNo NOT like 'CL%' 
								AND InvoiceName LIKE '%$kode%' 
								");
$row = mysqli_fetch_row($count_data);
$result["total"] = $row[0];
$get_data = $koneksi->query("SELECT * 
								FROM tblInvoice 
								WHERE InvoiceSaldo_IDR > 0 
								AND InvoiceNo NOT LIKE 'CL%' 
								AND InvoiceName LIKE '%$kode%' 
								ORDER By InvoiceDate DESC 
								LIMIT $offset,$rows
								");
$items = array();
while($row = mysqli_fetch_object($get_data)){
    $row->OTH = number_format($row->InvoicePack_IDR+$row->InvoiceIns_IDR+$row->InvoiceOther_IDR);
	$row->NET = number_format($row->InvoiceAmmount_IDR-$row->InvoiceDisc_IDR);
    array_push($items, $row);
}
$result["rows"] = $items;
echo json_encode($result);

?>