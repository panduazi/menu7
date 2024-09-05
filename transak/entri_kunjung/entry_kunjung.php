<?php
  $hari_ini=date('Y-m-d');


  if (isset($_POST['rekam'])) {
	$nm_sales=$_POST['nm_sales'];
	$tgl__kunjung=$_POST['dtTgl'];
	$NmCust=$_POST['NmCust'];
	$NoCust='NA#';
	$tuj_kunjung=$_POST['tuj_kunjung'];
	$Jenis=$_POST['Jenis'];
	$time_in=$_POST['time_in'];
	$time_out=$_POST['time_out'];
	$nm_opor=$_POST['nm_opor'];
	$kompetitor=$_POST['kompetitor'];
	$jns_opor=$_POST['jns_opor'];
	$ship=$_POST['ship'];
	$berat=$_POST['berat'];
	$tujuan=$_POST['tujuan'];
	$tuj_urai=$_POST['tuj_urai'];
	$potensi=$_POST['potensi'];
	$tahap=$_POST['tahap'];
	$comment=$_POST['comment'];
	$Q="INSERT INTO tblSalesKunjung (SalesKode, Tanggal, CustomerName, CustomerNo, Tujuan_Kunjung, Jenis_Kunjung, Jam_IN, Jam_OUT,OpporName,Competitor,JOIsi,JOQty,JOBrt,JODest,JODestKet,JOTahap,Revenu,Catatan) VALUES ('".$nm_sales."','".$tgl__kunjung."','".$NmCust."','".$Nocust."','".$tuj_kunjung."','".$Jenis."','".$time_in."','".$time_out."','".$nm_opor."','".$kompetitor."','".$jns_opor."','".$ship."','".$berat."','".$tujuan."','".$tuj_urai."','".$tahap."','".$potensi."','".$comment."')";
  	include('config/koneksi.php');	
	$r=mysql_query($Q) or die(mysql_error());
	if ($r) {$msg="Berhasil";}
	   else {$msg="Gagal";}
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PanduLogistics Bandung</title>

<script>
 function cekform2()
  {
   if (document.getElementById('NmCust').value=='')
    {
	 alert('Nama Pelanggan masih kosong ...');
	 return false;
	}
   if (document.getElementById('tuj_kunjung').value=='')
    {
	 alert('Tujuan kunjungan tidak bole kosong ...');
	 return false;
	}
   if (document.getElementById('edKetIsi').value=='')
    {
	 alert('Nama dituju masih kosong ...');
	 return false;
	}
   else return true;
   }	
    
</script>

</head>
<!-- The structure of this file is exactly the same as 2col_rightNav.html;
     the only difference between the two is the stylesheet they use -->
<body>

  <form id="form1" name="form1" method="post" action="fmenu.php?hal=ekunjung" onsubmit="return cekform2()">
    <table width="100%" border="0" cellpadding="0" cellspacing="2" class="style6">
       <tr>
    	<td width="2%">&nbsp;</td>
    	<td colspan="6"><h2>Entry Kunjungan Sales</h2></td>
       </tr>
       <tr>
         <td>&nbsp;</td>
         <td colspan="7"><hr /></td>
       </tr>
       

      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Nama Sales</td>
        <td>&nbsp;</td>
        <td><select name="nm_sales" id="nm_sales" class="easyui-combobox" data-options="prompt:'pilih'">
          <?php 
		  	include('config/koneksi.php');
		 	$sales=mysql_query("select PegawaiNo,PegawaiNama from tblPegawai where PegawaiDept='MKT' and PegawaiStatus > -1 order by PegawaiNama ",$koneksi);
		 	echo "<option value=''></option>";
		 	while ($dsales=mysql_fetch_array($sales))
		 	echo "<option value='$dsales[1]'>$dsales[1]</option>";
		 ?>
        </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tanggal </td>
        <td>&nbsp;</td>
        <td><input name="dtTgl" type="text" id="dtTgl" value=<? echo $hari_ini ?> size="10" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Nama Pelanggan </td>
        <td>&nbsp;</td>
        <td><input type="text" name="NmCust" id="NmCust" class="easyui-textbox"/>
          	<input type="checkbox" name="cek_custNew" id="cek_custNew" />
        <label for="cek_custNew">Pelanggan lama </label></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Tujuan kunjungan</td>
        <td><label for="tuj_kunjung"></label></td>
        <td><textarea name="tuj_kunjung" id="tuj_kunjung" cols="50" rows="3"></textarea></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td</td>
        <td>&nbsp;</td>
        <td class="style6">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Jenis</td>
        <td class="style6"><label for="Jenis"></label></td>
        <td><select name="Jenis" id="Jenis" class="easyui-combobox">
          <option value="0" selected="selected">AK</option>
          <option value="1">DV</option>
          <option value="2">MT</option>
        </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>Waktu In/Out </td>
        <td class="style6"><label for="time_in"></label></td>
        <td><input name="time_in" type="text" id="time_in" value="08:00" size="5" maxlength="5" />
/
  <label for="time_out"></label>
  <input name="time_out" type="text" id="time_out" value="12:00" size="5" maxlength="5" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>Nama Opotunity</td>
        <td></td>
        <td><input name="nm_opor" type="text" id="nm_opor" size="50" maxlength="50" class="easyui-textbox" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="right"></div></td>
        <td>Competitor</td>
        <td class="style6">&nbsp;</td>
        <td><input name="kompetitor" type="text" id="kompetitor" size="30" class="easyui-textbox" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="right"></div></td>
        <td>Jenis Oportunity</td>
        <td class="style6"><label for="jns_opor"></label></td>
        <td bgcolor="#FFFFFF"><select name="jns_opor" id="jns_opor">
          <option value="0" selected="selected">VAR</option>
          <option value="1">DOC</option>
          <option value="2">PAR</option>
        </select>
          <label for="ship2">Shipment</label>
          <input name="ship" type="text" id="ship2" value="0" size="3" maxlength="3" />
          <label for="berat2">Berat :</label>
          <input name="berat" type="text" id="berat2" value="0" size="3" maxlength="3" />
          <label for="tujuan2">Tujuan :</label>
          <select name="tujuan" id="tujuan2">
            <option>&lt;VAR&gt;</option>
        </select></td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="right" class="style6"></div></td>
        <td>Uraian Tujuan</td>
        <td class="style6">&nbsp;</td>
        <td><input name="tuj_urai" type="text" id="tuj_urai" size="20" maxlength="30" class="easyui-textbox" />
        .</p>        </td>
        <td bgcolor="#FFFFFF"><div align="right"></div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div align="right" class="style6">
          <div align="right"></div>
        </div></td>
        <td>Potensial Revenu.</td>
        <td></td>
        <td><input type="text" name="potensi" id="potensi" class="easyui-textbox" /></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>Tahap</td>
        <td><label for="tahap"></label></td>
        <td><select name="tahap" id="tahap">
          <option value="0">01 - Potential Opportunity</option>
          <option value="1">02 - Kontak Pertama</option>
          <option value="2">03 - Proposal</option>
          <option value="3">04 - Setuju Kirim</option>
          <option value="4">05 - Implementasi</option>
          <option value="5">06 - Pengiriman Perdana</option>
          <option value="6">07 - Follow Up</option>
          <option value="7">08 - Batal Kirim</option>
        </select></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td>Comment</td>
        <td><label for="comment"></label></td>
        <td><textarea name="comment" id="comment" cols="45" rows="3"></textarea></td>
        <td></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input name="rekam" type="submit" id="rekam" value="Rekam/Save" />
        <input type="reset" name="Submit2" value="Batal" /></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
<!--end content -->
</body>
</html>
