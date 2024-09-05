<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=produksi_detail.xls");


 if (isset($_POST['btcari'])){
    $t1=$_POST['tgl1'];
    $t2=$_POST['tgl2'];
 }
 include('../config/koneksi.php');

  $sql = $koneksi->query("SELECT *,if(ConnoteType=1,'P','D') as JENIS FROM (tblConnote left join tblCity on ConnoteDest=CityId) left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteDate BETWEEN '$t1' AND '$t2' and ConnoteOrig=11 AND ConnoteValid = 1"); 
 

  if ($t1>='2022-09-01') {
    $sql = $koneksi->query("SELECT ConnoteNo,
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
        ServiceName,
        if (ConnoteValid=1,'Y','N') as VALID,
        if (ConnoteInvoice=1,'Y','N') as TAGIH,
        SD_InvoiceNo,
        ByrDate
        FROM tblConnote_odisys 
        left join tblCustomer on ConnoteCustNo=CustomerNo
        left join tblCity on ConnoteDest=CityId
        left join tblPrice on ConnoteDest=PriceCityID
        left join tblService on ConnoteService=ServiceId
        left join tblInvoiceDtl on ConnoteNo=SD_ConnoteNo
        left join tblBayarPiutang on SD_InvoiceNo=ByrInvoiceNo
        WHERE ConnoteDate BETWEEN '$t1' AND '$t2' 
        and ConnoteOrig=11 
        and ConnoteBillCurrency='IDR'");

    } else {

    $sql = $koneksi->query("SELECT ConnoteNo,
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
        ServiceName,
        if (ConnoteValid=1,'Y','N') as VALID,
        if (ConnoteInvoice=1,'Y','N') as TAGIH,
        SD_InvoiceNo,
        ByrDate
        FROM tblConnote 
        left join tblCustomer on ConnoteCustNo=CustomerNo
        left join tblCity on ConnoteDest=CityId
        left join tblPrice on ConnoteDest=PriceCityID
        left join tblService on ConnoteService=ServiceId
        left join tblInvoiceDtl on ConnoteNo=SD_ConnoteNo
        WHERE ConnoteDate BETWEEN '$t1' AND '$t2' 
        and ConnoteOrig=11 
        and ConnoteBillCurrency='IDR'");
    }
 
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
                        <th align="left">VALID</th>
                        <th align="left">TAGIH</th>
                        <th align="left">NO.INV</th>
                        <th align="left">TGL.BYR</th>



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
                            <td>$r[VALID]</td>
                            <td>$r[TAGIH]</td>
                            <td>$r[SD_InvoiceNo]</td>
                            <td>$r[ByrDate]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
    </table>