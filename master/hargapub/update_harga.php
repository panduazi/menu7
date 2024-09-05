<?php

session_start();
date_default_timezone_set('Asia/Jakarta');

$user = $_SESSION['cuser'];
$waktu = date('Y-m-d H:i:s');

$id =  intval($_REQUEST['id']);

$city_id = $_REQUEST['cbdest'];
$sds1 = $_REQUEST['PriceSuper1'];
$sds2 = $_REQUEST['PriceSuper2'];
$sds_lim = $_REQUEST['PriceSuperLim'];
$ons1 = $_REQUEST['PricePrima1'];
$ons2 = $_REQUEST['PricePrima2'];
$ons_lim = $_REQUEST['PricePrimaLim'];
$reg1 = $_REQUEST['PriceExp1'];
$reg2 = $_REQUEST['PriceExp2'];
$reg_lim = $_REQUEST['PriceExpLim'];
$ekono1 = $_REQUEST['PriceEkono1'];
$ekono2 = $_REQUEST['PriceEkono2'];
$ekono_lim = $_REQUEST['PriceEkonoLim'];

include('../../config/koneksi.php');

if($city_id!=$id){
	$cek_row = $koneksi->query("SELECT * FROM tblprice WHERE PriceCityID='$city_id'");
	$rows = mysqli_num_rows($cek_row);
	if($rows==1){
		echo json_encode(array('errorMsg'=>'Tujuan Sudah Terdaftar.'));
		die();
	}
}

$sql = "UPDATE tblprice 
			SET PriceCityID='$city_id',
			PriceSuper1='$sds1',
			PriceSuper2='$sds2',
			PriceSuperLim='$sds_lim',
			PricePrima1='$ons1',
			PricePrima2='$ons2',
			PricePrimaLim='$ons_lim',
			PriceExp1='$reg1',
			PriceExp2='$reg2',
			PriceExpLim='$reg_lim',
			PriceEkono1='$ekono1',
			PriceEkono2='$ekono2',
			PriceEkonoLim='$ekono_lim',
			ModiBy='$user',
			RecId2='$waktu'
			WHERE PriceCityID='$id'
		";
$result = $koneksi->query($sql);
if ($result){
	echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));
} else {
	echo json_encode(array('errorMsg'=>'Terjadi Kesalahan.'));
}
?>