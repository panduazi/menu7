<?php
if (isset($_POST['user'])) {
  $cuser = $_POST['user'];
  $cpass =  $_POST['password'];
} else {
  $cuser = $_POST['user'];
  $cpass =  $_POST['password'];
  
}

  session_start();
  include('config/koneksi.php');
  $query=$koneksi->query("select * from tblUser where userID='$cuser' and UserPassword='$cpass'");
  $r=mysqli_fetch_array($query);
  $hasil=mysqli_num_rows($query);
  if($hasil==TRUE){ 		
    $_SESSION['cuser'] = $r['UserID'];
    $_SESSION['clevel']= $r['UserLevel'];
	  $_SESSION['cgroupid']= $r['GroupId'];
	  header("location:fmenu.php");
  }
  else{   				
	 echo "gagal login";
	}  
?>