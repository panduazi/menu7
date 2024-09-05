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
 
  //---jika tekan TOMBOL SAVE-BAGING ----
  if (isset($_POST['btsavebag'])) {
      session_start();
	  if ($_SESSION['MM_nods'] != 'NA#') {
   	   $n=$_SESSION['MM_nods'];
	   $d=$_SESSION['MM_nmkurir'];
	   $t=date('Y-m-d');
	   $time=date('Y-m-d G:i:s');
	   //rekam ke tabel deliverysheet
  	   include('config/koneksi.php');	
	   $q = "INSERT IGNORE INTO tbldeliverymaster (DlvNo, DlvDate, DlvKurir, DlvCarier, DlvShip) VALUES ('".$n."','".$tgl2."','".$d."','".$office."','". $location."')";	
	   $r=mysql_query($q) or die(mysql_error());   
	   //insert ke detail manifest
  		$sql=@mysql_query("SELECT * FROM tempbag WHERE bagno='$n'");
    	while ($r = mysql_fetch_array($sql)) {
		 $tawb=$r[awbno];
		 $tnobag=$r[bagno];
		 //entry Status CP
		 $cnocp=6; //WC-With Courier
		 $cdesc='Delv.Sheet NO '.$tnods.' Kurir : '.$d;
		 $cjam=date("G:i:s");
		 $q = "INSERT INTO tbltrackingstatus(StatusKonosNo, StatusPOD, StatusDesc, StatusOffice, StatusLocation, StatusDate, StatusJam, RecId, ModiBy) VALUES ('".$tawb."','".$cnocp."','".$cdesc."','".$office."','".$location."','".$tgl2."','".$cjam."',now(),'".$cuser."')";
  		 include('config/koneksi.php');	
  		 $r=mysql_query($q) or die(mysql_error());
		 //Entry ke Manifest Detail  				
		 $result2=@mysql_query("insert into tbldeliverydetail(DRNo, DRKonosNo) values('$n', '$tawb')");	
		}
   	   //cetak manifest
	   echo "<script> window.open('transak/baging/print_ds.php?nods=$n','_blank') </script>";
	   //-reset session dulu
	   session_start();
       $_SESSION['MM_nods'] = 'NA#';
       $_SESSION['MM_nmkurir'] = 'NA#';
       $_SESSION['MM_kdkurir'] = 'NA#';
	  } //akhir kalau save dipakai ...
  
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
   if (document.getElementById('cbdest').value=='')
    {
	 alert('Nama kota belum dipilih ...');
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

 <form action="fmenu.php?hal=dsdtl" method="post" enctype="multipart/form-data"  onsubmit="return cekform()">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td style="font-size:16px;" colspan="4"><h1>Create Delivery Shee</h1></td>
    </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td width="14%">Nomor</td>
    <td width="72%"><input type="text" name="nobag" />
       Tanggal
      : 
      <input class="easyui-datebox" type="text" name="tglbag" data-options="formatter:myformatter,parser:myparser" value="<?php echo $hari_ini ?>"/></td>
    <td width="7%">&nbsp;</td>
    <td width="7%">&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Kurir</td>
    <td><select name="cbkurir" id="cbkurir">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select PegawaiId,PegawaiNama from tblpegawai WHERE PegawaiOffice='$office' order by PegawaiNama",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
      </select></td>
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
    <td colspan="4"><span style="margin:10px">
      <input type="submit" name="btcreate" id="btcreate" value="Create DeliverySheet" />
      <input type="reset" name="btclear" id="btclear" value="Reset">
    </span></td>
    </tr>
  <tr>
    <td colspan="4"><hr></td>
    </tr>
 </table>
</form>
<div style="margin-bottom:10px">
<?php include('lihatisi_ds.php'); ?>
</div>  
</body>
</html>