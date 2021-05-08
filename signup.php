<?PHP 
//memanggil fail header.php dan connection.php 
include('header.php');
include('connection.php');

//menguji kewujudan data POST yang dihantar oleh bahagian norang di bawah 
if(!empty($_POST))
{
	//mengambil dan menapis data POST 
	$nama = mysqli_real_escape_string($condb , $_POST['nama']);
	$id  = mysqli_real_escape_string($condb , $_POST['id']);
	$katalaluan = mysqli_real_escape_string($condb , $_POST['Katalaluan']);
	$id_kelas = $_POST['id_kelas'];

	//menyemak kewujudan data POST
	if(empty($nama) or empty($id) or empty($katalaluan) or empty($id_kelas))
	{
		die("<script>alert('Sila lengkapkan maklumat');
			window.history.back();</script>");
	}

	//had atas dan had bawah : sebagai data validation kepada id
	if(strlen($id)!= 12 or !is_numeric($id))
	{
		die("<script>alert('Ralat No. Id');
			window.history.back();</script>");
	}

	//arahan untuk menyimpan data pelajar yang dimasukkan 
	$arahan_simpan = "insert into PELAJAR
	(nama_pelajar , id_pelajar , katalaluan_pelajar , id_kelas) 
	values
	('$nama' , '$id' , '$katalaluan' , '$id_kelas')";

	//laksana arahan block if 
	if(mysqli_query($condb , $arahan_simpan))
	{
		//data berjaya disimpan papar popup
		echo "<script>alert('Pendaftaran BERJAYA YAY!');
		window.location.href = 'index.php';</script>";
	}
	else 
	{
		//data gagal disimpan papar popup 
		echo "<script>alert('Data GAGAL disimpan BOOOOOO!');
		window.history.back();</script>";
	}

}
?>

<!-- Bahagian borang untuk mendaftar murid baharu -->
<h3>Pendaftaran Pelajar Baru</h3>
<form action= '' method= 'POST'>
	Nama Pelajar  <input type='text' name='nama'><br>
	Id Pelajar    <input type='text' name = 'id' minlength="12"><br>
	Katalaluan    <input type = 'password' name = 'Katalaluan'><br>
	Kelas         <select name = 'id_kelas'>
		          <option value selected disabled>Pilih</option>


<?PHP
//arahan untuk mencari semua data dari jadual KELAS
$sql = "select* from KELAS";

//Melaksanakan arahan mencari data 
$laksana_arahan_cari = mysqli_query($condb , $sql);

//pemboleh ubah $rekod_bilik mengambil data data yang ditemui baris demi baris
while ($rekod_bilik = mysqli_fetch_array($laksana_arahan_cari))
{
	//memaparkan data yang ditemui dalam element <option></option>
	echo "<option value = ".$rekod_bilik['id_kelas']." > ".$rekod_bilik['tingkatan']." ".$rekod_bilik['nama_kelas']." </option> ";
}
?>

</select><br>
<input type= 'submit' name='Daftar'>
<br><a href= 'index.php'>Kembali ke Laman Log Masuk </a>
</form>

<?PHP 
mysqli_close($condb);
include ('footer.php');
?>