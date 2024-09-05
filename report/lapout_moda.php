<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = 11;
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
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
						      "sSearch": "Filter : ", 
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
    <form action="fmenu.php?hal=lapmoda" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan Outbound moda UDARA/SMU berdasarkan TUJUAN</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
        <input type="submit" name="btpro3" id="btpro3" value="Submit">
    	</td>
    </tr>
    </table>
    </form>
    </div>
    
    <div id="isi">
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">TUJUAN</th>
                        <th align="right">Qty</th>
                        <th align="right">%</th>
                        <th align="right">Kg.</th>
                        <th align="right">%</th>
                        <th align="right">NILAI Rp.</th>
                        <th align="right">%</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL APPLY ----
  					  if (isset($_POST['btpro3'])) {
						$t1=$_POST['tgl1'];
                        $t2=$_POST['tgl2'];
						session_start();
						$_SESSION['MM_tgl1']=$_POST['tgl1'];
						$_SESSION['MM_tgl2']=$_POST['tgl2'];
						}
  					  else {
						$t1='1900-01-01';
						$t2='1900-01-01';
  						}
                      include('config/koneksi.php');
                      $sql0 = mysql_query("SELECT sum(ConnoteQty) as tqty, sum(ConnoteWeight) as tkg, sum(ConnoteBillAmount-ConnoteBillDisc) as tnilai
                             from tblConnote WHERE ConnoteDate between '$t1' and '$t2' 
                             and ConnoteOrig=11 
                             and ConnoteValid=1
                             and ConnoteBillCurrency='IDR'"); 
                      $sr0 = mysql_fetch_array($sql0);       
                      $byk=$sr0[tqty];
                      $brt=$sr0[tkg];
                      $net=$sr0[tnilai];
                      $tbyk=number_format($sr0[tqty]);
                      $tbrt=number_format($sr0[tkg]);
                      $tnet=number_format($sr0[tnilai]);
                      echo "<br><strong>";    
                      echo "PERIODE TGL : ".$t1." s.d ".$t2;
                      echo "<br>";
                      echo "TOTAL SHIPMENT : ".$tbyk.", BERAT Kg. : ".$tbrt.", NILAI JUAL Rp : ".$tnet."<br></strong>";
                      
                      include('config/koneksi.php');
                      $sql1 = mysql_query("SELECT sum(ConnoteQty) as tqty, sum(ConnoteWeight) as tkg, sum(ConnoteBillAmount-ConnoteBillDisc) as tnilai
                             from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                             WHERE ConnoteDate between '$t1' and '$t2' 
                             and ConnoteOrig=11 
                             and ConnoteValid=1 
                             and ConnoteBillCurrency='IDR'
                             and ManifestMAWBNo is not NULL"); 
                      $r1 = mysql_fetch_array($sql1);       
                      $tsbyk=number_format($r1[tqty]);
                      $tsbrt=number_format($r1[tkg]);
                      $tsnet=number_format($r1[tnilai]);
                      $bbyk=$r1[tqty];
                      $bbrt=$r1[tkg];
                      $bnet=$r1[tnilai];

                      $psbyk=number_format($r1[tqty]/$byk*100,1);
                      $psbrt=number_format($r1[tkg]/$brt*100,1);
                      $psnet=number_format($r1[tnilai]/$net*100,1);
                      
                      echo "<br><strong>";
                      echo "SHIPMENT UDARA : ".$tsbyk." -> ".$psbyk."%"."<br>";
                      echo "BERAT UDARA Kg.: ".$tsbrt." -> ".$psbrt."%"."<br>";
                      echo "NILAI JUAL UDARA : ".$tsnet." -> ".$psnet."%"."<br>";
                      echo "<br></strong>";

                      include('config/koneksi.php');
                      $sql = mysql_query("SELECT ManifestDest,sum(ConnoteQty) as tqty, sum(ConnoteWeight) as tkg, sum(ConnoteBillAmount-ConnoteBillDisc) as tnet
                             from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                             WHERE ConnoteDate between '$t1' and '$t2' 
                             and ConnoteOrig=11 
                             and ConnoteValid=1 
                             and ConnoteBillCurrency='IDR'
                             and ManifestMAWBNo is not NULL
                             GROUP BY ManifestDest"); 
                      $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
                        $byk=number_format($r[tqty]);
                        $brt=number_format($r[tkg]);
                        $net=number_format($r[tnet]);

                        $abyk=number_format($r[tqty]/$bbyk*100,1);
                        $abrt=number_format($r[tkg]/$bbrt*100,1);
                        $anet=number_format($r[tnet]/$bnet*100,1);
                        echo "<tr>
                            <td>$r[ManifestDest]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$abyk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$abrt</td>
                            <td align='right'>$net</td>
                            <td align='right'>$anet</td>
                            </tr>";
                            $no++;
                        }                    
                    ?>
                    
                </tbody>
            </table>
    </div>
</body>
</html>