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
	$bil_jawapan = mysqli_num_row ($laksana_skor);
	$bil_betul = 0;

	//pembolehubah rekod mengambil data yang ditemui semasa laksanakan arahan 
	while ($rekod = mysqli_fetch_aray ($laksana_skor)) {

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

<!-- Memanggil 