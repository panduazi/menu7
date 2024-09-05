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
  
  // --- jika tekan TOMBOL SAVE
  if (isset($_POST['btsave'])) {
	$noawb=$_POST['ednoawb'];
	$tgl=$_POST['edtgl'];
	$status=$_POST['cbstatus'];
	$jam=$_POST['edjam'];
	$nmrecv=$_POST['ednmterima'];
	$kurir=$_POST['cbkurir'];
	$nocp=8; //SD-SHIPMENT DELIVERY see tabel tbltrackingcode
  	include('config/koneksi.php');	
  	$r=mysql_query("SELECT * FROM tblstatuspod WHERE StatusPODId=$status") or die(mysql_error());
	$hasil=mysql_fetch_array($r);
	if ($hasil) {$ketstat=$hasil[StatusPODName];} else {$ketstat='';}
	if ($status==9) {
		$desc='Dikirim oleh kurir : '.$kurir.' dan DITERIMA oleh : '.$nmrecv.', pada tgl : '.$tgl.' jam '.$jam;
	} else {
		$desc='Dikirim tgl '.$tgl.' jam '.$jam.' oleh kurir : '.$kurir.' dengan status : '.$nmrecv;
	}
    //cari nomor POD dulu
  	include('config/koneksi.php');	
  	$r=mysql_query("SELECT * FROM tblconnote WHERE ConnoteNo='$noawb'") or die(mysql_error());
	$hasil=mysql_fetch_array($r);
	if ($hasil) {
  		include('config/koneksi.php');	
  		$r1=mysql_query("UPDATE tblconnote SET ConnoteCourierDeli='$kurir', ConnoteDateDeli='$tgl', ConnoteTimeDeli='$jam', ConnoteDescDeli='$nmrecv', ConnoteStatusDeli=$status WHERE ConnoteNo='$noawb'") or die(mysql_error());
		$q = "INSERT INTO tbltrackingstatus(StatusKonosNo, StatusPOD, StatusDesc, StatusOffice, StatusLocation, StatusDate, StatusJam, RecId, ModiBy) VALUES ('".$noawb."','".$nocp."','".$desc."','".$office."','".$location."','".$tgl."','".$jam."',now(),'".$cuser."')";
  include('config/koneksi.php');	
  $r2=mysql_query($q) or die(mysql_error());  	
  
  	
	} else {
	  echo "<script>window.alert('NOMOR RESI/AWB ini tidak diketemukan ...!')</script>";
	}
  } //akhir tombol save  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Shipment Delivery</title>
 <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
 <link rel="stylesheet" type="text/css" href="themes/icon.css">
 <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
 <script type="text/javascript" src="jq/jquery.min.js"></script>
 <script type="text/javascript" src="jq/jquery.easyui.min.js"></script>
 <script>
 function cekform() {
   if (document.getElementById('ednoawb').value=='')
    {
	 alert('Nomor AWB belum dicari ...');
	 return false;
	}
   if (document.getElementById('cbstatus').value=='')
    {
	 alert('Status harus dipilih ...');
	 return false;
	}
   if (document.getElementById('ednmterima').value=='')
    {
	 alert('Nama penerima tidak boleh kosong ...');
	 return false;
	}
     else return true;
 } //akhir fungsi
  
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
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="65%" style="font-size:16px;"><h1>Entry Status Pengiriman / Shipment Delivery</h1></td>
        <td></td>
      </tr>
      <tr>
       <td colspan="2"><hr /></td>
       </tr>
      </table>     

     <form action="fmenu.php?hal=sd" method="post" onsubmit="return cekform()">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>No. AWB</td>
    <td><input name="ednoawb"  type="text" id="ednoawb" /></td>
    <td width="9%">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="13%">Tanggal</td>
    <td width="70%"><input name="edtgl" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="edtgl" value="<?php echo $_SESSION[MM_date] ?>" /> 
    Jam :
    <input name="edjam" type="text" id="edjam" value="12:00"  size="10" /> 
    Kurir : 
    <select name="cbkurir" id="cbkurir" >
      <?php 
    	  	include('config/koneksi.php'); 
		  	$sales=mysql_query("select PegawaiNama from tblpegawai  where PegawaiOffice='$office' and PegawaiDept='OPS'",$koneksi);
   		  	echo "<option value=''>--pilih--</option>";
		  	while ($dsales=mysql_fetch_array($sales))
				echo "<option value='$dsales[0]'>$dsales[0]</option>";
		 	?>
    </select>    
    </td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Status</td>
    <td><select name="cbstatus" id="cbstatus" >
      <?php 
    	  	include('config/koneksi.php'); 
		  	$sales=mysql_query("select StatusPODId,StatusPODName from tblstatuspod  where StatusPODId>3 and StatusPODId<10 order by StatusPODId",$koneksi);
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
    
    <td height="32">Nama Penerima</td>
    <td><input name="ednmterima"  type="text" id="ednmterima" size="50" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input type="submit" name="btsave" id="btsave" value="Save/Rekam" />
      <input type="reset" name="btcancel" id="btcancel" value="Reset/Clear" /></td>
    <td>&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="4%"><label for="ketisi"></label>      <label for="berat"></label></td>
  </tr>
  <tr>
    <td colspan="5"><hr /></td>
  </tr>
  </table>

  </form>
</body>
</html>
