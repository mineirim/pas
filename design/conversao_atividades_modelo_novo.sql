
insert into pas2011.atividades  (id ,
  descricao ,
  operacao_id ,
  peso ,
  situacao_id ,
  inclusao_data ,
  inclusao_usuario_id ,
  alteracao_data ,
  alteracao_usuario_id 
)

SELECT 
  atividades_bkp.id, 
  atividades_bkp.descricao, 
  atividades_bkp.operacao_id, 
  atividades_bkp.valor, 
    atividades_bkp.situacao_id, 
  atividades_bkp.inclusao_data, 
  atividades_bkp.inclusao_usuario_id, 
  atividades_bkp.alteracao_data, 
  atividades_bkp.alteracao_usuario_id
FROM 
  pas2011.atividades_bkp;



insert into pas2011.atividades_historico
(
  atividade_id ,
  data_inicio ,
  data_prazo ,
  data_conclusao,
  situacao_id,
  responsavel_id,
  inclusao_data,
  inclusao_usuario_id ,
  alteracao_data ,
  alteracao_usuario_id 
)
SELECT 
  atividades_bkp.id, 
  atividades_bkp.inicio_data, 
  atividades_bkp.prazo_data, 
  atividades_bkp.conclusao_data, 
  atividades_bkp.situacao_id, 
  atividades_bkp.inclusao_usuario_id,
  atividades_bkp.inclusao_data, 
  atividades_bkp.inclusao_usuario_id, 
  atividades_bkp.alteracao_data, 
  atividades_bkp.alteracao_usuario_id
FROM 
  pas2011.atividades_bkp;
