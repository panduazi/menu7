<?php
	$sales=$_GET['sales'];
    $hari_ini=date('Y-m-d');
    $tgl=date('Ymd');
	$kunci=date('Ym');
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
			<h1>LAP. PENJUALAN</h1>
			<a href="hal_sales.php" data-icon="home" data-iconpos="left" data-transition="slide">Kembali</a>
        </div>
        <div data-role="main" class="ui-content">
			<ul data-role="listview">
				<?php
					include 'koneksi.php';
					$query=mysql_query("SELECT ConnoteCustNo,CustomerName,Count(*) as ship,sum(ConnoteWeight) as berat,sum(ConnoteBillAmount-ConnoteBillDisc) as nilai FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteValid=1 and ConnoteOrig=11 and CustomerSales='$sales' AND date_format(ConnoteDate,'%Y%m')='$kunci' GROUP BY ConnoteCustNo Order By nilai");
					while ($hasil=mysql_fetch_array($query)){
						echo "<li><a href='#' data-transition='slidedown'>".$hasil['CustomerName'].", Nilai rp. ".$hasil['nilai']." dari ".$hasil['ship']." ship"."</a></li>";
					}
					
				?>
			</ul>		
		
		</div> 
	</div> 


</body>
</html>