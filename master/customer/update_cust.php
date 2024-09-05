<?php
$no = $_REQUEST['CustomerNo'];
$name = $_REQUEST['CustomerName'];
$addr1 = $_REQUEST['CustomerAddr1'];
$addr2 = $_REQUEST['CustomerAddr2'];
$sales = $_REQUEST['CustomerSales'];
$member = $_REQUEST['CustomerMemberDate'];

include('../../config/koneksi.php');

$sql = "update tblcustomer set CustomerName='$name',CustomerAddr1='$addr1',CustomerAddr2='$addr2',CustomerSales='$sales',CustomerMemberDate='$member' where CustomerNo='$no'";
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