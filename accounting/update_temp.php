<?php 
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');

require '../config/koneksi.php';
$id = intval($_GET['id']);
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

    $update_jurnal = mysql_query("UPDATE tempjur
                                SET tAccNo='$acc',
                                tAccName='$acc_name',
                                tAcclDesc='$desc',
                                tAccValue='$jumlah',
                                tAccType='$type',
                                tAccValueDB='$db',
                                tAccValueCR='$cr',
                                tDate='$date'
                                WHERE Idrec='$id'
                                ");
    if(!$update_jurnal){
        throw new Exception('error update jurnal'.mysql_error());        
    }
    
    
    echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));

}catch(Exception $e){        
    echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage() ));
}

?>