<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Master Customer</title>
</head>
<body>
	<table id="dg" title="MASTER HARGA UMUM" class="easyui-datagrid" style="width:96%;height:550px"
			url="master/harga/get_harga.php?"
			toolbar="#toolbar" pagination="true" pagesize="50"
			rownumbers="false" fitColumns="true" singleSelect="true">
		<thead>
			<tr>
				<th field="CityCountry">Kodepos</th>
				<th field="CityName">NAMA TUJUAN</th>
				<th field="CityCode">KODE</th>
				<th field="CityForward">FOR</th>
				<th align="right" field="PriceExp1">REG1</th>
				<th align="right" field="PriceExp2">REG2</th>
				<th align="right" field="PriceEkono1">EKO1</th>
				<th align="right" field="PriceEkono2">EKO2</th>
				<th align="right" field="PriceEkonoLim">MIN.EKO</th>

			</tr>
		</thead>
	</table>
	<div id="toolbar">
		Nama tujuan yg dicari : <input name="carikota" id="carikota class=easyui-textbox">
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" onclick="findcity()">Filter</a>
		<!--
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">Edit Pegawai</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">Remove Pegawai</a>
		-->
	</div>
	
	
	<div id="dlg-buttons">
		<a href="javascript:void(0)" class="easyui-linkbutton c6" iconCls="icon-ok" onclick="saveUser()" style="width:90px">Save</a>
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')" style="width:90px">Cancel</a>
	</div>

	<script type="text/javascript">
		var url;
		function findcity(){
			var ckota = $("#carikota").text('getValue');
			var url = 'master/harga/get_harga.php?kota='+ckota;
			$("#dg").datagrid('reload', url);
	    }
	</script>
	
	<style type="text/css">
		#fm{
			margin:0;
			padding:10px 30px;
		}
		.ftitle{
			font-size:14px;
			font-weight:bold;
			padding:5px 0;
			margin-bottom:10px;
			border-bottom:1px solid #ccc;
		}
		.fitem{
			margin-bottom:5px;
		}
		.fitem label{
			display:inline-block;
			width:80px;
		}
		.fitem input{
			width:160px;
		}
	</style>
</body>
</html>