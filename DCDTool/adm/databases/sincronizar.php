<?php
	session_start();
	require_once("../../engine/connection.inc.php");
	require_once("../../engine/funcoes.php");
	//logado();
	//mantemLogin();
	
	if($_GET){

       if(isset($_GET['inst']) && intval($_GET['inst'])) {
       
       	    $inst = intval($_GET['inst']); //no default
                        
       	    /* Obtém os databases cadastrados para a instituição que deverão estar no sincronismo */
       	    $sql = "SELECT * FROM catalogo_database WHERE id_instituicao = $inst ";
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
		           $_SESSION['msg'] = "Falha na geração da Solicitação.";
                   header("location: index.php"); 
			   } else {
			       $id_agendamento = mysql_insert_id();
			   }	
			   
			   /* prepara o json para ser passado na chamda do webservice */
			   $ind = 0;
       	       while($post = mysql_fetch_assoc($result)) {
       	       	  //$posts[] = array('estrutura'=>$post);
				  $posts[$ind] = $post;
				  $ind++;
       	       }
               header('Content-type: application/json');
			   $json_parm = json_encode(array("request_number"=>"$id_agendamento","databases_total"=>"$linhas","request_type"=>"sincronismo",'Databases'=>$posts));
			   //exit;
			   
			   /* Incluir a chamada do webservice com servico "sincronismo" */
               /* recebe o retorno do webservice e de acordo com o retorno */
			   /* devolve a mensagem adequada */
			   
			   
			   If (true){  /* acertar este IF com base na análise do retorno da chamada do web service */
			      $SQLu = " Update Agendamento Set status = 'A' where idAgendamento = $id_agendamento; ";
			      $_SESSION['msg'] = "Sincronismo realizado com sucesso! Soliitação: $id_agendamento";
			   } else {
			      $SQLu = " Update Agendamento Set status = 'F' where idAgendamento = $id_agendamento; ";
			      $_SESSION['msg'] = "Falha ! Erro no processo de sincronismo.  Favor tetar novamente mais tarde.";
			   }
			   $result = mysql_query($SQLu,$con);
			   If ( mysql_error($con)!= null){
                  $_SESSION['msg'] = "Falha na tentativa de conexão do Bando de Dados - Update retorno sincronismo.";			
			   }
		    } else {
              /* não há nada a fazer pois não há databases */
		       $_SESSION['msg'] = "Não há Databases cadastrados para a Instituição.";
			}
            header("location: index.php");               			  
       }
    }
/* require the user as the parameter */
?>