<?php
$vend = htmlspecialchars($_REQUEST['VENDOR']);
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
$sql = "insert into tbAirLineDest(KODE,NAMA,GA,JT,XN,QZ,QG,IN1,SJ,PSS,PRIORITAS,PRI_KODE,PRI_ORIG) values('$kode','$nama', $ga, $jt, $xn, $qz, $qg, $in, $sj, $pss, $pri, '$pri_a', '$pri_o')";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'VENDOR' =>  $vend, //mysql_insert_id() -- untuk yg automatic nomor
		'KODE' =>  $kode, //mysql_insert_id() -- untuk yg automatic nomor
		'NAMA' => $nama,
		'GA' => $ga,
		'JT' => $jt,
		'XN' => $xn,
		'QZ' => $qz,
		'QG' => $qg,
		'IN' => $in,
		'ISJ' => $sj,
		'PSS' => $pss
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>