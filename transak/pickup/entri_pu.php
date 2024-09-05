<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = $_SESSION['clocation'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
 $office = $_SESSION['coffice'];
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y')-1;
 $tgl2=date('Y-m-d');   
 $bagawal=date('mdhis');
 if (isset($_POST['btcaricust'])) {
	$nocust=$_POST['cbcust'];
    include('config/koneksi.php'); 
	$sql=mysql_query("select * from tblcustomer where CustomerNo='$nocust'");
	$hasil=mysql_fetch_array($sql);
	$ketemu=mysql_num_rows($sql);
	if ($ketemu>0) {
		$nocust=$hasil['CustomerNo'];
		$nmcust=$hasil['CustomerName'];
		$alcust=$hasil['CustomerAddr2']; //alamat untuk pickup
		$piccust=$hasil['CustomerPersonName1'];
		$tlcust=$hasil['CustomerTelp'];
		session_start();
		$_SESSION['MM_nocust']=$nocust;
		$_SESSION['MM_nmcust']=$nmcust;
	}
 }
 //---jika tekan TOMBOL Rekam Order ----
 if (isset($_POST['btRekamPU'])) {
	$puaddr=$_POST['alpickup'];
	$dladdr=$_POST['aldelv'];
    $moda=$_POST['cbmoda'];
	session_start();
	$nocust=$_SESSION['MM_nocust'];
	$nmcust=$_SESSION['MM_nmcust'];
  	include('config/koneksi.php');	
	$q = "INSERT INTO tblpickuporder (POrderDate, POrderCustNo, POrderCustName, POrderPUAddr, POrderDLVAddr, POrderCSO, POrderModa, POrderOffice, POrderLocation, RecId, CreateBy) VALUES (now(),'".$nocust."','".$nmcust."','".$puaddr."','".$puaddr."','".$cuser."','".$moda."','".$office."','".$location."',now(),'".$cuser."')";	
	   $r=mysql_query($q) or die(mysql_error());  
	session_start();
	$nocust='';
	$nmcust='';
	    
  } 

 //---jika tekan TOMBOL UPDATE KURIRYG PICKUP dari update_pu.php ----
 if (isset($_POST['btUpdatePU'])) {
	session_start();
	$kurir=$_POST['cbkurir'];
	$orderno=$_SESSION['eorder'];
  	include('config/koneksi.php');	
	$r = mysql_query("UPDATE tblpickuporder SET POrderKurir='$kurir',POrderPickupDate=now(),POrderCSO2='$cuser' WHERE POrderNo=$orderno") or die(mysql_error());	    
  } 


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
  function cekform()
  {
   if (document.getElementById('alpickup').value=='')
    {
	 alert('Tempat pengambilan Barang belum ditulis ...');
	 return false;
	}
   if (document.getElementById('aldelv').value=='')
    {
	 alert('ALamat tujuan harus diisi ...');
	 return false;
	}
   if (document.getElementById('cbmoda').value=='')
    {
	 alert('MODA pengambilan bekum dipilih ...');
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

 <form action="fmenu.php?hal=pu" method="post" enctype="multipart/form-data" >
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td style="font-size:16px;" colspan="4"><h1>Entry Pickup Order</h1></td>
    </tr>
  <tr>
    <td colspan="4"><hr></td>
    </tr>
  <tr>
    <td colspan="4">Tanggal
      <input class="easyui-datebox" type="text" name="tglbag" data-options="formatter:myformatter,parser:myparser" value="<?php echo $hari_ini ?>"/>
      Customer
      <select name="cbcust" id="cbcust">
        <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CustomerNo,CustomerName from tblcustomer where CustomerLocation=$location order by CustomerNo",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
      </select>
      <span style="margin:10px">
      <input type="submit" name="btcaricust" id="btcaricust" value="Open" />
      </span></td>
    </tr>
 </table>
 </form>
    
<form action="fmenu.php?hal=pu" method="post" enctype="multipart/form-data"  onsubmit="return cekform()">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">    
  <tr>
    <td width="17%">&nbsp;</td>
    <td width="28%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td width="41%">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Customer</td>
    <td valign="top"><strong><? echo $nocust.'-'.$nmcust ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>P.I.C / Telp</td>
    <td valign="top"><strong><? echo $piccust.'-'.$tlcust ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Alamat penggambilan</td>
    <td valign="top"><textarea name="alpickup" cols="40" rows="3" id="alpickup"><? echo $alcust ?></textarea></td>
    <td>Rencana Tujuan</td>
    <td><textarea name="aldelv" cols="40" rows="3" id="aldelv">
</textarea></td>
  </tr>
  <tr>
    <td>Moda</td>
    <td><select name="cbmoda" id="cbmoda">
<option value="" selected="selected">-- pilih --</option>
<option value="GRANDMAX">GRANDMAX</option>
<option value="CDE4">CDE-4</option>
<option value="CDD6">CDD-6</option>
<option value="FUSO">FUSO</option>
<option value="INTCOOL">INTERCOLLER</option>
<option value="C20">CONTAINER-20</option>
<option value="C40">CONTAINER-40</option>
<option value="C40HQ">CONTAINER-40HQ</option>
    </select></td>
    <td>Catatan</td>
    <td><input name="edket" type="text" id="edket" size="50"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="btRekamPU" id="btRekamPU" value="Rekam Pickup Order"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  </table>
</form>
<div style="margin-bottom:10px">
<?php include('lihatisi_pu.php'); ?>
</div>  
</body>
</html>