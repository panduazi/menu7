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
if($no_voc==''){
    $counter = new Counter();
    $counter->counterGenerate('PAYMENT',$loc);
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
$statusbyr='PAYMENT JOURNAL NO.'+$no_voc;
$gagal=0;
$date = $_POST['tgbyr'];
$reff = '';
$periode = substr($date,1,4)+'/'+substr($date,6,2);
$noinv = $_POST['invno'];
$desc = $_POST['ketbyr'];
$nocr1 = $_POST['noacc1'];
$rpcr1 = $_POST['rpacc1'];
$nocr2 = $_POST['noacc2'];
$rpcr2 = $_POST['rpacc2'];
$nocr3 = $_POST['noacc3'];
$rpcr3 = $_POST['rpacc3'];
$nocr4 = $_POST['noacc4'];
$rpcr4 = $_POST['rpacc4'];
$nodb = $_POST['noacc5'];
$rpdb = $_POST['rpacc5'];
    //Catat pada journal DEBET
    $insert_jurDB = mysql_query("INSERT INTO tblJournal_tes
                                        (JournalVoucerNo,JournalDate,JournalReff,JournalAccNo,JournalPeriode,
                                        JournalDesc,JournalValue,JournalType,CreateTime,JournalLocation,User)
                                    VALUES
                                        ('$no_voc','$date','$reff','$nodb','$periode',
                                        '$desc','$rpdb','0','$time','$loc','$user')
                                    ");
    if(!$insert_jurDB){$gagal=$gagal+1;}                                

    //Catat pada journal CREDIT
    $insert_jurCR = mysql_query("INSERT INTO tblJournal_tes
                                        (JournalVoucerNo,JournalDate,JournalReff,JournalAccNo,JournalPeriode,
                                        JournalDesc,JournalValue,JournalType,CreateTime,JournalLocation,User)
                                    VALUES
                                        ('$no_voc','$date','$reff','$nocr1','$periode',
                                        '$desc','$rpcr1','1','$time','$loc','$user')
                                    ");
    if(!$insert_jurCR){$gagal=$gagal+1;}
    if (nocr2 != ''){
        $insert_jurCR2 = mysql_query("INSERT INTO tblJournal_tes
                                        (JournalVoucerNo,JournalDate,JournalReff,JournalAccNo,JournalPeriode,
                                        JournalDesc,JournalValue,JournalType,CreateTime,JournalLocation,User)
                                    VALUES
                                        ('$no_voc','$date','$reff','$nocr2','$periode',
                                        '$desc','$rpcr2','1','$time','$loc','$user')
                                    ");
        if(!$insert_jurCR2){$gagal=$gagal+1;}
    }
    if (nocr3 != ''){
        $insert_jurCR3 = mysql_query("INSERT INTO tblJournal_tes
                                        (JournalVoucerNo,JournalDate,JournalReff,JournalAccNo,JournalPeriode,
                                        JournalDesc,JournalValue,JournalType,CreateTime,JournalLocation,User)
                                    VALUES
                                        ('$no_voc','$date','$reff','$nocr3','$periode',
                                        '$desc','$rpcr3','1','$time','$loc','$user')
                                    ");
        if(!$insert_jurCR3){$gagal=$gagal+1;}
    }
    if (nocr4 != ''){
        $insert_jurCR4 = mysql_query("INSERT INTO tblJournal_tes
                                        (JournalVoucerNo,JournalDate,JournalReff,JournalAccNo,JournalPeriode,
                                        JournalDesc,JournalValue,JournalType,CreateTime,JournalLocation,User)
                                    VALUES
                                        ('$no_voc','$date','$reff','$nocr4','$periode',
                                        '$desc','$rpcr4','1','$time','$loc','$user')
                                    ");
        if(!$insert_jurCR4){$gagal=$gagal+1;}
    }

    //CATAT PADA TABEL PEMBAYARAN
    $insert_bayar = mysql_query("INSERT INTO tblBayarPiutang_tes
                                    (ByrInvoiceNo,ByrDate,ByrAmmount_IDR,ByrVoucerNo,ByrUser,ByrAccNo)
                                    VALUES ('$NoInv','$time','$rpdb','$no_voc','$user','$nodb')
                                    ")
    if(!$insert_bayar){$gagal=$gagal+1;}

    //tandai sudah LUNAS pada tabel invoice
    $update_inv = mysql_query("UPDATE tblInvoice SET InvoiceStatus=5,InvoiceStatusDate='$time',
                                InvoiceStatusKet='$statusbyr',InvoiceSaldo_IDR='$rpdb' 
                                WHERE InvoiceNo='$NoInv'");
    if(!$update_inv){$gagal=$gagal+1;}

    //tandai sudah LUNAS pada tabel Connote
    $update_resi = mysql_query("UPDATE tblConnote_tes SET ConnoteStatusInvoice=3 
                                WHERE ConnoteNo IN 
                                ('SELECT SD_ConnoteNo FROM tblInvoiceDtl WHERE SD_InvoiceNo="$NoInv"')
                                ");
    if(!$update_resi){$gagal=$gagal+1;}

    if($gagal==0){
        echo json_encode(array('success'=>true,'successMsg'=>'Berhasil.'));
    } else {
        echo json_encode(array('success'=>false,'errorMsg'=>$e->getMessage() ));
    }
?>