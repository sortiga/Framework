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
		
		if($telcontato == ""){
			$erros['telcontato'] = "Campo obrigatório.";
		}

		if($senha == ""){
			$erros['senha'] = "Campo obrigatório.";
		}
		
		if($idinst == 0){
			$erros['idinst'] = "Selecione uma opção.";
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
				$SQL = "INSERT INTO usuario VALUES(DEFAULT,'$nome','$email','$telcontato',$ramal,$celular,$idinst,SHA1('$senha'),$tipo);";
				$resultado = mysqli_query($conexao,$SQL);			
				if (!mysqli_query($resultado)) {
                   $msg = "Erro: " . mysqli_error($conexao);
				   $_SESSION['msg'] = "Usuário inserido com sucesso.";
                } else{
                   $_SESSION['msg'] = "Falha na inserção do novo usuário: ".$msg;
				}
			}		
			header("location: index.php");		
		}
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<?php
   if (!isset($idinst)){
      $idinst = null;
	}
   if (!isset($nome)){
      $nome = null;
	}
   if (!isset($email)){
      $email = null;
	}
   if (!isset($telcontato)){
      $telcontato = null;
	}
   if (!isset($celular)){
      $celular = null;
	}
   if (!isset($ramal)){
      $ramal = null;
	}
   if (!isset($senha)){
      $senha = null;
	}
   if (!isset($tipo)){
      $tipo = 1;
	}
?>			                          
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Inserir Usuario</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

  
    <div class="mws-form-row">
    <label for="imagem">Instituição</label>
    <div class="mws-form-item large">
     <select name="idinst">
		<option value="0">Selecione uma instituição</option>
		<?
		//Colocar aqui o código para carregar as opções 
   	    $SQL = "SELECT id as id_inst, nome as nm_inst FROM instituicao order by id;";
		//echo $SQL;
		//echo "<br>";
		//exit;
 	    $resultado = mysqli_query($conexao,$SQL);
		$total = mysqli_num_rows($resultado);
		echo $total;
		//exit;
		if($total == 0){
			echo "Tabela das Instituições está VAZIA!!!";		
		}else{
   		    while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				//echo "ID ".$id_database;echo "<br>";
				//echo "Tipo ".$tipodb;echo "<br>";
				//exit;
				if ($id_inst == $idinst) { 
        ?>
		           <option value=<?=$id_inst;?> selected><?=$nm_inst;?></option>
			<?  } else { ?>
		           <option value=<?=$id_inst;?>><?=$nm_inst;?></option>
			<?  } 
            }
		}	
		?>
	 </select>	 
		<?php		
          if (isset($erros['idinst'])){
			exibeErros($erros['idinst']);
		  }	
		?>
    </div>
    </div>

	
    <div class="mws-form-row">
      <label for="nome">Nome</label>
      <div class="mws-form-item large">
        <input type="text" id ="nome" name="nome" value="<?=$nome;?>" class="mws-textinput"/>
		<?php		
          if (isset($erros['nome'])){
			exibeErros($erros['nome']);
		  }	
		?>	
		                          
      </div>
    </div>

    <div class="mws-form-row">
      <label for="email">Email</label>
      <div class="mws-form-item large">
        <input type="text" id ="email" name="email" value="<?=$email;?>" class="mws-textinput"/>  
		 <?php		
          if (isset($erros['email'])){
			exibeErros($erros['email']);
		  }	
		?>	                        
      </div>
    </div>                  

    <div class="mws-form-row">
      <label for="email">Telefone de Contato</label>
      <div class="mws-form-item large">
        <input type="text" id ="telcontato" name="telcontato" value="<?=$telcontato;?>" class="mws-textinput"/>  
		 <?php		
          if (isset($erros['telcontato'])){
			exibeErros($erros['telcontato']);
		  }	
		?>	                        
      </div>
    </div>                  


    <div class="mws-form-row">
      <label for="email">Ramal</label>
      <div class="mws-form-item large">
        <input type="text" id ="ramal" name="ramal" value="<?=$ramal;?>" class="mws-textinput"/>  
		 <?php		
          if (isset($erros['ramal'])){
			exibeErros($erros['ramal']);
		  }	
		?>	                        
      </div>
    </div>                  

    <div class="mws-form-row">
      <label for="email">Celular</label>
      <div class="mws-form-item large">
        <input type="text" id ="celular" name="celular" value="<?=$celular;?>" class="mws-textinput"/>  
		 <?php		
          if (isset($erros['celular'])){
			exibeErros($erros['celular']);
		  }	
		?>	                        
      </div>
    </div>                  
		
   <div class="mws-form-row">
    <label for="senha">Senha</label>
    <div class="mws-form-item large">
      <input type="password" id ="senha" name="senha" value="" class="mws-textinput"/>
	   <?php		
          if (isset($erros['senha'])){
			exibeErros($erros['senha']);
		  }	
		?>	 
    </div>
  </div> 

  <div class="mws-form-row">
    <label for="imagem">Imagem</label>
    <div class="mws-form-item large">
      <input type="file" id ="imagem" name="imagem" value="" class="mws-fileinput"/>
	    <?php		
          if (isset($erros['imagem'])){
			exibeErros($erros['imagem']);
		  }	
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
          if (isset($erros['tipo'])){
			exibeErros($erros['tipo']);
		  }	
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
