<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $cawb=$_SESSION['MM_nobag'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi Akhir</title>        
    <link rel="stylesheet" href="style/layout.css" type="text/css" />
</head>
<body >
<!DOCTYPE html>
<html>
    <head>
        <title>Data Transaksi Akhir</title>        
        <link rel="stylesheet" href="style/layout.css" type="text/css" />
    </head>
    <body >
<table width="100%" border="0" cellpadding="1" cellspacing="0">
<tr>
    <td><div class="jud_tabel">Waktu Order</td>
    <td><div class="jud_tabel">Customer</td>
    <td><div class="jud_tabel">Tempat Pengambilan</td>
    <td><div class="jud_tabel">C.S.O</td>
    <td><div class="jud_tabel">C.S.O 2#</td>
    <td><div class="jud_tabel">Kurir</td>
    <td><div class="jud_tabel">Moda</td>
    <td align="center"><div class="jud_tabel">#</td>
    
    
</tr>

<?php
	include('config/koneksi.php');
	$sql = mysql_query("SELECT * FROM tblpickuporder order by POrderNo DESC LIMIT 50 ");
	$i=1;
	while ($row=mysql_fetch_array($sql))
	{
		$nbrt=number_format($row[ManifestWeight],1);
		//$time2=date_format($row[POrderPickupDate],'H:i:s');
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		//echo "<td class='isi_tabel' align='left'>$row[POrderNo]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[POrderDate]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[POrderCustName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[POrderPUAddr]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[POrderCSO]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[POrderCSO2]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[POrderKurir]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[POrderModa]</td>";
            echo "<td align='center'><a href='fmenu.php?hal=updatepu&id=".$row[POrderNo]."'>update</a></td>";
      		echo "</tr>";
	  		$i++;
	  	}
	?>
</table>
</body>
</html>
