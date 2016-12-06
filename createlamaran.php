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
			$idlowongan = '';
			if (isset($_GET['idlowongan'])){
				$idlowongan = $_GET['idlowongan'];
			}
			$sql= "SELECT k.tahun, k.semester, mk.nama, mk.kode from SIASISTEN.lowongan l, SIASISTEN.kelas_mk k, SIASISTEN.mata_kuliah mk 
			WHERE l.idlowongan = $idlowongan AND l.idkelasmk = k.idkelasmk AND k.kode_mk = mk.kode";
			/**$sql = "SELECT  kelas_mk.idkelasmk,
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
							
							;";*/
			$result = pg_query($conn, $sql);
			
			while($row = pg_fetch_assoc($result)) {
				$tahun = $row["tahun"];
				$semester = $row["semester"];
				$namaMatkul = $row["nama"];
				$kode_mk = $row["kode"];
			//	$kategori = $row["kategori"];
			}
		//$namamenu = str_replace('_', ' ', $namamenu);
		 //require "role.php"
		 			/** session_start();
			if(!isset($_SESSION["username"])){
				header("Location: index.php");
			} */
	
		/**if($_SERVER["REQUEST_METHOD"] == "POST"){
			$ipk = $_POST["ipk"];
			$jumlahSKS = $_POST["jumlahSKS"];
			
			$sql2 = "SELECT max(idlamaran) from SIASISTEN.lamaran";
			$result = pg_query($conn, $sql2);
			$row = pg_fetch_array($result);
			$idlamaran = $row['max'];
			
			$username = $_SESSION['username'];
			$sqlnpm = "SELECT npm from SIASISTEN.mahasiswa WHERE username = '$username'";
			$resultnpm = pg_query($conn, $sqlnpm);
			$row = pg_fetch_array($resultnpm);
			$npm = $row['npm'];
			
			$sql = "SELECT nipdosenpembuka from SIASISTEN.lowongan WHERE idlowongan = $idlowongan";
			$result = pg_query($conn, $sql);
			$row = pg_fetch_array($result);
			$nip = $row['nipdosenpembuka'];
			
			$sql = "INSERT INTO SIASISTEN.lamaran(idlamaran, npm, idlowongan, id_st_lamaran, ipk, jumlahSKS, nip) VALUES ($idlamaran+1, '$npm', '$idlowongan', '330001', '$ipk', '$jumlahSKS', '$nip');";
			if (pg_query($conn, $sql)) {
				header('Location: confirm.php?nama=$namaMatkul');
			}
		//$sql2 = "INSERT INTO FOODIE.pembelian_bahan_baku(namabahanbaku, notapembelian, jumlahpembelian, satuanpembelian, hargasatuan) VALUES ('$namaBahans', '$nomornotas', '$belis', '$satuans', '$hargas')";
		//$result2 = pg_query($conn, $sql2);
		}*/
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
					<td><?php echo $namaMatkul ?></p></td>
				</tr>
				<tr class="collection">
					<form action="confirm.php?idlowongan=<?php echo $idlowongan;?>" method="post">
						<div class="bordered">
							<th class="collection">IPK</th> 
							<td><input
								type="number"  step="any" min="1" max="4" class="collection" name="ipk"
								placeholder="Masukkan nilai IPK Anda" required></input></td>
						</div>
				</tr>
				<tr class="collection">
						<div class="bordered">
						<th class="collection">SKS</th> 
							<td><input
								type="number" min="1" class="collection" name="jumlahSKS"
								placeholder="Masukkan jumlah SKS yang Anda ambil sekarang" required></input></td>
						</div>
						
				</tr>
			</tbody>
			
		</table> <br>
			<div style="text-align: center">         
				<button type="submit" class="btn btn-default">Daftar</button>
				&nbsp; &nbsp;
			</form>
			<a href="melihatLowongan.php"><button class="btn btn-default" >Batal</button></a>
			</div>
	</div>
	
	</body>
	<footer>
	 <p style="text-align:center; color:red;"><small>Copyright &copy; 2016 SIASISTEN - TK Basdat B05</small></p>
    </footer>
</html>