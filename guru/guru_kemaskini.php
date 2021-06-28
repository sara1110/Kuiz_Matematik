<?PHP 
//memangil fail header_guru.php 
include ('header_guru.php');

//menyemak kewujudan data GET untuk mengelak fail diakses tanpa data GET 
if(empty($_GET)){
	die("<script>alert('Akses tanpa kebenaran');
		window.location.href = 'murid_senarai.php';</script>");
}

if(!empty($_POST)){
	//mengambil data baru yang diubah suai melalui borang di bawah 
	$nama = mysqli_real_escape_string($condb , $_POST['nama_baru']);
	$id = mysqli_real_escape_string ($condb , $_POST['id_baru']);
	$katalaluan = mysqli_real_escape_string($condb , $_POST['katalaluan_baru']);
	$tahap = $_POST['tahap'];

	//menyemak kewujudan data yang diambil 
	if(empty($nama) or empty($id) or empty($katalaluan) or empty($tahap)){
		//jika tidak wujud, aturcara akan terhenti di sini 
		die("<script>alert('Sila lengkapkan maklumat');
			window.history.back();</script>");
	}

	//had atas dan bawah. data validation bagi id guru 
	if (strlen($id) != 12 or !is_numeric($id)) {
		die("<script>alert('Ralat No.ID');
		window.history.back();</script>");
	}

	//arahan untuk mengemaskini data guru
	$arahan_kemaskini = "update GURU set 
	nama_guru = '$nama',
	id_guru = '$id',
	katalaluan_guru = '$katalaluan', 
	tahap = '$tahap'
	where 
	id_guru = '".$_GET['id_guru']."'";

	//melaksanakan arahan untuk mengemaskini data guru ke dalam jadual
	if(mysqli_query($condb , $arahan_kemaskini)){
		//data berjaya dikemaskini 
		echo "<script>alert('Kemaskini berjaya YAYAYAYAYAYYYYYYYYY!!!!');
		window.location.href = 'guru_senarai.php';</script>";
	}

	else {
		//data gagal dikemaskini 
		echo "<script>alert('Kemaskini gagal BOOOOOO!');
		window.location.href = 'guru_senarai.php';</script>";
	}
}
?>

<!-- bahagian untuk memaparkan senarai guru -->
<h3>Senarai Guru</h3>
<?PHP include ('../butang_saiz.php'); ?>
<table width = "100%" border = "1" id = "besar">
	<tr>
		<td>Nama</td>
		<td>Id</td>
		<td>Katalaluan</td>
		<td>Tahap</td>
		<td>Tindakan</td>
	</tr>
	<tr>
		<!-- borang untuk mendaftar guru baru -->
		<form action = " " method = "POST">
<td><input type = "text" name = "nama_baru" value = "<?PHP echo $_GET['nama_guru']; ?>"></td>
<td><input type = "text" name = "id_baru" value = "<?PHP echo $_GET['id_guru']; ?>"></td>
<td><input type = "password" name = "katalaluan_baru" value = "<?PHP echo $_GET['katalaluan_guru']; ?>"></td>
    <td>
    	<select name = "tahap">
    		<option value selected="" disabled>Pilih</option>
    		<option value = "GURU">GURU</option>
    		<option value = "ADMIN">ADMIN</option>
    		
    	</select>
    </td>
		<td><input type = "submit" value = "kemaskini"></td>	
		</form>
	</tr>

<?PHP 
//arahan SQL untuk memilih data dari jadual guru 
$arahan_cari_guru = "SELECT * from GURU order by tahap ASC";

//melaksanakan arahan SQL diatas
$laksana_cari_guru = mysqli_query($condb , $arahan_cari_guru);

//mengambil semua data yang ditemui 
while($data = mysqli_fetch_array($laksana_cari_guru)){
	//umpuk data kedalam tatasusunan 
	$data_guru = array(
		'nama_guru' => $data['nama_guru'],
		'id_guru' => $data['id_guru'],
		'katalaluan_guru' => $data['katalaluan_guru']
	);

	//memaparkan data dalam bentuk jadual baris demi baris 
	echo "<tr>
	<td>".$data['nama_guru']."</td>
	<td>".$data['id_guru']."</td>
	<td>".$data['katalaluan_guru']."</td>
	<td>".$data['tahap']."</td>
    <td>
| <a href = 'guru_kemaskini.php? ".http_build_query($data_guru)."'>Kemaskini</a>
| <a href = 'padam.php?jadual=guru&medan=id_guru&id=".$data['id_guru']."'>Padam</a> |
    </td>   
	</tr>";
}
?>	
</table>
<?PHP include('footer_guru.php'); ?>
