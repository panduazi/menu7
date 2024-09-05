<?php

$id = intval($_REQUEST['id']);

include('../config/koneksi.php');

$sql = "UPDATE tbljournal SET JOURNALSTATUS=-1 WHERE JournalId=$id";
$result = $koneksi->query($sql);
if ($result){
	echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));
} else {
	echo json_encode(array('errorMsg'=>'Terjadi Kesalahan.'));
}
?>