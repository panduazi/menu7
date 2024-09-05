<?php
	include('../../config/koneksi.php');
	$q = '';
	if(isset($_GET['q'])){
		$q = $_GET['q'];
	}
    
	$rs = mysql_query("SELECT * FROM tblCustomer                        
                       	WHERE CustomerName LIKE '%$q%'                        
                        ORDER BY CustomerName
                        ");
	$result = array();
	while($data = mysql_fetch_object($rs)){
		$result[] = array(						
						'CustomerNo' => $data->CustomerNo,
						'CustomerName' => $data->CustomerName
					);
	}
	echo json_encode($result);
?>

