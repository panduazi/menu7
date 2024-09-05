<?php
  session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $codeorig = $_SESSION['corigincode'];
  $hari_ini=date('m/d/Y');
  $tglresi=date('m/d/Y')-1;
  $tgl2=date('Y-m-d');   
 
  // --- jika tekan TOMBOL CARI 
  if (isset($_POST['btsave'])) {
	$noawb=$_POST['ednoawb'];
	$tgl=$_POST['edtgl'];
	$nocust=$_POST['cbcust'];
	$reffcust=$_POST['edreffcust'];
	$nmrecv=$_POST['ednmrecv'];
	$serv=$_POST['cbserv'];
	$dest=$_POST['cbdest'];
	$brt=$_POST['edbrt'];
	$qty=$_POST['edqty'];
	$isi=$_POST['edketisi'];
	$jenis=$_POST['cbjenis'];
	$jbyr=$_POST['cbjnsbayar'];
	$hrg=$_POST['edhrg'];
	$pack=$_POST['edpack'];
	$ass=$_POST['edass'];
    //cari nama dan alamat customer
  	include('../../config/koneksi.php');	
  	$r=mysql_query("SELECT * FROM tblcustomer WHERE CustomerNo='$nocust'") or die(mysql_error());
	$hasil=mysql_fetch_array($r);
	if ($hasil) {
	  $nmcust=$hasil['CustomerName'];
	  $alcust=$hasil['CustomerAddr1'];
	} else {
	  $nmcust='NA#';
	  $alcust='NA#';
	}
		
	//ubah connote
	$q = "UPDATE tblconnote SET ConnoteDate='$tgl',ConnoteDest='$dest',ConnoteCustNo='$nocust', ConnoteCustName='$nmcust', ConnoteCustAddr='$alcust', ConnoteCustReff='$reffcust', ConnoteRecvName='$nmrecv', ConnoteRecvAddr='$alrecv', ConnoteContents='$isi', ConnotePayment=$jbyr, ConnoteWeight=$brt, ConnoteQty=$qty, ConnoteService=$serv, ConnoteRecId2=now(), ConnoteModiBy='$cuser' WHERE ConnoteNo='$nocust'";
  include('../../config/koneksi.php');	
  $r=mysql_query($q) or die(mysql_error());
  if ($r) {
	echo "<script>window.alert('UPDATE/Validasi berhasil');
	     <script>window.open('fmenu.php?hal=cancel')</script>";
  }
  }
?>