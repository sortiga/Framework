<?php
define("DB",'mysql');
define("DB_NAME","objota");
define("DB_USER","root");
define("DB_HOST","localhost");
define("DB_PASS","zanfre");

function __autoload($className){
     if(file_exists($className.".class.php")){
          include($className.".class.php");
     }
}
?>
