<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = 11;
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroupid'];
 $office = $_SESSION['coffice'];
 //$hari_ini=date('m/d/Y');
 //$tglresi=date('m/d/Y')-1;
 //$tgl2=date('Y-m-d');   
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Tabel city</title>        
        <link rel="stylesheet" href="css/style.css" type="text/css" />
        <style type="text/css">
            @import "media/css/demo_table_jui.css";
            @import "media/themes/smoothness/jquery-ui.css";
        </style>      
        <script src="media/js/jquery.js"></script>
        <script src="media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
		
          $(document).ready(function(){
            $('#datatables').dataTable({
					     "oLanguage": {
						      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
						      "sSearch": "Pencarian: ", 
						      "sZeroRecords": "Maaf, tidak ada data yang ditemukan",
						      "sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
						      "sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
						      "sInfoFiltered": "(di filter dari _MAX_ total data)",
						      "oPaginate": {
						          "sFirst": "<<",
						          "sLast": ">>", 
						          "sPrevious": "<", 
						          "sNext": ">"
					       }
				      },
              "sPaginationType":"full_numbers",
              "bJQueryUI":true
            });
          })    

   function myformatter(date){
            var y = date.getFullYear();
            var m = date.getMonth()+1;
            var d = date.getDate();
            return y+'-'+(m<10?('0'+m):m)+'-'+(d<10?('0'+d):d);
        }
		
   function myparser(s){
            if (!s) return new Date();
            var ss = (s.split('-'));
            var y = parseInt(ss[0],10);
            var m = parseInt(ss[1],10);
            var d = parseInt(ss[2],10);
            if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
                return new Date(y,m-1,d);
            } else {
                return new Date();
            }	
   }

        </script>
       
    </head>
    <body>
    <div style="margin-bottom:10px">
    <form action="fmenu.php?hal=lapsmu" method="post">
    <table width="100%">
    <tr>
    <td><h2>Monitoring Transaksi Vendor</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
    Vendor : 
    <select name="vendor" id="vendor">
    <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select VendorCode,VendorName from tblVendor order by VendorCode ",$koneksi);
   		  echo "<option value=''>-- all vendor --</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]$dsales[1]'>$dsales[1]</option>";
		 ?>

      <!-- <option value="">-- all vendor --</option>
      <option value="V001">SWA BUANA PRATAMA</option>
      <option value="V002">ANTAR NUSANTARA CARGO</option>
      <option value="V003">SRIWIJAYA AIR</option>
      -->

    </select>
    <input type="submit" name="btproses" id="btproses" value="Submit">
    	</td>
    </tr>
    </table>
    </form>
    </div>
    
    <div id="isi">
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">RESI No</th>
                        <th align="left">Tanggal</th>
                        <th align="left">Dest</th>
                        <th align="right">Qty</th>
                        <th align="right">Berat</th>
                        <th align="right">Nilai</th>
                        <th align="right">V.Qty</th>
                        <th align="right">V.Kg</th>
                        <th align="right">V.Rp.</th>
                        <th align="right">Sel. Kg</th>
                        <th align="right">Sel. Rp.</th>
                        <th align="right">AWB. Kg.</th>
                        <th align="right">AWB. Rp.</th>
                        <th align="right">Sel. AWB. Kg.</th>
                        
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL SAVE-BAGING ----
					  $totkgops=0;
 					  $totkgvendor=0;
					  $totkgawb=0;
  					  if (isset($_POST['btproses'])) {
						$t1=$_POST['tgl1'];
						$t2=$_POST['tgl2'];
						$cust=$_POST['cbcust'];
						$vend=$_POST['vendor'];
						if ($vend=='') {$cvend='ALL';}
						else if ($vend=='V001') {$cvend='SWA BUANA PRATAMA';}
						else if ($vend=='V002') {$cvend='ANTAR NUSANTARA CARGO';}
						else if ($vend=='V003') {$cvend='SRIWIJAYA CARGO';}
						else {$cvend='NA#';}
						session_start();
						$_SESSION['MM_tgl1']=$_POST['tgl1'];
						$_SESSION['MM_tgl2']=$_POST['tgl2'];
					  	include('config/koneksi.php');
						if ($vend=='') {
						$sql = mysql_query("SELECT *,ManifestWeight*ManifestTarip+ManifestAdmin AS JUMLAH, 
                                                    (ManifestWeight*ManifestTarip+ManifestAdmin)-TagihFare as SELISIH, 
                                                    ManifestWeight-TagihWeight as SELISIH0, 
                                                    if(TagihWeight>0,ActualWeight-TagihWeight, 
                                                    ActualWeight-ManifestWeight) as SELISIH1, 
                                                    ActualWeight*PSS+ManifestAdmin as AWBRP 
                                            from tblAirLineSMU left join tbAirLineDestin on ManifestDest=KODE 
                                            where ManifestDate BETWEEN '$t1' AND '$t2'");
						}
						else {
						$sql = mysql_query("SELECT *,ManifestWeight*ManifestTarip+ManifestAdmin AS JUMLAH, 
                                                    (ManifestWeight*ManifestTarip+ManifestAdmin)-TagihFare as SELISIH, 
                                                    ManifestWeight-TagihWeight as SELISIH0, 
                                                    if(TagihWeight>0,ActualWeight-TagihWeight, 
                                                    ActualWeight-ManifestWeight) as SELISIH1, 
                                                    ActualWeight*PSS+ManifestAdmin as AWBRP 
                                            from tblAirLineSMU left join tbAirLineDestin on ManifestDest=KODE 
                                            where ManifestDate BETWEEN '$t1' AND '$t2' and ManifestReff='$vend'");
						}
						}
						else {
					  	include('config/koneksi.php');
						$sql = mysql_query("SELECT *,ManifestWeight*ManifestTarip+ManifestAdmin AS JUMLAH, TagihFare-(ManifestWeight*ManifestTarip+20000) as SELISIH, TagihWeight-ManifestWeight as SELISIH0, ActualWeight-TagihWeight as SELISIH1, ActualWeight*PSS+ManifestAdmin as AWBRP from tblAirLineSMU left join tbAirLineDestin on ManifestDest=KODE where ManifestMAWBNo='NA#'");
						}
 					  $totkgvendor=0;
					  $totkgawb=0;
					  $no = 1;
					  $totrpops=0;
  					  $totrpven=0;
					  $totrpawb=0;
					  
                      while ($r = mysql_fetch_array($sql)) {
						$byk=number_format($r[ManifestQty]);
						$brt=number_format($r[ManifestWeight]);
						$nilai=number_format($r[JUMLAH]);
						$vbyk=number_format($r[TagihQty]);
						$vbrt=number_format($r[TagihWeight]);
						$vnilai=number_format($r[TagihFare]);
						$sbrt=number_format($r[SELISIH0]);
						$snilai=number_format($r[SELISIH]);
						$abrt=number_format($r[ActualWeight]);
						$arp=number_format($r[AWBRP]);
						$sabrt=number_format($r[SELISIH1]);
                        echo "<tr>
                            <td>$r[ManifestMAWBNo]</td>
                            <td>$r[ManifestDate]</td>
                            <td>$r[ManifestDest]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$nilai</td>
                            <td align='right'>$vbyk</td>
                            <td align='right'>$vbrt</td>
                            <td align='right'>$vnilai</td>
                            <td align='right'>$sbrt</td>
                            <td align='right'>$snilai</td>
                            <td align='right'>$abrt</td>
                            <td align='right'>$arp</td>
                            <td align='right'>$sabrt</td>
                            </tr>";
                        $no++;
						//if ($r[TagihWeight] > 0) {
						//	$totkgvendor=$totkgvendor+$r[TagihWeight];
						//}
						//else {
						//	$totkgvendor=$totkgvendor+$r[ManifestWeight];
						//}
						$totkgops=$totkgops+$r[ManifestWeight];
						$totkgvendor=$totkgvendor+$r[TagihWeight];
						$totkgawb=$totkgawb+$r[ActualWeight];
						$totrpops=$totrpops+$r[JUMLAH];
						$totrpven=$totrpven+$r[TagihFare];
						$totrpawb=$totrpawb+$r[AWBRP];
						if ($totkgvendor <= 0) {
							$brtX=$totkgops;
						}
						else
						{
							$brtX=$totkgvendor;
						}
                      } 
                   ?>
                </tbody>
            </table>
    </div>
    <div style="margin-left:5px">
    <br>
    <br>
    <strong>Vendor : <?php echo $cvend ?>
    <br>
    <br>
    <strong>Total Berat OPS : <?php echo number_format($totkgops) ?>
    <br>
    Total Berat Vendor : <?php echo number_format($totkgvendor) ?>
    <br>
    Total Berat AWB : <?php echo number_format($totkgawb) ?>
    <br>
    <br>
    Selisih berat OPS dan VENDOR : <?php echo number_format($totkgops-$totkgvendor) ?>
    <br>
    Selisih berat AWB dan OPS : <?php echo number_format($totkgawb-$totkgops) ?>
    <br>
    Selisih berat AWB dan VENDOR : <?php echo number_format($totkgawb-$brtX) ?></strong>
    <br>
	<?php
	if ($group=='ADMIN') {
    echo "<br>";
    echo "<strong>Total Biaya OPS : ".number_format($totrpops);
    echo "<br>";
    echo "Total Biaya Vendor : ".number_format($totrpven);
    echo "<br>";
    echo "Total Biaya AWB : ".number_format($totrpawb);
    echo "<br>";
    echo "<br>";
    echo "Selisih TAGIHAN OPS dan VENDOR : ".number_format($totrpops-$totrpven);
    echo "<br>";
    echo "Selisih TAGIHAN AWB dan OPS : ".number_format($totrpawb-$totrpops);
    echo "<br>";
    echo "Selisih TAGIHAN AWB dan VENDOR : ".number_format($totrpawb-$totrpven);
	echo "</strong>";
	}
    ?>
    </div>
</body>
</html>