<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Elemen Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
	<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
	<div data-role="page" data-theme="a">
		<div data-role="header">
			<a href="crud.html" data-icon="back" data-role="button" data-inline="true" data-transition="flip">Kembali</a>
			<h1 align="center">Input Data Siswa</h1>
		</div>
		<div data-role="content">
			<div class="content-primary">
				<form action="Simpan.php" method="post" data-ajax="false">
					<ul data-role="listview" data-inset="true">
						<li data-role="fieldcontain">
							<center><label for="name"><h1>Silahkan Masukkan Data Anda</h1></label></center>
						</li>
						<li data-role="fieldcontain">
							<label for="npm">NPM</label>
							<input type="text" name="npm" id="npm" value=""  />
						</li>
						<li data-role="fieldcontain">
							<label for="nama">Nama</label>
							<input type="text" name="nama" id="nama" value=""  />
						</li>
						<li data-role="fieldcontain">
							<fieldset data-role="controlgroup">
							<legend>Jenis Kelamin</legend>
							<input type="radio" name="jk" id="radio-choice-1" value="Laki-Laki" checked="checked" />
							<label for="radio-choice-1">Laki-Laki</label>
							<input type="radio" name="jk" id="radio-choice-2" value="Perempuan"  />
							<label for="radio-choice-2">Perempuan</label>
							</fieldset>
						</li>
						<li data-role="fieldcontain">
							<label for="select-choice-1" class="select">Kelas</label>
							<select name="kelas" id="select-choice-1">
								<option value="">Pilih Kelas Anda</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
							</select>
						</li>

						<li class="ui-body ui-body-b">
							<fieldset class="ui-grid-a">
								<div class="ui-block-a"><button type="submit" data-theme="a">Submit</button></div>
								<div class="ui-block-b"><button type="reset" data-theme="d">Cancel</button></div>
							</fieldset>
						</li>
   
					</ul>
				</form>
			</div>
		</div>
		<div data-role="footer" data-position="fixed">
			<h2>@Agan Islah</h2>
		</div>
	</div>
</body>
</html>