<?php
$nik = $_REQUEST['PegawaiNo'];
$kode = $_REQUEST['PegawaiKode'];
$nama = $_REQUEST['PegawaiNama'];
$dept = $_REQUEST['PegawaiDept'];
$hp = $_REQUEST['PegawaiNoHP'];
$lokasi = $_REQUEST['PegawaiLocation'];

include('../../config/koneksi.php');

$sql = "insert into tblPegawai(PegawaiNo,PegawaiKode,PegawaiNama,PegawaiDept,PegawaiNoHP,PegawaiLocation) values('$nik','$kode','
$pic1','$pic2','$pic3','$pic_name')";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'id' => mysql_insert_id(),
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