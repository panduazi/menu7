<?php
  session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 $location = $_SESSION['cloc'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['MM_UserGroup'];
 $hari_ini=date('m/d/Y');
 $tglresi=date('m/d/Y')-1;
 $tgl2=date('Y-m-d');   
 
 //---jika tekan TOMBOL Save ----
 if (isset($_POST['btsave'])) {
		$cnoresi = $_POST['noresi'];
		$dtglresi = $_POST['tglresi'];
		$cnocust = substr($_POST['nmcust'],0,15);
		$cnmcust = substr($_POST['nmcust'],16,50);
		$cnmrecv = $_POST['nmrecv'];
		$calrecv1 = $_POST['alrecv1'];
		$calrecv2 = $_POST['alrecv2'];
		$calrecv3 = $_POST['alrecv3'];
		$ndest = $_POST['cbdest'];
		$cketisi = $_POST['ketisi'];
		$nbayar = $_POST['jnsbayar'];
		$nberat = $_POST['berat'];
		$service = $_POST['cbserv'];
		$q = "INSERT IGNORE INTO tblConnote(ConnoteNo, ConnoteDate, ConnoteDest, ConnoteCustNo, ConnoteCustName, ConnoteRecvName, ConnoteRecvAddr1, ConnoteRecvAddr2, ConnoteRecvAddr3, ConnoteContents, ConnotePayment, ConnoteWeight, ConnoteService, ConnoteRecId1, ConnoteRecId2, ConnoteCreateBy, ConnoteModiBy) VALUES ('".$cnoresi."','".$dtglresi."','".$ndest."','".$cnocust."','".$cnmcust."','".$cnmrecv."','".$calrecv1."','".$calrecv2."','".$calrecv3."','".$cketisi."','".$nbayar."','".$nberat."','".$service."',now(),now(),'".$user."','".$user."')";
  include('config/koneksi.php');	
  $r=mysql_query($q) or die(mysql_error());
  if ($r) {
	$msg="Berhasil";
	//buat cetak ke printer
	
    }
    else {$msg="Gagal";
	}
  } //-akhir dari Tombol SAVE
  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>Entry Resi</title>
 <script>
 function cekform()
  {
   if (document.getElementById('tglresi').value=='')
    {
	 alert('Tanggal masih kosong ...');
	 return false;
	}
   if (document.getElementById('noresi').value=='')
    {
	 alert('Nomor AWB masih kosong ...');
	 return false;
	}
   if (document.getElementById('service').value=='')
    {
	 alert('Jenis layanan belum dipilih ...');
	 return false;
	}
   if (document.getElementById('berat').value=='0')
    {
	 alert('BERAT Barang harus diisi ...');
	 return false;
	}
   else return true;
   	
  }
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
			
</script> 
</head>

<body>
 <div style="margin:10px">
 </div> 
<!-- <div id="er" class="easyui-panel" title="ENTRY AWB CREDIT" style="width:100%;height:500px;padding:5px;"> -->
   <form id="fentryout" action="" method="post">
     <table width="100%" border="0" cellspacing="0" cellpadding="2">
       <tr>
    <td width="2%">&nbsp;</td>
    <td colspan="3"><h2>Entry e-Connote Cash/Credit</h2></td>
    </tr>
       <tr>
         <td>&nbsp;</td>
         <td colspan="3"><hr /></td>
       </tr>
       <tr>
    <td>&nbsp;</td>
    <td width="13%">Tanggal</td>
    <td width="59%"><input name="tglresi" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="tglresi" value="<?php echo $hari_ini ?>" size="12" /></td>
    <td width="26%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama Pengirim</td>
    <td><input name="nocust" value="11.000.0000001" type="text" id="nocust" size="15" class="easyui-textbox" data-options="required:true"/>
    <input name="nmcust"  type="text" id="nmcust" size="30" class="easyui-textbox" data-options="required:true"/>
    <input type="button" name="btcust" id="btcust" onclick="$('#dlg-customer').dialog('open')" value=".."  />
    </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Alamat Pengirim</td>
    <td><input name="alcust1" id="alcust1" size="75" class="easyui-textbox" /></td>
    <td><label for="ketisi"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input name="alcust2" id="alcust2" size="75" class="easyui-textbox" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Nama dituju</td>
    <td><input name="nmrecv"  type="text" id="nmrecv" size="30" class="easyui-textbox" data-options="required:true"/></td>
    <td><label for="harga"></label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="2">Alamat dituju</td>
    <td><input name="alrecv1" id="alrecv1" size="75" class="easyui-textbox" /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="alrecv2" id="alrecv2" size="75" class="easyui-textbox"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Kota tujuan</td>
    <td><select name="cbdest" id="cbdest" class="easyui-combobox" data-options="prompt:'pilih',required:true">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblCity order by CityName",$koneksi);
   		  echo "<option value=''></option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
      </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Berat (Kg.)</td>
    <td><input  name="berat" type="text" id="berat" value="1" size="6" class="easyui-numberbox"/>
Koli/Qty
  <input  name="qty" type="text" id="qty" value="1" size="4" class="easyui-numberbox"/> 
  Dimensi : 
  <input  name="vol1" type="text" id="vol1" value="1" size="3" class="easyui-numberbox"/> 
  x 
  <input  name="vol2" type="text" id="vol2" value="1" size="3" class="easyui-numberbox"/> 
  x 
  <input  name="vol3" type="text" id="vol3" value="1" size="3" class="easyui-numberbox"/> 
  cm</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>keterangan isi</td>
    <td><input name="ketisi" type="text"  id="ketisi" size="50"class="easyui-textbox" data-options="required:true"/></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Layanan</td>
    <td><select  name="cbserv" id="cbserv" class="easyui-combobox" data-options="prompt:'pilih'">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select ServiceId,ServiceName from tblService order by ServiceId ",$koneksi);
  		  echo "<option value=''></option>";
		  while ($dsales=mysql_fetch_array($sales)) {
			if ($dsales[0]==2) {
		  		echo "<option value='$dsales[0]' selected='selected'>$dsales[1]</option>";
				}
			else {
		  		echo "<option value='$dsales[0]'>$dsales[1]</option>";
				}
		  	}
		 ?>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Pembayaran</td>
    <td><select name="jnsbayar" id="jnsbayar"  class="easyui-combobox">
      <option value="0" selected="selected">CASH</option>
      <option value="1">CREDIT</option>
      <option value="2">COD</option>
    </select></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="button" name="btsave" id="btsave" value="Save/Rekam"  onclick=""/></td>
    <td>&nbsp;</td>
  </tr>
   </table>

  </form>

  <div id="dlg-customer" class="easyui-dialog" title="Data Pengirim" data-options="iconCls:'icon-save',closed: true" style="width:500px;height:auto;padding:10px">
      <table class="easyui-datagrid" style="width:100%;height:400px" id="customer_list"
            data-options="
            url:'transak/entri_outbound/caricust2.php',
            singleSelect:true,pagination:true,
            rownumbers:true,
            toolbar: '#toolbar2',
            onDblClickRow: function(index,row){                            
              $('#nmcust').textbox('setValue',row.CustomerName);
              $('#nocust').textbox('setValue',row.CustomerNo);
              $('#alcust1').textbox('setValue',row.CustomerAddr1);
              $('#alcust2').textbox('setValue',row.CustomerAddr2);
              $('#dlg-customer').dialog('close');
            }
            ">
        <thead>
            <tr>
                <th data-options="field:'CustomerNo',width:200">Nomor</th>
                <th data-options="field:'CustomerName',width:250">Nama</th>                
            </tr>
        </thead>
      </table>
    </div>
    <div id="toolbar2">
          <input class="easyui-textbox" name="ckey" id="ckey" data-options="prompt:'Customer'" style="width:200px">          
          <a href="javascript:void(0)" id="filter-button" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="FilterCustomer()">Filter</a>
      </div>

<script>
	function submitForm(){
            $('#fentryout').form('submit');
			url='transak\entri_outbound\save_foutbound.php';
        }
	function clearForm(){
            $('#fentryout').form('clear');
        }
  function FilterCustomer(){
      var cust_name = $('#ckey').textbox('getValue');      

      $('#customer_list').datagrid('options').url="transak/entri_outbound/caricust2.php?cust="+cust_name;
      $('#customer_list').datagrid('reload');    
  }
</script>  
  

<!-- </div> -->    
<div style="margin-bottom:10px">
  </br>
  <?php //include('lihatisi_resi.php'); ?>
</div> 
</body>
</html>
