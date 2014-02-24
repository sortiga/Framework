abstract class AbstractDatabase 
{ 
    private $id; 
	private $host; 
    private $porta;
    private $string_conexao; 	
    private $descricao;
	private $idTipoDatabase;
	private $usuario;
	private $senha;
	private $database;
	private $schema;
 
    Public function __construct($id, $host, $porta, $string_conexao, $descricao, $idTipoDatabase, $usuario, $senha, $database, $schema){ 
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
    } 

    Public function __destruct(){ 
        $this->$id = null; 
   	    $this->$host = null; 
        $this->$porta = null; 
		$this->$string_conexao = null;
		$this->$descricao = null;
		$this->$idTipoDatabase = null;
        $this->$usuario = null; 
   	    $this->$senha = null; 
        $this->$database = null; 
    } 


	
    public function setId($newId){ 
        $this->id = $newId; 
    } 

    public function setHost($newHost){ 
        $this->host = $newHost; 
    } 

    public function setPorta($newPorta){ 
        $this->porta = $newPorta; 
    } 
 
    public function setStringConexao($newStringConexao){ 
        $this->string_conexao = $newStringConexao; 
    } 
 
    public function getId(){ 
        return $this->id; 
    } 

    public function getHost(){ 
        return $this->host; 
    } 
 
    public function getPorta(){ 
        return $this->porta; 
    } 

    public function getStringConexao(){ 
        return $this->string_conexao; 
    } 
 
    public abstract function ObterDatabase($id_database); // Boolean 
    // public abstract function getCategoria(); // String 
} 

class Database extends AbstractDatabase{ 
    function __construct($id, $host, $porta, $string_conexao, $descricao, $idTipoDatabase, $usuario, $senha, $database, $schema){ 
        parent::__construct($id, $host, $porta, $string_conexao); 
    } 
	
    function __destruct(){ 
        parent::__destruct(); 
    } 
	
	function ObterDatabase($id_database) {
	    
		
		
		
		
	}
	
 
    // Foi declarada no AbstractFactory 
    public function ObterDatabase(){ 

  	   return true; 
    } 
 
} 


$database = New Database();
