<?php
//memanggil fail header.php
include ('header.php');
?>
<!-- antara muka untuk daftar masuk / login -->

<table width = '100%'>
  <tr>
  	 <td align = 'centre' width = '50%'>
  	 	<h3> Selamat Datang, Sila Log Masuk </h3>
  	 	<form action = 'login.php' method = 'POST'>
  ID Pengguna	<input type = 'text'           name= 'id' placeholder="040503010203"><br>
  Katalaluan	 		<input type = 'password'       name= 'katalaluan'><br>
  	 		<input type = 'radio'      name ='jenis'   value = 'pelajar' checked>Murid 
  	 		<input type = 'radio'      name = 'jenis' value = 'guru'>Guru<br>
  	 		<input type = 'submit'     value = 'Login'>

  	 	</form>
  	 	<!-- pautan untuk mendaftar murid baru -->
  	 	<a href ='signup.php'>Daftar Murid Baharu</a>
  	 </td> 
  </tr>
</table>
<?PHP 
//memanggil fail footer.php 
include ('footer.php')
?>



  	 	



