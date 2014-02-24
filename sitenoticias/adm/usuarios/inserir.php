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
		
		if($email == ""){
			$erros['email'] = "Campo obrigatório.";
		}
		
		if($senha == ""){
			$erros['senha'] = "Campo obrigatório.";
		}
		
		if($tipo == 0){
			$erros['tipo'] = "Selecione uma opção.";
		}
		
		// Verifica se um arquivo foi enviado para a pasta temporária no servidor	
		if(is_uploaded_file($_FILES['imagem']['tmp_name'])){
			
			// Pega a extensão do arquivo e converte para minuscula
			$extensao = @strtolower(end(explode(".",$_FILES['imagem']['name'])));
			if($extensao != 'jpg' && $extensao != 'png' && $extensao != 'gif'){
				$erros['imagem'] = "Extensão não permitida.";
			}else{
				//Define o tamanho padrão do arquivo
				$tamanho = 1024*1024*1;
				//Compara o tamanho da imagem
				if($_FILES['imagem']['size'] > $tamanho){
					$erros['imagem'] = "Tamanho superior a 1MB.";
				}				
			}
		
		}
		
	
		if($erros == null){
		
		
			if(is_uploaded_file($_FILES['imagem']['tmp_name'])){
			
				$imagem = strtolower(str_replace(" ","_", $_FILES['imagem']['name']));
				$SQL = "INSERT INTO usuarios VALUES(DEFAULT,'$nome','$email','$texto',SHA1('$senha'),'$imagem',$tipo);";
				mysqli_query($conexao,$SQL);
				$id_usuario = mysqli_insert_id($conexao); //id da ultima inserção realizado
				
				// Cria a pasta Arquivos
				@mkdir("./arquivos", 0705);
				
				// Cria a pasta com o id do usuário
				$path = "./arquivos/$id_usuario";
				@mkdir($path, 0705);
				
				//Copia o arquivo da pasta temporaria para a pasta no sistema.
				$caminho = "./arquivos/$id_usuario/$imagem";
				copy($_FILES["imagem"]["tmp_name"],$caminho);
				
			
			}else{
				$SQL = "INSERT INTO usuarios VALUES(DEFAULT,'$nome','$email','$texto',SHA1('$senha'),'',$tipo);";
				mysqli_query($conexao,$SQL);			
			}		
			
			$_SESSION['msg'] = "Usuário inserido com sucesso.";
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
    <span class="mws-i-24 i-list">Inserir Usuario</span>
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

    <div class="mws-form-row">
      <label for="email">Email</label>
      <div class="mws-form-item large">
        <input type="text" id ="email" name="email" value="<?=$email;?>" class="mws-textinput"/>  
		 <?php		
			exibeErros($erros['email']);
		?>	                        
      </div>
    </div>                  

    <div class="mws-form-row">
      <label>Mini-Curriculo</label>
      <div class="mws-form-item large">
       <textarea name="texto" rows="100%" cols="100%"><?=$texto;?></textarea>
	 
     </div>
   </div>

   <div class="mws-form-row">
    <label for="senha">Senha</label>
    <div class="mws-form-item large">
      <input type="password" id ="senha" name="senha" value="" class="mws-textinput"/>
	   <?php		
			exibeErros($erros['senha']);

		?>	 
    </div>
  </div> 

  <div class="mws-form-row">
    <label for="imagem">Imagem</label>
    <div class="mws-form-item large">
      <input type="file" id ="imagem" name="imagem" value="" class="mws-fileinput"/>
	    <?php		
			exibeErros($erros['imagem']);
		?>	 
    </div>
  </div> 
  

  
    <div class="mws-form-row">
    <label for="imagem">Permissão</label>
    <div class="mws-form-item large">
     <select name="tipo">
		<option value="0">Selecione um tipo</option>
		<option value="1" <?php marcaSelect(1,$tipo);?>>Administrador</option> 
		<option value="2" <?php marcaSelect(2,$tipo);?>>Usuário</option>
	 </select>	 
		<?php		
			exibeErros($erros['tipo']);
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
