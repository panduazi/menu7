<?php
  session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 $location = $_SESSION['cloc'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['MM_UserGroup'];
 $hari_ini=date('m/d/Y')-1;
 $tglresi=date('m/d/Y')-1;
 $tgl2=date('Y-m-d')-1;   
 
 //---jika tekan TOMBOL Save ----
 if (isset($_POST['btsave'])) {
		$cnoresi = $_POST['noresi'];
		$dtglresi = $_POST['tglresi'];
		$dtgltrm = $_POST['tglresi2'];
		$cnocust = '00.000.00000000';
		$cnmcust = $_POST['nmcust'];
		$cnmrecv = $_POST['nmrecv'];
		$calrecv1 = $_POST['alrecv1'];
		$calrecv2 = $_POST['alrecv2'];
		$calrecv3 = $_POST['alrecv3'];
		$norig = $_POST['cborig'];
		$ndest = $_POST['cbdest'];
		$cketisi = $_POST['ketisi'];
		$nbayar = $_POST['jnsbayar'];
		$nberat = $_POST['berat'];
		$service = $_POST['service'];
		$cnocp = $_POST['cbstatus'];
		$cdesc = $_POST['ketisi'];
		$ckurir = $_POST['cbkurir'];
		$q = "INSERT IGNORE INTO tblConnote(ConnoteNo, ConnoteDate, ConnoteOrig, ConnoteDest, ConnoteTrans, ConnoteCustNo, ConnoteCustName, ConnoteRecvName, ConnoteWeight, ConnoteCourierDeli, ConnoteDateDeli, ConnoteDescDeli, ConnoteStatusDeli, ConnoteRecId1, ConnoteRecId2, ConnoteCreateBy, ConnoteModiBy) VALUES ('".$cnoresi."','".$dtglresi."','".$norig."','".$ndest."',1,'".$cnocust."','".$cnmcust."','".$cnmrecv."','".$nberat."','".$ckurir."','".$dtglresi."','".$cdesc."','".$cnocp."',now(),now(),'".$user."','".$user."')";

		$q1 = "INSERT INTO tblTrackingStatus(StatusKonosNo, StatusPOD, StatusDesc, StatusLocation, StatusDate, RecId, ModiBy) VALUES ('".$cnoresi."','".$cnocp."','".$cdesc."','".$location."','".$dtglresi."',now(),'".$cuser."')";

  include('config/koneksi.php');	
  $r=mysql_query($q) or die(mysql_error());  
  if ($r) {
	//insert juga pada tracking status
	$msg="Berhasil";
    //include('config/koneksi.php');	
    $r=mysql_query($q1) or die(mysql_error());
	
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
	 alert('Nomor AWB masih kosong ...');
	 return false;
	}
   if (document.getElementById('nmcust').value=='')
    {
	 alert('Nama di tuju tidak boleh kosong ...');
	 return false;
	}
   if (document.getElementById('ketisi').value=='')
    {
	 alert('Nama Penerima harus diisi ...');
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
<!-- <div id="er" class="easyui-panel" title="ENTRY AWB CREDIT" style="width:100%;height:500px;padding:5px;"> -->
   <form action="fmenu.php?hal=entrystatus" method="post" onsubmit="return cekform()">
     <table width="100%" border="0" cellspacing="0" cellpadding="2">
       <tr>
    <td width="2%">&nbsp;</td>
    <td colspan="3"><h2>Entry & Update Status Inbound Shipment</h2></td>
    </tr>
       <tr>
         <td>&nbsp;</td>
         <td colspan="3"><hr /></td>
       </tr>
       <tr>
    <td>&nbsp;</td>
    <td width="13%">No. AWB</td>
    <td width="59%"><input name="noresi" type="text"  id="noresi" class="easyui-numberbox"/>
      Tanggal
<input name="tglresi" id="tglresi" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser"  value="<?php echo $hari_ini ?>" /></td>
    <td width="26%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Kota Asal</td>
    <td><select name="cborig" id="cborig" class="easyui-combobox">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblCity order by CityName",$koneksi);
		  echo "<option value='27'>JAKARTA</option>";
   		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama Pengirim</td>
    <td><input name="nmcust"  type="text" id="nmcust" size="50" class="easyui-textbox"/></td>
    <td><label for="ketisi"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama dituju</td>
    <td><input name="nmrecv"  type="text" id="nmrecv" size="50" class="easyui-textbox"/></td>
    <td><label for="harga"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Kota tujuan</td>
    <td><select name="cbdest" id="cbdest" class="easyui-combobox">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblCity order by CityName",$koneksi);
		  echo "<option value='11'>BANDUNG</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Berat (Kg.)</td>
    <td><input  name="berat" type="text" id="berat" value="1" size="5" class="easyui-numberbox"/>
      Koli/Qty
      <input  name="qty" type="text" id="qty" value="1" size="5" class="easyui-numberbox"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jenis Kiriman</td>
    <td><select  name="jenis" id="jenis" class="easyui-combobox">
      <option value="0" selected="selected">DOC</option>
      <option value="1">PAR</option>
      <option value="2">BANK</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama Kurir</td>
    <td><select name="cbkurir" id="cbkurir" class="easyui-combobox">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select PegawaiNama from tblPegawai order by PegawaiNama",$koneksi);
		  echo "<option value=''></option>";
   		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[0]</option>";
		 ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Status kiriman</td>
    <td><select name="cbstatus" id="cbstatus" class="easyui-combobox">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select StatusPODId,StatusPODName from tblStatusPOD order by StatusPODId",$koneksi);
		  echo "<option value='9'>DITERIMA</option>";
   		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama Penerima</td>
    <td><input name="ketisi" type="text"  id="ketisi" size="20"class="easyui-textbox" /> 
      Tanggal 
      <input name="tglresi2" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="tglresi2" value="<?php echo $tglresi ?>" /></td>
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
    <td>&nbsp;</td>
    <td><input type="submit" name="btsave" id="btsave" value="Save/Rekam" />      <input type="reset" name="btcancel" id="btcancel" value="Reset/Clear" /></td>
    <td>&nbsp;</td>
  </tr>
   </table>

  </form>
<!-- </div> -->    
<div style="margin-bottom:10px">
  </br>
  <?php //include('lihatisi_resi.php'); ?>
</div> 
</body>
</html>
