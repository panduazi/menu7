<?php
	include('../../config/koneksi.php');
	$q = '';
	if(isset($_GET['q'])){
		$q = $_GET['q'];
	}
    
	$rs = $koneksi->query("SELECT * FROM tblkodepos_pliss                        
                        WHERE KOTA='$q'
                        GROUP BY KECAMATAN
                        ORDER BY KECAMATAN
                        ");
	$result = array();
	while($data = mysqli_fetch_object($rs)){
		$result[] = array(
						'Kode' => $data->REC_ID, 
						'Tujuan' => $data->KECAMATAN,
						'post_code' => $data->POST_CODE
					);
	}
	echo json_encode($result);
?>

