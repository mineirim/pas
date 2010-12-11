
--
-- TABLE: atividades_vinculadas
-- 
--  

CREATE TABLE atividades_vinculadas (
  id serial NOT NULL ,
  atividade_id integer NOT NULL ,
  depende_atividade_id integer NOT NULL ,
  justificativa character varying,
  observacoes character varying,
  is_pactuado boolean DEFAULT false,
  pacto_usuario_id integer,
  inclusao_data timestamp without time zone NOT NULL ,
  inclusao_usuario_id integer NOT NULL  DEFAULT now(),
  alteracao_data timestamp without time zone,
  alteracao_usuario_id integer
);

-- 
ALTER TABLE atividades_vinculadas ADD CONSTRAINT pk_vinculo_atividades_id PRIMARY KEY (id);
ALTER TABLE atividades_vinculadas ADD CONSTRAINT fk_atividade_dependente FOREIGN KEY (dependente_atividade_id) REFERENCES atividades (id);
ALTER TABLE atividades_vinculadas ADD CONSTRAINT fk_vinculo_atividade_atividade_id FOREIGN KEY (atividade_id) REFERENCES atividades (id);
ALTER TABLE atividades_vinculadas ADD CONSTRAINT fk_vinculo_atividades_depende_atividade_id FOREIGN KEY (depende_atividade_id) REFERENCES atividades (id);
