<?php
include('../../config/koneksi.php');
$kode = $_GET['kode'];
$get = $koneksi->query("SELECT * FROM tblCityPsb WHERE REC_ID='$kode'");
$rows = mysqli_num_rows($get);
if($rows){
    $json = mysqli_fetch_object($get);
    echo json_encode(
        array(
            'success'=>true,
            'message'=>'Berhasil.', 
            'connote'=> $json
        )
    );
} else{
    echo json_encode(
        array(
            'success'=>false,
            'message'=>'Nomor AWB tidak ditemukan.',            
        )
    );
}
  
?>