
<head>
	<link rel="stylesheet" href="/matematik_kuiz/styles/guru.css">
</head>

<?PHP 
//memulakan fungsi session 
session_start();


//memangil fail guard_guru.php
include ('guard_guru.php');

//memangil fail connection dari folder utama 
include ('../connection.php');

//menguji pembolehubah session tahap mempunyai nilai atau tidak 
if (empty($_SESSION['tahap']))
{
	//proses untuk mendapatkan tahap pengguna yang sedang login samada admin atau guru
	$arahan_semak_tahap = "select* from GURU where 
	id_guru = '".$_SESSION['id_guru']."'
	limit 1";
	$laksana_semak_tahap = mysqli_query( $condb , $arahan_semak_tahap);
	$data = mysqli_fetch_array($laksana_semak_tahap);
	$_SESSION['tahap'] = $data['tahap'];
}
?>

<!-- tajuk Sistem -->
<h1>Kuiz Matematik: Bahagian Guru</h1>

<!-- menu -->
<ul class="menu">
<li><a href = "index.php">Laman Utama</a></li>
<?PHP if ($_SESSION['tahap']=='ADMIN'){ ?>
	<li><a href= "guru_senarai.php"> Maklumat Guru</a></li>
	<li><a href= "murid_senarai.php"> Pengurusan Murid</a></li>
	<li><a href= "senarai_kelas.php"> Pengurusan Kelas</a></li>
<?PHP } ?>
    <li><a href= "soalan_set.php"> Pengurusan Soalan</a></li>
    <li><a href= "analisis.php"> Analisis Prestasi</a></li>
    <li><a href= "../logout.php"> Logout</a></li>
</ul>
<hr>
