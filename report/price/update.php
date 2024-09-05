<?php
$id = intval($_REQUEST['id']); //jika INT gunakan fungsi intval(....)
$CityName = intval($_REQUEST['PriceCityId']);
$cityid=intval($_REQUEST['CityName']);
$reg = intval($_REQUEST['PriceREG1']);
$sds  = intval($_REQUEST['PriceSDS1']);
$ons  = intval($_REQUEST['PriceONS1']);
$eko1  = intval($_REQUEST['PriceEKO1']);
$eko2  = intval($_REQUEST['PriceEKO2']);
$ekolim  = intval($_REQUEST['PriceEKOLim1']);
$truk1 = intval($_REQUEST['PriceTRUCK1']);
$truk2 = intval($_REQUEST['PriceTRUCK2']);
$truk3 = intval($_REQUEST['PriceTRUCK3']);
$truk4 = intval($_REQUEST['PriceTRUCK4']);
$truk5 = intval($_REQUEST['PriceTRUCK5']);
$truk6 = intval($_REQUEST['PriceTRUCK6']);
$truk7 = intval($_REQUEST['PriceTRUCK7']);
$truk8 = intval($_REQUEST['PriceTRUCK8']);
$sea1 = intval($_REQUEST['PriceSEA1']);
$sea2 = intval($_REQUEST['PriceSEA2']);
$sea3 = intval($_REQUEST['PriceSEA3']);
$sea4 = intval($_REQUEST['PriceSEA4']);
$sea5 = intval($_REQUEST['PriceSEA5']);
include('../../config/koneksi.php');
$sql = "update tblprice set PriceSDS1=$sds, PriceONS1=$ons,PriceREG1=$reg, PriceEKO1=$eko1, PriceEKO2=$eko2, PriceEKOLim1=$ekolim, PriceTRUCK1=$truk1, PriceTRUCK2=$truk2,  PriceTRUCK3=$truk3, PriceTRUCK4=$truk4, PriceTRUCK5=$truk5, PriceTRUCK6=$truk6, PriceTRUCK7=$truk7, PriceTRUCK8=$truk8, PriceSEA1=$sea1,PriceSEA2=$sea2, PriceSEA3=$sea3, PriceSEA4=$sea4,PriceSEA5=$sea5 where PriceCityId=$id";

$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'PriceCityId' => $id,
		'PriceCityName' => $cityname,
		'CityName' => $citiid,
		'PriceSDS1' => $sds,		
		'PriceONS1' => $ons,		
		'PriceREG1' => $reg,	
		'PriceEKO1' => $eko1,	
		'PriceEKO2' => $eko2,	
		'PriceEKOLim1' => $ekolim,	
		'PriceTRUCK1' => $truk1,
		'PriceTRUCK2' => $truk2,
		'PriceTRUCK3' => $truk3,
		'PriceTRUCK4' => $truk4,
		'PriceTRUCK5' => $truk5,
		'PriceTRUCK6' => $truk6,
		'PriceTRUCK7' => $truk7,
		'PriceTRUCK8' => $truk8,
		'PriceSEA1' => $sea1,
		'PriceSEA2' => $sea2,
		'PriceSEA3' => $sea3,
		'PriceSEA4' => $sea4,
		'PriceSEA5' => $sea5
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>