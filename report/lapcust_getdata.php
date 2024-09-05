<?php
    include('../config/koneksi.php');
	$t1=$_POST['tgl1'];
	$t2=$_POST['tgl2'];
    $rs = mysql_query("SELECT ConnoteCustNo,CustomerName,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP, CustomerSales FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 and ConnoteBillCurrency='IDR' group by ConnoteCustNo,CustomerName");
    $result = array();
    while($row = mysql_fetch_object($rs)){
        array_push($result, $row);
    }
     
    echo json_encode($result);
?>