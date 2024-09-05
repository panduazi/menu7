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
  $tgl=date('Y-m-d');   
  
	$q = "INSERT INTO tbltrackingstatus(StatusKonosNo, StatusPOD, StatusDesc, StatusOffice, StatusLocation, StatusDate, StatusJam, RecId, ModiBy) VALUES ('".$cnoresi."','".$cnocp."','".$cdesc."','".$office."','".$location."','".$tgl."','".$cjam."',now(),now(),'".$cuser."','".$cuser."')";
  include('config/koneksi.php');	
  $r=mysql_query($q) or die(mysql_error());  
  