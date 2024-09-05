<?php
$uid = $_REQUEST['UserID'];
$pass = $_REQUEST['UserPassword'];
$kode = $_REQUEST['PegawaiNo'];
$level = intval($_REQUEST['UserLevel']);

include('../../config/koneksi.php');

$sql = "insert into tbluser(UserID,UserPassword,PegawaiNo,UserLevel) values('$uid','$pass','
$kode',$level')";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'id' => mysql_insert_id(),
		'UserID' => $id,
		'UserPassword' => $pass,
		'PegawaiNo' => $kode,
		'UserLevel' => $level
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>