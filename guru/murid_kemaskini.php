<?PHP 
//memanggil fail header_guru.php 
include ('header_guru.php');

//menyemak kewujudan data GET untuk mengelak fail diakses tanpa data GET
if (empty($_GET)){

	die("<script>alert('Akses tanpa kebenaran');
		window.location.href = 'murid_senarai.php'; </script>");
}

if (!empty($_GET)){

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