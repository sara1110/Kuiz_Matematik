<?PHP 
//memanggil fail header guru 
include ('header_guru.php');
?>

<!-- borang untuk memuat naik fail data -->
<h2>Import Data Murid</h2>
<form action = " " method = "POST" action = 'upload.php' enctype = "multipart/form-data">
	Pilih Fail CSV untuk Diimport :<br>
	<input type = "file" name = "file" required/>
	<button type = "submit" name = "btn-upload">upload</button>
</form>

<!-- jadual penerangan data --> 
<table width = "40%">
	<tr>
		<td>Untuk proses mengimport data murid, pastikan anda menggunakan template yang telah disediakan. Muat turun <a href = "importdata.csv">di sini</a>
		</td>
	</tr>	
</table>

<?PHP 
//menyemak kewujudan data 
if (isset($_POST['btn-upload'])){
	$namafailsementara = $_FILES["file"]["tmp_name"];

	//mengambil nama fail
	$namafail = $_FILES['file']['name'];

	//mengambil jenis fail 
	$jenisfail = pathinfo($namafail , PATHINFO_EXTENSION);

	//menguji jenis fail dan saiz fail 
	print_r($_FILES);
	print_r($jenisfail);
	if ($_FILES["file"]["size"] > 0 AND $jenisfail == "csv"){

		//membuka fail yang diambil 
		$failyangdatainginupload = fopen($namafailsementara, "r");

		//umpuk nilai awal pembilang
		$counter = 1;
		$bil_berjaya = 0;
		$jum_data = 0;

		//mendapatkan data dari fail fail
		while (($data = fgetcsv($failyangdatainginupload , 10000 , ",")) !== FALSE){

			//mengambil data dari setiap cell pada fail csv
			$nama = mysqli_real_escape_string ($condb , $data[0]);
			$id = mysqli_real_escape_string ($condb , $data[1]);
			$katalaluan = mysqli_real_escape_string ($condb , $data[2]);
			$id_kelas = mysqli_real_escape_string ($condb , $data[3]);

			if ($counter > 1) {
				print_r($nama);
				//arahan untuk menyimpan data murid 
				$arahan_simpan = "INSERT into PELAJAR (nama_pelajar , id_pelajar , katalaluan_pelajar , id_kelas) values ('$nama' , '$id' , '$katalaluan' , '$id_kelas')";

				//melaksanakan arahan untuk menyimpan data 
				if (mysqli_query ($condb , $arahan_simpan)) {

					//mengira bilangan data yang berjaya disimpan 
					$bil_berjaya++;
				}
				else {

				 echo mysqli_error($condb);
				}
			}
			$jum_data++;
		    $counter++;
		}
       fclose ($failyangdatainginupload);
	}

	else {
		echo "<script>alert('Hanya fail csv sahaja dibenarkan');</script>";
	}

 	//memaparkan popup bilangan data yang berjaya dikemaskini 
 	if ($bil_berjaya > 0) {

		echo "<script>alert('Import fail data selesai. $bil_berjaya data berjaya disimpan');
		window.href.location = 'murid_senarai.php';</script>";
 	}
 	else {

		echo "<script>alert('Import fail GAGAL disimpan BOOOOOOO!!!');
		window.location.href = 'murid_upload.php';<";
 	}
}
?> 

<?PHP include ('footer_guru.php'); ?>