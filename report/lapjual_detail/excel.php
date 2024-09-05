<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=lap_penjualan_detail_percust.xls');
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
$cust = $_GET['cust'];

$query = '';

$query .="SELECT * FROM tblConnote 
        left join tblCustomer on ConnoteCustNo=CustomerNo 
        LEFT JOIN tblCity ON ConnoteDest=CityId 
        WHERE ConnoteDate between '$date1' and '$date2' 
            and ConnoteOrig=11 
            and ConnoteValid=1 
            and ConnoteBillCurrency='IDR' 
            and ConnoteCustNo='$cust' 
        ORDER BY ConnoteDate,ConnoteDest";
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
                <th field="ConnoteNo">AWB NO.</th>
                <th field="ConnoteDate">TANGGAL</th>
                <th field="ConnoteCustName">NAMA PENGIRIM</th>
                <th field="ConnoteRecvName">NAMA DITUJU</th>
                <th field="CityName">KOTA TUJUAN</th>
                <th field="ConnoteContents">ISI KIRIMAN</th>
                <th field="ConnoteQty" align="right">QTY</th>
                <th field="ConnoteWeight" align="right">BERAT Kg.</th>
                <th field="ConnoteBillAmount" align="right">NILAI Rp.</th>
            </tr>
            <?php
                $no = 1;
                while($data_connote = mysql_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_connote->ConnoteNo ?></td>
                    <td><?php echo $data_connote->ConnoteDate ?></td>
                    <td><?php echo $data_connote->ConnoteCustName ?></td>
                    <td><?php echo $data_connote->ConnoteRecvName ?></td>
                    <td><?php echo $data_connote->CityName ?></td>
                    <td><?php echo $data_connote->ConnoteContents ?></td>
                    <td align="right"><?php echo $data_connote->ConnoteQty ?></td>
                    <td align="right"><?php echo $data_connote->ConnoteWeight ?></td>
                    <td align="right"><?php echo $data_connote->ConnoteBillAmount ?></td>
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