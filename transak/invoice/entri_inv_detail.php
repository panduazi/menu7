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
  $sesi=$_SESSION['cuser'].$bagawal;
  
  function nonm_serv($param) {
	echo $param;
    //cari service dulu
  	include('config/koneksi.php');
	$ql=mysql_query("select * from tblservice where ServiceId=$param");
    $hsl=mysql_fetch_array($ql);
    $rec=mysql_num_rows($ql);
	if ($rec>0) {$balik=$hsl['ServiceName'];}
 	else {$balik="NA#";}
	return $balik;
  }
  
  function cari_ganda($n) {
  	include('config/koneksi.php');
	$ql=mysql_query("select * from tempinv where tNoKonos='$n'");
    $hsl=mysql_fetch_array($ql);
    $rec=mysql_num_rows($ql);
	if ($rec>0) {$balik=false;}
 	else {$balik=true;}
	return $balik;
  }

  //jika btcreate di tekan dari entri_inv.php
  if (isset($_POST['btcreate'])) {
	$noinv=$sesi; 
	session_start();
	$_SESSION[MM_noinv]=$noinv;
	$_SESSION[MM_tglinv]=$_POST['edtgl'];
	$_SESSION[MM_period]=$_POST['edperiod'];
	
	  
  } //akhir
  	

  //jika btcaricust di tekan
  if (isset($_POST['btadd'])) {
	$ckey=$_POST['edawb'];
	include('config/koneksi.php');
	$sql=@mysql_query("SELECT * FROM tblconnote left join tblCity ON ConnoteDest=CityId WHERE ConnoteNo='$ckey'");
	$hasil= mysql_fetch_array($sql);
    $rec=mysql_num_rows($sql);
	if ($rec>0 && $hasil['ConnoteValid']==1) {
		$cid=$_SESSION[MM_noinv];
    	$cnoresi=$hasil['ConnoteNo'];
    	$ctglresi=$hasil['ConnoteDate'];
    	$cnmresi=$hasil['ConnoteCustName'];
    	$cnmrecv=$hasil['ConnoteRecvName'];
		$cnmdest=$hasil['CityName'];
    	$cbrtresi=$hasil['ConnoteWeight'];
    	$cqtyresi=$hasil['ConnoteQty'];
		$cnilai=$hasil['ConnoteBillAmount'];
		$cisi=$hasil['ConnoteContents'];
		if ($hasil['ConnoteInvoice']==0) {
			if (cari_ganda($cnoresi)) {
 			  include('config/koneksi.php');
 			  $sql=@mysql_query("INSERT INTO tempinv(tTglKonos, tNoKonos, tId, tNamaDest, tNamaKota, tBanyak, tBerat, tHarga, tIsi) VALUES('$ctglresi','$cnoresi','$cid','$cnmrecv','$cnmdest',$cqtyresi,$cbrtresi,$cnilai,'$cisi')") or die(mysql_error());
			}
		}
	} //alhir jika Connote ada atau blm divalidasi
	else {
		echo "<script>window.alert('CONNOTE tidak diketemukan atau BELUM di VALIDASI ...!')</script>"; 
	}
  } //akhir tombol caricust
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

  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td style="font-size:16px;"><h1>Isi/Daftarkan Connote ke Invoice</h1></td>
  </tr>
  </table>

 <form action="?hal=invdtl" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td colspan="5"><hr /></td>
    </tr>
  <tr>
    <td width="21%">No.Invoice</td>
    <td width="48%"><label for="ednmrecv">
      <input name="ednoinv" type="text" id="ednoinv" value="<? echo $_SESSION[MM_noinv] ?>" readonly />
    </label></td>
    <td width="1%">&nbsp;</td>
    <td width="7%">Date</td>
    <td width="23%"><input name="edtgl" type="text" class="easyui-datebox" id="edtgl" value="<? echo $tglskr; ?>" readonly data-options="formatter:myformatter,parser:myparser" /></td>
  </tr>
  <tr>
    <td>Nama Pelanggan</td>
    <td><label for="edalrecv">
      <input name="ednmcust" type="text" id="ednmcust" value="<? echo $_SESSION[MM_nocust].'-'.$_SESSION[MM_nmcust] ?>" size="50" readonly/>
    </label></td>
    <td>&nbsp;</td>
    <td>Periode</td>
    <td><input name="edperiod" type="text" id="edperiod" value="<? echo $_SESSION[MM_period] ?>" readonly/></td>
  </tr>
  <tr>
    <td valign="top">Alamat</td>
    <td><textarea name="edalcust" cols="50" rows="2" readonly id="edalcust"><? echo $_SESSION[MM_alcust] ?></textarea></td>
    <td>&nbsp;</td>
    <td valign="top">Remark</td>
    <td><textarea name="edmemo" cols="0" rows="2" readonly="readonly" id="edmemo"></textarea></td>
  </tr>
  <tr>
    <td>Person / U.P </td>
    <td><input name="edcprecv" type="text" id="edcprecv" value="<? echo $_SESSION[MM_cpcust] ?>" readonly/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Input No AWB</strong></td>
    <td><input name="edawb" type="text" id="edawb" />
      <input type='submit' name='btadd' id='btadd' value='Add' /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"></td>
    </tr>
  <tr>
    <td colspan="5"><hr /></td>
  </tr>
  </table>

</form> 
<div>
<?php include('browse_invdtl.php'); ?>
<?
  	include('config/koneksi.php');
	$ql=mysql_query("select sum(tHarga) as jumlah from tempinv where tId='$_SESSION[MM_noinv]'");
    $hsl=mysql_fetch_array($ql);
	$nnilai=number_format($hsl[jumlah],1);
?>
<form action="?hal=inv" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
    <td><hr></td>
  </tr>
  <tr>
    <td><input type="submit" name="btsaveinvoice" id="btsaveinvoice" value="Save Invoice"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><strong>TOTAL (Rp.) : <? echo $nnilai ?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>
</div>  
</body>
</html>