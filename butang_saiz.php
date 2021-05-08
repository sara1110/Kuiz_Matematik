<br>
<!-- fungsi mengubah saiz tulisan bagi kepelbagaian pengguna -->
<script>
function resizeText(multiplier){
	var elem = document.getElementById("besar");
	var currentSize = elem
	.style.fontSize || 1;
	if(multiplier == 2)
	{
		elem.style.fontSize = "1em";
	}
	else 
	{
		elem.style.fontSize = (parseFloat(currentSize) + (multiplier * 0.2)) + "em";
	}

}
</script>

<!-- Kod untuk butang mengubah saiz tulisan -->
| ubah saiz tulisan |
<input name = 'reSize1' type = 'button' value = 'reset' onclick = "resizeText(2)"/>
<input name = 'reSize' type = 'button' value = '&nbsp;+&nbsp;' onclick = "resizeText(1)"/>
<input name = 'reSize2' type = 'button' value = '&nbsp;-&nbsp;' onclick = "resizeText(-1)"/>
|