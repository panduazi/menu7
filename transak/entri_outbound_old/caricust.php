<style type="text/css">
<!--
.head_tbl {
	font-size: 10px;
	font-weight: bold;
	font-family:Verdana, Arial, Helvetica, sans-serif;
	text-transform: uppercase;
	color: #FFFFFF;
	background-color: #FF0000;
}

.style9 {	color: #000000;
	font-size: 10px;
	font-weight: normal;
	font-family: Tahoma;
}
-->
</style>
<script type="text/javascript">
function ambil(a){
	window.opener.document.form.nama.value = document.getElementById("nmcust"+a+"").innerHTML;
	window.opener.document.form.alcust1.value = document.getElementById("alamat"+a+"").innerHTML; 	
	window.opener.document.form.nocust.value = document.getElementById("tlp"+a+"").innerHTML;
	window.close();
}

</script>
<table width="100%" border="0">
  <tr>
    <td><form id="form" name="form1" method="post" action="">
      <label>
        Nama
        <input type="text" name="cari" id="cari" />
        </label>
      <label>
        <input type="submit" name="button" id="button" value="cari" onClick="pencarian()" />
        </label>
    </form></td>
  </tr>
</table>
<table width="458" border="1">
<tr class="head_tbl">
    <td width="122" bgcolor="#FF0000"><div align="center">Nama</div></td>
    <td width="224" bgcolor="#FF0000"><div align="center">Alamat</div></td>
     <td width="90" bgcolor="#FF0000"><div align="center"><span class="style1">Tlp</span></div></td>
  </tr>

<?php
error_reporting(0);
    include('../../config/koneksi.php');	
	$hal = $_GET[hal];
if(!isset($_GET['hal'])){ 
    $page = 1; 
} else { 
    $page = $_GET['hal']; 
}
$jmlperhalaman = 20;  // jumlah record per halaman
$offset = (($page * $jmlperhalaman) - $jmlperhalaman);  


if($_GET['flag']==1)
{
	$cari=$_GET['cari'];
	$sql=mysql_query("select * from tblCustomer where CustomerName LIKE '%".$cari."%' limit $offset, $jmlperhalaman") or die (mysql_error());

}
else
{

	$sql=mysql_query("select * from tblCustomer limit $offset, $jmlperhalaman") or die (mysql_error());
}
$i=1;
while($rs=mysql_fetch_array($sql))
{
if($i%2==0)
	{
		echo("<tr onclick=\"ambil('$rs[0]')\" bgcolor=\"#FFEEEE\">");
	}
	else
	{
		echo("<tr onclick=\"ambil('$rs[0]')\">");
	}?>
<td width="122" id="nama<?=$rs[0];?>"><?=$rs[CustomerName];?></td>
<td width="224" id="alamat<?=$rs[0];?>"><?=$rs[CustomerAddr1];?></td>
<td width="90" id="tlp<?=$rs[0];?>"><?=$rs[CustomerNo];?></td>
<?  $i++;
}
?>
</table>
<?

if($_GET['flag']==1)
{
	$cari=$_GET['cari'];
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM tblCustomer where CustomerName LIKE '%".$cari."%'"),0);
}
else
{
	$total_record = mysql_result(mysql_query("SELECT COUNT(*) as Num FROM tblCustomer"),0);
}
$total_halaman = ceil($total_record / $jmlperhalaman);
echo "<center>"; 
$perhal=4;
if($hal > 1){ 
    $prev = ($page - 1); 
    if($_GET['flag']==1)
	{
		echo "<a href=$_SERVER[PHP_SELF]?hal=$prev&cari=$_GET[cari]&flag=1> << </a> "; 
	}
	else
	{
		echo "<a href=$_SERVER[PHP_SELF]?hal=$prev> << </a> "; 
	}
}
if($total_halaman<=10){
$hal1=1;
$hal2=$total_halaman;
}else{
$hal1=$hal-$perhal;
$hal2=$hal+$perhal;
}
if($hal<=5){
$hal1=1;
}
if($hal<$total_halaman){
$hal2=$hal+$perhal;
}else{
$hal2=$hal;
}
for($i = $hal1; $i <= $hal2; $i++){ 
    if(($hal) == $i){ 
        echo "[<b>$i</b>] "; 
        } else { 
    if($i<=$total_halaman){
            if($_GET['flag']==1)
		{
			echo "<a href=$_SERVER[PHP_SELF]?hal=$i&cari=$_GET[cari]&flag=1>$i</a> "; 
		}
		else
		{
			echo "<a href=$_SERVER[PHP_SELF]?hal=$i>$i</a> "; 
		}  
    }
    } 
}
if($hal < $total_halaman){ 
    $next = ($page + 1); 
    if($_GET['flag']==1)
	{
		echo "<a href=$_SERVER[PHP_SELF]?hal=$next&cari=$_GET[cari]&flag=1> >> </a>"; 
	}
	else
	{
		echo "<a href=$_SERVER[PHP_SELF]?hal=$next> >> </a>"; 
	} 
} 
echo "</center>"; 
?>

<script type="text/javascript">
function pencarian()
{
	var cari=document.getElementById('cari').value;
	document.form1.action="caricust.php?flag=1&cari="+cari;
	document.form1.submit();
}	
</script>
