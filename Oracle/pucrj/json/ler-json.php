<?php
// Primeiro lemos o conteúdo da página gera-json.php

/*$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';

var_dump(json_decode($json));
var_dump(json_decode($json, true));

$json = '{"request_number":1235, "database_id":1, "request_type":"GetCatalog", "facts":[{"owner":"BASE_PCC", "table":"SRO_FATO_FATURAMENTO5", "dimensions":[{"owner":"BASE_PCC","table":"SRO_DIM_TEMPO"}, {"owner":"BASE_PCC","table":"SRO_DIM_LOCALIZACAO"}, {"owner":"BASE_PCC","table":"SRO_DIM_PRODUTO"}, {"owner":"BASE_PCC","table":"SRO_DIM_CLIENTE"}, {"owner":"BASE_PCC","table":"SRO_DIM_LOJA"}]}]}';

var_dump(json_decode($json));
var_dump(json_decode($json, true));
*/

$json = file_get_contents('exemplo_json_Get_Catalog2.txt');

var_dump($json);
echo "file_get";echo "</br>";
// Depois convertemos o JSON para um array em PHP
// O segundo parâmetro com valor true, informa que
// o retorno de json_decode deve ser um array associativo.
$lista = json_decode($json, true);
echo "decode";echo "</br>";
 echo "<pre>";
 print_r($lista);
 echo "</pre>";
// Veja como fica o resultado

 
// Manipulando o resultado como PHP.
//foreach($lista as $objeto) {
//    print "Nome: {$objeto['nome']} - Idade: {$objeto['idade']}";
//}
?>