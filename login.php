<?PHP 
//memulakan fungsi session_start
session_start();

//menyemak kewujudan data id, katalaluan, dan jenis 
if(empty($_POST['id']) or empty($_POST['katalaluan']) or empty($_POST['jenis']))
{
	//menghentikan aturcara jika jenis pengguna adalah pelajar
	die("<script>alert('Sila masukkan id dan katalaluan.'));
		window.location.href = 'index.php';");
}

//Set pemboleubah jika jenis pengguna adalah pelajar 
if($_POST['jenis'] == 'pelajar')
{
	$jadual = "pelajar";
	$medan1 = "id_pelajar";
	$medan2 = "katalaluan_pelajar";
	$medan3 = "nama_pelajar";
	$lokasi = "pelajar/pilih_latihan.php";
}

//Set pembolehubah jika jenis pengguna adalah guru 
{
	$jadual = "guru";
	$medan1 = "id_guru";
	$medan2 = "katalaluan_guru";
	$medan3 = "nama_guru";
	$lokasi = "guru/index.php";
}

//Memanggil fail connection.php
include('connection.php');

//mengambil dan menapis data POST 
$id = mysqli_real_escape_string($condb , $_POST['id']);
$katalaluan = mysqli_real_escape_string($condb , $_POST['katalaluan']);

//arahan SQL untuk membandingkan data 
$arahan_login = "select* from $jadual
where 
       $medan1 = '$id'
and    $medan2 = '$katalaluan'
limit 1";

//Melaksanakan arahan login 
$laksana_login = mysqli_query($condb , $arahan_login);

//jika terdapat 1 data ditemui sepadan 
if(mysqli_num_rows($laksana_login) == 1)
{
	//login berjaya, umpukan nilai pembolehubah session 
	$data = mysqli_fetch_array($laksana_login);
	$_SESSION[$medan3] = $data[$medan3];
	$_SESSION[$medan1] = $data[$medan1];
	echo "<script>window.location.href = '$lokasi';</script>";
}
else 
{
	//login gagal 
	echo "<script>alert('Login Gagal');
	window.history.back();</script>";
}

//menutup hubungan antara sistem dan pangkalan data 
mysqli_close($condb);
?>









