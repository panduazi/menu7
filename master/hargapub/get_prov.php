<?php
	include('../../config/koneksi.php');
	$q = '';
	if(isset($_GET['q'])){
		$q = $_GET['q'];
	}
    
	$rs = $koneksi->query("SELECT * FROM tblkodepos_pliss WHERE PROVINSI LIKE '%$q%'
                        GROUP BY PROVINSI
                        ORDER BY PROVINSI
                        ");
	$result = array();
	while($data = mysqli_fetch_object($rs)){
		$result[] = array(
						'id' => $data->REC_ID, 
						'prov' => $data->PROVINSI
					);
	}
	echo json_encode($result);
?>

