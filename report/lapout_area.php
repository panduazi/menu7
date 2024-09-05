<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 $location = 11;
 //$cuser = $_SESSION['cuser'];
 //$group = $_SESSION['cgroup'];
 //$office = $_SESSION['coffice'];
 date_default_timezone_set('Asia/Jakarta');
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y');
 $tgl2=date('Y-m-d');   
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
						      "sSearch": "Filter: ", 
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
            $('#datatables2').dataTable({
					     "oLanguage": {
						      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
						      "sSearch": "Filter: ", 
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
            $('#datatables3').dataTable({
					     "oLanguage": {
						      "sLengthMenu": "Tampilkan _MENU_ data per halaman",
						      "sSearch": "Filter: ", 
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
    <form action="fmenu.php?hal=laparea" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan Outbound by Area</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
    <input type="submit" name="btpro2" id="btpro2" value="Submit">
    	</td>
    </tr>
    </table>
    </form>
    </div>
    
    <div class="easyui-tabs" style="width:100%;height:800">
        <div title="Propinsi" style="padding:10px">
            <div id="isi">
                <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">Area Tujuan</th>
                        <th align="right">Shipment</th>
                        <th align="right">%</th>
                        <th align="right">Berat Kg.</th>
                        <th align="right">%</th>
                        <th align="right">NILAI JUAL Rp.</th>
                        <th align="right">%</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL APPLY ----
  					  if (isset($_POST['btpro2'])) {
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
                      $sql0 = $koneksi->query("SELECT SUM(ConnoteBillAmount-ConnoteBillDisc) AS TNET,sum(ConnoteWeight) as TBERAT, count(*) as TSHIP 
                                          FROM tblConnote_odisys WHERE ConnoteDate between '$t1' and '$t2' 
                                          and ConnoteOrig=11 
                                          and ConnoteValid=1 
                                          and ConnoteBillCurrency='IDR'");

                      } else {
                      $sql0 = $koneksi->query("SELECT SUM(ConnoteBillAmount-ConnoteBillDisc) AS TNET,sum(ConnoteWeight) as TBERAT, count(*) as TSHIP 
                                          FROM tblConnote WHERE ConnoteDate between '$t1' and '$t2' 
                                          and ConnoteOrig=11 
                                          and ConnoteValid=1 
                                          and ConnoteBillCurrency='IDR'");

                      }
                      $r0 = mysqli_fetch_array($sql0);       
                      $tbyk=number_format($r0['TSHIP']);
                      $tbrt=number_format($r0['TBERAT']);
                      $tnet=number_format($r0['TNET']);

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
                      $sql = $koneksi->query("SELECT CityProvinsi, SUM(ConnoteBillAmount-ConnoteBillDisc) AS NET,sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP 
                                          FROM tblConnote_odisys left join tblCity on ConnoteDest=CityId 
                                          WHERE ConnoteDate between '$t1' and '$t2' 
                                          and ConnoteOrig=11 
                                          and ConnoteValid=1 
                                          and ConnoteBillCurrency='IDR' 
                                          group by CityProvinsi");

                      } else {
                      $sql = $koneksi->query("SELECT CityProvinsi, SUM(ConnoteBillAmount-ConnoteBillDisc) AS NET,sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP 
                                          FROM tblConnote left join tblCity on ConnoteDest=CityId 
                                          WHERE ConnoteDate between '$t1' and '$t2' 
                                          and ConnoteOrig=11 
                                          and ConnoteValid=1 
                                          and ConnoteBillCurrency='IDR' 
                                          group by CityProvinsi");

                      }
					  $no = 1;
                      while ($r = mysqli_fetch_array($sql)) {
						$byk=number_format($r['SHIP']);
						$brt=number_format($r['BERAT']);
						$net=number_format($r['NET']);
						$pbyk=number_format($r['SHIP']/$r0['TSHIP']*100,1);
						$pbrt=number_format($r['BERAT']/$r0['TBERAT']*100,1);
						$pnet=number_format($r['NET']/$r0['TNET']*100,1);
                        echo "<tr>
                            <td>$r[CityProvinsi]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$pbyk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$pbrt</td>
                            <td align='right'>$net</td>
                            <td align='right'>$pnet</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
                </table>
            </div>
        </div>    
        
        <div title="Kota/Kab" style="padding:10px">            
            <div id="isi2">
                <table id="datatables2" class="display">
                <thead>
                    <tr>
                        <th align="left">Kota/Kab</th>
                        <th align="left">Area</th>
                        <th align="right">Shipment</th>
                        <th align="right">%</th>
                        <th align="right">Berat Kg.</th>
                        <th align="right">%</th>
                        <th align="right">NILAI JUAL Rp.</th>
                        <th align="right">%</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL APPLY ----
  					  if (isset($_POST['btpro2'])) {
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
                      $sql0 = $koneksi->query("SELECT SUM(ConnoteBillAmount-ConnoteBillDisc) AS TNET,sum(ConnoteWeight) as TBERAT, count(*) as TSHIP 
                                          FROM tblConnote WHERE ConnoteDate between '$t1' and '$t2' 
                                          and ConnoteOrig=11 
                                          and ConnoteValid=1 
                                          and ConnoteBillCurrency='IDR'");
                      $r0 = mysqli_fetch_array($sql0);       
                      $tbyk=number_format($r0['TSHIP']);
                      $tbrt=number_format($r0['TBERAT']);
                      $tnet=number_format($r0['TNET']);

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
                      $sql = $koneksi->query("SELECT CityId, CityName, CityProvinsi, SUM(ConnoteBillAmount-ConnoteBillDisc) AS NET,sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP 
                                          FROM tblConnote_odisys left join tblCity on ConnoteDest=CityId 
                                          WHERE ConnoteDate between '$t1' and '$t2' 
                                          and ConnoteOrig=11 
                                          and ConnoteValid=1 
                                          and ConnoteBillCurrency='IDR' 
                                          group by CityId,CityName,CityProvinsi");

                    } else {
                      $sql = $koneksi->query("SELECT CityId, CityName, CityProvinsi, SUM(ConnoteBillAmount-ConnoteBillDisc) AS NET,sum(ConnoteWeight) as BERAT, count(ConnoteNo) as SHIP 
                                          FROM tblConnote left join tblCity on ConnoteDest=CityId 
                                          WHERE ConnoteDate between '$t1' and '$t2' 
                                          and ConnoteOrig=11 
                                          and ConnoteValid=1 
                                          and ConnoteBillCurrency='IDR' 
                                          group by CityId,CityName,CityProvinsi");

                    }

					  $no = 1;
                      while ($r = mysqli_fetch_array($sql)) {
						$byk=number_format($r['SHIP']);
						$brt=number_format($r['BERAT']);
						$net=number_format($r['NET']);
                        $pbyk=number_format($r['SHIP']/$tbyk*100,1);
						$pbrt=number_format($r['BERAT']/$tbrt*100,1);
						$pnet=number_format($r['NET']/$tnet*100,1);
                        echo "<tr>
                            <td>$r[CityName]</td>
                            <td>$r[CityProvinsi]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$pbyk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$pbrt</td>
                            <td align='right'>$net</td>
                            <td align='right'>$pnet</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
                </table>
            </div>
        </div>

        <div title="Moda Tonase per Kota/Kab" style="padding:10px">            
            <div id="isi2">
                <table id="datatables3" class="display">
                <thead>
                    <tr>
                        <th align="left">Kota/Kab</th>
                        <th align="left">Area</th>
                        <th align="right">Udara Kg</th>
                        <th align="right">%</th>
                        <th align="right">Darat Kg.</th>
                        <th align="right">%</th>
                        <th align="right">Laut Kg.</th>
                        <th align="right">%</th>
                        <th align="right">TOTAL Kg.</th>
                        <th align="right">%</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
  					  //---jika tekan TOMBOL APPLY ----
  					  if (isset($_POST['btpro2'])) {
						$t1=$_POST['tgl1'];
						$t2=$_POST['tgl2'];
                        session_start();
                        $cuser=$_SESSION['cuser'];
						$_SESSION['MM_tgl1']=$_POST['tgl1'];
						$_SESSION['MM_tgl2']=$_POST['tgl2'];
						}
  					  else {
						$t1='1900-01-01';
						$t2='1900-01-01';
                          }
                      $cSesi=$cuser.date('YmdHis');    
                      //cari total berat
                      $sql = $koneksi->query("SELECT sum(ConnoteWeight) as tkg from tblConnote 
                                        WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 
                                        and ConnoteBillCurrency='IDR'"); 
                      $r = mysqli_fetch_array($sql);
                      $totberat=$r[tkg];

                      //cari record yg via UDARA
                      $sql = $koneksi->query("SELECT ConnoteDest, sum(ConnoteWeight) as tkg
                                        from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                                        WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 
                                        and ConnoteBillCurrency='IDR' and ManifestMAWBNo is not NULL
                                        GROUP BY ConnoteDest"); 
                      while ($r = mysqli_fetch_array($sql)) {
                        $csql="insert into tempAnalis (Sesi,Mode,Key1,Nilai1) values('$cSesi','FALAH1',$r[ConnoteDest],$r[tkg])";
                        $isi_temp=$koneksi->query($csql);
                      }

                      //cari record yg via NON-UDARA (DARAT)
                      $sql = $koneksi->query("SELECT ConnoteDest, CityBts5, sum(ConnoteWeight) as tkg
                                        from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                                        left join tblCity on ConnoteDest=CityId
                                        WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 
                                        and ConnoteBillCurrency='IDR' 
                                        and CityBts5=1 
                                        and ManifestMAWBNo is NULL
                                        GROUP BY ConnoteDest"); 
                      while ($r1 = mysqli_fetch_array($sql)) {

                        $brt_drt=$r1['tkg'];
                        $brt_laut=0;

                      $csql_cari= $koneksi->query("select * from tempAnalis where Sesi='$cSesi' and Key1=$r1[ConnoteDest]");
                      $ketemu=mysqli_num_rows($csql_cari);
                      if($ketemu==1){ 	                        
                            $csql="update tempAnalis set Nilai2=$brt_drt,Nilai3=$brt_laut where Sesi='$cSesi' and Key1=$r1[ConnoteDest]";
                        }
                        else {
                            $csql="insert into tempAnalis (Sesi,Mode,Key1,Nilai2,Nilai3) values('$cSesi','FALAH1',$r1[ConnoteDest],$brt_drt,$brt_laut)";
                        }
                        $isi_temp=$koneksi->query($csql);
                      }

                      //cari record yg via NON-UDARA (LAUT)
                      $sql = $koneksi->query("SELECT ConnoteDest, CityBts5, sum(ConnoteWeight) as tkg
                                        from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                                        left join tblCity on ConnoteDest=CityId
                                        WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 
                                        and ConnoteBillCurrency='IDR' 
                                        and CityBts5=2 
                                        and ManifestMAWBNo is NULL
                                        GROUP BY ConnoteDest"); 
                      while ($r1 = mysqli_fetch_array($sql)) {

                        $brt_drt=0;
                        $brt_laut=$r1[tkg];;

                        $csql_cari= $koneksi->query("select * from tempAnalis where Sesi='$cSesi' and Key1=$r1[ConnoteDest]");
                        $ketemu=mysqli_num_rows($csql_cari);
                        if($ketemu==1){ 	                        
                            $csql="update tempAnalis set Nilai3=$brt_laut where Sesi='$cSesi' and Key1=$r1[ConnoteDest]";
                        }
                        else {
                            $csql="insert into tempAnalis (Sesi,Mode,Key1,Nilai2,Nilai3) values('$cSesi','FALAH1',$r1[ConnoteDest],$brt_drt,$brt_laut)";
                        }
                        $isi_temp=$koneksi->query($csql);
                      }

                      //tampilkan temp
                      $sql = $koneksi->query("SELECT * from tempAnalis left join tblCity on Key1=CityId WHERE Sesi='$cSesi'"); 
                      $no = 1;
                      $tot_udr=0;
                      $tot_drt=0;
                      $tot_lut=0;
                      while ($r3 = mysql_fetch_array($sql)) {
                        $udara=number_format($r3[Nilai1]);
                        $pudara=number_format($r3[Nilai1]/$totberat*100,2);
                        $darat=number_format($r3[Nilai2]);
                        $pdarat=number_format($r3[Nilai2]/$totberat*100,2);
                        $laut=number_format($r3[Nilai3]);
                        $plaut=number_format($r3[Nilai3]/$totberat*100,2);
                        $total=number_format($r3[Nilai1]+$r3[Nilai2]+$r3[Nilai3]);
                        $ptotal=number_format(($r3[Nilai1]+$r3[Nilai2]+$r3[Nilai3])/$totberat*100,2);
                        echo "<tr>
                            <td>$r3[CityName]</td>
                            <td>$r3[CityProvinsi]</td>
                            <td align='right'>$udara</td>
                            <td align='right'>$pudara</td>
                            <td align='right'>$darat</td>
                            <td align='right'>$pdarat</td>
                            <td align='right'>$laut</td>
                            <td align='right'>$plaut</td>
                            <td align='right'>$total</td>
                            <td align='right'>$ptotal</td>
                            </tr>";
                        $no++;
                        $tot_udr=$tot_udr+$r3[Nilai1];
                        $tot_drt=$tot_drt+$r3[Nilai2];
                        $tot_lut=$tot_lut+$r3[Nilai3];
                        
                        }                    
                        $tall=$tot_udr+$tot_drt+$tot_lut;
                        echo "<strong>";    
                        echo "PERIODE TGL : ".$t1." s.d ".$t2;
                        echo "<br>";
                        echo "TOTAL UDARA : ".number_format($tot_udr)." (".number_format($tot_udr/$tall*100,2)."%)";
                        echo "<br>";
                        echo "TOTAL DARAT : ".number_format($tot_drt)." (".number_format($tot_drt/$tall*100,2)."%)";
                        echo "<br>";
                        echo "TOTAL LAUT : ".number_format($tot_lut)." (".number_format($tot_lut/$tall*100,2)."%)";
                        echo "<br>";
                        echo "<br></strong>";
  
                    ?>
                    
                </tbody>
                </table>
            </div>
        </div>
    </div>       

</body>
</html>