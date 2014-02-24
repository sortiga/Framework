<?php
define("DB",'mysql');
define("DB_NAME","pucrj");
define("DB_USER","root");
define("DB_HOST","localhost");
define("DB_PASS","zanfre");

function __autoload($className){
     echo "Classe: $className <br>\n";
     if(file_exists($className.".class.php")){
          include_once($className.".class.php");
     }
}
?>
