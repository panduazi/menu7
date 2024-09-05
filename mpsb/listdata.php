<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>List View</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
		<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
<div data-role="page" data-theme="a">
<div data-role="header">
<a href="crud.html" data-icon="back" data-role="button" data-inline="true" data-transition="flip">Kembali</a>
<h1 align="center">Menggunakan Form Input</h1>
</div>
<div data-role="content"> 
<ul data-role="listview" data-inset="true">
   <li data-role="fieldcontain">
          <center><label for="name"><h1>List Mahasiswa</h1></label></center>
   </li>
  <form>
<table data-role="table" data-mode="columntoggle" class="ui-responsive" id="myTable" border="1">
  <thead>
    <tr>
      <th>NPM</th>
      <th data-priority="1">NAMA</th>
      <th data-priority="2">JENIS KELAMIN</th>
      <th data-priority="3">KELAS</th>
    </tr>
  </thead>
  <tbody>
<?php include 'koneksi.php';
 $hasil_db = mysql_query("SELECT * FROM tblcity ");

 while ($data = mysql_fetch_array($hasil_db)){

  echo "<tr>
      <td>$data[CityCode]</td>
      <td>$data[CityForward]</td>
      <td>$data[CityName]</td>"
   ?>
   <td><a href ="edit_mhs.php?id=<?php echo $data['No'];?>">Edit</a> || <a href ="delete_mhs.php?id=<?php echo $data['No'];?>">Hapus</a></td>
   <?php
   echo"
    </tr>";
} ?>
  </tbody>
</table>
    </form>
  </ul>
 </div>
<div data-role="footer" data-position="fixed">
<h2>@Agan Islah</h2>
</div>
</div>
</body>
</html>