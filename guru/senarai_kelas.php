<?PHP 
//memanggil fail header_guru.php 
include ('header_guru.php');

//----------bahagian menambah data baru ------------

//menyemak kewujudan data _POST 
if (!empty ($_POST)) {

	//mengambil data POST 
	$nama_kelas = mysqli_real_escape_string ($condb , $_POST['nama_kelas']);
	$tingkatan = mysqli_real_escape_string ($condb , $_POST['tingkatan']);
	$id_guru = $_POST['id_guru'];

	//menyemak kewujudan data yang diambil 
	if (empty ($nama_kelas) or empty ($tingkatan) or empty ($id_guru)) {

		die("<script>alert('Sila lengkapkan maklumat!!!');
			window.history.back();</script>");
	}

	//arahan untuk memasukkan data ke dalam KELAS 
	$arahan_simpan = "insert into KELAS (tingkatan , nama_kelas , id_guru)
	values ('$tingkatan' , '$nama_kelas' , '$id_guru')"; 

	//melaksanakan arahan untuk memasukkan data 
	if (mysqli_query($condb , $arahan_simpan)) {

		//data berjaya disimpan 
		echo "<script>alert('Pendaftaran BERJAYA YAYYYYYY!!!!');
		window.location.href = 'senarai_kelas.php';</script>";
	}

	else {

		//data gagal disimpan 
		trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($condb), E_USER_ERROR);
		echo "<script>alert('Pendaftaran GAGAL BOOOOOOOOOOOOO');
		window.location.href = 'senarai_kelas.php';</script>";
	}
}

// -------- bahagian mengemaskini guru kelas ----------- 

//menyemak kewujudan data GET 
if (!empty ($_GET)) {

	//mengambil data GET 
	$id_kelas = $_GET['id_kelas'];
	$id_guru = $_GET['id_guru_baru'];

	if (empty ($id_kelas) or empty ($id_guru)) {

		die("<script>alert('Sila lengkapkan maklumat'); 
			window.history.back();</script>");
	}

	//arahan untuk mengemaskini guru kelas 
	$arahan_kemaskini = "update KELAS set id_guru = '$id_guru' where id_kelas = '$id_kelas' ";

	//melaksanakan arahan untuk mengemaskini guru kelas 
	if (mysqli_query ($condb , $arahan_kemaskini)) {

		//kemaskini berjaya 
		echo "<script>alert('Kemaskini BERJAYA YAYYYYYYYYY'); 
		      window.location.href = 'senarai_kelas.php';</script>";
	}

	else {

		//kemaskini gagal 
		echo "<script>alert('Kemaskini GAGAL BOOOOOOOOOOOO!!!!!');
		      window.location.href = 'senarai_kelas.php';</script>";
	}
}
?>

<!-- ---------Bahagian untuk memaparkan senarai kelas dan guru---------- -->
<h3>Senarai Kelas</h3>
<?PHP include ('../butang_saiz.php'); ?>
<table width = "100%" border = "1" id = "besar">
	<tr>
		<td>Tingkatan</td>
		<td>Nama Kelas</td>
		<td>Guru Subjek</td>
		<td>Tukar Guru Baru</td>
		<td>Tindakan</td>
	</tr>
<tr> 
<!-- borang untuk mendaftar kelas baru -->
<form name = "tambah_kelas" action =" " method = "POST">
		<td><input type = "text" name = "tingkatan"></td>
		<td><input type = "text" name = "nama_kelas"></td>
		<td>
			<select name = 'id_guru'>
				<option value selected disable>Pilih</option>
				<?PHP 
				//arahan untuk mencari semua data dari jadual jenis_guru 
				$sql = "select * from GURU";

				//melaksanakan arahan mencari data 
				$laksana_arahan_cari = mysqli_query ($condb , $sql);

				//pembolehubah $rekod_guru mengambil data yang ditemui baris demi baris
				while ($rekod_guru = mysqli_fetch_array ($laksana_arahan_cari)) {

					//memaparkan data yang ditemui dalam element <option></option>
					echo "<option value = ".$rekod_guru['id_guru'].">".$rekod_guru['nama_guru']."</option>";
				}
				?>	
			</select>
		</td>
		<td></td>
		<td><input type = "submit" value = "Tambah Kelas Baru"></td>
	</form>
</tr>

<?PHP 
//arahan untuk mencari data yang sepadan dari jadual kelas dan guru 
$arahan_cari_kelas = "select * from KELAS , GURU where KELAS.id_guru = GURU.id_guru order by nama_kelas ASC";

//melaksanakan arahan untuk mencari data 
$laksana_cari_kelas = mysqli_query ($condb , $arahan_cari_kelas);

//pembolehubah $data mengambil data yang ditemui 
while ($data = mysqli_fetch_array ($laksana_cari_kelas)) {

	//memaparkan data baris demi baris 
	echo "<tr>
	       <td>".$data['tingkatan']."</td>
	       <td>".$data['nama_kelas']."</td>
	       <td>".$data['nama_guru']."</td>
	       <td>
	       <form action = '' method = 'GET'>
	       <input type = 'hidden' name = 'id_kelas' value = '".$data['id_kelas']."'>
	       <select name = 'id_guru_baru'>
	       			<option value selected disabled>Pilih</option>";


	    //arahan untuk mencari semua data dari jadual jenis_guru 
	    $sql2 = "select * from GURU";

	    //melaksanakan arahan mencari_data 
	    $laksana_arahan_cari2 = mysqli_query ($condb , $sql2) or trigger_error("Query Failed! SQL: $sql - Error: ".mysqli_error($condb), E_USER_ERROR);

	    //pembolehubah $rekod_guru mengambil data yang ditemui baris demi baris 
	    while ($rekod_guru2 = mysqli_fetch_array ($condb , $laksana_arahan_cari2)) {

	    	//memaparkan data yang ditemui dalam element <option></option>
	    	echo "<option value = '".$rekod_guru2['id_guru']."'> ".$rekod_guru2['nama_guru']."</option>";
	    }

	//memaparkan data yang ditemui dalam element <option></option>
	    echo "</select><td>
	     | <input type = 'submit' value = 'Kemaskini Guru Subjek'>

	     |<button onclick =\"location.href='padam.php?jadual=KELAS&medan=id_kelas&id=".$data['id_kelas']."'\" type = 'button'>Padam Kelas</button>|
	        </td>
	    </tr>
	</form> ";
}
?>
</table>
<?PHP include ('footer_guru.php'); ?>