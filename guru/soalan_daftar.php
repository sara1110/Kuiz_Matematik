<?PHP 
//memangil fail header_guru.php 
include ('header_guru.php');

//---bahagian menyimpan data soalan baru ----

//menyemak kewujudan data POST 
if(!empty($_POST)) {

	//mengambil data POST 
	$soalan = mysqli_real_escape_string ($condb , $_POST['soalan']);
	$jawapan_a = mysqli_real_escape_string ($condb , $_POST['jawapan_a']);
	$jawapan_b = mysqli_real_escape_string ($condb , $_POST['jawapan_b']);
	$jawapan_c = mysqli_real_escape_string ($condb , $_POST['jawapan_c']);
	$jawapan_d = mysqli_real_escape_string ($condb , $_POST['jawapan_d']);

	//menguji soalan yag dihasilkan mempunyai gambar 
	if ($_FILES['gambar']['size'] != 0) {

		//bahagian memuat naik gambar soalan 
		$timestmp = date("Y-m-d");
		$saiz_fail = $_FILES['gambar']['size'];
		$nama_fail = basename ($_FILES["gambar"]["name"]);
		$jenis_gambar = pathinfo($nama_fail , PATHINFO_EXTENSION);
		$lokasi = $_FILES['gambar']['tmp_name'];
		$nama_baru_gambar = "../images/".$timestmp.".".$jenis_gambar;
		move_uploaded_file($lokasi, $nama_baru_gambar);

		//arahan untuk menyimpan soalan yang mempunyai gambar 
		$arahan_simpan = "INSERT into soalan (no_set , soalan , gambar , jawapan_a , jawapan_b , jawapan_c , jawapan_d)
		values 
		('".$_GET['no_set']."' , '$soalan' , '$nama_baru_gambar' ,
		'$jawapan_a' , '$jawapan_b' , '$jawapan_c' , '$jawapan_d')";
	}

	else {

		//arahan untuk menyimpan soalan yang tidak mempunyai gambar 
		$arahan_simpan = "insert into soalan (no_set , soalan , jawapan_a , jawapan_b , jawapan_c , jawapan_d)
		values 
		('".$_GET['no_set']."' , '$soalan' , '$jawapan_a' , '$jawapan_b' , '$jawapan_c' , '$jawapan_d')";
	}

	if (empty($soalan) or empty($jawapan_a) or empty($jawapan_b) or empty($jawapan_c) or empty($jawapan_d)) {

		die ("<script>alert('Sila lengkapkan maklumat!!');
			window.history.back();</script>");
	}

	//melaksanakan arahan untuk menyimpan soalan 
	if (mysqli_query ($condb , $arahan_simpan)) {

		//data soalan berjaya disimpan 
		echo "<script>alert('Pendaftaran BERJAYA YAYYYYYYYY!!!!!!');
		window.location.href = 'soalan_daftar.php?no_set=".$_GET['no_set']."&topik=".$_GET['topik']."'</script>";
	}

	else {

		//data soalan gagal disimpan 
		echo "<script>alert('Pendaftaran GAGAL BOOOOOOOOOO!!!!!!');
		window.location.href = 'soalan_daftar.php?no_set=".$_GET['no_set']."&topik=".$_GET['topik']."'</script>";
		

	}
}
?>

<!-- Bahagian untuk memaparkan soalan yang telah didaftarkan -->
<h3>Senarai Soalan</h3>
<?PHP include ('../butang_saiz.php'); ?> 
<table width = '100%' border = '1' id = 'besar'>
	<tr>
		<td>Soalan</td>
		<td>Gambar Soalan</td>
		<td bgcolor = 'cyan'>Jawapan A (betul)</td>
		<td bgcolor = 'pink'>Jawapan B</td>
		<td bgcolor = 'pink'>Jawapan C</td>
		<td bgcolor = 'pink'>Jawapan D</td>
		<td></td>
	</tr>
	<tr>
	<!-- Bahagian untuk mendaftar soalan baharu -->
		<form action = '' method = 'POST' enctype = 'multipart/form-data'>
			<td><textarea name = 'soalan' rows = "4" cols = "25"></textarea></td>
			<td><input type= 'file' name = 'gambar'></td>
			<td bgcolor = 'cyan'>
			<textarea name = 'jawapan_a' rows = "4" cols = "25"></textarea>	
			</td>
			<td bgcolor = 'pink'><textarea name = 'jawapan_b' rows = "4" cols = "25"></textarea></td>
			<td bgcolor = 'pink'><textarea name = 'jawapan_c' rows = "4" cols = "25"></textarea></td>
			<td bgcolor = 'pink'><textarea name = 'jawapan_d' rows = "4" cols = "25"></textarea></td>	
			<td><input type = 'submit' value = 'simpan'></td>
		</form>
	</tr>

<?PHP 
//arahan untuk mencari soalan berdasarkan set soalan 
$arahan_soalan = "SELECT * from soalan where no_set = '".$_GET['no_set']."' order by no_soalan DESC";

//melaksanakan arahan untuk mencari soalan 
$laksana_soalan = mysqli_query ($condb , $arahan_soalan);

//mengambil data soalan yang ditemui 
while ($data = mysqli_fetch_array ($laksana_soalan)) {

	//mengumpukkan data soalan kepada tatasusunan $data_get
	$data_get = array (
		'no_set' => $data['no_set'],
		'no_soalan' => $data['no_soalan'],
		'topik' => $_GET['topik'],
		'soalan' => $data['soalan'],
		'jawapan_a' => $data['jawapan_a'],
		'jawapan_b' => $data['jawapan_b'],
		'jawapan_c' => $data['jawapan_c'],
		'jawapan_d' => $data['jawapan_d']
	);

	//memaparkan soalan data yang ditemui
	echo "<tr>
	<td>".$data['soalan']."</td>
	<td><img src='".$data['gambar']."' width ='50%'></td>
	<td>".$data['jawapan_a']."</td>
	<td>".$data['jawapan_b']."</td>
	<td>".$data['jawapan_c']."</td>
	<td>".$data['jawapan_d']."</td>
<td>
| <a href = 'soalan_set_kemaskini.php?".http_build_query($data_get)."'>Kemaskini</a>

| <a href = 'padam.php?jadual=set_soalan&medan=no_set&id=".$data['no_set']."' onClick=\"return confirm('Anda pasti anda ingin memadam data ini.')\">Padam</a> |
</td>
	</tr>";
}
?>	
</table>
<?PHP include ('footer_guru.php'); ?>