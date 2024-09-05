<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $mode = $_GET['mode'];
    
	include('../../config/koneksi.php');
	$rs = mysql_query("select count(*) from tblInvoice WHERE InvoiceSaldo_IDR > 0");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
    $rs = mysql_query("select *,InvoiceAmmount_IDR+InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR+InvoiceStamp_IDR-InvoiceDisc_IDR as NILAI,
			  		date_format(InvoiceStatusDate0,'%Y-%m-%d') as ldate0, date_format(InvoiceStatusDate,'%Y-%m-%d') as ldate1
			  		 from tblInvoice left join tblCustomer on InvoiceCustNo=CustomerNo
   					 WHERE InvoiceSaldo_IDR > 0");
    $items = array();
	while($row = mysql_fetch_object($rs)){
    	$row->InvoiceSaldo_IDR = number_format($row->InvoiceSaldo_IDR,0);
    	$row->NILAI = number_format($row->NILAI,0);
		array_push($items, $row);
	}

	$result["rows"] = $items;
	echo json_encode($result);
?>