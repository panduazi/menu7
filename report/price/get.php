<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
    $kota = isset($_POST['kota']) ? mysql_real_escape_string($_POST['kota']) : '';    
	$offset = ($page-1)*$rows;
	$result = array();
    include('../../config/koneksi.php');
    $rs = mysql_query("select count(*) from tblPrice left join tblCity on PriceCityId=CityId where CityName like '$kota%'");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
    $rs = mysql_query("select * from tblPrice left join tblCity on PriceCityId=CityId where CityName like '$kota%' Order By CityName limit $offset,$rows");
	$rows = array();
	while($row = mysql_fetch_object($rs)){
		array_push($rows, $row);
	}
	$result["rows"] = $rows;
	echo json_encode($result);
?>