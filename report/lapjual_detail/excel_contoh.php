<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=rekap_penjualan_per_sales.xls');
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

$query .="SELECT *
          FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
          WHERE ConnoteDate between '$date1' and '$date2' 
                and ConnoteOrig=11 
                and ConnoteValid=1 
                and ConnoteBillCurrency='IDR' 
          GROUP BY CustomerSales ORDER BY NILAI DESC" ;

$rs = mysql_query($query);

if(mysql_num_rows($rs) == 0){
    echo 'Tidak Ada Data !';
    die();
}
?>
<body>
    <div id="printable">
        <table border='1' style="font-size:0.8em;border-collapse: collapse;" cellpadding="5" width="100%">
            <tr>
                <th>No</th>
                <th>NAMA SALES</th>
                <th>SHIPMENT</th>
                <th>NILAI JUAL (Rp.)</th>
                <th>BERAT (Kg.)</th>
            </tr>
            <?php
                $no = 1;
                while($data_connote = mysql_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_connote->CustomerSales ?></td>
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