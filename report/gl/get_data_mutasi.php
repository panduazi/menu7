<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    $ckunci = date('YmdHis');

	include('../../config/koneksi.php');
 
 	//Query akun yang yg aktif dan tulis di temporer
    $q0 = $koneksi->query("SELECT JournalAccNo,AccName FROM tblJournal LEFT JOIN tblCOA ON JournalAccNo=AccNo
                        WHERE JournalDate BETWEEN '$date1' AND '$date2' 
                        GROUP BY JournalAccNo"
                    );
    $tdb=0;
    $tcr=0;
    while ($qhsl0 = mysqli_fetch_array($q0)) {
        $noacc=$qhsl0['JournalAccNo'];
        $nmacc=$qhsl0['AccName'];
        $posisi=$qhsl0['Idrec'];
        $tdb=totdb($noacc,$date1,$date2);
        $tcr=totcr($noacc,$date1,$date2);;
        $insert_jurnal=$koneksi->query("INSERT INTO tempJur (tId,tAccNo,tAccName,tAccValueDB,tAccValueCR) VALUES ('$ckunci','$noacc','$nmacc','$tdb','$tcr')");
    }

    /*
    //Query akun yang yg aktif akan di update
    $q1 = $koneksi->query("SELECT JournalAccNo,AccName FROM tblJournal LEFT JOIN tblCOA ON JournalAccNo=AccNo
                        WHERE JournalDate BETWEEN '$date1' AND '$date2' 
                        GROUP BY JournalAccNo"
                        );
    while ($qhsl1 = mysqlI_fetch_array($q1)) {
        //catat no akunnya
        $noacc=$qhsl1['JournalAccNo'];
        //hitung summary untuk DBET
        $q2=$koneksi->query("SELECT sum(JournalValue) AS DB 
                        FROM tblJournal 
                        WHERE JournalType=0 AND JournalAccNo='$noacc' AND JournalDate BETWEEN '$date1' AND '$date2'");
        $h2 = mysqlI_fetch_array($q2);
        $ndebet=$h2['DB'];
        //hitung summary untuk CREDIT
        $q3=$koneksi->query("SELECT sum(JournalValue) AS CR
                        FROM tblJournal 
                        WHERE JournalType=1 AND JournalAccNo='$noacc' AND JournalDate BETWEEN '$date1' AND '$date2'");
        $h3 = mysqlI_fetch_array($q3);
        $ncredit=$h3['CR'];

        //tulis hasil summary di temporer sesuai no acc
        $update_mutasi=mysql_query("UPDATE tempJur 
                                    SET tAccValueDB=$ndebet,
                                    tAccValueCR=$ncredit 
                                    WHERE tAccNo='$noacc' AND tId='$ckunci '");
    }
    */

    //tampilkan temporer hasil update
    $tdb=0;
    $tcr=0;
    $rs = $koneksi->query("SELECT * FROM tempJur WHERE tId='$ckunci'");
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	$rs = $koneksi->query("SELECT * FROM tempJur WHERE tId='$ckunci' ORDER BY IdRec");
	$items = array();
	while($row = mysqli_fetch_object($rs)){
  		array_push($items, $row);
        //$tdb += $row=> tAccValueDB;
        //$tcr += $row=> tAccValueCR;
	}
	$result["rows"] = $items;
    //$result["footer"] = array(
    //    array(		
    //        'tAccNo' => '',
    //        'tAcclDesc' => 'BALANCE',
    //        'tAccValueDB' => $tdb,
    //        'tAccValueCR' => $tcr
    //    )    
    echo json_encode($result);

    function totdb($acc,$tg1,$tg2){
        include('../../config/koneksi.php');
        $q2='';
        $q2=$koneksi->query("SELECT sum(JournalValue) AS DB 
                        FROM tblJournal 
                        WHERE JournalType=0 AND JournalAccNo='$acc' AND JournalDate BETWEEN '$tg1' AND '$tg2'");
        $h2 = mysqli_fetch_array($q2);
        $ndebet=$h2['DB'];
        return $ndebet;
    }    

    function totcr($acc,$tg1,$tg2){
        include('../../config/koneksi.php');
        $q3='';
        $q3=$koneksi->query("SELECT sum(JournalValue) AS CR
                        FROM tblJournal 
                        WHERE JournalType=1 AND JournalAccNo='$acc' AND JournalDate BETWEEN '$tg1' AND '$tg2'");
        $h3 = mysqli_fetch_array($q3);
        $ncredit=$h3['CR'];
        return $ncredit;
    }    


?>