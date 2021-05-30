<?php
//memanggil fail header.php
include ('header.php');
?>
<!-- antara muka untuk daftar masuk / login -->
<style>
body {
  background-color: lightcyan;
}
a {

  color:red
}
</style>
<table width = '100%'>
  <tr>
  	 <td align = 'centre' width = '50%'>
  	 	<h3> Selamat Datang, Sila Log Masuk </h3>
  	 	<form action = 'login.php' method = 'POST'>
  ID Pengguna	<input type = 'text'           name= 'id' placeholder="040503010203"><br>
  Katalaluan	 		<input type = 'password'       name= 'katalaluan'><br>
  	 		<input type = 'radio'      name ='jenis'   value = 'murid' checked>Murid 
  	 		<input type = 'radio'      name = 'jenis' value = 'guru'>Guru<br>
  	 		<input type = 'submit'     value = 'Login'>

  	 	</form>
  	 	<!-- pautan untuk mendaftar murid baru -->
  	 	<a href ='signup.php'>Daftar Murid Baharu</a>
  	 </td>
  	 <td>
  	 <?php 
  	 //memanggil fail connection.php 
  	 include('connection.php');

  	 //arahan sql untuk mencari data set soalan yang terkini 
  	 $arahan_latihan = "SELECT * FROM set_soalan , GURU , KELAS 
  	 WHERE 
  	       set_soalan.id_guru     =        GURU.id_guru
  	 AND   KELAS.id_guru     =        GURU.id_guru
  	 ORDER BY set_soalan.tarikh ASC ";

  	 //melaksanakan arahan SQL di atas 
  	 $laksana_latihan = mysqli_query($condb , $arahan_latihan);

  	 //mengambil dan memaparkan senarai set soalan, tingkatan yang terlibat dan guru
  	 while($rekod=mysqli_fetch_array($laksana_latihan))
  	 {
  	 	echo " <tr>
  	 	     <td> ".$rekod['topik']."</td>
  	 	     <td> ".$rekod['tingkatan']." ".$rekod['nama_kelas']." </td>
  	 	     <td> ".$rekod['nama_guru']."</td>
  	 	</tr> " ;
  	 }
  	 mysqli_close($condb);
  	 ?>
  	</table>
  </td>
</tr>
</table>
<? PHP 
//memanggil fail footer.php 
include ('footer.php')
?>



  	 	



