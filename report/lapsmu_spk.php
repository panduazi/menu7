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
    <form action="fmenu.php?hal=lapspk" method="post">
    <table width="100%">
    <tr>
    <td><h2>Laporan Monitoring SPK (Surat Perintah Kerja SMU)</h2></td>
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
                        <th align="left">Nomor SPK</th>
                        <th align="left">Tgl</th>
                        <th align="left">Dest</th>
                        <th align="left">Code</th>
                        <th align="left">No. SMU</th>
                        <th align="left">AirLine</th>
                        <th align="right">Qty</th>
                        <th align="right">Berat</th>
                        <th align="left">Vendor</th>
                        <th align="left">Status</th>
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
						session_start();
						$_SESSION['MM_tgl1']=$_POST['tgl1'];
						$_SESSION['MM_tgl2']=$_POST['tgl2'];
					  	include('config/koneksi.php');
						$sql = mysql_query("select tblAirLineSMU_tes.ManifestMAWBNo as nospk, tblAirLineSMU_tes.ManifestDate as tglspk, tblAirLineSMU_tes.ManifestReff as vendspk, tblAirLineSMU_tes.ManifestDest as destspk, tblAirLineSMU_tes.ManifestCarier as airspk, tblAirLineSMU.ManifestMAWBNo as nosmu, tblAirLineSMU.ManifestReff as vendsmu, tblAirLineSMU.ManifestCarier as airsmu, tblAirLineSMU.ManifestDest as destsmu, tblAirLineSMU.ManifestQty as qtysmu, tblAirLineSMU.ManifestWeight as brtsmu,if(tblAirLineSMU.status=0,'Sesuai','tdk.sesuai') as status, tblVendor.VendorName from (tblAirLineSMU_tes left join tblAirLineSMU on tblAirLineSMU_tes.ManifestMAWBNo = tblAirLineSMU.NoSPK) left join tblVendor on tblAirLineSMU.ManifestReff=tblVendor.VendorCode where tblAirLineSMU_tes.ManifestDate  BETWEEN '$t1' AND '$t2'
order by tblAirLineSMU_tes.ManifestMAWBNo");
						}
						else {
					  	include('config/koneksi.php');
						$sql = mysql_query("select tblAirLineSMU_tes.ManifestMAWBNo as nospk, tblAirLineSMU_tes.ManifestDate as tglspk, tblAirLineSMU_tes.ManifestReff as vendspk, tblAirLineSMU_tes.ManifestDest as destspk, tblAirLineSMU_tes.ManifestCarier as airspk, tblAirLineSMU.ManifestMAWBNo as nosmu, tblAirLineSMU.ManifestReff as vendsmu, tblAirLineSMU.ManifestCarier as airsmu, tblAirLineSMU.ManifestDest as destsmu, tblAirLineSMU.ManifestQty as qtysmu, tblAirLineSMU.ManifestWeight as brtsmu, tblAirLineSMU.status as status,tblVendor.VendorName from (tblAirLineSMU_tes left join tblAirLineSMU on tblAirLineSMU_tes.ManifestMAWBNo = tblAirLineSMU.NoSPK) left join tblVendor on tblAirLineSMU.ManifestReff=tblVendor.VendorCode where tblAirLineSMU_tes.ManifestMAWBNo='NA#'");
						}
                      while ($r = mysql_fetch_array($sql)) {
						$byk=number_format($r[qtysmu]);
						$brt=number_format($r[brtsmu]);
                        echo "<tr>
                            <td>$r[nospk]</td>
                            <td>$r[tglspk]</td>
                            <td>$r[destspk]</td>
                            <td>$r[airspk]</td>
                            <td>$r[nosmu]</td>
                            <td>$r[airsmu]</td>
                            <td align='right'>$byk</td>
                            <td align='right'>$brt</td>
                            <td>$r[VendorName]</td>
                            <td>$r[status]</td>
                            </tr>";
                        $no++;
                      } 
                   ?>
                </tbody>
            </table>
    </div>
    <div style="margin-left:5px">
    </div>
</body>
</html>