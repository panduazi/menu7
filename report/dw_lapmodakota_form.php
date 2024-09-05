<?php
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
 session_start();
 $location = $_SESSION['clocation'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
 $office = $_SESSION['coffice'];
 //$hari_ini=date('m/d/Y');
 //$tglresi=date('m/d/Y')-1;
 //$tgl2=date('Y-m-d');   

 
 if (isset($_POST['btcari'])){
 	$tgl1=$_POST['tgl1'];
	$tgl2=$_POST['tgl2'];
	$nocust=$_POST['cbcust'];
 } else
 {
 	$tgl1=$tglresi;
	$tgl2=$tglresi;
	$nocust='NA#';
 }
 
?>

<!DOCTYPE html>
<html>
<head>
        <title>Tabel city</title>     
 		<script>
 			function cekform() {
   				if (document.getElementById('cbcust').value=='')
    				{alert('Pelanggan belum dipilih ...');
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
<form action="report/dw_lapmodakota_isi.php" method="post" onsubmit="return cekform()">
	<table width="100%" border="0" cellspacing="0" cellpadding="1">
  	<tr>
    	<td style="font-size:16px" colspan="3"><h2>Tonase Moda per Kota/Kab.</h2></td>
    </tr>
  	<tr>
    	<td colspan="3"><hr></td>
    </tr>
  	<tr>
    	<td width="11%">Mulai tgl</td>
   	  <td width="71%"><input name="tgl1" type="text" class="easyui-datebox" id="tgl1" value="<? echo $tgl1 ?>" size="12" data-options="formatter:myformatter,parser:myparser"></td>
    	<td width="18%">&nbsp;</td>
   	  </tr>
  	<tr>
    	<td>hingga</td>
    	<td><input name="tgl2" type="text" class="easyui-datebox" id="tgl2" value="<? echo $tgl2 ?>" size="12" data-options="formatter:myformatter,parser:myparser"></td>
    	<td>&nbsp;</td>
   	</tr>
  	<tr>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
   	</tr>
  	<tr>
    	<td><input type="submit" name="btcari" id="btcari" value="Download ke Excel"></td>
    	<td>&nbsp;</td>
    	<td>&nbsp;</td>
   	</tr>
	</table>
</form>    
</body>
</html>