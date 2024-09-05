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
  $tglskr=date('Y-m-d');   
  $bagawal=date('mdhis');
  
  //jika rekam DO dari additem
  if (isset($_POST['btsavedo'])) {
	session_start();
	$nodo=$_SESSION['MM_nodo'];
	$cdate=$_SESSION['MM_tgldo'];
	$nocust=$_SESSION['MM_nocust'];
	$nmcust=$_SESSION['MM_nmcust'];
	$norecv='NA#';
	$nmrecv=$_SESSION['MM_nmrecv'];
	$alrecv=$_SESSION['MM_alrecv'];
	$tlrecv=$_SESSION['MM_tlrecv'];
	$cprecv=$_SESSION['MM_cprecv'];
	$refrecv='';
	include('config/koneksi.php');
	$sql=@mysql_query("SELECT * FROM tblproject_master WHERE Pno='$nodo'");
	$hasil=mysql_num_rows($sql);
	if ($hasil==0){
	 //insert ke tbale master DO	
     $result=@mysql_query("insert into tblproject_master(PNo, PDate, PCustNo, PRecvNo, PRecvName, PRecvAddr, PRecvPerson, PRecvTelp, PRecvReff, POffice, RecId1, CreateBy) VALUES('$nodo', '$cdate', '$nocust', '$norecv', '$nmrecv','$alrecv','$cprecv','$tlrecv','$refrecv','$office',now(),'$cuser' )")  or die(mysql_error());
	 //insert kr tabel detail DO
	$sql=@mysql_query("SELECT * FROM temppacklist WHERE PackNo='$nodo'");
    while ($r = mysql_fetch_array($sql)) {
		$tnodo=$r[PackNo];
		$tnobrg=$r[PackItem];
		$tqtybrg=$r[PackQty];
		$thrgbrg=0;
		$result2=@mysql_query("insert into tblproject_detail(DOpno,DOitemno,DOitemqty,DOitemhrg) values('$tnodo', '$tnobrg', $tqtybrg, $thrgbrg)");		
	}
	 
	}
	
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
</head>
<script>
  function cekform()
  {
   if (document.getElementById('cbcust').value=='')
    {
	 alert('Nama pelanggan belum dipilih ...');
	 return false;
	}
   if (document.getElementById('ednmrecv').value=='')
    {
	 alert('Nama yang dituju belum diisi ...');
	 return false;
	}
   if (document.getElementById('edalrecv').value=='')
    {
	 alert('Alamat tujuan masih kosong ...');
	 return false;
	}
   if (document.getElementById('edcprecv').value=='')
    {
	 alert('Contact person tidak boleh kosong...');
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
<body>
 <div style="margin:10px"></div>
 <form action="?hal=isido" method="post" onsubmit="return cekform()">
   <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td style="font-size:16px;" colspan="5"><h1>Create Delivery Order / Packing List</h1></td>
    </tr>
  <tr>
    <td colspan="5"><hr /></td>
    </tr>
  <tr>
    <td width="21%">Nama Pelanggan</td>
    <td width="44%"><label for="ednmrecv">
      <select name="cbcust" id="cbcust">
        <?php 
         include('config/koneksi.php'); 
	     $sales=mysql_query("select CustomerNo,CustomerName from tblcustomer order by CustomerName",$koneksi);
   	     echo "<option value='0'>--pilih--</option>";
	     while ($dsales=mysql_fetch_array($sales))
	     echo "<option value='$dsales[0]'>$dsales[1]</option>";
        ?>
      </select>
    </label></td>
    <td width="2%">&nbsp;</td>
    <td width="8%">Date</td>
    <td width="25%"><input value="<? echo $tglskr; ?>" class="easyui-datebox" type="text" name="edtgl" data-options="formatter:myformatter,parser:myparser" id="edtgl" /></td>
  </tr>
  <tr>
    <td>Kepada</td>
    <td><label for="edalrecv">
      <input type="text" name="ednmrecv" id="ednmrecv" />
    </label></td>
    <td>&nbsp;</td>
    <td>Reff#</td>
    <td><input type="text" name="edreff" id="edreff" /></td>
  </tr>
  <tr>
    <td valign="top">Alamat</td>
    <td><textarea name="edalrecv" id="edalrecv" cols="50" rows="3"></textarea></td>
    <td>&nbsp;</td>
    <td valign="top">Remark</td>
    <td><textarea name="edmemo" id="edmemo" cols="45" rows="3"></textarea></td>
  </tr>
  <tr>
    <td>Telpon/HP</td>
    <td><input type="text" name="edtlrecv" id="edtlrecv" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Contact Person</td>
    <td><input name="edcprecv" type="text" id="edcprecv" size="30" /></td>
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
    <td><input type="submit" name="btcreate" id="btcreate" value="Create D.O" /></td>
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
    <td colspan="5"><strong>Browse Delivery Order</strong></td>
    </tr>
  <tr>
    <td colspan="5"><hr /></td>
  </tr>
  </table>

</form> 
<div style="margin-bottom:10px">
<?php include('browse_do.php'); ?>
</div>  


</body>
</html>