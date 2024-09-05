<?php
    $judul=$_GET['jud'];
	$kunci1=$_GET['tgl1'];
	$kunci2=$_GET['tgl2'];
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
			echo "<h1>PENJUALAN ".$judul."</h1>";
			?>
			<a href="hal_jual_cust.php" data-icon="back" data-iconpos="left" data-transition="slide">back</a>
        </div>
        <div data-role="main" class="ui-content">
			<ul data-role="listview">
				<?php
					include '..\koneksi.php';
					$query=mysql_query("SELECT ConnoteCustNo,CustomerName,Count(*) as ship,sum(ConnoteWeight) as berat,sum(ConnoteBillAmount-ConnoteBillDisc) as nilai,CustomerSales AS SALES FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo WHERE ConnoteValid=1 and ConnoteOrig=11 and date_format(ConnoteDate,'%Y%m%d') between '$kunci1' AND '$kunci2' GROUP BY ConnoteCustNo Order By nilai DESC");
					while ($hasil=mysql_fetch_array($query)){
						echo "<li><a href='#' data-transition='slidedown'>".$hasil['CustomerName']."<p>Rp. ".number_format($hasil['nilai'])." dari ".$hasil['ship']." ship, sales :".$hasil['SALES']."</p></a></li>";
					}
					
				?>
			</ul>		
		
		</div> 
	</div> 


</body>
</html>