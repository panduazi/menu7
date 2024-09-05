<?
$norec=$_GET['id'];
$aktif=$_GET['isi'];
if ($aktif==1) {
	include('../../config/koneksi.php');
	$sql=mysql_query("UPDATE tblmanifestdetail SET ManiQty=0 WHERE ManiDtlConnoteNo='$norec'") or die(mysql_error()); 
}
else { 
	include('../../config/koneksi.php');
	$sql=mysql_query("UPDATE tblmanifestdetail SET ManiQty=1 WHERE ManiDtlConnoteNo='$norec'") or die(mysql_error()); 
}
header("location: ../../fmenu.php?hal=af");
?>