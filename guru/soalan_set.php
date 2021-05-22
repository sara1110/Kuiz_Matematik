<?PHP 
//memanggil fail header_guru.php 
include ('header_guru.php');

//----- Bahagian untuk menyimpan data set_soalan baru 

//menyemak kewujudan data POST 
if (!empty($_POST)) {

	//mengambil data POST 
	$topik = mysqli_real_escape_string ($condb , $_POST['topik']);
	$arahan = mysqli_real_escape_string ($condb , $_POST['arahan']);
	$jenis = $_POST['jenis'];
	$tarikh = $_POST['tarikh'];

	//menetapkan masa kuiz 
	if ($jenis == 'Latihan')
	$masa = "Tiada";
	else 
	$masa = mysqli_real_escape_string ($condb , $_POST['masa']);

	//menyemak kewujudan data yang diambil 
	if (empty($topik) or empty($arahan) or empty($jenis) or empty($tarikh) or empty($masa)) {

		//jika terdapat pembolehubah yang tidak mempunyai nilai, aturcara akan dihentikan 
		die("<script>alert('Sila lengkapkan maklumat'); 
			window.location.href = 'soalan_set.php';</script>");
	}

	//arahan untuk menyimpan data set_soalan baru 
	$arahan_simpan = "insert into set_soalan (topik , arahan , jenis , tarikh , masa , id_guru) values ('$topik' , '$arahan' , '$jenis' , '$tarikh' , '$masa' , '".$_SESSION['id_guru']."')"; 

	if (mysqli_query ($condb , $arahan_simpan)) {

		//data berjaya disimpan 
		echo "<script>alert('Pendaftaran BERJAYA YAYYYYYYYYY!!!!');
		window.location.href = 'soalan_set.php';</script>";
	}

	else {

		//data gagal disimpan 
		echo "<script>alert('Pendaftaran GAGAL BOOOOOOOO!!!!');
		window.location.href = 'soalan_set.php';</script>";
	}
}
?>