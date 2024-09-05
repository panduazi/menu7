<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    

	include('../../config/koneksi.php');
	
	$rs = mysql_query("select count(*) from tblCollectorMaster 
						LEFT JOIN tblInvoice ON tblCollectorMaster.CollInvNo=tblInvoice.InvoiceNo
						WHERE CollDateStatus between '$date1' AND '$date2' AND InvoiceSaldo_IDR >0
    				");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("select *,date_format(CollDateStatus,'%Y-%m-%d') AS TGL,
						date_format(InvoiceStatusDate0,'%Y-%m-%d') AS ldate,
						sum(tblInvoice.InvoiceSaldo_IDR) as totsaldo
						from tblCollectorMaster	
                       LEFT JOIN tblInvoice ON tblCollectorMaster.CollInvNo=tblInvoice.InvoiceNo
                       LEFT JOIN tblCollectorBayar ON tblCollectorMaster.CollStatus=tblCollectorBayar.ID
                       WHERE CollDateStatus between '$date1' AND '$date2' 
					   AND InvoiceSaldo_IDR >0  ORDER BY CollDateStatus ASC,CollKurir limit $offset,$rows");
	$items = array();
	while($row = mysql_fetch_object($rs)){
		$tot+= $row->totsaldo;
    	$row->InvoiceSaldo_IDR = number_format($row->InvoiceSaldo_IDR,0);
        $row->ByrAmmount_IDR= number_format($row->ByrAmmount_IDR,0);
		$row->log = "<button onclick='loginv(".$row->CollInvNo.")' type='button'>Riwayat</button>";		
        //$row->CollDateStatus = date_format($row->InvoiceSaldo_IDR,'Y-m-d');
		array_push($items, $row);
	}
	$result["rows"] = $items;
	$result["footer"]= array(
        array(		
            'InvoiceName' => 'TOTAL',
            'totsaldo' => $tot
        )
    );
	echo json_encode($result);


?>