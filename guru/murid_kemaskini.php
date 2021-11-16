<?PHP 
//memanggil fail header_guru.php 
include ('header_guru.php');

//menyemak kewujudan data GET untuk mengelak fail diakses tanpa data GET
if (empty($_GET)){

	die("<script>alert('Akses tanpa kebenaran');
		window.location.href = 'murid_senarai.php'; </script>");
}

if (!empty($_POST)){

	//mengambil data baru yang diubah suai melalui borang di bawah
	$nama = mysqli_real_escape_string($condb, $_POST['nama_baru']);
	$id = mysqli_real_escape_string($condb , $_POST['id_baru']);
	$katalaluan = mysqli_real_escape_string($condb , $_POST['katalaluan_baru']);
	$id_kelas = $_POST['id_kelas'];

	//menyemak kewujudan data yang diambil 
	if (empty($nama) or empty($id) or empty($katalaluan) or empty($id_kelas)){

		//jika data tidak wujud, aturcara akan terhenti di sini
		die("<script>alert('Sila lengkapkan maklumat');
			window.history.back();</script>");
	}

	//had atas dan had bawah. data validation bagi id murid
    if (strlen($id) != 12 or !is_numeric($id)){

		die("<script>alert('Ralat No. Id');
			window.history.back();</script>");
	}

	//arahan untuk mengemaskini data murid 
	$arahan_kemaskini = "update PELAJAR set
	nama_pelajar = '$nama'
	id_pelajar = '$id'
	katalaluan_pelajar = '$katalaluan'
	id_kelas = '$id_kelas'
	WHERE 
	id_pelajar = '".$_GET['id_pelajar']."' ";

	//melaksanakan arahan untuk menyimpan data murid ke dalam jadual 
	if (mysqli_query($condb , $arahan_kemaskini)){

		//data berjaya disimpan 
		echo "<script>alert('Kemaskini BERJAYA YAYYYYYY!!!');
		window.location.href = 'murid_senarai.php';</script>";
	}

	else {

		//data gagal disimpan 
		echo "<script>alert('Kemaskini GAGAL BOOOOOOOO!');
		window.location.href = 'murid_senarai.php';</script>";
	}
}
?>

<!-- Bahagian untuk memaparkan senarai murid -->
<h3>Senarai Murid</h3>

<!-- link untuk memuat naik fail data murid -->
<a href = 'murid_upload.php'>[+] Upload Data Murid</a>

<!-- link untuk membesarkan saiz tulisan bagi aspek kepelbagaian pengguna -->
<?PHP include ('../butang_saiz.php'); ?>

<table width = "100%" border = "1" id = "besar">
	<tr>
		<td>Nama Murid</td>
		<td>Id Murid</td>
		<td>Katalaluan Murid</td>
		<td>Kelas</td>
		<td>Tindakan</td>
	</tr>

	<tr>
		<!-- borang untuk mendaftar murid baharu -->
		<form action = " " method = "POST">
		<td><input type = "text" name = "nama_baru" value = "<?PHP echo $_GET['nama_pelajar']; ?>"></td>
		<td><input type = "text" name = "id_baru" value = "<?PHP echo $_GET['id_pelajar'];?>"></td>
		<td><input type = "password" name = "katalaluan_baru" value = "<?PHP echo $_GET['katalaluan_pelajar']; ?>"></td>
		<td>
			<select name = "id_kelas">
				<option value selected disabled>Pilih</option>
				<?PHP 
				//arahan untuk mencari semua data murid yang berdaftar
				$sql = "SELECT * from KELAS";

				//melaksanakan arahan mencari data
				$laksana_arahan_cari = mysqli_query ($condb , $sql);

				//pembolehubah $rekod_bilik mengambil data yang ditemui baris demi baris 
				while ($rekod_bilik = mysqli_fetch_array($laksana_arahan_cari)) {

					//memaparkan data yang ditemui dalam element 
					echo "<option value = ".$rekod_bilik['tingkatan'].">".$rekod_bilik['nama_kelas']."</option>";
				}

				?>
				
			</select>
		</td>
		<td><input type = "submit" value = "simpan"></td>
	</tr>

	<?PHP 
	//arahan untuk mencari semua data murid yang berdaftar
	$arahan_cari_murid = "select * from PELAJAR , KELAS 
	where 
	PELAJAR.id_kelas = KELAS.id_kelas
	order by KELAS.tingkatan , KELAS.nama_kelas , PELAJAR.nama_pelajar ASC";

	//melaksanakan arahan untuk mencari 
	$laksana_cari_murid = mysqli_query ($condb , $arahan_cari_murid);

	//pembolehubah $data mengambil semua data yang ditemui 
	while ($data = mysqli_fetch_array ($laksana_cari_murid)) {

		//mengumpukan data murid kedalam tatasusunan data_pelajar
		$data_pelajar = array (

			'nama_pelajar' => $data['nama_pelajar'],
			'id_pelajar' => $data['id_pelajar'],
			'katalaluan_pelajar' => $data['katalaluan_pelajar']
		);

		//memaparkan data murid baris demi baris 
		echo "<tr>
		<td>".$data['nama_pelajar']."</td>
		<td>".$data['id_pelajar']."</td>
		<td>".$data['katalaluan_pelajar']."</td>
		<td>
| <a href = 'murid_kemaskini.php?".http_build_query($data_pelajar)."'>Kemaskini</a>
| <a href = 'padam.php?jadual=PELAJAR&medan=id_pelajar&id=".$data['id_pelajar']."'>Padam</a> |
</td></tr>";
	}
	?>
</table>
<?PHP include ('footer_guru.php'); ?>
