<?php

    date_default_timezone_set('Asia/Jakarta');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    $acc = $_GET['acc'];
    $ckunci = date('Ymds');
    $nDEBET=0;
    $nCREDIT=0;

	include('../../config/koneksi.php');
 
  	//hitung saldo awal di tbalaccount
    $cACC='';
    $qawal = $koneksi->query("SELECT * FROM tblCOA WHERE AccNo='$acc' ");
    $qhsl = mysqli_fetch_array($qawal);
    if ($qhsl['AccType']== 1) {
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
    while ($hsl1=mysqli_fetch_object($qlalu)) {
        if ($hsl1->JournalType==0) {
            $tdebetl=$tdebetl+$hsl1->JournalValue;
        } 
        else {
            $tcreditl=$tcreditl+$hsl1->JournalValue;
        }
    }
 

    //hitung saldo awal dari tblaccount dan trx berjalan sblmnya
    $tdbl=$tdebetl+$nDEBET;
    $tcrl=$tcreditl+$nCREDIT;

    //isi saldo awal di tabel temporer
    $insert_jurnal=$koneksi->query("INSERT INTO tempJur
                    (tId,tAccNo,tAccName,tAcclDesc,tAccValue,tAccValueDB,tAccValueCR,tDate)
                    VALUES
                    ('$ckunci','$acc','$acc_name','SALDO AWAL/SEBELUMNYA','$nsaldo','$tdbl','$tcrl','$date1')
                   ");

    //query jurnal berjalan
    $rs0 = $koneksi->query("SELECT * FROM tblJournal
                    LEFT JOIN tblCOA ON tblJournal.JournalAccNo=tblCOA.AccNo
                    WHERE tblJournal.JOURNALSTATUS > -1
                    AND tblJournal.JournalDate between '$date1' AND '$date2' 
                    AND tblJournal.JournalAccNo='$acc'");
    //isi ke temporer
    while($row0 = mysqli_fetch_object($rs0)){
        $noacc=$row0->JournalAccNo;
        $vocacc=$row0->JournalVoucerNo;
        $ket=$row0->JournalDesc;
        $nilai=$row0->JournalValue;
        $tgl=$row0->JournalDate;
        $jenis=$row0->JournalType;
        if ($row0->JournalType==0) {
            $db=$row0->JournalValue;
            $cr=0;
        } else {
            $cr=$row0->JournalValue;
            $db=0;
        }
        $insert_jurnal=$koneksi->query("INSERT INTO tempJur
                                    (tId,tVocNo,tAccNo,tAccName,tAcclDesc,tAccValue,tAccType,tAccValueDB,tAccValueCR,tDate)
                                    VALUES
                                    ('$ckunci','$vocacc','$noacc','$acc_name','$ket','$nilai','$jenis','$db','$cr','$tgl')
                                ");
    }


    //tampilkan temporer
    $tdb=0;
    $tcr=0;
    $rs = $koneksi->query("SELECT * FROM tempJur WHERE tId='$ckunci'");
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	$rs = $koneksi->query("SELECT * FROM tempJur WHERE tId='$ckunci' ORDER BY IdRec");
	$items = array();
	while($row = mysqli_fetch_object($rs)){
        $tdb += $row->tAccValueDB;
        $tcr += $row->tAccValueCR;
    	$row->tAccValueDB = number_format($row->tAccValueDB,1);
        $row->tAccValueCR = number_format($row->tAccValueCR,1);
  		array_push($items, $row);
	}
	$result["rows"] = $items;
    echo json_encode($result);
    
?>