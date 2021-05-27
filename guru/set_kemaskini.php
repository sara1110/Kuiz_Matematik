<?PHP 
//memanggil header_guru.php 
include ('header_guru.php'); 

// ------ bahagian untuk menyimpan data set_soalan baru 

//menyemak kewujudan data POST 
$topik = mysqli_real_escape_string ($condb , $_POST['topik']);
$arahan = mysqli_real_escape_string ($condb , $_POST['arahan']);
$jenis = $_POST['jenis']; 
$tarikh = $_POST['tarikh'];

//menetapkan masa kuiz 
if ($jenis == 'Latihan')
$masa = "Tiada"; 
else 
$masa = mysqli_real_escape_string ($condb , $_POST['masa']); 

//menyemak kewujudan data yang diambil 
if (empty($topik) or empty($arahan) or empty($jenis) or empty($tarikh) or empty($masa)) {

	//jika terdapat pembolehubah yang tidak mempunyai nilai, aturcara akan dihentikan 
	die("<script>alert('Sila lengkapkan maklumat!!'); 
		window.location.href = 'soalan_set.php';</script>");
}

//arahan untuk mengemaskini data set_soalan Baharu 
$arahan_kemaskini = "update set"