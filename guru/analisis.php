<?PHP 
//memanggil fail header_guru.php 
include ('header_guru.php');
?> 

<!-- sub tajuk laman --> 
<h3>Analisis Prestasi Murid</h3>

<!-- Borang untuk memilih kelas dan set soalan --> 
<form action = '' method = 'POST'>

<!-- Memaparkan senarai kelas yang diajar oleh guru yang sedang login -->
Kelas 
<select name = 'id_kelas'>
	<option value selected disabled>Pilih</option>
<?PHP 

if ($_SESSION['tahap']=='ADMIN') {

	//jika guru yang sedang login adalah admin 
	//arahan untuk mencari semua kelas 
	$sql = "select * from KELAS , GURU where KELAS.id_guru = GURU.id_guru";
}

else {

	//sebaliknya jika guru yang sedang login bukan admin 
	//arahan untuk mencari semua kelas yang diajar oleh guru tersebut sahaja 
	$sql = "select * from KELAS , GURU where KELAS.id_guru = GURU.id_guru and KELAS.id_guru = '".$_SESSION['id_guru']."' ";
}

//melaksanakan arahan untuk mencari data 
$laksana_arahan_cari = mysqli_query ($condb , $sql);

//pembolehubah $rekod mengambil data yang ditemui dalam element <option></option>
while ($rekod = mysqli_fetch_array ($laksana_arahan_cari)) {

	//memaparkan data yang ditemui dalam element <option></option>
	echo "<option value = ".$rekod['id_kelas']."> ".$rekod['tingkatan']." ".$rekod['nama_kelas']."</option> ";
}
?>	
</select>