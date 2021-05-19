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
	$arahan_simpan = "insert into KELAS ($tingkatan , $nama_kelas , $id_guru)
	values ('$tingkatan' , '$nama_kelas' , '$id_guru')"; 

	//melaksanakan arahan untuk memasukkan data 
	if (mysqli_query($condb , $arahan_simpan)) {

		//data berjaya disimpan 
		echo "<script>alert('Pendaftaran BERJAYA YAYYYYYY!!!!');
		window.location.href = 'senarai_kelas.php';</script>";
	}

	else {

		//data gagal disimpan 
		echo "<script>alert('Pendaftaran GAGAL BOOOOOOOOOOOOO');
		window.location.href = 'senarai_kelas.php';</script>";
	}
}

// -------- bahagian mengemaskini guru kelas ----------- 

//menyemak kewujudan data GET 
if (!empty ($_GET)) {

	//mengambil data GET 
	$id_kelas = $_GET['id_kelas'];
	$id_guru = $_GET['id_guru'];

	if (empty ($id_guru) or empty ($id_kelas)) {

		die("<script>alert('Sila lengkapkan maklumat'); 
			window.history.back();</script>");
	}

	//arahan untuk mengemaskini guru kelas 
	$arahan_kemaskini = "update KELAS set id_guru = '$id_guru' where id_kelas = '$id_kelas'";

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
