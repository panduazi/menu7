<?php
include('../config/koneksi.php');
$kode = $_GET['kode'];
$get = $koneksi->query("SELECT * FROM tblCOA WHERE AccNo='$kode'");
$rows = mysqli_num_rows($get);
if($rows){
    $json = mysqli_fetch_object($get);
    echo json_encode(
        array(
            'success'=>true,
            'message'=>'Berhasil.', 
            'coa'=> $json
        )
    );
    
}else{
    echo json_encode(
        array(
            'success'=>false,
            'message'=>'Nomor COA tidak ditemukan.',            
        )
    );
}
  
?>