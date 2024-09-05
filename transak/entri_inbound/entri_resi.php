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
		$cnocust = substr($_POST['nmcust'],0,15);
		$cnmcust = substr($_POST['nmcust'],16,50);
		$cnmrecv = $_POST['nmrecv'];
		$calrecv1 = $_POST['alrecv1'];
		$calrecv2 = $_POST['alrecv2'];
		$calrecv3 = $_POST['alrecv3'];
		$norig = $_POST['cborig'];
		$ndest = $_POST['cbdest'];
		$cketisi = $_POST['ketisi'];
		$nbayar = $_POST['jnsbayar'];
		$nberat = $_POST['berat'];
		$service = $_POST['cbserv'];
		$jenis = $_POST['jenis'];
		$q = "INSERT IGNORE INTO tblConnote(ConnoteNo, ConnoteDate, ConnoteOrig,ConnoteDest, ConnoteCustNo, ConnoteCustName, ConnoteRecvName, ConnoteRecvAddr1, ConnoteRecvAddr2, ConnoteContents, ConnoteType, ConnoteTrans, ConnoteWeight, ConnoteService, ConnoteRecId1, ConnoteRecId2, ConnoteCreateBy, ConnoteModiBy) VALUES ('".$cnoresi."','".$dtglresi."','".$norig."','".$ndest."','".$cnocust."','".$cnmcust."','".$cnmrecv."','".$calrecv1."','".$calrecv2."','".$cketisi."','".$jenis."',1,'".$nberat."','".$service."',now(),now(),'".$user."','".$user."')";
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
   if (document.getElementById('nmcust').value=='')
    {
	 alert('Nama pengirim masih kosong ...');
	 return false;
	}
   if (document.getElementById('nmrecv').value=='')
    {
	 alert('Nama dituju masih kosong ...');
	 return false;
	}
   if (document.getElementById('noresi').value=='')
    {
	 alert('Nomor AWB masih kosong ...');
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
   <form action="fmenu.php?hal=entryinb" method="post" onsubmit="return cekform()">
     <table width="100%" border="0" cellspacing="0" cellpadding="2">
       <tr>
    <td width="2%">&nbsp;</td>
    <td colspan="3"><h2>Entry Data Inbound</h2></td>
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
           <input name="tglresi" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="tglresi" value="<?php echo $hari_ini ?>" size="12" />
           Kota asal
           <select name="cborig" id="cborig" class="easyui-combobox">
    <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblCity order by CityName",$koneksi);
   		  echo "<option value='27'>JAKARTA</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
  </select></td>
         <td width="26%">&nbsp;</td>
       </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Pengirim</td>
    <td><input name="nmcust" id="nmcust" size="30" class="easyui-textbox"/></td>
    <td><label for="ketisi"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama dituju</td>
    <td><input name="nmrecv"  type="text" id="nmrecv" size="30" class="easyui-textbox"/></td>
    <td><label for="harga"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="2">Alamat dituju</td>
    <td><input name="alrecv1" id="alrecv1" size="75" class="easyui-textbox"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="alrecv2" id="alrecv2" size="75" class="easyui-textbox"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Kota tujuan</td>
    <td><select name="cbdest" id="cbdest"  class="easyui-combobox">
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
    <td><input  name="berat" type="text" id="berat" value="1" size="6" class="easyui-numberbox"/>
Koli/Qty
  <input  name="qty" type="text" id="qty" value="1" size="4" class="easyui-numberbox"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Jenis Kiriman</td>
    <td><select  name="jenis" id="jenis" class="easyui-combobox">
      <option value="0" selected="selected">DOC</option>
      <option value="1">PAR</option>
      <option value="2">CARD</option>
      <option value="3">REWARD</option>
      <option value="4">BILLING</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>keterangan isi</td>
    <td><input name="ketisi" type="text"  id="ketisi" size="50"class="easyui-textbox" /></td>
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
