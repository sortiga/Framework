<?php
$sql = "select * from siip_transicao_estados ";
$usuario = 'BASE_PCC';
$senha = 'infodes1';
$host = 'fgvrj16.fgv.br';
$porta = '1521';

try
{
  echo '<h3>Teste de conexão com servidor Oracle</h3>';
########### OCI
  echo '<h5>Tentando conectar ao servidor usando a extensão oci</h5>';
  if(!$con = oci_connect($usuario,$senha,"DES1G"))    //"$host:$porta"
  {
    $e = oci_error();
    throw new Exception("Erro ao conectar ao servidor usando a extensão OCI - " . $e['message']);
  }
  echo '<h4>Sucesso!</h4>';
  echo '<h5>Tentando executar instrução "' .$sql . ' usando a a extensão OCI"</h5>';
  if(!$stmt = oci_parse($con,$sql))
  {
    $e = oci_error($stmt);
    throw new Exception("Erro ao preparar consulta - " . $e['message']);
  }
  if(!oci_execute($stmt))
  {
    $e = oci_error($con);
    throw new Exception("Erro ao executar consulta - " . $e['message']);
  }
  echo '<h4>Sucesso!</h4>';
  if(oci_fetch_all($stmt,$results,0,-1,OCI_ASSOC+OCI_RETURN_NULLS)>0)
  {
    echo '<h5>Exibindo dados retornados pela extensão OCI"</h5>';
    echo "<table border='1'>\n";
    foreach($results as $row ) 
    {
      echo "<tr>\n";
      foreach ($row as $item) 
      {
        echo "    <td>".($item!==null?htmlentities($item, ENT_QUOTES):" ")."</td>\r\n";
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
    oci_close($con);

  }
  else
  {
    echo '<h5>A consulta não retornou dados.</h5>';
  }

########### PDO

  echo '<h5>Tentando conectar ao servidor usando PDO</h5>';
  try
  {
    //$pdo = new PDO("oci:dbname=//$host:$porta",$usuario,$senha);
	$pdo = new PDO("oci:dbname=DES1G",$usuario,$senha);
  }
  catch(PDOException $e) 
  {
    throw new Exception("Erro ao conectar ao servidor usando a extensão OCI - " . $e->getMessage());
  }
  echo '<h4>Sucesso!</h4>';
  echo '<h5>Tentando executar instrução "' .$sql . ' usando PDO"</h5>';
  if(!$stmt = $pdo->prepare($sql))
  {
    $e= $pdo->errorInfo();
    throw new Exception("Erro ao preparar consulta - " . $e[2]);
  }
  if(!$stmt->execute())
  {
    $e= $stmt->errorInfo();
    throw new Exception("Erro ao preparar consulta - " . $e[2]);
  }
  echo '<h4>Sucesso!</h4>';
  if($results = $stmt->fetchAll(PDO::FETCH_ASSOC))
  {
    echo '<h5>Exibindo dados retornados pela extensão PDO"</h5>';
    echo "<table border='1'>\n";
    foreach($results as $row ) 
    {
      echo "<tr>\n";
      foreach ($row as $item) 
      {
        echo "    <td>".($item!==null?htmlentities($item, ENT_QUOTES):" ")."</td>\r\n";
      }
      echo "</tr>\n";
    }
    echo "</table>\n";
  }
  else
  {
    echo '<h5>A consulta não retornou dados.</h5>';
  }

}
catch(Exception $e)
{
  die("ERRO! Detalhes => " . $e->getMessage());
}