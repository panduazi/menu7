<?php

include('../../config/koneksi.php');
session_start();

$id = $_GET['id'];

$get = $koneksi->query("SELECT * FROM tblkodepos_pliss WHERE REC_ID='$id' GROUP BY KECAMATAN");
$rows = mysqli_num_rows($get);

if($rows != 0){

    $data = mysqli_fetch_object($get);

    echo json_encode(
        array(
            'success'=>true,
            'message'=>'Berhasil.',
            'data_city' => $data
        )
    );
}else{
    echo json_encode(
        array(
            'success'=>false,
            'message'=>'Kode pos tidak ditemukan !',            
        )
    );
}
  
?>