<?php
$id = $_REQUEST['id'];
include('../../config/koneksi.php');
$sql = "delete from tblPickupOrder where POrderNo=$id";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array('success'=>true));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>