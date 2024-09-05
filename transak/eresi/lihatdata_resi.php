<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Data Transaksi Akhir</title>        
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
        </script>
    </head>
    <body >
            <table id="datatables" class="display">
                <thead>
                    <tr>
                        <th align="left">NO. RESI</th>
                        <th align="left">TGL. RESI</th>
                        <th align="left">NAMA PENGIRIM</th>
                        <th align="left">NANAM DITUJU</th>
                        <th align="left">ALAMAT DITUJU</th>
                        <th align="left">LAYANAN</th>
                        <th align="left">CREATED</th>
                        <th align="center">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                
                    <?php
					  include('config/koneksi.php');
					  $sql = mysql_query("SELECT * FROM (tblconnote left join tblservice on ConnoteService=ServiceId) left join tblcity ON ConnoteDest=CityId WHERE ConnoteOffice='$office' ORDER by ConnoteRecId1 DESC LIMIT 10");
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
						  $angka1=number_format($r[ConnoteBillAmount]);
						  $angka2=number_format($r[ConnoteWeight]);
                        echo "<tr>
                            <td>$r[ConnoteNo]</td>
                            <td>$r[ConnoteDate]</td>
                            <td>$r[ConnoteCustName]</td>
                            <td>$r[ConnoteRecvName]</td>
                            <td>$r[ConnoteRecvAddr]</td>
                            <td>$r[ServiceName]</td>
							<td>$r[ConnoteRecId1]</td>
            				<td align='center'><a href='transak/eresi/print_eawb.php?noresi=".$r[ConnoteNo]."' target='_blank'>Print</a></td>							
                            </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
            </table>
    </body>
</html>
