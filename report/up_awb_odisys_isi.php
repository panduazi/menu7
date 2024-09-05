<?php

$fromdate = $_POST['tgl1'];
$todate = $_POST['tgl2'];
$datestart = date("Y/m/d H:i:s");

include('../config/koneksi.php');

$query ="SELECT * FROM tblConnote LEFT JOIN tblCity ON ConnoteDest=CityId 
		  WHERE ConnoteDate BETWEEN '$fromdate' AND '$todate'
		  AND ConnoteCountDeli=0
		";
		
//echo $query;		
$sql  = mssql_query($query,$koneksi);
$ada  = mssql_num_rows($sql);
$n = 0;
$success_connote = 0;
$error_connote = 0;
$error_policy = 0;

while ($data = mssql_fetch_assoc($sql)) {
	$n = $n +1;
	$nomor_cn=$data['ConnoteNo'];
	$nomor_referensi='refbdo'; //trim($data['REF_NO1']);
	$nomor_account='bdo001'; //$data['ACCOUNT_NO'];
	$credential_account='bdo001'; //$data['CREDENTIAL_ACCOUNT'];

	$layanan=$data['ConnoteService'];
	//$services=$data['SERVICES'];
		if($layanan=='0'){
			$layanan='EXPSDS';
			$jenis_kiriman='SHTPC';
		} else if($layanan=='1'){
			$layanan='EXPURG';
			$jenis_kiriman='SHTPC';
		} else if($layanan=='2'){
			$layanan='EXPREG';
			$jenis_kiriman='SHTPC';
		} else if($layanan=='3'){
			$layanan='EXPECO';
			$jenis_kiriman='SHTPC';
		} else {
			$layanan='EXPREG';
			$jenis_kiriman='SHTPC';
		}
				
		$jenis_transaksi=$data['ConnotePayment'];
		if($jenis_transaksi=='0'){
			$jenis_transaksi='TRTCS';
		} else {
			$jenis_transaksi='TRTCR';
		}

	$tanggal_cn=$data['ConnoteDate'];
	$koli=(is_numeric($data['ConnoteQty']) && $data['ConnoteQty']>0 )?$data['ConnoteQty']:1;
	$kilo=(is_numeric($data['ConnoteWeight']) && $data['ConnoteWeight']>0 )?$data['ConnoteWeight']:1;
	$deskripsi_barang=$data['ConnoteContents'];
	$instruksi_khusus=$data['ConnoteRecvReff'];


	$nilai_barang=(is_numeric($data['ITEM_PRICE']))?$data['ITEM_PRICE']:0;
	$asuransi=$data['IS_INSURANCE'];
		if($asuransi=='1'){
			$asuransi='INSAS';
		} else if($asuransi=='0'){
			$asuransi='INSNN';
		} else {
			$asuransi='INSNN';
		}
	$packing=$data['IS_PACKING'];
		if($packing=='1'){
			$packing='PACIN';
		} else if($packing=='0'){
			$packing='PACNN';
		} else {
			$packing='PACNN';
		}
	$surcharge=$data['IS_SURCHARGE'];
		if($surcharge=='2'){
			$surcharge='VR1HEA';
		} else if($surcharge=='1'){
			$surcharge='VR1DG';
		} else if($surcharge=='0'){
			$surcharge='VR1GEN';
		} else {
			$surcharge='VR1GEN';
		}
	$length=(is_numeric($data['VOLUME_L1']) && $data['VOLUME_L1'] < 0)?0:$data['VOLUME_L1'];
	$width=(is_numeric($data['VOLUME_W1']) && $data['VOLUME_W1'] < 0)?0:$data['VOLUME_W1'];
	$height=(is_numeric($data['VOLUME_H1']) && $data['VOLUME_H1'] < 0)?0:$data['VOLUME_H1'];
	$volume=(is_numeric($data['VOLUME_KG1']) && $data['VOLUME_KG1'] < 0)?0:$data['VOLUME_KG1'];

	$nama_pengirim=$data['ConnoteCustName'];
	$alamat_pengirim_1=$data['ConnoteCustAddr1'];
	$tricode_asal=$data['BDO'];
	$location_asal=$data['PSSBDO'];
	$kodepos_pengirim='40111'; //$data['SENDER_POSTAL_CODE1'];
	$telpon1_pengirim=preg_replace('/[^0-9]/', '', $data['ConnoteCustAddr3']);
	$telpon2_pengirim=preg_replace('/[^0-9]/', '', $data['ConnoteCustAddr3']);
	$email_pengirim='email@domain.com'; //$data['SENDER_EMAIL'];
	$kontak_pengirim='sender_pic'; //$data['SENDER_CONTACT'];
	$nama_penerima=$data['ConnoteRecvName'];
	$alamat_penerima_1=$data['ConnoteRecvAddr1'].' '.$data['ConnoteRecvAddr2'].' '.$data['ConnoteRecvAddr3'];
	$tricode_tujuan=$data['CityForward'];
	$kodepos_penerima=$data['CityCountry'];
	$telpon1_penerima=preg_replace('/[^0-9]/', '', $data['ConnoteRecvReff']);
	$telpon2_penerima=preg_replace('/[^0-9]/', '', $data['ConnoteRecvReff']);
	$email_penerima='penerima@domain.com'; //$data['CONSIGNEE_EMAIL'];
	$kontak_penerima='penerima_pic'; //$data['CONSIGNEE_CONTACT'];
	$rec_id = $data['ConnoteNo'];

	// $nomor_cn="PO00000894201";
	// $nomor_referensi="REF123";
	// $nomor_account="11.000.00000000";
	// $credential_account="11.000.00000000";
	// $layanan="EXPREG";
	// $jenis_kiriman="SHTPC";
	// $jenis_transaksi="TRTCR";
	// $tanggal_cn="2021/12/22";
	// $koli=2;
	// $kilo=1;
	// $deskripsi_barang="BARANG elektronik";
	// $instruksi_khusus="jangan dibanting";
	// $nilai_barang=0;
	// $asuransi="INSNN";
	// $packing="PACNN";
	// $surcharge="VR1GEN";
	// $length=30;
	// $width=40;
	// $height=50;
	// $volume=4.3;
	// $nama_pengirim="Toko Penjual";
	// $alamat_pengirim_1="JL. Depan Rumah No. 1";
	// $tricode_asal="BDO";
	// $location_asal="PSSBDO";
	// $kodepos_pengirim=40123;
	// $telpon1_pengirim=6285612345678;
	// $telpon2_pengirim=6285612345678;
	// $email_pengirim="helpdesk@odisys.id";
	// $kontak_pengirim="TEST RECEIVER 2";
	// $nama_penerima="Toko Penjual";
	// $alamat_penerima_1="JL. Depan Rumah No. 1";
	// $tricode_tujuan="JKT";
	// $kodepos_penerima=14450;
	// $telpon1_penerima=6285612345678;
	// $telpon2_penerima=6285612345678;
	// $email_penerima="helpdesk@odisys.id";
	// $kontak_penerima="TEST RECEIVER 2";
	
	$postfields = '{
		"nomor_cn": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $nomor_cn).'",
		"nomor_referensi": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $nomor_referensi).'",
		"nomor_account": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $nomor_account).'",
		"layanan": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $layanan).'",
		"jenis_kiriman": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $jenis_kiriman).'",
		"jenis_transaksi": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $jenis_transaksi).'",
		"tanggal_cn": "'.$tanggal_cn.'",
		"koli": '.$koli.',
		"kilo": '.$kilo.',
		"deskripsi_barang": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $deskripsi_barang).'",
		"instruksi_khusus": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $instruksi_khusus).'",
		"nilai_barang": '.$nilai_barang.',
		"asuransi": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $asuransi).'",
		"packing": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $packing).'",
		"surcharge": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $surcharge).'",
		"length": '.$length.',
		"width": '.$width.',
		"height": '.$height.',
		"volume": '.$volume.',
		"nama_pengirim": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $nama_pengirim).'",
		"alamat_pengirim_1": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $alamat_pengirim_1).'",
		"tricode_asal": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $tricode_asal).'",
		"location_asal": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $location_asal).'",
		"kodepos_pengirim": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $kodepos_pengirim).'",
		"telpon1_pengirim": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $telpon1_pengirim).'",
		"telpon2_pengirim": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $telpon2_pengirim).'",
		"email_pengirim": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $email_pengirim).'",
		"kontak_pengirim": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $kontak_pengirim).'",
		"nama_penerima": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $nama_penerima).'",
		"alamat_penerima_1": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $alamat_penerima_1).'",
		"tricode_tujuan": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $tricode_tujuan).'",  
		"kodepos_penerima": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $kodepos_penerima).'",
		"telpon1_penerima": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $telpon1_penerima).'",
		"telpon2_penerima": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $telpon2_penerima).'",
		"email_penerima": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $email_penerima).'",
		"kontak_penerima": "'.preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', ' ', $kontak_penerima).'"
	}';
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://production.pandulogistics.com/pandu/restapi/basic/raw_data/shipment_text_gen_pliss',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_SSL_VERIFYHOST => 0,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLINFO_HEADER_OUT => true,
		CURLOPT_CUSTOMREQUEST => 'POST',
		CURLOPT_POST => true,
		CURLOPT_VERBOSE => true,
		CURLOPT_POSTFIELDS => $postfields,
		CURLOPT_HTTPHEADER => array(
		'api-key: af707372-41a2-41cd-b542-b97f80f6ba74',
		'credential-account: BDON19385',
		'Content-Type: application/json'
		),
	));

	$response = curl_exec($curl);
	//echo $n.' paramater : '.$postfields.'<br/>';
	//echo $response.'<br/><br/>';
	curl_close($curl);
	
	$response = substr($response,strpos($response,'{'));	
	$data = json_decode($response);
	$status=$data->status;
	$message=$data->message;

	if ($status === 'POLICYS') { /* Handle error */ 
		//echo $nomor_cn.' Error, with Status : '.$status.' and Messages : '.$message;	
		echo 'Policy Error - '.$nomor_cn."\n".'paramater : '.$postfields."\n";
		echo 'Status : '.$status.' and Messages : '.$message."\n\n";	
		$error_policy = $error_policy + 1;
	} else {

		$status1=$status->sts;
		$message1=$status->msg;
		$error1=$status->error;
		if ($status1 === 'success'){
			$query = "update awb set ConnoteCountDeli = '1' where ConnoteNo = '".$rec_id."'";
			$sql2  = mssql_query($query,$koneksi);		
			$success_connote = $success_connote + 1;
			//echo $nomor_cn." Inserted, message : ".$message1;
		} else {
			if ((strpos($error1, 'Exists ') !== false) || (strpos($error1, 'duplicate ') !== false)) {
				$query = "update awb set ConnoteCountDeli = '1' where ConnoteNo = '".$rec_id."'";
				$sql2  = mssql_query($query,$koneksi);		
			} else {
				$error_connote = $error_connote + 1;
				echo 'Other Error - '.$nomor_cn."\n".'paramater : '.$postfields."\n";
				echo 'Status : '.$status1.' and Messages : '.$error1."\n\n";	
			}
		}
	}
	
}
$dateend = date("Y/m/d H:i:s");
if($n>0){
	echo "Date Start : ".$datestart.", Date End : ".$dateend.", Total Row : ".$n.", Success : ".$success_connote.", Error : ".$error_connote.", Policy Failed : ".$error_policy."\n";
}
?>