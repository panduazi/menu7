<?php
include('../config/koneksi.php');
$kode = $_GET['kode'];
$get = $koneksi->query("SELECT *,InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR AS OTH,
                        InvoiceAmmount_IDR-InvoiceDisc_IDR AS NET
                        FROM tblInvoice 
                        WHERE InvoiceNo='$kode'");
$rows = mysqli_num_rows($get);
if($rows){
    $json = mysqli_fetch_object($get);
    if($json->InvoiceSaldo_IDR <=0 ){
        echo json_encode(
            array(
                'success'=>false,
                'message'=>'Invoice ini sudah LUNAS !',            
            )
        );
    } else {
        echo json_encode(
            array(
                'success'=>true,
                'message'=>'Berhasil.', 
                'inv'=> $json
            )
        );
    }
}else{
    echo json_encode(
        array(
            'success'=>false,
            'message'=>'Nomor INVOICE tidak ditemukan.',            
        )
    );
}
  
?>