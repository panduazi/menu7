<?php
$server = "192.168.0.19";
$username = "biasa";
$password = "abcd1234";
$database = "pandulogistics";

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");
?>