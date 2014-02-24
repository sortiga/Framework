<?php
/**
 * Description of ConsultaCliente
 *
 * @author Diego Campos
 */
 
require_once("SQL_Oracle.class.php");
 
Class ConsultaCliente
{
    Private $_id;
	Private $_resposta;

    public function __construct($id)
    {
        $this->_id = $id;
		$this->_resposta; 
    }
    public function Consulta()
    {
        $SQL_Oracle = new SQL_Oracle;
        $SQL_Oracle->Conectar();
 
        //Monta a query para verificar a quantidade de resultados
        $SQL_Oracle->Select = "SELECT COUNT(*) AS LINHAS ".
                                "FROM SIIP_DOMINIO_ESTADOS ";
 
        //Executa a query
        $SQL_Oracle->Select();
        OCIFetch($SQL_Oracle->resultado);
        $total = OCIResult($SQL_Oracle->resultado,'LINHAS');
 
        if($total>0)
        {
            //Monta a query com os resultados
            $SQL_Oracle->Select = "SELECT CD_ESTADO, DS_ESTADO ".
                                    "FROM SIIP_DOMINIO_ESTADOS ".
                                    "WHERE CD_ESTADO='$this->_id' ".
                                    "ORDER BY nr_seq_ordem_estado";
 
            //Executa a query
            $SQL_Oracle->Select();
 
            //Exibe os resultados
            while (OCIFetch($SQL_Oracle->resultado))
            {
                OCIResult($SQL_Oracle->resultado,'DS_ESTADO');
				$this->_resposta = $SQL_Oracle->resultado;
            }
        }
    }
}

?>
