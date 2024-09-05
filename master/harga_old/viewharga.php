<?php
 session_start();
 if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = 11;
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
 $office = $_SESSION['coffice'];
 
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
    <h2>DAFTAR KOTA & HARGA UMUM</h2>
    <div style="margin-bottom:10px">

    <div id="isi">
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">KODE POS.</th>
                        <th align="left">NAMA TUJUAN</th>
                        <th align="left">PROPINSI</th>
                        <th align="left">KODE</th>
                        <th align="left">FORWD</th>
                        <th align="right">EXP1</th>
                        <th align="right">REG1</th>
                        <th align="right">REG2</th>
                        <th align="right">EKO1</th>
                        <th align="right">EKO2</th>
                        <th align="right">MIN.EKO</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
  					  //---jika tekan TOMBOL SAVE-BAGING ----
  				  	  include('config/koneksi.php');
                      $sql = mysql_query("select * from tblPrice  
                                            left join tblCity on PriceCityID=CityId 
                                            order by CityName");
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
						$exp=number_format($r[PricePrima1]);
						$reg1=number_format($r[PriceExp1]);
						$reg2=number_format($r[PriceExp2]);
						$eko1=number_format($r[PriceEkono1]);
						$eko2=number_format($r[PriceEkono1]);
                        echo "<tr>
                            <td>$r[CityCountry]</td>
                            <td>$r[CityName]</td>
                            <td>$r[CityProvinsi]</td>
                            <td align='right'>$exp</td>
                            <td align='right'>$reg1</td>
                            <td align='right'>$reg2</td>
                            <td align='right'>$eko1</td>
                            <td align='right'>$eko2</td>
                            <td align='right'>$r[PriceEkonoLim]</td>
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
            </table>
    </div>
</body>
</html>