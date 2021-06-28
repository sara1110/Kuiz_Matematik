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
<br>

<!--Memaparkan set soalan yang pernah dimasukkan oleh guru -->
Topik 
<select name = 'no_set'>
	<option value selected disabled></option>

<?PHP 
if ($_SESSION['tahap']== 'ADMIN') {

	//jika admin
	//arahan untuk memaparkan semua set soalan 
	$sql2 = "select * from set_soalan , GURU where set_soalan.id_guru = GURU.id_guru
	         and set_soalan.id_guru = '".$_SESSION['id_guru']."' ";
}

//melaksanakan arahan untuk mencari data 
$laksana_arahan_cari2 = mysqli_query ($condb , $sql2);

//pembolehubah $rekod mengambil data yang ditemui baris demi baris 
while ($rekod2 = mysqli_fetch_array ($laksana_arahan_cari2)) {

	//memaparkan data yang ditemui dalam element <option></option>
	echo "<option value = ".$rekod2['no_set'].">".$rekod2['topik']."</option>";
}
?>	
</select>
<br>
<input type = 'submit' value = 'Papar Keputusan'>
</form>

<?PHP 
// bahagian untuk memaparkan senarai nama murid, skor, dan jumlah markah 

//menyemak kewujudan data POST (tingkatan dan topik latihan) yang dihantar melalui borang di atas 
if (!empty ($_POST)) {

	//mengambil nilai POST 
	$id_kelas = $_POST['id_kelas'];
	$no_set = $_POST['no_set'];

	//bahagian untuk mendapatkan nama kelas berdasarkan id_kelas yang dihantar
	//arahan untuk mencari semua data kelas berdasarkan id_kelas yang dipilih 
	$arahan_kelas = "select * from KELAS where id_kelas = '$id_kelas'";

	//melaksanakan arahan carian di atas 
	$laksana_kelas = mysqli_query ($condb , $arahan_kelas); 

	//pembolehubah data1 mengambil data yang ditemui 
	$data1 = mysqli_fetch_array ($laksana_kelas); 

	//umpukkan gabingan data tingkatan dan nama kelas 
	$nama_kelas = $data1['tingkatan'].$data1['nama_kelas'];

	//bhgian untuk mendapatkan nama topik set latihan berdasarkan no_set yang dihantar 
	//arahan untuk mencari semua data set_soalan berdasarkan no_set yang dipilih 
	$arahan_topik = "select * from set_soalan where no_set = '$no_set'"; 

	//melaksanakan arahan untuk mencari di atas 
	$laksana_topik = mysqli_query ($condb , $arahan_topik); 

	//mengambil data set_soalan ditemui 
	$data2 = mysqli_fetch_array ($laksana_topik); 

	//umpukan data topik 
	$nama_topik = $data2['topik']; 

	//arahan sql untuk memilih pelajar berdasarkan id_kelas yang dihantar 
	$arahan_pilih = "SELECT * from PELAJAR, KELAS where PELAJAR.id_kelas = KELAS.id_kelas 
	                 and PELAJAR.id_kelas = '$id_kelas' ORDER BY PELAJAR.nama_pelajar ASC "; 

	//melaksanakan arahan untuk memilih pelajar 
	$laksana_pilih = mysqli_query ($condb , $arahan_pilih); 

	//jika bilangan rekod yang ditemui lebih besar atau sama dengan 1 
	if (mysqli_num_rows ($laksana_pilih) >= 1) {

		//papar maklumat carian nama kelas dan topik 
		echo "
		<br>Kelas : $nama_kelas
		<br>Topik : $nama_topik
		<br><button onclick = 'window.print()'>Cetak Keputusan</button> "; 
		include ('../butang_saiz.php');
		echo "<table width = '100%' border = '1' id = 'besar'>
		<tr> 
			<td>Nama Pelajar</td>
			<td>Id Pelajar</td>
			<td>Skor</td>
			<td>Markah</td>
		</tr>"; 
	}

	else {

		echo "tiada data yang ditemui bagi kelas tersebut";
	}

	//fungsi skor menerima data no_set soalan dan id murid 
	function skor ($no_set , $id_pelajar) {

		//memanggil fail connection.php dari folder luaran 
		include ('../connection.php'); 

		//arahan untuk mendapatkan data jawapan murid berdasarkan set soalan dan id murid
		$arahan_skor = "SELECT * FROM jawapan_pelajar , set_soalan , soalan WHERE 
		                set_soalan.no_set = soalan.no_set AND jawapan_pelajar.no_soalan = soalan.no_soalan
		                AND jawapan_pelajar.id_pelajar = '$id_pelajar' AND set_soalan.no_set = '$no_set' ";

		//melaksanakan arahan diatas 
		$laksana_skor = mysqli_query ($condb , $arahan_skor);

		//mengambil bilangan jawapan yang ditemui 
		$bil_jawapan = mysqli_num_rows ($laksana_skor);
		$bil_betul = 0; 

		//jika bilangan jawapan yang ditemui >= 1 
		if ($bil_jawapan >= 1) {

			while ($rekod = mysqli_fetch_array ($laksana_skor)) {

				//mengira bilangan jawapan yang betul 
				switch ($rekod['catatan']) {

					case 'BETUL' : $bil_betul++; break; 
					default : break;
				}
			}

			//mengira markah berdasarkan bilangan jawapan betul 
			$markah = $bil_betul / $bil_jawapan * 100;

			//memaparkan skor dan jumlah % markah 
			echo "<td>".$bil_betul." / ".$bil_jawapan."</td>
			      <td>".number_format($markah , 0)." % </td>";
		}
		else 
			echo "<td></td> <td>Belum Jawab</td>";
	}

	//mengambil data yang ditemui 
	while ($data = mysqli_fetch_array ($laksana_pilih)) {

		//memaparkan data yang ditemui baris demi baris 
		echo "<tr> 
			  <td>".$data['nama_pelajar']."</td>
			  <td>".$data['id_pelajar']."</td>";

		//memanggil fungsi skor di atas dengan menghantar data no_set soalan dan id murid 
		skor ($no_set , $data['id_pelajar']);
		echo "</tr>";
	}
}
?>
</table> 
<?PHP include ('footer_guru.php'); ?>