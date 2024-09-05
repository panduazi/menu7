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
  $hari_ini=date('m/d/Y');
  $tglresi=date('m/d/Y')-1;
  $tgl2=date('Y-m-d');   
 
  //---jika tekan TOMBOL Save ----
  if (isset($_POST['btsave'])) {
   	//ambil nomor Connote Dulu
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblcounter_awb where CountCity=$location");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	  $no=$hasil['CountNo']+1;
	  $no2=$hasil['CountKey']+1;
	  $label=$hasil['CountLabel'];
	  if ($no2>7) {$no2=1;}
	  $sql='update tblcounter_awb set CountNo='.$no.',Countkey='.$no2.' where CountCity='.$location;
	  $result = @mysql_query($sql)  or die(mysql_error());
	}  
  	if ($no<10) {$no='000000'.$no;}
	 elseif ($no<100) {$no='00000'.$no;}
	 elseif ($no<1000) {$no='0000'.$no;}
	 elseif ($no<10000) {$no='000'.$no;}
	 elseif ($no<100000) {$no='00'.$no;}
	 else  {$no='0'.$no;
	}
	$cnoresi=$label.$no.$no2;   //--selesai cari nomor
	$cnocust = $_POST['nmcust'];
	$dtglresi = $_POST['tglresi'];
	$cnmrecv = $_POST['nmrecv'];
	$calrecv = $_POST['alrecv'];
	$ndest = $_POST['cbdest'];
	$cketisi = $_POST['ketisi'].' '.$_POST['ketisi2'].' '.$_POST['ketisi3'].' '.$_POST['ketisi4'];
	$nbayar = $_POST['jnsbayar'];
	$nqty = $_POST['qty'];
	$nberat = $_POST['berat'];
	$service = $_POST['service'];
	$nodo1=$_POST['ketisi2'];
	$nodo2=$_POST['ketisi3'];
	$nodo3=$_POST['ketisi4'];
	//Cari nama dan alamat customer
 	include('config/koneksi.php');
	$query=mysql_query("select * from tblcustomer where CustomerNo='$cnocust'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	   $cnmcust = $hasil['CustomerName'];
	   $calcust = $hasil['CustomerAddr1'];
	   $ctlcust = $hasil['CustomerTelp'];
	}
	//rekam ke Database	   	 
	$q = "INSERT INTO tblconnote(ConnoteNo, ConnoteDate, ConnoteOrig, ConnoteDest, ConnoteCustNo, ConnoteCustName, ConnoteCustAddr, ConnoteCustTelp,ConnoteRecvName, ConnoteRecvAddr, ConnoteContents, ConnoteOffice, ConnotePayment, ConnoteWeight,ConnoteQty, ConnoteService, ConnoteRecId1, ConnoteRecId2, ConnoteCreateBy, ConnoteModiBy) VALUES ('".$cnoresi."','".$dtglresi."','".$location."','".$ndest."','".$cnocust."','".$cnmcust."','".$calcust."','".$ctlcust."','".$cnmrecv."','".$calrecv."','".$cketisi."','".$office."','".$nbayar."','".$nberat."','".$nqty."','".$service."',now(),now(),'".$user."','".$user."')";
  include('config/koneksi.php');	
  $r=mysql_query($q) or die(mysql_error());
  if ($r) {
	$msg="Berhasil";
    //update Master DO untuk isi no AWB
	if ($nodo1 !== '') {
		$result1=@mysql_query("update tblproject_master set PConnoteNo='$cnoresi' where PNo='$nodo1'");}
	if ($nodo2 !== '') {
		$result2=@mysql_query("update tblproject_master set PConnoteNo='$cnoresi' where PNo='$nodo2'");}
	if ($nodo3 !== '') {
		$result3=@mysql_query("update tblproject_master set PConnoteNo='$cnoresi' where PNo='$nodo3'");}
	//buat cetak ke printer
	echo "<script> window.open('transak/eresi/print_eawb.php?noresi=$cnoresi','_blank') </script>";
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
 <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
 <link rel="stylesheet" type="text/css" href="themes/icon.css">
 <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
 <script type="text/javascript" src="jq/jquery.min.js"></script>
 <script type="text/javascript" src="jq/jquery.easyui.min.js"></script>
 <script>
 function cekform()
  {
   if (document.getElementById('tglresi').value=='')
    {
	 alert('Tanggal masih kosong ...');
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
    <div id="er" class="easyui-panel" title="ENTRY E-RESI/E-CONNOTE" style="width:100%;height:380px;padding:5px;">
    <div style="margin:10px">
    </div>
    <div>
    <input name="cekprint" type="checkbox" value="1" checked="checked" />
    Cetak ke printer
    <input name="cekcust" type="checkbox" value="0"/>
    Pengirim jgn dihapus
    </div>
    <div style="margin:10px">
    </div>

     <form action="fmenu.php?hal=ekurir" method="post" onsubmit="return cekform()">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="11%">Tanggal</td>
    <td width="26%"><label for="tglresi"></label>
      <input name="tglresi" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="tglresi" value="<?php echo $hari_ini ?>" size="12" /></td>
    <td width="13%">&nbsp;</td>
    <td width="14%">&nbsp;</td>
    <td width="36%">&nbsp;</td>
  </tr>
  <tr>
    <td>Pelanggan</td>
    <td><label for="nmcust">
      <select name="nmcust" id="nmcust" >
        <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CustomerNo,CustomerName from tblcustomer order by CustomerName ",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
        </select>
      </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama dituju</td>
    <td><input name="nmrecv"  type="text" id="nmrecv" size="50" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><label for="ketisi"></label>      <label for="berat"></label></td>
  </tr>
  <tr>
    <td>alamat</td>
    <td><label for="nmrecv">
      <textarea name="alrecv" id="alrecv" cols="45" rows="3"></textarea>
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td>Kota tujuan</td>
    <td><select name="cbdest" id="cbdest">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblcity order by CityName",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>layanan</td>
    <td><select name="service" id="service">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select ServiceId,ServiceName from tblservice order by ServiceId ",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>berat</td>
    <td><input  name="berat" type="text" id="berat" value="1" size="6" />
Koli/Qty
  <input  name="qty" type="text" id="qty" value="1" size="4" /></td>
    <td>Lamp.DO 1#:</td>
    <td>Lamp.DO 2#:</td>
    <td>Lamp.DO 3#:</td>
  </tr>
  <tr>
    <td><p>ket. isi</p></td>
    <td><input name="ketisi" type="text"  id="ketisi" size="30" maxlength="50" /></td>
    <td><input name="ketisi2" type="text"  id="ketisi2" size="20" maxlength="50" /></td>
    <td><input name="ketisi3" type="text"  id="ketisi3" size="20" maxlength="50" /></td>
    <td><input name="ketisi4" type="text"  id="ketisi4" size="20" maxlength="50" /></td>
  </tr>
  <tr>
    <td>Pembayaran</td>
    <td><select name="jnsbayar" id="jnsbayar" >
      <option value="0">Cash</option>
      <option value="1" selected="selected">Credit</option>
      <option value="2">COD</option>
    </select></td>
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
    <td><input type="submit" name="btsave" id="btsave" value="Save/Rekam" />
      <input type="reset" name="btcancel" id="btcancel" value="Reset/Clear" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  </table>

  </form>
</div>    
<div style="margin-bottom:10px">
  </br>
  <?php include('lihatisi_resi.php'); ?>
</div> 
</body>
</html>
