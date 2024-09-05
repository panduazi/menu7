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
  $_SESSION['MM_alrecv1']='';
  $_SESSION['MM_alrecv2']='';
  $_SESSION['MM_alrecv3']='';
  $_SESSION['MM_dest']=11;
  $_SESSION['MM_orig']=27;
  $_SESSION['MM_qty']=1;
  $_SESSION['MM_brt']=1;
    
 
  // --- jika tekan TOMBOL CARI 
  if (isset($_POST['btcarino'])) {
	$ckey=$_POST['noawb'];
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblConnote where ConnoteNo='$ckey'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 	
	  if ($hasil[ConnoteValid]==0) {
	  	session_start();
	  	$_SESSION['MM_noawb']=$hasil[ConnoteNo];
	  	$_SESSION['MM_date']=$hasil[ConnoteDate];
	  	$_SESSION['MM_nmcust']=$hasil[ConnoteCustName];
	  	$_SESSION['MM_nmrecv']=$hasil[ConnoteRecvName];
	  	$_SESSION['MM_type']=$hasil[ConnoteType];
	  	$_SESSION['MM_ketisi']=$hasil[ConnoteContents];
	  	$_SESSION['MM_serv']=$hasil[ConnoteService];
	  	$_SESSION['MM_alrecv1']=$hasil[ConnoteRecvAddr1];
	  	$_SESSION['MM_alrecv2']=$hasil[ConnoteRecvAddr2];
	  	$_SESSION['MM_alrecv3']=$hasil[ConnoteRecvAddr3];
		$_SESSION['MM_dest']=$hasil[ConnoteDest];
		$_SESSION['MM_orig']=$hasil[ConnoteOrig];
	  	$_SESSION['MM_qty']=$hasil[ConnoteQty];
	  	$_SESSION['MM_brt']=$hasil[ConnoteWeight];
		
	  }
	  else {
		echo "<script>window.alert('AWB/POD/Konosemen ini sudah diVALIDASI...!')</script>";
	  }
  	}
	else {
	  echo "<script>window.alert('tidak diketemukan NO AWB ini ...!')</script>";
	  session_start();
	  $_SESSION['MM_noawb']='';
	  $_SESSION['MM_date']='';
	  $_SESSION['MM_nocust']='';
	  $_SESSION['MM_nmcust']='';
	  $_SESSION['MM_refcust']='';
	  $_SESSION['MM_nmrecv']='';
	  $_SESSION['MM_alrecv1']='';
	  $_SESSION['MM_alrecv2']='';
	  $_SESSION['MM_alrecv3']='';
	  $_SESSION['MM_type']=0;
	  $_SESSION['MM_ketisi']='';
	  $_SESSION['MM_serv']=0;
	  $_SESSION['MM_alrecv']='';
	  $_SESSION['MM_dest']=11;
	  $_SESSION['MM_orig']=27;
	  $_SESSION['MM_qty']=0;
	  $_SESSION['MM_brt']=0;
	 
	}
  } //akhir tombol cari no awb
  
 // --- jika tekan SAVE
  if (isset($_POST['btsave'])) {
	$noawb=$_POST['ednoawb'];
	$tgl=$_POST['edtgl'];
	$nocust='00.000.00000000';
	$nmcust=$_POST['nmcust'];
	$reffcust=$_POST['edreffcust'];
	$nmrecv=$_POST['ednmrecv'];
	$alrecv1=$_POST['alrecv1'];
	$alrecv2=$_POST['alrecv2'];
	$alrecv3=$_POST['alrecv3'];
	$serv=$_POST['cbserv'];
	$dest=$_POST['cbdest'];
	$orig=$_POST['cborig'];
	$brt=$_POST['edbrt'];
	$qty=$_POST['edqty'];
	$isi=$_POST['edketisi'];
	$jenis=$_POST['jenis'];
	
    //cari nama dan alamat customer
  	//include('config/koneksi.php');	
  	//$r=mysql_query("SELECT * FROM tblcustomer WHERE CustomerNo='$nocust'") or die(mysql_error());
	//$hasil=mysql_fetch_array($r);
	//if ($hasil) {
	  //$nmcust=$hasil['CustomerName'];
	  //$alcust=$hasil['CustomerAddr1'];
	//} else {
	  //$nmcust='NA#';
	  //$alcust='NA#';
	//}
		
	//ubah connote
	$q = "UPDATE tblConnote SET ConnoteOrig=$orig, ConnoteDest=$dest, ConnoteCustNo='$nocust', ConnoteCustName='$nmcust', ConnoteRecvAddr1='$alrecv1', ConnoteRecvAddr2='$alrecv2', ConnoteRecvAddr3='$alrecv3', ConnoteRecvName='$nmrecv', ConnoteType=$jenis, ConnoteContents='$isi',  ConnoteWeight=$brt, ConnoteQty=$qty, ConnoteRecId2=now(), ConnoteModiBy='$cuser' WHERE ConnoteNo='$noawb'";
  	include('config/koneksi.php');	
  	$r=mysql_query($q) or die(mysql_error());
  } //akhir tombol save  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Validasi AWB</title>
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

<body onLoad="document.frm1.noawb.focus()">
    <div style="margin:10px">
    </div>
     <form name="frm1" action="fmenu.php?hal=updateinb" method="post">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
      
      <tr>
        <td>&nbsp;</td>
        <td width="65%" style="font-size:16px;"><h2>Update Data Inbound</h2></td>
        <td align="right" width="35%">No AWB yg dicari :
          <input name="noawb"  class="easyui-textbox" type="text" id="noawb"/>
        <input name="btcarino" type="submit" value="Cari" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
       <td colspan="2"><hr /></td>
       </tr>
      </table>     
	</form>    

     <form action="fmenu.php?hal=updateinb" method="post" onsubmit="return cekform()">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
    <td>No. AWB</td>
    <td width="51%"><input class="easyui-textbox" name="ednoawb"  type="text" id="ednoawb" readonly="readonly" value="<? echo $_SESSION[MM_noawb] ?>"/>
      Tanggal
      <input name="edtgl" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="edtgl" value="<?php echo $_SESSION[MM_date] ?>" size="12" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="6%">&nbsp;</td>
    <td width="15%">Kota asal</td>
    <td><select name="cborig" id="cborig" class="easyui-combobox">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblCity order by CityName",$koneksi);
  		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  if ($dsales[0]==$_SESSION['MM_orig']) {
		  	echo "<option value='$dsales[0]' selected='selected'>$dsales[1]</option>";
		  }
		  else {
		  	echo "<option value='$dsales[0]'>$dsales[1]</option>";
		  }
		  
		 ?>
    </select></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama Pengirim</td>
    <td><input name="nmcust" id="nmcust" class="easyui-textbox" size="50" value="<? echo $_SESSION[MM_nmcust] ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    
    <td height="32">&nbsp;</td>
    <td>Nama dituju</td>
    <td><input class="easyui-textbox" name="ednmrecv"  type="text" id="ednmrecv" size="50" value="<? echo $_SESSION[MM_nmrecv] ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">Alamat</td>
    <td><input name="alrecv1" id="alrecv1" class="easyui-textbox" type="text" size="75" value="<? echo $_SESSION[MM_alrecv1] ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td><input name="alrecv2" id="alrecv2" class="easyui-textbox" type="text" size="75" value="<? echo $_SESSION[MM_alrecv2] ?>"/></td>
    <td width="27%">&nbsp;</td>
    <td width="1%"><label for="ketisi"></label>      <label for="berat"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="alrecv3" id="alrecv3" class="easyui-textbox" type="text" size="75" value="<? echo $_SESSION[MM_alrecv3] ?>"/></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Kota tujuan</td>
    <td><select name="cbdest" id="cbdest" class="easyui-combobox">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblCity order by CityName",$koneksi);
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
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Berat (Kg)</td>
    <td><input  class="easyui-numberbox" name="edbrt" type="text" id="edbrt" value="<? echo $_SESSION[MM_brt] ?>" size="6" />
Koli/Qty :
  <input  class="easyui-numberbox" name="edqty" type="text" id="edqty" value="<? echo $_SESSION[MM_qty] ?>" size="4" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>&nbsp;</p></td>
    <td>Jenis</td>
    <td><select  name="jenis" id="jenis" class="easyui-combobox">
      <option value="0" selected="selected">DOC</option>
      <option value="1">PAR</option>
      <option value="2">CARD</option>
      <option value="3">REWARD</option>
      <option value="4">BILLING</option>
    </select></td>
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
    <td>&nbsp;</td>
    <td><input type="submit" name="btsave" id="btsave" value="Save/Rekam" />
      <input type="reset" name="btcancel" id="btcancel" value="Reset/Clear" /></td>
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
    <td colspan="5"><hr /></td>
    </tr>
  </table>

  </form>
</body>
</html>
