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
    
    /*
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
	*/

	include('../config/koneksi.php');
	$query = '';
	$query .="SELECT tblJournal.*,tblCOA.*,
			IF(tblJournal.JournalType=0,'D','K') as Type, 
			IF(tblJournal.JournalType=0,tblJournal.JournalValue,0) as Db,
			IF(tblJournal.JournalType=1,tblJournal.JournalValue,0) as Cr
			FROM tblJournal
			LEFT JOIN tblCOA ON tblJournal.JournalAccNo=tblCOA.AccNo
			WHERE tblJournal.JOURNALSTATUS > -1 AND tblJournal.JournalDate='2024-06-12'
			";
	/*
	if($voc!='') {
		$query .=" AND JournalVoucerNo='$voc'";
	}else{
		$query .=" AND tblJournal.JournalDate='$date'";
	}
	*/
	$rs = mysql_query($query);
	$row = mysql_num_rows($rs);
	$result["total"] = $row;
	$query .=" LIMIT $offset,$rows";
	$rs = mysql_query($query);
	$items = array();
	while($row = mysql_fetch_object($rs)){
    	$row->JournalValue = number_format($row->JournalValue,1);
    	$row->Db = number_format($row->Db,1);
    	$row->Cr = number_format($row->Cr,1);
		array_push($items, $row);
	}
	$result["rows"] = $items;
	echo mysql_error();
	echo json_encode($result);

?>