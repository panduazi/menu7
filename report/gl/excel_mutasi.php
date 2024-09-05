<?php
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=mutasi_ledger.xls');
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
$ckunci = date('YmdHis');
include('../../config/koneksi.php');

//Query akun yang yg aktif dan tulis di temporer
$q0='';
$q0 = mysql_query("SELECT JournalAccNo,AccName FROM tblJournal LEFT JOIN tblCOA ON JournalAccNo=AccNo
                WHERE JournalDate BETWEEN '$date1' AND '$date2' 
                GROUP BY JournalAccNo"
                 );
while ($qhsl0 = mysql_fetch_array($q0)) {
        $noacc=$qhsl0['JournalAccNo'];
        $nmacc=$qhsl0['AccName'];
        $posisi=$qhsl0['Idrec'];
        $tdb=totdbx($noacc,$date1,$date2);
        $tcr=totcrx($noacc,$date1,$date2);;
        $insert_jurnal=mysql_query("INSERT INTO tempJur_copy (tId,tAccNo,tAccName,tAccValueDB,tAccValueCR) 
                                    VALUES ('$ckunci','$noacc','$nmacc','$tdb','$tcr')");
}

//tampilkan temporer hasil update
$query = '';
$query .="SELECT * FROM tempJur_copy WHERE tId='$ckunci'";
$rs = mysql_query($query);
if(mysql_num_rows($rs) == 0){
    echo 'Tidak Ada Data !';
    die();
}

function totdbx($acc,$tg1,$tg2)
    {
        include('../../config/koneksi.php');
        $q2='';
        $q2=mysql_query("SELECT sum(JournalValue) AS DB 
                        FROM tblJournal 
                        WHERE JournalType=0 AND JournalAccNo='$acc' AND JournalDate BETWEEN '$tg1' AND '$tg2'");
        $h2 = mysql_fetch_array($q2);
        $ndebet=$h2['DB'];
        return $ndebet;
    }    

    function totcrx($acc,$tg1,$tg2)
    {
        include('../../config/koneksi.php');
        $q3='';
        $q3=mysql_query("SELECT sum(JournalValue) AS CR
                        FROM tblJournal 
                        WHERE JournalType=1 AND JournalAccNo='$acc' AND JournalDate BETWEEN '$tg1' AND '$tg2'");
        $h3 = mysql_fetch_array($q3);
        $ncredit=$h3['CR'];
        return $ncredit;
    }    

?>

<body>
    <div id="printable">
        <table border='0' style="font-size:0.8em;border-collapse: collapse;" cellpadding="0" width="100%">
            <tr>
                <th>No</th>
                <th field="tAccNo">No.Account</th>
                <th field="tAccName">Nama Account</th>
                <th field="tAccValueDB"align="right">Debet</th>
                <th field="tAccValueCR"align="right">Credit</th>
            </tr>
            <?php
                $no = 1;
                while($hsl = mysql_fetch_object($rs)){            
            ?>
                <tr>
                    <td><?php echo $no ?></td>
                    <td><?php echo $hsl->tAccNo ?></td>
                    <td><?php echo $hsl->tAccName ?></td>
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