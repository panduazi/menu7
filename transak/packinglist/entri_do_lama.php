<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['MM_UserGroup'];
  $tgl2=date('Y-m-d');   
  $bagawal=date('mdhis');
  $nodo='DO.'.$location.'.'.$bagawal;

  //---jika tekan TOMBOL CREATE ----
  if (isset($_POST['btcreate'])) {
   	//simpan variabel penting dulu
	$nocust=$_POST['cbcust'];
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblcustomer where CustomerNo=$nocust");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	  session_start();
      $_SESSION['MM_nodo'] = 'DO.'.$location.date('mdhis');
	  $_SESSION['MM_nocust']=$nocust;
	  $_SESSION['MM_nmcust']=$hasil[CustomerName];
	  $_SESSION['MM_alcust']=$hasil[CustomerAddr1];
	  $_SESSION['MM_nmrecv']=$_POST['edRecvName'];
	  $_SESSION['MM_alrecv']=$_POST['edRecvAddr'];
	  $_SESSION['MM_rfrecv']=$_POST['edRecvReff'];
	  $nmrecv=$_SESSION['MM_nmrecv'];
	  $alrecv=$_SESSION['MM_alrecv'];
	  $rfrecv=$_SESSION['MM_rfrecv'];
	}
	else {
	  session_start();
      $_SESSION['MM_nodo'] = '';
	  $_SESSION['MM_nocust']='';
	  $_SESSION['MM_nmcust']='';
	  $_SESSION['MM_alcust']='';
	  $_SESSION['MM_nmrecv']='';
	  $_SESSION['MM_alrecv']='';
	  $_SESSION['MM_rfrecv']='';
	  $nmrecv='';
	  $alrecv='';
	  $rfrecv='';
	}
  }
  //---jika tekan TOMBOL ADD AWB ----
  if (isset($_POST['additem'])) {
   if ($_SESSION['MM_nodo'] <> '') {
	 $kdbrg=$_POST['nobrg'];  
	 $qty=$_POST['edqty'];  
	 //cari dulu apakah ada nomor barng  ini ?
   	 include('config/koneksi.php');
	 $kdcust=$_SESSION['MM_nocust'];
	 $query=mysql_query("select * from tblproject_item where ItemCode='$kdbrg' and ItemCust='kdcust'");
     $hasil=mysql_fetch_array($query);
	 $ketemu=mysql_num_rows($query);
     if($ketemu==1){ 		
		//rekam ke temporer   	 
	 	$q = "INSERT INTO temppacklist(PackNo,PackItem,PackQty) VALUES ('".$_SESSION['MM_nodo']."','".$_SESSION['MM_nobag']."',".$qty.")";
  	 	include('config/koneksi.php');	
  	 	$r=mysql_query($q) or die(mysql_error());
	 	//akhir rekam ke temporer
		}
	else {
	}
     }
  	} 
	//-akhir ISSET TOMBOL ADD-AWB
	
  //---jika tekan TOMBOL SAVE-BAGING ----
  if (isset($_POST['btsave'])) {
	  //rekam ke tabel manifest
	  //cetak manifest
	  $n=$_SESSION['MM_nodo'];
	  $d=$_SESSION['MM_nmdest'];
	  $t=date('Y-m-d');
	  echo "<script> window.open('transak/baging/print_manifes.php?nobag=$n&dest=$d&tgl=$t','_blank') </script>";
	  //-reset session dulu
	  session_start();
      $_SESSION['MM_nodo'] = '';
	  $_SESSION['MM_nocust']='';
	  $nmcust='';
	  $alcust='';
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
 <div style="margin:10px"></div>
 <div id="er" class="easyui-panel" title="CREATE PACKING LIST" style="width:100%;height:230px;padding:5px;">
 <div id="er1">
 <form action="fmenu.php?hal=do" method="post" enctype="multipart/form-data" ">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%">Nomor DO</td>
    <td width="51%"><strong><? echo $_SESSION['MM_nodo'] ?></strong></td>
    <td width="9%">Customer</td>
    <td width="30%"><span style="margin:10px">
      <select name="cbcust" id="cbcust">
        <?php 
       include('config/koneksi.php'); 
	   $sales=mysql_query("select CustomerNo,CustomerName from tblcustomer order by CustomerName",$koneksi);
   	   echo "<option value='0'>--pilih--</option>";
	   while ($dsales=mysql_fetch_array($sales))
	   echo "<option value='$dsales[0]'>$dsales[1]</option>";
      ?>
        </select>
      <input type="submit" name="btcreate" id="btcreate" value="Create/Cancel" />
    </span></td>
    </tr>
  <tr>
    <td>Kepada</td>
    <td><input value="<? echo $nmrecv; ?>" name="edRecvName" type="text" id="edRecvName" size="40" /></td>
    <td>Nama</td>
    <td><? echo  $_SESSION['MM_nmcust']; ?></td>
    </tr>
  <tr>
    <td>Alamat</td>
    <td><textarea value="<? echo $alrecv; ?>" name="edRecvAddr" cols="50" rows="3" id="edRecvAddr"></textarea></td>
    <td>&nbsp;</td>
    <td><? echo  $_SESSION['MM_alcust']; ?></td>
    </tr>
  <tr>
    <td>Reff</td>
    <td><input value="<? echo $rfrecv; ?>" name="edRecvReff" type="text" id="edRecvReff" size="30" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  </table>
 </form>
 </div>

 <div id="er2">
 <form action="?hal=do" method="post" enctype="multipart/form-data">
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="4"><hr></td>
    </tr>
  <tr>
    <td width="10%">Kode Barang</td>
    <td width="51%"><input type="text" name="nobrg" id="nobrg" /> 
      Jumlah 
        <label for="edqty"></label>
        <input class="easyui-numberbox" name="edqty" type="text" id="edqty" value="1" size="6" maxlength="6" />
        <input type="submit" name="additem" id="additem" value="Add"  /></td>
    <td width="9%">&nbsp;</td>
    <td width="30%">&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
 </table>
 </form>
 </div> 
</div>

<div style="margin-bottom:10px; margin-top:10px">
<form action="fmenu.php?hal=do" method="post" enctype="multipart/form-data">
  <input name="btsave" type="submit" value="Save Packing List/DO" />
</form> 
</div>
  
</body>
</html>