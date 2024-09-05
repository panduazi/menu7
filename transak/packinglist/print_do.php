<?php
 session_start();
 $location = $_SESSION['clocation'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
 $office = $_SESSION['coffice'];
 $codeorig = $_SESSION['corigincode'];
 $nameorig = $_SESSION['coriginname'];

 $no=$_GET['nodo'];
 include('../../config/koneksi.php');
 $sql=mysql_query("SELECT * FROM tblproject_master left join tblcustomer on PCustNo=CustomerNo WHERE PNo='$no'");
 $hasil=mysql_fetch_array($sql);
 $ketemu=mysql_num_rows($sql);
 if($ketemu==1){
	$nmcust=$hasil[CustomerName];
	$alcust=$hasil[CustomerAddr];
	$tlcust=$hasil[CustomerTelp];
	$nmrecv=$hasil[PRecvName];
	$alrecv=$hasil[PRecvAddr];
	$tlrecv=$hasil[PRecvTelp];
	$cprecv=$hasil[PRecvPerson];
	
 }
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Print Delivery Order</title>
 <style>
   body {
	background-color: #FFFFFF;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 12px;
   }
   </style>

</head>

<body  onload="window.print()" onfocus="window.close() >
<div id="header">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="font-family:'Free 3 of 9'; font-size:24px"><? echo $no ?></td>
  </tr>
  <tr>
    <td width="44%"><strong><? echo $nmcust ?></strong></td>
    <td width="1%">&nbsp;</td>
    <td width="19%">No Delivery Order (DO)</td>
    <td width="1%">: </td>
    <td width="35%"><? echo $no ?></td>
  </tr>
  <tr>
    <td valign="top" rowspan="4"><? echo $alcust ?></td>
    <td>&nbsp;</td>
    <td>Nama</td>
    <td>: </td>
    <td><? echo $nmrecv ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Alamat Kirim</td>
    <td valign="top">: </td>
    <td valign="top" rowspan="3"><? echo $alrecv ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td><? echo $tlcust ?></td>
    <td>&nbsp;</td>
    <td>Telpon</td>
    <td>: </td>
    <td><? echo $tlrecv ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>U.p</td>
    <td>: &nbsp;</td>
    <td><? echo $cprecv ?></td>
  </tr>
  <tr>
    <td colspan="5"><hr /></td>
  </tr>
</table>
</div>
<div id="isi">
 <table width="100%" border="0" cellpadding="1" cellspacing="0">
 <tr>
    <td width="3%">NO.</td>
    <td width="10%">KODE BARANG</td>
    <td width="30%">NAMA BARANG</td>
    <td width="20%">UNIT</td>
    <td align="right" width="10%">JUMLAH</td>
 </tr>
 <tr>
    <td colspan="5"><hr /></td>
 </tr> 
  <?php 
	//siapkan isi DO
 	include('../../config/koneksi.php');
 	$sql1=mysql_query("SELECT * FROM tblproject_detail left join tblproject_item on DOitemno=ItemCode WHERE DOpno='$no'");
	$i=1;
	while ($row=mysql_fetch_array($sql1)){
	  $nqty=number_format($row[DOitemqty]);
      echo "<td>$i</td>";
      echo "<td>$row[DOitemno]</td>";
      echo "<td>$row[ItemName]</td>";
      echo "<td>$row[ItemUnit]</td>";
      echo "<td align='right'>$nqty</td>";
      echo "</tr>";
	  $i++;
	}
	?>
 <tr>
    <td colspan="5">&nbsp;</td>
 </tr> 
 <tr>
    <td colspan="5"><hr /></td>
 </tr> 
 <tr>
    <td>WareHouse Staff,</td>
    <td>&nbsp;</td>
    <td>Penerima,</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
 </tr> 
</table>
</div>

</body>
</html>