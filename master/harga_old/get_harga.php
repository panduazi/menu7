<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

	$ckota = $_GET["kota"];
	
	include('../../config/koneksi.php');
	
	//	if ($ckota=='') {
//		$rs = mysql_query("select count(*) from tblPrice left join tblCity on PriceCityID=CityId");
//		$row = mysql_fetch_row($rs);
//		$result["total"] = $row[0];
//		$rs = mysql_query("select * from tblPrice  
//							left join tblCity on PriceCityID=CityId 
// 							order by CityName limit $offset,$rows");
//	} else {
//		$rs = mysql_query("select count(*) from tblPrice left join tblCity on PriceCityID=CityId where CityName like '%$ckota%'");
//		$row = mysql_fetch_row($rs);
//		$result["total"] = $row[0];
//		$rs = mysql_query("select * from tblPrice  
//							left join tblCity on PriceCityID=CityId 
//							where CityName like '%$ckota%'
//							order by CityName limit $offset,$rows");
//	}
		$rs = mysql_query("select count(*) from tblPrice left join tblCity on PriceCityID=CityId");
		$row = mysql_fetch_row($rs);
		$result["total"] = $row[0];
		$rs = mysql_query("select * from tblPrice  
							left join tblCity on PriceCityID=CityId 
 							order by CityName limit $offset,$rows");

	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>