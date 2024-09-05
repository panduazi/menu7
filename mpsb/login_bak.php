<?php
if($_POST['login']) {
  header('location: home.php');
}	


<?php
ini_set("display_errors",0);
session_start();
include 'koneksi.php';
if ($_POST['login']) {
    $nm = $_POST['name'];
    $ps = $_POST['pass'];
	if ( empty($nm) || empty($ps)){ 
		$error = '<h3>User tidak ada</h3>' ;
    } else {
		$query = mysql_query("SELECT * FROM tblUser WHERE UserID='$nm' AND UserPassword='$ps'");
		$num_rows = mysql_num_rows($query);
		if($num_rows == 1){
			$fetch = mysql_fetch_array($query);
			extract($fetch);
				$_SESSION['username'] = $fetch['UserId'];
				$_SESSION['password'] = $fetch['Password'];
				$_SESSION['group'] = $fetch['GroupId'];
			if(isset($_SESSION['username'])){
				header('location: index.html');}
				}else{$error = '<h3>Username dan Password salah</h3>';
			}
    }
}
?>

<!--

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
<script src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<div data-role="page">
  <div data-role="header">
  <h1>Form Inputs</h1>
  </div>
  <div data-role="main" class="ui-content">
    <h2>Halaman ADMIN</h2>
	ini adalah halaman untuk admin yang aklwd  asdklan dkladn lakdnaadnlkadmnldc aldj alid
  </div>
</div>
-->
