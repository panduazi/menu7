<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $cawb=$_SESSION['MM_nobag'];
  $ckey=$_SESSION['MM_nodo'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi Akhir</title>        
    <link rel="stylesheet" href="style/layout.css" type="text/css" />
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
               <th>NO</th>
               <th align="left">KODE.</th>
               <th align="left">NAMA BARANG</th>
               <th align="left">SATUAN</th>
               <th align="left">JUMLAH</th>
               <th align="center">ACTION</th>
               
           </tr>
        </thead>
        <tbody>
           <?php
			include('config/koneksi.php');
			$sql = mysql_query("SELECT * FROM temppacklist left join tblproject_item on PackItem=ItemCode WHERE PackNo='$ckey'");
			$no = 1;
            while ($r = mysql_fetch_array($sql)) {
                    echo "<tr>
                       <td>$no</td>
                       <td>$r[PackItem]</td>
                       <td>$r[ItemName]</td>
                       <td>$r[ItemUnit]</td>
                       <td>$r[PackQty]</td>
                       <td align=center><a href='#'>Delete</a></td>
                       </tr>";
                    $no++;
                   }
            ?>
         </tbody>
  </table>   
</body>
</html>
