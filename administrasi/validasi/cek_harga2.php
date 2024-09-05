<?php
error_reporting(E_ALL);
ini_set('ignore_repeated_errors', FALSE);
ini_set('display_errors', false);
ini_set('log_errors', true);
ini_set('error_log', 'errors.log');

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

    include('../../config/koneksi.php');
    
    $cust = $_GET['cust'];
    $tujuan = $_GET['tujuan'];
    $orig = $_GET['orig'];
    $berat_fix = $_GET['berat_fix'];
    $qty = $_GET['qty'];
    $serv = $_GET['service'];
    $hrg1=0;
    $hrg2=0;

	//cari tarip di hargakhusus
    $sqltext1="SELECT * FROM PriceCust WHERE PriceCustomerNo='$cust' AND PriceCityId='$tujuan'";
    $sqltext2="SELECT * FROM tblPrice WHERE PriceCityId='$tujuan'";
    if (mysqli_num_rows($sqltext1) > 0) {
        $row = mysqli_fetch_object($sqltext1);
    } else {
        $row = mysqli_fetch_object($sqltext2);
    }    
    if($serv==0){

    }


    
    $rs = $koneksi->query($sqltext);

	$result["total"] = mysqli_num_rows($rs);
	    




    $rs = $koneksi->query("SELECT * FROM tblService");
	$result["total"] = mysqli_num_rows($rs);
	$rs = $koneksi->query(" SELECT * FROM tblservice WHERE NOCR='Y'
							LIMIT $offset,$rows
						");
    $price = $koneksi->query("SELECT * FROM tblprice_newpsb WHERE PriceCityOrig=$orig AND PriceCityDest='$tujuan'");
    if(mysqli_num_rows($price) > 0){
        $price_cust = $koneksi->query("SELECT * FROM tblprice_cust WHERE PriceCustNo='$cust' AND PriceCityDest='$tujuan'");
        if(mysqli_num_rows($price_cust)){
            $data_harga = mysqli_fetch_object($price_cust);
        }else{
            $data_harga = mysqli_fetch_object($price);
        }

        
    }
    
	$items = array();
	while($row = mysqli_fetch_object($rs)){
        if($row->ServiceName=='URGENT'){
            if(mysqli_num_rows($price) > 0){

                $harga1 = $data_harga->PriceSuper1;
                $harga2 = $data_harga->PriceSuper2;
                $limit = $data_harga->PriceSuperLim;
                $harga_hitung = $berat_fix*$harga1;
                $row->Harga_text = 'Rp. '.number_format($harga_hitung,0);
                $row->Harga = $harga_hitung;
                $row->HargaSat = $harga1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }     
        }
        elseif($row->ServiceName=='REGULAR'){
            if(mysqli_num_rows($price) > 0){
                $harga1 = $data_harga->PriceReg1;
                $harga2 = $data_harga->PriceReg1;
                $limit = $data_harga->PriceExpLim; 
                $harga_hitung = $berat_fix*$harga1;
                $row->Harga_text = 'Rp. '.number_format($harga_hitung,0);
                $row->Harga = $harga_hitung;
                $row->HargaSat = $harga1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            } 
        }

        elseif($row->ServiceName=='EKONOMI'){
            if(mysqli_num_rows($price) > 0){

                $harga1 = $data_harga->PriceEko1;
                $harga2 = $data_harga->PriceEko1;
                $limit = 5;
                if($berat_fix <= $limit){
                    $harga_hitung = $harga1 * $limit;
                }else if($berat_fix > $limit){
                    $harga_hitung = $harga1 * $berat_fix;
                }                
                $row->Harga_text = 'Rp. '.number_format($harga_hitung,0);
                $row->Harga = $harga_hitung;
                $row->HargaSat = $harga1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }

        elseif($row->ServiceName=='ECO'){
            if(mysqli_num_rows($price) > 0){
                $harga1 = $data_harga->PriceEko1;
                $harga2 = $data_harga->PriceEko2;
                $limit = 30;
                if($berat_fix <= 30){
                    $harga_hitung = $harga1 * 30;
                }else if($berat_fix <= 50){
                    $harga_hitung = $harga2 * 50;
                }else if($berat_fix <= 1000000){
                    $harga_hitung = $harga3 * $berat_fix;
                }                
                $row->Harga_text = 'Rp. '.number_format($harga_hitung,0);
                $row->Harga = $harga_hitung;
                $row->HargaSat = $harga1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }

        elseif($row->ServiceName=='FAST-1'){
            if(mysqli_num_rows($price) > 0){
                $harga1 = $data_harga->PriceReg1;
                $harga2 = $data_harga->PriceReg1;
                $limit = 1;
                if($berat_fix <= $limit){
                    $harga_hitung = $harga1*$limit;
                }else if($berat_fix > $limit){
                    $harga_hitung = $harga1 * $berat_fix;
                }                
                $row->Harga_text = 'Rp. '.number_format($harga_hitung,0);
                $row->Harga = $harga_hitung;
                $row->HargaSat = $harga1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }             
        }

        elseif($row->ServiceName=='FAST-4'){
            if(mysqli_num_rows($price) > 0){
                $harga1 = $data_harga->PriceReg2;
                $harga2 = $data_harga->PriceReg2;
                $limit = 4;
                if($berat_fix <= $limit){
                    $harga_hitung = $harga1*$limit;
                }else if($berat_fix > $limit){
                    $harga_hitung = $harga1 * $berat_fix;
                }                
                $row->Harga_text = 'Rp. '.number_format($harga_hitung,0);
                $row->Harga = $harga_hitung;
                $row->HargaSat = $harga1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }             
        }

        elseif($row->ServiceName=='FAST-10'){
            if(mysqli_num_rows($price) > 0){
                $harga1 = $data_harga->PriceReg3;
                $harga2 = $data_harga->PriceReg3;
                $limit = 10;
                if($berat_fix <= $limit){
                    $harga_hitung = $harga1*$limit;
                }else if($berat_fix > $limit){
                    $harga_hitung = $harga1 * $berat_fix;
                }                
                $row->Harga_text = 'Rp. '.number_format($harga_hitung,0);
                $row->Harga = $harga_hitung;
                $row->HargaSat = $harga1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }             
        }


        elseif($row->ServiceName=='CARTER BOX VAN'){
            if(mysqli_num_rows($price) > 0){
                $row->Harga_text = 'Rp. '.number_format($data_harga->PriceCarter1);
                $row->Harga = $data_harga->PriceCarter1;
                $row->HargaSat = $data_harga->PriceCarter1;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }
        elseif($row->ServiceName=='CARTER ENGKEL'){
            if(mysqli_num_rows($price) > 0){
                $row->Harga_text = 'Rp. '.number_format($data_harga->PriceCarter2);
                $row->Harga = $data_harga->PriceCarter2;
                $row->HargaSat = $data_harga->PriceCarter2;
            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }
        elseif($row->ServiceName=='CARTER DOUBLE'){
            if(mysqli_num_rows($price) > 0){
                
                $row->Harga_text = 'Rp. '.number_format($data_harga->PriceCarter3);
                $row->Harga = $data_harga->PriceCarter3;
                $row->HargaSat = $data_harga->PriceCarter3;

            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }

        elseif($row->ServiceName=='CARTER FUSO'){
            if(mysqli_num_rows($price) > 0){
                
                $row->Harga_text = 'Rp. '.number_format($data_harga->PriceCarter4);
                $row->Harga = $data_harga->PriceCarter4;
                $row->HargaSat = $data_harga->PriceCarter4;

            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }
        elseif($row->ServiceName=='CARTER TRONTON'){
            if(mysqli_num_rows($price) > 0){
                
                $row->Harga_text = 'Rp. '.number_format($data_harga->PriceCarter5);
                $row->Harga = $data_harga->PriceCarter5;
                $row->HargaSat = $data_harga->PriceCarter5;

            }else{
                $row->HargaSat = 0;
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }
        elseif($row->ServiceName=='KOLI 3cbm'){
            if(mysqli_num_rows($price) > 0){
                
                $harga_coli = $qty * $data_harga->PriceColi1;
                $row->Harga_text = 'Rp. '.number_format($harga_coli);
                $row->Harga = $harga_coli;

            }else{
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }
        elseif($row->ServiceName=='KOLI 5cbm'){
            if(mysqli_num_rows($price) > 0){
                
                $harga_coli = $qty * $data_harga->PriceColi2;
                $row->Harga_text = 'Rp. '.number_format($harga_coli);
                $row->Harga = $harga_coli;

            }else{
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }
        elseif($row->ServiceName=='KUBIKASI (M3)'){
            if(mysqli_num_rows($price) > 0){
                
                $harga_coli = $qty * $data_harga->PriceColi3;
                $row->Harga_text = 'Rp. '.number_format($harga_coli);
                $row->Harga = $harga_coli;

            }else{
                $row->Harga = 0;
                $row->Harga_text = 'Rp. 0';
            }
        }
    
		array_push($items, $row);
	}
	$result["rows"] = $items;

	echo json_encode($result);

?>