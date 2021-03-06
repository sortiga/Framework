<?php
include_once('model.php');

class BALDatabaseMySQL extends AbstractDatabase 
{
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
	
	
	public function Get_Fatos_potenciais(AbstractDatabase $objDatabase, $result) {

  	    $objDatabase->SetTipoQuery(2);
		If ($result) {
			$resqueries= $objDatabase->Get_Queries($objDatabase);
			$objDatabase->SetTipoQuery(0);
			$resqueries2= $objDatabase->Get_Queries($objDatabase);
			$objDatabase->SetTipoQuery(3);
			$resqueries3= $objDatabase->Get_Queries($objDatabase);
			If (($query2 = mysql_fetch_row($resqueries))&&($query3 = mysql_fetch_row($resqueries2))&&($query4 = mysql_fetch_row($resqueries3))) {	   
				$sql  = $query2[2];
				$sql2 = $query3[2];
				$sql3 = $query4[2];
                $tot_fatos_pot = 0;
			    foreach($result as $row ) 
			    {
			    	$ind = 0;
			    	foreach ($row as $item) 
			    	{
			    		$col[$ind] = $item;
			    		$ind++;
			    	}
			    	$owner = " '".$col[0]."' ";
			    	$table = " '".$col[1]."' ";
					$restriction_type = " ('P','U') ";
					echo "Owner: $owner <br>";
					echo "Table: $table <br>";
					$contador = 0;
					$contador_s++;
					echo "total: $contador_s <br>";
	                // Fornece: <body text='black'>
                    $sql = str_replace("%condicao%", $restriction_type, $sql);
                    $sql = str_replace("%owner%", $owner, $sql);
					$sql = str_replace("%table%", $table, $sql);
                    $sql2 = str_replace("%owner%", $owner, $sql2);
					$sql2 = str_replace("%table%", $table, $sql2);
                    $sql3 = str_replace("%owner%", $owner, $sql3);
					$sql3 = str_replace("%table%", $table, $sql3);

					if ($col2[1] = 'SRO_FATO_FATURAMENTO') {
                       echo "Vou processar a FATO de verdade... <br>";
					}
					
					
                	// Monta a string de conex�o de acordo com o tipo do BD
                	if ($objDatabase->GetIdTipoDatabase() == 1) {
                	   $conDB = "oci:dbname=".$objDatabase->GetDatabase();
                	}
                	   
                	if ($objDatabase->GetIdTipoDatabase() == 2) {
                	   $conDB = "mysql:host=".$objDatabase->GetDatabase().";dbname=".$$objDatabase->GetSchema();
                	}

					////echo 'CONSULTA 1 <br>   ';
					////echo $sql;
					////echo '<br>';
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

					////echo 'EXECUTOU <br>   ';
					////echo '<br>';
					
					if($result2 = $stmt->fetchAll(PDO::FETCH_ASSOC))
					{
   					    $eh_fato_potencial = true;
						$contador = 0;
						foreach($result2 as $row) 
						{
						    //$contador++;
							////echo "contador: $contador";
							////echo '<br>';
							$ind2 = 0;
							foreach ($row as $item)
							{
								$col2[$ind2] = $item;
								$ind2++;
							}
							$coluna = "'".$col2[2]."'";
                            $sql2 = str_replace("%column%", $coluna, $sql2);
							$sql3 = str_replace("%column%", $coluna, $sql3);

                            echo "      coluna: $coluna <br>";

         					////echo 'CONSULTA 2';
							////echo '<br>';
		        			////echo $sql2;
        					////echo '<br>';

                            if(!$stmt2 = $pdo->prepare($sql2))
                            {
                              $e= $pdo->errorInfo();
                              throw new Exception("Erro ao preparar consulta 2- " . $e[2]);
                            }
                            if(!$stmt2->execute())
                            {
                              $e= $stmt2->errorInfo();
                              throw new Exception("Erro ao executar consulta 2- " . $e[2]);
                            }
							if($result3 = $stmt2->fetchAll(PDO::FETCH_ASSOC))
							{
								foreach($result3 as $row2)
								{
									foreach ($row2 as $item2)
									{
									   echo "          Item 2: $item2 <br>";
									   //echo '<br>';
									   If ($item2 == 0) 
									   {
									      echo "          Falso 1  <br>";
									      $eh_fato_potencial = false;
									   } else {
            		        			////echo $sql3;
                    					//echo '<br>';

									   if(!$stmt3 = $pdo->prepare($sql3))
                                          {
                                            $e= $pdo->errorInfo();
                                            throw new Exception("Erro ao preparar consulta 3- " . $e[2]);
                                          }
                                       if(!$stmt3->execute())
                                          {
                                            $e= $stmt3->errorInfo();
                                            throw new Exception("Erro ao executar consulta 3- " . $e[2]);
                                          }
							           if($result4 = $stmt3->fetchAll(PDO::FETCH_ASSOC))
									      {
								             foreach($result4 as $row3)
								             {
								             	foreach ($row3 as $item3)
								             	{
												   echo "          Item 3: $item3";
												   echo '<br>';
												   If ($item3 > 0){
  									                   echo "          Falso 2  <br>";
                                                       $eh_fato_potencial = false;
												   }
												}
											 }
										      
										  }
									   }
									}
								}
							}
						}
						
						//echo "Resultado: $eh_fato_potencial <br>";
						//echo '<br>';
                        //echo 'Passei aqui <br>';
						If ($eh_fato_potencial) {
						   //echo 'Entrei no if...  <br>';
						   $fato_potencial["owner"][$tot_fatos_pot] = $owner; 
						   $fato_potencial["table"][$tot_fatos_pot] = $table;
						   $tot_fatos_pot++;
						}
					}
					// Fechar conex�o com PDO
					$pdo = null;
			    }
				//echo 'Antes do teste <br>';
				if (!isset($fato_potencial)){
				   //echo 'Dentro do if <br>';
				   $fato_potencial = null;
				   if (!isset($fato_potencial)){
				      //echo 'criou fato_potencial com null <br>';
				   }else{
				      //echo 'N�O criou fato_potencial com null <br>';
				   }
				}
				//echo $fato_potencial;
				Return $fato_potencial;
           }
		}

	}
	

	
	
	
	
	public function Print_Results($result) {

   	   //echo '<h5>Exibindo dados retornados pela extens�o PDO"</h5>';
       //echo "<table border='1'>\n";
       foreach($result as $row ) 
       {
          //echo "<tr>\n";
          foreach ($row as $item) 
          {
             //echo "    <td>".($item!==null?htmlentities($item, ENT_QUOTES):" ")."</td>\r\n";
          }
          //echo "</tr>\n";
        }
        //echo "</table>\n";
    }
	
	
	
}
?>