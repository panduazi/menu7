<?php
$id = intval($_REQUEST['id']);
$uid = $_REQUEST['UserID'];
$pass = $_REQUEST['UserPassword'];
$kode = $_REQUEST['PegawaiNo'];
$level = intval($_REQUEST['UserLevel']);

include('../../config/koneksi.php');

$sql = "update tbluser set UserID='$uid', UserPassword='$pass',PegawaiNo='$kode',UserLevel=$level where id=$id";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'UserID' => $id,
		'UserPassword' => $pass,
		'PegawaiNo' => $kode,
		'UserLevel' => $level
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>