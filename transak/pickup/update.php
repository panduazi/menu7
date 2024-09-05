<?php
session_start();
$cuser =  $_SESSION['cuser'];

$id = $_REQUEST['id']; //jika INT gunakan fungsi intval(....)
$kurir = $_REQUEST['kur'];

include('../../config/koneksi.php');
$sql = "UPDATE tblPickupOrder SET POrderKurir='$kurir',POrderFinalDate=now(),POrderCSO2='$cuser' WHERE POrderNo=$id";

$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'POrderNo' => $id,
		'POrderKurir' => $kurir
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>