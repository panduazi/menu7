<?php 
    // require 'db/connection.php';
    require '../../config/koneksi.php';
    require '../../vendor/autoload.php';
    use PhpOffice\PhpSpreadsheet\IOFactory;

    session_start();

    $ip = $_SERVER['REMOTE_ADDR'];

    date_default_timezone_set('Asia/Jakarta');
    $time = date('Y-m-d H:i:s');

    unset($_SESSION['successImport']);
    $target = basename($_FILES['filexls']['name']);
    move_uploaded_file($_FILES['filexls']['tmp_name'], $target);

    // Load the Excel file
    $spreadsheet = IOFactory::load($_FILES['filexls']['name']);

    // echo $spreadsheet;
    // return;

    // Select the first worksheet
    $worksheet = $spreadsheet->getActiveSheet();
    $skipFirstColumn = true;
    // $successImport = [];

    // Iterate through rows and insert data into the database
    foreach ($worksheet->getRowIterator() as $row) {
        if ($skipFirstColumn) {
            $skipFirstColumn = false; // Skip the first column
            continue;
        }
        $cellIterator = $row->getCellIterator();
        $data = [];
        foreach ($cellIterator as $cell) {
           
            $data[] = $cell->getValue();
        }
        
        $ConnoteNo = $data[0];
        $ConnoteWeight = $data[1];
        $ConnoteBillAmount = $data[2];
        $ConnoteBillDisc = $data[3];
        $ConnoteBillPack = $data[4];
        $ConnoteBillInsurance = $data[5];
        $ConnoteBillOther = $data[6];
      
            $sql = "UPDATE tblconnote SET
            ConnoteWeight='$ConnoteWeight',
            ConnoteBillAmount='$ConnoteBillAmount',				
            ConnoteBillDisc='$ConnoteBillDisc',
            ConnoteBillPack='$ConnoteBillPack',
            ConnoteBillInsurance='$ConnoteBillInsurance',
            ConnoteBillOther='$ConnoteBillOther'
            WHERE ConnoteNo='$ConnoteNo'";
            
            $result = $koneksi->query($sql);

            // if ($result){

                
            // }
        // }
    }
    unlink($_FILES['filexls']['name']);
    echo json_encode(array('success'=>true,'successMsg'=>"Berhasil update resi masal"));
    // echo "<script>alert('Berhasil update data.');</script>";

?>
