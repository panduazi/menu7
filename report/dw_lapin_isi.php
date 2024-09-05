<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=inbound.xls");

session_start();
$location = $_SESSION['clocation'];
$cuser = $_SESSION['cuser'];
$group = $_SESSION['cgroup'];
$office = $_SESSION['coffice'];

 if (isset($_POST['btcari'])){
 	$t1=$_POST['tgl1'];
	$t2=$_POST['tgl2'];
	$nocust=$_POST['cbcust'];
 } else
 {
 	$t1=$tglresi;
	$t2=$tglresi;
	$nocust='';
 }
 include('../config/koneksi.php');
 $sql = mysql_query("SELECT *,if(ConnoteType=1,'P','D') as JENIS FROM tblConnote left join tblCity on ConnoteOrig=CityId WHERE ConnoteDate BETWEEN '$t1' AND '$t2' and ConnoteOrig <> 11");
 
?>
	<table padding="1">
        <thead>
                    <tr>
                        <th align="left">NO. AWB</th>
                        <th align="left">TGL. AWB</th>
                        <th align="left">NAMA PENGIRIM</th>
                        <th align="left">NANAM DITUJU</th>
                        <th align="left">ALAMAT DITUJU</th>
                        <th align="left">ASAL</th>
                        <th align="left">JENIS</th>
                        <th align="left">BERAT</th>
                        <th align="left">KOLI</th>
                        <th align="left">KURIR</th>
                        <th align="left">TGL.TERIMA</th>
                        <th align="left">PENERIMA/KET</th>
                        
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
                        echo "<tr>
                            <td>$r[ConnoteNo]</td>
                            <td>$r[ConnoteDate]</td>
                            <td>$r[ConnoteCustName]</td>
                            <td>$r[ConnoteRecvName]</td>
                            <td>$r[ConnoteRecvAddr1]</td>
                            <td>$r[CityCode]</td>
                            <td>$r[JENIS]</td>
                            <td>$r[ConnoteWeight]</td>
                            <td>$r[ConnoteQty]</td>
                            <td>$r[ConnoteCourierDeli]</td>
                            <td>$r[ConnoteDateDeli]</td>
                            <td>$r[ConnoteDescDeli]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
    