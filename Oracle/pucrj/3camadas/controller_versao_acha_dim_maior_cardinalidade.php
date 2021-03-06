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
	   // Obtem a senten�a a ser executada 
	   $resqueries= $objDatabase->Get_Queries($objDatabase);
       // Obtem as tabelas que possuem Qtd Pk = Qtd Fk e que tem P 

       If ($query1 = mysql_fetch_row($resqueries)) {	   
       	   $sql = $query1[2];
       	   
       	   // Monta a string de conex�o de acordo com o tipo do BD
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
				   // Fechar conex�o com PDO
                   $pdo = null;
                   Return $tab_tot_pk_fk;
                }
				// Fechar conex�o com PDO
                $pdo = null;

       }
	}

	
	public function Sel_Tabelas_Candidatas(AbstractDatabase $objDatabase, $result) {
	   // Obtem a senten�a a ser executada 
  	    $objDatabase->SetTipoQuery(2);
		If ($result != null) {
			$resqueries= $objDatabase->Get_Queries($objDatabase);
              
           If ($query1 = mysql_fetch_array($resqueries)) {	   
       	       Extract($query1);
			   $tot_fatos_pot = 0;
			   // Define string de conex�o de acordo com o tipo do Database
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
	   // Obtem a senten�a a ser executada 

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
			   // Define string de conex�o de acordo com o tipo do Database
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
	   // Obtem a senten�a a ser executada 

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
			   // Define string de conex�o de acordo com o tipo do Database
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

	
	public function Get_Dimes_Maior_Cardinalidade(AbstractDatabase $objDatabase, $result) {

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
			   // Define string de conex�o de acordo com o tipo do Database
               if ($objDatabase->GetIdTipoDatabase() == 1) {
               	   $conDB = "oci:dbname=".$objDatabase->GetDatabase();
               	}
                	   
               if ($objDatabase->GetIdTipoDatabase() == 2) {
               	   $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
               	}
			   $maior = 0;
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
                     foreach($result2 as $row2) {
		               //echo "<pre>";
		               print_r($result2);
		               //echo "</pre>";
					   $ind = 0;
  			           foreach ($row2 as $item2) { 
					      //echo "Item2 = $item2";
						  //echo "</br>";
						  $col[$ind] = $item2;
					      //echo "Col($ind) = ".$col[$ind];
						  //echo "</br>";
						  $ind++;
			    	   }
					   //echo "Maior = $maior";
					   //echo "</br>";
					   //echo "Col(2) = ".$col[2];
					   If ($col[2] > $maior) 
							{
							  //echo "Entrei no If";
							  //echo "</br>";
							  $maior = $col[2];
							  If (isset($maior_dim)){
							     //echo "Existe maior_dim";
							     //echo "</br>";
							    unset($maior_dim);
							  }
							  $tot_dim = 0;
        				      $maior_dim[$tot_dim]["owner"] = $col[0]; 
				    	      $maior_dim[$tot_dim]["table"] = $col[1];
							  //echo "Falso ";
							  //echo "</br>";
				   		      //return false;
 				   		    } else {
							  //echo "Entrei no Else";
							  //echo "</br>";
							  if ($item2 == $maior){
								//echo "Entrei no 2o If";
								//echo "</br>";
								  if (!$objDatabase->in_array_table($objDatabase, $col[1],$col[0],$maior_dim)){
  				    	            $tot_dim++;
        				            $maior_dim[$tot_dim]["owner"] = $col[0]; 
				    	            $maior_dim[$tot_dim]["table"] = $col[1];							    
                                  } 
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
	  //echo "mensagem";
	  //echo "</br>";
      // echo "<pre>";
	  //print_r($maior_dim);
	  //echo "</pre>";
      return $maior_dim;		

	  } //Get_Dimes_Maior_Cardinalidade
	
	public function Print_Results($result) {

   	   echo '<h5>Exibindo dados retornados pela extens�o PDO"</h5>';
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
	
	
	
}
?>