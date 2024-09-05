<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=rekap_invoice_periode.xls');
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
            font-size:8px;
            font-weight:bold;
            font-family:Calibri;
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
	
$per1 = $_GET['per1'];
$per2 = $_GET['per2'];

$query = '';

if ($per1 < "2022/01") {
$query .="SELECT InvoiceNo,
            InvoiceDate,
            InvoiceName,
            InvoicePeriode,
            InvoiceAmmount_IDR,
            InvoiceSaldo_IDR,
            InvoiceStatusDate,
            InvoiceStatusKet,
            InvoiceAmmount_IDR+InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR+InvoiceTax_IDR+InvoiceStamp_IDR+InvoiceDisc_IDR as NILAI,
            CustomerSales,CollKurir,CollDateStatus,JBAYAR
            from tblInvoice2021  
            left join tblCustomer ON tblInvoice2021.InvoiceCustNo=tblCustomer.CustomerNo
            left join tblInvoiceStatus ON tblInvoice2021.InvoiceStatus=tblInvoiceStatus.ID
            left join tblCollectorMaster on tblInvoice2021.InvoiceNo=CollInvNo
            WHERE InvoicePeriode between '$per1'  and '$per2'";
} else
{
$query .="SELECT InvoiceNo,
            InvoiceDate,
            InvoiceName,
            InvoicePeriode,
            InvoiceAmmount_IDR,
            InvoiceSaldo_IDR,
            InvoiceStatusDate,
            InvoiceStatusKet,
            InvoiceAmmount_IDR+InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR+InvoiceTax_IDR+InvoiceStamp_IDR+InvoiceDisc_IDR as NILAI,
            CustomerSales,CollKurir,CollDateStatus,JBAYAR
            from tblInvoice  
            left join tblCustomer ON tblInvoice.InvoiceCustNo=tblCustomer.CustomerNo
            left join tblInvoiceStatus ON tblInvoice.InvoiceStatus=tblInvoiceStatus.ID
            left join tblCollectorMaster on InvoiceNo=CollInvNo
            WHERE InvoicePeriode between '$per1'  and '$per2'";    
}


$rs = $koneksi->query($query);

if(mysqli_num_rows($rs) == 0){
    echo 'Tidak Ada Data !';
    die();
}
?>
<body>
    <div id="printable">
        <table border='0' style="font-size:0.8em;border-collapse: collapse;" cellpadding="0" width="100%">
            <tr>
                <th>No</th>
                <th field="InvoiceDate">Tgl.Invoice</th>
                <th field="InvoiceNo">No.Invoice</th>
                <th field="InvoicePeriode">Periode</th>
                <th field="InvoiceName">Nama Pelangga</th>
                <th field="NILAI" align="right">Nilai Invoice (Rp.)</th>
                <th field="InvoiceSaldo_IDR" align="right">Sisa Piutang (Rp.)</th>
                <th field="CustomerSales">Sales</th>
                <th field="JBAYAR">Status</th>
                <th field="InvoiceStatusKet">Keterangan</th>
                <th field="InvoiceStatusDate">Inv. Update</th>
                <th field="CollKurir">Kolektor</th>
                <th field="CollDateStatus">Tgl. Action</th>
            </tr>
            <?php
                $no = 1;
                while($data_connote = mysqli_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_connote->InvoiceDate ?></td>
                    <td><?php echo $data_connote->InvoiceNo ?></td>
                    <td><?php echo $data_connote->InvoicePeriode ?></td>
                    <td><?php echo $data_connote->InvoiceName ?></td>
                    <td align="right"><?php echo $data_connote->NILAI ?></td>
                    <td align="right"><?php echo $data_connote->InvoiceSaldo_IDR ?></td>
                    <td><?php echo $data_connote->CustomerSales ?></td>
                    <td><?php echo $data_connote->JBAYAR ?></td>
                    <td><?php echo $data_connote->InvoiceStatusKet ?></td>
                    <td><?php echo $data_connote->InvoiceStatusDate ?></td>
                    <td><?php echo $data_connote->CollKurir ?></td>
                    <td><?php echo $data_connote->CollDateStatus ?></td>
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