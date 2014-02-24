<?php
/**
 * Description of ConsultaCliente
 *
 * @author Diego Campos
 */
 
 try
{
 require_once("consulta.class.php");
 
 $consulta = new ConsultaCliente;
 
 
 echo "<pre>Consulta: </pre>";  
 $consulta->Consulta("CR");
 echo "<pre>Consulta: ", print_r($consulta, TRUE), "</pre>";  

}

 
?>