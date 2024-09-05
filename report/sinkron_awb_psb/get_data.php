<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    

	include('../../config/koneksi.php');
	
	$rs = mysql_query("SELECT count(*) FROM tblConnote_odisys left join tblCity on ConnoteDest=CityId 
					WHERE ConnoteDate between '$date1' and '$date2'
					and ConnoteOrig=11 and ConnoteCountDeli=0");
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("SELECT * FROM tblConnote_odisys left join tblCity on ConnoteDest=CityId
						WHERE ConnoteDate between '$date1' and '$date2' and ConnoteOrig=11 
						and ConnoteCountDeli=0
						limit $offset,$rows");
	$items = array();
	$tnilai=0;
	$tship=0;
	$tbrt=0;
	while($row = mysql_fetch_object($rs)){
        $row->upload = "<button onclick='uploadawb(".$row->ConnoteNo.")' type='button'>upload</button>";
		//$tnilai += $row->NILAI;
		//$tship += $row->SHIP;
		//$tbrt += $row->BERAT;
	   	//$row->NILAI = number_format($row->NILAI,0);
        //$row->SHIP= number_format($row->SHIP,0);
        //$row->BERAT = number_format($row->BERAT,0);
        //$row->brt = date_format($row->BERAT,'Y-m-d');
		array_push($items, $row);
	}
	$result["rows"] = $items;
	//bikin footer
	//$result["footer"]= array(
	//	array(		
	//		  'CustomerKelola' => 'TOTAL',
	//		  'SHIP' => number_format($tship,0),
	//		  'NILAI' => number_format($tnilai,0),
	//		  'BERAT' => number_format($tbrt,0)
	//	  )
	// );
	echo json_encode($result);
?>