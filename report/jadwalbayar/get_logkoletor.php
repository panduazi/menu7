<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $no = $_GET['noinv'];
    
	include('../../config/koneksi.php');
	
	$rs = mysql_query("select * from tblInvoiceAction	
                       WHERE ComplainInvNo='$no'");
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	echo json_encode($result);

?>