<?php
	session_start();
	require_once("../../engine/connection.inc.php");
	require_once("../../engine/funcoes.php");
	logado();
	//adm();
	mantemLogin();
	
	if($_GET){
       if(isset($_GET['id']) && intval($_GET['id'])) {
       
       	    $id = intval($_GET['id']); //no default
			$inst = intval($_GET['inst']); //no default
                        
       	    /* Obtém os databases cadastrados para a instituição que deverão estar no sincronismo */
       	    $sql = "SELECT * FROM catalogo_database WHERE idCatalogo_Database = $id; ";
			$result = mysql_query($sql,$con);
			If ( mysql_error($con)!= null){
               $_SESSION['msg'] = "Falha na tentativa de conexão do Bando de Dados - Consulta ao Catalogo de databases.";			
			   header("location: index.php");
			}
            $linhas = mysql_num_rows($result);
			//echo $linhas;
			//exit;
            if($linhas>0) {
			   /* Insere o agendamento de controle */
   		       $SQLi = "INSERT INTO agendamento (tipo_agendamento, horario_processamento, dia_processamento, flag_imediato, Instituicao_id, Catalogo_Database_idCatalogo_Database, status)  ";
			   $SQLi = $SQLi." values ( 'N', null, null, 1, $inst, $id,'P'); ";
               //echo "SQL = $SQLi";
               //echo "<br>";			
			   //exit;
			   $result2 = mysql_query($SQLi,$con);
			   
			   $linhas_inserted = mysql_affected_rows();
			   //$linhas_inserted = 0;
               //echo "linhas = $SQLi";
               //echo "<br>";			
			   //exit;
			   If ($linhas_inserted <> 1) {
		           $_SESSION['msg'] = "Falha na geração da Solicitação de Pesquisa do Catálogo.";
                   header("location: index.php"); 
			   } else {
			       $id_agendamento = mysql_insert_id();
			   }	
			   
			   /* prepara o json para ser passado na chamda do webservice */
			   $ind = 0;

               //header('Content-type: application/json');
			   //$json_parm = json_encode(array("request_number"=>"$id_agendamento","database_id"=>"$id","request_type"=>"SearchCatalog"));
			   //exit;
			   
			   /* Incluir a chamada do webservice com servico "search_catalog" */

		    } else {
              /* não há nada a fazer pois não há databases */
		       $_SESSION['msg'] = "Database não localizado na base de dados.";
               header("location: index.php");               			  
			}
       }
	   //echo "Após tratar GET";echo "<br>";
	   //exit;
	   $max = 0;
    }
		
	if($_POST){
	//echo "Entrei no POST";
	//exit;
	//if (isset($_POST['fatos'])) {
    //    print_r($_POST['fatos']); 
    //}
	//exit;
	   if (isset($_SESSION['json'])) {
	      extract($_SESSION['json']);
		  //echo $request_number; echo "<br>";
		  //echo $database_id; echo "<br>";
		  //print_r($facts);
		  //exit;
	      $saida["request_number"] = $request_number;
          $saida["database_id"] = $database_id;
		  $saida["request_type"] = "GetCatalog";
		  $saida["facts"] = array();
          $maxj = sizeof($facts)-1;
		  //echo $maxj;
		  //exit;
		  
		  implode(',', $_POST['fatos']);
          $checked = $_POST['fatos'];
          for($i=0; $i < count($checked); $i++){
               for($j=0; $j < $maxj; $j++){
                      If ($checked[$i] == $j){
  			              $saida["facts"][$i] = $facts[$j];
						}  
                }  
	           echo "Selected " . $checked[$i] . "<br/>";
            }
		  }
      /* prepara o json para ser passado na chamda do webservice */
   
      //header('Content-type: application/json');
	  $jsons = json_encode($saida,true); 	  
	  //echo $jsons;
      			   
	  /* Incluir a chamada do webservice com servico "get_catalog" */
	  
	  /* Incluir a chamada da rotina de update_catalog se a get_catalog retornou um json válido!!! */
            
	  exit;
	   
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-table-1">Escolha um ou mais modelos dimensionais</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">
    <div class="mws-form-row">
      <label for="database">MODELOS DIMENSIONAIS</label>
		<?php
               //echo "Cheguei aqui!!!";
			   //exit;
               /* AQUI TESTA o retorno do webservice e de acordo com o retorno */
			   /* monta a tela adequada */
			   If (true){  /* acertar este IF com base na análise do retorno da chamada do web service */
                  //Parâmetros que serão recebidos pelo json retornado pelo web service
                  //echo "Entrei no IF!!!";
			      //exit;
	              $json = file_get_contents('exemplo_json_lista_fatos_dimensoes.txt');
                  $jsond = json_decode($json,true);
				  $_SESSION['json'] = $jsond;
                  
				  $jsond["request_number"] = $id_agendamento;  //retirar na versão para valer
			      //exit;
			  	  If ($jsond["request_type"] == 'SearchCatalog' and $jsond["request_number"] == $id_agendamento and $jsond["database_id"] == $id){

				      $SQLu = " Update Agendamento Set status = 'R' where idAgendamento = $id_agendamento; ";
			          $_SESSION['msg'] = "Sincronismo realizado com sucesso! Soliitação: $id_agendamento";
			          $result = mysql_query($SQLu,$con);
			          If ( mysql_error($con)!= null){
                         $_SESSION['msg'] = "Falha na tentativa de conexão do Banco de Dados - Update retorno pesquisa do catálogo.";			
  			          }

                      $max = sizeof($jsond['facts']);
                      $ind = 0;
					  
					  While ($ind <= ($max-1)){
					     $jsond["facts"][$ind]["owner"] = str_replace("'"," ",$jsond["facts"][$ind]["owner"]);
						 $jsond["facts"][$ind]["table"] = str_replace("'"," ",$jsond["facts"][$ind]["table"]);
						 $valor = $ind;
						 $label = "Fato".$jsond["facts"][$ind]["owner"]." - ".$jsond["facts"][$ind]["table"];
					  ?>
                         <div class="mws-panel-toolbar top clearfix">
                             <ul>
                     		    <li><input type="checkbox" name="fatos[]" value="<?=$valor;?>"/><?=$label;?><br/></li>
                                 <!--<li><a href="inserir.php?id=<?//=$user_instituicao;?>" class="mws-ic-16 ic-accept">Inserir Database</a></li>-->
                             </ul>
                         </div>
						 <table class="mws-datatable mws-table"> 
							 <tbody>
							 <?php 				
							 $max2 = sizeof($jsond['facts'][$ind]['dimensions']);
							 $ind2 = 0;
							 while($ind2 <= ($max2-1)){
								$owner = $jsond['facts'][$ind]['dimensions'][$ind2]["owner"];
								$owner = str_replace("'"," ",$owner);
								$table = $jsond['facts'][$ind]['dimensions'][$ind2]["table"];
								$table = str_replace("'"," ",$table);
								$descricao = $owner." - ".$table
								//echo "Descricao: $descricao";
								//exit;					
							 ?>
								<tr>
									<td><?=$descricao;?></td>
								</tr>					
							 <?php
                                $ind2++;							 
							 }			
			                 ?>					
							 </tbody>
						 </table>	
 				   <?php
					     
					     $ind++;					  
					  }
					}
				}	
					?>  
</div>
<div class="mws-button-row">
  <?
     //$total = 0;
     if ($max == 0){ 
  ?>
        <input type="submit" value="Carregar Modelos" class="mws-button red" disabled="disabled" />
  <?
     }else{ 
  ?>
        <input type="submit" value="Carregar Modelos" class="mws-button red" />
  <?
     } 
  ?>
  <input type="reset" value="Limpar" class="mws-button gray" />
</div>
</div>
</div>     
</div>
</form>    
</div>

<?php
	include_once("../rodape.php");
?>
