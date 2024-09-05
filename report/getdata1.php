<?php
    include('../config/koneksi.php');
    $rs = mysql_query("select * from tblConnote limit 10");
    $result = array();
    while($row = mysql_fetch_object($rs)){
        array_push($result, $row);
    }
     
    echo json_encode($result);
?>