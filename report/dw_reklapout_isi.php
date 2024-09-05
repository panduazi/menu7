<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=rekap_outcust.xls");

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
 }
 include('../config/koneksi.php');
 $sql=mysql_query("select ConnoteCustNo,CustomerName,sum(ConnoteBillAmount) as NILAI, sum(ConnoteBillDisc) as DISC, 
 sum(ConnoteBillAmount-ConnoteBillDisc) as NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) as OTH, 
 sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP, CustomerSales from tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
 where date_format(ConnoteDate,'%Y-%m-%d') between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 and ConnoteBillCurrency='ÍDR'
  group by ConnoteCustNo,CustomerName order by ConnoteCustNo");  
?>
	<table padding="1">
        <thead>
                    <tr>
                        <th align="left">NO. ACC</th>
                        <th align="left">CUSTOMER</th>
                        <th align="left">BERAT</th>
                        <th align="left">SHIP</th>
                        <th align="left">GROSS</th>
                        <th align="left">DISC</th>
                        <th align="left">NET</th>
                        <th align="left">ASS/PAC</th>
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
                        echo "<tr>
                            <td>$r[ConnoteCustNo]</td>
                            <td>$r[CustomerName]</td>
                            <td>$r[BERAT]</td>
                            <td>$r[SHIP]</td>
                            <td>$r[NILAI]</td>
                            <td>$r[DISC]</td>
                            <td>$r[NET]</td>
                            <td>$r[OTH]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
    