<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	adm();
	mantemLogin();
	
	if($_POST){
		extract($_POST);
		$erros = array();
		
		if($nome == ""){
			$erros['nome'] = "Campo obrigatório.";
		}
				
		
		if($erros == null){
			
			$SQL = "INSERT INTO categorias VALUES(DEFAULT,'$nome');";
			mysqli_query($conexao,$SQL);
			$_SESSION['msg'] = "Categoria inserida com sucesso.";
			header("location: index.php");		
		
		}
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Inserir Categoria</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="nome">Nome</label>
      <div class="mws-form-item large">
        <input type="text" id ="nome" name="nome" value="<?=$nome;?>" class="mws-textinput"/>
		<?php		
			exibeErros($erros['nome']);
		?>	
		                          
      </div>
    </div>
</div>

<div class="mws-button-row">
  <input type="submit" value="Inserir" class="mws-button red" />
  <input type="reset" value="Limpar" class="mws-button gray" />
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>
