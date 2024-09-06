<?php
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', TRUE);
ini_set('display_errors', true);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');

require '../config/koneksi.php';
session_start();
date_default_timezone_set('Asia/Jakarta');
$time = date('Y-m-d H:i:s');
$date_default = date('Y-m-d');
$loc = '7669';
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

$koneksi->begin_transaction(); // Start transaction

try {
    $user = $data['ByrUser'];
    $no_voc = '';
    $jurnalData = $data['dataJournal'];

    if ($no_voc == '') {
        $query = $koneksi->query('SELECT * FROM `tblCounter` WHERE CountId=33');
        if ($query) {
            $counter = mysqli_fetch_object($query);
            if ($counter) {
                // Concatenate CountCode and CountNo with space or however they should be formatted
                $no_voc = str_replace('.', '', $counter->CountCode) . ' ' . $counter->CountNo;
            } else {
                throw new Exception('No record found in tblCounter.');
            }
        } else {
            throw new Exception('Query failed: ' . $koneksi->error);
        }
    }

    foreach ($jurnalData as $j) {
        $sql = "INSERT INTO tblJournal
                (JournalVoucerNo, JournalDate, JournalAccNo, JournalPeriode,
                 JournalDesc, JournalValue, JournalType, RecId1, CreateBy)
                VALUES
                ('$no_voc', '{$j['JournalDate']}', '{$j['JournalAccNo']}', '{$j['JournalPeriode']}',
                 '{$j['JournalDesc']}', '{$j['JournalValue']}', '{$j['JournalType']}', '$time', '$user')";

        if (!$koneksi->query($sql)) {
            throw new Exception('Insert journal failed: ' . $koneksi->error);
        }
    }
    $ByrInvoiceNo = $data['ByrInvoiceNo'];
    $ByrDate = $data['ByrDate'];
    $ByrAmmount_IDR = $data['ByrAmmount_IDR'];
    $ByrUser = $data['ByrUser'];
    $ByrAccNo = $data['ByrAccNo'];

    $insert_piutang = "INSERT INTO tblBayarPiutang
                    (ByrVoucerNo, ByrInvoiceNo, ByrDate, ByrAmmount_IDR,
                    ByrUser, ByrAccNo)
                    VALUES
                    ('$no_voc', '$ByrInvoiceNo', '$ByrDate', '$ByrAmmount_IDR',
                    '$ByrUser', '$ByrAccNo')";

    if (!$koneksi->query($insert_piutang)) {
        throw new Exception('Insert piutang failed: ' . $koneksi->error);
    }

    $update_counter = $koneksi->query("UPDATE tblCounter SET
                        CountNo = CountNo + 1                                     
                        WHERE CountId=33");

    if (!$update_counter) {
        throw new Exception('Error update counter: ' . $koneksi->error);
    }

    $koneksi->commit(); // Commit transaction
    echo json_encode(array('success' => true, 'message' => 'Pembayaran berhasil'));
} catch (\Throwable $th) {
    $koneksi->rollback(); // Rollback transaction on error
    echo json_encode(array('success' => false, 'message' => 'Error: ' . $th->getMessage()));
}
?>