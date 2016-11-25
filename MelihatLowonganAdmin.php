<?php
	require "connect.php";
?>


<!DOCTYPE html>
<html>
<head>
	<title>Melihat Lowongan</title>
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
					<h3 class="grey-text text-darken-3">Daftar Lowongan Asisten <small><span style="color:#ff4d4d; font-style:italic;">(admin)</small></h3>
					<a class="waves-effect waves-light btn-large">Tambah</a>
				</div>
				<table class="highlight"> 
					<thead>
					  <tr>
						  <th data-field="Kode">Kode</th>
						  <th data-field="Mata Kuliah">Mata Kuliah</th>
						  <th data-field="Dosen Pengajar">Dosen Pengajar</th>
						  <th data-field="Status">Status</th>
						  <th data-field="Jumlah Lowongan">Jumlah Lowongan</th>
						  <th data-field="Jumlah Pelamar">Jumlah Pelamar</th>
						  <th data-field="Jumlah Pelamar Diterima">Jumlah Pelamar Diterima</th>
						  <th data-field="Action">Action</th>
					  </tr>
					</thead>

					<tbody>
					  <tr>
						<td>CS1232</td>
						<td>Basis Data</td>
						<td>Daniel</td>
						<td>Tutup</td>
						<td>1</td>
						<td><a href="">1</a></td>
						<td>1</td>
						<td><a href=""><i class="material-icons">mode_edit</i></a><a href=""><i class="material-icons">not_interested</i></a></td>
					  </tr>
					  
					  <tr>
						<td>CS1234</td>
						<td>Basis Data Lanjut</td>
						<td>Anto, Bimo</td>
						<td>Buka</td>
						<td>3</td>
						<td><a href="">3</a></td>
						<td>2</td>
						<td><a href=""><i class="material-icons">mode_edit</i></a><a href=""><i class="material-icons">not_interested</i></a></td>
					  </tr>
					  
					  <tr>
						<td>CS1233</td>
						<td>Data-dasar Pemprograman</td>
						<td>Charlie</td>
						<td>Buka</td>
						<td>2</td>
						<td><a href="">1</a></td>
						<td>0</td>
						<td><a href=""><i class="material-icons">mode_edit</i></a><a href=""><i class="material-icons">not_interested</i></a></td>
					  </tr>
					</tbody>
				</table>
		
			</div>
		</div>
	</div>
</body>

</html>