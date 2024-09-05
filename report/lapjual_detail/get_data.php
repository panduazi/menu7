<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
	$cust = $_GET['cust'];
	
	include('../../config/koneksi.php');

	if ($date1 >= '2022-09-01') {
	$rs = mysql_query("SELECT count(*) FROM tblConnote_odisys 
					WHERE ConnoteDate between '$date1' and '$date2'
					and ConnoteOrig=11 and ConnoteValid=1 and ConnoteBillCurrency='IDR' and ConnoteCustNo='$cust'");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("SELECT * FROM tblConnote_odisys 
						left join tblCustomer on ConnoteCustNo=CustomerNo 
						LEFT JOIN tblCity ON ConnoteDest=CityId
						WHERE ConnoteDate between '$date1' and '$date2' 
							and ConnoteOrig=11 
							and ConnoteValid=1 
							and ConnoteBillCurrency='IDR' 
							and ConnoteCustNo='$cust'
							ORDER BY ConnoteDate,ConnoteDest
							limit $offset,$rows");

	} else {
	$rs = mysql_query("SELECT count(*) FROM tblConnote 
					WHERE ConnoteDate between '$date1' and '$date2'
					and ConnoteOrig=11 and ConnoteValid=1 and ConnoteBillCurrency='IDR' and ConnoteCustNo='$cust'");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("SELECT * FROM tblConnote 
						left join tblCustomer on ConnoteCustNo=CustomerNo 
						LEFT JOIN tblCity ON ConnoteDest=CityId
						WHERE ConnoteDate between '$date1' and '$date2' 
							and ConnoteOrig=11 
							and ConnoteValid=1 
							and ConnoteBillCurrency='IDR' 
							and ConnoteCustNo='$cust'
							ORDER BY ConnoteDate,ConnoteDest
							limit $offset,$rows");
	}
	$items = array();
	while($row = mysql_fetch_object($rs)){
    	$row->NILAI = number_format($row->ConnoteBillAmount,0);
        //$row->SHIP= number_format($row->SHIP,0);
        //$row->BERAT = number_format($row->BERAT,0);
        //$row->TGL = date_format($row->ConnoteDate,'d-m-Y');
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);
?>