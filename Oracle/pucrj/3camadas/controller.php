<?php
include_once('model.php');

class BALDatabaseMySQL extends AbstractDatabase 
{

    private function in_array_table(AbstractDatabase $objDatabase, $table, $owner, $array)
    {
         
        if (!empty($array) && is_array($array))
        {
            for ($i=0; $i < count($array); $i++)
            {
                if ($array[$i]["table"]==$table || strcmp($array[$i]["table"],$table)==0) {
    			   if ($array[$i]["owner"]==$owner || strcmp($array[$i]["owner"],$owner)==0) return true;
    			}
            }
        }
        return false;
    }

	public function Get_Database(AbstractDatabase $objDatabase) {
	    $objiDatabase = new DALDatabaseMySQL;
		return $objiDatabase->Get_Database($objDatabase);
	}

	public function Get_Queries(AbstractDatabase $objDatabase) {
	    $objiDatabase = new DALDatabaseMySQL;
		return $objiDatabase->Get_Queries($objDatabase);
	}
	
	public function Get_Tabelas_Candidatas(AbstractDatabase $objDatabase) {
	   // Obtem a sentença a ser executada 
	   $resqueries= $objDatabase->Get_Queries($objDatabase);
       // Obtem as tabelas que possuem Qtd Pk = Qtd Fk e que tem P 

       If ($query1 = mysql_fetch_row($resqueries)) {	   
       	   $sql = $query1[2];
       	   
       	   // Monta a string de conexão de acordo com o tipo do BD
       	   if ($objDatabase->GetIdTipoDatabase() == 1) {
       	     $conDB = "oci:dbname=".$objDatabase->GetDatabase();
       	   }
       	   
       	   if ($objDatabase->GetIdTipoDatabase() == 2) {
       	     $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
       	   }
       
                try
                {
              	   $pdo = new PDO($conDB,$objDatabase->GetUsuario(),$objDatabase->GetSenha());
                }
                catch(PDOException $e) 
                {
                  throw new Exception("Erro ao conectar ao servidor " . $e->getMessage());
                }
                if(!$stmt = $pdo->prepare($sql))
                {
                  $e= $pdo->errorInfo();
                  throw new Exception("Erro ao preparar consulta - " . $e[2]);
                }
                if(!$stmt->execute())
                {
                  $e= $stmt->errorInfo();
                  throw new Exception("Erro ao preparar consulta - " . $e[2]);
                }

                if($tab_tot_pk_fk = $stmt->fetchAll(PDO::FETCH_ASSOC))
                {
				   // Fechar conexão com PDO
                   $pdo = null;
                   Return $tab_tot_pk_fk;
                }
				// Fechar conexão com PDO
                $pdo = null;

       }
	}

	
	public function Sel_Tabelas_Candidatas(AbstractDatabase $objDatabase, $result) {
	   // Obtem a sentença a ser executada 
  	    $objDatabase->SetTipoQuery(2);
		If ($result != null) {
			$resqueries= $objDatabase->Get_Queries($objDatabase);
              
           If ($query1 = mysql_fetch_array($resqueries)) {	   
       	       Extract($query1);
			   $tot_fatos_pot = 0;
			   // Define string de conexão de acordo com o tipo do Database
               if ($objDatabase->GetIdTipoDatabase() == 1) {
               	   $conDB = "oci:dbname=".$objDatabase->GetDatabase();
               	}
                	   
               if ($objDatabase->GetIdTipoDatabase() == 2) {
               	   $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
               	}
				
			   foreach($result as $row) {
                  $sql = $de_sql;
			      $ind = 0;
			      foreach ($row as $item) 
			    	{
			    		$col[$ind] = $item;
			    		$ind++;
			    	}
			      $owner = " '".$col[0]."' ";
			      $table = " '".$col[1]."' ";
					// Echo "Owner = $owner";
					// Echo "</br>";
					// Echo "Table = $table";
					// Echo "</br>";
				  
  				  $restriction_type = " ('P','U') ";
                  $sql = str_replace("%condicao%", $restriction_type, $sql);
                  $sql = str_replace("%owner%", $owner, $sql);
				  $sql = str_replace("%table%", $table, $sql);
                  try
                    {
                     $pdo = new PDO($conDB,$objDatabase->GetUsuario(),$objDatabase->GetSenha());
                    }
                  catch(PDOException $e) 
                    {
                     throw new Exception("Erro ao conectar ao servidor " . $e->getMessage());
                    }
                  if(!$stmt = $pdo->prepare($sql))
                   {
                     $e= $pdo->errorInfo();
                      throw new Exception("Erro ao preparar consulta - " . $e[2]);
                   }
                  if(!$stmt->execute())
                   {
                    $e= $stmt->errorInfo();
                    throw new Exception("Erro ao executar consulta - " . $e[2]);
                   }
                  
			      if($result2 = $stmt->fetchAll(PDO::FETCH_ASSOC))
				   {
				     $retorno1 = $objDatabase->Valida_PK_FK($objDatabase, $result2);
					 $retorno2 = $objDatabase->Valida_Column_Type($objDatabase, $result2);
					 //Echo "Retorno1 = $retorno1";
					// Echo "</br>";
					 //Echo "Retorno2 = $retorno2";
					 //Echo "</br>";
                     if($retorno1 && $retorno2){
					    //echo "</br>";
					    //Echo "Entrei no IF";
					    $fato_potencial[$tot_fatos_pot]["owner"] = $owner; 
				    	$fato_potencial[$tot_fatos_pot]["table"] = $table;
				    	$tot_fatos_pot++;
					 } 
					 //echo "</br>";
					 //die("Encerrei Aqui ********************");
					 //echo "Total de Fatos Potenciais = $tot_fatos_pot";
					 //echo "</br>";
				   }	
				} // foreach($result as $row)
			   //echo "Tipo Database: $id_tipo_database </br>";
			   //echo "Tipo Query: $id_tipo_query</br>";
			   //echo "Sql: $de_sql</br>";
			}
        }		
		Return $fato_potencial;		
	}
	
	private function Valida_PK_FK(AbstractDatabase $objDatabase, $result) {
	   // Obtem a sentença a ser executada 

        //echo "</br>";
	    //echo "*******************************************";
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		//echo "*******************************************";					 
        //echo "</br>";				 
	    $objDatabase->SetTipoQuery(0);
		If ($result != null) {
			$resqueries= $objDatabase->Get_Queries($objDatabase);
           If ($query1 = mysql_fetch_array($resqueries)) {	   
       	       Extract($query1);
			   $eh_fato_pot = true;
			   // Define string de conexão de acordo com o tipo do Database
               if ($objDatabase->GetIdTipoDatabase() == 1) {
               	   $conDB = "oci:dbname=".$objDatabase->GetDatabase();
               	}
                	   
               if ($objDatabase->GetIdTipoDatabase() == 2) {
               	   $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
               	}
				
			   foreach($result as $row) {
                  $sql = $de_sql;
			      $ind = 0;
			      foreach ($row as $item) 
			    	{
			    		$col[$ind] = $item;
			    		$ind++;
			    	}
			      $owner = " '".$col[0]."' ";
			      $table = " '".$col[1]."' ";
                  $column =	" '".$col[2]."' ";
				  
				  //echo "</br>";
				  //echo "--------------PRIMEIRO---------------";
				  //echo "Owner = $owner";
				  //echo "</br>";
				  //echo "Table = $table";
				  //echo "</br>";
				  //echo "Column = $column";
				  //echo "</br>";
				  
                  $sql = str_replace("%column%", $column, $sql);
                  $sql = str_replace("%owner%", $owner, $sql);
				  $sql = str_replace("%table%", $table, $sql);
				  //echo "SQL = $sql";
				  //echo "</br>";
				  //echo "-----------------------------------------------";
				  //echo "</br>";
                  try
                    {
                     $pdo = new PDO($conDB,$objDatabase->GetUsuario(),$objDatabase->GetSenha());
                    }
                  catch(PDOException $e) 
                    {
                     throw new Exception("Erro ao conectar ao servidor " . $e->getMessage());
                    }
                  if(!$stmt = $pdo->prepare($sql))
                   {
                     $e= $pdo->errorInfo();
                      throw new Exception("Erro ao preparar consulta - " . $e[2]);
                   }
                  if(!$stmt->execute())
                   {
                    $e= $stmt->errorInfo();
                    throw new Exception("Erro ao executar consulta - " . $e[2]);
                   }
                  
			      if($result2 = $stmt->fetchAll(PDO::FETCH_ASSOC))
				   {
                     foreach($result2 as $row2) {
		               //echo "<pre>";
		               //print_r($result2);
		               //echo "</pre>";
  			           foreach ($row2 as $item2) { 
					      //echo "Item2 = $item2";
						  //echo "</br>";
			   		      If ($item2 == 0) 
							{
							  //echo "Falso ";
							  //echo "</br>";
				   		      Return false;
 				   		    }
			    	   }
					 }
				   }	
				} // foreach($result as $row)
			   //echo "Tipo Database: $id_tipo_database </br>";
			   //echo "Tipo Query: $id_tipo_query</br>";
			   //echo "Sql: $de_sql</br>";
			}
        }
	  //echo "eh_fato_pot = $eh_fato_pot";
	  //echo "</br>";
      return $eh_fato_pot;		
	}
	
	private function Valida_Column_Type(AbstractDatabase $objDatabase, $result) {
	   // Obtem a sentença a ser executada 

        //echo "</br>";
	    //echo "*******************************************";
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		//echo "*******************************************";					 
        //echo "</br>";				 
	    $objDatabase->SetTipoQuery(3);
		If ($result != null) {
			$resqueries= $objDatabase->Get_Queries($objDatabase);
           If ($query1 = mysql_fetch_array($resqueries)) {	   
       	       Extract($query1);
			   $eh_fato_pot = true;
			   // Define string de conexão de acordo com o tipo do Database
               if ($objDatabase->GetIdTipoDatabase() == 1) {
               	   $conDB = "oci:dbname=".$objDatabase->GetDatabase();
               	}
                	   
               if ($objDatabase->GetIdTipoDatabase() == 2) {
               	   $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
               	}
				
			   foreach($result as $row) {
                  $sql = $de_sql;
			      $ind = 0;
			      foreach ($row as $item) 
			    	{
			    		$col[$ind] = $item;
			    		$ind++;
			    	}
			      $owner = " '".$col[0]."' ";
			      $table = " '".$col[1]."' ";
                  $column =	" '".$col[2]."' ";
				  
				  //echo "</br>";
				  //echo "--------------SEGUNDO--------------";
				  //echo "Owner = $owner";
				  //echo "</br>";
				  //echo "Table = $table";
				  //echo "</br>";
				  //echo "Column = $column";
				  //echo "</br>";
				  
                  $sql = str_replace("%column%", $column, $sql);
                  $sql = str_replace("%owner%", $owner, $sql);
				  $sql = str_replace("%table%", $table, $sql);
				  //echo "SQL = $sql";
				  //echo "</br>";
				  //echo "-----------------------------------------------";
				  //echo "</br>";
                  try
                    {
                     $pdo = new PDO($conDB,$objDatabase->GetUsuario(),$objDatabase->GetSenha());
                    }
                  catch(PDOException $e) 
                    {
                     throw new Exception("Erro ao conectar ao servidor " . $e->getMessage());
                    }
                  if(!$stmt = $pdo->prepare($sql))
                   {
                     $e= $pdo->errorInfo();
                      throw new Exception("Erro ao preparar consulta - " . $e[2]);
                   }
                  if(!$stmt->execute())
                   {
                    $e= $stmt->errorInfo();
                    throw new Exception("Erro ao executar consulta - " . $e[2]);
                   }
                  
			      if($result2 = $stmt->fetchAll(PDO::FETCH_ASSOC))
				   {
                     foreach($result2 as $row2) {
		               //echo "<pre>";
		               //print_r($result2);
		               //echo "</pre>";
  			           foreach ($row2 as $item2) { 
					      //echo "Item2 = $item2";
						  //echo "</br>";
			   		      If ($item2 == 0) 
							{
							  //echo "Falso ";
							  //echo "</br>";
				   		      return false;
 				   		    }
			    	   }
					 }
				   }	
				} // foreach($result as $row)
			   //echo "Tipo Database: $id_tipo_database </br>";
			   //echo "Tipo Query: $id_tipo_query</br>";
			   //echo "Sql: $de_sql</br>";
			}
        }
	  //echo "eh_fato_pot2 = $eh_fato_pot";
	  //echo "</br>";
      return $eh_fato_pot;		
	}
	
	
	//Proc_Tabelas_Candidatas
	
/*	private function Existe_Col_FK(AbstractDatabase $objDatabase, $result) {
	
	}
*/	
	
	public function Get_Dimensoes(AbstractDatabase $objDatabase, $result) {

        //Echo "Entrei...";
	    //Echo "</br>";

		//echo "</br>";
	    //echo "*******************************************";
		//echo "<pre>";
		//print_r($result);
		//echo "</pre>";
		//echo "*******************************************";					 
        //echo "</br>";				 
		//die('Parei por Aqui');
	    $objDatabase->SetTipoQuery(6);
		If ($result != null) {
			$resqueries= $objDatabase->Get_Queries($objDatabase);
           If ($query1 = mysql_fetch_array($resqueries)) {	   
       	       Extract($query1);
			   $eh_fato_pot = true;
			   // Define string de conexão de acordo com o tipo do Database
               if ($objDatabase->GetIdTipoDatabase() == 1) {
               	   $conDB = "oci:dbname=".$objDatabase->GetDatabase();
               	}
                	   
               if ($objDatabase->GetIdTipoDatabase() == 2) {
               	   $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
               	}
			   $maior = 0;
			   $cont_facts = -1;
			   foreach($result as $row) {
                  $sql = $de_sql;
			      $ind = 0;
			      foreach ($row as $item) 
			    	{
			    		$col[$ind] = $item;
						//echo "item = $item";
						//echo "</br>";
						//echo "ind = $ind";
						//echo "</br>";
			    		$ind++;
			    	}
			      $owner = $col[0];
			      $table = $col[1];
				  $cont_facts++;
				  $facts_vetor[$cont_facts]["owner"] = $owner;
				  $facts_vetor[$cont_facts]["table"] = $table;
				  
				  //echo "</br>";
				  //echo "--------------SEGUNDO--------------";
				  //echo "Owner = $owner";
				  //echo "</br>";
				  //echo "Table = $table";
				  //echo "</br>";
				  //echo "Column = $column";
				  //echo "</br>";
				  
                  $sql = str_replace("%owner%", $owner, $sql);
				  $sql = str_replace("%table%", $table, $sql);
				  
				  //echo "SQL = $sql";
				  //echo "</br>";
				  //echo "-----------------------------------------------";
				  //echo "</br>";
				  //die('Acabou ******************************');
                  try
                    {
                     $pdo = new PDO($conDB,$objDatabase->GetUsuario(),$objDatabase->GetSenha());
                    }
                  catch(PDOException $e) 
                    {
                     throw new Exception("Erro ao conectar ao servidor " . $e->getMessage());
                    }
                  if(!$stmt = $pdo->prepare($sql))
                   {
                     $e= $pdo->errorInfo();
                      throw new Exception("Erro ao preparar consulta - " . $e[2]);
                   }
                  if(!$stmt->execute())
                   {
                    $e= $stmt->errorInfo();
                    throw new Exception("Erro ao executar consulta - " . $e[2]);
                   }
                  
			      if($result2 = $stmt->fetchAll(PDO::FETCH_ASSOC))
				   {
 				   $tot_dim = 0;
				   foreach($result2 as $row2) {
					   $ind = 0;
  			           foreach ($row2 as $item2) { 
						  $col[$ind] = $item2;
						  $ind++;
			    	   }
        			   $dime_vector[$tot_dim]["owner"] = $col[0]; 
				       $dime_vector[$tot_dim]["table"] = $col[1];
  				       $tot_dim++;
				   }
                  $facts_vetor[$cont_facts]["dimensions"] = $dime_vector;				   
				  } // foreach($result as $row)
			   //echo "Tipo Database: $id_tipo_database </br>";
			   //echo "Tipo Query: $id_tipo_query</br>";
			   //echo "Sql: $de_sql</br>";
			  }
			}
        }
	  //echo "mensagem";
	  //echo "</br>";
	  //echo "<pre>";
	  //print_r($facts_vetor);
	  //echo "</pre>";
      return $facts_vetor;		

	  } //Get_Dimes_Maior_Cardinalidade
	

	public function Get_Outriggers(AbstractDatabase $objDatabase, $owner, $table) {
	   // Obtem a sentença a ser executada 
	   $objDatabase->SetTipoQuery(7);
	   $resqueries= $objDatabase->Get_Queries($objDatabase);
       // Obtem as tabelas que possuem Qtd Pk = Qtd Fk e que tem P 
       $out_vector[0] = null;
       If ($query1 = mysql_fetch_row($resqueries)) {	   
       	   $sql = $query1[2];
		   //echo '</br>';echo '**********  Outriggers ';echo '</br>';
   		   $owner = str_replace("'", "", $owner);
		   $table = str_replace("'", "", $table);
		   $owner = "'".$owner."'";
		   $table = "'".$table."'";
       	   $sql = str_replace("%owner%", $owner, $sql);
		   $sql = str_replace("%table%", $table, $sql);
		   
		   //echo $sql;
		   
       	   // Monta a string de conexão de acordo com o tipo do BD
       	   if ($objDatabase->GetIdTipoDatabase() == 1) {
       	     $conDB = "oci:dbname=".$objDatabase->GetDatabase();
       	   }
       	   
       	   if ($objDatabase->GetIdTipoDatabase() == 2) {
       	     $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
       	   }
       
           try
           {
             $pdo = new PDO($conDB,$objDatabase->GetUsuario(),$objDatabase->GetSenha());
           }
           catch(PDOException $e) 
           {
             throw new Exception("Erro ao conectar ao servidor " . $e->getMessage());
           }
           if(!$stmt = $pdo->prepare($sql))
           {
             $e= $pdo->errorInfo();
             throw new Exception("Erro ao preparar consulta - " . $e[2]);
           }
           if(!$stmt->execute())
           {
             $e= $stmt->errorInfo();
             throw new Exception("Erro ao preparar consulta - " . $e[2]);
           }

		   if($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
			{
 				  $tot_out = 0;
				  foreach($result as $row) {
					$ind = 0;
  			        foreach ($row as $item) { 
					  $col[$ind] = $item;
					  $ind++;
			    	}
        			$out_vector[$tot_out]["owner"] = $col[0]; 
				    $out_vector[$tot_out]["table"] = $col[1];
  				    $tot_out++;
				   }                  
			} 

       }
	   Return $out_vector[0];
	}

	public function Get_Estutura_Tabela(AbstractDatabase $objDatabase, $owner, $table) {
	   // Obtem a sentença a ser executada 
	   $objDatabase->SetTipoQuery(8);
	   $resqueries= $objDatabase->Get_Queries($objDatabase);
       // Obtem as tabelas que possuem Qtd Pk = Qtd Fk e que tem P 
       $out_vector = null;
	   //echo '</br>';echo '**********  Get Estrutura Tabela ';echo '</br>';
       If ($query1 = mysql_fetch_row($resqueries)) {	   
       	   $sql = $query1[2];
		   $owner = str_replace("'", "", $owner);
		   $table = str_replace("'", "", $table);
 		   $out_vector["owner"] = $owner; 
		   $out_vector["table"] = $table;
		   $owner = "'".$owner."'";
		   $table = "'".$table."'";
       	   $sql = str_replace("%owner%", $owner, $sql);
		   $sql = str_replace("%table%", $table, $sql);
		   //echo "</br>";
		   //echo "-----------  SQL que recupera a estrutura da tabela --------------";echo "</br>";
		   //echo $sql;echo "</br>";
		   //echo "-----------  SQL que recupera a estrutura da tabela --------------";
		   //echo "</br>";
		   //exit;
		   
       	   // Monta a string de conexão de acordo com o tipo do BD
       	   if ($objDatabase->GetIdTipoDatabase() == 1) {
       	     $conDB = "oci:dbname=".$objDatabase->GetDatabase();
       	   }
       	   
       	   if ($objDatabase->GetIdTipoDatabase() == 2) {
       	     $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
       	   }
       
           try
           {
             $pdo = new PDO($conDB,$objDatabase->GetUsuario(),$objDatabase->GetSenha());
           }
           catch(PDOException $e) 
           {
             throw new Exception("Erro ao conectar ao servidor " . $e->getMessage());
           }
           if(!$stmt = $pdo->prepare($sql))
           {
             $e= $pdo->errorInfo();
             throw new Exception("Erro ao preparar consulta - " . $e[2]);
           }
           if(!$stmt->execute())
           {
             $e= $stmt->errorInfo();
             throw new Exception("Erro ao preparar consulta - " . $e[2]);
           }

		   if($result = $stmt->fetchAll(PDO::FETCH_ASSOC))
			{
  			   $out_vector["columns"] = $result;
			} 

       }
		//echo "</br>";echo "Vou printar o array result";
		//echo "<pre>";
	    //print_r($out_vector);
	    //echo "</pre>";
        //exit;
	   Return $out_vector;
	}



	public function Print_Results($result) {

   	   echo '<h5>Exibindo dados retornados pela extensÃ£o PDO"</h5>';
       echo "<table border='1'>\n";
       foreach($result as $row ) 
       {
          echo "<tr>\n";
          foreach ($row as $item) 
          {
             echo "    <td>".($item!==null?htmlentities($item, ENT_QUOTES):" ")."</td>\r\n";
          }
          echo "</tr>\n";
        }
        echo "</table>\n";
    }

	public function insert_table($owner,$table,$idTipo,$columns,$con,$idDatabase) {
	
	      //Checar se a tabela existe.  Se existir pegar o id, caso contrÃ¡rio, insere
    	  $sql = "Select idTabelas from Tabelas where nome = '".$table."' and owner = '".$owner."' ";
          //echo $sql;
		  $query = mysql_query($sql,$con);
		  If (mysql_error($con)!= null){
			  //echo "1"; echo"<br>".mysql_error($con); 
			  Return -1;
		  }
		  If (mysql_num_rows($query)>0){
			  $query_result = mysql_fetch_assoc($query);
		      extract($query_result);
			  $id = $idTabelas;
		  }else{
    	      $sql = "Insert Into Tabelas(nome, owner, idTipo_Tabela, idCatalogo_Database) values ('".$table."','".$owner."',$idTipo,$idDatabase)";		   
			  $query = mysql_query($sql,$con);
		      If (mysql_error($con)!= null){
			      //echo "2"; echo"<br>".mysql_error($con);
				  Return -1;
		      }
		      $id = mysql_insert_id();
			  If ($idTipo == 2){
    	          $sql = "Insert Into Modelos (nome, Catalogo_Database_idCatalogo_Database, idFactTable) values ('".$table."',$idDatabase,$id)";		   
			      $query = mysql_query($sql,$con);
		          If (mysql_error($con)!= null){
			          //echo "2-2"; echo"<br>".mysql_error($con);
				      Return -1;
				  }
		      }
          }
		  $ind = 0;
          $max = sizeof($columns);
		  While ($ind <= ($max-1)){
		     $col = $ind + 1;
			 $aceita_nulls = 0;
			 If ($columns[$ind]['NULLABLE'] == 'S'){
			     $aceita_nulls = 1;
			 }
			 $pk = 0;
			 If ($columns[$ind]['EH_PK'] == 'S'){
			     $pk = 1;
			 }
			 $fk = 1;
			 If ($columns[$ind]['FK_TABLE_NAME'] == 'N/A'){
			     $fk = 0;
			 }			 
			 // Verificar se a coluna jÃ¡ existe, casa exista, fazer update, caso contrÃ¡rio fazer insert
    	     $sql = "Select idColuna from coluna where nome = '".$columns[$ind]['COLUMN_NAME']."' and Tabelas_idTabelas = $id ";		   
             //echo $ind;echo "</br>";
			 $query = mysql_query($sql,$con);
		     If (mysql_error($con)!= null){
			     //echo "3"; echo"<br>".mysql_error($con);
				 Return -1;
		     }
		     If (mysql_num_rows($query)>0){
				$query_result = mysql_fetch_assoc($query);
		         extract($query_result);
			     $col = $idColuna;
				 $sql = "Update coluna ";
				 $sql = $sql." Set tamanho_coluna = ".$columns[$ind]['DATA_LENGTH'].",";
				 $sql = $sql." aceita_valor_nulo = $aceita_nulls,";
				 $sql = $sql." faz_parte_pk = $pk,";
				 $sql = $sql." chave_estrangeira = $fk,";
				 $sql = $sql." Tipo_Dados = '".$columns[$ind]['DATA_TYPE']."' ";
				 $sql = $sql." Where Tabelas_idTabelas = $id and idColuna = $col ";
		     }else{			 
    	         $sql = "Insert Into coluna ";
			     $sql = $sql."(Tabelas_idTabelas, idColuna, nome, tamanho_coluna,";
			     $sql = $sql."aceita_valor_nulo, faz_parte_pk, chave_estrangeira, Tipo_Dados) ";
			     $sql = $sql."values ($id,$col,'".$columns[$ind]['COLUMN_NAME']."',".$columns[$ind]['DATA_LENGTH'].",";
                 $sql = $sql."$aceita_nulls,$pk,$fk,'".$columns[$ind]['DATA_TYPE']."')";					 
			 }
	         $query = mysql_query($sql,$con);
		     If (mysql_error($con)!= null){
		         //echo "4"; echo"<br>".mysql_error($con);
				 Return -1;
		     }
			 // Efetua o tratamento da chave estrangeira
			 If ($fk == 1){
			     // Recupera os ids da tabela e da coluna
                 $table_fk = $columns[$ind]['FK_TABLE_NAME'];
                 $owner_fk = $columns[$ind]['FK_OWNER'];		
                 $column_fk = $columns[$ind]['FK_COLUMN_NAME'];
				 $tipo_equivalencia = 'FK';
    	         $sql = "Select idTabelas from tabelas where nome = '".$table_fk."' and owner = '".$owner_fk."' ";		   
		         $query = mysql_query($sql,$con);
		         If (mysql_error($con)!=null){
			         //echo "5"; echo"<br>".mysql_error($con);
					 Return -1;
		         }
		         If (mysql_num_rows($query)>0){
                     $query_result = mysql_fetch_assoc($query);
					 extract($query_result);
   				     $id_fk = $idTabelas; 
    	             $sql = "Select idColuna from coluna where nome = '".$column_fk."' and Tabelas_idTabelas = $id_fk ";		   
		             $query = mysql_query($sql,$con);
		             If (mysql_error($con)!= null){
			             //echo "6"; echo"<br>".mysql_error($con);
						 Return -1;
		             }
		             If (mysql_num_rows($query)>0){
                         $query_result = mysql_fetch_assoc($query);
						 extract($query_result);
   	    			     $id_col_fk = $idColuna; 
                         $sql = "Select count(0) as total from equivalencias ";
                         $sql = $sql." where idTabelas_equivalencia_1 = ".$id_fk." and idColuna_equivalencia_1 = ".$id_col_fk." ";
                         $sql = $sql."   and idTabelas_equivalencia_2 = ".$id." and idColuna_equivalencia_2 = ".$col." ";
                         $query = mysql_query($sql,$con);
                         If ( mysql_error($con)!= null){
                            //echo "7"; echo"<br>".mysql_error($con);
							Return -1;
                         }
                         $query_result = mysql_fetch_assoc($query);
                         extract($query_result);
                         If ($total == 0){ 
                       		 $sql = "Insert into equivalencias (idTabelas_equivalencia_1, idColuna_equivalencia_1, ";
                       		 $sql = $sql."idTabelas_equivalencia_2, idColuna_equivalencia_2, tipo_equivalencia) ";
                       		 $sql = $sql." values ($id_fk, $id_col_fk, $id, $col, '".$tipo_equivalencia."') ";
                       		 $query = mysql_query($sql,$con);					 
                         }
					 }
				 } else {
					 //echo "8"; echo"<br>".mysql_error($con);		
			         Return -1;				 
			     }
			 }
			 $ind++;
		  }
		  Return $id;  
    }

	public function insert_relations($id,$vet,$con) {
	      $ind = 0;
          $max = sizeof($vet);
		  //echo "antes insert relation $id";
		  While ($ind <= ($max-1)){
             If ($id == null){
			     $tipo_mae = 3;
				 $tipo_filha = $vet[$ind]['TIPO'];
				 $id_mae = $vet[$ind]['MAE'];
				 $id_filha = $vet[$ind]['FILHA'];				 
			  } else {
			     $tipo_mae = 1;
				 $tipo_filha = 2;
				 $id_mae = $vet[$ind];
				 $id_filha = $id;
		      }
			  $sql = "Select count(0) as total from Tabelas_Relacoes ";
			  $sql = $sql." where idTabelas_Mae = ".$id_mae." and idTipoTabMae = ".$tipo_mae." ";
			  $sql = $sql."   and idTabelas_filha = ".$id_filha." and idTipoTabFilha = ".$tipo_filha." ";
			  $query = mysql_query($sql,$con);
			  If ( mysql_error($con)!= null){
			     Return -1;
			  }
              $query_result = mysql_fetch_assoc($query);
			  extract($query_result);
   			  If ($total == 0){ 
       	          $sql = "Insert Into Tabelas_Relacoes (idTabelas_Mae, idTipoTabMae, idTabelas_Filha, idTipoTabFilha) values ($id_mae,$tipo_mae,$id_filha,$tipo_filha)";		   
		          $query = mysql_query($sql,$con);
			      If (mysql_error($con)!= null){
			          Return -1;
			      }
			  }  
		    $ind++;
			}
		Return 1;
    }

	public function InsErrMsg($idAgendamento, $deMsg, $con) {

       	   $sql = "Insert Into MsgAgendamento(idAgendamento, deMsg, dtMsg) values ($idAgendamento,'".$deMsg."',now())";		   
 	       $query = mysql_query($sql,$con);
		   If (mysql_error($con)!= null){
			   Return -1;
		   }else {
			   Return 1;
		   }
    }
	
	public function UpdAgendamento($idAgendamento,$status,$con) {

       	   $sql = "Update Agendamento Set status = '".$status."' Where idAgendamento = $idAgendamento";		   
 	       $query = mysql_query($sql,$con);
		   If (mysql_error($con)!= null){
			   Return -1;
		   }else {
			   Return 1;
		   }
    }

	public function UpdCatalogoInterno($idDb,$idTipo,$descDb,$database,$schema,$con) {
			 // Verificar se o registro jÃ¡ existe, casa exista, fazer update, caso contrÃ¡rio fazer insert
    	     $sql = "Select * from catalogo_database_clientsite where idCatalogo_Database = $idDb; ";		   
             //echo $sql;echo "</br>";
			 $query = mysql_query($sql,$con);
		     If (mysql_error($con)!= null){
			     //echo "erro 3"; echo"<br>".mysql_error($con);
				 Return -1;
		     }
			 $rows = mysql_num_rows($query);
			 //echo $rows;echo "</br>";
		     If (mysql_num_rows($query)>0){			 
				 $sql = "Update catalogo_database_clientsite ";
				 $sql = $sql." Set Tipo_Database_idTipo_Database = $idTipo,";
				 $sql = $sql." descricao = '$descDb', ";
				 $sql = $sql." `database` = '$database', ";
				 $sql = $sql." `schema` = '$schema' ";
				 $sql = $sql." Where idCatalogo_Database = $idDb ";
		     }else{			 
    	         $sql = "Insert Into catalogo_database_clientsite ";
			     $sql = $sql."(idCatalogo_Database,Tipo_Database_idTipo_Database, descricao, `database`, `schema`) ";
			     $sql = $sql."values ($idDb,$idTipo,'".$descDb."','".$database."','".$schema."') ";
			 }
             //echo $sql;echo "</br>";
	         $query = mysql_query($sql,$con);
		     If (mysql_error($con)!= null){
		         //echo "4"; echo"<br>".mysql_error($con);
				 Return -1;
		     } else {
			     Return 0;
             }			 
    }
	
}
?>