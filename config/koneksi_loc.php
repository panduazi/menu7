<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_koneksi = "localhost";
$database_koneksi = "pandu";
$username_koneksi = "root";
$password_koneksi = "";
$koneksi = mysql_pconnect($hostname_koneksi, $username_koneksi, $password_koneksi) or trigger_error(mysql_error(),E_USER_ERROR); 
$db=mysql_select_db($database_koneksi,$koneksi) or die("DATABASE TIDAK ADA");
?>