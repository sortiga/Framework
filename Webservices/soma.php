<?php
function soma($numero1,$numero2) {
  return $numero1+$numero2;
}
$soma = soma($_GET['n1'],$_GET['n2']);
return $soma
?>
