<?php

function exibeErros($variavel){
	if(isset($variavel)){
		echo "<div class='error'>$variavel</div>";
		unset($variavel);	
	}
}

function exibeMSG($variavel){
	if(isset($variavel)){
		echo "<div class='msg'>$variavel</div>";
		unset($variavel);	
	}
}

function marcaSelect($var1, $var2){	
	if($var1 == $var2){
		echo "selected='selected'";	
	}
}

function logado(){
	if($_SESSION['autenticado'] != true){
		header("location: ../index.php");	
	}
}

function adm(){
	if($_SESSION['user_tipo'] != 1){
		header("location: ../index.php");	
	}
}
function mantemLogin(){
	if($_COOKIE['cookie'] == "1234"){
		$_SESSION['autenticado'] = true;
		$_SESSION['user_tipo'] = $_COOKIE['permissao'];		
	}
}

function dataBD($variavel){
	// 12/04/2014  -- > 2014-04-12
	$vetor = explode("/",$variavel);
	$data = $vetor[2]."-".$vetor[1]."-".$vetor[0];
	return $data;
}

function dataUser($variavel){
	//2014-04-12 --> 12/04/2014
	$vetor = explode("-",$variavel);
	$data = $vetor[2]."/".$vetor[1]."/".$vetor[0];
	return $data;
}


?>