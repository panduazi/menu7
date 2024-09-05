<?php
  session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 $location = $_SESSION['cloc'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['MM_UserGroup'];
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y')-1;
 $tgl2=date('Y-m-d');   
 
 //---jika tekan TOMBOL Save ----
 if (isset($_POST['btsave'])) {
		$cnoresi = $_POST['noresi'];
		$dtglresi = $_POST['tglresi'];
		$cnocust = substr($_POST['nmcust'],0,10);
		$cnmcust = substr($_POST['nmcust'],11,50);
		$cnmrecv = $_POST['nmrecv'];
		$calrecv = $_POST['alrecv'];
		$ndest = $_POST['cbdest'];
		$cketisi = $_POST['ketisi'];
		$nbayar = $_POST['jnsbayar'];
		$nberat = $_POST['berat'];
		$service = $_POST['service'];
		$q = "INSERT IGNORE INTO tblconnote(ConnoteNo, ConnoteDate, ConnoteDest, ConnoteCustNo, ConnoteCustName, ConnoteRecvName, ConnoteRecvAddr, ConnoteContents, ConnotePayment, ConnoteWeight, ConnoteService, ConnoteRecId1, ConnoteRecId2, ConnoteCreateBy, ConnoteModiBy) VALUES ('".$cnoresi."','".$dtglresi."','".$ndest."','".$cnocust."','".$cnmcust."','".$cnmrecv."','".$calrecv."','".$cketisi."','".$nbayar."','".$nberat."','".$service."',now(),now(),'".$user."','".$user."')";
  include('config/koneksi.php');	
  $r=mysql_query($q) or die(mysql_error());
  if ($r) {
	$msg="Berhasil";
	//buat cetak ke printer
	
    }
    else {$msg="Gagal";
	}
  } //-akhir dari Tombol SAVE
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Entry Resi</title>
 <script>
 function cekform()
  {
   if (document.getElementById('tglresi').value=='')
    {
	 alert('Tanggal masih kosong ...');
	 return false;
	}
   if (document.getElementById('noresi').value=='')
    {
	 alert('Nomor RESI masih kosong ...');
	 return false;
	}
   if (document.getElementById('nmcust').value=='')
    {
	 alert('Nama di tuju tidak boleh kosong ...');
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
    <div style="margin:10px">
    </div>
<div id="er" class="easyui-panel" title="ENTRY CONNOTE COOPORATE/CREDIT" style="width:100%;height:500px;padding:5px;">
     <form action="fmenu.php?hal=ekurir" method="post" onsubmit="return cekform()">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%">Tanggal</td>
    <td width="35%"><label for="tglresi"></label>
      <input name="tglresi" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="tglresi" value="<?php echo $hari_ini ?>" size="12" /></td>
    <td width="8%">&nbsp;</td>
    <td width="47%">&nbsp;</td>
  </tr>
  <tr>
    <td>No. Resi</td>
    <td><label for="noresi"></label>
      <input name="noresi" type="text"  id="noresi" size="20" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pelanggan</td>
    <td><label for="nmcust">
      <select name="nmcust" id="nmcust">
        <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CustomerNo,CustomerName from tblcustomer order by CustomerName ",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]$dsales[1]'>$dsales[1]</option>";
		 ?>
      </select>
    </label></td>
    <td>berat</td>
    <td><input  name="berat" type="text" id="berat" value="1" size="6" /> 
      Koli/Qty       <input  name="qty" type="text" id="qty" value="1" size="4" /></td>
  </tr>
  <tr>
    <td>Nama dituju</td>
    <td><input name="nmrecv"  type="text" id="nmrecv" size="50" /></td>
    <td>keterangan isi</td>
    <td><label for="ketisi"></label>
      <input name="ketisi" type="text"  id="ketisi" size="30" maxlength="50" />      <label for="berat"></label></td>
  </tr>
  <tr>
    <td>alamat</td>
    <td><label for="nmrecv">
      <textarea name="alrecv" id="alrecv" cols="45" rows="3"></textarea>
    </label></td>
    <td>Pembayaran</td>
    <td><label for="harga"></label>
      <label for="jnsbayar">
        <select name="jnsbayar" id="jnsbayar" >
          <option value="0">Cash</option>
          <option value="1" selected="selected">Credit</option>
          <option value="2">COD</option>
        </select>
    </label></td>
  </tr>
  <tr>
    <td>Kota tujuan</td>
    <td><label for="alrecv">
      <select name="cbdest" id="cbdest">
        <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblcity order by CityName",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
      </select>
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>layanan</td>
    <td><label for="kdpos">
      <select  name="service" id="service">
        <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select ServiceId,ServiceName from tblservice order by ServiceId ",$koneksi);
  		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
        </select>
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btsave" id="btsave" value="Save/Rekam" />
      <input type="reset" name="btcancel" id="btcancel" value="Reset/Clear" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

  </form>
</div>    
<div style="margin-bottom:10px">
  </br>
  <?php //include('lihatisi_resi.php'); ?>
</div> 
</body>
</html>
