<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="keywords" content="jquery,ui,easy,easyui,web">
	<meta name="description" content="easyui help you build your web page easily!">
	<title>Add search functionality in DataGrid - jQuery EasyUI Demo</title>
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/icon.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/themes/color.css">
    <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
    
	<script type="text/javascript">
		function doSearch(){
			$('#tt').datagrid('load',{
				itemid: $('#itemid').val(),
				productid: $('#productid').val()
			});
		}
	</script>
</head>
<body>
	<table id="tt" class="easyui-datagrid" style="width:100%;height:500px"
			url="report/lapcust_getdata.php"
			title="Searching" iconCls="icon-search" toolbar="#tb"
			rownumbers="true" pagination="true">
		<thead>
			<tr>
				<th field="ConnoteCustNo" width="150">Account No.</th>
				<th field="CustomerName" width="250">Customer Name</th>
				<th field="BERAT" width="80" align="right">Berat Kg.</th>
				<th field="SHIP" width="80" align="right">Qty</th>
				<th field="NILAI" width="150" align="right">Bruto Rp.</th>
				<th field="DISC" width="60" align="right">Disc Rp.</th>
				<th field="NET" width="150" align="right">NET Rp.</th>
				<th field="OTH" width="150" align="right">Ass/Pack</th>
			</tr>
		</thead>
	</table>
	<div id="tb" style="padding:3px">
		<span>Item ID:</span>
		<input id="itemid" style="line-height:26px;border:1px solid #ccc">
		<span>Product ID:</span>
		<input id="productid" style="line-height:26px;border:1px solid #ccc">
		<a href="#" class="easyui-linkbutton" plain="false" onClick="doSearch()">Search</a>
	</div>
</body>
</html>