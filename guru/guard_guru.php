<?PHP 
//Menyemak kewujudan data pada pembolehubah session
if (empty($_SESSION['nama_guru']))
{
	//menghentikan sistem dan terus ke index.php
	die("<script>alert('Akses tidak dibenarkan,sila log in') window.location.href = '../index.php';</script>");
}
?>