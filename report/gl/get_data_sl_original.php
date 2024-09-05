<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    $acc = $_GET['acc'];
    $kuci = $_GET['kunci'];
    

	include('../../config/koneksi.php');
	
	$rs = mysql_query("SELECT *,
                    IF(tblJournal.JournalType=0,'D','K') as Type, 
                    IF(tblJournal.JournalType=0,tblJournal.JournalValue,0) as Db,
                    IF(tblJournal.JournalType=1,tblJournal.JournalValue,0) as Cr
                    FROM tblJournal
                    LEFT JOIN tblCOA ON tblJournal.JournalAccNo=tblCOA.AccNo
                    WHERE tblJournal.JOURNALSTATUS > -1
					AND JournalDate between '$date1' AND '$date2' 
                    AND JournalAccNo='$acc' ORDER BY JournalDate ASC");
	$row = mysql_num_rows($rs);
	$result["total"] = $row;
	$rs = mysql_query("SELECT *,
                    IF(tblJournal.JournalType=0,'D','K') as Type, 
                    IF(tblJournal.JournalType=0,tblJournal.JournalValue,0) as Db,
                    IF(tblJournal.JournalType=1,tblJournal.JournalValue,0) as Cr
                    FROM tblJournal
                    LEFT JOIN tblCOA ON tblJournal.JournalAccNo=tblCOA.AccNo
                    WHERE tblJournal.JOURNALSTATUS > -1
                    AND JournalDate between '$date1' AND '$date2' 
                    AND JournalAccNo='$acc' ORDER BY JournalDate ASC limit $offset,$rows");
	$items = array();
	while($row = mysql_fetch_object($rs)){
    	$row->Db = number_format($row->Db,0);
        $row->Cr = number_format($row->Cr,0);
        //$row->CollDateStatus = date_format($row->InvoiceSaldo_IDR,'Y-m-d');
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>