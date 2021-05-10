<?PHP 
//memulakkan fungsi sesson start 
session_start();

//menyemak kewujudan data _GET
if (!empty($_GET)) {
	
	//memanggil fail connection dari folder utama 
	include('../connection.php');

	//mengambil data yang dihantar 
	$jadual = $_GET['jadual'];
	$medan = $_GET['medan'];
	$id = $_GET['id'];

	//arahan untuk memadam rekod di dalam jadual 
	$arahan_padam = "delete from $jadual where $medan = '$id'";

	//melaksanakn arahan untuk memadam rekod 
	if(mysqli_query($condb , $arahan_padam)){

		//data berjaya dipadam
		echo "<script>alert('Data berjaya dipadam');
		window.history.back();</script>";
	}
	else {
		echo "<script>alert('Data gagal dipadam');
		window.history.back();</script>";
	}
}

else {
	die("<script>alert('Akses fail tanpa kebenaran');
		window.history.back():</script>");
}
?>