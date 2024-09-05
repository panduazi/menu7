<?php
date_default_timezone_set('Asia/Jakarta');
?>


<body>    
  <div style="margin:10px;">

    <h2>Daftar AWB yang ada diserver PSB</h2>
    <hr>
    <form id="form_data" class="on_enter">
    <table>
      <tr>
          <td>
              Tanggal: 
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
            <a href="javascript:void(0)" class="easyui-linkbutton c6" onclick="get_data()" style="width:50px">Submit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="uploadawb()" >Upload ke server</a>

          </td>
      </tr>
    </table>  
    </form>
  </div>  

	<table id="dg" class="easyui-datagrid" style="width:100%;height:480px"
			url="https://www.pandusiwibandung.co.id/tms/transak/outbound/api_resi.php"
		  pagination="true" 
			rownumbers="false" fitColumns="false" showFooter='true' singleSelect="true" pagesize=50>
		<thead>
			<tr>
        <th field="ConnoteNo">NOMOR AWB</th>
        <th field="ConnoteDate">TANGGAL</th>
        <th field="ConnoteCustName">NAMA PENGIRIM</th>
        <th field="ConnoteRecvName">NAMA DITUJU</th>
        <th field="CityName">KOTA TUJUAN</th>
        <th field="ConnoteQty" align="right">KOLI</th>
        <th field="ConnoteWeight" align="right">BERAT</th>
        <th field="ConnoteCreateBy">OPERATOR ENTRY</th>
        <th field="ConnoteRecId1">WAKTU ENTRY</th>
        

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
      var url = 'https://www.pandusiwibandung.co.id/tms/transak/outbound/api_resi.php';
      //var url = 'report/upload_awb_odisys/get_data.php?date1='+tgl1+'&date2='+tgl2;
      $("#dg").datagrid('reload', url);
    }

    function uploadawb(no){
      var tgl1 = $("#tgl1").datebox('getValue');
      var tgl2 = $("#tgl2").datebox('getValue');
      window.open('report/upload_awb_odisys/up_awb_odisys_isi.php?date1='+tgl1+'&date2='+tgl2);
      var url = 'report/upload_awb_odisys/get_data.php?date1='+tgl1+'&date2='+tgl2;
      $("#dg").datagrid('reload', url);
    }

	</script>

</body>
