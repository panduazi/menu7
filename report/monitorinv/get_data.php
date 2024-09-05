<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
	$cust = '';
	if(isset($_GET['cust'])){
		$cust = $_GET['cust'];
	}

	include('../../config/koneksi.php');
	$query = "";
	$query.="select *,date_format(CollDateStatus,'%Y-%m-%d') AS TGL from tblCollectorMaster
	left join tblInvoice on tblCollectorMaster.CollInvNo=tblInvoice.InvoiceNo	
	left join tblCollectorBayar on tblCollectorMaster.CollStatus=tblCollectorBayar.ID
	left join tblBayarPiutang on tblInvoice.InvoiceNo=tblBayarPiutang.ByrInvoiceNo
	left join tblCustomer on tblInvoice.InvoiceCustNo=tblCustomer.CustomerNo
	WHERE CollDateStatus between '$date1' AND '$date2'";


	if($cust!=''){
		$query .= " AND tblInvoice.InvoiceCustNo='$cust'";
	}
	$query .=" ORDER BY CollDateStatus ASC";
	$rs = mysql_query($query);
	$row = mysql_num_rows($rs);
	$result["total"] = $row;
	$query .=" limit $offset,$rows";
	$rs = mysql_query($query);
	$items = array();
	while($row = mysql_fetch_object($rs)){
    	$row->InvoiceSaldo_IDR = number_format($row->InvoiceSaldo_IDR,0);
		$row->ByrAmmount_IDR = number_format($row->ByrAmmount_IDR,0);
        //$row->CollDateStatus = date_format($row->InvoiceSaldo_IDR,'Y-m-d');
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>