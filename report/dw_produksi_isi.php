<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_produksi_detail.xls");


 if (isset($_POST['btcari'])){
 	$t1=$_POST['tgl1'];
	$t2=$_POST['tgl2'];
 }
 include('../config/koneksi.php');

 $sql = $koneksi->query("SELECT *,if(ConnoteType=1,'P','D') as JENIS FROM (tblConnote left join tblCity on ConnoteDest=CityId) left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteDate BETWEEN '$t1' AND '$t2' and ConnoteCustNo='$nocust' and ConnoteOrig=11 AND ConnoteValid = 1");

 if ($t1 >= '2022-09-01') {
    $textsql = "SELECT ConnoteNo,
        ConnoteDate,
        ConnoteCustNo,
        ConnoteCustName,
        ConnoteWeight As BERAT,
        (ConnoteWeight-1)*PriceExp2+PriceExp1 AS HRG_PUB,
        ConnoteBillAmount AS HRG_JUAL,
        ConnoteBillDisc AS POTONGAN,
        CityCode,
        CityForward,
        CityCountry as KODEPOS,
        CityName,
        CityProvinsi,
        CustomerSales,
        CustomerKelola,
        ServiceName
        FROM tblConnote_odisys 
        left join tblCustomer on ConnoteCustNo=CustomerNo
        left join tblCity on ConnoteDest=CityId
        left join tblPrice on ConnoteDest=PriceCityID
        left join tblService on ConnoteService=ServiceId
        WHERE ConnoteDate BETWEEN '$t1' AND '$t2' 
        and ConnoteOrig=11 
        and ConnoteBillCurrency='IDR'
        and ConnoteValid=1");
 } else {
    $textsql = "SELECT ConnoteNo,
        ConnoteDate,
        ConnoteCustNo,
        ConnoteCustName,
        ConnoteWeight As BERAT,
        (ConnoteWeight-1)*PriceExp2+PriceExp1 AS HRG_PUB,
        ConnoteBillAmount AS HRG_JUAL,
        ConnoteBillDisc AS POTONGAN,
        CityCode,
        CityForward,
        CityCountry as KODEPOS,
        CityName,
        CityProvinsi,
        CustomerSales,
        CustomerKelola,
        ServiceName
        FROM tblConnote 
        left join tblCustomer on ConnoteCustNo=CustomerNo
        left join tblCity on ConnoteDest=CityId
        left join tblPrice on ConnoteDest=PriceCityID
        left join tblService on ConnoteService=ServiceId
        WHERE ConnoteDate BETWEEN '$t1' AND '$t2' 
        and ConnoteOrig=11 
        and ConnoteBillCurrency='IDR'
        and ConnoteValid=1" 
 }
$sql=$koneksi->query($textsql);

?>
	<table padding="1">
        <thead>
                    <tr>
                        <th align="left">NO. AWB</th>
                        <th align="left">TGL. AWB</th>
                        <th align="left">ACCT.NO</th>
                        <th align="left">NAMA PENGIRIM</th>
                        <th align="left">BERAT</th>
                        <th align="left">HARGA PUBLISH</th>
                        <th align="left">HARGA TERJUAL</th>
                        <th align="left">POTONGAN</th>
                        <th align="left">KD. TUJUAN</th>
                        <th align="left">KD. FORWD</th>
                        <th align="left">KD. POS</th>
                        <th align="left">NAMA TUJUAN</th>
                        <th align="left">PROPINSI TUJUAN</th>
                        <th align="left">SALES</th>
                        <th align="left">PENGELOLA</th>
                        <th align="left">PRODUK</th>
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysqli_fetch_array($sql)) {
                        echo "<tr>
                            <td>$r[ConnoteNo]</td>
                            <td>$r[ConnoteDate]</td>
                            <td>$r[ConnoteCustNo]</td>
                            <td>$r[ConnoteCustName]</td>
                            <td>$r[BERAT]</td>
                            <td>$r[HRG_PUB]</td>
                            <td>$r[HRG_JUAL]</td>
                            <td>$r[POTONGAN]</td>
                            <td>$r[CityCode]</td>
                            <td>$r[CityForward]</td>
			                <td>$r[KODEPOS]</td>
                            <td>$r[CityName]</td>
                            <td>$r[CityProvinsi]</td>
                            <td>$r[CustomerSales]</td>
                            <td>$r[CustomerKelola]</td>
                            <td>$r[ServiceName]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
    