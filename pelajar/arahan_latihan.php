<?PHP 
//memangggil fail header.php dan fail connection.php dari folder luaran 
include ('../header.php');
include ('../connection.php');

//menguji kewujudan data _GET 
if (empty($_GET)) {

	//menghenti aturcara jika ada get tidak wujud 
	die ("<script>alert('Akses tanpa kebenaran??? KELUAR!!!!!!!!!!!');
		window.location.href = 'pilih_latihan.php';</script>"); 
}

//arahan untuk memilih set_soalan berdasarkan no_set soalan 
$arahan_pilih_set = "select * from set_soalan where no_set = '".$_GET['no_set']."' ";

//melaksanakan arahan untuk memilih 
$laksana = mysqli_query ($condb , $arahan_pilih_set);

//pembolehubah data mengambil data yang ditemui 
$data = mysqli_fetch_array ($laksana);
?>

<!-- Memaparkan arahan untuk menjawab soalan -->
<h3>Arahan</h3>
<hr>
<?PHP echo $data['arahan']; ?> <br>

<a href = 'jawab_soalan.php?no_set=<?PHP echo $_GET['no_set']; ?>&masa=<?PHP echo $data['masa']; ?>&jenis=<?PHP echo $data['jenis']; ?>' >
Mula </a>

<?PHP include ('../footer.php'); ?>