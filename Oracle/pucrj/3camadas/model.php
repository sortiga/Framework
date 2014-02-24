<?php
include_once('connection.inc.php');
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
	private $_tipo_query;
	private $_table_name;
	private $_owner;
	private $_column;
	private $_restriction_type;
 

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
        $this->_id = AbstractDatabase::setId(null); 
   	    $this->_host = AbstractDatabase::setHost(null); 
        $this->_porta = AbstractDatabase::setPorta(null); 
		$this->_string_conexao = AbstractDatabase::setStringConexao(null);
		$this->_descricao = AbstractDatabase::setDescricao(null);
		$this->_idTipoDatabase = AbstractDatabase::setIdTipoDatabase(null);
		$this->_usuario = AbstractDatabase::setUsuario(null);
		$this->_senha = AbstractDatabase::setSenha(null);
		$this->_database = AbstractDatabase::setDatabase(null);
		$this->_schema = AbstractDatabase::setSchema(null);
		$this->_tipo_query = AbstractDatabase::setTipoQuery(null);
		$this->_table_name = AbstractDatabase::setTableName(null);
		$this->_owner = AbstractDatabase::setOwner(null);
		$this->_column = AbstractDatabase::setColumn(null);
		$this->_restriction_type = AbstractDatabase::setRestrictionType(null);
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
        $this->_id = $newId; 
    } 

    public function setHost($newHost){ 
        $this->_host = $newHost; 
    } 

    public function setPorta($newPorta){ 
        $this->_porta = $newPorta; 
    } 
 
    public function setStringConexao($newStringConexao){ 
        $this->_string_conexao = $newStringConexao; 
    } 

    public function setDescricao($newDescricao){ 
        $this->_descricao = $newDescricao; 
    } 

    public function setIdTipoDatabase($newIdTipoDatabase){ 
        $this->_idTipoDatabase = $newIdTipoDatabase; 
    } 

    public function setUsuario($newUsuario){ 
        $this->_usuario = $newUsuario; 
    } 

    public function setSenha($newSenha){ 
        $this->_senha = $newSenha; 
    } 
	
    public function setDatabase($newDatabase){ 
        $this->_database = $newDatabase; 
    } 

    public function setSchema($newSchema){ 
        $this->_schema = $newSchema; 
    } 
	
    public function SetTipoQuery($newTipoQuery){ 
        $this->_tipo_query = $newTipoQuery; 
    } 

    public function SetTableName($newTableName){ 
        $this->_table_name = $newTableName; 
    } 

    public function SetOwner($newOwner){ 
        $this->_owner = $newOwner; 
    } 

    public function SetColumn($newColumn){ 
        $this->_column = $newColumn; 
    } 
	
    public function SetRestrictionType($newRestType){ 
        $this->_restriction_type = $newRestType; 
    } 

	/*
	   DEFINIÇÃO DOS MÉTODOS GET
	*/
	
    public function getId(){ 
        return $this->_id; 
    } 

    public function getHost(){ 
        return $this->_host; 
    } 
 
    public function getPorta(){ 
        return $this->_porta; 
    } 

    public function getStringConexao(){ 
        return $this->_string_conexao; 
    } 
	
    public function getDescricao(){ 
        return $this->_descricao; 
    } 
	
	public function GetIdTipoDatabase() {
	    return $this->_idTipoDatabase;
	}
 
    public function GetUsuario(){ 
        Return $this->_usuario; 
    } 

    public function GetSenha(){ 
        Return $this->_senha; 
    } 
	
    public function GetDatabase(){ 
        Return $this->_database; 
    } 
	
    public function GetSchema(){ 
        Return $this->_schema; 
    } 

    public function GetTipoQuery(){ 
        Return $this->_tipo_query; 
    } 

    public function GetTableName(){ 
        Return $this->_table_name; 
    } 

    public function GetOwner(){ 
        Return $this->_owner; 
    } 

    public function GetColumn(){ 
        Return $this->_column; 
    }

    public function GetRestrictionType(){ 
        Return $this->_restriction_type; 
    } 

} 

//////////My Interface ///////// 
interface iDatabase 
{ 
 function Get_Database(AbstractDatabase $objDatabase); // Boolean 
    // public abstract function getCategoria(); // String 

} 

class DALDatabaseMySQL implements iDatabase
{
   public function Get_Database(AbstractDatabase $objDatabase)
   {
	   
	       $result= mysql_query("select * from catalogo_database_clientsite where idCatalogo_Database = ".$objDatabase->GetId());
           return $result; 
       }            			

   public function Get_Queries(AbstractDatabase $objDatabase)
   {
	         
	       $result= mysql_query("select * from catalogo_queries Where id_tipo_database = ".$objDatabase->GetIdTipoDatabase()." and id_tipo_query = ".$objDatabase->GetTipoQuery().";");
           return $result; 
       }            			

	   
}   

?>


