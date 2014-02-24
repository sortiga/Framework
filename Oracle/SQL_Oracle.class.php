<?php
 
/**
 * Description of SQL_Oracle
 *
 * @author Diego Campos
 */
 
class SQL_Oracle
{
    private $ora_servidor;      // Servidor Oracle
    private $ora_user;           // Usuario do banco
    private $ora_senha;        // Senha do banco
    private $ora_conecta;	   //identificador de conex�o
    public $resultado;
 
    //Variaveis do m�todo Select
    public $Select;
    public $ErroSelect;
 
    //Variaveis do m�todo deletar
    public $Delete;
    public $ConfirmaDelete;
    public $ErroDelete;
 
    //Variaveis do m�todo Inserir
    public $Insert;
    public $ConfirmaInsert;
    public $ErroInsert;
 
    //Variaveis do m�todo Update
    public $Update;
    public $ConfirmaUpdate;
    public $ErroUpdate;
 
//Construtor
    function __construct($server,$user,$senha)
    {
        //Define os dados de conex�o ao banco de dados
        $this->ora_servidor = $server;
        $this->ora_user = $user;
        $this->ora_senha = $senha;
    }
 
    //Conecta ao Bando de Dados
    public function Conectar()
    {
        $this->ora_conecta = ocilogon($this->ora_user,$this->ora_senha,$this->ora_servidor);
        if(!$this->ora_conecta) {
            echo "<p>N�o foi poss�vel conectar-se ao servidor Oracle.</p>\n";
                 "<p><strong>Erro Oracle: " . OCIError() . "</strong></p>\n";
                 exit();
        }
    }
 
    //Selecionar dados
    public function Select()
    {
        try
        {
            //OCIParse an�lisa a �consulta� (identificador de conex�o, meuSQL)
            $this->resultado = OCIParse($this->ora_conecta, $this->Select);
            if(OCIExecute($this->resultado))
            {
                return $this->resultado;
            }
            else
            {
                $erro_select = ("<p>Erro Oracle: " . OCIError() . "</p>");
                throw new Exception($erro_select); //Msg de Erro
            }
        }
        catch (Exception $excecao)
        {
            //Exibe a msg de erro
            echo $excecao->getMessage();
        }
    }
 
    //Deletar dados
    public function Deletar()
    {
        //Tenta Deletar, sen�o exibe msg de erro personalizada
        try
        {
            $this->resultado = OCIParse($this->ora_conecta, $this->Delete);
            if(OCIExecute($this->resultado))
            {
                return $this->resultado;
            }
            else
            {
                //$this->ErroDelete = ("<p>Erro Oracle: " . OCIError() . "</p>");
                throw new Exception($this->ErroDelete); //Msg de Erro
            }
        }
        catch (Exception $excecao)
        {
            echo $excecao->getMessage();
        }
    }
 
    //Inserir dados
    public function Inserir()
    {
 
        //Tenta Inserir, sen�o exibe msg de erro personalizada
        try
        {
            $this->Insert;
            $this->ora_conecta;
            $this->resultado = OCIParse($this->ora_conecta, $this->Insert);
            if(OCIExecute($this->resultado))
            {
                return $this->resultado;
            }
            else
            {
                $this->ErroInsert = ("<p>Erro Oracle: " . OCIError() . "</p>");
                //throw new Exception($this->ErroInsert); //Msg de Erro
            }
        }
        catch (Exception $excecao)
        {
            echo $excecao->getMessage();
        }
    }
 
    //Atualziar dados
    public function Update()
    {
       //Tenta Inserir, sen�o exibe msg de erro personalizada
        try
        {
            $this->resultado = OCIParse($this->ora_conecta, $this->Update);
            if(OCIExecute($this->resultado))
            {
                return $this->resultado;
            }
            else
            {
                //$this->ErroUpdate = ("<p>Erro Oracle: " . OCIError() . "</p>");
                throw new Exception($this->ErroUpdate); //Msg de Erro
            }
        }
        catch (Exception $excecao)
        {
            echo $excecao->getMessage();
        }
    }
 
    //Desconecta do banco de dados
    public function Desconectar()
    {
        return ocilogoff($this->ora_conecta);
    }

}	
?>