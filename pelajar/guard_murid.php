<?PHP 
//menyemak kewujudan data pada pembolehubah session [nama_murid]
if (empty ($_SESSION['nama_pelajar'])) {

	//jika pembolehubah session tidak mempunyai nilai, papar pop up dan
	//buka fail index di laman utama 
	die ("<script>alert('Akses tanpa kebenaran!!!!! KELUAR!!!');
		window.location.href = '../index.php';</script>");
}
?> 