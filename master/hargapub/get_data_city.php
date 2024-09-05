<?php

include('../../config/koneksi.php');
session_start();

$kode = $_GET['kode'];

$get = $koneksi->query("SELECT * FROM tblkodepos_pliss WHERE POST_CODE='$kode' GROUP BY KECAMATAN");
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