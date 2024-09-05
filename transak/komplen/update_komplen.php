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
 $ckey=$_SESSION['eorder'];
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y')-1;
 $tgl2=date('Y-m-d');   
 $bagawal=date('mdhis');
 include('config/koneksi.php'); 
 $sql=mysql_query("select * from tblpickuporder left join tblcustomer on POrderCustNo=CustomerNo where POrderNo=$ckey");
 $hasil=mysql_fetch_array($sql);
 $ketemu=mysql_num_rows($sql);
 if ($ketemu>0) {
		$nocust=$hasil['POrderCustNo'];
		$nmcust=$hasil['POrderCustName'];
		$alcust=$hasil['POrderPUAddr']; //alamat untuk pickup
		$piccust=$hasil['CustomerPersonName1'];
		$tlcust=$hasil['CustomerTelp'];
		$catcust=$hasil['POrderMemo'];
		$moda=$hasil['POrderModa'];
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
   if (document.getElementById('alpickup').value=='')
    {
	 alert('Tempat pengambilan Barang belum ditulis ...');
	 return false;
	}
   if (document.getElementById('aldelv').value=='')
    {
	 alert('ALamat tujuan harus diisi ...');
	 return false;
	}
   if (document.getElementById('cbmoda').value=='')
    {
	 alert('MODA pengambilan bekum dipilih ...');
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

 
    
<form action="fmenu.php?hal=pu" method="post" enctype="multipart/form-data"  onsubmit="return cekform()">
 <table width="100%" border="0" cellspacing="0" cellpadding="2">    
  <tr>
    <td style="font-size:16px" colspan="4"><h1>Update Kurir yang akan Pickup</h1></td>
    </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td width="17%">Nama Customer</td>
    <td width="28%" valign="top"><strong><? echo $nmcust ?></strong></td>
    <td width="14%">P.I.C / Telp</td>
    <td width="41%"><strong><? echo $piccust.'/'.$tlcust ?></strong></td>
  </tr>
  <tr>
    <td>Alamat penggambilan</td>
    <td valign="top"><strong><? echo $alcust ?></strong></td>
    <td>Catatan</td>
    <td><strong><? echo $catcust ?></strong></td>
  </tr>
  <tr>
    <td>Moda</td>
    <td valign="top"><strong><? echo $moda ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kurir yg Pickup</td>
    <td><select name="cbkurir" id="cbkurir">
        <?php 
         include('config/koneksi.php'); 
	     $sales=mysql_query("select PegawaiNama,PegawaiDept from tblpegawai order by PegawaiNama",$koneksi);
   	     echo "<option value='0'>--pilih--</option>";
	     while ($dsales=mysql_fetch_array($sales))
	     echo "<option value='$dsales[0]'>$dsales[0]</option>";
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
    <td><input type="submit" name="btUpdatePU" id="btUpdatePU" value="Update Pickup Order"></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="4"><hr></td>
  </tr>
  </table>
</form>
</body>
</html>