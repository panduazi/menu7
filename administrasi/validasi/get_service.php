<?php
	include('../../config/koneksi.php');
	$q = '';
	if(isset($_GET['q'])){
		$q = $_GET['q'];
	}
    $rs = $koneksi->query("SELECT * FROM tblService");
	$result = array();
	while($data = mysqli_fetch_object($rs)){
		$result[] = array(
						'id' => $data->ServiceId, 
						'nama' => $data->ServiceName
					);
	}
	echo json_encode($result);
?>

