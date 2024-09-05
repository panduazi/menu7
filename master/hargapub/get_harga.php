<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	$prov = '';
	$kota = '';
	if(isset($_GET['prov'])){
		$prov = $_GET['prov'];
	}
	if(isset($_GET['kota'])){
		$kota = $_GET['kota'];
	}

	include('../../config/koneksi.php');
	$query = "SELECT  tblPrice.*,tblkodepos_pliss.* 
				FROM tblPrice 
				LEFT JOIN tblkodepos_pliss ON tblPrice.PriceCityID=tblkodepos_pliss.REC_ID
				";
	
	if($prov!=''){
		$query .=" WHERE tblkodepos_pliss.PROVINSI='$prov' ";
	}

	if($kota!=''){
		$query .=" AND tblkodepos_pliss.KOTA='$kota'";
	}
	

	$query .= " GROUP BY tblkodepos_pliss.KECAMATAN ";
	$rs = $koneksi->query($query);
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	$query.= " ORDER BY tblkodepos_pliss.KOTA 
			   limit $offset,$rows";
	$rs = $koneksi->query($query);
	
	$items = array();
	while($row = mysqli_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);
	echo mysqli_error($koneksi);

?>