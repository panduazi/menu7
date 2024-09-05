<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$start_date = $_GET['start_date'];
	
	$offset = ($page-1)*$rows;
	
	$result = array();
	
	include('../../config/koneksi.php');
	
	$where = "POrderDate like '$start_date%'";
	$rs = mysql_query("select count(*) from tblPickupOrder where " . $where);
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	
	$rs = mysql_query("SELECT POrderDate,POrderCustName,POrderCustAddr1,POrderArea,POrderKurir,POrderCSO FROM tblPickupOrder WHERE ". $where . " limit $offset,$rows");
	
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	
	echo json_encode($result);
?>

