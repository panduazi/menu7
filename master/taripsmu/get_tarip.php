<?
    include('../../config/koneksi.php');
    $rs = mysql_query('select * from tbAirLineDest order by VENDOR,KODE');
    $result = array();
    while($row = mysql_fetch_object($rs)){
        array_push($result, $row);
    }
    echo json_encode($result);
?>	