<?php
    $nmcust=$_GET['cust'];
	$alcust1=$_GET['al1'];
	$alcust2=$_GET['al2'];
	$alcust3=$_GET['al3'];
	$telp=$_GET['telp'];
	$piccust=$_GET['pic'];
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
		    <?php 
            //echo "<h1>".$nmpeg."</h1>";
			echo "<h1>KONFIRMASI PICKUP</h1>";
			?>
			<a href="porder.php" data-icon="home" data-iconpos="left" data-transition="slide">Kembali</a>
        </div>
        <div data-role="main" class="ui-content">
		    <?php
			  echo $nmcust."<p>";
			  echo $alcust1;
			  echo $alcust2;
			  echo $alcust3."</p>";
			  echo $telp."</p>";
			  echo "Sales : ".$sales;
			?>
			<form method="post" action="porder.php" data-ajax="false">
				<label for="select-choice-0" class="select">
				<h2> Pickup ini akan : </h2></label>
				<select name="note_utilisateur" id="note_utilisateur" data-native-menu="false" data-theme="c" >
					<option value="0" class="one">Diambil</option>
					<option value="1" class="two">Ditolak </option>
					<option value="2" class="three">Tidak cukup waktu</option>
				</select>	
				<input type="submit" data-inline="true" data-icon="check" value="Submit" data-theme="a">
				<a href="#" data-role="button" data-inline="true"data-icon="delete">Cancel</a>
			</form>
		</div>
    </div> 


</body>
</html>