<?php
session_start();
$cuser =  $_SESSION['cuser'];

$nocust = $_REQUEST['POrderCustNo']; //jika INT gunakan fungsi intval(....)
$moda = $_REQUEST['POrderDest'];

//cari dulu data customer
include('../../config/koneksi.php');
$sql=mysql_query("select * from tblCustomer where CustomerNo='$nocust'");
$hasil=mysql_fetch_array($sql);
if (mysql_num_rows($sql) > 0) {
	$nmcust=$hasil['CustomerName'];
	$puaddr1=$hasil['CustomerAddr1']; //alamat untuk pickup
	$puaddr2=$hasil['CustomerAddr2']; //alamat untuk pickup
	$puaddr3=$hasil['CustomerAddr3']; //alamat untuk pickup
	$pumtr=$hasil['CustomerAreaMotor'];
	$pumbl=$hasil['CustomerAreaMobil'];
} else
{
	$nmcust='NA#';
	$puaddr1='NA#';
	$puaddr2='NA#';
	$puaddr3='NA#';
	$pumtr='NA#';
	$pumbl='NA#';
}
// cari moda dan kurir aktif hari ini
if ($moda==0) {
	$area=$pumtr;
} else if ($moda==1) {
	$area=$pumbl;
} else {
	$area='NA#';
}
include('../../config/koneksi.php');
$areaid=date('Ymd').$area;
$sql=mysql_query("select * from tblAreaPickupHarian where AreaId='$areaid'");
$hasil=mysql_fetch_array($sql);
if (mysql_num_rows($sql) > 0) {
	$nmkurir=$hasil['AreaKurir'];
} else {
	$nmkurir='NA#';
}
	

$memo = $_REQUEST['POrderMemo'];
$ass = $_REQUEST['ass']; //$_REQUEST['POrderIsi'];
$pak = $_REQUEST['pac']; //$_REQUEST['POrderBayar'];
$person = $_REQUEST['POrderCustPerson'];
	

include('../../config/koneksi.php');
$sql = "INSERT INTO tblPickupOrder (POrderDate, POrderCustNo, POrderCustName, POrderCustAddr1, POrderCustAddr2,POrderCustAddr3, POrderCSO, POrderDest, POrderKurir, POrderMemo, POrderCustPerson, RecId, CreateBy) VALUES (now(),'".$nocust."','".$nmcust."','".$puaddr1."','".$puaddr2."','".$puaddr3."','".$cuser."','".$moda."','".$nmkurir."','".$memo."','".$person."',now(),'".$cuser."')";	
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'POrderCustNo' => $id,
		'POrderDest' => $moda,
		'POrderMemo' => $moda,
		'POrderIsi' => $ass,
		'POrderDest' => $moda,
		'POrderBayar' => $pak
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>