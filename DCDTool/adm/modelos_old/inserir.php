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
		//echo $id;
		//exit;
    }
	
	if($_POST){
		$idcateg = $_POST['idcateg'];
		
		extract($_POST);
		$erros = array();
		
		$SQL = "   Select nome as nmcateg from categoria_assunto where id = $idcateg";
		
		
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
		}
			
		if($erros == null){

			$SQL = "Select * from assuntos where descricao = '$descricao' and id_categoria = $idcateg ";
			mysqli_query($conexao,$SQL);
		    $linhas = mysqli_affected_rows($conexao);
            if($linhas > 0){
			     $_SESSION['msg'] = "Falha na Inserção. O assunto $descricao já se encontra cadastrado na categoria $nmcateg.";
			}else{
   		        $SQL = "INSERT INTO assuntos (descricao, palavras_chave, urls, id_categoria)  ";
			    $SQL = $SQL." values ('$descricao', '$palavras_chave', '$urls', $idcateg); ";
                //echo "SQL = $SQL";
                //echo "<br>";			
			    //exit;
			    mysqli_autocommit($conexao, FALSE);
			    mysqli_query($conexao,$SQL);
			    
			    $linhas_inserted = mysqli_affected_rows($conexao);
			    //$linhas_inserted = 0;
			    If ($linhas_inserted <> 1) {
		            mysqli_rollback($conexao);
		            $_SESSION['msg'] = "Falha na Inserção.  Tentativa de inserção afetaria $linhas_inserted linha(s).";
                } else {
			    	mysqli_commit($conexao);
			        $_SESSION['msg'] = "Sucesso na inclusão de um novo assunto para a categoria ".$nmcateg."." ;
			    }	
			    //mysqli_autocommit($conexao, TRUE);
		    }
		    header("location: index_01.php");		
		} 
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<?php
   if (!isset($descricao)){
      $descricao = null;
	}
   if (!isset($palavras_chave)){
      $palavras_chave = null;
	}
   if (!isset($urls)){
      $urls = null;
	}
?>			                          
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Inserir Assunto</span>
  </div>
  <div class="mws-panel-body">
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
<div class="mws-button-row">
    <input type="submit" value="Inserir" class="mws-button red" />
	<input type="reset" value="Limpar" class="mws-button gray" />
	<input type="hidden" name="idcateg" value="<?=$idcateg;?>"/>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>

