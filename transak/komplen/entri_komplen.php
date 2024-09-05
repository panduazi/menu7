<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
   
 function carikota($cdest) {
    include('config/koneksi.php'); 
	$fsql=mysql_query("select * from tblCity where CityId=$cdest");
	$fhasil=mysql_fetch_array($fsql);
	$fketemu=mysql_num_rows($fsql);
	if ($fketemu>0) {
		$ckota=$fhasil['CityName'];
	}
	else {
		$ckota='NA#';
	}
 	Return $ckota;
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
 $ckey='';
 $_SESSION['MM_nocust']='';
 
 //kalau user cari no awb
 if (isset($_POST['btcariawb'])) {
	$noawb=$_POST['edawb'];
    include('config/koneksi.php'); 
	$sql=mysql_query("select * from tblConnote where ConnoteNo='$noawb'");
	$hasil=mysql_fetch_array($sql);
	$ketemu=mysql_num_rows($sql);
	if ($ketemu>0) {
		session_start();
		$_SESSION['MM_noawb']=$noawb;
		$_SESSION['MM_nocust']=$hasil['ConnoteCustNo'];
		$_SESSION['MM_nmcust']=$hasil['ConnoteCustName'];
		$nocust=$hasil['ConnoteCustNo'];
		$tglawb=$hasil['ConnoteDate'];
		$nmcust=$hasil['ConnoteCustName'];
		$nmrecv=$hasil['ConnoteRecvName'];
		$alrecv=$hasil['ConnoteRecvAddr1'];
		$isi=$hasil['ConnoteContents'];
		$brt=$hasil['ConnoteWeight'];
		$byk=$hasil['ConnoteQty'];
		$kota=carikota($hasil['ConnoteDest']);
	}
 }
 
 //kalau user tekan tombol rekam 
 if (isset($_POST['btrekam'])) {
	session_start();
	$nopod=$_SESSION['MM_noawb'];
	$person=$_POST['person'];
	$cbjenis1=$_POST['cbjenis'];
	$ketkomp1=$_POST['ketkomplen'];
	$cbjenis2=$_POST['cbjenis2'];
	$ketkomp2=$_POST['ketkomplen2'];
	//cari di master complen ....INSERT atau UPDATE
    //include('config/koneksi.php'); 
	//$sql=mysql_query("select * from tblComplainMaster where ComplainPOD='$nopod'");
	//$hasil=mysql_fetch_array($sql);
	//kalau belum ada di INSERT
    //proses di MASTER

    $q0="INSERT IGNORE into tblComplainMaster(ComplainPOD, ComplainDate, ComplainStatus, ComplainAction, RecId1, RecId2, CreateBy,ModiBy) VALUES('$nopod',now(),$cbjenis1,$cbjenis2,now(),now(),'$cuser','$cuser')";
  	include('config/koneksi.php');	
  	$r=mysql_query($q0) or die(mysql_error());			


	//isi pada tabel complen detail
    $q1 = "INSERT INTO tblComplainDetail(ComplainKonosNo, ComplainPerson, ComplainJenis,ActionDesc, ActionDate,  RecId, CreateBy) VALUES ('$nopod','$person.',$cbjenis2, '$ketkomp2', now(),now(),'$cuser')";	
  	include('config/koneksi.php');	
  	$r=mysql_query($q1) or die(mysql_error());
      	
 }
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Entry Baging</title>
 <script>
  function cekform()
  {
   if (document.getElementById('person').value=='')
    {
	 alert('Nama penelpon/person masih kosong ...');
	 return false;
	}
   if (document.getElementById('cbjenis').value=='')
    {
	 alert('Jenis keluhan belum dipilih  ...');
	 return false;
	}
   if (document.getElementById('cbjenis2').value=='')
    {
	 alert('Jenis tindakan belum dipilih ...');
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

 <form action="fmenu.php?hal=komplen" method="post" enctype="multipart/form-data" >
 <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td style="font-size:16px;" colspan="3"><h2>Entry Complain Customer / Keluhan Pelanggan</h2></td>
    <td align="right" style="font-size:9px" width="31%" >No AWB
      <input type="text" name="edawb" id="edawb" />
      <input type="submit" name="btcariawb" id="btcariawb" value="Cari" />
    </td>
    </tr>
  <tr>
    <td colspan="4"><hr></td>
    </tr>
 </table>
 </form>
    
<form action="fmenu.php?hal=komplen" method="post" enctype="multipart/form-data"  onsubmit="return cekform()">
 <table width="100%" border="0" cellspacing="0" cellpadding="1">    
  <tr>
    <td colspan="2"><strong>DETAIL CONNOTE/AWB :</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="14%">No AWB / Connote</td>
    <td width="44%">: <strong><? echo $noawb ?></strong> Tanggal : <strong><? echo $tglawb ?></strong></td>
    <td width="17%">Keterangan isi</td>
    <td width="25%">: <strong><? echo $isi ?></strong></td>
    </tr>
  <tr>
    <td>Nama Pengirim</td>
    <td>: <strong><? echo $nmcust ?></strong></td>
    <td>Berat (kg)</td>
    <td>: <strong><? echo $brt ?></strong></td>
    </tr>
  <tr>
    <td>ALamat</td>
    <td valign="top">: <strong><? echo $alcust ?></strong></td>
    <td>Koli / Pcs</td>
    <td>: <strong><? echo $byk ?></strong></td>
    </tr>
  <tr>
    <td>Nama dituju</td>	
    <td>: <strong><? echo $nmrecv ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>Alamat Tujuan</td>
    <td>: <strong><? echo $alrecv ?></strong></td>
    <td colspan="2">* Lihat <a href="report/lacakawb.php?id=<? echo $noawb ?>" target="_blank">detail tracking</a> atau posisi kiriman</td>
    </tr>
  <tr>
    <td>Kota tujuan</td>
    <td valign="top">: <strong><? echo $kota ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td colspan="4"><hr></td>
    </tr>
  <tr>
    <td colspan="2"><strong>CATAT KELUHAN &amp; TINDAKAN :</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Person</td>
    <td><input type="text" name="person" id="person"></td>
    <td>Jenis Tindakan</td>
    <td><select name="cbjenis2" id="cbjenis2">
        <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select * from tblComplainAction order by ComplainActId ",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select>
    </td>
  </tr>
  <tr>
    <td>Jenis keluhan</td>
    <td><select name="cbjenis" id="cbjenis">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select * from tblComplainJenis order by ComplainJnsId ",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select></td>
    <td>Catatan tindakan</td>
    <td rowspan="2"><textarea name="ketkomplen2" cols="30" rows="2" id="ketkomplen2"></textarea></td>
  </tr>
  <tr>
    <td>Keterangan</td>
    <td rowspan="2">       
      <textarea name="ketkomplen" cols="50" rows="2" id="ketkomplen"></textarea>
    </td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="submit" name="btrekam" id="btrekam" value="Rekam Data Complain" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
    </tr>
  
  </table>
</form>
<div>
<?php include('lihatisi_komplen.php'); ?>
</div>  
</body>
</html>


