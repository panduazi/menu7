<?php
date_default_timezone_set('Asia/Jakarta');
?>


<body>    
  <div style="margin:10px;">

    <h2>Daftar Outstanding dan Riwayat Invoice</h2>
    <hr>
    <form id="form_data" class="on_enter">
    <table>
      <tr>
          <td>
          Periode : <select class="easyui-combobox" id="per1" name="per1" style="width:75px;">
              </select>
            <a href="javascript:void(0)" class="easyui-linkbutton c6" onclick="get_data()" style="width:50px">Submit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="excel_data()" >Export ke Excel</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="loginv()" >Lihat riwayat</a>

          </td>
      </tr>
    </table>  
    </form>
  </div>  

         
	<table id="dg" class="easyui-datagrid" style="width:100%;height:300px"
			url="report/piutang/get_data.php"
		  pagination="true" 
			rownumbers="false" fitColumns="false" singleSelect="true" pagesize=50>
		<thead>
			<tr>
        <th field="InvoicePeriode">Pedriode</th>
        <th field="InvoiceDate">Tgl.Inv</th>
        <th field="InvoiceNo">No.Invoice</th>
        <th field="InvoiceName">Nama pelanggan</th>
        <th field="NILAI" align="right">Nilai Inv.</th>
        <th field="InvoiceSaldo_IDR" align="right">Saldo Rp.</th>
        <th field="CustomerSales">Sales awal</th>
        <th field="ldate0">Kunj. akhir</th>
        <th field="ldate1">Realisasi</th>
        <th field="InvoiceStatusKet">Uraian/Keterangan</th>
			</tr>
		</thead>
	</table>	

  <div style="margin:10px;">
  </div>

  <table id="dglog" class="easyui-datagrid" style="width:50%;height:200"
			url="" rownumbers="false" fitColumns="false" singleSelect="true">
		<thead>
			<tr>
        <th field="ActionDesc">Status/Ket</th>
        <th field="ActionDate">Tgl.Lanjutan/Ket</th>
        <th field="CreateBy">EDP</th>
        <th field="RecId">Create timestamp</th>
			</tr>
		</thead>
	</table>	

  <?php 
    include 'jq/on_enter.php';
  ?>


	<script>
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
	
    $(document).ready(function(){
      $("#tgl1").datebox('textbox').bind('keydown', function(e){
        if(e.keyCode == 13){
          $("#tgl2").datebox('textbox').focus();
          return false;
        }
      });
      $("#tgl2").datebox('textbox').bind('keydown', function(e){
        if(e.keyCode == 13){
          $("#nmcust").textbox('textbox').focus();
          return false;
        }
      });
    });

    function get_data(){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      // var cust = $("#nocust").val();      
      var url = 'report/jadwalbayar/get_data.php?date1='+tgl1+'&date2='+tgl2;
      $("#dg").datagrid('reload', url);
    }

    function loginv(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
        url = 'report/piutang/get_logkoletor.php?noinv='+row.InvoiceNo; 
        //alert(url);
        $("#dglog").datagrid('reload', url);
			}
    }

    function excel_data(){
      var url = 'report/piutang/excel.php'; 
      window.open(url);

    }
    
    function csv_data(){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      // var cust = $("#nocust").val();  
      var url = 'master/penjualan_agen/csv.php?date1='+tgl1+'&date2='+tgl2; 
      window.open(url);

    }


    function printAwb(no){
      window.open('transak/outbound/print_awb_new_cash.php?no_connote='+ no);
    }

    function reset_data(){
      $("#dg").datagrid('loadData', []);
      $('#form_data').form('clear');
      $("#tgl1").datebox('setValue', '<?php echo date('Y-m-d') ?>');
      $("#tgl2").datebox('setValue', '<?php echo date('Y-m-d') ?>');           
    }

	</script>

</body>
