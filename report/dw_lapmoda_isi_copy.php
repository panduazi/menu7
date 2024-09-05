<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=outbound.xls");

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

 $sql = mysql_query("SELECT ConnoteNo,ConnoteDate,CustomerSales,CustomerName,CityName,ServiceCode,
                     ConnoteQty,ConnoteWeight,ConnoteBillAmount-ConnoteBillDisc as NilaiJual,ManifestMAWBNo,ManifestAirline,ManifestDest                         
                    from tblConnote 
                    left join tblAirLineSMU_AWB_tes on ConnoteNo=AWBNo
                    left join tblCustomer on ConnoteCustNo=CustomerNo
                    left join tblCity on ConnoteDest=CityId
                    left join tblService on ConnoteService=ServiceId
                    WHERE ConnoteDate between '$t1' and '$t2' 
                    and ConnoteOrig=11 
                    and ConnoteValid=1"); 
?>
<table padding="1">
        <thead>
                    <tr>
                    <th align="left">Connote No</th>
                        <th align="left">Tanggal</th>
                        <th align="left">Pengirim</th>
                        <th align="left">Sales</th>
                        <th align="left">Kota Tujuan</th>
                        <th align="left">Serv.</th>
                        <th align="left">Qty</th>
                        <th align="left">Kg.</th>
                        <th align="left">NILAI Rp.</th>
                        <th align="left">SMU/BL/RESI</th>
                        <th align="left">MODA ID</th>
                        <th align="left">DEST</th>
                       
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
                        echo "<tr>
                        <td>$r[ConnoteNo]</td>
                        <td>$r[ConnoteDate]</td>
                        <td>$r[CustomerName]</td>
                        <td>$r[CustomerSales]</td>
                        <td>$r[CityName]</td>
                        <td>$r[ServiceCode]</td>
                        <td>$r[ConnoteQty]</td>
                        <td>$r[ConnoteWeight]</td>
                        <td>$r[ConnoteQty]</td>
                        <td>$r[NilaiJual]</td>
                        <td>$r[ManifestAirline]</td>
                        <td>$r[ManifestDest]</td>
                        </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
    