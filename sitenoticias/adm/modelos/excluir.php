<?php
session_start();
require_once("../../engine/conexao.php");
require_once("../../engine/funcoes.php");
logado();
usuario();
if($_GET){
	extract($_GET);
	
	$SQL = "SELECT imagem AS imagemAtual FROM noticias WHERE id = $id";
	$resultado = mysqli_query($conexao,$SQL);
	$linha = mysqli_fetch_array($resultado);
	extract($linha);
	
	@unlink("./arquivos/$id/$imagemAtual");
	//Apaga a pasta
	@rmdir("./arquivos/$id");
	
	$SQL = "DELETE FROM noticias WHERE id = $id;";
	mysqli_query($conexao,$SQL);
	header("location:index.php");
}
?>