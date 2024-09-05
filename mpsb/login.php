<?php 
session_start();
if ($_POST['login']) {
    $nm = $_POST['name'];
    $ps = $_POST['pass'];
    include 'koneksi.php';
	$query = mysql_query("SELECT * FROM tblUser left join tblPegawai on tblUser.PegawaiNo=tblPegawai.PegawaiNo WHERE UserID='$nm' AND UserPassword='$ps'");
	$num_rows = mysql_num_rows($query);
	if($num_rows == 1){
		$hasil = mysql_fetch_array($query);
		$grup = $hasil['GroupId'];
        $_SESSION['NOPEG']=$hasil['PegawaiNo'];
        $_SESSION['NMPEG']=$hasil['PegawaiNama'];
		switch ($grup) {
			case 'MKT':
				header('location: hal_sales.php');
				break;
			case 'OPS':
				header('location: hal_ops.php');
				break;
			case 'ADMIN':
				header('location: hal_admin.html');
				break;
			default: 	
				header('location: home.php');
				break;
		}
	} else {
		header('location: index.html');
	}	
}
?>
	
