<?php

function exibeErros($variavel){
	if(isset($variavel)){
		echo "<div class='error'>$variavel</div>";
		unset($variavel);	
	}
}

//<DIV STYLE="background-color: #CC0000; position: absolute;
//left: 200px; top: 810px; height: 50px; width: 200px;">

function exibeMSG($variavel){
	if(isset($variavel)){
	    list($result, $resto) = explode(' ', $variavel, 2);
		If ($result == "Falha"){
		    echo "<div style='background-color: #CC0000; color: #FFF; font-size: 1.2em;' class='msg'>$variavel</div>";
		} else {
		    echo "<div style='background-color: #007FFF; color: #FFF; font-size: 1.2em;' class='msg'>$variavel</div>";
        }		
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
    // Aqui tem que mudar isso porque a diferença do ADM é que apenas ele pode cadastrar usuários
	if($_SESSION['user_tipo'] != 1){
		header("location: ../index.php");	
	}
}
function mantemLogin(){
    if (array_key_exists('cookie',$_COOKIE) AND $_COOKIE['cookie'] == '1234'){
	//if($_COOKIE['cookie'] == "1234"){
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

function get_post_action($name)
{
    $params = func_get_args();

    foreach ($params as $name) {
        if (isset($_POST[$name])) {
            return $name;
        }
    }
}
?>