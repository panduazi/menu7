<?php
$kode = $_REQUEST['KODE'];
$vendor = $_REQUEST['VENDOR'];
$prior = $_REQUEST['PRIOR'];
$tarip = $_REQUEST['COST'];
$min = $_REQUEST['MIN'];

include('../../config/koneksi.php');

$sql = "update tbAirlinePrior set VENDOR='$vendor',CustomerAddr1='$addr1',CustomerAddr2='$addr2',CustomerSales='$sales',CustomerMemberDate='$member' where CustomerNo='$no'";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'CustomerNo' => $no,
		'CustomerName' => $name,
		'CustomerAddr1' => $addr1,
		'CustomerAddr2' => $addr2,
        'CustomerSales' => $sales,
		'CustomerMemberDate' => $member
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>