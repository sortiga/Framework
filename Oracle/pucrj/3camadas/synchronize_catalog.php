<?php
   //include_once("config.php");
   //
try
{     
   	set_time_limit(0); 
	require_once("Controller.php");
	//Parâmetros que serão recebidos pelo json de solicitação:
	$json = file_get_contents('exemplo_json_solicitacao_sincronismo.txt');
	$jsond = json_decode($json,true);
    $idAgendamento = $jsond["request_number"];
	$totDatabases = $jsond["databases_total"];
	$tpRequest = $jsond["request_type"];
	
	//echo "<pre>";
	//print_r($jsond);
	//echo "</pre>";
	//exit;
   $objDatabase=new BALDatabaseMySQL(); 
/*   $objDatabase->SetId($jsond["database_id"]);  
   $result= $objDatabase->Get_Database($objDatabase); 
   while($row = mysql_fetch_row($result)){ 
        //$tpDB = $row[5];
      $objDatabase->SetIdTipoDatabase($row[5]);
      //$usDB = $row[6];   //$user
      $objDatabase->SetUsuario($row[6]);
      //$pwDB = $row[7];   //$senha
      $objDatabase->SetSenha($row[7]);
      //$nmDB = $row[8];   //$server
      $objDatabase->SetDatabase($row[8]);
      //$scDB = $row[9];
      $objDatabase->SetSchema($row[9]);
      $objDatabase->SetTipoQuery(1);
    }
*/
	$erro = 0;
    mysql_query('SET AUTOCOMMIT=0'); 
	mysql_query('START TRANSACTION');
	//echo $jsond["request_number"];echo "</br>";
    //echo $sol_sent;echo "</br>";	
	//exit;
	//echo "****** Início ";
	//echo "</br>";

    $max = sizeof($jsond['Databases']);
	//echo '</br>';echo "**********  max = $max ";echo '</br>';
    //exit;
    //echo "Max = $max";
    $ind = 0;        // controla o loop principal das tabelas informadas no json
	While ($ind <= ($max-1)){	      
          $idDb = $jsond['Databases'][$ind]['idCatalogo_Database'];
	      $idTipo = $jsond['Databases'][$ind]['Tipo_Database_idTipo_Database'];
          $descDb = $jsond['Databases'][$ind]['descricao'];
		  $database = $jsond['Databases'][$ind]['database'];
		  $schema = $jsond['Databases'][$ind]['schema'];		  
		  //echo '</br>';
		  //echo '**************************';echo '</br>';
		  //echo $idTipo;echo '</br>';
		  //echo $owner;echo '</br>';
		  //echo "processando $table";echo '</br>';
//          echo "<pre>";
//		  print_r($columns);
//		  echo "</pre>";
		  //echo '**************************';echo '</br>';
          $result = $objDatabase->UpdCatalogoInterno($idDb,$idTipo,$descDb,$database,$schema,$con);
		  //echo 'Resultado'.$ind.': '.$result;echo "</br>";
		  //exit;
		  If ($result < 0) {
		      $erro++;
          }		  
		  $ind++;
	}
	If ($erro > 0){
		mysql_query('ROLLBACK');
		//echo "$erro";echo "<br>";
		//echo "ROLLBACK 0!!!";
        mysql_query('SET AUTOCOMMIT=0'); 
		mysql_query('START TRANSACTION');  
		$status = 'F';
        $deMsg = "Error during Synchronize Process";
        $result = $objDatabase->InsErrMsg($idAgendamento,$deMsg,$con);
        Return -1;		
    }
	mysql_query('COMMIT');
	//echo "COMMIT 1!!!";
    mysql_query('SET AUTOCOMMIT=1'); 
    Return 0;
}
catch(Exception $e)
 {
   mysql_query('ROLLBACK');
   //echo "ROLLBACK 1!!!";
   mysql_query('SET AUTOCOMMIT=0'); 
   mysql_query('START TRANSACTION');  
   $deMsg ="ERROR! Details => " . $e->getMessage();
   $result = $objDatabase->InsErrMsg($idAgendamento,$deMsg,$con);
   mysql_query('COMMIT');
   //echo "COMMIT 2!!!";
   die("Error! Please see messages created to solicitation: ".$idAgendamento);
 }
?>