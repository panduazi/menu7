<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	$kunci=$_GET['nama'];

	include('../../config/koneksi.php');
	if ($kunci!='') {
		$query ="SELECT * FROM tblCustomer WHERE CustomerCategory IN (2,6,10) AND CustomerName like '%$kunci%' ";
	} else {
		$query ="SELECT * FROM tblCustomer WHERE CustomerCategory IN (2,6,10) ";
	}
	
		
	$rs = $koneksi->query($query);
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	$query.="ORDER BY CustomerName LIMIT $offset,$rows";
	$rs = $koneksi->query($query);
	$items = array();
	while($row = mysqli_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;
	echo json_encode($result);	

?>