<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=outstading_invoice.xls');
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
	

$query = '';

$query .="select *,InvoiceAmmount_IDR+InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR+InvoiceStamp_IDR-InvoiceDisc_IDR as NILAI,
        date_format(InvoiceStatusDate0,'%Y-%m-%d') as ldate0,date_format(InvoiceStatusDate,'%Y-%m-%d') as ldate1 
        from tblInvoice left join tblCustomer on InvoiceCustNo=CustomerNo
        WHERE InvoiceSaldo_IDR > 0";


$rs = mysql_query($query);

if(mysql_num_rows($rs) == 0){
    echo 'Tidak Ada Data !';
    die();
}
?>
<body>
    <div id="printable">
        <table border='0' style="font-size:0.8em;border-collapse: collapse;" cellpadding="5" width="100%">
            <tr>
                <th>No</th>
                <th field="InvoiceDate">Tgl.Inv</th>
                <th field="InvoiceNo">No.Invoice</th>
                <th field="InvoicePeriode">Periode</th>
                <th field="InvoiceName">Nama pelanggan</th>
                <th field="NILAI" align="right">Saldo Rp.</th>
                <th field="InvoiceSaldo_IDR" align="right">Saldo Rp.</th>
                <th field="ldate0">Tgl.Akhir Kunj.</th>
                <th field="ldate1">Tgl.Realisasi</th>
                <th field="InvoiceStatusKet">Keterangan/Uraian</th>
            </tr>
            <?php
                $no = 1;
                while($data_connote = mysql_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_connote->InvoiceDate ?></td>
                    <td><?php echo $data_connote->InvoiceNo ?></td>
                    <td><?php echo $data_connote->InvoicePeriode ?></td>
                    <td><?php echo $data_connote->InvoiceName ?></td>
                    <td align="right"><?php echo $data_connote->NILAI ?></td>
                    <td align="right"><?php echo $data_connote->InvoiceSaldo_IDR ?></td>
                    <td><?php echo $data_connote->ldate0?></td>
                    <td><?php echo $data_connote->ldate1?></td>
                    <td><?php echo $data_connote->InvoiceStatusKet ?></td>
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