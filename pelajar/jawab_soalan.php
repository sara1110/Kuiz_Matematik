<?PHP
# memanggil fail header.php dan fail connection.php dari folder utama
include ('../header.php');
include('../connection.php');

# menyemak kewujudan data get 
if(empty($_GET))
{
	#jika data get tidak wujud. aturcara akan dihentikan
	die("<script>alert('Akses tanpa kebenaran?? KELUARRRRRRRRR!!!!!!!!');
	window.location.href='pilih_latihan.php';</script>");
}
?>

<?PHP

# Menguji data get[jenis]==kuiz
if($_GET['jenis']=="Kuiz")
{
	# memanggil fail timer2.php
	include('timer2.php');
	# memanggil fungsi timer_kuiz
	timer_kuiz($_GET['masa']);
}
?>

<!-- Memaparkan latihan untuk dijawap oleh pelajar-->
<h3>Soalan Latihan</h3>
<hr>
<form name='soalan_kuiz' action='jawab_semak.php?no_set=<?PHP echo $_GET['no_set']; ?>'
method='POST'>
<?PHP include ('../butang_saiz.php'); ?>
<table border='1' width='50%' id='besar'>
<tr>
	<td>Bil</td>
	<td>soalan</td>
</tr>

<?PHP
# Arahan untuk memilih soalan berdasarkan noset dan menyusun nya secara rawak (rand)
$arahan_pilih_soalan="select* from soalan where no_set='".$_GET['no_set']."'
order by rand()";

# melaksanakan arahan untuk memilih soalan
$laksana=mysqli_query($condb,$arahan_pilih_soalan);
$i=0;

# pembolehubah data mengambil data yang ditemui 
while ($data=mysqli_fetch_array($laksana))
{
	# memaparkan soalan dan jawapan
	echo"<tr>
	<td>".++$i."</td>
	<td>";
	
# mengumpukkan nama medan kepada tatasusunan
	$a=array("jawapan_a","jawapan_b","jawapan_c","jawapan_d");
	
	# menjadikan susunan jawapan secara rawak 
	shuffle($a);
	$xjawap='TIDAK MENJAWAB';
	
	# jika soalan mempunyai gambar, umpukan nama gambar
	if($data['gambar']!=" ")
	{
		$gambar=$data['gambar'];
	}
	else
	{
		$gambar=" ";
	}
	
		# memaparkan jawapan yang telah disusun secara rawak
		echo $soalan=str_replace("'"," ",$data['soalan']);
		
# susunan value yang dihantar. Taip dengan penuh berhati-hati.
# medan,jawapan, jawapan1, jawapan2, jawapan3, jawapan4, soalan, nilai jawapan_a, gambar
		echo"
		<br><img src='$gambar'><br>
		
<input type='radio' name='s".$data['no_soalan']."' value='".$a[0]."|".$data[$a[0]]."|".$data[$a[0]]."|".$data[$a[1]]."|".$data[$a[2]]."|".$data[$a[3]]."|".$soalan."|
".$data['jawapan_a']."|".$gambar."'> <label>".$data[$a[0]]."</label><br>

<input type='radio' name='s".$data['no_soalan']."' value='".$a[1]."|".$data[$a[1]]."|".$data[$a[0]]."|".$data[$a[1]]."|".$data[$a[2]]."|".$data[$a[3]]."|".$soalan."|
".$data['jawapan_a']."|".$gambar."'> <label>".$data[$a[1]]."</label><br>

<input type='radio' name='s".$data['no_soalan']."' value='".$a[2]."|".$data[$a[2]]."|".$data[$a[0]]."|".$data[$a[1]]."|".$data[$a[2]]."|".$data[$a[3]]."|".$soalan."|
".$data['jawapan_a']."|".$gambar."'> <label>".$data[$a[2]]."</label><br>

<input type='radio' name='s".$data['no_soalan']."' value='".$a[3]."|".$data[$a[3]]."|".$data[$a[0]]."|".$data[$a[1]]."|".$data[$a[2]]."|".$data[$a[3]]."|".$soalan."|
".$data['jawapan_a']."|".$gambar."'> <label>".$data[$a[3]]."</label><br>

<input type='radio' name='s".$data['no_soalan']."' value='tidak jawab|tidak jawab|
".$data[$a[0]]."|".$data[$a[1]]."|".$data[$a[2]]."|".$data[$a[3]]."|".$soalan."|
".$data['jawapan_a']."|".$gambar."'   checked style='visibility: hidden'>

<br>";


echo"</td>
</tr>";
}
?>

</table>
<input type='submit' value='Hantar'>

</form>
<?PHP include ('../footer.php'); ?>