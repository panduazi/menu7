<?php
date_default_timezone_set('Asia/Jakarta');
?>
<body>    
  <div class="easyui-tabs" style="width:100%;height:auto">
    <div title="by PERIODE" style="padding:5px">
      <div><h2>Monitoring/Rekap Invoice bendasarkan periode</h2></div>

      <table id="dg" class="easyui-datagrid" style="width:100%;height:500px"
          url="report/rekapinv/get_data.php"
          pagination="true" toolbar="#toolbar"
          rownumbers="false" fitColumns="true" singleSelect="true" pagesize=50>
        <thead>
          <tr>
            <th field="InvoiceDate">Tgl.Invoice</th>
            <th field="InvoiceNo">No.Invoice</th>
            <th field="InvoicePeriode">Periode</th>
            <th field="InvoiceName">Nama Pelangga</th>
            <th field="NILAI" align="right">Nilai Invoice (Rp.)</th>
            <th field="InvoiceSaldo_IDR" align="right">Sisa Piutang (Rp.)</th>
            <th field="CustomerSales">Sales</th>
            <th field="JBAYAR">Status</th>
            <th field="InvoiceStatusKet">Keterangan</th>
            <th field="InvoiceStatusDate">Inv. Update</th>
            <th field="CollKurir">Kolektor</th>
            <th field="CollDateStatus">Tgl. Action</th>
          </tr>
        </thead>
      </table>	

      <div id="toolbar">
         Periode <select class="easyui-combobox" id="per1" name="per1" style="width:75px;">
                <option value="2021/06">2021/06</option>
                <option value="2021/05">2021/05</option>
                <option value="2021/04">2021/04</option>
                <option value="2021/03">2021/03</option>
                <option value="2021/02">2021/02</option>
                <option value="2021/01">2021/01</option>
                <option value="2020/12">2020/12</option>
                <option value="2020/11">2020/11</option>
                <option value="2020/10">2020/10</option>
                <option value="2020/09">2020/09</option>
                <option value="2020/08">2020/08</option>
                <option value="2020/07">2020/07</option>
                <option value="2020/06">2020/06</option>
              </select>
              <select class="easyui-combobox" id="per2" name="per2" style="width:75px;">
                <option value="2021/07">2021/07</option>
                <option value="2021/06">2021/06</option>
                <option value="2021/05">2021/05</option>
                <option value="2021/04">2021/04</option>
                <option value="2021/03">2021/03</option>
                <option value="2021/02">2021/02</option>
                <option value="2021/01">2021/01</option>
                <option value="2020/12">2020/12</option>
                <option value="2020/11">2020/11</option>
                <option value="2020/10">2020/10</option>
                <option value="2020/09">2020/09</option>
                <option value="2020/08">2020/08</option>
              </select>
              <!--
              Status <select class="easyui-combobox" id="stat" name="stat" style="width:150px;">
                <option value="0">CREATE</option>
                <option value="1">COLLECTOR</option>
                <option value="2">K.BON/GIRO</option>
               <option value="3">CAMCEL</option>
                <option value="4">POSTING</option>
                <option value="5">PAYMENT</option>
                <option value="-1">CANCEL</option>
              </select>  
            -->
              <a href="javascript:void(0)" class="easyui-linkbutton c6" onclick="get_data()" style="width:50px">Submit</a>
              <a href="javascript:void(0)" class="easyui-linkbutton" onclick="excel_data()" >Export ke Excel</a>
      </div>
    </div>

    <div title="by PAID/CAIR" style="padding:5px">
        <div><h2>Monitoring/Rekap Invoice bendasarkan yang Cair</h2></div>
        <table id="dg2" class="easyui-datagrid" style="width:100%;height:500px"
                url="report/rekapinv/get_data_cair.php"
                pagination="true" toolbar="#toolbar2"
                rownumbers="false" fitColumns="false" singleSelect="true" pagesize=50>
          <thead>
          <tr>
            <th field="ByrDate">Tgl. Bayar</th>
            <th field="ByrAmmount_IDR"  align="right">Nilai Bayar</th>
            <th field="ByrVoucerNo">No. Jurnal</th>
            <th field="InvoiceNo">No.Invoice</th>
            <th field="InvoiceDate">Tgl.Invoice</th>
            <th field="InvoicePeriode">Periode</th>
            <th field="InvoiceSaldo_IDR" align="right">Sisa Piutang (Rp.)</th>
            <th field="InvoiceCustNo"No. Pelangan</th>
            <th field="InvoiceName">Nama Pelanggan</th>
            <th field="InvoiceAmmount_IDR"  align="right">Nilai (Rp.)</th>
          </tr>
          </thead>
        </table>	
        <div id='toolbar2'>
          <input name="tgl1" id="tgl1" type="text" class="easyui-datebox" data-options="
                  formatter:myformatter,
                  parser:myparser                
                  " value="<?php echo date('Y-m-d') ?>">
          <input name="tgl2" id="tgl2" type="text" class="easyui-datebox" data-options="
                  formatter:myformatter,
                  parser:myparser                
                  " value="<?php echo date('Y-m-d') ?>">
          <a href="javascript:void(0)" class="easyui-linkbutton c6" onclick="get_data_cair()" style="width:50px">Submit</a>
          <a href="javascript:void(0)" class="easyui-linkbutton" onclick="excel_data_cair()" >Export ke Excel</a>
        </div>

    </div>


  </div>        

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
      // $("#tgl1").datebox('textbox').bind('keydown', function(e){
      //   if(e.keyCode == 13){
      //     $("#tgl2").datebox('textbox').focus();
      //     return false;
      //   }
      // });
      // $("#tgl2").datebox('textbox').bind('keydown', function(e){
      //   if(e.keyCode == 13){
      //     $("#nmcust").textbox('textbox').focus();
      //     return false;
      //   }
      // });
    });

    function get_data(){
      var per1 = $("#per1").combobox('getValue');
      var per2 = $("#per2").combobox('getValue');
      //var status = $("#stat").combobox('getValue');
      //var url = 'report/rekapinv/get_data.php?per1='+per1+'&per2='+per2+'&status='+status;
      var url = 'report/rekapinv/get_data.php?per1='+per1+'&per2='+per2;
      $("#dg").datagrid('reload', url);
    }

    function get_data_cair(){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      var url = 'report/rekapinv/get_data_cair.php?tgl1='+tgl1+'&tgl2='+tgl2;
      $("#dg2").datagrid('reload', url);
    }

    function excel_data(){
      var p1 = $("#per1").combobox('getValue');
      var p2 = $("#per2").combobox('getValue');
      var url = 'report/rekapinv/excel.php?per1='+p1+'&per2='+p2; 
      window.open(url);

    }
    
    function excel_data_cair(){
      var p1 = $("#per1").combobox('getValue');
      var p2 = $("#per2").combobox('getValue');
      var url = 'report/rekapinv/excel_cair.php?per1='+p1+'&per2='+p2; 
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
