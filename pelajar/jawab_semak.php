<?PHP
include('../header.php');
include('../connection.php');

if(empty($_POST) and empty($_GET))
{
    die("<script>alert('Akses tanpa kebenaran');
    window.location.href='pilih_latihan.php';</script>");
}
$arahan_bil="select* from soalan where no_set='".$_GET['no_set']."'";
$laksana_bil=mysqli_query($condb,$arahan_bil);
$bil_soalan=mysqli_num_rows($laksana_bil);

$betul=0;
$salah=0;
$bil=0;

echo"<h3>Keputusan</h3>";
echo"
<table border='1' width='50%' id='besar'>
<tr>
    <td>Bil</td>
    <td>soalan</td>
</tr>";
$arahan_simpan="insert into jawapan_murid(no_soalan,jawapan,catatan,nokp_murid)
values";
foreach ($_POST as $key => $value)
{
    $no_soalan=ltrim($key,"s");
    $pecahkanbaris=explode("|",$value);
    list($medan,$jawapan,$jawapan1,$jawapan2,$jawapan3,$jawapan4,$soalan,$jawapana,$gambar) = $pecahkanbaris;

    if($gambar!=" ")
    {
        $gambar="<img src='".$gambar."'>";
    }

    if($jawapan!="tidak jawab")
    {
        $nilai_jawapan=$jawapan;
    }
    else
    {
        $nilai_jawapan='Tidak Jawab';
    }

    switch($medan)
    {
        case 'jawapan_a' : $betul++;break;
        case 'jawapan_b' : $salah++;break;
        case 'jawapan_c' : $salah++;break;
        case 'jawapan_d' : $salah++;break;
        default:$salah++; break;
    }

    if($jawapan==$jawapana)
    {
        $warna="";
        $catatan="BETUL";
    }
    else if($jawapan=='tidak jawab')
    {
        $warna="bgcolor='yellow'";
        $catatan="SALAH";
        $medan='tidak jawap';
    }
    else
    {
        $warna="bgcolor='pink'";
        $catatan="SALAH";
    }
    echo "<tr>
    <td>".++$bil."</td>
    <td $warna>".$soalan."<br>$gambar.
    <br>";
    for($k=1;$k<=4;$k++)
    {
        $jawapans="jawapan".$k;
        if($jawapan==$$jawapans)
            $tanda="checked='checked'";
        else
            $tanda="";
        echo"<input type='checkbox' name='$no_soalan' disabled='disabled' $tanda><label>".$$jawapans."</label><br>";
    }
    echo"</td>
        </tr>
        <tr>
           
            <td colspan='2' align='right'><b>Jawapan Pelajar :</b> $nilai_jawapan | <b>Jawapan Sebenar : </b>$jawapana</td>
        </tr>";
        $arahan_simpan=$arahan_simpan."('$no_soalan','$medan','$catatan','".$_SESSION['nokp_murid']."'),";
}
$arahan_simpan=rtrim($arahan_simpan,",");
if(mysqli_query($condb,$arahan_simpan))
{
    echo"<script>alert('Latihan tamat. data berjaya disimpan');</script>";
}
else
{
    echo"<script>alert('data gagal disimpan');
    window.history.back();
    </script>";
}
echo "<hr>Jumlah markah : $betul / $bil_soalan";
$peratus=($betul/$bil_soalan)*100;
echo "<br>Peratus : ".number_format($peratus,2)." %<br>";
include ('../butang_saiz.php');
?>