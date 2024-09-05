<?php
	include('config/koneksi.php');
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$tgl1 = isset($_POST['tgl1']);
	$tgl2 = isset($_POST['tgl2']);
	//$tgl1 = isset($_POST['tgl1']) ? mysql_real_escape_string($_POST['tgl1']) : '';
	//$tgl2 = isset($_POST['tgl2']) ? mysql_real_escape_string($_POST['tgl2']) : '';
	
	$offset = ($page-1)*$rows;
	
	$result = array();
	
	$where = "date_format(ManifestDate,'%m/%d/%Y') between  '$tgl1' and '$tgl2'";
	//$rs = mysql_query("select count(*) from tblAirLineSMU where " . $where);
	$rs = mysql_query("select count(*) from tblAirLineSMU");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	
	//$rs = mysql_query("select * from tblAirLineSMU where " . $where . " limit $offset,$rows");
	$rs = mysql_query("select * from tblAirLineSMU");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	
	echo json_encode($result);
?>