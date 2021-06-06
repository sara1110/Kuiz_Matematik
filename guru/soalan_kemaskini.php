<?PHP 
//memanggil fail header_guru.php 
include ('header_guru.php');

//bahagian untuk menyimpan data yang telah dikemakini 

//menyemak kewujudan data GET 
if (empty ($_GET)) {

	die("<script>alert('Akses tanpa kebenaran eh?? KELUARRRRR!!!!!!');
		window.location.href = 'soalan_set.php?no_set=".$_GET['no_set']."&topik=".$_GET['topik']."';</script>");
}

//menyemak kewujudan data POST 
if (!empty ($_POST)) {

	//mengambil data POST 
	$soalan = mysqli_real_escape_string ($condb , $_POST['soalan']);
	$jawapan_a = mysqli_real_escape_string ($condb , $_POST['jawapan_a']);
	$jawapan_b = mysqli_real_escape_string ($condb , $_POST['jawapan_b']);
	$jawapan_c = mysqli_real_escape_string ($condb , $_POST['jawapan_c']);
	$jawapan_d = mysqli_real_escape_string ($condb , $_POST['jawapan_d']);

	//menyemak kewujudan data yang telah diambil 
	if (empty($soalan) or empty($jawapan_a) or empty($jawapan_b) or empty($jawapan_c) or empty($jawapan_d)) {

		die("<script>alert('Sila lengkapkan maklumat');
			window.history.back();</script");
	}

	//arahan mengemaskini soalan dan jawapan 
	$arahan_kemaskini = "update soalan 
	set 
	soalan = '".$_POST['soalan']."',
	jawapan_a = '".$_POST['jawapan_a']."',
	jawapan_b = '".$_POST['jawapan_b']."',
	jawapan_c = '".$_POST['jawapan_c']."',
	jawapan_d = '".$_POST['jawapan_d']."'
	where 
	no_soalan = '".$_GET['no_soalan']."' ";

	//melaksanakan arahan untuk mengemaskini soalan 
	if (mysqli_query ($condb , $arahan_kemaskini)) {

		//soalan berjaya disimpan 
		echo "<script>alert('Kemaskini BERJAYA YAYYYYYYYYY!!!!');
		window.location.href = 'soalan_set.php?no_set=".$_GET['no_set']."&topik=".$_GET['topik']."';</script>"; 
	}

	else { 

		echo "<script>alert('Kemaskini GAGAL BOOOOOOO!!!!!!');
		window.location.href = 'soalan_set.php?no_set=".$_GET['no_set']."&topik=".$_GET['topik']."';</script>";
	}

}
?>

<!-- Bahagian untuk memaparkan soalan yang telah didaftarkan -->
<h3>Senarai Soalan</h3>
<?PHP include ('../butang_saiz.php'); ?>
<table width = '100%' border = '1' id = 'besar'>
	<tr>
		<td>Soalan</td>
		<td bgcolor = 'cyan'>Jawapan A</td>
		<td bgcolor = 'pink'>Jawapan B</td>
		<td bgcolor = 'pink'>Jawapan C</td>
		<td bgcolor = 'pink'>Jawapan D</td>
		<td></td>
	</tr>
	<tr>
	<!-- Bahagian borang untuk mengemaskini soalan dan jawapan -->
<form action = '' method = 'POST'>

<td><textarea name = 'soalan' rows = "4" cols = "25"><?PHP echo $_GET['soalan']; ?></textarea></td>

<td bgcolor = 'cyan'><textarea name = 'jawapan_a' rows = "4" cols = "25"><?PHP echo $_GET['jawapan_a']; ?></textarea></td>

<td bgcolor = 'pink'><textarea name = 'jawapan_b' rows = "4" cols = "25"><?PHP echo $_GET['jawapan_b']; ?></textarea></td>

<td bgcolor = 'pink'><textarea name = 'jawapan_c' rows = "4" cols = "25"><?PHP echo $_GET['jawapan_c']; ?></textarea></td>

<td bgcolor = 'pink'><textarea name = 'jawapan_d' rows = "4" cols = "25"><?PHP echo $_GET['jawapan_d']; ?></textarea></td>

</form>
</tr>

<?PHP 

//arahan untuk mencari soalan yang berkaitan dengan set soalan yang telah dipilih 
$arahan_soalan = "select * from soalan 
where no_set = '".$_GET['no_set']."'
order by no_soalan DESC";

//melaksanakan arahan untuk mencari soalan 
$laksana_soalan = mysqli_query ($condb , $arahan_soalan);

//pembolehubah $data mengambil data yang ditemui 
while ($data = mysqli_fetch_array ($laksana_soalan)) {

	//mengumpukkan data yang ditemui kepada tatasusunan $data_get 
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

	//memaparkan data yang ditemui baris demi baris 
	"echo <tr>
	<td>".$data['soalan']."</td>
	<td>".$data['jawapan_a']."</td>
	<td>".$data['jawapan_b']."</td>
	<td>".$data['jawapan_c']."</td>
	<td>".$data['jawapan_d']."</td>
<td>
| <a href = 'soalan_set_kemaskini.php?".http_build_query($data_get)."'>Kemaskini</a>

| <a href = 'padam.php?jadual=soalan&medan=no_soalan&id=".$data['no_soalan']."'>Padam</a> |
</td>
	</tr>";
}
?>	
</table>
<?PHP include ('footer_guru.php'); ?>