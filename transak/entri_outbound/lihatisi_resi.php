<!DOCTYPE html>
<html>
    <head>
        <title>Data Transaksi Akhir</title>        
        <link rel="stylesheet" href="style/layout.css" type="text/css" />
    </head>
    <body >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td width="3%"><div class="jud_tabel">NO.</td>
    <td width="10%"><div class="jud_tabel">RESI NO.</td>
    <td width="10%"><div class="jud_tabel">TANGGAL</td>
    <td width="10%"><div class="jud_tabel" >PENGIRIM</td>
    <td width="20%"><div class="jud_tabel" >NAMA DITUJU</td>
    <td width="30%"><div class="jud_tabel" >ALAMAT</td>
    <td width="30%"><div class="jud_tabel" >KOTA</td>
    <td width="10%"><div align="right"  class="jud_tabel" >BERAT</td>
    <td width="10%"><div align="right"  class="jud_tabel" >KOLI</td>
    
  </tr>
      <?php 
		include('config/koneksi.php');
		$sql = mysql_query("SELECT ConnoteNo, ConnoteDate, ConnoteCustName, ConnoteRecvName, ConnoteRecvAddr, ConnoteDest, ConnoteWeight, ServiceName,ConnoteQty,ConnoteService,ConnoteCreateBy,ConnoteRecId1,CityName FROM (tblconnote left join tblservice on ConnoteService=ServiceId) left join tblcity ON ConnoteDest=CityId ORDER by ConnoteRecId1 DESC LIMIT 10");
	  	$i=1;
	  	while ($row=mysql_fetch_array($sql))
	  	{
	  		$nbrt=number_format($row[ConnoteWeight]);
	  		$nqty=number_format($row[ConnoteQty]);
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		echo "<td class='isi_tabel' align='left'>$i</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteNo]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteDate]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteCustName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteRecvName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteRecvAddr]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[CityName]</td>";
      		echo "<td class='isi_tabel' align='right'>$nbrt</td>";
      		echo "<td class='isi_tabel' align='right'>$nqty</td>";
      		echo "</tr>";
	  		$i++;
	  	}
	?>


</table>
    
    </body>
</html>
