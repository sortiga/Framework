USE [BASE_CUSTO]
GO
/****** Object:  StoredProcedure [dbo].[SP_GERA_RELCRIT2]    Script Date: 02/22/2014 12:42:35 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
	ALTER PROCEDURE [dbo].[SP_GERA_RELCRIT2]
     @DT_REFER   NVARCHAR(10),
     @ID_USER    INT,
     @ID_SERVICO INT,
     @RET        CHAR(1) OUTPUT 
AS
BEGIN
-- SET NOCOUNT ON added to prevent extra result sets from
    -- interfering with SELECT statements.
SET NOCOUNT ON;

declare @QUERY NVARCHAR(400);
declare @SQL   NVARCHAR(1000);
declare @SEVERIDADE NVARCHAR(10);
declare @DS_CRITICA NVARCHAR(400);
DECLARE @OBJETO NVARCHAR(400);
DECLARE @TOTAL INT = 0;
DECLARE @ParmDefinition nvarchar(500);
DECLARE @sSQL nvarchar(500);
DECLARE @ID_CRITICA INT ;
DECLARE @DT_CONVERT nvarchar(30);
DECLARE @TEM_ERRO_GRAVE char(1) = 'N'; 
DECLARE @ID_COMPOSICAO INT;
DECLARE @ID_COMP INT;
DECLARE @NIVEL_ANT INT; 
DECLARE @CD_COMPOSICAO NVARCHAR(10);
DECLARE @DESCRICAO NVARCHAR(MAX);
DECLARE @NIVEL INT;
DECLARE @STATUS INT;
        
        
DELETE FROM TAB_RELATORIO_CRITICA WHERE DT_REFERENCIA = CONVERT(DATE,@DT_REFER,103) AND ID_SERVICO = @ID_SERVICO;    

DECLARE C_CRITICAS CURSOR FOR
Select DS_CRITICA, SEVERIDADE_ERRO, SQL_CRITICA, OBJETO, ID_CRITICA
from TAB_CRITICA WHERE ID_CRITICA NOT IN (12,13)
ORDER BY ID_CRITICA;

DECLARE C_COMP_PRINC CURSOR FOR
Select DISTINCT ID_COMPOSICAO
from TAB_ESTRUTURA_COMPOSICAO WHERE TP_COMPONENTE = 'C';

DECLARE C_TEMP_DESATIVADAS CURSOR FOR
Select ID_COMPONENTE, CD_COMPONENTE, DESCRICAO, NIVEL, STATUS
from TAB_TEMP_DESATIVADAS;

OPEN C_CRITICAS;
FETCH NEXT FROM C_CRITICAS 
 INTO @DS_CRITICA, @SEVERIDADE, @QUERY, @OBJETO, @ID_CRITICA;

--PRINT 'INICIO ****************'
--BEGIN TRAN
WHILE @@FETCH_STATUS = 0
 BEGIN
    Set @DT_CONVERT = @dt_refer
    --print @DT_CONVERT
    set @DT_CONVERT = 'convert(date,''' + @DT_CONVERT + ''',103) '
    --print @DT_CONVERT
    set @QUERY = REPLACE(@QUERY,'@dt_refer',@DT_CONVERT)
    --print @query

    set @SQL = 'INSERT INTO TAB_RELATORIO_CRITICA ';
    set @SQL = @SQL + ' (CD_UF, ID_USUARIO, TS_GERACAO_RELATORIO, DT_REFERENCIA, CODIGO_OBJETO, ds_objeto, ID_OBJETO, TIPO, ID_ERRO, DS_ERRO, SEVERIDADE_ERRO, ID_SERVICO) ';
    set @SQL = @SQL + ' Select a.CD_UF, ' + CONVERT(nvarchar(20),@ID_USER) + ', SYSDATETIME(), ';
    set @SQL = @SQL + ' convert(date,''' + CONVERT(nvarchar(10),@dt_refer,103) + ''',103), '; 
    set @SQL = @SQL + ' a.CODIGO , a.DESCRICAO, a.ID, ''' + @OBJETO + ''', ' + CONVERT(nvarchar(20),@ID_CRITICA) + ', ''' + @DS_CRITICA + ''', ''' + @SEVERIDADE + ''', ' + @ID_SERVICO;
    set @SQL = @SQL + ' FROM (' + @QUERY + ') a';
  
    --         PRINT @SQL;
    EXEC(@SQL);
    FETCH NEXT FROM C_CRITICAS 
    INTO @DS_CRITICA, @SEVERIDADE, @QUERY, @OBJETO, @ID_CRITICA;
 END
 CLOSE C_CRITICAS;
 DEALLOCATE C_CRITICAS;
-- CRITICA DAS UFs
--PRINT 'UFS ****************'
 SET @DS_CRITICA = 'Menos de 27 estados na tabela de UF';

    Declare @TOT_UF as int
    select @TOT_UF = COUNT(*) from TAB_REGIAO Where CD_PAIS_REGIAO = 'BR' and CD_REG_REGIAO <> '--' and CD_UF_REGIAO <> '--' and CD_MUN_REGIAO = '---' and CD_BAIR_REGIAO = '---'
    If @TOT_UF < 27
    Begin
       set @SQL = 'INSERT INTO TAB_RELATORIO_CRITICA ';
       set @SQL = @SQL + ' (CD_UF, ID_USUARIO, TS_GERACAO_RELATORIO, DT_REFERENCIA, CODIGO_OBJETO, ds_objeto, ID_OBJETO, TIPO, ID_ERRO, DS_ERRO, SEVERIDADE_ERRO, ID_SERVICO) ';
       set @SQL = @SQL + ' values ( Null, ' + CONVERT(nvarchar(20),@ID_USER) + ', SYSDATETIME(), ';
       set @SQL = @SQL + ' convert(date,''' + CONVERT(nvarchar(10),@dt_refer,103) + ''',103), '; 
       set @SQL = @SQL + '''***,'''+ ''' Menos de 27 estados na tabela de UF ,''' +'0, ' + '''UF, ''' + CONVERT(nvarchar(20),12) + ', ''' + @DS_CRITICA + ''', ''' + @SEVERIDADE + ''', ' + @ID_SERVICO;
       set @SQL = @SQL + ' ) ';
                
       SET @TEM_ERRO_GRAVE = 'S' 
       --PRINT @SQL;
       EXEC (@SQL)
    End  

--PRINT 'DESATIVS ****************'   
-- CRITICA DAS COMPOSICOES DESATIVADAS
    SET @OBJETO = 'COMPOSIÇÃO'
    SET @ID_CRITICA = 13 
    SET @DS_CRITICA = 'COMPOSIÇÃO POSSUI AUXILIAR DESATIVADA.'
    SET @SEVERIDADE = 'GRAVE'
    --AQUI TROCAR PARA A TAB_COMPOSICAO

/* LOOP PRINCIPAL - PARA CADA COMPOSICAO QUE POSSUI AUXILIAR FAZ A VERIFICACAO */     
   OPEN C_COMP_PRINC;
   FETCH NEXT FROM C_COMP_PRINC 
    INTO @ID_COMP; 
   WHILE @@FETCH_STATUS = 0
     BEGIN
       /* RECUPERA A ESTRUTURA DA COMPOSICAO - APENAS COMPOSICOES AUXILIARES */
       TRUNCATE TABLE TAB_TEMP_DESATIVADAS;  -- LIMPA A TABELA DE TRABALHO
       TRUNCATE TABLE TAB_CRITICA_DESATIVADAS;
       -- MONTA A ESTRUTURA HIERARQUICA
       WITH rs AS (
            SELECT ID_COMPONENTE, CD_COMPONENTE, DESCRICAO, 0 AS lvl, CAST(0 AS varbinary(MAX)) AS sort_val
              FROM VIEW_ESTRUTURA_HIERARQUICA
             WHERE ID_COMPONENTE = @ID_COMP
             UNION ALL
            SELECT C.ID_COMPONENTE, C.CD_COMPONENTE, C.DESCRICAO, P.lvl + 1, CAST(P.sort_val + CAST(ROW_NUMBER() OVER(PARTITION BY C.ID_COMP_MASTER ORDER BY C.DESCRICAO, C.ID_COMPONENTE) AS binary(4)) AS varbinary(MAX))
              FROM rs AS P
               INNER JOIN VIEW_ESTRUTURA_HIERARQUICA AS C
                       ON C.ID_COMP_MASTER = P.ID_COMPONENTE
            )
       
       -- SALVA A ESTRUTURA HIERARQUICA NA TEMPORARIA
       INSERT INTO TAB_TEMP_DESATIVADAS(ID_COMPONENTE, CD_COMPONENTE, DESCRICAO,NIVEL, STATUS)
       SELECT rs.ID_COMPONENTE, rs.CD_COMPONENTE, rs.DESCRICAO, 
              rs.lvl as Nivel, z.STATUS
         FROM rs, TAB_COMPOSICAO_SRO z  
        Where rs.id_componente = z.Id_composicao   
        ORDER BY sort_val;

       -- GERA RELAÇÃO DE COMPOSIÇÕES AFETADAS POR AUXILIARES DESATIVADAS
       -- ATRAVÉS DA ANÁLISE DA ESTRUTURA HIERARQUICA 
       OPEN C_TEMP_DESATIVADAS;
       FETCH NEXT FROM C_TEMP_DESATIVADAS 
        INTO @ID_COMPOSICAO, @CD_COMPOSICAO, @DESCRICAO, @NIVEL, @STATUS
       
       -- INICIALIZA VARIAVEL USADA PARA CONTROLAR A QUEBRA DE NIVEL    
       SET @NIVEL_ANT = -1 
       -- LIMPA A FILA DAS COMPOSICOES AFETADAS PELA AUXILIAR DESATIVADA
       TRUNCATE TABLE TAB_FILA_DESATIVADAS;
       
       -- LOOP SECUNDÁRIO APLICADO APENAS À ESTRUTURA HIERARQUICA DA COMPOSIÇÃO ATUAL
       WHILE @@FETCH_STATUS = 0
         BEGIN
           -- SE LEU UM COMPONENTE COM STATUS DESATIVADO E O NIVEL FOR > 0 GRAVA SAIDA
           IF @STATUS IN (3,4) 
             BEGIN
               IF @NIVEL > 0
                 BEGIN
                   INSERT INTO TAB_CRITICA_DESATIVADAS (ID_COMPONENTE, CD_COMPONENTE, DESCRICAO, NIVEL)
                     SELECT ID_COMPONENTE, CD_COMPONENTE, DESCRICAO, NIVEL FROM TAB_FILA_DESATIVADAS;
                   DELETE FROM TAB_FILA_DESATIVADAS WHERE NIVEL > 0; 
                 END
             END
           ELSE
           -- SE O COMPONENTE NÃO ESTÁ DESATIVADO
             BEGIN
               -- SE ESTA DENTRO DO MESMO RAMO INSERE RAMO NA TABELA DA FILA
               IF NOT (@NIVEL < @NIVEL_ANT)
                 BEGIN
                   INSERT INTO TAB_FILA_DESATIVADAS(ID_COMPONENTE, CD_COMPONENTE, DESCRICAO, NIVEL)
                         VALUES (@ID_COMPOSICAO, @CD_COMPOSICAO, @DESCRICAO, @NIVEL)
                 END
               ELSE  
               -- SENAO LIMPA O RAMO DA FILA
                 BEGIN
                   DELETE FROM TAB_FILA_DESATIVADAS WHERE NIVEL >= @NIVEL;
                 END  
             END 
           SET @NIVEL_ANT = @NIVEL    
           FETCH NEXT FROM C_TEMP_DESATIVADAS 
            INTO @ID_COMPOSICAO, @CD_COMPOSICAO, @DESCRICAO, @NIVEL, @STATUS              
         END
       FETCH NEXT FROM C_COMP_PRINC 
        INTO @ID_COMP; 
     END    
     
    SELECT @TOTAL=COUNT(*) FROM TAB_CRITICA_DESATIVADAS;

    IF @TOTAL > 0
      BEGIN    
        SET @QUERY = 'SELECT NULL AS CD_UF, CD_COMPONENTE, DESCRICAO, ID_COMPONENTE AS ID FROM TAB_CRITICA_DESATIVADAS '

        set @SQL = 'INSERT INTO TAB_RELATORIO_CRITICA ';
        set @SQL = @SQL + ' (CD_UF, ID_USUARIO, TS_GERACAO_RELATORIO, DT_REFERENCIA, CODIGO_OBJETO, ds_objeto, ID_OBJETO, TIPO, ID_ERRO, DS_ERRO, SEVERIDADE_ERRO, ID_SERVICO) ';
        set @SQL = @SQL + ' Select a.CD_UF, ' + CONVERT(nvarchar(20),@ID_USER) + ', SYSDATETIME(), ';
        set @SQL = @SQL + ' convert(date,''' + CONVERT(nvarchar(10),@dt_refer,103) + ''',103), '; 
        set @SQL = @SQL + ' a.CODIGO , a.DESCRICAO, a.ID, ''' + @OBJETO + ''', ' + CONVERT(nvarchar(20),@ID_CRITICA) + ', ''' + @DS_CRITICA + ''', ''' + @SEVERIDADE + ''', ' + @ID_SERVICO;
        set @SQL = @SQL + ' FROM (' + @QUERY + ') a';

        EXEC(@SQL);
      END  
        
/*     
Para cada composicao que tem auxiliar faça
nivelant = -1
Le
Enquanto não acabou faça
  Se status in (3,4)
     Se nivel > 0 
        Insert into Tab_saida
        select * from TAB_FILA 
     fim se
  Senao      
    Se not (nivel < nivelant) 
      Insere codigo, descricao, ID, nivel em TAB_FILA
    senão
      delete from tab_fila where nivel > 0   
    fim se
  fim se
fim enquanto
delete from tab_fila
*/
   
--PRINT 'TIPO ERRO ****************'    
   DECLARE @TIPO_ERRO AS int           
   SELECT @TIPO_ERRO = COUNT(*) FROM TAB_RELATORIO_CRITICA WHERE severidade_erro = 'GRAVE'               
   
   IF @TIPO_ERRO > 0 
      SET @TEM_ERRO_GRAVE = 'S'
   ELSE
      SET @TEM_ERRO_GRAVE = 'N'        
-- CRITICA DOS COMPONENTES DAS FÓRMULAS
--COMMIT; --TRAN  
SET @RET = @TEM_ERRO_GRAVE   
END
