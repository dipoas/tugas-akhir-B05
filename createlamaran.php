<?php
			/** session_start();
			if(!isset($_SESSION["username"])){
				header("Location: index.php");
			} */

			require "session.php";
			$sestype = $_SESSION['type'];
			if (strcmp($sestype, "admin") == 0) {
				header("Location: homeadmin.php");
			}
			else if(strcmp($sestype, "dosen") == 0) {
				header("Location: homedosen.php");
			}
			
			$qname = "SELECT nama FROM Mahasiswa WHERE username = '$sessionowner'";
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

		//$namamenu = $_GET["nama"];
			$conn = connectDB();
			$sql = "SELECT  kelas_mk.idkelasmk,
							kelas_mk.tahun,
							kelas_mk.semester,
							kelas_mk.kode_mk,
							lowongan.idkelasmk,
							mata_kuliah.kode,
							mata_kuliah.nama
							  
					FROM    siasisten.kelas_mk,
							siasisten.lowongan,
							siasisten.mata_kuliah
							
					WHERE   kelas_mk.idkelasmk = lowongan.idkelasmk AND
							kelas_mk.kode_mk = mata_kuliah.kode
							
							;";
			$result = pg_query($conn, $sql);
			
			while($row = pg_fetch_assoc($result)) {
				$tahun = $row["tahun"];
				$semester = $row["semester"];
				$kode_mk = $row["kode_mk"];
				$nama = $row["nama"];
				
			//	$kategori = $row["kategori"];
			}
		//$namamenu = str_replace('_', ' ', $namamenu);
		 //require "role.php"
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Daftar Lowongan</title>
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
</head>

<body>
	<nav class="indigo darken-3">
		<div class="nav-wrapper">
			<a href="#" class="brand-logo center">SIASISTEN</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><?php echo $profile; ?> </li>
				<li><a href="logout.php">Log Out</a></li>
			</ul>
		</div>
	</nav>

	<div class="container">
		<h3 class="grey-text text-darken-3">Daftar Lowongan <small><span style="color:#ff4d4d; font-style:italic;">(mahasiswa)</span></small></h3>
		
		 <table class="bordered">
			<tbody>
				<tr class="collection">
					<th class="collection">Term</th>
					<td><?php if($semester == 1 ) :?> Ganjil, 
						<?php elseif($semester == 2 ) :?> Genap, 
						<?php elseif($semester == 3 ) :?> Pendek, 
						<?php endif; ?>
						<?php echo $tahun ?></p></td>
				</tr>
				<tr class="collection">
					<th class="collection">Kode</th>
					<td><?php echo $kode_mk ?></p></td>
				</tr>
				<tr class="collection">
					<th class="collection">Mata Kuliah</th>
					<td><?php echo $nama ?></p></td>
				</tr>
				<tr class="collection">
					<form>
						<div class="bordered">
							<th class="collection">IPK</th> 
							<td><input
								type="number"  step="any" min="1" max="4" class="collection" name="nomor"
								placeholder="Masukkan nilai IPK Anda" required></input></td>
						</div>
				</tr>
				<tr class="collection">
						<div class="bordered">
						<th class="collection">SKS</th> 
							<td><input
								type="number" min="1" class="collection" name="nomor"
								placeholder="Masukkan jumlah SKS yang Anda ambil sekarang" required></input></td>
						</div>
						
				</tr>
			</tbody>
			
		</table> <br>
			<div style="text-align: center">         
				<button type="submit" class="btn btn-default">Daftar</button>
				&nbsp; &nbsp;
				<button class="btn btn-default"><a href="index.php">Batal</button>
			</div>
					</form>
	</div>
	
	</body>
	<footer>
	 <p style="text-align:center; color:red;"><small>Copyright &copy; 2016 SIASISTEN - TK Basdat B05</small></p>
    </footer>
</html>