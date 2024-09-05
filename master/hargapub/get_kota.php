<?php
	include('../../config/koneksi.php');
	$q = '';
	if(isset($_GET['q'])){
		$q = $_GET['q'];
	}
    
	$rs = $koneksi->query("SELECT * FROM tblkodepos_pliss
                        WHERE PROVINSI='$q'
                        GROUP BY KOTA
                        ORDER BY KOTA
                        ");
	$result = array();
	while($data = mysqli_fetch_object($rs)){
		$result[] = array(
						'id' => $data->REC_ID, 
						'kota' => $data->KOTA
					);
	}
	echo json_encode($result);
?>

