<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
	<link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="/themes/color.css">
	<script type="text/javascript" src="jq/jquery.min.js"></script>
	<script type="text/javascript" src="jq/jquery.easyui.min.js"></script>
    <script>
        function submitForm(){
            $('#ff').form('submit');
            $('#ff').form('clear');
        }
        function clearForm(){
            $('#ff').form('clear');
        }
    </script>
    
</head>
<div class="easyui-panel" title="Entry Transaksi Courier" style="width:80%;height:500px;padding:10px;">
  <form id="ff" method="post" action="savekurir.php">
    <table cellpadding="2" id="table">
      <tr>
        <td>No.AWB</td>
        <td><input class="easyui-textbox" 
             type="text" 
             name="noawb" 
             size="12"
             data-options="required:true">
             </input>
        </td>
        <td>Reff.No</td>
        <td><input class="easyui-textbox" 
             type="text" 
             name="reffawb"
             size="20" 
             </input>
         </td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td><input class="easyui-datebox"
             size="12" 
             name="tglawb" 
             data-options="required:true">
             </input> 
        </td>
      </tr>
      <tr>
        <td>Pelanggan</td>
        <td><select class="easyui-combobox" name="cbcust" id="cbcust">
            <?php 
    	    include('config/koneksi.php'); 
		    $sales=mysql_query("select CustomerNo,CustomerName from tblcustomer order by CustomerName",$koneksi);
   		    echo "<option value=''>--pilih--</option>";
		    while ($dcust=mysql_fetch_array($sales))
		    echo "<option value='$dcust[0]'>$dcust[1]</option>";
		    ?>
            </select>
        </td>
      </tr>
      <tr>
        <td>Nama dituju</td>
        <td><input 
             name="namatuj" 
             type="text" class="easyui-textbox" size="30" 
             data-options="required:true">
             </input>
        </td>
      </tr>
      <tr>
        <td>Alamat</td>
        <td><input 
             name="almtuj" class="easyui-textbox" 
             style="height:50px" size="30" 
             data-options="multiline:true">
             </input>
        </td>
      </tr>
      <tr>
        <td>Telp/HP</td>
        <td><input 
             name="telptuj" class="easyui-textbox" 
             size="20" 
             </input>
        </td>
      </tr>
      <tr>
        <td>Kota tujuan</td>
        <td><select class="easyui-combobox" name="cbdest" id="cbdest">
            <?php 
    	    include('config/koneksi.php'); 
		    $sales=mysql_query("select PriceID,PriceCityName from tblprice order by PriceCityName",$koneksi);
   		    echo "<option value=''>--pilih--</option>";
		    while ($dcust=mysql_fetch_array($sales))
		    echo "<option value='$dcust[0]$dcust[1]'>$dcust[1]</option>";
		    ?>
            </select>
        </td>
      </tr>  
      <tr>
        <td>Layanan</td>
        <td><select class="easyui-combobox" name="cbservis" id="cbservis">
            <?php 
    	    include('config/koneksi.php'); 
		    $sales=mysql_query("select ServiceId,ServiceName from tblservice order by ServiceId",$koneksi);
   		    echo "<option value=''>--pilih--</option>";
		    while ($dcust=mysql_fetch_array($sales))
		    echo "<option value='$dcust[0]'>$dcust[1]</option>";
		    ?>
            </select>
        </td>

        <td>Berat</td>
        <td><input 
             name="berat" 
             type="text" class="easyui-numberbox" 
             value="1" 
             size="3" 
             maxlength="3" 
             data-options="required:true">
             </input>Kg.
        </td>
        <td>Banyak</td>
        <td><input class="easyui-numberbox" 
             type="text" 
             name="banyak" 
             value="1" 
             size="3" 
             maxlength="3" 
             data-options="required:true">
             </input>
        </td>
      </tr>
      </tr>
      <tr>
        <td>Isi kiriman</td>
        <td><input class="easyui-textbox" 
             type="text" 
             name="isi" 
             </input>
        </td>
      </tr>
    </table>
  </form>
        <div style="text-align:left;padding:5px">
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">Submit</a>
            <a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()">Clear</a>
        </div>
        </div>
    </div>

</div>


<body>
</body>
</html>