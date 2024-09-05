<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    

	include('../../config/koneksi.php');

	//hitung smua secara global
	$query=mysqli_query($koneksi,"SELECT sum(ConnoteBillAmount) AS net, 
	                            sum(ConnoteQty) as qty, 
	                            sum(ConnoteWeight) as kg,
	                            count(*) as awb
	                    FROM tblConnote_odisys 
	                    WHERE ConnoteDate between '$date1' and '$date2' 
							and ConnoteOrig=11 
							and ConnoteValid=1 
							and ConnoteBillCurrency='IDR'
	                    ");
	$r=mysqli_fetch_array($query);
	$trp=$r['net'];
	$tqty=$r['awb'];
	$tkg=$r['kg'];	
	

	$rs = $koneksi->query("SELECT count(*) FROM tblConnote  
					WHERE ConnoteDate between '$date1' and '$date2'
					and ConnoteOrig=11 and ConnoteValid=1 and ConnoteBillCurrency='IDR' GROUP BY CustomerKelola");
	$row = mysqli_fetch_row($rs);
	$result["total"] = $row[0];

	if ($date1 >= '2022-09-01') {
	$rs = $koneksi->query("SELECT CustomerKelola,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP, CustomerKelola
						FROM tblConnote_odisys left join tblCustomer on ConnoteCustNo=CustomerNo 
						WHERE ConnoteDate between '$date1' and '$date2' 
							and ConnoteOrig=11 
							and ConnoteValid=1 
							and ConnoteBillCurrency='IDR' 
						GROUP BY CustomerKelola ORDER BY NILAI DESC limit $offset,$rows");

	} else {
	$rs = mysqli_query("SELECT CustomerKelola,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP, CustomerKelola
						FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
						WHERE ConnoteDate between '$date1' and '$date2' 
							and ConnoteOrig=11 
							and ConnoteValid=1 
							and ConnoteBillCurrency='IDR' 
						GROUP BY CustomerKelola 
						ORDER BY NILAI DESC limit $offset,$rows");

	}
	$items = array();
	$tnilai=0;
	$tship=0;
	$tbrt=0;
	while($row = mysqli_fetch_object($rs)){
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
			  'CustomerKelola' => 'TOTAL',
			  'SHIP' => number_format($tqty,0),
			  'NILAI' => number_format($trp,0),
			  'BERAT' => number_format($tkg,0)
		  )
	 );
	echo json_encode($result);
?>