<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = $_SESSION['cloc'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['MM_UserGroup'];
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y')-1;
 $tgl2=date('Y-m-d');   
 $nobagawal=date('Ymdhis');

  //---jika tekan TOMBOL CREATE ----
  if (isset($_POST['btcreate'])) {
   	//simpan variabel penting dulu
	$nocity=$_POST['cbdest'];
	$nobag=$_POST['nobag'];
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblprice left join tblcity on PriceCityId=CityId where PriceCityId=$nocity");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	  $nmcity=$hasil[CityName];
	  $kdcity=$hasil[CityForward];
	}
	else {
	  $nmcity='NA#';
	  $kdcity='NA#';
	}
  }
  //---jika tekan TOMBOL CREATE ----
  //if (isset($_POST['btcreate'])) {
  //}
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
   if (document.getElementById('service').value=='')
    {
	 alert('Jenis layanan belum dipilih ...');
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
<body>
    <div style="margin:10px">
    </div>
<div id="er" class="easyui-panel" title="ENTRY BAGING" style="width:100%;height:600px;padding:5px;">
 <form action="fmenu.php?hal=baging" method="post" enctype="multipart/form-data"  onsubmit="cekform1()">
 <div>
   Nomor Baging : <input value="<? echo $nobagawal ?>" name="nobag" type="text" /> 
   Tujuan : 
   <label for="cbdest"></label>
   <select name="cbdest" id="cbdest">
   
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblprice left join tblcity on PriceCityId=CityId order by CityName",$koneksi);
   		  echo "<option value='0'>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
   
   </select>
   <input type="submit" name="btcreate" id="btcreate" value="Create" />
 </div>
 </form>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="13%">&nbsp;</td>
    <td width="59%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td>Nomor Baging</td>
    <td><? echo $nobag ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Tujuan</td>
    <td><? echo $kdcity.'-'.$nmcity ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 </table>

</div>     


</body>
</html>