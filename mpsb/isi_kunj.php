<?php
	$sales=$_GET['sales'];
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
			<h1>KUNJ. SALES</h1>
			<a href="hal_sales.php" data-icon="home" data-iconpos="left" data-transition="slide">Kembali</a>
        </div>
        <div data-role="main" class="ui-content">
		    <?php 
			echo "<h1>".$sales."</h1>";
			?>
			<form method="post" action="hal_sales.php" data-ajax="false">
				<label for="tgl">Tanggal : <span>*</span></label>
				<?php echo "<input type='text' value=".$hari_ini." name='tgl'>"; ?>
				<label for="nmcust">Nama Cust : <span>*</span></label>
				<input type="text"' name="nccust"/>
				<label for="alcust">Alamat : </label>
				<textarea name="alcust" id="alcust" placeholder="alamat pelanggan"></textarea>
				
				<label for="jenis">Jenis kunjungan:</label>
				<select name="jenis" id="jenis">
					<option value="AK">AK</option>
					<option value="DV">DV</option>
					<option value="MT">MT</option>
				</select>				
			
				<label for="nmcust">Waktu kunjung : <span>*</span></label>
				<input type="text" name="time1" value="08:00"/>
				<input type="text" name="time2" value="12:00"/>
				
				<label for="nmopp">Nama Opertunity :</label>
				<input type="text" name="nmopp"/>

				<label for="nmkompt">Nama Kompetitor :</label>
				<input type="text" name="nmkompt"/>

				
				<label for="jenisop">Jenis Opertunity:</label>
				<select name="jenisop" id="jenisop">
					<option value="VAR">VAR</option>
					<option value="DOC">DOCUMEN</option>
					<option value="PAR">PARCEL</option>
				</select>				

				<label for="tahap">Tahap kunjungan:</label>
				<select name="tahap" id="tahap">
					<option value="1">01. Potential Opportunity</option>
					<option value="2">02. Kontak pertama</option>
					<option value="3">03. Proposal</option>
					<option value="4">04. Setuju kirim</option>
					<option value="5">05. Implementasi</option>
					<option value="6">06. Pengiriman perdana</option>
					<option value="7">07. Follow up</option>
					<option value="8">08. Batal kirim</option>
				</select>				
				
				<label for="info">Message:</label>
				<textarea name="addinfo" id="info" placeholder="Message"></textarea>
				<input type="submit" data-inline="true" value="Submit" data-theme="b">
			</form>
			
		</div> 
	</div> 


</body>
</html>