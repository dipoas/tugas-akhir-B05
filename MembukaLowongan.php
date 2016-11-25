<?php
	require "connect.php";
?>


<!DOCTYPE html>
<html>
<head>
	<title>Membuka Lowongan</title>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>
	<nav class="indigo darken-3">
		<div class="nav-wrapper">
			<a href="#" class="brand-logo center">SIASISTEN</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><a href="#">Profile</a></li>
				<li><a href="#">Log Out</a></li>
			</ul>
		</div>
	</nav>

	<div class="container" >
		<div class="row">
			<div class="col s12">
				<div class="row">
					<h3 class="grey-text text-darken-3">Tambah Lowongan <small><span style="color:#ff4d4d; font-style:italic;">(admin atau dosen)</small></h3>
				</div>
				<table class="bordered">
					<thead>
					  <tr>
						  <th data-field="Kode">Term</th>
						  <td>Ganjil,2016</td>
					  </tr>
					  <tr>
						  <th data-field="Mata Kuliah">Mata Kuliah</th>
						  <td>CS1234 Basis Data Lanjut</td>
					  </tr>
                      <tr>					  
						  <th data-field="Status">Status</th>
						  <td>buka/tutup</td>
					  </tr>
					  <tr>
						  <th data-field="Jumlah Lowongan">Jumlah Asisten dibutuhkan</th>
						  <td></td>
					  </tr>
					  <tr>
						  <th data-field="Jumlah Pelamar">Syarat tambahan</th>
						  <td></td>
					  </tr>
					  <tr>
						  <th data-field="Jumlah Pelamar Diterima">Daftar Pengajar</th>
						  <td>Anto
						  <br><br>
						  Bimo</td>
					  </tr>
					</thead>
					
				</table>
				<center>
				<br><br>
				<a class="waves-effect waves-light btn-large">Simpan</a>
				&nbsp;&nbsp;&nbsp;
				<a class="waves-effect waves-light btn-large">Batal</a>
				</center>
		
			</div>
		</div>
	</div>
</body>

</html>