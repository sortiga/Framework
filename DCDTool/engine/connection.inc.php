<?php 
$con = mysql_connect('lod2.inf.puc-rio.br','root','casanova'); 
 if (!$con){ 
    die('Could not connect to mysql ' . mysql_error()); 
 }else{ 
    mysql_select_db("pucrj",$con); 
 } 
 ?>