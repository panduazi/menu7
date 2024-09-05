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
  if (isset($_POST['btcaricust'])) {
	include('config/koneksi.php');
	$sql=@mysql_query("SELECT * FROM tblcustomer WHERE CustomerNo='$_POST[cbcust]'");
	$hasil= mysql_fetch_array($sql);
	session_start();
	$_SESSION['MM_nocust']=$_POST['cbcust'];
	$_SESSION['MM_nmcust']=$hasil['CustomerName'];
	$_SESSION['MM_alcust']=$hasil['CustomerAddr1'];
	$_SESSION['MM_tlcust']=$hasil['CustomerTelp'];
	$_SESSION['MM_cpcust']=$hasil['CustomerPersonName2'];
    $_SESSION['MM_period']=$period;
  } //akhir tombol caricust
  
  if (isset($_POST['btsaveinvoice'])) {
	//cari nomor invoice dulu  
  	include('config/koneksi.php');
	$query=mysql_query("select * from tblcounter where CountCity=$location and CountName='INV'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	  $no=$hasil['CountNo']+1;
	  $label=$hasil['CountCode'];
	  $sql="update tblcounter set CountNo=".$no." where CountCity=".$location." and CountName='INV'";
	  $result = mysql_query($sql)  or die(mysql_error());
	}  
  	if ($no<10) {$no='00000'.$no;}
	 elseif ($no<100) {$no='0000'.$no;}
	 elseif ($no<1000) {$no='000'.$no;}
	 elseif ($no<10000) {$no='00'.$no;}
	 else  {$no='0'.$no;
	}
	$noinv=$label.$no; 
	  
	//isi pada detail INVOICE
	$cnoinv=$_SESSION['MM_noinv'];
	$nhrg=0;
	$ndisc=0;
	$npack=0;
	$nass=0;
	$nlain=0;
	include('config/koneksi.php');
	$sql = mysql_query("SELECT * FROM tempinv WHERE tId='$cnoinv'");
	while ($r=mysql_fetch_array($sql)){
		$nhrg=$nhrg+$r['tHarga'];
		$ndisc=$ndisc+$r['tDisc'];
		$npack=$npack+$r['tPack'];
		$nass=$nass+$r['tAss'];
		$nlain=$nlain+$r['tLain'];
		$cnoinv=$r['tId'];
		$cnoawb=$r['tNoKonos'];
		include('config/koneksi.php');
 		$sql0=mysql_query("INSERT INTO tblinvoicedtl(SD_InvoiceNo,SD_ConnoteNo) VALUES('$cnoinv','$cnoawb')");
		include('config/koneksi.php');
 		$sql1=mysql_query("UPDATE tblconnote SET ConnoteInvoice=1 WHERE ConnoteNo='$cnoawb'") or die(mysql_error());
	}
	//hapus di temporer dulu ..
	//include('config/koneksi.php');
	$sql2=@mysql_query("DELETE FROM tempinv WHERE tNoKonos='$_SESSION[MM_noinv]'") or die(mysql_error());
	//isi pada detail INVOICE
	include('config/koneksi.php');
	$sql3=@mysql_query("INSERT INTO tblinvoice(InvoiceNo, InvoiceDate, InvoiceCustNo, InvoiceName, InvoiceAddr1, InvoiceAmmount_IDR, InvoiceDisc_IDR, InvoicePack_IDR, InvoiceIns_IDR, InvoiceOther_IDR, InvoicePeriode, InvoiceRecId1, InvoiceRecId2,ModiBy) VALUES('$noinv', '$_SESSION[MM_tglinv]', '$_SESSION[MM_nocust]', '$_SESSION[MM_nmcust]', '$_SESSION[MM_alcust]', $nhrg, $ndisc, $npack, $nass, $nlain, '$_SESSION[MM_period]', now(),now(),'$_SESSION[cuser]')") or die(mysql_error());
  	session_start();
  	$_SESSION['MM_nocust']='';
  	$_SESSION['MM_nmcust']='';
  	$_SESSION['MM_alcust']='';
  	$_SESSION['MM_tlcust']='';
  	$_SESSION['MM_cpcust']='';
  	$_SESSION['MM_period']='';
  }
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
 <form action="?hal=inv" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="font-size:16px;"><h1>Create Invoice</h1></td>
    <td align="right">Pelangan : 
      <select name="cbcust" id="cbcust">
        <?php 
         include('config/koneksi.php'); 
	     $sales=mysql_query("select CustomerNo,CustomerName,CustomerAddr1,CustomerTelp from tblcustomer order by CustomerName",$koneksi);
   	     echo "<option value=''>--pilih--</option>";
	     while ($dsales=mysql_fetch_array($sales))
	     echo "<option value='$dsales[0]'>$dsales[1]</option>";
        ?>
      </select>
      <input name="btcaricust" type="submit" value="cari" />
    </td>
  </tr>
  </table>
 </form>  
 <form action="?hal=invdtl" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="5"><hr /></td>
    </tr>
  <tr>
    <td width="21%">No. Pelanggan</td>
    <td width="44%"><label for="ednmrecv">
      <input type="text" name="ednocust" id="ednocust" value="<? echo $_SESSION[MM_nocust] ?>" />
    </label></td>
    <td width="2%">&nbsp;</td>
    <td width="8%">Date</td>
    <td width="25%"><input value="<? echo $tglskr; ?>" class="easyui-datebox" type="text" name="edtgl" data-options="formatter:myformatter,parser:myparser" id="edtgl" /></td>
  </tr>
  <tr>
    <td>Nama Pelanggan</td>
    <td><label for="edalrecv">
      <input type="text" name="ednmcust" id="ednmcust" size="50" value="<? echo $_SESSION[MM_nmcust] ?>"/>
    </label></td>
    <td>&nbsp;</td>
    <td>Periode</td>
    <td><input type="text" name="edperiod" id="edperiod" value="<? echo $_SESSION[MM_period] ?>"/></td>
  </tr>
  <tr>
    <td valign="top">Alamat</td>
    <td><textarea name="edalcust" id="edalcust" cols="50" rows="3"><? echo $_SESSION[MM_alcust] ?></textarea></td>
    <td>&nbsp;</td>
    <td valign="top">Remark</td>
    <td><textarea name="edmemo" id="edmemo" cols="45" rows="3"></textarea></td>
  </tr>
  <tr>
    <td>Telpon/HP</td>
    <td><input type="text" name="tlcust" id="tlcust" value="<? echo $_SESSION[MM_telcust] ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Contact Person</td>
    <td><input name="edcprecv" type="text" id="edcprecv" size="30" value="<? echo $_SESSION[MM_cpcust] ?>"/></td>
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><? if ($_SESSION['MM_nocust']=='') {
		   echo "<input type='submit' name='btcreate' id='btcreate' value='Create Invoice' disabled='disabled' />";
		   }
		   else {
		   echo "<input type='submit' name='btcreate' id='btcreate' value='Create Invoice' />";
		   }
		?>
      </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><hr /></td>
  </tr>
  </table>

</form> 
<div style="margin-bottom:10px">
<?php include('browse_inv.php'); ?>
</div>  


</body>
</html>