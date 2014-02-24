<?php

abstract class AbstractDatabase 
{ 
    private $_id; 
	private $_host; 
    private $_porta;
    private $_string_conexao; 	
    private $_descricao;
	private $_idTipoDatabase;
	private $_usuario;
	private $_senha;
	private $_database;
	private $_schema;
 

/*    Public function __construct($id, $host, $porta, $string_conexao, $descricao, $idTipoDatabase, $usuario, $senha, $database, $schema){ 
        $this->setId($id); 
   	    $this->setHost($host); 
        $this->setPorta($porta); 
		$this->setStringConexao($string_conexao);
		$this->setDescricao($descricao);
		$this->setIdTipoDatabase($idTipoDatabase);
		$this->setUsuario($usuario);
		$this->setSenha($senha);
		$this->setDatabase($Database);
		$this->setSchema($schema);
    } */


    Public function __construct(){ 
        $this->$_id = setId(null); 
   	    $this->$_host = setHost(null); 
        $this->$_porta = setPorta(null); 
		$this->$_string_conexao = setStringConexao(null);
		$this->$_descricao = setDescricao(null);
		$this->$_idTipoDatabase = setIdTipoDatabase(null);
		$this->$_usuario = setUsuario(null);
		$this->$_senha = setSenha(null);
		$this->$_database = setDatabase(null);
		$this->$_schema = setSchema(null);
	}
	
/*    Public function __destruct(){ 
        $this->$id = null; 
   	    $this->$host = null; 
        $this->$porta = null; 
		$this->$string_conexao = null;
		$this->$descricao = null;
		$this->$idTipoDatabase = null;
        $this->$usuario = null; 
   	    $this->$senha = null; 
        $this->$database = null; 
		$this->$schema = null;
    } 
*/	
	/*
	   DEFINIÇÃO DOS MÉTODOS SET
	*/
    public function setId($newId){ 
        $this->$_id = $newId; 
    } 

    public function setHost($newHost){ 
        $this->$_host = $newHost; 
    } 

    public function setPorta($newPorta){ 
        $this->$_porta = $newPorta; 
    } 
 
    public function setStringConexao($newStringConexao){ 
        $this->$_string_conexao = $newStringConexao; 
    } 

    public function setDescricao($newDescricao){ 
        $this->$_descricao = $newDescricao; 
    } 

    public function setIdTipoDatabase($newIdTipoDatabase){ 
        $this->$_idTipoDatabase = $newIdTipoDatabase; 
    } 

    public function setUsuario($newUsuario){ 
        $this->$_usuario = $newUsuario; 
    } 

    public function setSenha($newSenha){ 
        $this->$_senha = $newSenha; 
    } 
	
    public function setDatabase($newDatabase){ 
        $this->$_database = $newDatabase; 
    } 

    public function setSchema($newSchema){ 
        $this->$_schema = $newSchema; 
    } 
	/*
	   DEFINIÇÃO DOS MÉTODOS GET
	*/
	
    public function getId(){ 
        return $this->$_id; 
    } 

    public function getHost(){ 
        return $this->$_host; 
    } 
 
    public function getPorta(){ 
        return $this->$_porta; 
    } 

    public function getStringConexao(){ 
        return $this->$_string_conexao; 
    } 
	
    public function getDescricao(){ 
        return $this->$_descricao; 
    } 
	
	public function GetIdTipoDatabase() {
	    return $this->$_idTipoDatabase;
	}
 
    public function GetUsuario(){ 
        Return $this->$_usuario; 
    } 

    public function GetSenha(){ 
        Return $this->$_senha; 
    } 
	
    public function GetDatabase(){ 
        Return $this->$_database; 
    } 
	
    public function GetSchema(){ 
        Return $this->$_schema; 
    } 

} 

//////////My Interface ///////// 
interface iDatabase 
{ 
 function Get_Database($oConexao,AbstractDatabase $objDatabase); // Boolean 
    // public abstract function getCategoria(); // String 

} 

class DALDatabaseMySQL implements iDatabase
{
   public function Get_Database($oConexao,AbstractDatabase $objDatabase)
   {
       try{
       //executa uma instrução de consulta
           $result = $oConexao->query("select * from catalogo_database_clientsite where idCatalogo_Database = ".$this->id);
           if($result){
                //percorre os resultados via o laço foreach
                foreach($result as $item){
                  //exibe o resultado
                  echo "Host: ".$item['Host'] . " - " . $item['porta'] . $item['descricao'] ."<br>\n";
                }
           }
       }
   	   catch (PDOException $e){         
            echo $e->getMessage();
       }            			
	}
   
}

?>


