<?php
	session_start();
	require_once("../../engine/conexao.php");
	require_once("../../engine/funcoes.php");
	logado();
	adm();
	mantemLogin();
	
	if($_GET){
		extract($_GET);
		if(is_numeric($id)){
			//Verifica se existe a imagem no diretorio.
			$SQL = "SELECT imagem FROM usuarios WHERE id = $id;";
			$resultado = mysqli_query($conexao,$SQL);
			$linha = mysqli_fetch_array($resultado);
			extract($linha);
			
			//Se exitir a imagem
			if($imagem != ""){
				// Apaga a imagem
				@unlink("./arquivos/$id/$imagem");			
				// Apaga o diretório com o id do usuário
				@rmdir("./arquivos/$id");
			}			
			
			$SQL = "DELETE FROM usuarios WHERE id = $id"; 
			mysqli_query($conexao,$SQL);
			$_SESSION['msg'] = "Usuário excluido com sucesso.";
			header("location:index.php");
		}else{
			header("location: index.php");
		}
	}
	
	





?>