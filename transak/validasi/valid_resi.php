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
  //INITIAL SESSION DULU
  session_start();
  $_SESSION['MM_noawb']='';
  $_SESSION['MM_date']=$tgl2;
  $_SESSION['MM_nocust']='';
  $_SESSION['MM_refcust']='';
  $_SESSION['MM_nmrecv']='';
  $_SESSION['MM_alrecv']='';
  $_SESSION['MM_type']='';
  $_SESSION['MM_ketisi']='';
  $_SESSION['MM_serv']='';
  $_SESSION['MM_alrecv']='';
  $_SESSION['MM_dest']='';
  $_SESSION['MM_qty']=0;
  $_SESSION['MM_brt']=0;
  $_SESSION['MM_hrg']=0;
  $_SESSION['MM_disc']=0;
  $_SESSION['MM_pack']=0;
  $_SESSION['MM_ass']=0;
  $_SESSION['MM_pay']=0;
    
 
  // --- jika tekan TOMBOL CARI 
  if (isset($_POST['btcarino'])) {
	$ckey=$_POST['noawb'];
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblconnote where ConnoteNo='$ckey'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 	
	  if ($hasil[ConnoteInvoice]==0) {
	  	session_start();
	  	$_SESSION['MM_noawb']=$hasil[ConnoteNo];
	  	$_SESSION['MM_date']=$hasil[ConnoteDate];
	  	$_SESSION['MM_nocust']=$hasil[ConnoteCustNo];
	  	$_SESSION['MM_refcust']=$hasil[ConnoteCustReff];
	  	$_SESSION['MM_nmrecv']=$hasil[ConnoteRecvName];
	  	$_SESSION['MM_alrecv']=$hasil[ConnoteRecvAddr];
	  	$_SESSION['MM_type']=$hasil[ConnoteType];
	  	$_SESSION['MM_ketisi']=$hasil[ConnoteContents];
	  	$_SESSION['MM_serv']=$hasil[ConnoteService];
	  	$_SESSION['MM_alrecv']=$hasil[ConnoteRecvAddr];
		$_SESSION['MM_dest']=$hasil[ConnoteDest];
	  	$_SESSION['MM_qty']=$hasil[ConnoteQty];
	  	$_SESSION['MM_brt']=$hasil[ConnoteWeight];
	  	$_SESSION['MM_hrg']=$hasil[ConnoteBillAmount];
	  	$_SESSION['MM_disc']=$hasil[ConnoteBillDisc];
	  	$_SESSION['MM_pack']=$hasil[ConnoteBillPack];
	  	$_SESSION['MM_ass']=$hasil[ConnoteBillInsurance];
	  	$_SESSION['MM_pay']=$hasil[ConnotePayment];
	  }
	  else {
		echo "<script>window.alert('AWB/Konosemen ini sudah dibuatkan INVOICE...!')</script>";
	  }
  	}
	else {
	  echo "<script>window.alert('tidak diketemukan NO AWB ini ...!')</script>";
	  session_start();
	  $_SESSION['MM_noawb']='';
	  $_SESSION['MM_date']='';
	  $_SESSION['MM_nocust']='';
	  $_SESSION['MM_refcust']='';
	  $_SESSION['MM_nmrecv']='';
	  $_SESSION['MM_alrecv']='';
	  $_SESSION['MM_type']=0;
	  $_SESSION['MM_ketisi']='';
	  $_SESSION['MM_serv']=0;
	  $_SESSION['MM_alrecv']='';
	  $_SESSION['MM_dest']=0;
	  $_SESSION['MM_qty']=0;
	  $_SESSION['MM_brt']=0;
	  $_SESSION['MM_hrg']=0;
	  $_SESSION['MM_disc']=0;
	  $_SESSION['MM_pack']=0;
	  $_SESSION['MM_ass']=0;
	  $_SESSION['MM_pay']=0;
	}
  } //akhir tombol cari no awb
  
 // --- jika tekan TOMBOL CARI 
  if (isset($_POST['btsave'])) {
	$noawb=$_POST['ednoawb'];
	$tgl=$_POST['edtgl'];
	$nocust=$_POST['cbcust'];
	$reffcust=$_POST['edreffcust'];
	$nmrecv=$_POST['ednmrecv'];
	$alrecv=$_POST['edalrecv'];
	$serv=$_POST['cbserv'];
	$dest=$_POST['cbdest'];
	$brt=$_POST['edbrt'];
	$qty=$_POST['edqty'];
	$isi=$_POST['edketisi'];
	$jenis=$_POST['cbjenis'];
	$jbyr=$_POST['cbjnsbayar'];
	$hrg=$_POST['edhrg'];
	$pack=$_POST['edpack'];
	$ass=$_POST['edass'];
    //cari nama dan alamat customer
  	include('config/koneksi.php');	
  	$r=mysql_query("SELECT * FROM tblcustomer WHERE CustomerNo='$nocust'") or die(mysql_error());
	$hasil=mysql_fetch_array($r);
	if ($hasil) {
	  $nmcust=$hasil['CustomerName'];
	  $alcust=$hasil['CustomerAddr1'];
	} else {
	  $nmcust='NA#';
	  $alcust='NA#';
	}
		
	//ubah connote
	$q = "UPDATE tblconnote SET ConnoteDate='$tgl',ConnoteDest='$dest',ConnoteCustNo='$nocust', ConnoteCustName='$nmcust', ConnoteCustAddr='$alcust', ConnoteCustReff='$reffcust', ConnoteRecvName='$nmrecv', ConnoteRecvAddr='$alrecv', ConnoteContents='$isi', ConnotePayment=$jbyr, ConnoteWeight=$brt, ConnoteQty=$qty, ConnoteService=$serv, ConnoteBillAmount=$hrg, ConnoteBillPack=$pack, ConnoteBillInsurance=$ass,ConnoteValid=1, ConnoteRecId2=now(), ConnoteModiBy='$cuser' WHERE ConnoteNo='$noawb'";
  	include('config/koneksi.php');	
  	$r=mysql_query($q) or die(mysql_error());
  } //akhir tombol save  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Validasi AWB</title>
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
     <form action="fmenu.php?hal=valid" method="post">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td width="65%" style="font-size:16px;"><h1>Validasi Connote / Resi penjualan</h1></td>
        <td align="right" width="35%">No AWB yg dicari :
          <input name="noawb"  type="text" id="noawb"/>
        <input name="btcarino" type="submit" value="Cari" /></td>
      </tr>
      <tr>
       <td colspan="2"><hr /></td>
       </tr>
      </table>     
	</form>    

     <form action="fmenu.php?hal=valid" method="post" onsubmit="return cekform()">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>No. AWB</td>
    <td><input name="ednoawb"  type="text" id="ednoawb" readonly="readonly" value="<? echo $_SESSION[MM_noawb] ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="10%">Tanggal</td>
    <td width="73%"><input name="edtgl" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="edtgl" value="<?php echo $_SESSION[MM_date] ?>" size="12" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Customer</td>
    <td><select name="cbcust" id="cbcust" >
      <?php 
    	  	include('config/koneksi.php'); 
		  	$sales=mysql_query("select CustomerNo,CustomerName from tblcustomer order by CustomerName ",$koneksi);
   		  	echo "<option value=''>--pilih--</option>";
		  	while ($dsales=mysql_fetch_array($sales))
		  	if ($dsales[0]==$_SESSION[MM_nocust]) {
				echo "<option value='$dsales[0]' selected='selected' >$dsales[0]-$dsales[1]</option>";
				} 
			else {
				echo "<option value='$dsales[0]'>$dsales[0]-$dsales[1]</option>";
				}
		 	?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
    <td height="32">Reff. Customer</td>
    <td><input name="edreffcust"  type="text" id="edreffcust" size="50" value="<? echo $_SESSION[MM_refcust] ?>"/></td>
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
    <td valign="top">Nama dituju</td>
    <td valign="top"><input name="ednmrecv"  type="text" id="ednmrecv" size="50" value="<? echo $_SESSION[MM_nmrecv] ?>"/></td>
    <td>&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="4%"><label for="ketisi"></label>      <label for="berat"></label></td>
  </tr>
  <tr>
    <td>alamat</td>
    <td><textarea name="edalrecv" id="edalrecv" cols="45" rows="3"><? echo $_SESSION[MM_alrecv]?></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td valign="top">Kota tujuan</td>
    <td><select name="cbdest" id="cbdest">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblcity order by CityName",$koneksi);
  		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  if ($dsales[0]==$_SESSION['MM_dest']) {
		  	echo "<option value='$dsales[0]' selected='selected'>$dsales[1]</option>";
		  }
		  else {
		  	echo "<option value='$dsales[0]'>$dsales[1]</option>";
		  }
		  
		 ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>layanan</td>
    <td><select name="cbserv" id="cbserv">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select ServiceId,ServiceName from tblservice order by ServiceId ",$koneksi);
 		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  if ($dsales[0]==$_SESSION[MM_serv]) {
		  	echo "<option value='$dsales[0]' selected='selected' >$dsales[1]</option>";
		  }
		  else {
		  	echo "<option value='$dsales[0]'>$dsales[1]</option>";
		  }
		 ?>
    </select>
      berat : 
      <input  class="easyui-numberbox" name="edbrt" type="text" id="edbrt" value="<? echo $_SESSION[MM_brt] ?>" size="6" />
Koli/Qty : 
<input  class="easyui-numberbox" name="edqty" type="text" id="edqty" value="<? echo $_SESSION[MM_qty] ?>" size="4" /> 
Jenis : 
<select name="cbjenis" id="cbjenis">
<?
  if ($_SESSION[MM_jenis]==0) {
	echo "<option value='0' selected='selected'>DOKUMEN</option>";} else {echo "<option value='0'>DOKUMEN</option>";}
  if ($_SESSION[MM_jenis]==1) {
    echo "<option value='1' selected='selected'>PARCEL</option>";} else {echo "<option value='1'>PARCEL</option>";}
  if ($_SESSION[MM_jenis]==2) {
    echo "<option value='2' selected='selected'>CARD</option>";} else {echo "<option value='2'>CARD</option>";}
  if ($_SESSION[MM_jenis]==3) {
    echo "<option value='3' selected='selected'>GIFT/REWARD</option>";} else {echo "<option value='3'>GIFT/REWARD</option>";}
  if ($_SESSION[MM_jenis]==4) {
    echo "<option value='4' selected='selected'>BILLING</option>";} else {echo "<option value='4'>BILLING</option>";}
  if ($_SESSION[MM_jenis]==9) {
    echo "<option value='9' selected='selected'>PROJECT</option>";} else {echo "<option value='9'>PROJECT</option>";}
  ?>
</select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>ket. isi</td>
    <td><input name="edketisi" type="text"  id="edketisi" size="30" maxlength="50" value="<? echo $_SESSION[MM_ketisi]?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>Pembayaran</p></td>
    <td><select name="cbjnsbayar" id="cbjnsbayar" >
	<?
	if ($_SESSION[MM_pay]==0) { 
      echo '<option value="0" selected="selected">Cash</option>';} else {echo '<option value="0">Cash</option>';}
	if ($_SESSION[MM_pay]==1) { 
      echo '<option value="1" selected="selected">Credit</option>';} else {echo '<option value="1">Credit</option>';}
	if ($_SESSION[MM_pay]==2) { 
      echo '<option value="2" selected="selected">COD</option>';} else {echo '<option value="2">COD</option>';}
	?>  
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
    <td>Bea Kirim</td>
    <td><input class="easyui-numberbox" name="edhrg"  type="text" id="edhrg" value="<? echo $_SESSION[MM_hrg]?>"/></td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Packing</td>
    <td><input  class="easyui-numberbox" name="edpack"  type="text" id="edpack" value="<? echo $_SESSION[MM_pack]?>"/></td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Asuransi</td>
    <td><input  class="easyui-numberbox" name="edass"  type="text" id="edass" value="<? echo $_SESSION[MM_ass]?>"/></td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btsave" id="btsave" value="Save/Rekam" />
      <input type="reset" name="btcancel" id="btcancel" value="Reset/Clear" /></td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><hr /></td>
    </tr>
  </table>

  </form>
</body>
</html>
