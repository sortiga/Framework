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
	//echo "<pre>";
	//print_r($jsond);
	//echo "</pre>";
	//exit;
	If ($jsond["request_type"] == 'GetCatalog'){
 
 	   $objDatabase=new BALDatabaseMySQL(); 
	   $objDatabase->SetId($jsond["database_id"]);  
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
 	   $saida["request_number"] = $jsond["request_number"];
       $saida["database_id"] = $jsond["database_id"];
	   $saida["tables"] = array();

       $max = sizeof($jsond['facts']);
       //echo "Max = $max";
       $ind = 0;        // controla o loop principal das fatos informadas no json
	   $ind_tables = 0; // controla o array de tabelas de saída
	   
	   While ($ind <= ($max-1)){
          // Vamos processar na seguinte ordem: 
		  //    Primeiro vamos processar as outriggers tables se existirem
		  //    Em seguida, processaremos as dimensões
		  //    Por fim processaremos as fatos
  	      $max2 = sizeof($jsond['facts'][$ind]['dimensions']);
		  //echo "Max 2 = $max2";
		  $ind2 = 0;
		  // Primeiro Loop obtém qtdd de outrigger tables para cada dimensão
		  // Em seguida ordenamos as dimensões de acordo com a qtt de outriggers para processar
          // os outriggers primeiro e, em seguida a dimensão		  
    	  While ($ind2 <= ($max2-1)){
		     // apenas recupera a quantidade de outriggers de cada dimensão
	         $owner_dim =  $jsond['facts'][$ind]['dimensions'][$ind2]['owner'];
		     $table_dim =  $jsond['facts'][$ind]['dimensions'][$ind2]['table'];
			 
			 echo $owner_dim;echo "<br>";  //AQUI
			 echo $table_dim;echo "<br>";  //AQUI
			 
			 // Efetua o Loop para encontrar o topo da hierarquia de outriggers se existir
			 $ind_origem = 0;
			 $origem[$ind_origem]['owner'] = $owner_dim;
			 $origem[$ind_origem]['table'] = $table_dim;
             $result_topo = $objDatabase->Get_Outriggers($objDatabase, $owner_dim, $table_dim);
			 $result = $result_topo;
             While ($result != null) {
			   extract($result);
			   $ind_origem++;
			   $origem[$ind_origem]['owner'] = $owner;
			   $origem[$ind_origem]['table'] = $table;
			   $result_topo = $result;
			   $result = $objDatabase->Get_Outriggers($objDatabase, $owner, $table);
             }			
			 While (($result_topo != null) OR ($ind_origem >= 0)) {
                // Tem Outrigger
				Echo "ind_origem = $ind_origem";echo "</br>";
				echo "<pre>";
	            print_r($origem[$ind_origem]);
	            echo "</pre>";
				
				extract($origem[$ind_origem]);
				//   echo "owner = $owner";echo "br";
				//   echo "table = $table";echo "br";
				// Obtem a estrutura da tabela
				$result = $objDatabase->Get_Estutura_Tabela($objDatabase, $owner, $table);
				// Inclui a estrutura da tabela no vetor de saída
         	    If ($result != null){
				       $saida["tables"][$ind_tables] = $result;
				       $ind_tables++;
                }else {
				       $msg = "Erro grave de processamento na recuperação da estrutura da tabela $owner - $table";
				       die($msg);
				}
 			    // Obtem a próxima filha da tabela outrigger
				$ind_origem--;
				if (ind_origem < 0){
				  $result_topo = null;
				}
             } 			 
		     $ind2++;
			 unset($origem);
		  }
	      $owner =  $jsond['facts'][$ind]['owner'];
		  $table =  $jsond['facts'][$ind]['table'];
		  // chama função que recupera a estrutura de colunas da fato
	      $result = $objDatabase->Get_Estutura_Tabela($objDatabase, $owner, $table);
          If ($result != null){
              $saida["tables"][$ind_tables] = $result;
              $ind_tables++;
          }else {
              $msg = "Erro grave de processamento na recuperação da estrutura da tabela $owner - $table";
              die($msg);
          }

		  //echo "Fato ".$ind+1;echo"<br>";
		  //echo "$owner";echo"<br>";
		  //echo "$table";echo"<br>";
		  //echo "------------------";echo"<br>";
		  $ind++;
	   }
	} //If request = GetCatalog
	echo "<pre>";
	print_r($saida);
	echo "</pre>";
	exit;

    Return $saida;
}
catch(Exception $e)
 {
   die("ERRO! Detalhes => " . $e->getMessage());
 }


	
?>