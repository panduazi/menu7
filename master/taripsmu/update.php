<?php
$id = intval($_REQUEST['id']); //jika INT gunakan fungsi intval(....)
$vend = htmlspecialchars($_REQUEST['VEDOR']);
$kode = htmlspecialchars($_REQUEST['KODE']);
$nama = htmlspecialchars($_REQUEST['NAMA']);
$ga = $_REQUEST['GA'];
$jt = $_REQUEST['JT'];
$xn= $_REQUEST['XN'];
$qz= $_REQUEST['QZ'];
$qg= $_REQUEST['QG'];
$in= $_REQUEST['IN1'];
$sj= $_REQUEST['SJ'];
$pss= $_REQUEST['PSS'];
$pri= $_REQUEST['PRIORITAS'];
$pri_a= $_REQUEST['PRI_KODE'];
$pri_o= $_REQUEST['PRI_ORIG'];
include('../../config/koneksi.php');
$sql = "update tbAirLineDest set NAMA='$nama', GA='$ga', JT=$jt, XN=$xn, QZ=$qz, QG=$qg, IN1=$in, SJ=$sj, PSS=$pss, PRIORITAS=$pri, PRI_KODE='$pri_a', PRI_ORIG='$pri_o'  where id=$id";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'KODE' =>  $kode, //mysql_insert_id() -- untuk yg automatic nomor
		'NAMA' => $nama,
		'GA' => $ga,
		'JT' => $jt,
		'XN' => $xn,
		'QZ' => $qz,
		'QG' => $qg,
		'IN1' => $in,
		'PSS' => $pss
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>