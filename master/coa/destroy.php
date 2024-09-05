<?php
$id = intval($_REQUEST['id']); //jika INT gunakan fungsi intval(....)
include('../../config/koneksi.php');
$sql = "delete from tbluser where id=$id";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>