<?php
include "koneksi.php";

mysql_query("insert into dataku (NPM, NAMA, JENIS_KELAMIN, KELAS)
         values('$_POST[npm]',
             '$_POST[nama]',
             '$_POST[jk]',
             '$_POST[kelas]')");
            
?>
<script>
 window.location='Index.php';
</script>