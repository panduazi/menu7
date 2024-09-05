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
    <form action="fmenu.php?hal=lappikup" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan PickUp Order</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
        <select name="cbkur" id="cbkur">
    	  <?php 
    	  include('config/koneksi.php');
		  $sales=mysql_query("select PegawaiNama from tblPegawai where PegawaiDept='OPS' order by PegawaiNama ",$koneksi);
		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[0]</option>";
		 ?>
  	  </select>
        </select>
    <input type="submit" name="btpro2" id="btpro2" value="Submit">
    	</td>
    </tr>
    </table>
    </form>
    </div>
    
    <div id="isi">
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">Tgl.Order</th>
                        <th align="left">Customer</th>
                        <th align="left">Alamat Pengambilan</th>
                        <th align="left">Kurir</th>
                        <th align="left">CSO1</th>
                        <th align="left">CSO2</th>
                        <th align="left">TIME</th>
                        <th align="left">ACTUAL</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL SAVE-BAGING ----
  					  if (isset($_POST['btpro2'])) {
						$t1=$_POST['tgl1'];
                        $kurir=$_POST['cbkur'];
						session_start();
						$_SESSION['MM_tgl1']=$_POST['tgl1'];
						$_SESSION['MM_kurir']=$_POST['cbkur'];
					  	include('config/koneksi.php');
						$sql =  mysql_query("SELECT *,date_format(POrderDate,'%Y-%m-%d') as TGL, 
                                date_format(POrderFinaldate,'%T') as FINAL 
                                FROM tblPickupOrder 
                                WHERE date_format(POrderDate,'%Y-%m-%d') = '$t1' and POrderKurir='$kurir'");
  						}
  					else {
						include('config/koneksi.php');
						$sql = mysql_query("SELECT * FROM tblPickupOrder WHERE POrderCustNo='x'");
  						}
					  
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
                        $sql1 = mysql_query("SELECT count(*) as QTY FROM tblConnote WHERE ConnoteCustNo='$r[POrderCustNo]' AND date_format(ConnoteDate,'%Y-%m-%d') = '$t1' ");  
                        $r0 = mysql_fetch_array($sql1);
                        echo "<tr>
                            <td>$r[TGL]</td>
                            <td>$r[POrderCustName]</td>
                            <td>$r[POrderCustAddr1]</td>
                            <td>$r[POrderKurir]</td>
							<td>$r[POrderCSO]</td>
							<td>$r[POrderCSO2]</td>
                            <td>$r[FINAL]</td>
                            <td>$r0[QTY]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                </tbody>
            </table>
    </div>
    <div>
        <?php
        echo "<a href='report/pickup/print_pu.php?tgl=".$_SESSION['MM_tgl1']."&kurir=".$_SESSION['MM_kurir']."' target='_blank'>Cetak ke Printer</a>";
        ?>
    </div>
</body>
</html>