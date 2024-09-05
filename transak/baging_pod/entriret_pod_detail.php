<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = $_SESSION['clocation'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['MM_UserGroup'];
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y')-1;
 $tgl2=date('Y-m-d');   
 $bagawal=date('mdhis');
 $nobagawal=$location.'.'.$bagawal;
 $mnobag='xxx';


 //---jika tekan TOMBOL CREATE ----
 if (isset($_POST['btpodret'])) {
   	//simpan variabel penting dulu
	if ($_POST['noretpod']=='') {
      $bagawal=date('mdhis');
      $nobag=$location.'RPOD.'.$bagawal;
	}
	else {
	  $nobag=$_POST['noretpod'];
	}
	$novendor=$_POST['cbvendor'];
	$nocity=$_POST['cbdest'];
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblcity where CityId=$nocity");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
      include('config/koneksi.php');
	  $query1=mysql_query("select * from tblvendor where VendorNo='$novendor'");
      $hasil1=mysql_fetch_array($query1);
	  session_start();
      $_SESSION['MM_nmdest'] = $hasil[CityName];
      $_SESSION['MM_kddest'] = $hasil[CityCode];
      $_SESSION['MM_nodest'] = $nocity;
      $_SESSION['MM_nobag'] = $nobag;
      $_SESSION['MM_tglbag'] = $_POST['tglbag'];
	  $_SESSION['MM_nmvendor']=$hasil1[VendorName];
	  $nmcity=$hasil[CityName];
	  $kdcity=$hasil[CityForward];
	}
	else {
	  session_start();
      $_SESSION['MM_nmdest'] = 'NA#';
      $_SESSION['MM_kddest'] = 'NA#';
      $_SESSION['MM_nodest'] = '0';
      $_SESSION['MM_nobag'] = 'NA#';
	  $_SESSION['MM_nmvendor']='NA#';
	  $nmcity='NA#';
	  $kdcity='NA#';
	}
  }

  //---jika tekan TOMBOL ADD AWB ----
  if (isset($_POST['addawb'])) {
	$cawb=$_POST['noawb'];
	$mnobag=$_SESSION['MM_nobag'];
	//cari dulu apakah ada nomor awb ini ?
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblconnote where ConnoteNo='$cawb'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
		//rekam ke temporer   	 
	 	$q = "INSERT INTO tempbagpod(sesi,bagno,awbno) VALUES ('".$_SESSION['MM_nobag']."','".$_SESSION['MM_nobag']."','".$cawb."')";
  	 	include('config/koneksi.php');	
  	 	$r=mysql_query($q) or die(mysql_error());
	 	//akhir rekam ke temporer
		}
  	} 
	//-akhir ISSET TOMBOL ADD-AWB
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Entry Baging</title>
 <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
 <link rel="stylesheet" type="text/css" href="themes/icon.css">
 <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
 <script type="text/javascript" src="jq/jquery.min.js"></script>
 <script type="text/javascript" src="jq/jquery.easyui.min.js"></script>
 <script>
  function cekform1()
  {
   if (document.getElementById('nobag').value=='')
    {
	 alert('Nomor baging masih kosong ...');
	 return false;
	}
   if (document.getElementById('cbdest').value=='')
    {
	 alert('Nama kota belum dipilih ...');
	 return false;
	}
   if (document.getElementById('brtbrg').value==0)
    {
	 alert('Berat harus diisi ...');
	 return false;
	}
   if (document.getElementById('kdpos').value=='')
    {
	 alert('Kode POS masih kosong ...');
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
</head>
<body>
 <div style="margin:10px"></div>

 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td style="font-size:16px;" colspan="4"><h1>Create Manifest Retur-POD</h1></td>
   </tr>
  <tr>
    <td colspan="4"><hr></td>
   </tr>
  <tr>
    <td width="14%">Tanggal</td>
    <td width="72%"><strong><? echo $_SESSION['MM_tglbag']; ?></strong> Nomor : <strong><? echo $_SESSION['MM_nobag']; ?></strong></td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td>Kota Tujuan</td>
    <td><strong><? echo $_SESSION['MM_nmdest']; ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Vendor</td>
    <td><strong><? echo $_SESSION['MM_nmvendor']; ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 </table>
 

<form action="?hal=bagdtl" method="post" enctype="multipart/form-data">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td style="font-size:9px" colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:9px" colspan="2">* Masukan/isikan nomor-nomor POD/Resi yang sudah di Delivery dan akan dikembalikan ke Pengirim.</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td width="13%">Nomor AWB/RESI</td>
    <td width="59%">: 
      <input class="easyui-textbox" type="text" name="noawb" id="noawb" />
      <input type="submit" name="addawb" id="addawb" value="Add"  /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

  </table>
 </form>

<div style="margin-bottom:10px">
  </br>
<?php //include('lihatisi_bagdetailret_pod.php'); ?>
</div>  
<div>
<form action="fmenu.php?hal=retpod" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><hr></td>
  </tr>
  <tr>
    <td><input name="btsavebag" type="submit" value="Save Manifest/Baging"> 
      </td>
  </tr>
</table>

</form>
<br />
<a href="fmenu.php?hal=retpod">Batal membuat dan kembali ke menu sebelumnya</a>
</div>  
</body>
</html>