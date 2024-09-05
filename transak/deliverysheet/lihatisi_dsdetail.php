<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $cawb=$_SESSION['MM_nods'];
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
    <td><div class="jud_tabel">No.</td>
    <td><div class="jud_tabel">AWB No.</td>
    <td><div class="jud_tabel">PENGIRIM</td>
    <td><div class="jud_tabel">PENERIMA</td>
    <td><div class="jud_tabel" >KOTA</td>
    <td align="right"><div class="jud_tabel" >BERAT (kg.)</td>
</tr>

<?php
	include('config/koneksi.php');
	$sql = mysql_query("SELECT * FROM ((tempbag left join tblconnote on awbno=ConnoteNo) left join tblcity on ConnoteDest=CityId) where bagno='$cawb'");
	$i=1;
	while ($row=mysql_fetch_array($sql))
	{
		$nbrt=number_format($row[ConnoteWeight]);
		$nqty=number_format($row[ConnoteQty]);
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		echo "<td class='isi_tabel' align='left'>$i</td>";
      		echo "<td class='isi_tabel' align='left'>$row[awbno]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteCustName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteRecvName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[CityName]</td>";
      		echo "<td class='isi_tabel' align='right'>$nbrt</td>";
      		echo "</tr>";
	  		$i++;
	  	}
	?>
</table>
</body>
</html>
