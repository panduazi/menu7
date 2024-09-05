<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();
	date_default_timezone_set('Asia/Jakarta');
	$per=date('Ym');
	$bln=date('m')-1;
	
	include('../../config/koneksi.php');
	$rs = mysql_query("SELECT Customersales,sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, 
											sum(ConnoteWeight) as BERAT, 
											count(ConnoteNo) as SHIP
					FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
					WHERE date_format(ConnoteDate,'%Y%m')= '$per' 
		  			and ConnoteOrig=11 
		  			and ConnoteValid=1 
		  			and ConnoteBillCurrency='IDR' 
					GROUP BY Customersales
					ORDER BY NET DESC");
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>