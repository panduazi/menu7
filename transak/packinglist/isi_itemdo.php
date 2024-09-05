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

  if (isset($_POST['btcreate'])) {
    $nocust=$_POST['cbcust'];
    //cari data customer
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblcustomer where CustomerNo='$nocust'");
    $hasil=mysql_fetch_array($query);
	$ketemu2=mysql_num_rows($query);
    if($ketemu2==1){ 	
	  $nocust=$_POST['cbcust'];
      $nmcust=$hasil['CustomerName'];
      $alcust=$hasil['CustomerAddr'];
      $tlcust=$hasil['CustomerTelp'];
	  $nmrecv=$_POST['ednmrecv'];
	  $alrecv=$_POST['edalrecv'];
	  $tlrecv=$_POST['edtlrecv'];
	  $cprecv=$_POST['edcprecv'];
	  $ctgl=$_POST['edtgl'];
	
	//Cari Nomor Akhir DO
	include('config/koneksi.php');
	$query=mysql_query("select * from tblcounter where CountCity=$location and CountOffice='$office' and CountName='DO'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	
		  $no=$hasil['CountNo']+1;
		  $kode=$hasil['CountCode'];
		  $result=@mysql_query("update tblcounter set CountNo=CountNo+1 where CountCity=$location and CountOffice='$office' and CountName='DO'") or die(mysql_error());
	    }
		else{   				
	      $result=@mysql_query("insert into tblcounter(CountCity,CountName,CountOffice,CountCode,CountNo) VALUES($location,'DO','$office','$location',1)")  or die(mysql_error());
		  $no=1;
	    };  
  		if ($location<100) {
			if ($location<10) {$location='00'.$location;} else { $location='0'.$location;}
		}
  		if ($no<10) {$no='00000'.$no;}
		elseif ($no<100) {$no='0000'.$no;}
		elseif ($no<1000) {$no='000'.$no;}
		elseif ($no<10000) {$no='00'.$no;}
		else  {$no='0'.$no;}
		$nodo=$kode.'.'.$office.".".$no;
		//--selesai cari nomor
	  session_start();
	  $_SESSION['MM_nodo']=$nodo;
	  $_SESSION['MM_tgldo']=$ctgl;
	  $_SESSION['MM_nocust']=$nocust;
	  $_SESSION['MM_nmcust']=$nmcust;
	  $_SESSION['MM_alcust']=$alcust;
	  $_SESSION['MM_tlcust']=$tlcust;
	  $_SESSION['MM_nmrecv']=$nmrecv;
	  $_SESSION['MM_alrecv']=$alrecv;
	  $_SESSION['MM_tlrecv']=$tlrecv;
	  $_SESSION['MM_cprecv']=$cprecv;
	  
	  
	}
  }//end of btcreate
  
  //--mulai isi BUTTON ADD
  if (isset($_POST['btisi'])) {
    $nobrg=$_POST['ednobrg'];
	$qtbrg=$_POST['qtybrg'];
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblproject_item where ItemCode='$nobrg'");
    $hasil=mysql_fetch_array($query);
	$ketemu0=mysql_num_rows($query);
    if($ketemu0 > 0){ 
	  $nodo=$_SESSION['MM_nodo'];
	  $result=@mysql_query("insert into temppacklist(PackNo, PackItem, PackQty) VALUES( '$nodo', '$nobrg', $qtbrg)")  or die(mysql_error());
	}
	else
	{ 
		echo "<script language=\"Javascript\">\n";
		echo "alert('KODE BARANG INI TIDAK DIKETEMUKAN');";
		echo "</script>";
	}
  }//-end BUTTON ADD
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
</head>

<body>
 <div style="margin:10px"></div>
   <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td style="font-size:16px;" colspan="6">Delivery Order</td>
    </tr>
  <tr>
    <td colspan="6"><hr /></td>
    </tr>
  <tr>
    <td width="44%"><strong><? echo $_SESSION['MM_nmcust'] ?></strong></td>
    <td width="3%">&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="2%">&nbsp;</td>
    <td width="20%">No. Delivery Order (DO)</td>
    <td width="27%">: <? echo $_SESSION['MM_nodo'] ?></td>
  </tr>
  <tr>
    <td><? echo $_SESSION['MM_alcust'] ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Kepada</td>
    <td>: <? echo $_SESSION['MM_nmrecv'] ?></td>
  </tr>
  <tr>
    <td><? echo $_SESSION['MM_tlcust'] ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Alamat kirim</td>
    <td valign="top" rowspan="2">: <? echo $_SESSION['MM_alrecv'] ?></td>
  </tr>
  <tr>
    <td>u.p : <? echo$_SESSION['MM_cpcust'] ?></td>
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
    <td>Telpon</td>
    <td>: <? echo $_SESSION['MM_tlrecv'] ?></td>
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
<div>
<form action="fmenu.php?hal=isido" method="post">
  Kode Barang : 
     <input class="eassyui-textbox" name="ednobrg" type="text" /> 
Jumlah : 
<label for="qtybrg"></label>
<input class="easyui-numberbox" name="qtybrg" type="text" id="qtybrg" value="1" size="6" maxlength="6">
<input  type="submit" name="btisi" id="btisi" value="Add/Tambah" />
</form> 
</div>
<div style="margin-bottom:20px">
<? include("browse_pl.php"); ?>
</div>

<form action="fmenu.php?hal=do" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><hr></td>
  </tr>
  <tr>
    <td><input name="btsavedo" type="submit" value="Save Delivery Order"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</form>

</body>
</html>