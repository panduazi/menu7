<?php
	error_reporting(E_ALL);
	ini_set('ignore_repeated_errors', TRUE);
	ini_set('display_errors', false);
	ini_set('log_errors', true);
	ini_set('error_log', 'errors.log');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
    
	if(isset($_GET['date'])){
		$date = $_GET['date'];
	}else{
		$date = '';
	}
	if(isset($_GET['no'])){
		$voc = $_GET['no'];	
	}else{
		$voc = '';
	}

	include('../config/koneksi.php');
	$query ="SELECT tblJournal.*,tblCOA.*,
			IF(tblJournal.JournalType=0,'D','K') as Type, 
			IF(tblJournal.JournalType=0,tblJournal.JournalValue,0) as Db,
			IF(tblJournal.JournalType=1,tblJournal.JournalValue,0) as Cr
			FROM tblJournal
			LEFT JOIN tblCOA ON tblJournal.JournalAccNo=tblCOA.AccNo
			WHERE tblJournal.JOURNALSTATUS > -1 
			";
	if($voc!='') {
		$query .=" AND JournalVoucerNo='$voc'";
	}else{
		$query .=" AND tblJournal.JournalDate='$date'";
	}
	$rs = $koneksi->query($query);
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	//$query .=" LIMIT $offset,$rows";

	$rs = $koneksi->query($query);
	$items = array();
	$tdb=0;
	$tcr=0;
	while($row = mysqli_fetch_object($rs)){
    	if($row->JournalType==0){$tdb+=$row->JournalValue;}	else {$tcr+=$row->JournalValue;};
    	$row->JournalValue = number_format($row->JournalValue,1);
    	$row->Db = number_format($row->Db,1);
    	$row->Cr = number_format($row->Cr,1);
		array_push($items, $row);
	}
	$result["rows"] = $items;
	$result["footer"]= array(
        array(		
            'Db' => number_format($tdb,1),
            'Cr' => number_format($tcr,1)
        )
    );
	echo mysqli_error();
	echo json_encode($result);

?>