<?PHP 
//memanggil fail header.php
include ('header_guru.php');

//memaparkan nama guru dan tahap 
echo "Nama Guru : ".$_SESSION['nama_guru']." (".$_SESSION['tahap'].")";
?>
<br><hr>
<!-- Memaparkan senarai Latihan terkini -->
Senarai Latihan Terkini 
        <table border= "1">
        <tr>
        	<td>Topik</td>
        	<td>Kelas</td>
        	<td>Nama Guru</td>
        </tr>
        <?PHP 
        //arahan untuk mencari data guru, kelas, dan set_soalan
        $arahan_latihan = "SELECT * FROM set_soalan , GURU , KELAS 
        WHERE 
              set_soalan.id_guru = GURU.id_guru
        AND   kelas.id_guru = GURU.id_guru
        ORDER BY set_soalan.tarikh ASC ";

        //melaksanakan arahan carian di atas 
        $laksana_latihan = mysqli_query($condb , $arahan_latihan);

        //mengambil data dan memaparkan semula data tersebut 
        while ($rekod = mysqli_fetch_array($laksana_latihan))
        {
        	echo "
        	     <tr>
        	         <td> ".$rekod['topik']."</td>
        	         <td> ".$rekod['tingkatan']."</td>
        	         <td> ".$rekod['nama_guru']."</td>
        	     </tr>";
        }
        ?>
        </table>

        <?PHP include('footer_guru.php'); ?>