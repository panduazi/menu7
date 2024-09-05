<?php
date_default_timezone_set('Asia/Jakarta');
?>


<body>    
  <div style="margin:10px;">

    <h2>Monitoring kolektor yang bawa Invoice</h2>
    <hr>
    <form id="form_data" class="on_enter">
    <table>
      <tr>
          <td>
          <input name="cbcust" id="cbcust" class="easyui-combobox" size="30" data-options="                               
                prompt:'pilih nama pelanggan',
                url:'report/monitorinv/get_cust.php',
                method:'get',
                valueField:'CustomerNo',
                textField:'CustomerName'
              ">
          </td>
          <td>
          Periode: 
          <input name="tgl1" id="tgl1" type="text" class="easyui-datebox" data-options="
            formatter:myformatter,
            parser:myparser,
            onSelect: function(){
              $('#tgl2').datebox('textbox').focus();
            }
            " value="<?php echo date('Y-m-d') ?>" size="12"/>
            <input name="tgl2" id="tgl2" type="text" class="easyui-datebox" data-options="
              formatter:myformatter,
              parser:myparser,                
              " 
            value="<?php echo date('Y-m-d') ?>" size="12"/> 
            <a href="javascript:void(0)" class="easyui-linkbutton c6" onclick="get_data()" style="width:50px">Submit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="excel_data()" >Export ke Excel</a>

          </td>
      </tr>
    </table>  
    </form>
  </div>  

	<table id="dg" class="easyui-datagrid" style="width:100%;height:480px"
			url="report/monitorinv/get_data.php"
		  pagination="true" 
			rownumbers="false" fitColumns="false" singleSelect="true" pagesize=50>
		<thead>
			<tr>
        <th field="InvoiceName">Pelanggan</th>
        <th field="CustomerSalesFirst">Sales</th>
        <th field="CollInvNo">No.Invoice</th>
        <th field="InvoicePeriode">Periode</th>
        <th field="InvoiceDate">Tgl. Invoice</th>
        <th field="ByrAmmount_IDR" align="right">Nilai Rp.</th>
        <th field="InvoiceSaldo_IDR" align="right">Saldo Rp.</th>
        <th field="TGL">Tgl.Action</th>
        <th field="JBAYAR">Status</th>
        <th field="CollKurir">Kolektor</th>
        <th field="CollKet">Keterangan/Uraian</th>
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
      var cust = $("#cbcust").combobox('getValue');      
      var url = 'report/monitorinv/get_data.php?date1='+tgl1+'&date2='+tgl2+'&cust='+cust;
      console.log(url);
      $("#dg").datagrid('reload', url);
    }

    function excel_data(){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      // var cust = $("#nocust").val();  
      var url = 'report/monitorinv/excel.php?date1='+tgl1+'&date2='+tgl2; 
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
