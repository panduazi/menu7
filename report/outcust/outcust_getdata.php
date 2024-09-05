<?php
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

include('../../config/koneksi.php');

$rs = mysql_query("SELECT ConnoteCustNo,CustomerName,Customersales,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP, CustomerSales FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteDate between '$start_date' and '$end_date' and ConnoteOrig=11 and ConnoteValid=1 and ConnoteBillCurrency='IDR' group by ConnoteCustNo,CustomerName");

$result = array();
while($row = mysql_fetch_object($rs)){
array_push($result, $row);
}
echo json_encode($result);
?>

