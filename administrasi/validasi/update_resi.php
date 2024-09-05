<?php
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');
date_default_timezone_set('Asia/Jakarta');

session_start();
// $location = $_SESSION['cloc'];
$location = '7669';
$cuser = $_SESSION['cuser'];
$group = $_SESSION['cgroupid'];
 
include('../../config/koneksi.php');
$id_connote = $_POST['id_connote'];
$no_resi = $_POST['noresi'];
$dtglresi = $_POST['tglresi'];
$cnocust = $_POST['nocust'];
$cnmcust = $_POST['nmcust'];
$ctelp = $_POST['telpcust'];
$cmalcust = $_POST['alcust'];
$nomor_do = $_POST['nomor_do'];
$cnmrecv = $_POST['nmrecv'];
$idrecv = $_POST['idrecv'];
$tlprecv = $_POST['tlprecv'];
$calrecv = $_POST['alrecv'];
$reff_dituju = $_POST['reff_dituju'];
$ndest = $_POST['cbdest'];
$cketisi = $_POST['ketisi'];
$nbayar = $_POST['jnsbayar'];
$nberat = $_POST['berat'];
$qty = $_POST['qty'];
$service = $_POST['cbserv_id'];
$hrgsat = $_POST['hrgsat'];

$tgldeli = $_POST['tgldeli'];
$ketdeli = $_POST['ketdeli'];
$pegdeli = $_POST['pegdeli'];

$bea = $_POST['bea'];
$pack = $_POST['pack'];
$asuransi = $_POST['ass'];
$other = $_POST['other'];
$diskon = $_POST['disc'];
$vol1 = $_POST['vol1'];
$vol2 = $_POST['vol2'];
$vol3 = $_POST['vol3'];
$vol_weight = ($vol1 * $vol2 * $vol3) / 4000;
$time = date('Y-m-d H:i:s');
$cek_connote = $koneksi->query("SELECT * FROM tblConnote_odisys WHERE ConnoteRecNo='$id_connote'");
if(mysqli_num_rows($cek_connote)){
    $data_connote = mysqli_fetch_object($cek_connote);  
    if($data_connote->ConnoteNo != $no_resi){
        $cek_no = $koneksi->query("SELECT * FROM tblConnote WHERE ConnoteNo='$no_resi'");
        if(mysqli_num_rows($cek_no)){
            echo json_encode(
                array(
                    'success'=>false,
                    'errorMsg'=>'Nomor AWB sudah di pakai !',            
                )
            );
            die();
        }
    }
}
    try{
        if(isset($_POST['check_dituju'])){
            $check_dituju = $_POST['check_dituju'];
            if($check_dituju == true){
                $check_dituju = $koneksi->query("SELECT * FROM tblcustomerdest WHERE id='$idrecv'");
                if(mysqli_num_rows($check_dituju) != 0){
                    $update_dituju = $koneksi->query("UPDATE tblcustomerdest SET
                                                CustomerDestName='$cnmrecv',
                                                CustomerDestAddr='$calrecv',
                                                CustomerDestTelp='$tlprecv',
                                                CustomerDestCity='$ndest'                                                
                                                WHERE id='$idrecv'
                                                ");
                    if(!$update_dituju){
                        throw new Exception('error update recv');        
                    }
                }else{
                    $save_dituju = $koneksi->query("INSERT INTO tblcustomerdest
                                                (CustomerDestName,CustomerDestAddr,CustomerDestTelp,CustomerDestCity,CreateLoc)
                                                VALUES
                                                ('$cnmrecv','$calrecv','$tlprecv','$ndest','$location')
                                                ");
                    if(!$save_dituju){
                        throw new Exception('error save recv');        
                    }
                }
                
            }
            
        }
        $sql ="UPDATE tblConnote_odisys
            SET ConnoteDate='$dtglresi', 
            ConnoteDest='$ndest', 
            ConnoteOrig='$location',
            ConnoteCustNo='$cnocust', 
            ConnoteCustName='$cnmcust',
            ConnoteCustAddr3='$ctelp', 
            ConnoteCustAddr1='$cmalcust', 
            ConnoteCustReff='$nomor_do',
            ConnoteRecvAddr2='$idrecv',
            ConnoteRecvName='$cnmrecv', 
            ConnoteRecvAddr3='$tlprecv',
            ConnoteRecvAddr1='$calrecv',  
            ConnoteRecvReff='$reff_dituju',
            ConnoteContents='$cketisi', 
            ConnotePayment='$nbayar', 
            ConnoteWeight='$nberat', 
            ConnoteQty='$qty',
            /* ConnoteVol1='$vol1', */
            /* ConnoteVol2='$vol2',*/
            /* ConnoteVol3='$vol3',*/ 
            ConnoteWeight='$vol_weight',
            ConnoteService='$service',    
            ConnoteBillAmount='$bea',
            ConnoteBillOther='$other',
            ConnoteBillDisc='$diskon',
            ConnoteBillPack='$pack',
            ConnoteBillInsurance='$asuransi',   
            ConnoteCost3='$hrgsat',
            ConnoteValid='Y',
            ConnoteStatusInvoice=2,            
            ConnoteModiBy='$cuser'
            /* UpdateTime='$time'*/
            WHERE ConnoteRecNo='$id_connote'        
        ";	
        $result = $koneksi->query($sql);
        if(!$result){
            throw new Exception('error update resi');        
        }
        echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));
    }catch(Exception $e){
        echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage() ));
    }
?>