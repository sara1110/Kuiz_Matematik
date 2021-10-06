<?PHP 
//memanggil fail header.php, guard_murid.php dan fail connection.php 
include ('../header.php');
include ('guard_murid.php');
include ('../connection.php');

//fungsi untuk mengira skor berdasarkan noset soalan 
function skor($no_set , $bil_soalan) {

	//memanggil fail connection.php dari folder utama 
	include ('../connection.php');

	//arahan untuk mendapatkan data jawapan murid 
	$arahan_skor = "SELECT * FROM set_soalan , soalan , jawapan_pelajar
					WHERE set_soalan.no_set = soalan.no_set 
				AND soalan.no_soalan = jawapan_pelajar.no_soalan
				AND set_soalan.no_set = '$no_set'
				AND jawapan_pelajar.id_pelajar = '".$_SESSION['id_pelajar']."' ";

	//melaksanakan arahan untuk mendapatkan data jawapan 
	$laksana_skor = mysqli_query ($condb, $arahan_skor);

	//mengira bilangan jawapan 
	$bil_jawapan = mysqli_num_rows($laksana_skor);
	$bil_betul = 0;

	//pembolehubah rekod mengambil data yang ditemui semasa laksanakan arahan 
	while ($rekod = mysqli_fetch_array ($laksana_skor)) {

		//mengira jawapan yang betul 
		switch ($rekod ['catatan']) {

			case 'BETUL': $bil_betul++; break;
			default : break;
		}
	}

	//mengira peratus jawapan betul 
	$peratus = $bil_betul/$bil_soalan* 100;

	//memaparkan sjor dan markah dalam %
	echo "<td align = 'right'>$bil_betul/$bil_soalan</td>
		  <td align = 'right'>".number_format($peratus , 0)."%</td>";
		  $kumpul = $bil_betul. "|".$bil_betul."|".$peratus."|".$bil_jawapan;

	//memulangkan nilai bil betul, bil soalan, peratus dan bilangan jawapan
		  return $kumpul;
}
?>

<!-- Memanggil fail butang saiz dari folder luaran untuk membesarkan saiz tulisan -->
<?PHP include ('../butang_saiz.php'); ?>

<!-- Bahagian memaparkan maklumat set soalan -->
<table border = '1' id = 'besar'>
<tr>
	<td>Bil</td>
	<td>Topik</td>
	<td>Jenis Latihan</td>
	<td>Bil Soalan</td>
	<td>Skor</td>
	<td>Peratus</td>
	<td>Jawab</td>
</tr>

<?PHP 
//arahan untuk mendapatkan maklumat murid berdasarkan data session [id_pelajar]
$arahan_cari = "select * from PELAJAR where id_pelajar = '".$_SESSION['id_pelajar']."' ";

//laksanakan arahan di atas
$laksana_cari = mysqli_query ($condb , $arahan_cari);

//mengambil data yang ditemui 
$data_pelajar = mysqli_fetch_array ($laksana_cari);

//arahan untuk mencari data set soalan 
$arahan_pilih_latihan = "SELECT set_soalan.no_set , COUNT(soalan.no_soalan) AS bil_soalan , topik , jenis 
FROM set_soalan , soalan , GURU , KELAS WHERE set_soalan.no_set = soalan.no_set
AND set_soalan.id_guru = GURU.id_guru
AND KELAS.id_guru = GURU.id_guru
AND KELAS.id_kelas = '".$data_pelajar['id_kelas']."'
GROUP BY set_soalan.no_set, topik";

//melaksanakan arahan untuk mencari data set soalan 
$laksana = mysqli_query($condb , $arahan_pilih_latihan);
$i = 0;

//pembolehubah data mengambil setiap data yang ditemui 
while ($data = mysqli_fetch_array ($laksana)) {

	//memaparkan data set soalan yang ditemui 
	echo "<tr>
		  <td>".++$i."</td>
		  <td>".$data['topik']."</td>
		  <td>".$data['jenis']."</td>
		  <td align 'centre'>".$data['bil_soalan']."</td> ";

	//memanggil fungsi skor dengan menghantar no set soalan dan bilangan soalan 
	$kumpul = skor ($data['no_set'] , $data['bil_soalan']);

	//menerima dan memecahkan data yang diterima kembali dari fungsi skor 
	$pecahkanbaris = explode ("|" , $kumpul);

	//umpukkan kepada pembolehubah dibawah 
	list ($bil_betul , $bil_soalan , $peratus , $bil_jawapan) = $pecahkanbaris;

	//menguji bilangan jawapan yang ditemui 
	if ($bil_jawapan <= 0) {

		//jika bil jawapan <= 0 bermaksud murid belum menjawab soalan 
		echo "<td><a href = 'arahan_latihan.php?no_set=".$data['no_set']."'>Pilih</a></td> ";
	}

	else {

		//jika tidak, murid hanya boleh mengulangkaji semua soalan yang telah dijawab 
		echo "<td><a href = 'ulangkaji.php?no_set=".$data ['no_set']."&topik=".$data['topik']."&kumpul".$kumpul."'>Ulangkaji</a></td> ";
	}
	echo "<tr>";
} 
?>  
</table>
<?PHP include ('../footer.php'); ?>