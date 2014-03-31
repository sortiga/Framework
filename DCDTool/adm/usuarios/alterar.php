<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	//adm();
	mantemLogin();
	
	if($_GET){
		extract($_GET);
		$SQL = "SELECT nome, email, tel_contato as telcontato, ramal, celular, senha, tipo, instituicao_id as idinst FROM usuario WHERE id = $id;";
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
		
		if($telcontato == ""){
			$erros['telcontato'] = "Campo obrigatório.";
		}

//		if($senha == ""){
//			$erros['senha'] = "Campo obrigatório.";
//		}
		
		
		if($erros == null){
		
			if($senha != ""){
				$SQL = "UPDATE usuario SET
					nome ='$nome',
					email = '$email',
					tel_contato = '$telcontato',
					senha = SHA1('$senha'),
					ramal = '$ramal',
                    tipo = $tipo,
					instituicao_id = $idinst,
					celular = '$celular' WHERE id =$usuario_id;";			
			}else{
					$SQL = "UPDATE usuario SET
					nome ='$nome',
					email = '$email',
					tel_contato = '$telcontato',
					ramal = '$ramal',
                    tipo = $tipo,
					instituicao_id = $idinst,
					celular = '$celular' WHERE id =$usuario_id;";			
			}		
			
			//echo $SQL;
            //exit;			
			$resultado = mysqli_query($conexao,$SQL);			
			if (!mysqli_query($resultado)) {
   			    $_SESSION['msg'] = "Usuário atualizado com sucesso.";
			    If ($_SESSION['user_id'] == $id){
     			    $_SESSION['user_tipo'] = $tipo;
					header("location: ../databases/index.php");
                } else {
   			        header("location: index.php");
                }					
            } else{
                $msg = "Erro: " . mysqli_error($conexao);
                $_SESSION['msg'] = "Falha na atualização do usuário: ".$msg;
				header("location: index.php");		
			}
            
			//echo $id;echo "<br>";
			//echo $_SESSION['user_id'];echo "<br>";
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

<?php
  if ($_SESSION['user_tipo'] == 1){    
?>  
   
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
		//echo $total;
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
		           <option value=<?=$id_inst;?> <?php marcaSelect($id_inst,$idinst);?>><?=$nm_inst;?></option> 
			<?  } else { ?>
		           <option value=<?=$id_inst;?> <?php marcaSelect($id_inst,$idinst);?>><?=$nm_inst;?></option> 			
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
<?php
  }    
?>     
   
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

<?php
  if ($_SESSION['user_tipo'] == 1){    
?>  
  
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
<?php
  }    
?>    
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
