<?php 
    require '../../config/koneksi.php';
    
    //insert ke database
    $file = fopen(".........csv","r"); //buka file csv
    $baris= 0;
    while(!feof($file)) //cari akhir baris csv
    {
      $data = fgetcsv($file,0,',');
      if(!empty($data[0])) //tidak mengikutkan spasi kosong
      { 
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
      }
      $baris++;
    }
    fclose($file); //tutup akses file csv
    
    echo json_encode(array('success'=>true,'successMsg'=>"Berhasil update resi masal"));
    // echo "<script>alert('Berhasil update data.');</script>";

?>
