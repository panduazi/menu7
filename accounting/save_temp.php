<?php 
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');

require '../config/koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');
$date_default = date('Y-m-d');
$time = date('Y-m-d H:i:s');
$user = $_SESSION['cuser'];

$get_counter = mysql_query("SELECT * FROM tblcounter WHERE CountName='MEMORIAL'");
$data_counter = mysql_fetch_object($get_counter);
$counter = $data_counter->CountNo + 1;
if($counter < 10)
{
    $no = '00000'.$counter;
}
elseif($counter < 100)
{
    $no = '0000'.$counter;
}
elseif($counter < 1000)
{
    $no = '000'.$counter;
}
elseif($counter < 10000)
{
    $no = '00'.$counter;
}
elseif($counter < 100000)
{
    $no = '0'.$counter;
}
else{
    $no = $counter;
}
$no_counter = $data_counter->CountCode.$no;

$update_counter = mysql_query("UPDATE tblcounter SET CountNo='$counter' WHERE CountId='$data_counter->CountId'");

if(!$update_counter){
    echo json_encode(array('success'=>false,'errorMsg'=>'Error Counter.'));
}

$voc_no = $no_counter;

$date = $_POST['voctgl'];
$periode = date('Ym');

$temp_key = $_POST['temp_key'];

$get_temp = mysql_query("SELECT * FROM tempjur WHERE tId='$temp_key'");
if(mysql_num_rows($get_temp) != 0){

    try{

        while($data_temp = mysql_fetch_object($get_temp)){
    
                $insert = mysql_query("INSERT INTO tbljournal
                                                        (
                                                            JournalDate,
                                                            JournalAccNo,
                                                            JournalDesc,
                                                            JournalVoucerNo,
                                                            JournalPeriode,
                                                            JournalValue,
                                                            JournalType,
                                                            RecId1,
                                                            CreateBy
                                                        )
                                                        VALUES
                                                        (
                                                            '$date',
                                                            '$data_temp->tAccNo',
                                                            '$data_temp->tAcclDesc',
                                                            '$voc_no',
                                                            '$periode',
                                                            '$data_temp->tAccValue',
                                                            '$data_temp->tAccType',
                                                            '$time',
                                                            '$user'                                                            
                                                        )
                                                    ");
                if(!$insert){
                    throw new Exception('error insert ');
                    break;
                }         
    
        }
    
        echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));

    }catch(Exception $e){        
        echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage() ));

    }
   

}else{
    echo json_encode(array('success'=>false,'errorMsg'=>'Terjadi Kesalahan.'));
}

?>