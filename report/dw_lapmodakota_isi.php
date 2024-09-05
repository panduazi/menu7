<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=tonase_perkota.xls");

session_start();
$location = $_SESSION['clocation'];
$cuser = $_SESSION['cuser'];
$group = $_SESSION['cgroup'];
$office = $_SESSION['coffice'];

 if (isset($_POST['btcari'])){
 	$t1=$_POST['tgl1'];
    $t2=$_POST['tgl2'];
 } else
 {
 	$t1=$tglresi;
	$t2=$tglresi;
	$nocust='';
 }
date_default_timezone_set('Asia/Jakarta'); 
$cSesi=$cuser.date('YmdHis');  
include('../config/koneksi.php');
//cari record yg via UDARA
$sql = mysql_query("SELECT ConnoteDest, sum(ConnoteWeight) as tkg
                                        from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                                        WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 
                                        and ConnoteBillCurrency='IDR' and ManifestMAWBNo is not NULL
                                        GROUP BY ConnoteDest"); 
while ($r = mysql_fetch_array($sql)) {
    $csql="insert into tempAnalis (Sesi,Mode,Key1,Nilai1) values('$cSesi','FALAH1',$r[ConnoteDest],$r[tkg])";
    $isi_temp=@mysql_query($csql);
}

//cari record yg via NON-UDARA (DARAT)
$sql = mysql_query("SELECT ConnoteDest, CityBts5, sum(ConnoteWeight) as tkg
                    from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                    left join tblCity on ConnoteDest=CityId
                    WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 
                    and ConnoteBillCurrency='IDR' and CityBts5=1 and ManifestMAWBNo is NULL GROUP BY ConnoteDest"); 
while ($r1 = mysql_fetch_array($sql)) {
    $brt_drt=$r1[tkg];
    $brt_laut=0;
    $csql_cari= mysql_query("select * from tempAnalis where Sesi='$cSesi' and Key1=$r1[ConnoteDest]");
    $ketemu=mysql_num_rows($csql_cari);
    if($ketemu==1){ 	                        
        $csql="update tempAnalis set Nilai2=$brt_drt,Nilai3=$brt_laut where Sesi='$cSesi' and Key1=$r1[ConnoteDest]";
        }
    else {
        $csql="insert into tempAnalis (Sesi,Mode,Key1,Nilai2,Nilai3) values('$cSesi','FALAH1',$r1[ConnoteDest],$brt_drt,$brt_laut)";
        }
    $isi_temp=@mysql_query($csql);
}

//cari record yg via NON-UDARA (LAUT)
$sql = mysql_query("SELECT ConnoteDest, CityBts5, sum(ConnoteWeight) as tkg
                    from tblConnote left join tblAirLineSMU_AWB on ConnoteNo=AWBNo
                    left join tblCity on ConnoteDest=CityId
                    WHERE ConnoteDate between '$t1' and '$t2' and ConnoteOrig=11 and ConnoteValid=1 
                    and ConnoteBillCurrency='IDR' and CityBts5=2 and ManifestMAWBNo is NULL GROUP BY ConnoteDest"); 
while ($r1 = mysql_fetch_array($sql)) {
    $brt_drt=0;
    $brt_laut=$r1[tkg];;
    $csql_cari= mysql_query("select * from tempAnalis where Sesi='$cSesi' and Key1=$r1[ConnoteDest]");
    $ketemu=mysql_num_rows($csql_cari);
    if($ketemu==1){ 	                        
        $csql="update tempAnalis set Nilai3=$brt_laut where Sesi='$cSesi' and Key1=$r1[ConnoteDest]";
        }
    else {
        $csql="insert into tempAnalis (Sesi,Mode,Key1,Nilai2,Nilai3) values('$cSesi','FALAH1',$r1[ConnoteDest],$brt_drt,$brt_laut)";
    }
    $isi_temp=@mysql_query($csql);
}
//tapilkan hasil temporer
$sql = mysql_query("SELECT * from tempAnalis left join tblCity on Key1=CityId WHERE Sesi='$cSesi'"); 
?>
	<table padding="1">
        <thead>
                    <tr>
                        <th align="left">Kode Tujuan</th>
                        <th align="left">Nama Tujuan</th>
                        <th align="left">Propinsi</th>
                        <th align="left">Udara</th>
                        <th align="left">Darat</th>
                        <th align="left">Laut</th>
                    </tr>
        </thead>
        <tbody>
                    <?php
					  $no = 1;
                      while ($r = mysql_fetch_array($sql)) {
                        $byk=number_format($r[Nilai1]);
                        $brt=number_format($r[Nilai2]);
                        $net=number_format($r[Nilai3]);
                        echo "<tr>
                        <td>$r[CityForward]</td>
                        <td>$r[CityName]</td>
                        <td>$r[CityProvinsi]</td>
                        <td align='right'>$byk</td>
                        <td align='right'>$brt</td>
                        <td align='right'>$net</td>
                        </tr>";
                        $no++;
                      }                    
                    ?>
                    
                </tbody>
	</table>
