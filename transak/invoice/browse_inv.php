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
               <th>NO.INVOICE</th>
               <th align="left">TANGGAL</th>
               <th align="left">NAMA PELANGGAN</th>
               <th align="left">NILAI</th>
               <th align="left">SALES</th>
               <th align="center">ACTION</th>
               
           </tr>
        </thead>
        <tbody>
           <?php
			include('config/koneksi.php');
			$sql = mysql_query("SELECT InvoiceNo,InvoiceDate,InvoiceCustNo,InvoiceName, InvoiceAmmount_IDR-InvoiceDisc_IDR+InvoicePack_IDR+InvoiceIns_IDR+InvoiceOther_IDR as NILAI,CustomerSales FROM tblinvoice left join tblcustomer on InvoiceCustNo=CustomerNo");
			$no = 1;
            while ($r = mysql_fetch_array($sql)) {
                    echo "<tr>
                       <td>$r[InvoiceNo]</td>
                       <td>$r[InvoiceDate]</td>
                       <td>$r[InvoiceName]</td>
                       <td>$r[NILAI]</td>
                       <td>$r[CustomerSales]</td>
                       <td align='center'><a href='transak/invoice/print_inv.php?noinv=".$r[InvoiceNo]."' target='_blank'>Print</a></td>
                       </tr>";
                    $no++;
                   }
            ?>
         </tbody>
  </table>   
</body>
</html>
