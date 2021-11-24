<?php
//memulakan fungsi session_start bagi membolehkan pembolehubah super global 
//session digunakan 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<head>
	<link rel="stylesheet" href="/matematik_kuiz/styles/student.css">
</head>

<!-- Tajuk Sistem -->
<h1 align = 'centre' >Kuiz Matematik</h1>
<hr>

<!-- Menu Bahagian Murid -->
<?php if(!empty($_SESSION) and basename($_SERVER['PHP_SELF']) != 'index.php'){ ?>

<?php echo "Nama Pelajar : ". $_SESSION['nama_pelajar']; ?>
  <a href = 'pilih_latihan.php' >Laman Utama</a>
  <a href = '../logout.php'>logout</a>
<hr>

<?php } ?>