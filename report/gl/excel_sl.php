<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=sub_ledger.xls');
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

$date1 = $_GET['date1'];
$date2 = $_GET['date2'];
$acc = $_GET['acc'];
$ckunci = date('Ymds');

include('../../config/koneksi.php');

//hitung saldo awal di tbalaccount
$cACC='';
$qawal = $koneksi->query("SELECT * FROM tblCOA WHERE AccNo='$acc'");
$qhsl = mysqli_fetch_array($qawal);
if ($qhsl['AccType']==1) {
    $cACC='CR';}
else {
    $cACC='DB';
}
$acc_name=$qhsl['AccName'];
$nDEBET=$qhsl['AccDEBET'];
$nCREDIT=$qhsl['AccCREDIT'];


//hitung saldo berjalan sebelum tgl diminta
$qlalu = $koneksi->query("select * from tblJournal 
                    where JournalAccNo='$acc'
                    and  Journaldate between '$date1' and '$date2'");
$nsaldo=0;
$tdebetl=0;
$tcreditl=0;
while($qhsl1=mysqli_fetch_array($qlalu)){
    if ($qhsl1['JournalType']==0) {
        $tdebetl=$tdebetl+$qhsl1['JournalValue'];
    } 
    else {
        $tcreditl=$tcreditl+$qhsl1['JournalValue'];
    }
    
}
//hitung saldo awal dari tblaccount dan trx berjalan sblmnya
$tdebetl=$tdebetl+$nDEBET;
$tcreditl=$tcreditl+$nCREDIT;

//isi saldo awal di tabel temporer
$insert_jurnal=$koneksi->query("INSERT INTO tempJur
                (tId,tAccNo,tAccName,tAcclDesc,tAccValue,tAccValueDB,tAccValueCR,tDate)
                VALUES
                ('$ckunci','$acc','$acc_name','SALDO AWAL/SEBELUMNYA','$nsaldo','$tdebetl','$tcreditl','$date1')
            ");


//query jurnal berjalan
$rs0 = $koneksi->query("SELECT * FROM tblJournal
                LEFT JOIN tblCOA ON tblJournal.JournalAccNo=tblCOA.AccNo
                WHERE tblJournal.JOURNALSTATUS > -1
                AND JournalDate between '$date1' AND '$date2' 
                AND JournalAccNo='$acc'");
//isi ke temporer
while($row0 = mysqli_fetch_array($rs0)){
    $noacc=$row0['JournalAccNo'];
    $vocacc=$row0['JournalVoucerNo'];
    $ket=$row0['JournalDesc'];
    $nilai=$row0['JournalValue'];
    $tgl=$row0['JournalDate'];
    $jenis=$row0['JournalType'];
    if ($row0['JournalType']==0) {
        $db=$row0['JournalValue'];
        $cr=0;
    } else {
        $cr=$row0['JournalValue'];
        $db=0;
    }
    $insert_jurnal=$koneksi->query("INSERT INTO tempJur
                                (tId,tVocNo,tAccNo,tAccName,tAcclDesc,tAccValue,tAccType,tAccValueDB,tAccValueCR,tDate)
                                VALUES
                                ('$ckunci','$vocacc','$noacc','$acc_name','$ket','$nilai','$jenis','$db','$cr','$tgl')
                            ");
}

//tampilkan temporer
$query = '';
$query .="SELECT * FROM tempJur WHERE tId='$ckunci' ORDER BY IdRec ";
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
                <th field="tDate">Tanggal</th>
                <th field="tVocNo">No.Voc</th>
                <th field="tAccNo">No.Acc</th>
                <th field="tAccName">Nm.Account</th>
                <th field="tAcclDesc">Keterangan Jurnal</th>
                <th field="tAccValueDB"align="right">Debet</th>
                <th field="tAccValueCR"align="right">Credit</th>
            </tr>
            <?php
                $no = 1;
                while($hsl = mysqli_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $hsl->tDate ?></td>
                    <td><?php echo $hsl->tVocNo ?></td>
                    <td><?php echo $hsl->tAccNo ?></td>
                    <td><?php echo $hsl->tAccName ?></td>
                    <td><?php echo $hsl->tAcclDesc ?></td>
                    <td align="right"><?php echo $hsl->tAccValueDB ?></td>
                    <td align="right"><?php echo $hsl->tAccValueCR ?></td>
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