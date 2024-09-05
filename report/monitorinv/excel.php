<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=monitoring_invoice.xls');
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

$query .="SELECT *,date_format(CollDateStatus,'%Y-%m-%d') AS TGL from tblCollectorMaster	
        LEFT JOIN tblInvoice ON tblCollectorMaster.CollInvNo=tblInvoice.InvoiceNo
        LEFT JOIN tblCollectorBayar ON tblCollectorMaster.CollStatus=tblCollectorBayar.ID
        WHERE CollDateStatus between '$date1' AND '$date2' ";

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
                <th field="InvoiceName">Pelanggan</th>
                <th field="CustomerSalesFirst">Sales</th>
                <th field="CollInvNo">No.Invoice</th>
                <th field="InvoicePeriode">Periode</th>
                <th field="InvoiceDate">Tgl. Invoice</th>
                <th field="ByrAmmount_IDR" align="right">Bayar Rp.</th>
                <th field="InvoiceSaldo_IDR" align="right">Saldo Rp.</th>
                <th field="TGL">Tgl.Action</th>
                <th field="JBAYAR">Jenis</th>
                <th field="CollKurir">Kolektor</th>
                <th field="CollKet">Keterangan/Uraian</th>
            </tr>
            <?php
                $no = 1;
                while($data_connote = mysql_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_connote->InvoiceName ?></td>
                    <td><?php echo $data_connote->CustomerSalesFirst ?></td>
                    <td><?php echo $data_connote->CollInvNo ?></td>
                    <td><?php echo $data_connote->InvoicePeriode ?></td>
                    <td><?php echo $data_connote->InvoiceDate ?></td>
                    <td align="right"><?php echo $data_connote->ByrAmmount_IDR ?></td>
                    <td align="right"><?php echo $data_connote->InvoiceSaldo_IDR ?></td>
                    <td><?php echo $data_connote->TGL ?></td>
                    <td><?php echo $data_connote->JBAYAR ?></td>
                    <td><?php echo $data_connote->CollKurir ?></td>
                    <td><?php echo $data_connote->CollKet ?></td>
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