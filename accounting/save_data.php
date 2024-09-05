<?php 
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');

require '../../config/koneksi.php';
require '../../counter.php';
session_start();
date_default_timezone_set('Asia/Jakarta');
$time = date('Y-m-d H:i:s');
$date_default = date('Y-m-d');
$user = $_SESSION['cusername'];
$loc = $_SESSION['cloc'];                                         

$no_voc = '';
$no_voc = $_POST['JournalVoucerNo'];
if($no_voc==''){

    $counter = new Counter();
    $counter->counterGenerate('VOC',$loc);
    
    $no_voc = $counter->getCounter();
    if($no_voc=='error'){
        echo json_encode(
            array(
                'success'=>false,
                'errorMsg'=>'Counter Error !',            
            )
        );
        die();
    }
    
}else{

    $cek_no = mysql_query("SELECT * FROM tblJournal WHERE JournalVoucerNo='$no_voc'");


    if(mysql_num_rows($cek_no)){

        echo json_encode(
            array(
                'success'=>false,
                'errorMsg'=>'Nomor Voucer sudah di pakai !',            
            )
        );
        die();
        
    }
}
$date = $_POST['JournalDate'];
$acc = $_POST['JournalAccNo'];
$reff = $_POST['JournalReff'];
$desc = $_POST['JournalDesc'];
$type = $_POST['JournalType'];
$periode = $_POST['JournalPeriode'];
$value = $_POST['JournalValue'];




try{

        

    $insert_jurnal_1 = mysql_query("INSERT INTO tblJournal
                                    (JournalVoucerNo,JournalDate,JournalReff,JournalAccNo,JournalPeriode,JournalDesc,JournalValue,JournalType,CreateTime,JournalLocation,User)
                                    VALUES
                                    ('$no_voc','$date','$reff','$acc','$periode','$desc','$value','$type','$time','$loc','$user')
                                ");
    if(!$insert_jurnal_1){
        throw new Exception('error insert jurnal db '.$koneksi->error);        
    }
    
    if($type==1){
        $type = 0;
    }else{
        $type = 1;
    }
    $insert_jurnal_2 = mysql_query("INSERT INTO tblJournal
                                    (JournalVoucerNo,JournalDate,JournalReff,JournalAccNo,JournalPeriode,JournalDesc,JournalValue,JournalType,CreateTime,JournalLocation,User)
                                    VALUES
                                    ('$no_voc','$date','$reff','$acc','$periode','$desc','$value','$type','$time','$loc','$user')
                                ");
    if(!$insert_jurnal_2){
        throw new Exception('error insert jurnal cr '.$koneksi->error);        
    }
    
    echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));

}catch(Exception $e){        
    echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage() ));

}

?>