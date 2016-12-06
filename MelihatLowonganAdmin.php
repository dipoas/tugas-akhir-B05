<?php
	include "session.php";
	
	if(!connect())
		die(pg_last_error());
		
    session_start();
    if(!isset ($_SESSION["username"])){
        header("Location: index.php");
    }
	
    $role = $_SESSION["role"];

// QUERY ADMIN
	$conn = connect();
	$sql = "Select Distinct mata_kuliah.Kode as kode, lowongan.IDkelasMK as ID, Mata_kuliah.nama as nama, dosen.nama as dosen, lowongan.status as status, lowongan.jumlah_asisten as jumlahasisten, lowongan.jumlah_pelamar as pelamar from term, lowongan join kelas_mk ON lowongan.IDkelasMK=kelas_mk.IDkelasMK join mata_kuliah on mata_kuliah.kode=kelas_mk.kode_mk join dosen on dosen.NIP=lowongan.NIPDosenPembuka Order by Dosen.nama ASC;";
    $ADMIN = [];
    $result = pg_query($conn,$sql) or die(pg_last_error($conn));
	
    if(pg_num_rows($result) > 0) {
      while ($row = pg_fetch_assoc($result)) {
        $ADMIN[] = [$row["kode"],$row["nama"], $row['dosen'],  $row['status'], $row['jumlahasisten'], $row['pelamar'] ];
      }
    } 

// QUERY UNTUK DOSEN
	$namadosen=$_SESSION["username"];
    $sql = "Select Distinct mata_kuliah.Kode as kode, lowongan.IDkelasMK as ID, Mata_kuliah.nama as nama, dosen.nama as dosen, lowongan.status as status, lowongan.jumlah_asisten as jumlahasisten, lowongan.jumlah_pelamar as pelamar from term, lowongan join kelas_mk ON lowongan.IDkelasMK=kelas_mk.IDkelasMK join mata_kuliah on mata_kuliah.kode=kelas_mk.kode_mk join dosen on dosen.NIP=lowongan.NIPDosenPembuka where term.tahun='2016' AND dosen.username= '$namadosen' Order by Dosen.nama ASC";   
    $dosen = [];
    $result = pg_query($conn,$sql) or die(pg_last_error($conn));

    if(pg_num_rows($result) > 0) {
      while ($row = pg_fetch_assoc($result)) {
		
         $dosen[] = [$row["kode"],$row["nama"], $row['dosen'],  $row['status'], $row['jumlahasisten'], $row['pelamar'] ];
		}
    }



// QUERY UNTUK MAHASISWA
	$namaMHS=$_SESSION["username"];
    $sql = "Select Distinct mata_kuliah.Kode as kode, lowongan.IDkelasMK as ID, Mata_kuliah.nama as nama, dosen.nama as dosen, lowongan.status as status, lowongan.jumlah_asisten as jumlahasisten, lowongan.jumlah_pelamar as pelamar, status_lamaran.status as statuslamaran from term, mahasiswa, lowongan join kelas_mk ON lowongan.IDkelasMK=kelas_mk.IDkelasMK join mata_kuliah on mata_kuliah.kode=kelas_mk.kode_mk join dosen on dosen.NIP=lowongan.NIPDosenPembuka join lamaran on lamaran.IDlowongan=lowongan.IDlowongan join status_lamaran on status_lamaran.ID=lamaran.ID_st_lamaran where term.tahun='2016' AND lamaran.NPM= mahasiswa.NPM Order by lowongan.status ASC";
	$mahasiswa = [];
    $result = pg_query($conn,$sql) or die(pg_last_error($conn));

    if(pg_num_rows($result) > 0) {
      while ($row = pg_fetch_assoc($result)) {
        $mahasiswa[] = [$row["kode"],$row["nama"], $row['dosen'],  $row['status'], $row['jumlahasisten'], $row['pelamar'], $row['statuslamaran'] ];
      }
    }


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
					  
					  <?php if($role =="admin") : ?>

						<div class="container">
                      				<h1>DASBOARD</h1>
							<div class="panel panel-default">
							<div class="panel-heading">
								<div>
									<h2>Daftar Lowongan Asisten</h2>
								</div>	
							<div class="table table-bordered ">
								<br>
									<table>
									  <tr>
										<th>Kode</th>
										<th>Mata Kuliah</th>
										<th>Dosen Pengajar</th>
										<th>Status</th>
										<th>Jumlah Asisten Dibutuhkan</th>
										<th>Jumlah Pelamar</th>
										<th>Jumlah Pelamar Diterima</th>			
										<th>Action  </th>
									  </tr>
					<?php foreach ($ADMIN as $DaftarPelamarAdmin) : ?>
					<tr>
					    <td><?= $DaftarPelamarAdmin[0] ?></td>
					    <td><?= $DaftarPelamarAdmin[1] ?></td>
					    <td><?= $DaftarPelamarAdmin[2] ?></td>
					    <td><?= $DaftarPelamarAdmin[3] ?></td>
										<td></td>
										<td></td>
										<td><a href='".$link_address."'>Edit</a>
											<a href='".$link_address."'>Hapus</a></td>
					</tr>
					<?php endforeach; ?>
                                
					    </table>
						</div>
					    </div>
					</div>
				    </div>
						<?php endif; ?>
					</tbody>
				</table>
		
			</div>
		</div>
	</div>
</body>

</html>
