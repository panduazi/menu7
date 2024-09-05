<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $cmani=$_SESSION['MM_nomani'];
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
    <td><div class="jud_tabel">Date</td>
    <td><div class="jud_tabel">Nama Pegirim</td>
    <td><div class="jud_tabel">Kota Asal</td>
    <td><div class="jud_tabel">Nama dituju</td>
    <td align="right"><div class="jud_tabel">Qty</td>
    <td align="right"><div class="jud_tabel" >Berat(kg.)</td>
    <td align="center" class="jud_tabel" >Cek.Fisik</td>
</tr>

<?php
	include('config/koneksi.php');
	$sql = mysql_query("SELECT if(tblmanifestdetail.ManiQty=1,'Ada','tdk.Ada') AS cisi,tblmanifestdetail.*,tblconnote.*,tblcity.* FROM (tblmanifestdetail left join tblconnote on ManiDtlConnoteNo=ConnoteNo) left join tblcity on ConnoteOrig=CityId where ManiDtlNo='$cmani'");
	$i=1;
	while ($row=mysql_fetch_array($sql))
	{
		$nbrt=number_format($row[ConnoteWeight],1);
		$nqty=number_format($row[ConnoteQty],1);
			
	  		if($i%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
      		echo "<td class='isi_tabel' align='left'>$i</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ManiDtlConnoteNo]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteDate]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteCustName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[CityName]</td>";
      		echo "<td class='isi_tabel' align='left'>$row[ConnoteRecvName]</td>";
      		echo "<td class='isi_tabel' align='right'>$nqty</td>";
      		echo "<td class='isi_tabel' align='right'>$nbrt</td>";
			//transak/baging/print_manifes.php?nobag=$n&dest=$d&tgl=$t','_blank'
            //echo "<td align='center'><a href='transak/baging/print_manifes.php?nobag=".$row[ManiDtlConnoteNo]."' target='_blank'>Ada</a></td>";
			echo "<td align='center'><a href='transak/cekpoint/update_af.php?id=$row[ManiDtlConnoteNo]&isi=$row[ManiQty]'>$row[cisi]</a></td>";			
      		echo "</tr>";
	  		$i++;
	  	}
	?>
</table>
</body>
</html>
