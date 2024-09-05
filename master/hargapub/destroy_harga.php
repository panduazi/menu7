<?php

$id = intval($_REQUEST['id']);

include('../../config/koneksi.php');

$sql = "DELETE FROM tblprice WHERE PriceCityID=$id";
$result = $koneksi->query($sql);
if ($result){
	echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));
} else {
	echo json_encode(array('errorMsg'=>'Terjadi Kesalahan.'));
}
?>