<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    

	include('../../config/koneksi.php');
	
	$rs = $koneksi->query("SELECT count(*) FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
					WHERE ConnoteDate between '$date1' and '$date2'
					and ConnoteOrig=11 and ConnoteValid=1 and ConnoteBillCurrency='IDR' GROUP BY ConnoteCustNo");
	$row = mysqli_fetch_row($rs);
	$result["total"] = $row[0];
	if ($date1 >= '2022-09-01') {

	$rs = $koneksi->query("SELECT CustomerKelola,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP, CustomerKelola,CustomerName
						FROM tblConnote_odisys 
						LEFT JOIN tblCustomer ON ConnoteCustNo=CustomerNo 
						WHERE ConnoteDate between '$date1' and '$date2' 
							and ConnoteOrig=11 
							and ConnoteValid=1 
							and ConnoteBillCurrency='IDR' 
						GROUP BY ConnoteCustNo 
						ORDER BY NILAI DESC limit $offset,$rows");

	} else {
	$rs = mysqli_query("SELECT CustomerKelola,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP, CustomerKelola,CustomerName
						FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
						WHERE ConnoteDate between '$date1' and '$date2' 
							and ConnoteOrig=11 
							and ConnoteValid=1 
							and ConnoteBillCurrency='IDR' 
						GROUP BY ConnoteCustNo 
						ORDER BY NILAI DESC limit $offset,$rows");

	}
	$items = array();
	$tnilai=0;
	$tship=0;
	$tbrt=0;
	while($row = mysqli_fetch_object($rs)){
		$tnilai += $row->NILAI;
		$tship += $row->SHIP;
		$tbrt += $row->BERAT;
	   	$row->NILAI = number_format($row->NILAI,0);
        $row->SHIP= number_format($row->SHIP,0);
        $row->BERAT = number_format($row->BERAT,0);
        //$row->brt = date_format($row->BERAT,'Y-m-d');
		array_push($items, $row);
	}
	$result["rows"] = $items;
	//bikin footer
	$result["footer"]= array(
		array(		
			  'CustomerName' => 'TOTAL',
			  'SHIP' => number_format($tship,0),
			  'NILAI' => number_format($tnilai,0),
			  'BERAT' => number_format($tbrt,0)
		  )
	 );
	echo json_encode($result);
?>