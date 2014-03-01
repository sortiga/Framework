<?php
session_start();
require_once("../../engine/conexao.php");
require_once("../../engine/funcoes.php");
logado();
if($_POST){

	extract($_POST);
	$erros = array();
	
	if($nome == ""){
		$erros["nome"] = "Campo obrigatorio.";	
	}
	if($email == ""){
		$erros["email"] = "Campo obrigatorio.";	
	}else{
		$vetor = explode("@",$email);
		if(count(explode(".",$vetor[1])) < 2){
			$erros["email"] = "Email invalido";
		}
	}
	if($texto == ""){
		$erros["texto"] = "Campo obrigatorio.";	
	}
	if($senha == ""){
		$erros["senha"] = "Campo obrigatorio.";	
	}
	//Validação da imagem
	if(is_uploaded_file($_FILES["imagem"]["tmp_name"])){
		//Pega a extenção da imagem
		$extensao = @strtolower(end(explode(".",$_FILES["imagem"]["name"])));
		// Valida as extensões permitidas.
		if($extensao != "jpg" && $extensao != "gif" && $extensao != "png"){
			$erros["imagem"] = "Extensão não permitida.";	
		}else{
		
			$tamanho = 900*1024; // 500KB 
			// Validar tamanho do arquivo
			if($_FILES["imagem"]["size"] > $tamanho){
				$erros["imagem"] = "Arquivo maior 500kb.";	
			}			
		}			
	}
	
	if($erros == null){	
	
		// usuario enviou uma imagem
		if(is_uploaded_file($_FILES["imagem"]["tmp_name"])){
			
			// Foto do passeio.JPG  --> foto_do_passeio.jpg
			$imagem = strtolower(str_replace(" ","_",$_FILES["imagem"]["name"]));
			
			$SQL = "INSERT INTO usuarios VALUES(DEFAULT,'$nome', '$email','$texto',SHA1('$senha'), '$imagem');";
			mysqli_query($conexao,$SQL) OR DIE(mysqli_error());
			$id_usuario = mysqli_insert_id($conexao); //id da ultima inserção realizado
			
			// Cria a pasta Arquivos
			@mkdir("./arquivos", 0705);
			
			// Cria a pasta com o id do usuário
			$path = "./arquivos/$id_usuario";
			@mkdir($path, 0705);
			
			//Copia o arquivo da pasta temporaria para a pasta no sistema.
			$caminho = "./arquivos/$id_usuario/$imagem";
			copy($_FILES["imagem"]["tmp_name"],$caminho);			
			
		
		//usuario não enviou imagem
		}else{
			$SQL = "INSERT INTO usuarios VALUES(DEFAULT,'$nome', '$email','$texto',SHA1('$senha'), '');";
			mysqli_query($conexao,$SQL) OR DIE(mysqli_error());
		}
		
		
		header("location: index.php");	
	}
}
include("../topo.php");
?>
<link type="text/css" href="../../engine/css/smoothness/jquery-ui-1.8.20.custom.css" rel="stylesheet" />
<script type="text/javascript" src="../../engine/js/jquery-ui-1.8.20.custom.min.js"></script>
<script type="text/javascript" src="../../engine/js/i18n/jquery.ui.datepicker-pt-BR.js"></script>
<script type="text/javascript">
<!--
$(function() {
  $("#data").datepicker($.datepicker.regional["pt-BR"]);
  $("#data").datepicker("option", "dateFormat", "dd/mm/yy"); 
});
-->
</script>
<form class="mws-form" action="" method="post" enctype="multipart/form-data">
  <div class="mws-panel grid_8">
   <div class="mws-panel-header">
    <span class="mws-i-24 i-list">Inserir Noticia</span>
  </div>
  <div class="mws-panel-body">
   <div class="mws-form-block">

    <div class="mws-form-row">
      <label for="titulo">Titulo</label>
      <div class="mws-form-item large">
        <input type="text" id ="titulo" name="titulo" value="" class="mws-textinput"/>
		<?php exibeErros($erros["titulo"]); ?>		
      </div>
    </div>

    <div class="mws-form-row">
      <label for="data">Data</label>
      <div class="mws-form-item large">
        <input type="text" id ="data" name="data" value="" class="mws-textinput"/>
		<?php exibeErros($erros["data"]); ?>		
      </div>
    </div>

    <div class="mws-form-row">
      <label for="empresa_id">Categoria</label>
      <div class="mws-form-item large">
        <select name="categoria_id">
          <option value="0">Selecione uma op&ccedil;&atilde;o</option>
		
		  </select>
		
      </div>
    </div>

    <div class="mws-form-row">
      <label>Texto</label>
      <div class="mws-form-item large">
       <textarea name="texto" rows="100%" cols="100%"></textarea>
	
     </div>
   </div>

   <div class="mws-form-row">
    <label for="empresa_id">Autor</label>
    <div class="mws-form-item large">
      <select name="autor_id">
        <option value="0">Selecione uma op&ccedil;&atilde;o</option>
                  
      </select>
	
    </div>
  </div>

  <div class="mws-form-row">
    <label for="imagem">Imagem - *<small style="color:red;">Tamanho 610 x 400 pixels</small> </label>
    <div class="mws-form-item large">
      <input type="file" id ="imagem" name="imagem" value="" class="mws-fileinput"/>
	 

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
<?php include("../rodape.php")?>