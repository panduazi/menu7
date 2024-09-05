<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = $_SESSION['clocation'];
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
 		<link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
 		<link rel="stylesheet" type="text/css" href="themes/icon.css">
 		<link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
 		<script type="text/javascript" src="jq/jquery.min.js"></script>
 		<script type="text/javascript" src="jq/jquery.easyui.min.js"></script>

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
    <form action="fmenu.php?hal=statoutcust" method="post">
    <table width="100%">
    <tr>
    <td style="font-size:16px"><h1>Statistik Outbound Shipment per Pelangan</h1></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
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
                        <th align="left">No Pelanggan</th>
                        <th align="left">Nama Pelanggan</th>
                        <th align="right">Ship.</th>
                        <th align="right">Berat</th>
                        <th align="right">Nilai (Rp.)</th>
                        <th align="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL SAVE-BAGING ----
  					  if (isset($_POST['btproses'])) {
						$t1=$_POST['tgl1'];
						$t2=$_POST['tgl2'];
						session_start();
						$_SESSION['MM_tgl1']=$_POST['tgl1'];
						$_SESSION['MM_tgl2']=$_POST['tgl2'];
					  	include('config/koneksi.php');
						$sql = mysql_query("SELECT ConnoteCustNo,CustomerName,sum(ConnoteWeight) as berat, count(ConnoteNo) as banyak, sum(ConnoteBillAmount-ConnoteBillDisc) as nilai FROM tblconnote left join tblcustomer on ConnoteCustNo=CustomerNo WHERE ConnoteDate BETWEEN '$t1' AND '$t2' AND ConnoteOrig=$location AND ConnoteValid>=0 GROUP BY ConnoteCustNo");
  						}
  					else {
						include('config/koneksi.php');
						$sql = mysql_query("SELECT ConnoteCustNo,CustomerName,sum(ConnoteWeight) as berat, sum(ConnoteNo) as banyak, sum(ConnoteBillAmount-ConnoteBillDisc) as nilai FROM tblconnote left join tblcustomer on ConnoteCustNo=CustomerNo WHERE ConnotenO='NA#' AND ConnoteOrig=$location GROUP BY ConnoteCustNo");
  						}
					  
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
						$byk=number_format($r[banyak]);
						$brt=number_format($r[berat],1);
						$jum=number_format($r[nilai],1);
                        echo "<tr>
                            <td>$r[ConnoteCustNo]</td>
                            <td>$r[CustomerName]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$jum</td>
                            <td align='center'>detail</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
            </table>
    </div>
</body>
</html>