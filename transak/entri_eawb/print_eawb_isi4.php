<?php
 session_start();
 $location = $_SESSION['clocation'];
 $cuser = $_SESSION['cuser'];
 $group = $_SESSION['cgroup'];
 $office = $_SESSION['coffice'];
 $codeorig = $_SESSION['corigincode'];
 $nameorig = $_SESSION['coriginname'];

 $no=$_GET['noresi'];
 include('../../config/koneksi.php');
 $query=mysql_query("select * from ((tblconnote left join tblcity on ConnoteDest=CityId) left join tblservice on tblconnote.ConnoteService=tblservice.ServiceId) where ConnoteNo='$no'");
 $hasil=mysql_fetch_array($query);
 $ketemu=mysql_num_rows($query);
 if($ketemu==1){
	$nocn=$hasil[ConnoteNo];
	$tglcn=$hasil[ConnoteDate];
	$nocust=$hasil[ConnoteCustNo];
	$nmcust=$hasil[ConnoteCustName];
	$alcust=$hasil[ConnoteCustAddr];
	$tlcust=$hasil[ConnoteCustTelp];
	$refcust=$hasil[ConnoteCustReff];
	$nmrecv=$hasil[ConnoteRecvName];
	$alrecv=$hasil[ConnoteRecvAddr];
	$tlrecv=$hasil[ConnoteRecvTelp];
	$refrecv=$hasil[ConnoteRecvReff];
	$ketisi=$hasil[ConnoteContents];
	$brt=$hasil[ConnoteWeight];
	$qty=$hasil[ConnoteQty];
	$destcode=$hasil[CityCode];
	$namadest=$hasil[CityName];
	$srvname=$hasil[ServiceName];
	$vol1=$hasil[ConnoteVol1];
	$vol2=$hasil[ConnoteVol2];
	$vol3=$hasil[ConnoteVol3];
	$spcintr=$hasil[ConnoteMemo];
	
	
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cetak Resi</title>
 <style>
   body {
	background-color: #FFFFFF;
	font-family: Tahoma, Geneva, sans-serif;
	font-size: 10px;
   }
   </style>
</head>
<body onload="window.print()" onfocus="window.close()">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="0%">&nbsp;</td>
    <td width="16%" rowspan="3"><img src="../../images/logo_kecil.png" width="165" height="40" /></td>
    <td width="7%" style="font-size:6px">&nbsp;</td>
    <td width="1%" rowspan="2" align="center">&nbsp;</td>
    <td width="45%" rowspan="2" align="center"><span style="font-family:'Free 3 of 9'; font-size:24px"><? echo $no; ?></span></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="font-size:6px">&nbsp;</td>
    <td style="font-size:6px" align="right" colspan="3">Lembar untuk Pengirim</td>
  </tr>
  <tr>
    <td height="18">&nbsp;</td>
    <td style="font-size:8px">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">e-Connote No : <? echo $no; ?></td>
    <td width="11%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="8%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Pengirim : </td>
    <td>&nbsp;</td>
    <td>Penerima :</td>
    <td>Tanggal</td>
    <td>: <? echo $tglcn; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $nocust; ?>-<strong><? echo $nmcust; ?></strong></td>
    <td>&nbsp;</td>
    <td><strong><? echo $nmrecv; ?></strong></td>
    <td>Kota Asal</td>
    <td style="font-size:8px">: <? echo $nameorig; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top" colspan="2" rowspan="2"><? echo $alcust; ?></td>
    <td rowspan="2">&nbsp;</td>
    <td valign="top" rowspan="2"><? echo $alrecv; ?></td>
    <td>Kota Tujuan</td>
    <td style="font-size:8px">: <? echo $namadest; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Layanan</td>
    <td>: <? echo $srvname; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $tlcust; ?></td>
    <td>&nbsp;</td>
    <td><? echo $tlrecv; ?></td>
    <td>Berat</td>
    <td colspan="2">: <? echo $brt; ?> Kg. - Jumlah : <? echo $qty; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Reff pebgirim :</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Keterangan Isi : </td>
    <td colspan="3">Dimensi/Volummetric :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $refcust; ?></td>
    <td>&nbsp;</td>
    <td valign="top" rowspan="2"><? echo $ketisi; ?></td>
    <td colspan="3">Pjng : <? echo $vol1; ?> X <? echo $vol2; ?> X <? echo $vol3; ?> cm</td>
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
    <td>Petugas,</td>
    <td>Pengirim,</td>
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
    <td align="center" colspan="5" rowspan="2">Dengan mendanda tangani lembar ini, pelanggan sudah membaca memahami syarat2 pengirman. Untuk melihat pergerakan barang/tracking dapat melihat pada www.sagaprima.com </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><? echo '('.$cuser.')'; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><hr size="2px" color="#000000" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp; </td>
    <td>&nbsp;</td>
    <td style="font-size:6px" align="right" colspan="2">Lembar untuk Arsip</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="3"><img src="../../images/logo_kecil.png" width="165" height="40" /></td>
    <td><span style="font-size:8px">:</span></td>
    <td rowspan="3" align="center" style="font-family: 'Free 3 of 9'; font-size:24px">&nbsp;</td>
    <td rowspan="2" align="center" style="font-family: 'Free 3 of 9'; font-size:24px"><? echo $no; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="font-size:8px">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style="font-size:6px">&nbsp;</td>
    <td align="center">e-Connote No : <? echo $no; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td style="font-size:6px">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Pengirim :</strong></td>
    <td>&nbsp;</td>
    <td><strong>Penerima : </strong></td>
    <td>Tanggal</td>
    <td>: <? echo $tglcn; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $nocust; ?>-<? echo $nmcust; ?></td>
    <td>&nbsp;</td>
    <td><? echo $nmrecv; ?></td>
    <td>Kota Asal</td>
    <td style="font-size:8px">: <? echo $nameorig; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top" colspan="2" rowspan="3"><? echo $alcust; ?></td>
    <td rowspan="3">&nbsp;</td>
    <td valign="top" rowspan="3"><? echo $alrecv; ?></td>
    <td>Kota Tujuan</td>
    <td style="font-size:8px">: <? echo $namadest; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Layanan</td>
    <td>: <? echo $srvname; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Berat</td>
    <td colspan="2">: <? echo $brt; ?> Kg. - Jumlah : <? echo $qty; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $tlcust; ?></td>
    <td>&nbsp;</td>
    <td><? echo $tlrecv; ?></td>
    <td colspan="3">Dimensi/Volumetric :</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">Reff pengirim :</td>
    <td>&nbsp;</td>
    <td>Keterangan isi :</td>
    <td colspan="3">: <? echo $vol1; ?> X <? echo $vol2; ?> X <? echo $vol3; ?> cm</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $refcust; ?></td>
    <td>&nbsp;</td>
    <td valign="top" rowspan="2"><? echo $ketisi; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
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
    <td>Petugas,</td>
    <td>Pengirim,</td>
    <td>&nbsp;</td>
    <td>Ins: <? echo $spcintr; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center" colspan="5" rowspan="2">Dengan mendanda tangani lembar ini, pelanggan sudah membaca memahami syarat2 pengirman. Untuk melihat pergerakan barang/tracking dapat melihat pada www.sagaprima.com</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><? echo '('.$cuser.')'; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><hr size="2px" color="#000000" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3" style="font-size:6px" align="right">Lembar untuk dibarang (POD-Kembali)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="3"><img src="../../images/logo_kecil.png" width="165" height="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="2" align="center" style="font-family: 'Free 3 of 9'; font-size:24px"><? echo $no; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">Asal/Origin</td>
    <td align="center">Tujuan/Dest</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">e-Connote No : <? echo $no; ?></td>
    <td align="center" style="font-size:12px"><strong><? echo $codeorig; ?></strong></td>
    <td align="center" style="font-size:12px"><strong><? echo $destcode; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td><strong>Tanggal</strong></td>
    <td>: <? echo $tglcn; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Pengirim :</strong></td>
    <td>&nbsp;</td>
    <td><strong>Penerima :</strong></td>
    <td><strong>Layanan</strong></td>
    <td>: <? echo $srvname; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $nocust; ?>-<? echo $nmcust; ?></td>
    <td>&nbsp;</td>
    <td><? echo $nmrecv; ?></td>
    <td><strong>Berat</strong></td>
    <td colspan="2">: <? echo $brt; ?> Kg / Koli: <? echo $qty; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top"  colspan="2" rowspan="3"><? echo $alcust; ?></td>
    <td>&nbsp;</td>
    <td valign="top" rowspan="3"><? echo $alrecv; ?></td>
    <td><strong>Volume</strong></td>
    <td colspan="2">: <? echo $vol1; ?> X <? echo $vol2; ?> X <? echo $vol3; ?></td>
  </tr>
  <tr>
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
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><strong>Reff pengirim :</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Telpon : <? echo $tlrecv; ?></td>
    <td colspan="3"><strong>TTD dan Nama Penerima :</strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $refcust; ?></td>
    <td>&nbsp;</td>
    <td><strong>Keterangan isi :</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><? echo $ketisi; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Petugas,</td>
    <td>Pengirim,</td>
    <td>&nbsp;</td>
    <td><strong>Instruksi Khusus :</strong></td>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" rowspan="2"><? echo $spcintr; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><? echo '('.$cuser.')'; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><hr size="1px" color="#000000" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">*** LEMBAR INI SEGERA DIKEMBALIKAN KE CAB.PENGIRIM ***</td>
    <td><strong>Waktu/Jam</strong></td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><hr size="2px" color="#000000" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" style="font-size:6px" align="right">Lembar untuk dibarang (arsip cabang)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td rowspan="3"><img src="../../images/logo_kecil.png" width="165" height="40" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td rowspan="2" align="center" style="font-family: 'Free 3 of 9'; font-size:24px"><? echo $no; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center"><strong>Asal/Origin</strong></td>
    <td align="center"><strong>Tujuan/Dest</strong></td>
    <td>&nbsp;</td> 
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="center">e-Connote No : <? echo $no; ?></td>
    <td align="center" style="font-size:12px"><strong><? echo $codeorig; ?></strong></td>
    <td align="center" style="font-size:12px"><strong><? echo $destcode; ?></strong></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Tanggal</strong></td>
    <td>: <? echo $tglcn; ?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><strong>Pengirim :</strong></td>
    <td>&nbsp;</td>
    <td><strong>Penerima :</strong></td>
    <td><strong>Layanan</strong></td>
    <td>: <? echo $srvname; ?></td>
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $nocust; ?>-<? echo $nmcust; ?></td>
    <td>&nbsp;</td>
    <td><? echo $nmrecv; ?></td>
    <td><strong>Berat</strong></td>
    <td colspan="2">: <? echo $brt; ?> Kg / Koli: <? echo $qty; ?></td>
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td valign="top" colspan="2" rowspan="3"><? echo $alcust; ?></td> 
    <td>&nbsp;</td>
    <td valign="top" rowspan="3"><? echo $alrecv; ?></td>
    <td><strong>Volume</strong></td>
    <td colspan="2">: <? echo $vol1; ?> X <? echo $vol2; ?> X <? echo $vol3; ?></td>
    <td>&nbsp;</td>
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
    <td width="0%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
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
    <td><strong>Reff pengirim :</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>Telpon : <? echo $tlrecv; ?></td>
    <td colspan="3"><strong>TTD dan Nama Penerima :</strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2"><? echo $refcust; ?></td>
    <td>&nbsp;</td>
    <td><strong>Keterangan isi :</strong></td>
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
    <td><? echo $ketisi; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Petugas,</td>
    <td>Pengirim,</td>
    <td>&nbsp;</td>
    <td><strong>Instruksi Khusus : </strong></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top" rowspan="2"><? echo $spcintr; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="3"><hr size="1px" color="#000000" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><? echo '('.$cuser.')'; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><strong>Waktu/Jam</strong></td>
    <td>:</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"><hr size="2px" color="#000000" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td >
    <td>&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
    <td width="0%">&nbsp;</td>
  </tr>
</table>
</body>
</html>