<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=filesmu_awb.xls");

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
	$sql = mysql_query("SELECT *,if(ConnoteType=0,'D','P') as Type FROM (tblAirLineSMU_AWB LEFT JOIN tblConnote ON AWBNo=ConnoteNo) left join tblCity on ConnoteDest=CityId WHERE ConnoteDate BETWEEN '$t1' AND '$t2' ");

 
?>
	<table border="1">
        <thead>
                    <tr>
                        <th align="left">SMU NO</th>
                        <th align="left">PORT ASAL</th>
                        <th align="left">PORT TUJUAN</th>
                        <th align="left">CONNOTE</th>
                        <th align="left">TGL</th>
                        <th align="left">CUSTOMER</th>
                        <th align="left">QTY</th>
                        <th align="left">BERAT</th>
                        <th align="left">JENIS</th>
                        <th align="left">TUJUAN</th>
                        <th align="left">NAMA TUJUAN</th>
                        
                        
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
						$byk=number_format($r[ConnoteQty]);
						$brt=number_format($r[ConnoteWeight]);
                        echo "<tr>
                            <td>$r[ManifestMAWBNo]</td>
                            <td>$r[ManifestPort]</td>
                            <td>$r[ManifestDest]</td>
                            <td>$r[AWBNo]</td>
                            <td>$r[ConnoteDate]</td>
                            <td>$r[ConnoteCustName]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$brt</td>
                            <td>$r[Type]</td>
                            <td>$r[CityCode]</td>
                            <td>$r[CityName]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
    