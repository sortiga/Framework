<?php
// Informa o navegador que o conteúdo do arquivo é do tipo JSON
header('Content-Type: application/json');
 
// Se for usar esse código como exemplo,
// coloque ele num arquivo chamado gera-json.php
$lista = array(
    array('nome' => 'Eduardo Monteiro', 'idade' => 27),
    array('nome' => 'Suzana Medeiros', 'idade' => 20),
    array('nome' => 'Monica de Sousa', 'idade' => 25),
);
 
// Imprime o array php em forma de JSON
$var = json_encode($lista);
echo $var;

$filename = 'test.json';
//if (is_writable($filename)) { 
  if (!$handle = fopen($filename, 'a')) { 
     echo "Não foi possível abrir o arquivo ($filename)"; 
     exit; 
   } 


  if (fwrite($handle, $var) === FALSE) { 
     echo "Não foi possível escrever no aqruivo ($filename)"; 
     exit; 
   } 

  echo "Sucesso. Escreveu ($var) no arquivo ($filename)"; 
  fclose($handle); 
//} else { 
//echo "Impossível escrever em $filename"; 
//}	


?>