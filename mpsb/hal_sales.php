<?php
   session_start();   
   $nopeg=$_SESSION['NOPEG'];
   $nmpeg=$_SESSION['NMPEG'];
   $hari_ini=date('Y-m-d');
   $tgl=date('Ymd');
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>List View</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>MENU SALES</h1>
			<a href="index.html" data-icon="home" data-iconpos="left" data-transition="slide">Kembali</a>
        </div>
        <div data-role="main" class="ui-content">
		    <?php
			//echo "<h1>".$nmpeg."</h1>";
			?>
			<ul data-role="listview">
			    <?php
			    echo "<li><a href='isi_kunj.php?sales=".$nmpeg."' data-transition='slidedown'>Daftar Kunjungan</a></li>";
			    echo "<li><a href='lap_jual.php?sales=".$nmpeg."' data-transition='slidedown'>Penjualan Bulan Berjalan</a></li>";
			    echo "<li><a href='#' data-transition='slidedown'>Lap.Pickup</a></li>";
				?>
			</ul>		
		</div>
    </div> 


</body>
</html>