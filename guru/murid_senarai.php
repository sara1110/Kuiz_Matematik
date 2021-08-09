<?PHP 
//memanggil fail header_guru.php
include ('header_guru.php');

//menyemak kewujudan data _POST bagi mendaftar murid baru
if (!empty($_POST)) {

	//mengambil data murid baru yang dihantar melalui borang pada senarai 
	$nama = mysqli_real_escape_string($condb , $_POST['nama_baru']);
	$id = mysqli_real_escape_string ($condb , $_POST['id_baru']);
	$katalaluan = mysqli_real_escape_string ($condb , $_POST['katalaluan_baru']);
	$id_kelas = $_POST['id_kelas'];

	//menyemak kewujudan data yang dihantar 
	if (empty($nama) or empty($id) or empty($katalaluan) or empty($id_kelas)){
		die("<script>alert('Sila lengkapkan maklumat'); 
			window.history.back();</script>");
	}

	//had atas, had bawah. data validation untuk id murid
	if (strlen($id) != 12 or !is_numeric($id)) {
		die("<script>alert('Ralat No. Id');
			window.location.back();</script>");
	}

	//arahan untuk menyimpan data murid 
	$arahan_simpan = "insert into PELAJAR (nama_pelajar , id_pelajar , katalaluan_pelajar , id_kelas)
	values ($nama , $id , $katalaluan , $id_kelas)";

	//melaksanakan arahan simpan data murid 
	if (mysqli_query($condb , $arahan_simpan)){

		//data berjaya disimpan 
		echo "<script>alert('Data BERJAYA disimpan YAYYYYYYYYY!!!!');
		window.location.href = 'murid_senarai.php';</script>";
	}

	else {

		//data gagal disimpan 
		echo "<script>alert('Data GAGAL disimpan BOOOOOOO');
		window.location.href = 'murid_senarai.php'; </script>";
	}
}
?>

<!-- jadual untuk memaparkan senarai murid -->
<h3>Senarai Murid</h3>

<!-- link untuk memuat naik fail data murid -->
<a href = 'murid_upload.php'>[+] Upload Data Pelajar</a>

<!-- link untuk membesarkan saiz tulisan bagi aspek kepelbagaian pengguna -->
<?PHP include ('../butang_saiz.php'); ?>

<table>
	<tr>
		<td>Nama Murid</td>
		<td>Id Murid</td>
		<td>Katalaluan</td>
		<td>Kelas</td>
		<td>Tindakan</td>
	</tr>
	<tr>
<!-- borang untuk mendaftar murid baru --> 
    <form action = " " method = 'POST'>
    	<td><input type = "text" name = "nama_baru"></td>
    	<td><input type = "text" name = "id_baru"></td>
    	<td><input type = "password" name = "katalaluan_baru"></td>
    	<td>
    		<select name = "id_kelas">
    			<option value selected disable>Pilih</option>
<?PHP 
//arahan untuk mencari semua data dari jadual kelas 
$sql = "select * from kelas";

//melaksanakan arahan mencari data 
$laksana_arahan_cari = mysqli_query($condb , $sql);

//pembolehubah $rekod_bilik mengambil data yang ditemui baris demi baris 
while ($rekod_bilik = mysqli_fetch_array($laksana_arahan_cari)){
	//memaparkan data yang yang ditemui dalam element <option></option>
	echo "<option value = ".$rekod_bilik['id_kelas'].">".$rekod_bilik['tingkatan']." ".$rekod_bilik['nama_kelas']."</option>";
}
?>
    		</select>
    	</td>
    	<td><input type = 'submit' value = 'simpan'></td>
    </form>
		
	</tr>

<?PHP 
//arahan untuk mencari semua data murid yang berdaftar 
$arahan_cari_murid = "select * from PELAJAR , KELAS
where 
PELAJAR.id_kelas = KELAS.id_kelas
order by KELAS.tingkatan , KELAS.nama_kelas , PELAJAR.nama_pelajar ASC";

//melaksanakan arahan untuk mencari 
$laksana_cari_murid = mysqli_query($condb , $arahan_cari_murid);

//pembolehubah $data mengambil semua data yang ditemui 
while ($data = mysqli_fetch_array($laksana_cari_murid)){

	//mengumpukan data murid kedalam tatasusunan data_pelajar
	$data_pelajar = array(
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
| <a href = 'murid_kemaskini.php?".http_build_query($data_pelajar)."'> Kemaskini </a>

| <a href = 'padam.php?jadual=PELAJAR&medan=id_pelajar&id=".$data['id_pelajar']."' onClick=\"return confirm ('Anda pasti anda ingin memadam data ini.')\">Padam</a> |
       </td>
      </tr>";

}
?>	
</table>
<?PHP include ('footer_guru.php'); ?>