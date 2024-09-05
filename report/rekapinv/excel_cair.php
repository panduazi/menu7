<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=rekap_invoice_cair.xls');
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
	
$date1 = $_GET['per1'];
$date2 = $_GET['per2'];

$query = '';

$query .="select * from tblBayarPiutang	
            LEFT JOIN tblInvoice ON tblBayarPiutang.ByrInvoiceNo=tblInvoice.InvoiceNo
            WHERE ByrDate between '$date1' AND '$date2'";

$rs = $koneksi->query($query);

if(mysqli_num_rows($rs) == 0){
    echo 'Tidak Ada Data !';
    die();
}
?>
<body>
    <div id="printable">
        <table border='1' style="font-size:0.8em;border-collapse: collapse;" cellpadding="5" width="100%">
            <tr>
                <th>No</th>

                <th field="ByrDate">Tgl. Bayar</th>
                <th field="ByrAmmount_IDR"  align="right">Nilai Bayar</th>
                <th field="ByrVoucerNo">No. Jurnal</th>
                <th field="InvoiceNo">No.Invoice</th>
                <th field="InvoiceDate">Tgl.Invoice</th>
                <th field="InvoicePeriode">Periode</th>
                <th field="InvoiceSaldo_IDR" align="right">Sisa Piutang (Rp.)</th>
                <th field="InvoiceCustNo"No. Pelangan</th>
                <th field="InvoiceName">Nama Pelanggan</th>
                <th field="InvoiceAmmount_IDR"  align="right">Nilai (Rp.)</th>
            </tr>
            <?php
                $no = 1;
                while($data_connote = mysqli_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>

                    <td><?php echo $data_connote->ByrDate ?></td>
                    <td align="right"><?php echo $data_connote->ByrAmmount_IDR ?></td>
                    <td><?php echo $data_connote->ByrVoucerNo ?></td>
                    <td><?php echo $data_connote->InvoiceNo ?></td>
                    <td><?php echo $data_connote->InvoiceDate ?></td>
                    <td><?php echo $data_connote->InvoicePeriode ?></td>
                    <td><?php echo $data_connote->InvoiceSaldo_IDR ?></td>
                    <td><?php echo $data_connote->InvoiceCustNo ?></td>
                    <td><?php echo $data_connote->InvoiceName ?></td>
                    <td><?php echo $data_connote->InvoiceAmmount_IDR ?></td>
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