<?php
	include('../config/koneksi.php');
	$q = '';
	if(isset($_GET['q'])){
		$q = $_GET['q'];
	}
    
	$rs =$koneksi->query("SELECT * FROM tblCOA                        
                       	WHERE AccName LIKE '%$q%'  and AccDetail=1                      
                        ORDER BY AccNo
                        ");
	$result = array();
	while($data = mysqli_fetch_object($rs)){
		$result[] = array(						
						'no' => $data->AccNo,
						'nama' => $data->AccName
					);
	}
	echo json_encode($result);
?>

