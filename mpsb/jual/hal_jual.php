<!DOCTYPE html>
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
             <h1>PENJUALAN</h1>
			 <a href="../hal_admin.html" data-icon="back" data-iconpos="left" data-transition="slide">back</a>
        </div>
        <div data-role="main" class="ui-content">
			<ul data-role="listview">
				<li><a href="hal_jual_cust.php">
					<img src="../gambar/truk.jpg">
					<h2>Per Pelanggan</h2>
					<p>Penjualan diurut perpelanggan</p></a>
				</li>
				<li><a href="#">
					<img src="../gambar/uang.jpg">
					<h2>Per Tujuan</h2>
					<p>Penjualan diurut berdasarkan wilayah tujuan</p></a>
				</li>
			</ul>		
		</div>
        <div data-role="footer">
             <h1>ICT Dept</h1>
		</div>
	</div> 
</body>
</html>