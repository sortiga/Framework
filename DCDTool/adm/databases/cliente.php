<?php
$n1 = $_GET['n1'];
$n2 = $_GET['n2'];
//echo $n1;echo "<br>";
//echo $n2;exit;
$conteudo='http://localhost:3000/pucrj/framework/webservices/soma.php?n1='.$n1.'&n2='.$n2;
echo "<br>";
echo $conteudo;
$resultado = file_get_contents($conteudo);
echo $resultado;
?>