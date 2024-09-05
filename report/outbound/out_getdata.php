<?php
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

include('../../config/koneksi.php');

$rs = mysql_query("SELECT ConnoteNo,ConnoteDate,ConnoteCustName,ConnoteRecvName,ConnoteQty,ConnoteWeight,CityName,if(ConnoteType=0,'DOC','PAR') as Tipe FROM tblConnote LEFT JOIN tblCity ON ConnoteDest=CityId WHERE ConnoteDate between '$start_date' and '$end_date' and ConnoteOrig=11 and ConnoteValid=1 limit 100");

$result = array();
while($row = mysql_fetch_object($rs)){
array_push($result, $row);
}
echo json_encode($result);
?>

