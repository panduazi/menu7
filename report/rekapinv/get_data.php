<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $per1 = $_GET['per1'];
    $per2 = $_GET['per2'];
	//$status = $_GET['status'];
    

	include('../../config/koneksi.php');

	if ($per1 < '2022/01') {
	$rs = $koneksi->query("SELECT count(*) 
						from tblInvoice2021 
						left join tblCustomer ON tblInvoice2021.InvoiceCustNo=tblCustomer.CustomerNo
						left join tblInvoiceStatus ON tblInvoice2021.InvoiceStatus=tblInvoiceStatus.ID
						left join tblCollectorMaster on InvoiceNo=CollInvNo
						WHERE InvoicePeriode between '$per1' and '$per2'"); 
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	$rs = $koneksi->query("SELECT InvoiceNo,
						InvoiceDate,
						InvoiceName,
						InvoicePeriode,
						InvoiceAmmount_IDR,
						InvoiceSaldo_IDR,
						InvoiceStatusDate,
						InvoiceStatusKet,
						InvoiceAmmount_IDR+InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR+InvoiceTax_IDR+InvoiceStamp_IDR+InvoiceDisc_IDR as NILAI,
						CustomerSales,CollKurir,CollDateStatus,JBAYAR
						from tblInvoice2021  
						left join tblCustomer ON tblInvoice2021.InvoiceCustNo=tblCustomer.CustomerNo
						left join tblInvoiceStatus ON tblInvoice2021.InvoiceStatus=tblInvoiceStatus.ID
						left join tblCollectorMaster on InvoiceNo=CollInvNo
						WHERE InvoicePeriode between '$per1'  and '$per2'"); 

	}
	else {
	$rs = $koneksi->query("SELECT count(*) 
						from tblInvoice  
						left join tblCustomer ON tblInvoice.InvoiceCustNo=tblCustomer.CustomerNo
						left join tblInvoiceStatus ON tblInvoice.InvoiceStatus=tblInvoiceStatus.ID
						left join tblCollectorMaster on InvoiceNo=CollInvNo
						WHERE InvoicePeriode between '$per1' and '$per2'"); 
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;

	$rs = $koneksi->query("SELECT InvoiceNo,
						InvoiceDate,
						InvoiceName,
						InvoicePeriode,
						InvoiceAmmount_IDR,
						InvoiceSaldo_IDR,
						InvoiceStatusDate,
						InvoiceStatusKet,
						InvoiceAmmount_IDR+InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR+InvoiceTax_IDR+InvoiceStamp_IDR+InvoiceDisc_IDR as NILAI,
						CustomerSales,CollKurir,CollDateStatus,JBAYAR
						from tblInvoice  
						left join tblCustomer ON tblInvoice.InvoiceCustNo=tblCustomer.CustomerNo
						left join tblInvoiceStatus ON tblInvoice.InvoiceStatus=tblInvoiceStatus.ID
						left join tblCollectorMaster on InvoiceNo=CollInvNo
						WHERE InvoicePeriode between '$per1'  and '$per2'"); 
	}
	$items = array();
	while($row = mysqli_fetch_object($rs)){
    	$row->InvoiceSaldo_IDR = number_format($row->InvoiceSaldo_IDR,0);
        $row->NILAI= number_format($row->NILAI,0);
        //$row->CollDateStatus = date_format($row->CollDateStatus,'Y-m-d');
		//$row->InvoiceStatusDate = date_format($row->InvoiceStatusDate,'Y-m-d');
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>