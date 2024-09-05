<?php 
    session_start();
    $_SESSION['SS_tgl']=$_GET['tgl']; 
    $_SESSION['SS_kur']=$_GET['kurir']; 
?>

<meta content="text/html; charset=utf-8" http-equiv="Content-Type" /><title>Form Cetak PickupOrder</title>

<style>
body {
    background-color: #FFFFFF;
    font-family: Tahoma, Geneva, sans-serif;
    font-size: 10px;
}
</style>
</head>

<body onload="window.print()" onfocus="window.close()">
<div id="judul" style="font-size: 8px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td>LAPORAN PICKUP ORDER</td>
        </tr>
        <tr>
            <td>TANGGAL : <? echo $_SESSION['SS_tgl'] ?></td>
        </tr>
        <tr>
            <td>KURIR : <? echo $_SESSION['SS_kur'] ?></td>
        </tr>
    </tbody>
</table>

</div>
<div id="isi" style="font-size: 8px;">
    <table border="0" cellpadding="2" cellspacing="0" width="100%">
    <tbody>
        <tr>
            <td colspan="8"> <hr /> </td>
        </tr>
        <tr>
            <td width="3%"><strong>NO.</strong></td>
            <td width="12%"><strong>TANGGAL</strong></td>
            <td width="15%"><strong>CUSTOMER</strong></td>
            <td width="25%"><strong>ALAMAT PENGAMBILAN.</strong></td>
            <td width="10%"><strong>AREA</strong></td>
            <td width="5%"><strong>KURIR</strong></td>
            <td width="5%"><strong>CSO</strong></td>
        </tr>
        <tr>
            <td colspan="8"> <hr /> </td>
        </tr>
        
<?php 
    $tgl=$_SESSION['SS_tgl'];
    $kur=$_SESSION['SS_kur'];
    include('../../config/koneksi.php'); 
    $query=mysql_query("select * from tblPickupOrder where POrderDate like '$tgl%' and POrderKurir='$kur'"); 
    $i=1; 
    $totnilai=0; 
    while ($hasil=mysql_fetch_array($query)){
        echo "<tr>"; 
        echo "<td>$i</td>"; 
        echo "<td>$hasil[POrderDate]</td>"; 
        echo "<td>$hasil[POrderCustName]</td>"; 
        echo "<td>$hasil[POrderCustAddr1]</td>"; 
        echo "<td>$hasil[POrderArea]</td>"; 
        echo "<td>$hasil[POrderKurir]</td>"; 
        echo "<td>$hasil[POrderCSO2]/$hasil[POrderCSO2]</td>"; 
        echo "</tr>"; 
        $i++; 
    } 
     
?>
</tbody>
</table>
</div>
</body></html>