<?php
include_once("config.php");

   	set_time_limit(0); 

    $oConexao = Conexao::getInstance();
    
    $id = 1;	
/*	$database = new DatabaseMySQL;
	$database->SetId($id);
	$database->Get_Database($oConexao);
*/

    $objDatabase=new BALDatabaseMySQL(); 
    $objDatabase->SetId($id);  
    $result= $objDatabase->Get_Database($oConexao,$objDatabase); 
    print "<script>alert('View');</script>"; 
    while($row = mysql_fetch_row($result)){ 
       echo $row[0]."-"; 
       echo $row[1]."<br>"; 
    }
	
?>