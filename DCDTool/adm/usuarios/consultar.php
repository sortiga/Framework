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
		
		$SQL = "SELECT nome, email, tel_contato as telcontato, ramal, celular, senha, tipo, instituicao_id as idinst FROM usuario WHERE id = $id;";
		//echo "SQL = $SQL";
		//exit;
		$resultado = mysqli_query($conexao,$SQL);
		$linha = mysqli_fetch_array($resultado);
	    //echo "<pre>";
		//print_r($linha);
		//echo "</pre>";
		//extract($_GET);
		//echo "ID = $id";
		//exit;
		extract($linha);	
	}
	
	include_once("../topo.php");
?>
<!-- Inner Container Start -->
<div class="container">
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Consultar Usuário</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
    <label for="imagem">Instituição</label>
    <div class="mws-form-item large">
     <select name="idinst" disabled="disabled">
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
			echo "Tabela de Instituições está VAZIA!!!";		
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
    </div>
    </div>
   
    <div class="mws-form-row">
      <label for="nome">Nome</label>
      <div class="mws-form-item large">
        <input type="text" id ="nome" name="nome" value="<?=$nome;?>" class="mws-textinput" disabled="disabled"/>
      </div>
    </div>

    <div class="mws-form-row">
      <label for="email">Email</label>
      <div class="mws-form-item large">
        <input type="text" id ="email" name="email" value="<?=$email;?>" class="mws-textinput" disabled="disabled"/>  
      </div>
    </div>                  

    <div class="mws-form-row">
      <label for="email">Telefone de Contato</label>
      <div class="mws-form-item large">
        <input type="text" id ="telcontato" name="telcontato" value="<?=$telcontato;?>" class="mws-textinput" disabled="disabled"/>  
      </div>
    </div>                  


    <div class="mws-form-row">
      <label for="email">Ramal</label>
      <div class="mws-form-item large">
        <input type="text" id ="ramal" name="ramal" value="<?=$ramal;?>" class="mws-textinput" disabled="disabled"/>  
      </div>
    </div>                  

    <div class="mws-form-row">
      <label for="email">Celular</label>
      <div class="mws-form-item large">
        <input type="text" id ="celular" name="celular" value="<?=$celular;?>" class="mws-textinput" disabled="disabled"/>  
      </div>
    </div>                  
		
    <div class="mws-form-row">
    <label for="imagem">Permissão</label>
    <div class="mws-form-item large">
     <select name="tipo" disabled="disabled">
		<option value="0">Selecione um tipo</option>
		<option value="1" <?php marcaSelect(1,$tipo);?>>Administrador</option> 
		<option value="2" <?php marcaSelect(2,$tipo);?>>Usuário</option>
	 </select>	 
    </div>
  </div>
</div>
</div>     
</div>
</form>    
</div>
<?php
	include_once("../rodape.php");
?>
