<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=filesmu.xls");

session_start();
$location = $_SESSION['clocation'];
$cuser = $_SESSION['cuser'];
$group = $_SESSION['cgroup'];
$office = $_SESSION['coffice'];

 if (isset($_POST['btcari'])){
 	$t1=$_POST['tgl1'];
	$t2=$_POST['tgl2'];
 } else
 {
 	$t1=$tglresi;
	$t2=$tglresi;
	$nocust='NA#';
 }
    include('../config/koneksi.php');
	$sql = mysql_query("SELECT *,ManifestWeight*ManifestTarip+15000 AS JUMLAH, TagihFare-(ManifestWeight*ManifestTarip+15000) as SELISIH, ManifestWeight-TagihWeight as SELISIH0, if(TagihWeight>0,ActualWeight-TagihWeight, ActualWeight-ManifestWeight) as SELISIH1 from tblAirLineSMU where ManifestDate BETWEEN '$t1' AND '$t2' ");

 
?>
	<table border="1">
        <thead>
                    <tr>
                        <th align="left">VENDOR</th>
                        <th align="left">SMU NO</th>
                        <th align="left">AIRLINES</th>
                        <th align="left">TGL</th>
                        <th align="left">DEST</th>
                        <th align="left">QTY</th>
                        <th align="left">BERAT</th>
                        <th align="left">TARIP</th>
                        <th align="left">NILAI</th>
                        <th align="left">VEND.QTY</th>
                        <th align="left">VEND.BERAT</th>
                        <th align="left">VEND.NILAI</th>
                        <th align="left">SELISIH.BERAT</th>
                        <th align="left">SELISIH.NILAI</th>
                        <th align="left">BERAT AWB</th>
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
						$byk=number_format($r[ManifestQty]);
						$brt=number_format($r[ManifestWeight]);
						$tarip=number_format($r[ManifestTarip]);
						$nilai=number_format($r[JUMLAH]);
						$vbyk=number_format($r[TagihQty]);
						$vbrt=number_format($r[TagihWeight]);
						$vnilai=number_format($r[TagihFare]);
						$sbrt=number_format($r[SELISIH0]);
						$snilai=number_format($r[SELISIH]);
						$abrt=number_format($r[ActualWeight]);
                        echo "<tr>
                            <td>$r[ManifestReff]</td>
                            <td>$r[ManifestMAWBNo]</td>
                            <td>$r[ManifestCarier]</td>
                            <td>$r[ManifestDate]</td>
                            <td>$r[ManifestDest]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$tarip</td>
                            <td align='right'>$nilai</td>
                            <td align='right'>$vbyk</td>
                            <td align='right'>$vbrt</td>
                            <td align='right'>$vnilai</td>
                            <td align='right'>$sbrt</td>
                            <td align='right'>$snilai</td>
                            <td align='right'>$abrt</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
    