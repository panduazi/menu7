<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=rekap_penjualan_per_pelanggan.xls');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel</title>
    <style>
        body{
            color:000000;
            font-size:4mm;
            font-weight:bold;
            font-family:Arial Narrow;
        }
        @media print
        {
            #non-printable { display: none; }
            #printable { 
                display: block; 
            }
        }
    </style>
</head>
<?php

include('../../config/koneksi.php');
	
$date1 = $_GET['date1'];
$date2 = $_GET['date2'];

$query = '';


if ($date1 >= '2022-09-01'){
$rs=$koneksi->query("SELECT CustomerName,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP
          FROM tblConnote_odisys left join tblCustomer on ConnoteCustNo=CustomerNo 
          WHERE ConnoteDate between '$date1' and '$date2' 
                and ConnoteOrig=11 
                and ConnoteValid=1 
                and ConnoteBillCurrency='IDR' 
          GROUP BY CustomerName ORDER BY NILAI DESC") ;

} else {
$rs=$koneksi->query("SELECT CustomerName,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP
          FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
          WHERE ConnoteDate between '$date1' and '$date2' 
                and ConnoteOrig=11 
                and ConnoteValid=1 
                and ConnoteBillCurrency='IDR' 
          GROUP BY CustomerName ORDER BY NILAI DESC") ;

}

if(mysqli_num_rows($rs) == 0){
    echo 'Tidak Ada Data !';
    die();
}
?>
<body>
    <div id="printable">
        <table border='0' style="font-size:0.8em;border-collapse: collapse;" cellpadding="0">
            <tr>
                <th>No</th>
                <th>NAMA PELANGGAN</th>
                <th>SHIPMENT</th>
                <th>NILAI JUAL (Rp.)</th>
                <th>BERAT (Kg.)</th>
            </tr>
            <?php
                $no = 1;
                while($data_connote = mysqli_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_connote->CustomerName ?></td>
                    <td><?php echo $data_connote->SHIP ?></td>
                    <td><?php echo $data_connote->NILAI ?></td>
                    <td><?php echo $data_connote->BERAT ?></td>
                </tr>
            <?php
                $no++;
                }
            ?>
        </table>
    </div>

<script>
    function printpage(){
        window.print();
    }
</script>
</body>
</html>