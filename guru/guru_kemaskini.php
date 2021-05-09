<?PHP 
//memangil fail header_guru.php 
include ('header_guru.php');

//menyemak kewujudan data GET untuk mengelak fail diakses tanpa data GET 
if(empty($_GET)){
	die("<script>alert('Akses tanpa kebenaran');
		window.location.href = 'murid_senarai.php';</script>");
}

if()