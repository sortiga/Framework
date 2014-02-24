abstract class AbstractTipoDatabase 
{ 
    private $id; 
	private $nome; 
    private $versao;
    private $descricao; 	
 
    function __construct($id, $nome, $versao, $descricao){ 
        $this->setId($id); 
   	    $this->setNome($nome); 
        $this->setVersao($versao); 
		$this->setDescricao($descricao);
    } 
 
    public function setId($newId){ 
        $this->id = $newId; 
    } 

    public function setNome($newNome){ 
        $this->nome = $newNome; 
    } 

    public function setVersao($newVersao){ 
        $this->versao = $newVersao; 
    } 
 
    public function setDescricao($newDescricao){ 
        $this->descricao = $newDescricao; 
    } 
 
    public function getId(){ 
        return $this->id; 
    } 

    public function getNome(){ 
        return $this->nome; 
    } 
 
    public function getVersao(){ 
        return $this->versao; 
    } 

    public function getDescricao(){ 
        return $this->descricao; 
    } 
 
    public abstract function ObterTipoDatabase(); // Boolean 
    // public abstract function getCategoria(); // String 
} 

class TipoDatabase extends AbstractTipoDatabase{ 
    function __construct($id, $nome, $versao, $descricao){ 
        parent::__construct($id, $nome, $versao, $descricao); 
    } 
 
    // Foi declarada no AbstractFactory 
    public function ObterTipoDatabase(){ 



  	   return true; 
    } 
 
    } 
