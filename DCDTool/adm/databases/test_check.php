<?php
	if($_GET){
$checked = $_GET['options'];
for($i=0; $i < count($checked); $i++){
    echo "Selected " . $checked[$i] . "<br/>";
}
}
?>
<form method="get">
    <input type="checkbox" name="options[]" value="Politics"/> Politics bdbdbdbd <br/>
    <input type="checkbox" name="options[]" value="Movies"/> Movies cbcbcbc<br/>
    <input type="checkbox" name="options[]" value="World "/> World  fsfsfs<br/>
    <input type="submit" value="Go!" />
</form>