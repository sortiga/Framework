<?php
   //include_once("config.php");
   //
try
{     
   	set_time_limit(0); 
	require_once("Controller.php");
	//Parâmetros que serão recebidos pelo json de solicitação:
	$json = file_get_contents('exemplo_json_Get_Catalog.txt');
	$jsond = json_decode($json,true);
	$sol_sent = $jsond["request_number"];
	$json = file_get_contents('exemplo_json_gerado_Get_Catalog.txt');
    $jsond = json_decode($json,true);
	$sol_returned = $jsond["request_number"];
    $idAgendamento = 1;  //$jsond["request_number"];
    $database_id = $jsond["database_id"];
	//echo "<pre>";
	//print_r($jsond);
	//echo "</pre>";
	//exit;
   $status = 'A';
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
	
	If ($jsond["request_number"] == $sol_sent){
       $max = sizeof($jsond['tables']);
	   //echo '</br>';echo "**********  max = $max ";echo '</br>';
       //exit;
       //echo "Max = $max";
       $ind = 0;        // controla o loop principal das tabelas informadas no json
	   $ind_tables = 0; 
       $ultima_outrigger = null;
	   $ind_out = -1;
	   $ind_dim = 0;
	   While ($ind <= ($max-1)){	      
  	      $idTipo = $jsond['tables'][$ind]['type'];
          $owner = $jsond['tables'][$ind]['owner'];
		  $table = $jsond['tables'][$ind]['table'];
		  $columns = $jsond['tables'][$ind]['columns'];
		  //echo '</br>';
		  //echo '**************************';echo '</br>';
		  //echo $idTipo;echo '</br>';
		  //echo $owner;echo '</br>';
		  //echo $table;echo '</br>';
//          echo "<pre>";
//		  print_r($columns);
//		  echo "</pre>";
		  //echo '**************************';echo '</br>';
		  
		  If ($idTipo == 'Dimension'){
		     $idTipo = 1;
			 $vet_dim[$ind_dim] = $objDatabase->insert_table($owner,$table,$idTipo,$columns,$con);			 
			 If ($vet_dim[$ind_dim] == - 1){
			     $erro++;
			 } else {			 
			     If ($ultima_outrigger != null){
			        $ind_out++;
			  	    $vet_out[$ind_out]['MAE'] = $ultima_outrigger;
			  	    $vet_out[$ind_out]['FILHA'] = $vet_dim[$ind_dim];
			  	    $vet_out[$ind_out]['TIPO'] = $idTipo;
			        $ultima_outrigger = null;
			     }
			 }
			 $ind_dim++;
		  }
		  If ($idTipo == 'Fact'){
		     $idTipo = 2;
			 $id = $objDatabase->insert_table($owner,$table,$idTipo,$columns,$con);
			 If ($id == - 1){
			     $erro++;
			 } else {
			     //echo $id;echo "<br>";
                 //echo "<pre>";
                 //print_r($vet_dim);
                 //echo "</pre>";		
                 //mysql_query('ROLLBACK');
                 //exit;				 
                 $result = $objDatabase->insert_relations($id,$vet_dim,$con);			 
                 If ($result > 0){
			         $result = $objDatabase->insert_relations(null,$vet_out,$con);					 
                     If ($result > 0){
			             $status = 'A';
                     } else {
   	                     mysql_query('ROLLBACK');
						 //echo "ROLLBACK -2!!!";
              	         mysql_query('SET AUTOCOMMIT=0'); 
						 mysql_query('START TRANSACTION');
			             $status = 'F';
           	             $deMsg = "Error when it tried to create the relationships between Outriggers and dimensions for fact table - ".$owner." - ".$table;
	                     $result = $objDatabase->InsErrMsg($idAgendamento,$deMsg,$con);				 
                     }			 			 
                 } else {
	                 mysql_query('ROLLBACK');
					 //echo "ROLLBACK -3!!!";
              	     mysql_query('SET AUTOCOMMIT=0'); 
					 mysql_query('START TRANSACTION');
			         $status = 'F';
           	         $deMsg = "Error when it tried to create the relationships between fact and dimensions - ".$owner." - ".$table;
	                 $result = $objDatabase->InsErrMsg($idAgendamento,$deMsg,$con);				 
			     }
             }				 
		  }
		  If ($idTipo == 'Outrigger'){
		     $idTipo = 3;

			 $id = $objDatabase->insert_table($owner,$table,$idTipo,$columns,$con);			 
			 If ($id == - 1){
			     $erro++;
			 } else {			 
			     If ($ultima_outrigger == null){
			         $ultima_outrigger = $id;
			     } else {
			        $ind_out++;
			  	    $vet_out[$ind_out]['MAE'] = $ultima_outrigger;
			  	    $vet_out[$ind_out]['FILHA'] = $id;
			  	    $vet_out[$ind_out]['TIPO'] = $idTipo;
			     }
			 }
		  }
          //echo "================================================";echo '</br>';
		  //echo " Tipo processado = $idTipo ";echo '</br>';
          //echo " Indice = $ind ";echo '</br>';
          //echo "================================================";echo '</br>';
		  
		  $ind++;
	   }
	} //If request = GetCatalog
	else {
	//echo isset($con);
	  mysql_query('ROLLBACK');
	  //echo "ROLLBACK -1!!!";
	  mysql_query('SET AUTOCOMMIT=0'); 
	  mysql_query('START TRANSACTION');
	  $deMsg = "Error!  Sent Solicitation: ".$sol_sent." is different from returned Solicitation: ".$jsond["request_number"];
	  $result = $objDatabase->InsErrMsg($idAgendamento,$deMsg,$con);
	  $status = "F";
	}	
	If ($erro > 0){
		mysql_query('ROLLBACK');
		//echo "ROLLBACK 0!!!";
        mysql_query('SET AUTOCOMMIT=0'); 
		mysql_query('START TRANSACTION');  
		$status = 'F';
        $deMsg = "Error during Load Table Process";
        $result = $objDatabase->InsErrMsg($idAgendamento,$deMsg,$con);				 
    }
    $result = $objDatabase->UpdAgendamento($idAgendamento,$status,$con);
	mysql_query('COMMIT');
	//echo "COMMIT 1!!!";
    mysql_query('SET AUTOCOMMIT=1'); 
   Return true;
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