<?php
date_default_timezone_set('Asia/Jakarta');
include 'jq/on_enter.php';
?>


<body>    
  <div style="margin:10px;">
    <form id="form_data" class="on_enter">
    <table>
      <tr>
          <td>
              <strong>REAKAPITLASI PENJUALAN TANGGAL :</strong>
          </td>
          <td>
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
            <a href="javascript:void(0)" class="easyui-linkbutton c6" onclick="get_data()" style="width:50px">Cari</a>
            <!-- 
              <a href="javascript:void(0)" class="easyui-linkbutton" onclick="excel_data()" >Export ke Excel</a>
            -->
          </td>
      </tr>
    </table>  
    </form>
  </div>  

  <div class="easyui-tabs" style="width:90%;height:auto">
    <div title="BY CUSTOMER" style="padding:5px">
      <table id="dgcust" class="easyui-datagrid" style="width:100%;height:auto"
          url="#"
          pagination="true" 
          showFooter='true'
          rownumbers="false" 
          fitColumns="false" 
          singleSelect="true" 
          pagesize=50>
        <thead>
          <tr>
            <th field="CustomerName">NAMA PELANGGAN</th>
            <th field="SHIP" align="right">SHIPMENT</th>
            <th field="NILAI" align="right">NILAI JUAL (Rp.)</th>
            <th field="BERAT" align="right">BERAT (Kg.)</th>
            <th field="CustomerKelola">PENGELOLA</th>
          </tr>
        </thead>
      </table>  
      <div style="margin:10px;"></div>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="excel_data1()" >Export ke Excel</a>

    </div>
    <div title="BY SALES" style="padding:5px">
    	<table id="dg" class="easyui-datagrid" style="width:100%;height:auto"
    			url="#"
    		  pagination="true" 
    			rownumbers="false" fitColumns="false" showFooter='true' singleSelect="true" pagesize=20>
    		<thead>
    			<tr>
            <th field="CustomerKelola">NAMA PENGELOLA</th>
            <th field="SHIP" align="right">SHIPMENT</th>
            <th field="NILAI" align="right">NILAI JUAL (Rp.)</th>
            <th field="BERAT" align="right">BERAT (Kg.)</th>
    			</tr>
    		</thead>
    	</table>	
      <div style="margin:10px;"></div>
      <a href="javascript:void(0)" class="easyui-linkbutton" onclick="excel_data2()" >Export ke Excel</a>

    </div>
    <div title="BY AREA" style="padding:5px">
      <table id="dgarea" class="easyui-datagrid" style="width:100%;height:auto"
          url="#"
          pagination="true" 
          rownumbers="false" fitColumns="false" singleSelect="true" pagesize=50>
        <thead>
          <tr>
            <th field="CityProvinsi">NAMA PROPINSI</th>
            <th field="SHIP" align="right">SHIPMENT</th>
            <th field="NILAI" align="right">NILAI JUAL (Rp.)</th>
            <th field="BERAT" align="right">BERAT (Kg.)</th>
          </tr>
        </thead>
      </table>  
    </div>

  </div>


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
      var url = 'report/rekapsales/get_data.php?date1='+tgl1+'&date2='+tgl2;
      var url2 = 'report/rekapsales/get_data2.php?date1='+tgl1+'&date2='+tgl2;
      var url3 = 'report/rekapsales/get_data3.php?date1='+tgl1+'&date2='+tgl2;
      $("#dg").datagrid('reload', url);
      $("#dgcust").datagrid('reload', url2);
      $("#dgarea").datagrid('reload', url3);
    }

    function excel_data1(){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      // var cust = $("#nocust").val();  
      var url = 'report/rekapsales/excel.php?date1='+tgl1+'&date2='+tgl2; 
      window.open(url);
    }

    function excel_data2(){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      // var cust = $("#nocust").val();  
      var url = 'report/rekapsales/excel2.php?date1='+tgl1+'&date2='+tgl2; 
      window.open(url);
    }
    
    function csv_data(){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      // var cust = $("#nocust").val();  
      var url = 'master/rekapsales/csv.php?date1='+tgl1+'&date2='+tgl2; 
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
