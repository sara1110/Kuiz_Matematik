<?php
//memulakan fungsi session_start bagi membolehkan pembolehubah super global 
//session digunakan 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- Tajuk Sistem -->
<h1 align = 'centre' >Kuiz Matematik</h1>
<hr>

<!-- Menu Bahagian Murid -->
<?php if(!empty($_SESSION) and basename($_SERVER['PHP_SELF']) != 'index.php'){ ?>

<?php echo "Nama Murid : ". $_SESSION['nama_murid']; ?>
  <a href = 'pilih_latihan.php' >Laman Utama</a>
  <a href = '../logout.php'>logout</a>
<hr>

<?php } ?>