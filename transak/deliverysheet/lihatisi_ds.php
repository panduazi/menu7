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
<table width="100%" border="0" cellpadding="1" cellspacing="0">
<tr>
    <td><div class="jud_tabel">Delv.Sheet No.</td>
    <td><div class="jud_tabel">Date</td>
    <td><div class="jud_tabel">Kurir</td>
    <td align="center" class="jud_tabel" >Action</td>
</tr>

<?php
	include('config/koneksi.php');
	$sql = mysql_query("SELECT * FROM tbldeliverymaster where DlvShip=$location order by DlvNo DESC LIMIT 20 ");
	$i=1;
	while ($row=mysql_fetch_array($sql))
	{
		$nbrt=number_format($row[ManifestWeight],1);
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		echo "<td class='isi_tabel' align='left'>$row[DlvNo]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[DlvDate]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[DlvKurir]</td>";
			//transak/baging/print_manifes.php?nobag=$n&dest=$d&tgl=$t','_blank'
            echo "<td align='center'><a href='transak/deliverysheet/print_ds.php?nods=".$row[DlvNo]."' target='_blank'>Print</a></td>";
			
			
      		echo "</tr>";
	  		$i++;
	  	}
	?>
</table>
</body>
</html>
