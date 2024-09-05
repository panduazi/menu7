<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

	include('../../config/koneksi.php');
	$q = '';
	if(isset($_GET['q'])){
			$q = $_GET['q'];
	}
	//$rs = $koneksi->query("SELECT count(*) FROM tblCustomer WHERE CustomerCategory in (2,6,10)");
	//$rows=mysqli_num_rows($rs);
	//$result["total"] = $rows;
	$rs = $koneksi->query("SELECT CustomerNo,CustomerName,CustomerAddr1,CustomerTelp 
								FROM tblCustomer 
								WHERE CustomerCategory in (2,6,10) AND CustomerName like '%$q%'
								ORDER BY CustomerName
								");
		
	$result = array();
	while($row = mysqli_fetch_object($rs)){
			array_push($result, $row);
		}
	echo json_encode($result);
?>

