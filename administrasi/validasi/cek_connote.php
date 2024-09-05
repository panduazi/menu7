<?php
include('../../config/koneksi.php');
session_start();
$kode = $_GET['kode'];
$get = $koneksi->query("SELECT tblConnote_odisys.*,tblCityPsb.*,tblService.ServiceName,tblCity.CityName
                        FROM tblConnote_odisys 
                        LEFT JOIN tblService ON tblConnote_odisys.ConnoteService=tblService.ServiceId
                        LEFT JOIN tblCity ON tblConnote_odisys.ConnoteDest=tblCity.CityId
                        LEFT JOIN tblCityPsb ON tblConnote_odisys.ConnoteReDocs=tblCityPsb.POST_CODE
                        WHERE tblConnote_odisys.ConnoteNo='$kode' 
                    ");

$rows = mysqli_num_rows($get);
if($rows){
    $json = mysqli_fetch_object($get);
    if($json->ConnoteStatusInvoice==3 || $json->ConnoteStatusInvoice==4 || $json->ConnoteStatusInvoice==5){
        echo json_encode(
            array(
                'success'=>false,
                'message'=>'Nomor AWB sudah jadi invoice.',            
            )
        );
    }else{
        echo json_encode(
            array(
                'success'=>true,
                'message'=>'Berhasil.', 
                'connote'=> $json
            )
        );
    }
  
}else{
    echo json_encode(
        array(
            'success'=>false,
            'message'=>'Nomor AWB tidak ditemukan.',            
        )
    );
}
  
?>