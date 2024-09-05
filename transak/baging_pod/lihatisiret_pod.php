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
    <td><div class="jud_tabel">Manifest No.</td>
    <td><div class="jud_tabel">Date</td>
    <td><div class="jud_tabel">Asal</td>
    <td><div class="jud_tabel" >Vendor/Cabang</td>
    <td><div class="jud_tabel">Keterangan</td>
    <td align="center" class="jud_tabel" >Action</td>
</tr>

<?php
	include('config/koneksi.php');
	$sql = mysql_query("SELECT * FROM tblmanifest_doc left join tblcity on ManifestFromCity=CityId where ManifestFromCity=$location order by ManifestNo DESC LIMIT 20 ");
	$i=1;
	while ($row=mysql_fetch_array($sql))
	{
		$nbrt=number_format($row[ManifestWeight],1);
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		echo "<td class='isi_tabel' align='left'>$row[ManifestNo]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ManifestDate]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[CityName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ManifestReff]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ManifestMAWBNo]</td>";
			//transak/baging/print_manifes.php?nobag=$n&dest=$d&tgl=$t','_blank'
            echo "<td align='center'><a href='transak/baging_pod/print_manifesret_pod.php?nobag=".$row[ManifestNo]."' target='_blank'>Print</a></td>";
      		echo "</tr>";
	  		$i++;
	  	}
	?>
</table>
</body>
</html>
