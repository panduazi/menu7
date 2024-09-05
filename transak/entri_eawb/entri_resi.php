<?php
  session_start();
  if (!isset($_SESSION['cuser'])) {
	echo('anda harus melalui form login ...!');
	exit;
   }
  $location = $_SESSION[clocation];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];
  $codeorig = $_SESSION['corigincode'];
  $hari_ini=date('m/d/Y');
  $tglresi=date('m/d/Y')-1;
  $tgl2=date('Y-m-d');   
 
  // --- jika tekan TOMBOL APPLY CUSTOMER
  if (isset($_POST['btcust'])) {
	$noc=$_POST['nmcust'];
	$tgl=$_POST['tglresi'];
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblcustomer where CustomerNo='$noc'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	  $nm=$hasil['CustomerName'];
	  $al=$hasil['CustomerAddr1'];
	  $tl=$hasil['CustomerTelp'];
	  session_start();
	  $_SESSION['MM_nocust']=$noc;
	  $_SESSION['MM_nmcust']=$nm;
	  $_SESSION['MM_alcust']=$al;
	  $_SESSION['MM_tlcust']=$tl;
	  $_SESSION['MM_tlgresi']=$tgl;
	  	}
	else {
	  session_start();
	  $_SESSION['MM_nocust']='';
	  $_SESSION['MM_nmcust']='';
	  $_SESSION['MM_alcust']='';
	  $_SESSION['MM_tlcust']='';
	  $_SESSION['MM_tlgresi']=$tgl2;
	}
  }
  
  //---jika tekan TOMBOL Save ----
  if (isset($_POST['btsave'])) {
   	//ambil nomor Connote Dulu
   	include('config/koneksi.php');
	$query=mysql_query("select * from tblcounter_awb where CountCity=$location");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	  $no=$hasil['CountNo']+1;
	  $no2=$hasil['CountKey']+1;
	  $label=$hasil['CountLabel'];
	  if ($no2>7) {$no2=1;}
	  $sql='update tblcounter_awb set CountNo='.$no.',Countkey='.$no2.' where CountCity='.$location;
	  $result = @mysql_query($sql)  or die(mysql_error());
	} 
	else {
	  if ($location<100) {$kdloc='0'.$location;} else {$kdloc=$location;};
	  $sql="insert into tblcounter_awb(CountCity,CountLabel,CountNo,CountKey) VALUES($location,'$kdloc',1,1)";
	  $result = @mysql_query($sql)  or die(mysql_error());
	  $no=1;
	  $no2=1;
	  $label=$kdloc;
	}
  	if ($no<10) {$no='000000'.$no;}
	 elseif ($no<100) {$no='00000'.$no;}
	 elseif ($no<1000) {$no='0000'.$no;}
	 elseif ($no<10000) {$no='000'.$no;}
	 elseif ($no<100000) {$no='00'.$no;}
	 else  {$no='0'.$no;
	}
	$cnoresi=$label.$no.$no2;   //--selesai cari nomor
	$cnocust = $_SESSION['MM_nocust'];
	$dtglresi =$_SESSION['MM_tlgresi'];
	$cnmrecv = $_POST['nmrecv'];
	$calrecv = $_POST['alrecv'];
	$ndest = $_POST['cbdest'];
	$cketisi = $_POST['ketisi'].' '.$_POST['ketisi2'].' '.$_POST['ketisi3'].' '.$_POST['ketisi4'];
	$nbayar = $_POST['jnsbayar'];
	$nqty = $_POST['qty'];
	$nberat = $_POST['berat'];
	$service = $_POST['service'];
	$nodo1=$_POST['ketisi2'];
	$nodo2=$_POST['ketisi3'];
	$nodo3=$_POST['ketisi4'];
	$memo=$_POST['cmemo'];
	$vol1=$_POST['vol1'];
	$vol2=$_POST['vol2'];
	$vol3=$_POST['vol3'];
	if ($vol1+$vol2+$vol3>0){
		if ($service<4){$brtvol=($vol1*$vol2*$vol3)/6000 ;} else {$brtvol=($vol1*$vol2*$vol3)/4000 ;}
		$brtvol=intval($brtvol);
	}else {	$brtvol=0;}
	if ($nberat>$brtvol) {$brthit=$nberat;} else {$brthit=$brtvol;}
	
	//Cari nama dan alamat customer
 	include('config/koneksi.php');
	$query=mysql_query("select * from tblcustomer where CustomerNo='$cnocust'");
    $hasil=mysql_fetch_array($query);
	$ketemu=mysql_num_rows($query);
    if($ketemu==1){ 		
	   $cnmcust = $hasil['CustomerName'];
	   $calcust = $hasil['CustomerAddr1'];
	   $ctlcust = $hasil['CustomerTelp'];
	}

	//Cari hartga
 	include('config/koneksi.php');
	$query=mysql_query("select * from tblpricecust where PriceCustID='$cnocust' and PriceID=$ndest");
    $hasil=mysql_fetch_array($query);
    if(mysql_num_rows($query)>0){ 		
	}
	else {
 		include('config/koneksi.php');
		$query1=mysql_query("select * from tblprice where PriceCityId=$ndest");
    	$hasil1=mysql_fetch_array($query1);
		$ketemu1=mysql_num_rows($query1);
		if ($ketemu1==1) {
			switch ($service) {
				case 1 :
				 $bea=$brthit*$hasil1['PriceSDS1'];
				case 2 :
				 $bea=$brthit*$hasil1['PriceONS1'];
				case 3 :
				 $bea=$brthit*$hasil1['PriceREG1'];
				case 4 :
				 if ($brthit>$hasil1[PriceREG1]) {$bea=($brthit-$hasil1[PriceEKOLim1])*$hasil1[PriceEKO2]+$hasil1[PriceEKO1];} else {$bea=$brthit*$hasil1[PriceEKO1];}
				case 5 :
				 $bea=$hasil1[PriceTRUCK1];
				case 6 :
				 $bea=$hasil1[PriceTRUCK2];
				case 7 :
				 $bea=$hasil1[PriceTRUCK3];
				case 7 :
				 $bea=$hasil1[PriceTRUCK4];
				case 7 :
				 $bea=$hasil1[PriceTRUCK5];
				case 7 :
				 $bea=$hasil1[PriceTRUCK6];
				case 7 :
				 $bea=$hasil1[PriceTRUCK7];
				default :
				 $bea=0;
			}
		}
		else {
			$bea=0;
		}
		
	}
	
	//rekam ke Database	   	 
	$q = "INSERT IGNORE INTO tblconnote(ConnoteNo, ConnoteDate, ConnoteOrig, ConnoteDest, ConnoteCustNo, ConnoteCustName, ConnoteCustAddr, ConnoteCustTelp,ConnoteRecvName, ConnoteRecvAddr, ConnoteContents, ConnoteOffice, ConnotePayment, ConnoteWeight, ConnoteQty, ConnoteService, ConnoteCost, ConnoteCost1, ConnoteCost2, ConnoteCost3, ConnoteBillAmount, ConnoteMemo, ConnoteRecId1, ConnoteRecId2, ConnoteCreateBy, ConnoteModiBy) VALUES ('".$cnoresi."','".$dtglresi."','".$location."','".$ndest."','".$cnocust."','".$cnmcust."','".$calcust."','".$ctlcust."','".$cnmrecv."','".$calrecv."','".$cketisi."','".$office."','".$nbayar."','".$nberat."','".$nqty."','".$service."','".$brtvol."','".$vol1."','".$vol2."','".$vol3."','".$bea."','".$memo."',now(),now(),'".$user."','".$user."')";
  include('config/koneksi.php');	
  $r=mysql_query($q) or die(mysql_error());
  if ($r) {
	$msg="Berhasil";
    //update Master DO untuk isi no AWB
	if ($nodo1 !== '') {
		$result1=@mysql_query("update tblproject_master set PConnoteNo='$cnoresi' where PNo='$nodo1'");}
	if ($nodo2 !== '') {
		$result2=@mysql_query("update tblproject_master set PConnoteNo='$cnoresi' where PNo='$nodo2'");}
	if ($nodo3 !== '') {
		$result3=@mysql_query("update tblproject_master set PConnoteNo='$cnoresi' where PNo='$nodo3'");}
		
	//entry Status CP
	$cnocp=2; //SC-shipmwnt create
	$cdesc='Entry Data';
	$cjam='';
	$q = "INSERT INTO tbltrackingstatus(StatusKonosNo, StatusPOD, StatusDesc, StatusOffice, StatusLocation, StatusDate, StatusJam, RecId, ModiBy) VALUES ('".$cnoresi."','".$cnocp."','".$cdesc."','".$office."','".$location."','".$tgl2."','".$cjam."',now(),'".$cuser."')";
  	include('config/koneksi.php');	
  	$r=mysql_query($q) or die(mysql_error());  		
	//buat cetak ke printer
	echo "<script> window.open('transak/eresi/print_eawb_garis.php?noresi=$cnoresi','_blank') </script>";
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
 <link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
 <link rel="stylesheet" type="text/css" href="themes/icon.css">
 <link rel="stylesheet" type="text/css" href="http://www.jeasyui.com/easyui/demo/demo.css">
 <script type="text/javascript" src="jq/jquery.min.js"></script>
 <script type="text/javascript" src="jq/jquery.easyui.min.js"></script>
 <script>
 function cekform()
  {
   if (document.getElementById('tglresi').value=='')
    {
	 alert('Tanggal masih kosong ...');
	 return false;
	}
   if (document.getElementById('service').value=='')
    {
	 alert('Jenis layanan belum dipilih ...');
	 return false;
	}
   if (document.getElementById('kdpos').value=='')
    {
	 alert('Kode POS masih kosong ...');
	 return false;
	}
   if (document.getElementById('harga').value=='0')
    {
	 alert('Harga harus diisi ...');
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
     <form action="fmenu.php?hal=ekurir" method="post">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
      <tr>
        <td style="font-size:16px;"><h1>eConnote Create Shipment</h1></td>
      </tr>
      <tr>
       <td><hr /></td>
      </tr>
      <tr>
    	<td>
        Tanggal <input name="tglresi" type="text" class="easyui-datebox" data-options="formatter:myformatter,parser:myparser" id="tglresi" value="<?php echo $hari_ini ?>" size="12" />
  		Pelanggan <select name="nmcust" id="nmcust" >
        	<?php 
    	  	include('config/koneksi.php'); 
		  	$sales=mysql_query("select CustomerNo,CustomerName from tblcustomer order by CustomerName ",$koneksi);
   		  	echo "<option value='NA#'>--pilih--</option>";
		  	while ($dsales=mysql_fetch_array($sales))
		  	echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 	?>
        	</select>
            <input name="btcust" type="submit" value="Apply" />
      </td>      
      </tr>
	  </table>     
	</form>    

     <form action="fmenu.php?hal=ekurir" method="post" onsubmit="return cekform()">
      <table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td width="10%">&nbsp;</td>
    <td width="49%">&nbsp;</td>
    <td width="33%">&nbsp;</td>
  </tr>
  <tr>
    <td>No. Acount</td>
    <td><strong><? echo $_SESSION['MM_nocust'] ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>

    <td>Nama Cust.</td>
    <td><strong><? echo $_SESSION['MM_nmcust'] ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td valign="top" rowspan="2">Alamat</td>
    <td valign="top" rowspan="2"><strong><? echo $_SESSION['MM_alcust'] ?></strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="4%">&nbsp;</td>
    <td width="4%"><label for="ketisi"></label>      <label for="berat"></label></td>
  </tr>
  <tr>
    <td>Nama dituju</td>
    <td colspan="4"><input name="nmrecv"  type="text" id="nmrecv" size="50" />
      <input type="checkbox" name="creknama" id="creknama" value="1" />
      <label for="creknama">Simpan data penerima</label></td>
    </tr>
  <tr>
    <td valign="top">alamat</td>
    <td><textarea name="alrecv" id="alrecv" cols="45" rows="3"></textarea></td>
    <td>Lampiran DO :</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Kota tujuan</td>
    <td><select name="cbdest" id="cbdest">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select CityId,CityName from tblcity order by CityName",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select></td>
    <td><input name="ketisi2" type="text"  id="ketisi2" size="30" maxlength="50" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>layanan</td>
    <td><select name="service" id="service">
      <?php 
    	  include('config/koneksi.php'); 
		  $sales=mysql_query("select ServiceId,ServiceName from tblservice order by ServiceId ",$koneksi);
   		  echo "<option value=''>--pilih--</option>";
		  while ($dsales=mysql_fetch_array($sales))
		  echo "<option value='$dsales[0]'>$dsales[1]</option>";
		 ?>
    </select>
berat (Kg) 
<input  name="berat" type="text" id="berat" value="1" size="6" />
Koli/Qty
<input  name="qty" type="text" id="qty" value="1" size="4" /></td>
    <td><input name="ketisi3" type="text"  id="ketisi3" size="30" maxlength="50" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><p>Dimensi</p></td>
    <td>P:
      <input  name="vol1" type="text" id="vol1" value="0" size="6" /> 
       
      L:
      <input  name="vol2" type="text" id="vol2" value="0" size="6" /> 
       
      T:
      <input  name="vol3" type="text" id="vol3" value="0" size="6" /> 
      dalam cm</td>
    <td><input name="ketisi4" type="text"  id="ketisi4" size="30" maxlength="50" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>ket. isi</td>
    <td><input name="ketisi" type="text"  id="ketisi" size="30" maxlength="50" />
Pembayaran
  <select name="jnsbayar" id="jnsbayar" >
    <option value="0">Cash</option>
    <option value="1" selected="selected">Credit</option>
    <option value="2">COD</option>
  </select></td>
    <td>Memo / Special Instruction :</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" rowspan="2"><textarea name="cmemo" id="cmemo" rows="2"></textarea></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="btsave" id="btsave" value="Save/Rekam" />
      <input type="reset" name="btcancel" id="btcancel" value="Reset/Clear" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="5"><hr /></td>
    </tr>
  </table>

  </form>
<div style="margin-bottom:10px">
  
  <?php include('lihatisi_resi.php'); ?>
</div> 
</body>
</html>
