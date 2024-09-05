<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=status_outbound.xls");

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
 if ($nocust=='') {
    if ($t1 >= '2022-09-01') {
         $sql = mysql_query("SELECT *,if(ConnoteType=1,'P','D') as JENIS FROM ((tblConnote_odisys left join tblCity on ConnoteDest=CityId) left join tblCustomer on ConnoteCustNo=CustomerNo) left join tblStatusPOD on ConnoteStatusDeli=StatusPODId WHERE ConnoteDate BETWEEN '$t1' AND '$t2' and ConnoteOrig=11 AND ConnoteValid = 1");

    } else {

         $sql = mysql_query("SELECT *,if(ConnoteType=1,'P','D') as JENIS FROM ((tblConnote left join tblCity on ConnoteDest=CityId) left join tblCustomer on ConnoteCustNo=CustomerNo) left join tblStatusPOD on ConnoteStatusDeli=StatusPODId WHERE ConnoteDate BETWEEN '$t1' AND '$t2' and ConnoteOrig=11 AND ConnoteValid = 1");
    }
 }
 else {
    if ($t1 >= '2022-09-01') {
 $sql = mysql_query("SELECT *,if(ConnoteType=1,'P','D') as JENIS FROM (tblConnote_odisys left join tblCity on ConnoteDest=CityId) left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteDate BETWEEN '$t1' AND '$t2' and ConnoteCustNo='$nocust' and ConnoteOrig=11 AND ConnoteValid = 1");

    } else {
 $sql = mysql_query("SELECT *,if(ConnoteType=1,'P','D') as JENIS FROM (tblConnote left join tblCity on ConnoteDest=CityId) left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteDate BETWEEN '$t1' AND '$t2' and ConnoteCustNo='$nocust' and ConnoteOrig=11 AND ConnoteValid = 1");

    }

 }
 
?>
	<table padding="1">
        <thead>
                    <tr>
                        <th align="left">NO. AWB</th>
                        <th align="left">TGL. AWB</th>
                        <th align="left">ACCT.NO</th>
                        <th align="left">NAMA PENGIRIM</th>
                        <th align="left">REFF.</th>
                        <th align="left">NANAM DITUJU</th>
                        <th align="left">KOTA</th>
                        <th align="left">JENIS</th>
                        <th align="left">BERAT</th>
                        <th align="left">KOLI</th>
                        <th align="left">STATUS</th>
                        <th align="left">TGL.TERIMA</th>
                        <th align="left">JAM</th>
                        <th align="left">PENERIMA</th>
                        <th align="left">DEO</th>
                        <th align="left">TIME</th>
                        
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
                        echo "<tr>
                            <td>$r[ConnoteNo]</td>
                            <td>$r[ConnoteDate]</td>
                            <td>$r[ConnoteCustNo]</td>
                            <td>$r[ConnoteCustName]</td>
                            <td>$r[ConnoteContents]</td>
                            <td>$r[ConnoteRecvName]</td>
                            <td>$r[CityCode]</td>
                            <td>$r[JENIS]</td>
                            <td>$r[ConnoteWeight]</td>
                            <td>$r[ConnoteQty]</td>
                            <td>$r[StatusPODName]</td>
                            <td>$r[ConnoteDateDeli]</td>
                            <td>$r[ConnoteTimeDeli]</td>
							<td>$r[ConnoteDescDeli]</td>
							<td>$r[ConnoteCreateBy]</td>
							<td>$r[ConnoteRecId1]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
    