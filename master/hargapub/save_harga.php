<?php

session_start();

$user = $_SESSION['cuser'];

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

$cek_row = $koneksi->query("SELECT * FROM tblprice WHERE PriceCityID='$city_id'");
$rows = mysqli_num_rows($cek_row);
if($rows==1){
	echo json_encode(array('errorMsg'=>'Tujuan Sudah Terdaftar.'));
	die();
}

$sql = "INSERT INTO tblprice(PriceCityID,
							PriceSuper1,
							PriceSuper2,
							PriceSuperLim,
							PricePrima1,
							PricePrima2,
							PricePrimaLim,
							PriceExp1,
							PriceExp2,
							PriceExpLim,
							PriceEkono1,
							PriceEkono2,
							PriceEkonoLim,
							ModiBy
							) 
		VALUES('$city_id',
				'$sds1',
				'$sds2',
				'$sds_lim',
				'$ons1',
				'$ons2',
				'$ons_lim',
				'$reg1',
				'$reg2',
				'$reg_lim',
				'$ekono1',
				'$ekono2',
				'$ekono_lim',
				'$user'
				)";
$result = $koneksi->query($sql);
if ($result){
	echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));
} else {
	echo json_encode(array('errorMsg'=>'Terjadi Kesalahan.'));
}
?>