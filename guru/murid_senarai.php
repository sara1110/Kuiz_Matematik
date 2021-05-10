<?PHP 
//memanggil fail header_guru.php
include ('header_guru.php');

//menyemak kewujudan data _POST bagi mendaftar murid baru
if (!empty($_POST)) {

	//mengambil data murid baru yang dihantar melalui borang pada senarai 
	$nama = mysqli_real_escape($condb , $_POST['nama_baru']);
	$id = mysqli_real_escape($condb , $_POST['id_baru']);
	$katalaluan = mysqli_real_escape($condb , $_POST['katalaluan_baru']);
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
