<?php
			/**session_start();
			if(!isset($_SESSION["username"])){
				header("Location: index.php");
			}*/
			
			require "session.php";
			$sestype = $_SESSION['type'];
			if (strcmp($sestype, "mahasiswa") == 0) {
				header("Location: homemahasiswa.php");
			} 
			
			$qname = "SELECT nama FROM DOSEN WHERE username = '$sessionowner'";
			pg_query($db, "SET search_path TO SIASISTEN");
			$resname = pg_query($db, $qname);
			$row = pg_fetch_assoc($resname);
			$name = $row['nama'];
			$profile = "<li><a href=''>".$name."</a></li>";

			function connectDB(){
			$conn = pg_connect("host=localhost port=5432 dbname=mydb user=postgres password=basdat");
			if (!$conn) {
				die("Connection failed: " . pg_last_error());
			}
				return $conn;
			}

		//$namamatkul = $_GET["nama"];
			$conn = connectDB();
			$sql = 'SELECT  mahasiswa.email,
							mahasiswa.npm,
							mahasiswa.nama,
							
							status_lamaran.status
														  
					FROM    
							siasisten.lamaran,
							siasisten.mahasiswa,
							siasisten.status_lamaran,
							siasisten.kelas_MK,
							siasisten.lowongan,
							siasisten.mata_kuliah
							
							
					WHERE   siasisten.lamaran.npm = siasisten.mahasiswa.npm AND
							siasisten.status_lamaran.id = siasisten.lamaran.id_st_lamaran AND
							siasisten.lowongan.idkelasmk = siasisten.kelas_MK.idkelasmk AND
							siasisten.kelas_MK.kode_MK = siasisten.mata_kuliah.kode AND
							siasisten.lowongan.idlowongan = siasisten.lamaran.idlowongan AND
							siasisten.lowongan.idlowongan = 7300001  
							';
							
			$result = pg_query($conn, $sql);
			
			/** while($row = pg_fetch_assoc($result)) {
				$npm = $row["npm"];
				$semester = $row["semester"];
				$status = $row["status"];
				$nama = $row["nama"];
				$namaMK = $row["namaMK"];
				$email = $row["email"];
				
				 
			} */
		//$namauser = str_replace('_', ' ', $namauser);
		 //require "role.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	
	<link rel="stylesheet"
	href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css"></link>
	<script
		src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
			$('#myTable').DataTable();
		});
	</script>
</head>

<body>
	<nav class="indigo darken-3">
		<div class="nav-wrapper">
			<a href="#" class="brand-logo center">SIASISTEN</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<?php echo $profile; ?>
				<li><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<h3 class="grey-text text-darken-3">Daftar Pelamar <small><span style="color:#ff4d4d; 
		font-style:italic;"> 
		<!--<?php if(strcmp($sestype, "admin") !== 0){
			echo "(dosen: ". $name . ")";
		} else if(strcmp($sestype, "dosen") !== 0){
			echo "(admin: ". $name . ")";
		}						
			?> --> </span></small></h3>						
			
		 <table class="bordered">
    <tbody>
      <tr>
        <td>Mata Kuliah</td>
        <td>:</td>
        <td><?php echo $nama = "Basis Data"; ?></td>
      </tr>
      <tr>
        <td>Term</td>
        <td>:</td>
        <td>2015/2016, <!-- <?php if($semester == 1 ) :?> Ganjil
						<?php elseif($semester == 2 ) :?> Genap
						<?php elseif($semester == 3 ) :?> Pendek
						<?php endif; ?></td> --> Ganjil
						
      </tr>
     
    </tbody>
  </table>
  <br>
  
		 <table id="myTable" class="bordered">
		 
			<thead>
			  <tr>
				<th>No.</th>
				<th>Nama</th>
				<th>NPM</th>
				<th>Email</th>
				<th>Profil</th>
				<th>Status</th>
			  </tr>
			</thead>
			<tbody>
			
						<?php
							$nomor = 0;
							while($row = pg_fetch_assoc($result)) {
								$npm = $row["npm"];
								$nomor = $nomor + 1;
								$status = $row["status"];
								$nama = $row["nama"];
								
								$email = $row["email"];

							echo '<tr>
							<td>' . $nomor . '</td>
							<td>' . $nama . '</td>
							<td>' . $npm . '</td>
							<td>' . $email . '</td>
							<td><a href="detailpelamar.php?npm='.$npm.'"> Lihat </a></td>
							<td>';
									
								if($status == 1) {
								 echo "Melamar";
								 } else if($status == 2) {
									 echo "Direkomendasikan";
								 } else if($status == 3) {
									 echo "Diterima";
								 } else if($status == 4) {
									 echo "Ditolak";
								 }
								   
							echo '	</td>
							</tr>';
							}
						?>
			</tbody>
		</table>
		
		
	</div>

</body>
	<footer>
	 <p style="text-align:center; color:red;"><small>Copyright &copy; 2016 SIASISTEN - TK Basdat B05</small></p>
    </footer>
</html>