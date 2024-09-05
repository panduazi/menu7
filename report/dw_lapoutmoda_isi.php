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
    <form action="fmenu.php?hal=lapmoda" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan Outbound by Moda</h2></td>
    </tr>
    <tr>
    <td><hr></td>
    </tr>
    <tr>
    	<td>Tanggal : <input class="easyui-datebox" name="tgl1" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl1] ?>">
    s.d. <input class="easyui-datebox" name="tgl2" type="text" data-options="formatter:myformatter,parser:myparser" value="<? echo $_SESSION[MM_tgl2] ?>">
        <select name="cbmoda" id="cbmoda">
   		    <option value='0'>Non Udara</option>
   		    <option value='1'>Udara</option>
  	    </select>
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
                        <th align="left">Connote No</th>
                        <th align="left">Tanggal</th>
                        <th align="left">Pengirim</th>
                        <th align="left">Sales</th>
                        <th align="left">Kota Tujuan</th>
                        <th align="left">Serv.</th>
                        <th align="right">Qty</th>
                        <th align="right">Kg.</th>
                        <th align="right">NILAI Rp.</th>
                        <th align="left">SMU/BL/RESI</th>
                        <th align="left">MODA ID</th>
                        <th align="left">DEST</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
  					  //---jika tekan TOMBOL APPLY ----
  					  if (isset($_POST['btpro3'])) {
						$t1=$_POST['tgl1'];
                        $t2=$_POST['tgl2'];
                        $moda=$_POST['cbmoda'];
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
                             from tblConnote 
                             left join tblAirLineSMU_AWB_tes on ConnoteNo=AWBNo
                             WHERE ConnoteDate between '$t1' and '$t2' 
                             and ConnoteOrig=11 
                             and ConnoteValid=1 
                             and ManifestMAWBNo is not NULL"); 
                      $r0 = mysql_fetch_array($sql0);       
                      $tbyk=number_format($r0[tqty]);
                      $tbrt=number_format($r0[tkg]);
                      $tnet=number_format($r0[tnilai]);
                      
                      echo "TOTAL SHIPMENT : ".$tbyk.", BERAT Kg. : ".$tbrt.", NILAI Rp : ".$tnet ;

                      $sql = mysql_query("SELECT ConnoteNo,ConnoteDate,CustomerSales,CustomerName,CityName,ServiceCode,
                             ConnoteQty,ConnoteWeight,ConnoteBillAmount-ConnoteBillDisc as NilaiJual,ManifestMAWBNo,ManifestAirline,ManifestDest                         
                             from tblConnote 
                             left join tblAirLineSMU_AWB_tes on ConnoteNo=AWBNo
                             left join tblCustomer on ConnoteCustNo=CustomerNo
                             left join tblCity on ConnoteDest=CityId
                             left join tblService on ConnoteService=ServiceId
                             WHERE ConnoteDate between '$t1' and '$t2' 
                             and ConnoteOrig=11 
                             and ConnoteValid=1 
                             and ManifestMAWBNo is not NULL"); 
                      $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
						    $byk=number_format($r[ConnoteQty]);
						    $brt=number_format($r[ConnoteWeight]);
						    $net=number_format($r[NilaiJual]);
                            echo "<tr>
                            <td>$r[ConnoteNo]</td>
                            <td>$r[ConnoteDate]</td>
                            <td>$r[CustomerName]</td>
                            <td>$r[CustomerSales]</td>
                            <td>$r[CityName]</td>
                            <td>$r[ServiceCode]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$brt</td>
                            <td align='right'>$net</td>
                            <td>$r[ManifestMAWBNo]</td>
                            <td>$r[ManifestAirline]</td>
                            <td>$r[ManifestDest]</td>
                            </tr>";
                            $no++;
                        }                    
                    ?>
                    
                </tbody>
            </table>
    </div>
</body>
</html>