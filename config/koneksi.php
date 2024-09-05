<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_koneksi = "192.168.0.17";
$database_koneksi = "psb_miror";
$username_koneksi = "biasa";
$password_koneksi = "abcd1234";


$koneksi = new mysqli($hostname_koneksi,$username_koneksi,$password_koneksi,$database_koneksi);
if($koneksi->connect_error){
    die('Connection failed : " '.$connect->connect_error);
}

?>