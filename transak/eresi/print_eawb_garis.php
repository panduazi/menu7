<?php
 session_start();
 $location = $_SESSION['clocation'];
 //$cuser = $_SESSION['cuser'];
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
	$tglcn2=$hasil[ConnoteRecId1];
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
	$vol1=$hasil[ConnoteCost1];
	$vol2=$hasil[ConnoteCost2];
	$vol3=$hasil[ConnoteCost3];
	$brtvol=$hasil[ConnoteCost];
	$spcintr=$hasil[ConnoteMemo];
	$cuser=$hasil[ConnoteCreateBy];
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

<table width="100%" border="1" cellspacing="0" cellpadding="1">
  <tr>
    <td width="30%" rowspan="2" valign="top" style="font-size:7px"><p><strong>      Head Office :</strong><br />
      Jl. Pahlawan Seribu Ruko Golden Boulevard G1-19<br />
      BSD City, Serpong Tanggerang Selatan 15345<br />
      Phone : (021) 44683488 Fax : (021) 59160997<br />
      <strong>Operatiion &amp; Storage Office :</strong><br />
      Jl. Haji Karim No.45A, Bambu Apus Jakarta Timur 13880<br />
      Phone : (021) 29377924 Fax : (021) 29377924<br />
      website : www.sagaprima.com email: info@sagaprima.com
    </p></td>
    <td colspan="2" rowspan="2" align="center"><img src="../../images/logo_kecil.png" width="165" height="40" /><br />
    <span style="font-size:14px">PT SAGA PRIMA INDONESIA</span></td>
    <td align="center" colspan="4"><span style="font-family:'Free 3 of 9'; font-size:32px"><? echo $no; ?></span><br />      <strong><? echo $no; ?></strong></td>
  </tr>
  <tr>
    <td height="34" colspan="2" align="center">ORIGIN : <br />
    <strong><? echo $codeorig; ?></strong></td>
    <td colspan="2" align="center">DESTINATION :<br /><strong><? echo $destcode; ?></strong></td>
  </tr>
  <tr>
    <td valign="top" rowspan="8">Pengirim :<br /><strong><? echo $nmcust; ?> (</strong><? echo $nocust; ?>)<br />      <? echo $alcust; ?></td>
    <td colspan="2" rowspan="8" valign="top">Penerima :<strong><br />
<? echo $nmrecv; ?></strong><br />      <? echo $alrecv; ?><br /></td>
    <td  style="font-size:8px" width="10%" align="center">Tanggal</td>
    <td  style="font-size:8px" width="5%" align="center">Koli</td>
    <td  style="font-size:8px" align="center" width="8%">Kg.</td>
    <td  style="font-size:8px" align="center" width="10%">Dimensi (cm)</td>
  </tr>
  <tr>
    <td align="center"><? echo $tglcn; ?></td>
    <td align="center" ><? echo $qty; ?></td>
    <td align="center"><? echo $brt; ?></td>
    <td style="font-size:8px" align="center"><? echo $vol1; ?>X<? echo $vol2; ?>X<? echo $vol3; ?></td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Service/Layanan</td>
    <td colspan="2"><? echo $srvname; ?></td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:8px">Price / Harga (Rp).</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:8px">Insurance (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Packing (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Other / Lain-lain (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" align="right"  colspan="2">TOTAL PRICE (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px">Telpon : <? echo $tlcust; ?></td>
    <td  style="font-size:8px" valign="top" colspan="2">Telpon : <? echo $tlrecv; ?><br /></td>
    <td  style="font-size:8px"  colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td  style="font-size:8px">Keterangan Isi :<? echo $ketisi; ?></td>
    <td  style="font-size:8px" colspan="2" valign="top">Reff pengirim : <? echo $refcust; ?></td>
    <td colspan="4" align="center">CONSIGNEE / Penerima</td>
  </tr>
  <tr>
    <td style="font-size:8px" rowspan="3">Dimensi (cm) : ..... X ..... X ..... / 4000 = ........Kg</td>
    <td  style="font-size:8px" colspan="2" valign="top">Pesan khusus : <? echo $spcintr ?></td>
    <td  style="font-size:8px" valign="top" colspan="4" rowspan="3" >Name/Nama :</td>
  </tr>
  <tr>
    <td width="20%" align="center">SHIPPER / PENGIRIM</td>
    <td width="17%" align="center">PICKUP BY</td>
  </tr>  
  <tr>
    <td style="font-size:8px" valign="top" rowspan="2">Name/Nama :</td>
    <td style="font-size:8px" valign="top" rowspan="2">Nama/Nama : <? echo $cuser; ?></td>
  </tr>  
  <tr>
    <td style="font-size:8px" rowspan="2">Dimensi (cm) : ..... X ..... X ..... / 6000 = ........Kg</td>
    <td  style="font-size:8px" valign="top" colspan="4" rowspan="2">Date/Tgl :</td>
  </tr>  
 
  <tr>
    <td style="font-size:8px" valign="top">Date/Tgl :</td>
    <td style="font-size:8px" valign="top">Date : <? echo $tglcn2; ?></td>
  </tr>
  <!-- ini BATAS CONNOTE -->
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="1">
  <tr>
    <td style="font-size:7px" valign="top" rowspan="2"><p><strong>      Head Office :</strong><br />
      Jl. Pahlawan Seribu Ruko Golden Boulevard G1-19<br />
      BSD City, Serpong Tanggerang Selatan 15345<br />
      Phone : (021) 44683488 Fax : (021) 59160997<br />
      <strong>Operatiion &amp; Storage Office :</strong><br />
      Jl. Haji Karim No.45A, Bambu Apus Jakarta Timur 13880<br />
      Phone : (021) 29377924 Fax : (021) 29377924<br />
      website : www.sagaprima.com email: info@sagaprima.com
    </p></td>
    <td colspan="2" rowspan="2" align="center"><img src="../../images/logo_kecil.png" width="165" height="40" /><br />
    <span style="font-size:14px">PT SAGA PRIMA INDONESIA</span></td>
    <td align="center" colspan="4"><span style="font-family:'Free 3 of 9'; font-size:32px"><? echo $no; ?></span><br />      <strong><? echo $no; ?></strong></td>
  </tr>
  <tr>
    <td height="34" colspan="2" align="center">ORIGIN : <br />
    <strong><? echo $codeorig; ?></strong></td>
    <td colspan="2" align="center">DESTINATION :<br /><strong><? echo $destcode; ?></strong></td>
  </tr>
  <tr>
    <td valign="top" rowspan="8">Pengirim :<br /><strong><? echo $nmcust; ?> (</strong><? echo $nocust; ?>)<br />      <? echo $alcust; ?></td>
    <td colspan="2" rowspan="8" valign="top">Penerima :<strong><br />
<? echo $nmrecv; ?></strong><br />      <? echo $alrecv; ?><br /></td>
    <td  style="font-size:8px" width="10%" align="center">Tanggal</td>
    <td  style="font-size:8px" width="4%" align="center">Koli</td>
    <td  style="font-size:8px" align="center" width="8%">Kg.</td>
    <td  style="font-size:8px" align="center" width="10%">Dimensi (cm)</td>
  </tr>
  <tr>
    <td align="center"><? echo $tglcn; ?></td>
    <td align="center" ><? echo $qty; ?></td>
    <td align="center"><? echo $brt; ?></td>
    <td style="font-size:8px" align="center"><? echo $vol1; ?>X<? echo $vol2; ?>X<? echo $vol3; ?></td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Service/Layanan</td>
    <td colspan="2"><? echo $srvname; ?></td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:8px">Price / Harga (Rp).</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:8px">Insurance (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Packing (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Other / Lain-lain (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" align="right"  colspan="2">TOTAL PRICE (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px">Telpon : <? echo $tlcust; ?></td>
    <td  style="font-size:8px" valign="top" colspan="2">Telpon : <? echo $tlrecv; ?><br /></td>
    <td  style="font-size:8px"  colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td  style="font-size:8px">Keterangan Isi :<? echo $ketisi; ?></td>
    <td  style="font-size:8px" colspan="2" valign="top">Reff pengirim : <? echo $refcust; ?></td>
    <td colspan="4" align="center">CONSIGNEE / Penerima</td>
  </tr>
  <tr>
    <td style="font-size:8px" rowspan="3">Dimensi (cm) : ..... X ..... X ..... / 4000 = ........Kg</td>
    <td  style="font-size:8px" colspan="2" valign="top">Pesan khusus : <? echo $spcintr ?></td>
    <td  style="font-size:8px" valign="top" colspan="4" rowspan="3" >Name/Nama :</td>
  </tr>
  <tr>
    <td width="21%" align="center">SHIPPER / PENGIRIM</td>
    <td width="16%" align="center">PICKUP BY</td>
  </tr>  
  <tr>
    <td style="font-size:8px" valign="top" rowspan="2">Name/Nama :</td>
    <td style="font-size:8px" valign="top" rowspan="2">Nama/Nama : <? echo $cuser; ?></td>
  </tr>  
  <tr>
    <td style="font-size:8px" rowspan="2">Dimensi (cm) : ..... X ..... X ..... / 6000 = ........Kg</td>
    <td  style="font-size:8px" valign="top" colspan="4" rowspan="2">Date/Tgl :</td>
  </tr>  
 
  <tr>
    <td style="font-size:8px" valign="top">Date/Tgl :</td>
    <td style="font-size:8px" valign="top">Date: <? echo $tglcn2; ?></td>
  </tr>
  <!-- ini BATAS CONNOTE -->
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr>
  <td>&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="1" cellspacing="0" cellpadding="1">
  <tr>
    <td style="font-size:7px" valign="top" rowspan="2"><p><strong>      Head Office :</strong><br />
      Jl. Pahlawan Seribu Ruko Golden Boulevard G1-19<br />
      BSD City, Serpong Tanggerang Selatan 15345<br />
      Phone : (021) 44683488 Fax : (021) 59160997<br />
      <strong>Operatiion &amp; Storage Office :</strong><br />
      Jl. Haji Karim No.45A, Bambu Apus Jakarta Timur 13880<br />
      Phone : (021) 29377924 Fax : (021) 29377924<br />
      website : www.sagaprima.com email: info@sagaprima.com
    </p></td>
    <td colspan="2" rowspan="2" align="center"><img src="../../images/logo_kecil.png" width="165" height="40" /><br />
    <span style="font-size:14px">PT SAGA PRIMA INDONESIA</span></td>
    <td align="center" colspan="4"><span style="font-family:'Free 3 of 9'; font-size:32px"><? echo $no; ?></span><br />      <strong><? echo $no; ?></strong></td>
  </tr>
  <tr>
    <td height="34" colspan="2" align="center">ORIGIN : <br />
    <strong><? echo $codeorig; ?></strong></td>
    <td colspan="2" align="center">DESTINATION :<br /><strong><? echo $destcode; ?></strong></td>
  </tr>
  <tr>
    <td valign="top" rowspan="8">Pengirim :<br /><strong><? echo $nmcust; ?> (</strong><? echo $nocust; ?>)<br />      <? echo $alcust; ?></td>
    <td colspan="2" rowspan="8" valign="top">Penerima :<strong><br />
<? echo $nmrecv; ?></strong><br />      <? echo $alrecv; ?><br /></td>
    <td  style="font-size:8px" width="10%" align="center">Tanggal</td>
    <td  style="font-size:8px" width="4%" align="center">Koli</td>
    <td  style="font-size:8px" align="center" width="8%">Kg.</td>
    <td  style="font-size:8px" align="center" width="10%">Dimensi (cm)</td>
  </tr>
  <tr>
    <td align="center"><? echo $tglcn; ?></td>
    <td align="center" ><? echo $qty; ?></td>
    <td align="center"><? echo $brt; ?></td>
    <td style="font-size:8px" align="center"><? echo $vol1; ?>X<? echo $vol2; ?>X<? echo $vol3; ?></td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Service/Layanan</td>
    <td colspan="2"><? echo $srvname; ?></td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:8px">Price / Harga (Rp).</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:8px">Insurance (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Packing (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" colspan="2">Other / Lain-lain (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px" align="right"  colspan="2">TOTAL PRICE (Rp.)</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td style="font-size:8px">Telpon : <? echo $tlcust; ?></td>
    <td  style="font-size:8px" valign="top" colspan="2">Telpon : <? echo $tlrecv; ?><br /></td>
    <td  style="font-size:8px"  colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td  style="font-size:8px">Keterangan Isi :<? echo $ketisi; ?></td>
    <td  style="font-size:8px" colspan="2" valign="top">Reff pengirim : <? echo $refcust; ?></td>
    <td colspan="4" align="center">CONSIGNEE / Penerima</td>
  </tr>
  <tr>
    <td style="font-size:8px" rowspan="3">Dimensi (cm) : ..... X ..... X ..... / 4000 = ........Kg</td>
    <td  style="font-size:8px" colspan="2" valign="top">Pesan khusus : <? echo $spcintr ?></td>
    <td  style="font-size:8px" valign="top" colspan="4" rowspan="3" >Name/Nama :</td>
  </tr>
  <tr>
    <td width="21%" align="center">SHIPPER / PENGIRIM</td>
    <td width="16%" align="center">PICKUP BY</td>
  </tr>  
  <tr>
    <td style="font-size:8px" valign="top" rowspan="2">Name/Nama :</td>
    <td style="font-size:8px" valign="top" rowspan="2">Nama/Nama : <? echo $cuser; ?></td>
  </tr>  
  <tr>
    <td style="font-size:8px" rowspan="2">Dimensi (cm) : ..... X ..... X ..... / 6000 = ........Kg</td>
    <td  style="font-size:8px" valign="top" colspan="4" rowspan="2">Date/Tgl :</td>
  </tr>  
 
  <tr>
    <td style="font-size:8px" valign="top">Date/Tgl :</td>
    <td style="font-size:8px" valign="top">Date: <? echo $tglcn2; ?></td>
  </tr>
  <!-- ini BATAS CONNOTE -->


</body>
</html>