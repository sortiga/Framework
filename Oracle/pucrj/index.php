<?php
include_once("config.php");

$oConexao = Conexao::getInstance();

//EX1
/*try{           
    //executa as instruções SQL
    $oConexao->exec("INSERT INTO clientes (nome,telefone,email) VALUES ('Rodrigo', '11-333-555', 'rodrigo@objota.com.br')");
    $oConexao->exec("INSERT INTO clientes (nome,telefone,email) VALUES ('Marcos', '55-555-888', 'marcos@mm.com.br')");
    $oConexao->exec("INSERT INTO clientes (nome,telefone,email) VALUES ('Maria', '11-888-9999', 'maria@maria.com.br')");
}catch (PDOException $e){
        //se houver exceção, exibe
        echo $e->getMessage();
}*/
//END EX1

//EX2
/*try{
    //executa uma instrução de consulta
    $result = $oConexao->query("SELECT * FROM clientes");
    if($result){
          //percorre os resultados via o laço foreach
           foreach($result as $item){
                  //exibe o resultado
                  echo "Nome: ".$item['nome'] . " - " . $item['telefone'] . $item['email'] ."<br>\n";
           }
    }
}catch (PDOException $e){         
        echo $e->getMessage();
}*/                                 
//END EX2

//EX3
try{
    //executa a instrução de consulta
    $result = $oConexao->query("SELECT * FROM clientes");
 
    if($result){
        //percorre os resultados via o fetch()
        while ($item = $result->fetch(PDO::FETCH_OBJ)){
            //exibe resultado
             echo "Nome: ".$item->nome. " - " . $item->telefone . $item->email . "<br>\n";
        }
    }
}catch (PDOException $e){
    echo $e->getMessage();
}
//END EX3

//EX4
/*
try{
    //executa a instrução de consulta 
	
    $oConexao->beginTransaction();
           
    $stmt = $oConexao->prepare("INSERT INTO clientes (nome,telefone,email) VALUES (?, ?, ?)");
    $stmt->bindValue(1, "Helio");
    $stmt->bindValue(2, "33-4444-5555");
    $stmt->bindValue(3, "helio@m.com.br");
    $stmt->execute();
    
    $oConexao->commit();
	
    
}catch (PDOException $e){
    $oConexao->rollBack();
    echo $e->getMessage();
}
*/
//END EX4
?>