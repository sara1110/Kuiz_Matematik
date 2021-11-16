<?PHP 
# Memanggil header_guru.php
include('header_guru.php'); 

# ----- bahagian untuk menyimpan data set_soalan baru

# Menyemak kewujudan data POST
if(!empty($_POST))
{
    # Mengambil data POST
    $topik  =   mysqli_real_escape_string($condb,$_POST['topik']);
    $arahan =   mysqli_real_escape_string($condb,$_POST['arahan']);
    $jenis  =   $_POST['jenis'];
    $tarikh =   $_POST['tarikh'];

    # Menetapkan masa kuiz
    if($jenis=='Latihan')
    $masa   =   "Tiada";
    else
    $masa   =   mysqli_real_escape_string($condb,$_POST['masa']);
    
    # menyemak kewujudan data yang diambil
    if(empty($topik) or empty($arahan) or empty($jenis)or empty($tarikh)or empty($masa))
    {
        #jika terdapat pembolehubah yang tidak mempunyai nilai, aturcara akan dihentikan
        die("<script>alert('Sila lengkapkan maklumat');
        window.location.href='soalan_set.php';</script>");
    }

    # Arahan untuk mengemaskini data set_soalan baru
    $arahan_kemaskini=" update set_soalan set
    topik	=	'$topik',
    arahan	=	'$arahan',
    jenis	=	'$jenis',
    tarikh	=	'$tarikh',
    masa	=	'$masa'
    where
    no_set	=	'".$_GET['no_set']."' ";

    if(mysqli_query($condb,$arahan_kemaskini))
    {
        # data berjaya diKemaskini
        echo "<script>alert('Kemaskini BERJAYA.');
        window.location.href='soalan_set.php';</script>";
    }
    else
    {
        # data gagal dikemaskini
        echo "<script>alert('Kemaskini GAGAL.');
        window.location.href='soalan_set.php';
        </script>";
    }
}
?>

<!-- bahagian untuk memaparkan senarai set soalan -->
<h3>Senarai Set Soalan</h3>
<?PHP include ('../butang_saiz.php'); ?>
<table width='100%' border='1' id='besar'>
    <tr>
        <td>Topik</td>
        <td>Arahan</td>
        <td>Jenis</td>
        <td>Tarikh</td>
        <td>Masa</td>    
        <td></td>   
    </tr>
    <tr>
    <!-- bahagian borang untuk mendaftar set soalan yang baru -->
<form action='' method='POST'>
<td>
<textarea name='topik' rows="4" cols="25" ><?PHP echo $_GET['topik']; ?></textarea>
</td>
<td>
<textarea name='arahan' rows="4" cols="25"><?PHP echo $_GET['arahan']; ?></textarea>
</td>
<td>
<select name='jenis'>
<option value='<?PHP echo $_GET['jenis']; ?>'><?PHP echo $_GET['jenis']; ?></option>
<option value='Latihan'>Latihan</option>
<option value='Kuiz'>Kuiz</option>                
</select>
</td>
<td><input type='date' name='tarikh' value='<?PHP echo $_GET['tarikh']; ?>'></td>
<td><input type='text' name='masa' value='<?PHP echo $_GET['masa']; ?>'></td>
<td><input type='submit' value='Kemaskini'></td>
        </form> 
    </tr>
<?PHP
# arahan untuk memilih data dari jadual set soalan
$arahan_set     =   "select* from set_soalan order by no_set DESC";

# melaksanakan arahhan untuk memilih data
$laksana_set    =   mysqli_query($condb,$arahan_set);

# pembolehubah $data mengambil data yang ditemui
while ($data=mysqli_fetch_array($laksana_set))
{
    # mengumpukkan data yang ditemui ke dalam tatasusunan $data_get
    $data_get=array(
        'no_set'    =>  $data['no_set'],
        'topik'     =>  $data['topik'],
        'arahan'    =>  $data['arahan'],
        'jenis'     =>  $data['jenis'],
        'tarikh'    =>  $data['tarikh'],
        'masa'      =>  $data['masa'],
        'id_guru' =>  $data['id_guru']
    );
 # Memaparkan data yang diambil baris demi baris
 echo "<tr>
 <td>    ".$data['topik']."  </td>
 <td>    ".$data['arahan']." </td>
 <td>    ".$data['jenis']."  </td>
 <td>    ".$data['tarikh']." </td>
 <td>    ".$data['masa']."   </td>
 <td>

|<a href='soalan_daftar.php?no_set=".$data['no_set']."&topik=".$data['topik']."'>Soalan</a>
|<a href='soalan_set_kemaskini.php?".http_build_query($data_get)."'> Kemaskini </a>

|<a href='padam.php?jadual=set_soalan&medan=no_set&id=".$data['no_set']."' 
onClick=\"return confirm('Anda pasti anda ingin memadam data ini.')\" >Padam</a>|

 </td> 
</tr>";
}
?>
</table>
<?PHP include('footer_guru.php'); ?>




