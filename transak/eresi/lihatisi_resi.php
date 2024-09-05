<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
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
    <td width="10%"><div class="jud_tabel">CONNOTE#</td>
    <td width="10%"><div class="jud_tabel">DATE</td>
    <td width="15%"><div class="jud_tabel" >PENGIRIM</td>
    <td width="20%"><div class="jud_tabel" >NAMA DITUJU</td>
    <td width="20%"><div class="jud_tabel" >KOTA</td>
    <td width="10%" align="right"><div class="jud_tabel" >BERAT (kg.)</td>
    <td width="10%"><div align="center" class="jud_tabel" >Action</td>
    <td width="20%"><div class="jud_tabel" >user</td>
    
    
  </tr>
      <?php 
		include('config/koneksi.php');
		$sql = mysql_query("SELECT * FROM (tblconnote left join tblservice on ConnoteService=ServiceId) left join tblcity ON ConnoteDest=CityId WHERE ConnoteOrig=$location AND ConnoteValid > -1 ORDER by ConnoteRecId1 DESC LIMIT 10");
	  	$i=1;
	  	while ($row=mysql_fetch_array($sql))
	  	{
	  		$nbrt=number_format($row[ConnoteWeight]);
	  		$nqty=number_format($row[ConnoteQty]);
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		//echo "<td class='isi_tabel' align='right'>$i</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteNo]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteDate]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteCustName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteRecvName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[CityName]</td>";
      		echo "<td class='isi_tabel' align='right'>$nbrt</td>";
            echo "<td align='center'><a href='transak/eresi/print_eawb_garis.php?noresi=".$row[ConnoteNo]."' target='_blank'>Print</a></td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteCreateBy]</td>";
			
			
      		echo "</tr>";
	  		$i++;
	  	}
	?>


</table>
    
    </body>
</html>
