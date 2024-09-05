<?php

include('../../config/koneksi.php');
session_start();

$kode = $_GET['kode'];

$get = $koneksi->query("SELECT * FROM tblcity WHERE ID='$kode'");
$rows = mysqli_num_rows($get);

if($rows){

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
            'message'=>'Kode pos tidak temukan !',            
        )
    );
}
  
?>