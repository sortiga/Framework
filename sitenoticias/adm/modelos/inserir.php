<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	mantemLogin();
	logado();
	adm();
	

	
if($_POST){

	extract($_POST);
	$erros = array();
	
	if($titulo == ""){
		$erros["titulo"] = "Campo obrigatorio.";	
	}
	if($data == ""){
		$erros["data"] = "Campo obrigatorio.";	
	}
	if($categoria_id == 0){
		$erros["categoria_id"] = "Campo obrigatorio.";	
	}
	if($texto == ""){
		$erros["texto"] = "Campo obrigatorio.";	
	}
	if($autor_id == 0){
		$erros["autor_id"] = "Campo obrigatorio.";	
	}
	
	//Validação da imagem
	if(is_uploaded_file($_FILES["imagem"]["tmp_name"])){
		//Pega a extenção da imagem
		$extensao = @strtolower(end(explode(".",$_FILES["imagem"]["name"])));
		// Valida as extensões permitidas.
		if($extensao != "jpg" && $extensao != "gif" && $extensao != "png"){
			$erros["imagem"] = "Extensão não permitida.";	
		}else{		
			$tamanho = 1024*1024*1; // 1mb 
			// Validar tamanho do arquivo
			if($_FILES["imagem"]["size"] > $tamanho){
				$erros["imagem"] = "Arquivo maior 1MB.";	
			}			
		}			
	}
	
	if($erros == null){	
	
		// usuario enviou uma imagem
		if(is_uploaded_file($_FILES["imagem"]["tmp_name"])){
			
			// Foto do passeio.JPG  --> foto_do_passeio.jpg
			$imagem = strtolower(str_replace(" ","_",$_FILES["imagem"]["name"]));
			$data = dataBD($data);
			$SQL = "INSERT INTO noticias VALUES(DEFAULT,'$titulo', '$data',$categoria_id,'$texto',$autor_id, '$imagem');";
			// echo $SQL;
			// exit;
			mysqli_query($conexao,$SQL);
			$id_noticia = mysqli_insert_id($conexao); //id da ultima inserção realizado
			
			// Cria a pasta Arquivos
			@mkdir("./arquivos", 0705);
			
			// Cria a pasta com o id do usuário
			$path = "./arquivos/$id_noticia";
			@mkdir($path, 0705);
			
			//Copia o arquivo da pasta temporaria para a pasta no sistema.
			$caminho = "./arquivos/$id_noticia/$imagem";
			copy($_FILES["imagem"]["tmp_name"],$caminho);			
			
		
		//usuario não enviou imagem
		}else{
			$data = dataBD($data);
			$SQL = "INSERT INTO noticias VALUES(DEFAULT,'$titulo', '$data',$categoria_id,'$texto',$autor_id, '');";
			// echo $SQL;
			// exit;
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
<div class="container">
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
        <input type="text" id ="titulo" name="titulo" value="<?=$titulo;?>" class="mws-textinput"/>
		<?php exibeErros($erros["titulo"]); ?>		
      </div>
    </div>

    <div class="mws-form-row">
      <label for="data">Data</label>
      <div class="mws-form-item large">
        <input type="text" id ="data" name="data" value="<?=$data;?>" class="mws-textinput"/>
		<?php exibeErros($erros["data"]); ?>		
      </div>
    </div>

    <div class="mws-form-row">
      <label for="categoria_id">Categoria</label>
      <div class="mws-form-item large">
        <select name="categoria_id">
          <option value="0">Selecione uma op&ccedil;&atilde;o</option>
		  <?php
			$SQL = "SELECT id, nome FROM categorias ORDER BY nome;";
			$resultado = mysqli_query($conexao,$SQL);
			while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				?> 
				<option value="<?=$id;?>" <?php marcaSelect($id, $categoria_id); ?>><?=$nome;?></option>
				<?php
			}		  
		  ?>
		
		  </select>
		  <?php exibeErros($erros["categoria_id"]); ?>
		
      </div>
    </div>

    <div class="mws-form-row">
      <label>Texto</label>
      <div class="mws-form-item large">
       <textarea name="texto" rows="100%" cols="100%"><?=$texto;?></textarea>
		<?php exibeErros($erros["texto"]); ?>
     </div>
   </div>

   <div class="mws-form-row">
    <label for="empresa_id">Autor</label>
    <div class="mws-form-item large">
      <select name="autor_id">
        <option value="0">Selecione uma op&ccedil;&atilde;o</option>
		  <?php
			$SQL = "SELECT id, nome FROM usuarios ORDER BY nome;";
			$resultado = mysqli_query($conexao,$SQL);
			while($linha = mysqli_fetch_array($resultado)){
				extract($linha);
				?> 
				<option value="<?=$id;?>" <?php marcaSelect($id, $autor_id); ?>><?=$nome;?></option>
				<?php
			}		  
		  ?>
                  
      </select>
	<?php exibeErros($erros["autor_id"]); ?>
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
</div>
<?php include("../rodape.php")?>