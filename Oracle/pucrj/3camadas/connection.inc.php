<?php 
 $con = mysql_connect("localhost","root","zanfre"); 
 if (!$con){ 
    die('Could not connect to mysql ' . mysql_error()); 
 }else{ 
    mysql_select_db("pucrj",$con); 
 } 
?>