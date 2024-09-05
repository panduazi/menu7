<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['tgl1'];
    $date2 = $_GET['tgl2'];
    

	include('../../config/koneksi.php');
	
	$rs = $koneksi->query("select * from tblBayarPiutang	
					LEFT JOIN tblInvoice ON tblBayarPiutang.ByrInvoiceNo=tblInvoice.InvoiceNo
					WHERE ByrDate between '$date1' AND '$date2' ");
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	$rs = $koneksi->query("select * from tblBayarPiutang	
                       LEFT JOIN tblInvoice ON tblBayarPiutang.ByrInvoiceNo=tblInvoice.InvoiceNo
                       WHERE ByrDate between '$date1' AND '$date2'");
                       //WHERE ByrDate between '$date1' AND '$date2' limit $offset,$rows");
	$items = array();
	$tot=0;
	while($row = mysqli_fetch_object($rs)){
		$tot += $row->ByrAmmount_IDR;
    	$row->InvoiceSaldo_IDR = number_format($row->InvoiceSaldo_IDR,0);
        $row->ByrAmmount_IDR= number_format($row->ByrAmmount_IDR,0);
		$row->InvoiceAmmount_IDR= number_format($row->InvoiceAmmount_IDR,0);
		array_push($items, $row);
	}
	$result["rows"] = $items;
	//bikin footer
	$result["footer"]= array(
      array(		
            'ByrDate' => 'TOTAL',
            'ByrAmmount_IDR' => number_format($tot,0)
        )
    );
	echo json_encode($result);

?>