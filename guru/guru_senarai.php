<?PHP 
//memanggil fail header_guru.php 
include ('header_guru.php');

//menyemak kewujudan data POST untuk proses mendaftar guru baru 
if(!empty($_POST))
{
	//mengambil data dari form yang dimasukkan oleh admin 
	$nama = mysqli_real_escape_string($condb, $_POST['nama_baru']);
	$id = mysqli_real_escape_string($condb , $_POST['id_baru']);
	$katalaluan = mysqli_real_escape_string($condb , $_POST['katalaluan_baru']);
	$tahap = $_POST['tahap'];

	//menyemak kewujudan data yang diambil 
	if (empty($nama) or empty($id) or empty($katalaluan) or empty($tahap))
	{
		//jika data tidak wujud, aturcara akan terhenti sendiri
		die("<script>alert('Sila lengkapkan maklumat');
		window.history.back();</script>");
	}

	//had atas & bawah. data validation bagi id guru
	if(strlen($id)!= 12 or !is_numeric($id))
	{
		die("<script>alert(Ralat Id.);
		window.history.back();</script>");
	}

	//arahan untuk menyimpan data 
	$arahan_simpan = "insert into GURU (nama_guru , id_guru , katalaluan_guru , tahap)
	values ('$nama' , '$id' , '$katalaluan' , '$tahap')";

	//melaksanakan arahan untuk menyimpan data guru 
	if (mysqli_query($condb , $arahan_simpan)) 
	{
		//data berjaya disimpan 
		echo "<script>alert(Pendaftaran Berjaya YAYYYYYY!);
		window.location.href = 'gurusenarai.php';</script>";
	}
	else 
	{
		echo "<script>alert('Pendaftaran GAGAL BOOOOOO!!!!!');
		window.location.href = 'guru_senarai.php';</script>";
	}
}
?>

<!-- Bahagian untuk memaparkan senarai guru -->
<h3>Senarai Guru</h3>
<?PHP include ('../butang_saiz.php'); ?>
<table width= "100%" border = "1" id = "besar">
	<tr>
		<th>Nama</th>
		<th>Id</th>
		<th>Katalaluan</th>
		<th>Tahap</th>
		<th>Tindakan</th>
	</tr>
	<tr> 
		<!-- borang untuk mendaftarkan guru baru -->
		<form action = "" method = "POST">
			<td><input type = "text" name = "nama_baru"></td>
			<td><input type = "text" name = "id_baru"></td>
			<td><input type = "text" name = "katalaluan_baru"></td>
			<td>
				<select name = "tahap">
					<option value selected disabled>Pilih</option>
					<option value = "GURU">GURU</option>
					<option value = "ADMIN">ADMIN</option>
					
				</select>
			</td>
			<td><input type = "submit" value = "simpan"></td>
			
		</form>
	</tr>
<?PHP 

//arahan SQL untuk memilih data dari jadual guru 
$arahan_cari_guru = "select * from GURU order by tahap ASC";

//melaksanakan arahan SQL di atas 
$laksana_cari_guru = mysqli_query($condb , $arahan_cari_guru);

//mengambil semua data yang ditemui 
while ($data = mysqli_fetch_array($laksana_cari_guru))
{
	//umpuk data kedalam tatasusunan
	$data_guru = array(
		'nama_guru' => $data['nama_guru'],
		'id_guru' => $data['id_guru'],
		'katalaluan_guru' => $data['katalaluan_guru']
	);
    //memaparkan data dalam bentuk jadual baris demi baris 
    echo "<tr>
        <td>".$data['nama_guru']."</td>
        <td>".$data['id_guru']."</td>
        <td>".$data['katalaluan_guru']."</td>
        <td>".$data['tahap']."</td>
        <td>
            | <a href = 'guru_kemaskini.php?".http_build_query($data_guru)."'> Kemaskini </a> 
| <a href = 'padam.php?jadual=guru&medan=id_guru&id=".$data['id_guru']."' onClick =\"return confirm('Sebelum memadam data guru,pastikan beliau tidak mempunyai kelas terlebih dahulu')\"> Padam </a>|</td>
    </tr>";
}
?>	
</table>