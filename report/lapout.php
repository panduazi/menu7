<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 $location = 11;
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
    <form action="fmenu.php?hal=lapout" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan Outbound Shipment</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
    <label for="cbvalid"></label>
    Customer : 
    <select name="cbcust" id="cbcust">
        <?php 
    	  	include('config/koneksi.php'); 
		  	$sales=$koneksi->query("select CustomerNo,CustomerName from tblCustomer order by CustomerName");
   		  	echo "<option value=''>--pilih--</option>";
		  	while ($dsales=mysqli_fetch_array($sales))
		  	echo "<option value='$dsales[0]'>$dsales[1]</option>";
		?>
    </select>    
    <input type="submit" name="btproses" id="btproses" value="Submit">
    	</td>
    </tr>
    </table>
    </form>
    </div>
    
    <div id="isi">
            <table id="datatables" name="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">AWB No</th>
                        <th align="left">Tanggal</th>
                        <th align="left">Nama Pengirim</th>
                        <th align="left">Nama dituju</th>
                        <th align="left">Kota tujuan</th>
                        <th align="left">Kode tuj.</th>
                        <th align="left">Kode for.</th>
                        <th align="right">Banyak</th>
                        <th align="right">Berat</th>
                        <th align="right">Nilai</th>
                        <th align="center">Validasi</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL SAVE-BAGING ----
  					  if (isset($_POST['btproses'])) {
						$t1=$_POST['tgl1'];
						$t2=$_POST['tgl2'];
						$cust=$_POST['cbcust'];
						//session_start();
						//$_SESSION['MM_tgl1']=$_POST['tgl1'];
                        //$_SESSION['MM_tgl2']=$_POST['tgl2'];

					  	include('config/koneksi.php');
                        if ($t1 >= '2022-09-01') {
                        $sql0 = $koneksi->query("SELECT count(*) as tqty,sum(ConnoteWeight) as tbrt,
                          sum(ConnoteBillAmount-ConnoteBillDisc) as tnet
                          FROM tblConnote_odisys WHERE ConnoteDate BETWEEN '$t1' AND '$t2' AND ConnoteOrig=11 
                          AND ConnoteCustNo='$cust'");

                        } else {
                        $sql0 = $koneksi->query("SELECT count(*) as tqty,sum(ConnoteWeight) as tbrt,
                          sum(ConnoteBillAmount-ConnoteBillDisc) as tnet
                          FROM tblConnote WHERE ConnoteDate BETWEEN '$t1' AND '$t2' AND ConnoteOrig=11 
                          AND ConnoteCustNo='$cust'");
                        }




                        $r0 = mysqli_fetch_array($sql0);
                        $byk=number_format($r0['tqty']);
                        $brt=number_format($r0['tbrt']);
                        $net=number_format($r0['tnet']);
                        echo "<strong>";    
                        echo "PERIODE TGL : ".$t1." s.d ".$t2;
                        echo "<br>";
                        echo "TOTAL SHIPMENT : ".$byk;
                        echo "<br>";
                        echo "TOTAL BERAT Kg. : ".$brt;
                        echo "<br>";
                        echo "TOTAL NILAI JUAL Rp : ".$net;
                        echo "<br>";
                        echo "<br></strong>";
  
                        include('config/koneksi.php');
                        if ($t1 >= '2022-09-01') {
                        $sql = $koneksi->query("SELECT *,ConnoteBillAmount-ConnoteBillDisc AS NET FROM tblConnote_odisys left join tblCity on ConnoteDest=CityId
                                            WHERE ConnoteDate BETWEEN '$t1' AND '$t2' 
                                            AND ConnoteOrig=11 
                                            AND ConnoteCustNo='$cust'");
                        } else {
                        $sql =$koneksi->query("SELECT *,ConnoteBillAmount-ConnoteBillDisc AS NET FROM tblConnote left join tblCity on ConnoteDest=CityId
                                            WHERE ConnoteDate BETWEEN '$t1' AND '$t2' 
                                            AND ConnoteOrig=11 
                                            AND ConnoteCustNo='$cust'");                            
                        }



                        $no = 1;
                        while ($r = mysqli_fetch_array($sql)) {
						 $byk=number_format($r['ConnoteQty']);
                         $brt=number_format($r['ConnoteWeight']);
                         $tnet=number_format($r['NET']);
                         echo "<tr>";
                            echo "<td>".$r['ConnoteNo']."</td>";
                            echo "<td>".$r['ConnoteDate']."</td>";
                            echo "<td>".$r['ConnoteCustName']."</td>";
                            echo "<td>".$r['ConnoteRecvName']."</td>";
                            echo "<td>".$r['CityName']."</td>";
                            echo "<td>".$r['CityCode']."</td>";
                            echo "<td>".$r['CityForward']."</td>";
                            echo "<td align='right'>".$byk."</td>";
                            echo "<td align='right'>".$brt."</td>";
                            echo "<td align='right'>".$tnet."</td>";
                            echo "<td align='right'>".$r['ConnoteValid']."</td>";
                            echo "</tr>";
                         $no++;
                        }                    
                    }
                    ?>
                    
                </tbody>
            </table>
    </div>
</body>
</html>