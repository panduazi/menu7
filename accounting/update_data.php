<?php 
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');

require '../config/koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');
$time = date('Y-m-d H:i:s');
$date_default = date('Y-m-d');
$user = $_SESSION['cuser'];

$id = intval($_GET['id']);
$no_voc = $_POST['JournalVoucerNo'];

$date = $_POST['JournalDate'];
$acc = $_POST['JournalAccNo'];
$reff = $_POST['JournalReff'];
$desc = $_POST['JournalDesc'];
$type = $_POST['JournalType'];
$periode = $_POST['JournalPeriode'];
$value = $_POST['JournalValue'];

try{
    $update_jurnal = $koneksi->query("UPDATE tblJournal
                                    SET JournalVoucerNo='$no_voc',
                                    JournalDate='$date',
                                    JournalAccNo='$acc',
                                    JournalPeriode='$periode',
                                    JournalDesc='$desc',
                                    JournalValue='$value',
                                    JournalType='$type',                                    
                                    CreateBy='$user'
                                    WHERE JournalId='$id'
                                ");
    if(!$update_jurnal){
        throw new Exception("Update Data Gagal !".$koneksi->error);        
    }
    
    echo json_encode(array('success'=>true,'successMsg'=>'Update Berhasil.'));

}catch(Exception $e){        
    echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage() ));

}

?>