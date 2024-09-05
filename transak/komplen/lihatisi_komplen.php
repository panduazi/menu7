<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $ckey=$_SESSION['MM_noawb'];
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
<table width="100%" border="0" cellpadding="3" cellspacing="0">
<tr>
    <td><div class="jud_tabel">TANGGAL</td>
    <td><div class="jud_tabel">KELUHAN</td>
    <td><div class="jud_tabel">STATUS</td>
    <td><div class="jud_tabel">TINDAKAN/ACTION</td>
    <td><div class="jud_tabel">C.S.O</td>
    
    
</tr>

<?php
    $ckey=$_SESSION['MM_noawb'];
	include('config/koneksi.php');
	$sql = mysql_query("SELECT * FROM (tblComplainDetail left join tblComplainAction on ActionStatus=ComplainActId) left join tblComplainJenis on ComplainJenis=ComplainJnsId WHERE ComplainKonosNo='$ckey' ORDER BY RecId DESC");
	$i=1;
	while ($row=mysql_fetch_array($sql))
	{
		//$nbrt=number_format($row[ManifestWeight],1);
		//$time2=date_format($row[POrderPickupDate],'H:i:s');
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		//echo "<td class='isi_tabel' align='left'>$row[POrderNo]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[RecId]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ComplainJnsKet]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ComplainActKet]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ActionDesc]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[CreateBy]</td>";
      		echo "</tr>";
	  		$i++;
	  	}
	?>
</table>
</body>
</html>
