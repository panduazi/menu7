<?php
  session_start();
  $location = $_SESSION['clocation'];
  $cuser = $_SESSION['cuser'];
  $group = $_SESSION['cgroup'];
  $office = $_SESSION['coffice'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Transaksi Akhir</title>        
    <link rel="stylesheet" href="style/layout.css" type="text/css" />
</head>
<body >
	<table width="50%" border="0" cellpadding="1" cellspacing="0">
    	<tr>
        	<td class="jud_tabel">NO.</td>
            <td class="jud_tabel" align="left">GROUP</td>
            <td class="jud_tabel" align="left">NAMA MENU</td>
            <td class="jud_tabel" align="center">ACTION</td>
        </tr>
        <tr>
         	<td colspan="4"><hr></td>
        </tr>

        <?php
		include('config/koneksi.php');
		$sql = mysql_query("SELECT *,if(useraktif='Y','Aktif','NonAktif') as satatus FROM tbluser_menu WHERE groupid=$_SESSION[MM_ugroup]");
		$no = 1;
        while ($r = mysql_fetch_array($sql)) {
	  		if($no%2==0) $bg='#0FF'; else $bg='#FFFFFF';
      		echo "<tr bgcolor='$bg' >";
            echo "<td class='isi_tabel'>$no</td>";
            echo "<td class='isi_tabel'>$r[usergrup]</td>";
            echo "<td class='isi_tabel'>$r[usermenu]</td>";
            echo "<td class='isi_tabel' align=center><a href='master/usergrup/update.php?id=$r[recid]&isi=$r[useraktif]'>$r[satatus]</a></td>";
            echo "</tr>";
            $no++;
        }
        ?>
  </table>   
</body>
</html>
