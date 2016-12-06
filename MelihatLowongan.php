<?php
	require "session.php";
			$sestype = $_SESSION['type'];
			if (strcmp($sestype, "admin") !== 0) {
				header("Location: homeadmin.php");
			}
			else if(strcmp($sestype, "dosen") !== 0) {
				header("Location: homedosen.php");
			}
			else if(strcmp($sestype, "mahasiswa") !== 0) {
				header("Location: homemahasiswa.php");
			}
			
			function connectDB(){
			$conn = pg_connect("host=localhost port=5432 dbname=mydb user=postgres password=basdat");
			if (!$conn) {
				die("Connection failed: " . pg_last_error());
			}
			return $conn;
		}

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
    $DOSEN = [];
    $result = pg_query($conn,$sql) or die(pg_last_error($conn));

    if(pg_num_rows($result) > 0) {
      while ($row = pg_fetch_assoc($result)) {
		
         $DOSEN[] = [$row["kode"],$row["nama"], $row['dosen'],  $row['status'], $row['jumlahasisten'], $row['pelamar'] ];
		}
    }



// QUERY UNTUK MAHASISWA
	$namaMHS=$_SESSION["username"];
    $sql = "Select Distinct mata_kuliah.Kode as kode, lowongan.IDkelasMK as ID, Mata_kuliah.nama as nama, dosen.nama as dosen, lowongan.status as status, lowongan.jumlah_asisten as jumlahasisten, lowongan.jumlah_pelamar as pelamar, status_lamaran.status as statuslamaran from term, mahasiswa, lowongan join kelas_mk ON lowongan.IDkelasMK=kelas_mk.IDkelasMK join mata_kuliah on mata_kuliah.kode=kelas_mk.kode_mk join dosen on dosen.NIP=lowongan.NIPDosenPembuka join lamaran on lamaran.IDlowongan=lowongan.IDlowongan join status_lamaran on status_lamaran.ID=lamaran.ID_st_lamaran where term.tahun='2016' AND lamaran.NPM= mahasiswa.NPM Order by lowongan.status ASC";
	$MAHASISWA = [];
    $result = pg_query($conn,$sql) or die(pg_last_error($conn));

    if(pg_num_rows($result) > 0) {
      while ($row = pg_fetch_assoc($result)) {
        $MAHASISWA[] = [$row["kode"],$row["nama"], $row['dosen'],  $row['status'], $row['jumlahasisten'], $row['pelamar'], $row['statuslamaran'] ];
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
					<h3 class="grey-text text-darken-3">Daftar Lowongan Asisten <small><span style="color:#ff4d4d; font-style:italic;">(<?php if($role == "dosen" ) :  ?>
                        Dosen
                    <?php elseif ($role  == "admin") : ?>
                        Admin
                    <?php elseif ($role  == "mahasiswa") : ?>
                        Mahasiswa
                    <?php endif;?>)</small></h3>
					<a class="waves-effect waves-light btn-large">Tambah</a>
				</div>
				
				<table class="highlight"> 

					<?php if($role =="admin") : ?>
					
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
						<div class="table table-bordered ">
							<br>
							
							<table>
								<?php foreach ($ADMIN as $PelamarAdmin) : ?>
								<tr>
									<td><?= $PelamarAdmin[0] ?></td>
									<td><?= $PelamarAdmin[1] ?></td>
									<td><?= $PelamarAdmin[2] ?></td>
									<td><?= $PelamarAdmin[3] ?></td>
									<td></td>
									<td></td>
								<td><a href='".$link_address."'>Edit</a>
									<a href='".$link_address."'>Hapus</a></td>
								</tr>
								<?php endforeach; ?>                           
							</table>
						
						</div>
					</tbody>
					<?php endif; ?>
				</table>				
				
					<?php if($role =="dosen") : ?>
					
					<thead>
					  <tr>
						  <th data-field="Mata Kuliah">Mata Kuliah</th>
						  <th data-field="Dosen Pengajar">Dosen Pengajar</th>
						  <th data-field="Status">Status</th>
						  <th data-field="Jumlah asisten Dibutuhkan">Jumlah asisten Dibutuhkan</th>
						  <th data-field="Jumlah Pelamar">Jumlah Pelamar</th>
						  <th data-field="Jumlah Pelamar Diterima">Jumlah Pelamar Diterima</th>
						  <th data-field="Action">Action</th>
					  </tr>
					</thead>
					
					<tbody>
						<div class="table table-bordered ">
							<br>
							
							<table>
								<?php foreach ($DOSEN as $pd) : ?>
								<tr>
									<td><?= $pd[0] ?></td>
									<td><?= $pd[1] ?></td>
									<td><?= $pd[2] ?></td>
									<td><?= $pd[3] ?></td>
									<td></td>
									<td></td>
								<td><a href='".$link_address."'>Edit</a>
									<a href='".$link_address."'>Hapus</a></td>
								</tr>
								<?php endforeach; ?>                           
							</table>
						
						</div>
					</tbody>
					<?php endif; ?>
				</table>
				
				<?php if($role =="mahasiswa") : ?>
					
					<thead>
					  <tr>
						  <th data-field="Kode">Kode</th>
						  <th data-field="Mata Kuliah">Mata Kuliah</th>
						  <th data-field="Dosen Pengajar">Dosen Pengajar</th>
						  <th data-field="Status">Status</th>
						  <th data-field="Jumlah asisten Dibutuhkan">Jumlah asisten Dibutuhkan</th>
						  <th data-field="Jumlah Pelamar">Jumlah Pelamar</th>
						  <th data-field="Jumlah Pelamar Diterima">Jumlah Pelamar Diterima</th>
						  <th data-field="Status Lamaran">Status Lamaran</th>
						  <th data-field="Action">Action</th>						  
					  </tr>
					</thead>
					
					<tbody>
						<div class="table table-bordered ">
							<br>
							
							<table>
								<?php foreach ($MAHASISWA as $pm) : ?>
								<tr>
									<td><?= $pm[0] ?></td>
                                    <td><?= $pm[1] ?></td>
                                    <td><?= $pm[2] ?></td>
									<td><?= $pm[3] ?></td>
									<td><?= $pm[4] ?></td>
									<td><?= $pm[5] ?></td>
                                    <td></td>
									<td><?= $pm[6] ?></td>
									<td>
										<?php if (in_array("melamar", $pm, TRUE))
											  {
												  echo"<a href='".$link1."'> Batal</a>";
											  }
											  if(in_array("direkomendasikan", $pm, TRUE))
											  {
											  echo"<a href='".$link_address."'>Daftar </a>";
											  } 
											 if(in_array("ditolak", $pm, TRUE)){
												 echo" ";
											 }
											
											$link_address='index.php';
											$link1='index.php';	
										?>
									</td>
                                </tr>
                                <?php endforeach; ?>                           
							</table>
						
						</div>
					</tbody>
					<?php endif; ?>
				</table>
		
			</div>
		</div>
	</div>
</body>

</html>