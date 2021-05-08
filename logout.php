<?PHP 
//memulakan fungsi session 
session_start();

//meghapuskan nilai pembolehubah session 
session_unset();

//menghentikan fungsi session
session_destroy();

//membuka fail index.php
echo "<script>window.location.href = 'index.php';</script>";
?>
