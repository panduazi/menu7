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
		    <?php 
            //echo "<h1>".$nmpeg."</h1>";
			echo "<h1>DAFTAR PICKUP</h1>";
			?>
			<a href="hal_ops.php" data-icon="home" data-iconpos="left" data-transition="slide">Kembali</a>
        </div>
        <div data-role="main" class="ui-content">
			<ul data-role="listview">
				<?php
				$nmkurir=$nmpeg; //$_GET['kurir'];
				include 'koneksi.php';
				$perintah_sql= "SELECT POrderCustName,POrderCustAddr1,POrderCustPerson,POrderCustAddr1,POrderCustAddr2,CustomerAddr3,CustomerTelp,CustomerPersonName1,CustomerSales,POrderCSO,date_format(POrderDate,'%h:%m') as POtime FROM tblPickupOrder left join tblCustomer On POrderCustNo=CustomerNo WHERE POrderDate like '$hari_ini%' and POrderKurir='$nmpeg' ORDER BY POrderUrut ASC";
				$hasil_query=mysql_query($perintah_sql);
				while ($row=mysql_fetch_array($hasil_query)){
					echo "<li><a href='porder_konf.php?cust=$row[0]&al1=$row[3]&al2=$row[4]&al3=$row[5]&telp=$row[6]&pic=$row[7]&sales=$row[8]' data-transition='slidedown'> <h2>$row[0]</h2><p><strong>$row[2]</strong> (CSO:$row[9] $row[10])</p><p>$row[1]</p></a></li>\n";
				}
				?>
			</ul>		
		</div>
    </div> 


</body>
</html>