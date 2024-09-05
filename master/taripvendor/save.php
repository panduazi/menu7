<?php
$no = $_REQUEST['CustomerNo'];
$name = $_REQUEST['CustomerName'];
$addr1 = $_REQUEST['CustomerAddr1'];
$addr2 = $_REQUEST['CustomerAddr2'];
$sales = $_REQUEST['CustomerSales'];
$member = $_REQUEST['CustomerMemberDate'];

include('../../config/koneksi.php');

$sql = "insert into tblcustomer(CustomerNo,CustomerName,CustomerAddr1,CustomerAddr2,CustomerSales,CustomerMemberArea) values('$no','$name1','$addr1','$addr2','$sales','$member')";
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