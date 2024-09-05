<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    $date1 = $_GET['date1'];
    $date2 = $_GET['date2'];
    $ckunci = date('YmdHis');

	include('../../config/koneksi.php');
 
    //tampilkan temporer hasil update
    $tdb=0;
    $tcr=0;
    $rs = $koneksi->query("SELECT JournalAccNo,AccName,if(JournalType=0,sum(JournalValue),0) as DEBET,
                            if(JournalType=1,sum(JournalValue),0) as CREDIT 
                        FROM tblJournal LEFT JOIN tblCOA ON JournalAccNo=AccNo
                        WHERE Journaldate between '$date1' and '$date2' 
                        GROUP BY JournalAccNo
                    ");
	$row = mysqli_num_rows($rs);
	$result["total"] = $row;
	$rs = $koneksi->query("SELECT JournalAccNo,AccName,if(JournalType=0,sum(JournalValue),0) as DEBET,
                            if(JournalType=1,sum(JournalValue),0) as CREDIT 
                        FROM tblJournal LEFT JOIN tblCOA ON JournalAccNo=AccNo
                        WHERE Journaldate between '$date1' and '$date2' 
                        GROUP BY JournalAccNo
                        ");
	$items = array();
	while($row = mysqli_fetch_object($rs)){
        $row->DEBET = number_format($row->DEBET,1);
        $row->CREDIT = number_format($row->CREDIT,1);
  		array_push($items, $row);
	}
	$result["rows"] = $items;
    echo json_encode($result);
?>