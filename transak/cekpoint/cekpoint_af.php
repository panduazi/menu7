<?php
  session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $codeorig = $_SESSION['corigincode'];
  $tglskr=date('Y-m-d');   
  $bagawal=date('mdhis');
  $period=date('Y-m');

  
  //jika btcaricust di tekan
  if (isset($_POST['btcarimani'])) {
	$nomani=$_POST['ednomani'];  
	if ($nomani=='') {$nomani='NA#';}
	include('config/koneksi.php');
    $sql0=mysql_query("SELECT * FROM tblmanifest left join tblcity on ManifestFromCity=CityId where ManifestNo='$nomani'");
	$hsl0=mysql_fetch_array($sql0);
	if ($hsl0==true) {
		session_start();
		$_SESSION['MM_nomani']=$nomani;
		$_SESSION['MM_tglmani']=$hsl0['ManifestDate'];
		$_SESSION['MM_ktasal']=$hsl0['CityName'];
		$_SESSION['MM_brt']=$hsl0['ManifestWeight'];
		$_SESSION['MM_ada']=true;
		
	} else {
		$_SESSION['MM_nomani']='NA#';
		$_SESSION['MM_tglmani']='';
		$_SESSION['MM_ktasal']='';
		$_SESSION['MM_brt']='';
		$_SESSION['MM_ada']=false;
	}
  }//akhir tombol cari nomanifest
  
  //jika btcaricust di tekan
  if (isset($_POST['btsave'])) {
	include('config/koneksi.php');
	$ckey=$_SESSION['MM_nomani'];
    $sql1=mysql_query("SELECT * FROM tblmanifestdetail WHERE ManiDtlNo='$ckey'");
	while ($hsl1=mysql_fetch_array($sql1)) {
		//entry Status CP-AF
		$noawb=$hsl1['ManiDtlConnoteNo'];
		$cnocp=6;
		$cjam=date("G:i:s");
		if ($hsl1['ManiQty']=1) {$cdesc='Cek Fisik Barang ada dan lengkap, diperiksa oleh '.$cuser;} else {$cdesc='Cek fisik barang tidak ditemukan/tidak ada, diperiksa oleh '.$cuser;}
		$q = "INSERT INTO tbltrackingstatus(StatusKonosNo, StatusPOD, StatusDesc, StatusOffice, StatusLocation, StatusDate, StatusJam, RecId, ModiBy) VALUES ('".$noawb."','".$cnocp."','".$cdesc."','".$office."','".$location."','".$tglskr."','".$cjam."',now(),'".$cuser."')";
  		 include('config/koneksi.php');	
  		 $r=mysql_query($q) or die(mysql_error());
	} //akhir looping
	$_SESSION['MM_nomani']='NA#';
	$_SESSION['MM_tglmani']='';
	$_SESSION['MM_ktasal']='';
	$_SESSION['MM_brt']='';
	$_SESSION['MM_ada']=false;
  }//akhir tombol SAVE
  
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Entry Invoice</title>
 <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
 <link rel="stylesheet" type="text/css" href="themes/icon.css">
 <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
 <script type="text/javascript" src="jq/jquery.min.js"></script>
 <script type="text/javascript" src="jq/jquery.easyui.min.js"></script>
</head>
<script>
  function cekform()
  {
   if (document.getElementById('cbcust').value=='')
    {
	 alert('Nama pelanggan belum dipilih ...');
	 return false;
	}
   if (document.getElementById('ednmrecv').value=='')
    {
	 alert('Nama yang dituju belum diisi ...');
	 return false;
	}
   if (document.getElementById('edalrecv').value=='')
    {
	 alert('Alamat tujuan masih kosong ...');
	 return false;
	}
   if (document.getElementById('edcprecv').value=='')
    {
	 alert('Contact person tidak boleh kosong...');
	 return false;
	}
   if (document.getElementById('harga').value=='0')
    {
	 alert('Harga harus diisi ...');
	 return false;
	}
   if (document.getElementById('berat').value=='0')
    {
	 alert('BERAT Barang harus diisi ...');
	 return false;
	}
   else return true;
   	
  }
   function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        }
		
   function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }	
   }
</script> 
<body>
 <div style="margin:10px"></div>
 <form action="?hal=af" method="post">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="2" style="font-size:16px"><h1>Validasi/Cek barang-barang yg masuk</h1></td>
    <td align="right">Cari no.manifest 
      <input type="text" name="ednomani" id="ednomani" />
      <input name="btcarimani" type="submit" value="cari" /></td>
    </tr>
  <tr>
    <td colspan="3"><hr /></td>
    </tr>
  <tr>
    <td width="12%">&nbsp;</td>
    <td width="43%">&nbsp;</td>
    <td width="45%">&nbsp;</td>
  </tr>
  <tr>
    <td>Nomor Manifest</td>
    <td><?  echo $_SESSION[MM_nomani] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tanggal</td>
    <td><?  echo $_SESSION[MM_tglmani] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kota Asal</td>
    <td><?  echo $_SESSION[MM_ktasal] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Berat (Kg.)</td>
    <td><?  echo $_SESSION[MM_brt] ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><hr /></td>
    </tr>
</table>
 </form>  


<div style="margin-bottom:10px">
<?php 
 if ($_SESSION['MM_ada']) {
	include('lihatisi_af.php');
	echo "<br>";
 	echo "<form action='?hal=af' method='post'>";
 	echo "<input name='btsave' type='submit' value='Rekam Cek Fisik Barang Masuk' />";
 	echo "</form>";
 }
?>
</div>  
<div style="font-size:9px">
<?php 
 if ($_SESSION['MM_ada']) {
    echo "* catatan : untuk merubah cek fisik ini, CLICK pada kolom Cek.Fisik, sehingga menjadi ADA/TDK.ADA sesuai dengan keadaan fisik barang.";
 }
 ?>
</div>


</body>
</html>