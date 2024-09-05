<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $cnoinv=$_SESSION[MM_noinv];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Detail Invoice</title>        
        <link rel="stylesheet" href="style/layout.css" type="text/css" />
    </head>
    <body >
<table width="100%" border="0" cellpadding="1" cellspacing="0">
<tr>
    <td><div class="jud_tabel">Tanggal</td>
    <td><div class="jud_tabel">AWB No.</td>
    <td><div class="jud_tabel">NAMA DITUJU</td>
    <td><div class="jud_tabel">SERVICE</td>
    <td><div class="jud_tabel">KOTA</td>
    <td align="right"><div class="jud_tabel" >Berat(kg.)</td>
    <td align="right" class="jud_tabel" >Koli</td>
    <td align="right" class="jud_tabel" >NILAI (Rp.)</td>
</tr>

<?php
	include('config/koneksi.php');
	$sql = mysql_query("SELECT * FROM tempinv WHERE tId='$cnoinv'");
	$i=1;
	while ($row=mysql_fetch_array($sql)){
		$nbrt=number_format($row[tBerat],1);
		$nqty=number_format($row[tBanyak],1);
		$nnilai=number_format($row[tHarga],1);
		
	  	if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      	echo "<tr bgcolor='$bg' >";
      	echo "<td class='isi_tabel' align='left'>$row[tTglKonos]</td>";
      	echo "<td class='isi_tabel' align='left'>$row[tNoKonos]</td>";
      	echo "<td class='isi_tabel' align='left'>$row[tNamaDest]</td>";
      	echo "<td class='isi_tabel' align='left'>$row[tServ]</td>";
      	echo "<td class='isi_tabel' align='left'>$row[tNamaKota]</td>";
      	echo "<td class='isi_tabel' align='right'>$nbrt</td>";
      	echo "<td class='isi_tabel' align='right'>$nqty</td>";
      	echo "<td class='isi_tabel' align='right'>$nnilai</td>";
     	echo "</tr>";
	  	$i++;
	}
?>
</table>
</body>
</html>
