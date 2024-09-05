<?php
date_default_timezone_set('Asia/Jakarta');
$per=date('Ym');

//hitung hari kerja
$p=date('Y-m')."-01";
$begin = new DateTime($p);
$end = new DateTime(date('Y-m-d'));
//$daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
$daterange = 31;
//mendapatkan range antara dua tanggal dan di looping
$i=0;
$x=0;
$end=1;
foreach($daterange as $date){
    $daterange     = $date->format("Y-m-d");
    $datetime     = DateTime::createFromFormat('Y-m-d', $daterange);
    //Convert tanggal untuk mendapatkan nama hari
    $day         = $datetime->format('D');
    //Check untuk menghitung yang bukan hari minggu
    if($day!="Sun") {
        //echo $i;
        $x    +=    $end-$i;
    }
    $end++;
    $i++;
}    
include("'../../config/koneksi.php");
$rs0 = mysql_query("SELECT * FROM tblsdc WHERE bulan='$per'"); 
$r0=mysql_fetch_array($rs0);
$bulan=$r0[NamaBulan];
$jhari=$r0[JumHari];

include("'../../config/koneksi.php");
$rs = mysql_query("SELECT Customersales,sum(ConnoteBillAmount-ConnoteBillDisc) AS NET, 
                                            sum(ConnoteWeight) as BERAT, 
                                            count(ConnoteNo) as SHIP
                    FROM tblConnote left join tblCustomer on ConnoteCustNo=CustomerNo 
                    WHERE date_format(ConnoteDate,'%Y%m')= '$per' 
                      and ConnoteOrig=11 
                      and ConnoteValid=1 
                    and ConnoteBillCurrency='IDR'"); 
$r=mysql_fetch_array($rs);
$trp=$r[NET];
$tqty=$r[SHIP];
$tkg=$r[BERAT];                      
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>FORCAST & TREND</title>
</head>
<script>
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

<body>
    
    <div class="easyui-tabs" style="width:95%;height:650">
        <div title="GENERAL-FORCAST" style="padding:10px">
            <div id="p" class="easyui-panel" title="FORCAST BULAN BERJALAN" style=height:600px;padding:10px;">        
            <table>
                <tr>
                    <td>BULAN</td>
                    <td><?php echo ": ".$bulan ?></td>
                </tr>
                <tr>
                    <td>HARI KERJA</td>
                    <td><?php echo ": ".$x." dari ".$jhari ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong>TOTAL PRODUKSI</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td>NILAI</td>
                    <td><?php echo ": Rp. ".number_format($trp)?></td>
                </tr>
                <tr>
                    <td>SHIPMENT</td>
                    <td><?php echo ": ".number_format($tqty)?></td>
                </tr>
                <tr>
                    <td>BERAT</td>
                    <td><?php echo ": ".number_format($tkg)." Kg."?></td>
                </tr>
                <tr>
                    <td><strong>RATA-RATA HARIAN</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td>NILAI</td>
                    <td><?php echo ": Rp. ".number_format($trp/$x,1)?></td>
                </tr>
                <tr>
                    <td>SHIPMENT</td>
                    <td><?php echo ": ".number_format($tqty/$x,1)?></td>
                </tr>
                <tr>
                    <td>BERAT</td>
                    <td><?php echo ": ".number_format($tkg/$x,1)." Kg."?></td>
                </tr>
                <tr>
                    <td><strong>RAMALAN/FORCAST</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td>NILAI</td>
                    <td><?php echo ": Rp. ".number_format($trp/$x*$jhari)?></td>
                </tr>
                <tr>
                    <td>SHIPMENT</td>
                    <td><?php echo ": ".number_format($tqty/$x*$jhari)?></td>
                </tr>
                <tr>
                    <td>BERAT</td>
                    <td><?php echo ": ".number_format($tkg/$x*$jhari)." Kg."?></td>
                </tr>

            </table>
            </div>
        </div>
        <div title="persales" style="padding:10px">
                <table id="dg" title="FORCAST SALES" class="easyui-datagrid" style="height:600px"
                url="report/sdc/get_forcast.php"
                toolbar="#toolbar" pagination="true" pageSize="20"
                rownumbers="false" fitColumns="true" singleSelect="true">
            <thead>
                <tr>
                    <th field="Customersales" rowspan="2">SALES</th>
                    <th field="SHIP" align="right" formatter="formatrp" rowspan="2">QTY</th>
                    <th field="BERAT" align="right" formatter="formatrp" rowspan="2">KG.</th>
                    <th field="NET" align="right" formatter="formatrp" rowspan="2">PRODUKSI</th>
                    <th field="FORC" align="right" rowspan="2">FORCAST</th>
                    <th colspan="6">TREND 1 BULAN</th>
                    <th colspan="6">TREND 3 BULAN</th>
                    <th colspan="6">TREND 3 BULAN TAHUN LALU</th>
                </tr>
                <tr>
                    <th field="NET" align="right">QTY</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">KG</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">NET</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">QTY</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">KG</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">NET</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">QTY</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">KG</th>
                    <th field="NET1" align="right">%</th>
                    <th field="NET" align="right">NET</th>
                    <th field="NET1" align="right">%</th>
                </tr>
            </thead>
    
        </table>            
        </div>
    </div>











	

	<!--
	<div id="toolbar">
		<label>Periode</label>
		<select id="kurir" name="kurir" class="easyui-combobox" data-options="prompt:'-- pilih --'">
			  <?php 
				include('config/koneksi.php'); 
				$sales=mysql_query("select Bulan,NamaBulan from tblsdc where Bulan like '2019%' order by Bulan DESC",$koneksi);
				   while ($dsales=mysql_fetch_array($sales))
				echo "<option value='$dsales[0]'>$dsales[1]</option>";
			  ?>
		</select>  
		<a href="javascript:void(0)" class="easyui-linkbutton" iconCls="icon-search" plain="true" onclick="doSearch()">Proses</a>
	</div>
-->

	<script type="text/javascript">
		var url;
        function doSearch(){
        $('#dg').datagrid('load',{
            kurir: $('#kurir').val()
            });
        }        

		function formatrp(val,row){
            return number_format(val,0,',','.');
        };
        function number_format(num,dig,dec,sep) {
            x=new Array();
            s=(num<0?"-":"");
            num=Math.abs(num).toFixed(dig).split(".");
            r=num[0].split("").reverse();
            for(var i=1;i<=r.length;i++){x.unshift(r[i-1]);if(i%3==0&&i!=r.length)x.unshift(sep);}
            return s+x.join("")+(num[1]?dec+num[1]:"");
        }		
	</script>

</body>
</html>