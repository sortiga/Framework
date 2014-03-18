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
			   Return -1;
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
                   Return; 
			   } else {
			       $id_agendamento = mysql_insert_id();
			   }	
			   
			   /* prepara o json para ser passado na chamda do webservice */
			   $ind = 1;
       	       while($post = mysql_fetch_assoc($result)) {
       	       	  //$posts[] = array('estrutura'=>$post);
				  $posts[] = array('registro'.$ind=>$post);
				  $ind++;
       	       }
               header('Content-type: application/json');
			   echo json_encode(array("solicitacao_id"=>"$id_agendamento","databases_total"=>"$linhas","tipo_request"=>"sincronismo",'Databases'=>$posts));
			   
			   
			   /* Incluir a chamada do webservice com servico "sincronismo" */
               /* recebe o retorno do webservice e de acordo com o retorno */
			   /* devolve a mensagem adequada */
			   If (true){
			      $_SESSION['msg'] = "Sincronismo realizado com sucesso!";
			   } else {
			      $_SESSION['msg'] = "Falha ! Erro no processo de sincronismo.  Favor tetar novamente mais tarde.";
			   }
			   Return
		    } else {
              /* não há nada a fazer pois não há databases */
		       $_SESSION['msg'] = "Não há Databases cadastrados para a Instituição.";
               Return;               			  
			}
       }
    }
/* require the user as the parameter */
?>