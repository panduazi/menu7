<?php 
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');

require '../config/koneksi.php';
$temp_key = $_POST['temp_key'];
$acc = $_POST['acc'];
$acc_name = $_POST['acc_name'];
$desc = $_POST['desc'];
$type = $_POST['type'];
$jumlah = $_POST['jumlah'];
$date = date('Y-m-d');
if($type==0){
    $db = $jumlah;
    $cr = 0;
}else{
    $db = 0;
    $cr = $jumlah;
}

try{

    $insert_jurnal = mysql_query("INSERT INTO tempJur
                                    (tId,tAccNo,tAccName,tAcclDesc,tAccValue,tAccType,tAccValueDB,tAccValueCR,tDate)
                                    VALUES
                                    ('$temp_key','$acc','$acc_name','$desc','$jumlah','$type','$db','$cr','$date')
                                ");
    if(!$insert_jurnal){
        throw new Exception('error insert jurnal'.mysql_error());        
    }
    
    
    echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));

}catch(Exception $e){        
    echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage() ));
}

?>