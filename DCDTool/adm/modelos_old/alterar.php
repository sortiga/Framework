<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	//adm();
	mantemLogin();
	
	if($_GET){
	    //echo "<pre>";
		//print_r($_GET);
		//echo "</pre>";
		extract($_GET);
		//echo "ID = $id";
		//exit;
		
		$SQL = "SELECT * FROM assuntos WHERE idAssuntos = $id;";
		//echo "SQL = $SQL";
		//exit;
		$resultado = mysqli_query($conexao,$SQL);
		
	    $linhas = mysqli_affected_rows($conexao);
		//echo "Linhas = $linhas";
		//exit;
        if($linhas > 0){
  		   $linha = mysqli_fetch_array($resultado);
		   extract($linha);		   
        }else{
		   $_SESSION['msg'] = "Falha - Não foi possível recuperar o assunto informado.";
		   header("location: index_01.php");
        }		

		$SQL = "   SELECT nome as nmcateg FROM categoria_assunto WHERE id = $id_categoria;";
		//echo "SQL = $SQL";
		//exit;
		$resultado = mysqli_query($conexao,$SQL);
	    $linhas = mysqli_affected_rows($conexao);
        if($linhas > 0){
  		   $linha = mysqli_fetch_array($resultado);
		   extract($linha);		   
        }else{
		   $_SESSION['msg'] = "Falha - Não foi possível recuperar a categoria do assunto informado.";
		   header("location: index_01.php");
        }		
	    //echo "<pre>";
		//print_r($linha);
		//echo "</pre>";
		//extract($_GET);
		//echo "ID = $id";
		//exit;
		$desc_old = $descricao;$palavras_old = $palavras_chave;$url_old = $urls;$idcateg_old=$id2;
	}
	
	
	if($_POST){
	    //echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		
		extract($_POST);
		$erros = array();
		
		if (isset($alterar)){
		   $id2 = $_SESSION['categoria'];
		   
		   //echo $id2;
		   //exit;
		   
		   $SQL = "   Select nome as nmcateg from categoria_assunto where id = $id2";
		   
		   $resultado = mysqli_query($conexao,$SQL);
	       $linhas = mysqli_affected_rows($conexao);
           if($linhas > 0){
  		      $linha = mysqli_fetch_array($resultado);
		      extract($linha);		   
           }else{
		      $_SESSION['msg'] = "Falha - Não foi possível recuperar a categoria informada.";
		      header("location: index.php");
           }		
           
		   
		   if($descricao == ""){
		   	$erros['descricao'] = "Campo obrigatório.";
		   }
		   
		   if($palavras_chave == ""){
		   	$erros['palavras_chave'] = "Campo obrigatório.";
		   }// else { 
             //  $SQL = "SELECT id_database FROM tipo_database WHERE nm_database = $tipodb ";
 	         //  $resultado = mysqli_query($conexao,$SQL);
		     //  $linha = mysqli_fetch_array($resultado);
		     //  extract($linha);	
             //  $tipodb = $id_database;
           //}
		   
		   
		   if($erros == null){
               If (!($desc_old == $descricao AND $palavras_old == $palavras_cahve AND $url_old == $urls)){ //AND $idcateg_old == $database)){
 		           $SQL = "Select * from assuntos where descricao = '$descricao' and id_categoria = $id2 and idAssuntos <> $id";
		   		//echo $SQL;
		   		//exit;
		   	    mysqli_query($conexao,$SQL);
		           $linhas = mysqli_affected_rows($conexao);
                   if($linhas > 0){
		   	         $_SESSION['msg'] = "Falha na Atualização. O assunto $descricao já se encontra cadastrado na categoria $nmcateg.";
		   	    }else{
		   	         $SQL = "UPDATE assuntos SET urls= '$urls', descricao ='$descricao', palavras_chave = '$palavras_chave' ";
		   	         $SQL = $SQL."  WHERE idAssuntos =$id;";	
                        //echo "SQL = $SQL";
                        //echo "<br>";			
		   	         //exit;
		   	         mysqli_autocommit($conexao, FALSE);
		   	         mysqli_query($conexao,$SQL);
		   	         
		   	         $linhas_updated = mysqli_affected_rows($conexao);
		   	         //$linhas_updated = 0;
		   	         If ($linhas_updated <> 1) {
		   	             if (!($desc_old == $descricao AND $palavras_old == $palavras_cahve AND $url_old == $urls)){
		   	                 mysqli_rollback($conexao);
		   	                 $_SESSION['msg'] = "Falha na atualização.  Tentativa de atualização afetaria $linhas_updated linha(s).";
		   	         	}
                        } else {
		   	         	mysqli_commit($conexao);
		   	             $_SESSION['msg'] = "Sucesso na alteração do Assunto.";
		   	         }	
		   		}
		   	} else{
                   $_SESSION['msg'] = "Falha - Nenhuma modificação foi realizada na definição do Assunto.";				
		   	}
		   	//mysqli_autocommit($conexao, TRUE);			
		   } //else {
		     //echo "Entrei no Else";
		     //echo "<br>";
		   //}
		}		
        header("location: index_01.php");
		
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Alterar Database</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="descricao">Assunto</label>
      <div class="mws-form-item large">
        <input type="text" id ="descricao" name="descricao" value="<?=$descricao;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['descricao'])){
			   exibeErros($erros['descricao']);
			}
		?>			                          
      </div>
      <label for="palavras_chave">Palavras Chaves para Pesquisa</label>
      <div class="mws-form-item large">
        <input type="text" id ="palavras_chave" name="palavras_chave" value="<?=$palavras_chave;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['palavras_chave'])){
			   exibeErros($erros['palavras_chave']);
			}
		?>			                          
      </div>
      <label for="urls">URLs Relacionadas</label>
      <div class="mws-form-item large">
        <input type="text" id ="urls" name="urls" value="<?=$urls;?>" class="mws-textinput"/>
		<?php
            if (isset($erros['urls'])){
			   exibeErros($erros['urls']);
			}
		?>			                          
      </div> 
    </div>
</div>
</div>
<div class="mws-button-row">
  <?
     //$total = 0;
     if ($linhas == 0){ 
  ?>
        <input type="submit" value="Alterar" class="mws-button red" disabled="disabled" />
  <?
     }else{ 
  ?>
        <input type="submit" name="alterar" value="Alterar" class="mws-button red" />
  <?
     } 
  ?>
	<input type="reset"  name="limpar" value="Limpar" class="mws-button gray" />
    <input type="submit" name="retornar" value="Retornar" class="mws-button orange" />
    <input type="hidden" name="id" value="<?=$id;?>"/>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>
