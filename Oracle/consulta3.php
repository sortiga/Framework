<?php
/**
 * Description of ConsultaCliente
 *
 * @author Diego Campos
 */
 
require_once("SQL_Oracle.class.php");

	
	
Class MySqlDb
{
   Private $_con_str;
   Private $_user;
   Private $_pwd;
   
    function __construct()
    {
    }

    private function ConectaMySql($con_str,$user,$pwd) {
  
       
       Return $pdo;
    }

    private function ValidaDatabase($id_db) {
	   $servidor = 'localhost';
	   $usuario = 'root';
	   $banco = 'pucrj';
	   $pwd = 'zanfre';
       $con_str = "mysql:host=".$servidor.";dbname=".$banco;
	   
	   $pdo = new PDO($con_str, $user, $pwd);
	   
	   $database = new DatabaseMySql();
	   
	   If (!$database->ExisteDB) Then
	     Return False;
	   
	   
	   Return $pdo;
	}   
}	
	
 
Class GetModelos
{
    Private $_id_db;
	Public  $_resposta;

    function __construct($id)
    {
        $this->_id_db = $id;
		$this->_resposta = '';
    }
	
    public function Consulta()
    {
   	    set_time_limit(0); 
      		
		$database = new DatabaseMysql;
		$database->SetId($id);
		$database->GetDatabase();
		
		$usuario_db = $database->GetUsuario;
		$db = $database->GetDatabase;
		$pwd = $database->GetSenha;
		$idTpDb = $database->GetidTipoDatabase;
		
		
		
		$queries = new TipoDatabase;
		$tipodb->SetId($idTpDb);
		$IdTpDb = $tipodb->get
		
		
        $SQL_Oracle = new SQL_Oracle($db,$usuario_db,$pwd);
        $SQL_Oracle->Conectar();
 
        //Monta a query para verificar a quantidade de resultados
        $SQL_Oracle->Select = "SELECT COUNT(*) AS LINHAS ".
                              "  FROM ( ".
                              " select distinct owner, table_name from ( ".
                              " select owner, table_name, count(*) total from ( ".
                              " select owner, table_name, column_name ".
                              "   from all_cons_columns ".
                              "  where constraint_name in ".
                              "        (select constraint_name from all_constraints ".
                              "          where Constraint_Type in ('P','U') ".
                              "            and owner||table_name  in ".
                              "                (select distinct a.owner||a.TABLE_NAME  ".
                              "                   from ALL_CONSTRAINTS a ".
                              "                  where a.OWNER NOT IN ('SYS','SYSTEM','MDSYS','CTXSYS','OLAPSYS','SYSTEM','EXFSYS','SQLTXPLAIN','PERFSTAT','XDB','TRCANLZR') ".
                              "                  /* SELECIONA TABELAS QUE TENHAM CHAVE PRIM�RIA OU �NICA */ ".
                              "                    and a.Constraint_Type in ('P','U') ".
                              "                  /* E QUE POSSUEM CHAVE ESTRANGEIRA */ ".
                              "                    and a.table_name in ".
                              "                        (Select table_name from all_constraints where Constraint_Type = 'R') ".
                              "                 ) ".
                              "        ) ".
                              " ) ".
                              " group by owner, table_name ".
                              " ) ".
                              " where total > 1 ".
							  " ) ";					
 
        //Executa a query
        $SQL_Oracle->Select();
        OCIFetch($SQL_Oracle->resultado);
        $total = OCIResult($SQL_Oracle->resultado,'LINHAS');
		
		
		// Query principal 
        // -------------------------------------------------- 
 
        if($total>0)
        {
            //Monta a query com os resultados
            $SQL_Oracle->Select = " select distinct OWNER, TABLE_NAME from ( ".
                                  " select owner, table_name, count(*) total from ( ".
                                  " select owner, table_name, column_name ".
                                  "   from all_cons_columns ".
                                  "  where constraint_name in ".
                                  "        (select constraint_name from all_constraints ".
                                  "          where Constraint_Type in ('P','U') ".
                                  "            and owner||table_name  in ".
                                  "                (select distinct a.owner||a.TABLE_NAME  ".
                                  "                   from ALL_CONSTRAINTS a ".
                                  "                  where a.OWNER NOT IN ('SYS','SYSTEM','MDSYS','CTXSYS','OLAPSYS','SYSTEM','EXFSYS','SQLTXPLAIN','PERFSTAT','XDB','TRCANLZR') ".
                                  "                  /* SELECIONA TABELAS QUE TENHAM CHAVE PRIM�RIA OU �NICA */ ".
                                  "                    and a.Constraint_Type in ('P','U') ".
                                  "                  /* E QUE POSSUEM CHAVE ESTRANGEIRA */ ".
                                  "                    and a.table_name in ".
                                  "                        (Select table_name from all_constraints where Constraint_Type = 'R') ".
                                  "                 ) ".
                                  "        ) ".
                                  " ) ".
                                  " group by owner, table_name ".
                                  " ) ".
                                  " where total > 1 ";
 
            //Executa a query
            $SQL_Oracle->Select();
 
            //Exibe os resultados
			$this->_resposta = '';
            while (OCIFetch($SQL_Oracle->resultado))
            {
			    printf("%s => %s\n", ociresult($SQL_Oracle->resultado, 'OWNER'), ociresult($SQL_Oracle->resultado, 'TABLE_NAME'));
                /* $this->_resposta = $this->_resposta . OCIResult($SQL_Oracle->resultado,'owner') . OCIResult($SQL_Oracle->resultado,'table_name'); */
            }
        }
    }
}

$consulta = new GetModelos(1);
/* echo "<pre>Consulta: ", print_r($consulta, TRUE), "</pre>";  */
$consulta->Consulta();
echo $consulta->_resposta;
/* echo "<pre>Consulta: ", print_r($consulta, TRUE), "</pre>"; */  
 
?>
