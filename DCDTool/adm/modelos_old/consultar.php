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
	}

	if($_POST){
      header("location: index_01.php");
	  echo "POST";
	  exit;
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Consultar Assunto</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="descricao">Assunto</label>
      <div class="mws-form-item large">
        <input type="text" id ="descricao" name="descricao" value="<?=$descricao;?>" class="mws-textinput" disabled="disabled"/>
      </div>
      <label for="palavras_chave">Palavras Chaves para Pesquisa</label>
      <div class="mws-form-item large">
        <input type="text" id ="palavras_chave" name="palavras_chave" value="<?=$palavras_chave;?>" class="mws-textinput" disabled="disabled" />
      </div>
      <label for="urls">URLs Relacionadas</label>
      <div class="mws-form-item large">
        <input type="text" id ="urls" name="urls" value="<?=$urls;?>" class="mws-textinput" disabled="disabled" />
      </div>
      <label for="nmcateg">Categoria</label>
      <div class="mws-form-item large">
        <input type="text" id ="nmcateg" name="nmcateg" value="<?=$nmcateg;?>" class="mws-textinput" disabled="disabled" />
      </div>
    </div>
</div>
<div class="mws-button-row">
    <input type="submit" value="Retornar" class="mws-button orange" />
	<input type="hidden" name="id" value="<?=$id;?>"/>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>
