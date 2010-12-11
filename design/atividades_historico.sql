
--
-- TABLE: atividades_historico
-- 
--  

CREATE TABLE atividades_historico (
  id serial NOT NULL ,
  atividade_id integer NOT NULL ,
  data_inicio date NOT NULL ,
  data_prazo date NOT NULL ,
  data_conclusao date NOT NULL ,
  andamento_id integer NOT NULL  DEFAULT 1,
  avaliacao character varying NOT NULL ,
  percentual integer NOT NULL , -- f
  situacao_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL ,
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE atividades_historico ADD CONSTRAINT pk_atividades_historico PRIMARY KEY (id);
ALTER TABLE atividades_historico ADD CONSTRAINT fk_andamento_atividade FOREIGN KEY (andamento) REFERENCES andamento (id);
ALTER TABLE atividades_historico ADD CONSTRAINT fk_atividade_historico FOREIGN KEY (atividade_id) REFERENCES atividades (id);
