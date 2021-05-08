<?php 
#fail connection.php

//nama host. localhost merupakan default 
$nama_host = "localhost";

//username bagi SQL. root merupakan default 
$user_sql = "root";

// password bagi SQL. masukkan password anda.
$pass_sql = "root";

//nama pangkalan data yang anda telah bangunkan sebelum ini.
$nama_db = "KUIZ_MATEMATIK";

//membuka hubungan antara pangkalan data dan sistem.
$condb = mysqli_connect($nama_host , $user_sql , $pass_sql , $nama_db);

//menguji adakah hubungan berjaya dibuka 
if (!$condb)
{
	die("Sambungan Gagal");
}
else 
{
	//echo "Sambungan Berjaya";
}
?>
