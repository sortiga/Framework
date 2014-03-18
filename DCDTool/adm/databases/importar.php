<?php
	session_start();
	require_once("../../engine/connection.inc.php");
	require_once("../../engine/funcoes.php");
	//logado();
	//mantemLogin();
	
	if($_GET){

       if(isset($_GET['id']) && intval($_GET['id'])) {
       
       	    $id = intval($_GET['id']); //no default
                        
       	    /* Obtém os databases cadastrados para a instituição que deverão estar no sincronismo */
       	    $sql = "SELECT * FROM catalogo_database WHERE idCatalogo_Database = $id; ";
			$result = mysql_query($sql,$con);
			If ( mysql_error($con)!= null){
               $_SESSION['msg'] = "Falha na tentativa de conexão do Bando de Dados - Consulta ao Catalogo de databases.";			
			   header("location: index.php");
			}
            $linhas = mysql_num_rows($result);
            if($linhas>0) {
			   /* Insere o agendamento de controle */
   		       $SQLi = "INSERT INTO agendamento (tipo_agendamento, horario_processamento, dia_processamento, flag_imediato, Instituicao_id, Catalogo_Database_idCatalogo_Database, status)  ";
			   $SQLi = $SQLi." values ( 'N', null, null, 1, $inst,null,'P'); ";
               //echo "SQL = $SQL";
               //echo "<br>";			
			   //exit;
			   $result2 = mysql_query($SQLi,$con);
			   
			   $linhas_inserted = mysql_affected_rows();
			   //$linhas_inserted = 0;
			   If ($linhas_inserted <> 1) {
		           $_SESSION['msg'] = "Falha na geração da Solicitação de Pesquisa do Catálogo.";
                   header("location: index.php"); 
			   } else {
			       $id_agendamento = mysql_insert_id();
			   }	
			   
			   /* prepara o json para ser passado na chamda do webservice */
			   $ind = 0;

               header('Content-type: application/json');
			   $json_parm = json_encode(array("request_number"=>"$id_agendamento","database_id"=>"$id","request_type"=>"SearchCatalog");
			   //exit;
			   
			   /* Incluir a chamada do webservice com servico "search_catalog" */
               /* recebe o retorno do webservice e de acordo com o retorno */
			   /* devolve a mensagem adequada */

			   If (true){  /* acertar este IF com base na análise do retorno da chamada do web service */
			      $SQLu = " Update Agendamento Set status = 'R' where idAgendamento = $id_agendamento; ";
			      $_SESSION['msg'] = "Sincronismo realizado com sucesso! Soliitação: $id_agendamento";
			      $result = mysql_query($SQLu,$con);
			      If ( mysql_error($con)!= null){
                     $_SESSION['msg'] = "Falha na tentativa de conexão do Bando de Dados - Update retorno pesquisa do catálogo.";			
			       }

                  //Parâmetros que serão recebidos pelo json retornado pelo web service
	              $json = file_get_contents('exemplo_json_lista_fatos_dimensoes.txt');
                  $jsond = json_decode($json,true);
                  
			  	  If ($jsond["request_type"] == 'SearchCatalog' $jsond["request_number"] == $id_agendamento and $jsond["database_id"] == $id){
                      $saida["request_number"] = $jsond["request_number"];
                      $saida["database_id"] = $jsond["database_id"];
					  $saida["request_type"] = "GetCatalog";
	                  $saida["facts"] = array();
                      $max = sizeof($jsond['facts']);
                    
                      
				   
  			          $SQLu = " Update Agendamento Set status = 'A' where idAgendamento = $id_agendamento; ";

                  } else {
			          $SQLu = " Update Agendamento Set status = 'F' where idAgendamento = $id_agendamento; ";
			          $_SESSION['msg'] = "Falha - Recuperação de Modelos Dimensionais mal sucedida! Solicitação: $id_agendamento";				  
				  }
			      $result = mysql_query($SQLu,$con);
			      If ( mysql_error($con)!= null){
                     $_SESSION['msg'] = "Falha na tentativa de conexão do Bando de Dados - Update processamento do retorno pesquisa do catálogo.";			
			       }
			   } else {
			      $SQLu = " Update Agendamento Set status = 'F' where idAgendamento = $id_agendamento; ";
			      $_SESSION['msg'] = "Falha ! Erro no processo de pesquisa do catálogo.  Favor tetar novamente mais tarde.";
			      $result = mysql_query($SQLu,$con);
			      If ( mysql_error($con)!= null){
                     $_SESSION['msg'] = "Falha na tentativa de conexão do Bando de Dados - Update retorno pesquisa do catálogo.";			
			       }
			   }
		    } else {
              /* não há nada a fazer pois não há databases */
		       $_SESSION['msg'] = "Database não localizado na base de dados.";
			}
            header("location: index.php");               			  
       }
    }
?>