<?php
  //session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 $location = 11;
 //$cuser = $_SESSION['cuser'];
 //$group = $_SESSION['cgroup'];
 //$office = $_SESSION['coffice'];
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
    <form action="fmenu.php?hal=lapocust" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan Outbound Group Customer</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
    <input type="submit" name="btpro1" id="btpro1" value="Submit">
    	</td>
    </tr>
    </table>
    </form>
    </div>
    
    <div id="isi">
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">Account No.</th>
                        <th align="left">Nama Pelanggan</th>
                        <th align="left">Pengelola</th>
                        <th align="right">Shipment</th>
                        <th align="right">%</th>
                        <th align="right">Berat Kg.</th>
                        <th align="right">%</th>
                        <th align="right">NET Rp.</th>
                        <th align="right">%</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL SAVE-BAGING ----
  					  if (isset($_POST['btpro1'])) {
						$t1=$_POST['tgl1'];
						$t2=$_POST['tgl2'];
						//session_start();
						//$_SESSION['MM_tgl1']=$_POST['tgl1'];
						//$_SESSION['MM_tgl2']=$_POST['tgl2'];
						}
  					  else {
						$t1='1900-01-01';
						$t2='1900-01-01';
  						}
  				  	  include('config/koneksi.php');
                      if ($t1 >= '2022-09-01') {
                      $sql0 = $koneksi->query("SELECT sum(ConnoteBillAmount-ConnoteBillDisc) AS tNET, sum(ConnoteWeight) as tBERAT, count(ConnoteNo) as tSHIP
                                            FROM tblConnote_odisys 
                                            WHERE ConnoteDate between '$t1' and '$t2' 
                                            and ConnoteOrig=11 
                                            and ConnoteValid=1 
                                            and ConnoteBillCurrency='IDR'");

                      } else {
                      $sql0 = $koneksi->query("SELECT sum(ConnoteBillAmount-ConnoteBillDisc) AS tNET, sum(ConnoteWeight) as tBERAT, count(ConnoteNo) as tSHIP
                                            FROM tblConnote 
                                            WHERE ConnoteDate between '$t1' and '$t2' 
                                            and ConnoteOrig=11 
                                            and ConnoteValid=1 
                                            and ConnoteBillCurrency='IDR'");

                      }
                      $r0 = mysqli_fetch_array($sql0);       
                      $tbyk=number_format($r0['tSHIP']);
                      $tbrt=number_format($r0['tBERAT']);
                      $tnet=number_format($r0['tNET']);
                      echo "<strong>";    
                      echo "PERIODE TGL : ".$t1." s.d ".$t2;
                      echo "<br>";
                      echo "TOTAL SHIPMENT : ".$tbyk;
                      echo "<br>";
                      echo "TOTAL BERAT Kg.: ".$tbrt;
                      echo "<br>";
                      echo "TOTAL NILAI JUAL Rp : ".$tnet;
                      echo "<br>";
                      echo "<br></strong>";

                      if ($t1 >= '2022-09-01') {
                      $sql = $koneksi->query("SELECT ConnoteCustNo,CustomerName,CustomerKelola,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP 
                                          FROM tblConnote_odisys left join tblCustomer on ConnoteCustNo=CustomerNo 
                                          WHERE ConnoteDate between '$t1' and '$t2' 
                                                and ConnoteOrig=11 
                                                and ConnoteValid=1 
                                                and ConnoteBillCurrency='IDR' 
                                          GROUP BY ConnoteCustNo,CustomerName,CustomerKelola");
                      } else {
                      $sql = $koneksi->query("SELECT ConnoteCustNo,CustomerName,CustomerKelola,sum(ConnoteBillAmount) AS NILAI, sum(ConnoteBillDisc) AS DISC, sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, sum(ConnoteBillPack+ConnoteBillInsurance+ConnoteBillOther) AS OTH, sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP 
                                          FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
                                          WHERE ConnoteDate between '$t1' and '$t2' 
                                                and ConnoteOrig=11 
                                                and ConnoteValid=1 
                                                and ConnoteBillCurrency='IDR' 
                                          GROUP BY ConnoteCustNo,CustomerName,CustomerKelola");                        
                      }


					  $no = 1;
                      while ($r = mysqli_fetch_array($sql)) {
						$byk=number_format($r['SHIP']);
						$brt=number_format($r['BERAT']);
						$bruto=number_format($r['NILAI']);
						$disc=number_format($r['DISC']);
						$net=number_format($r['NET']);
						$pakas=number_format($r['OTH']);
						$pbyk=number_format($r['SHIP']/$r0['tSHIP']*100,1);
						$pbrt=number_format($r['BERAT']/$r0['tBERAT']*100,1);
						$pnet=number_format($r['NET']/$r0['tNET']*100,1);
                        echo "<tr>";
                            echo "<td>".$r['ConnoteCustNo']."</td>";
                            echo "<td>".$r['CustomerName']."</td>";
                            echo "<td>".$r['CustomerKelola']."</td>";
                             echo "<td align='right'>".$byk."</td>";
                             echo "<td align='right'>".$pbyk."</td>";
                             echo "<td align='right'>".$brt."</td>";
                             echo "<td align='right'>".$pbrt."</td>";
                             echo "<td align='right'>".$net."</td>";
                             echo "<td align='right'>".$pnet."</td>";
                            echo "</tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
            </table>
    </div>
</body>
</html>