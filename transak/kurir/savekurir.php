<?php
 session_start();
 $hari_ini=date('m/d/Y');
 $user = $_SESSION['username'];
 $orig = $_SESSION['location'];
 $level = $_SESSION['leveluser'];
 $id = $_POST['noawb']; //jika INT gunakan fungsi intval(....)
 $tglawb=$_POST['tglawb'];
 $nocust=$_POST['cbcust'];
 $nmtuj=$_POST['namatuj'];
 $altuj=$_POST['almtuj'];
 $tlptuj=$_POST['telptuj'];
 $dest=$_POST['cbdest'];
 $serv=$_POST['cbservis'];
 $berat=intval($_POST['berat']);
 $koli=intval($_POST['banyak']);
 $isi=$_POST['isi'];
 include('config/koneksi.php');
 $sql = "insert into tblconnote(ConnoteNo, ConnoteDate, ConnoteCustNo, ConnoteCustName, ConnoteRecvName, ConnoteRecvAddr,  ConnoteRecvReff, ConnoteOrig, ConnoteDest, ConnoteService, ConnoteWeight, ConnoteQty, ConnoteRecId1, ConnoteRecId2, ConnoteCreateBy, ConnoteModiBy) values('$id','$tglawb','$nocust','$nmtuj','$altuj', '$telptuj', $orig, $dest,$serv,$berat,$koli,now(),now(),'$user','$user')";
 $result = @mysql_query($sql);
 if ($result){
	echo json_encode(array(
       'noawb' => $id,
       'tglawb' => $tglawb,
       'cbcust' => $nocust,
       'namatuj' => $nmtuj,
       'almtuj' => $altuj,
       'telptuj' => $tlptuj,
       'cbdest' => $dest,
       'cbservis' => $serv,
       'berat' => $berat,
       'banyak' => $koli,
       'isi' => $isi
 	));
 } else { 
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
 }

?>