<?php

$nik = $_REQUEST['PegawaiNo'];
$kode = $_REQUEST['PegawaiKode'];
$nama = $_REQUEST['PegawaiNama'];
$dept = $_REQUEST['PegawaiDept'];
$hp = $_REQUEST['PegawaiNoHP'];
$lokasi = $_REQUEST['PegawaiLocation'];

include('../../config/koneksi.php');

$sql = "update tblpegawai set PegawaiNama='$nama',PegawaiDept='$dept',PegawaiNoHP='$hp',PegawaiLocation=$lokasi, PegawaiKode='$kode' where PegawaiNo='$nik'";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'PegawaiNo' => $nik,
		'PegawaiKode' => $kode,
		'PegawaiNama' => $nama,
		'PegawaiDept' => $dept,
        'PegawaiNoHP' => $hp,
		'PegawaiLocation' => $lokasi
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>