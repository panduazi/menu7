<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=resi_no_validasi.xls');
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
            font-size:5mm;
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
	
	session_start();
	$user = $_SESSION['cusername'];
	$loc = $_SESSION['cloc'];

    $query = '';
    $query .= "SELECT tblconnote.*,
                ConnoteBillAmount-ConnoteBillDisc+ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther as beakirim,
                if(ConnotePayment=1,'CREDIT',if(ConnotePayment=2,'COLLECT','FOC')) as bayar,
                tblcity_newpsb.KOTA AS Kota,
                tblservice.ServiceName AS Service,
                tblcp_code.cpstatus_name AS CPCODE
                FROM tblconnote
                LEFT JOIN tblcity_newpsb ON tblconnote.ConnoteDest=tblcity_newpsb.REC_ID
                LEFT JOIN tblservice ON tblconnote.ConnoteService=tblservice.id
                LEFT JOIN tblcp_code ON tblconnote.ConnoteLastStatus=tblcp_code.cpstatus_ID
                where tblconnote.ConnoteLocation=$loc AND ConnoteValid<>'Y'
                ORDER BY ID DESC";

	$rs = $koneksi->query($query);
	
    if(mysqli_num_rows($rs) == 0){
        echo 'Tidak Ada Data !';
        die();
    }?>

<body>
    <div id="printable">
        <table border='0' style="font-size:0.8em;border-collapse: collapse;" cellpadding="5" width="100%">
            <tr>
                <th>No</th>
                <th field="ConnoteDate">TANGGAL</th>
                <th field="ConnoteNo">NO. AWB</th>
                <th field="ConnoteCustName">NAMA PENGIRIM</th>
                <th field="ConnoteRecvName">NAMA DITUJU</th>
                <th field="Kota">KOTA</th>
                <th field="Service">LAYANAN</th>
                <th field="ConnoteWeight" formatter="formatrp"  align="right">BERAT</th>
                <th field="bayar">JENIS</th>
                <th field="beakirim" formatter="formatrp"  align="right">BEA KIRIM</th>

            </tr>
            <?php
                $no = 1;
                while($data_connote = mysqli_fetch_object($rs)){            
                $subtotal = ($data_connote->ConnoteBillAmount - $data_connote->ConnoteBillDisc) + $data_connote->ConnoteBillPack + $data_connote->ConnoteBillInsurance + $data_connote->ConnoteBillOther;
                if($data_connote->ConnoteWeight > 0)
                {
                    $fix_w = $data_connote->ConnoteWeight;
                }else{
                    $fix_w = $data_connote->ConnoteWeight;
                }
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $data_connote->ConnoteDate ?></td>
                    <td><?php echo $data_connote->ConnoteNo ?></td>
                    <td><?php echo $data_connote->ConnoteCustName ?></td>
                    <td><?php echo $data_connote->ConnoteRecvName ?></td>
                    <td><?php echo $data_connote->Kota ?></td>
                    <td><?php echo $data_connote->Service ?></td>
                    <td><?php echo $data_connote->ConnoteWeight ?></td>
                    <td><?php echo $data_connote->bayar ?></td>
                    <td><?php echo $data_connote->beakirim ?></td>
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