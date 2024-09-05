<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $cawb=$_SESSION['MM_nobag'];
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
               <th align="left">DO NO.</th>
               <th align="left">DATE</th>
               <th align="left">PENGIRIM</th>
               <th align="left">PENERIMA</th>
               <th align="left">AWB NO</th>
               <th align="center">ACTION</th>
               
           </tr>
        </thead>
        <tbody>
           <?php
			include('config/koneksi.php');
			$sql = mysql_query("SELECT * FROM (tblproject_master left join tblcustomer on PCustNo=CustomerNo) left join tbllocation on POffice=LocId WHERE LocCity=$location order by Pno DESC LIMIT 100");
			$no = 1;
            while ($r = mysql_fetch_array($sql)) {
                    echo "<tr>
                       <td>$no</td>
                       <td>$r[PNo]</td>
                       <td>$r[PDate]</td>
                       <td>$r[CustomerName]</td>
                       <td>$r[PRecvName]</td>
                       <td>$r[PConnoteNo]</td>
                       <td align=center><a href='transak/packinglist/print_do.php?nodo=".$r[PNo]."' target='_blank'>Print</a></td>
                       </tr>";
                    $no++;
                   }
            ?>
         </tbody>
  </table>   
</body>
</html>
