<!DOCTYPE html>
<?php
    $tgl_current=date('Ymd');
    $tgl_last=date('Ymd');
	$kunci=date('Ym');
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>List View</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
	<style>
		body {
		margin: 0;
		padding: 0;
		}
		.bg {
		width: 100%;
		height: 100%;
		position: fixed;
		z-index: 1;
		float: left;
		left: 0;
		}
	</style>
</head>
<body>
    <div id="page-jaringan" data-role="page">
        <div data-role="header">
             <h1>PENJUALAN CUSTOMER</h1>
			 <a href="../hal_admin.html" data-icon="back" data-iconpos="left" data-transition="slide">back</a>
        </div>
        <div data-role="main" class="ui-content">
			<ul data-role="listview">
				<li><a href="lap_jual_cust.php?jud=hari ini&tgl1=20200603&tgl2=20200603">
					<h2>Penjualan hari ini</h2>
					<p>Penjualan perpelanggan hari ini</p></a>
				</li>
				<li><a href="lap_jual_cust.php?jud=kemarin&tgl1=20200602&tgl2=20200602">
					<h2>Penjualan kemarin</h2>
					<p>Penjualan perpelanggan hari kemarin</p></a>
				</li>
				<li><a href="#">
					<h2>Penjualan minggu ini</h2>
					<p>Penjualan perpelanggan dalam 1 minggu ini</p></a>
				</li>
				<li><a href="#">
					<h2>Penjualan minggu lalu</h2>
					<p>Penjualan perpelanggan dalam 1 minggu lalu</p></a>
				</li>
				<li><a href="#">
					<h2>Penjualan bulan ini</h2>
					<p>Penjualan perpelanggan s.d hari ini pada bulan ini</p></a>
				</li>
				<li><a href="#">
					<h2>Penjualan bulan lalu</h2>
					<p>perpelanggan dalam 1 bulan lalu</p></a>
				</li>
			</ul>		
		</div>
        <div data-role="footer">
             <h1>ICT Dept</h1>
		</div>
	</div> 
</body>
</html>