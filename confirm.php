<?php
			/** session_start();
			if(!isset($_SESSION["username"])){
				header("Location: index.php");
			} */
			require "session.php";
			function connectDB(){
			$conn = pg_connect("host=localhost port=5432 dbname=mydb user=postgres password=basdat");
			if (!$conn) {
				die("Connection failed: " . pg_last_error());
			}
			return $conn;
		}

			$conn = connectDB();
			//$nama = $_GET['nama'];
			$idlowongan = $_GET['idlowongan'];
			
			$sql= "SELECT mk.nama from SIASISTEN.lowongan l, SIASISTEN.kelas_mk k, SIASISTEN.mata_kuliah mk 
			WHERE l.idlowongan = $idlowongan AND l.idkelasmk = k.idkelasmk AND k.kode_mk = mk.kode";
			$result = pg_query($conn, $sql);
			$row = pg_fetch_array($result);
			$nama = $row['nama'];
			
			
			if($_SERVER["REQUEST_METHOD"] == "POST"){
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
			$resp = '';
			if (pg_query($conn, $sql)) {
				$resp = "Selamat, Anda telah mendaftar pada lowongan Mata Kuliah ". $nama."";
			}
		//$sql2 = "INSERT INTO FOODIE.pembelian_bahan_baku(namabahanbaku, notapembelian, jumlahpembelian, satuanpembelian, hargasatuan) VALUES ('$namaBahans', '$nomornotas', '$belis', '$satuans', '$hargas')";
		//$result2 = pg_query($conn, $sql2);
		}
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
		<?php echo $resp;?>
		
		
	</div>
	
	</body>
	<footer>
	 <p style="text-align:center; color:red;"><small>Copyright &copy; 2016 SIASISTEN - TK Basdat B05</small></p>
    </footer>
</html>