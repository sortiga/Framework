<?php
   //include_once("config.php");
try
{     
   	set_time_limit(0); 

    require_once("Controller.php");
    
	//Parâmetros que serão recebidos pelo json de solicitação:
	$json_request_number = 1234;
	$json_request_type = "SearchCatalog";
	$json_database_id = 1;
	
/*	$database = new DatabaseMySQL;
	$database->SetId($id);
	$database->Get_Database($oConexao);
*/

    $objDatabase=new BALDatabaseMySQL(); 
    $objDatabase->SetId($json_database_id);  
    $result= $objDatabase->Get_Database($objDatabase); 
    //print "<script>alert('View');</script>"; 
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
	   
	   If ($result2 = $objDatabase->Get_Tabelas_Candidatas($objDatabase)) {
	       //$resultt = $objDatabase->Print_Results($result2);
		   If ($result2 != null){
		       If ($result3 = $objDatabase->Sel_Tabelas_Candidatas($objDatabase, $result2)){
			       //die("**** ACABOU! ****");
        		   //echo "</br>";
        	       //echo "************    1    *****************";
        		   //echo "<pre>";
        		   //print_r($result3);
        		   //echo "</pre>";
        		   //echo "*******************************************";					 
        		   //echo "</br>";
      		       If ($result3 != null){
				       //$resultt = $objDatabase->Print_Results($result3);
					   $saida["request_number"] = $json_request_number;
					   $saida["database_id"] = $json_database_id;
					   $saida["request_type"] = "SearchCatalog";
					   $saida["facts_qtt"] = sizeof($result3);
    		    	   If ($result4 = $objDatabase->Get_Dimensoes($objDatabase, $result3)){
					       $saida["facts"] = $result4; 
						   echo "<pre>";
						   print_r($saida);
						   $var = json_encode($saida);
                           echo $var;
  			               //$resultt = $objDatabase->Print_Results($saida);
						   echo "</pre>";
					   }else {
		                   echo "Nenhum modelo identificado";
		               }
                    } else {
		               echo "Nenhum modelo identificado";
		            }
			   } else {
			       echo "Nenhum modelo identificado";
			   }
		   } else {
		       echo "Nenhum modelo identificado";
		   } 
		}		  
		else {
           echo '<h5>A consulta não retornou dados.</h5>';
        }


/*
	   If ($result2 = $objDatabase->Get_Tabelas_Candidatas($objDatabase)) {
	       //$resultt = $objDatabase->Print_Results($result2);
		   If ($result2 != null){
		       If ($result3 = $objDatabase->Get_Fatos_potenciais($objDatabase, $result2)){	
      		       If ($result3 != null){
				       Echo "Vou processar...";
					   Echo "</br>";
    		    	   If ($result4 = $objDatabase->Get_Dimes_Maior_Cardinalidade($objDatabase, $result3)){
					       $resultt = $objDatabase->Print_Results($result4);
                        } else {
		                    echo "Nenhum modelo identificado";
		                }
  		           } else {
		               echo "Nenhum modelo identificado";
		           }
			   }
		   } else {
		       echo "Nenhum modelo identificado";
		   }
		   
		}		  
		else {
           echo '<h5>A consulta não retornou dados.</h5>';
        }
*/
	}
}
catch(Exception $e)
 {
   die("ERRO! Detalhes => " . $e->getMessage());
 }


	
?>