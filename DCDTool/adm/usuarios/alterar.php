<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	adm();
	mantemLogin();
	
	if($_GET){
		extract($_GET);
		$SQL = "SELECT * FROM usuarios WHERE id = $id;";
		$resultado = mysqli_query($conexao,$SQL);
		$linha = mysqli_fetch_array($resultado);
		extract($linha);	
	}
	
	
	if($_POST){
		extract($_POST);
		$erros = array();
		
		if($nome == ""){
			$erros['nome'] = "Campo obrigatório.";
		}
		
		if($email == ""){
			$erros['email'] = "Campo obrigatório.";
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
		
			//Se a imagem foi enviada...
			if(is_uploaded_file($_FILES['imagem']['tmp_name'])){			
				
				//Selecionei a imagem
				$SQL = "SELECT imagem FROM usuarios WHERE id = $usuario_id;";
				$resultado = mysqli_query($conexao,$SQL);
				$linha = mysqli_fetch_array($resultado);
				extract($linha);
				
				//Se exitir a imagem
				if($imagem != ""){
					// Apaga a imagem
					@unlink("./arquivos/$usuario_id/$imagem");			
				}

				@mkdir("./arquivos", 0705);
				@mkdir("./arquivos/$usuario_id", 0705);
				
				$imagem = strtolower(str_replace(" ","_",$_FILES["imagem"]["name"]));
				@copy($_FILES['imagem']['tmp_name'],"./arquivos/$usuario_id/$imagem");		
				
				
				if($senha != ""){
				$SQL = "UPDATE usuarios SET
					nome ='$nome',
					email = '$email',
					curriculo = '$texto',
					senha = SHA1('$senha'),
					imagem = '$imagem',
					tipo = $tipo WHERE id =$usuario_id;";			
				}else{
					$SQL = "UPDATE usuarios SET
						nome ='$nome',
						email = '$email',
						curriculo = '$texto',
						imagem = '$imagem',
						tipo = $tipo WHERE id = $usuario_id;";	
				}			
			}else{
			
				if($senha != ""){
				$SQL = "UPDATE usuarios SET
					nome ='$nome',
					email = '$email',
					curriculo = '$texto',
					senha = SHA1('$senha'),
					tipo = $tipo WHERE id =$usuario_id;";			
				}else{
					$SQL = "UPDATE usuarios SET
					nome ='$nome',
					email = '$email',
					curriculo = '$texto',
					tipo = $tipo WHERE id = $usuario_id;";	
				}		
			
			}
			
				
			mysqli_query($conexao,$SQL);
			$_SESSION['msg'] = "Usuário alterado com sucesso.";
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
    <span class="mws-i-24 i-list">Alterar Usuario</span>
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
       <textarea name="texto" rows="100%" cols="100%"><?=$curriculo;?></textarea>
	 
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
	<image src="./arquivos/<?=$id?>/<?=$Imagem;?>" alt="<?=$nome?>" Width="400px"/>
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
  <input type="submit" value="Alterar" class="mws-button red" />
  <input type="reset" value="Limpar" class="mws-button gray" />
  <input type="hidden" name="usuario_id" value="<?=$id;?>"/>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>
