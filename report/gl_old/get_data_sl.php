<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    $acc = $_GET['acc'];
    

	include('../../config/koneksi.php');
	//hitung saldo awal di tbalaccount
    $cACC='';
    $qawal = mysql_query("SELECT * FOM tblCOA WHERE AccNo='$acc'");
    $qhsl = mysql_fetch_array($qawal);
    if ($qhsl['ACCTYPE']=='1') {
        $cACC='CR';}
    else {
        $cACC='DB';
    }
    $nDEBET=$qhsl['AccDEBET'];
    $nCREDIT=$qhsl['AccCREDIT'];

    //hitung saldo berjalan sebelum tgl diminta
    $qlalu = mysql_query("SELECT *,
                        IF(JournalType=0,JournalValue,0) AS lDb,
                        IF(JournalType=1,JournalValue,0) AS lCr 
                        FROM tblJournal
                        WHERE between '$date1' AND '$date2' 
                        AND AND JournalAccNo='$acc'");
    $nsaldo=0;
    $tdebetl=0;
    $tcreditl=0;
    while($qhsl1=mysql_fetch_array($qlalu)){
        if ($qhsl1=0) {
            $tdebetl=$tdebetl+qhsl1['JournalValue']} 
        else {
            $tcreditl=$tcreditl+qhsl1['JournalValue']
        }
        $nsaldo=$nsaldo+$qhsl1['DEBET']-$qhsl1['CREDIT'];
    }

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