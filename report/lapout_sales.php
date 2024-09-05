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
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y')-1;
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
    <form action="fmenu.php?hal=lapout_sales" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan Outbound Shipment Detail</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
    <label for="cbvalid"></label>
    Customer : 
    <label for="cbcust"></label>
    <select name="cbcust" id="cbcust" >
        	<?php 
    	  	include('config/koneksi.php'); 
		  	$sales=mysql_query("select PegawaiNo,PegawaiNama from tblPegawai where (PegawaiDept='MKT' or PegawaiDept='CSO') and PegawaiStatus > -1 order by PegawaiNama ",$koneksi);
   		  	echo "<option value=''>--pilih--</option>";
		  	while ($dsales=mysql_fetch_array($sales))
		  	echo "<option value='$dsales[1]'>$dsales[1]</option>";
		 	?>
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
                        <th align="left">AWB No</th>
                        <th align="left">Tanggal</th>
                        <th align="left">Nama Pengirim</th>
                        <th align="left">Nama dituju</th>
                        <th align="left">Tuj.</th>
                        <th align="right">Banyak</th>
                        <th align="right">Berat</th>
                        <th align="right">Nilai</th>
                        <th align="right">Kurir Pickup</th>
                        
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL SAVE-BAGING ----
  					  if (isset($_POST['btproses'])) 
					  {
						$t1=$_POST['tgl1'];
						$t2=$_POST['tgl2'];
						$cust=$_POST['cbcust'];
						session_start();
						$_SESSION['MM_tgl1']=$_POST['tgl1'];
						$_SESSION['MM_tgl2']=$_POST['tgl2'];
					  	include('config/koneksi.php');
						$sql = mysql_query("SELECT * FROM (tblConnote left join tblCity on ConnoteDest=CityId) left join tblCustomer on ConnoteCustNo=CustomerNo 
                                            WHERE ConnoteDate BETWEEN '$t1' AND '$t2' 
                                            AND ConnoteOrig=11 
                                            AND ConnoteValid = 1 
                                            AND ConnoteBillCurrency='IDR'
                                            AND tblCustomer.CustomerSales='$cust'");
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
						$byk=number_format($r[ConnoteQty]);
						$brt=number_format($r[ConnoteWeight]);
						$nl=number_format($r[ConnoteBillAmount]-$r[ConnoteBillDisc]);
                        echo "<tr>
                            <td>$r[ConnoteNo]</td>
                            <td>$r[ConnoteDate]</td>
                            <td>$r[ConnoteCustName]</td>
                            <td>$r[ConnoteRecvName]</td>
                            <td>$r[CityCode]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$nl</td>
							<td>$r[ConnoteCourierPickup]</td>
                            </tr>";
                        $no++;
  						}
                      }                    
                    ?>
                    
                </tbody>
            </table>
    </div>
</body>
</html>