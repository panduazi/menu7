<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

	include('../config/koneksi.php');

	$temp_key = '';

	if(isset($_GET['temp_key'])){
		$temp_key = $_GET['temp_key'];
	}
	
    $rs = mysql_query("SELECT * FROM tempJur 
                        WHERE tId='$temp_key' 
                    ");
	$row = mysql_num_rows($rs);
	$result["total"] = $row;
	$rs = mysql_query("SELECT * FROM tempJur 
                            WHERE tId='$temp_key' 
							LIMIT $offset,$rows
						");
	
	$items = array();
    $t_db = 0;
    $t_cr = 0;
	while($row = mysql_fetch_object($rs)){
        $t_db += $row->tAccValueDB;
        $t_cr += $row->tAccValueCR;
		array_push($items, $row);
	}
	$result["rows"] = $items;
    $result["footer"] = array(
        array(		
            'tAccNo' => '',
            'tAcclDesc' => 'BALANCE',
            'tAccValueDB' => $t_db,
            'tAccValueCR' => $t_cr
        )
    );
    echo mysql_error();
	echo json_encode($result);

?>