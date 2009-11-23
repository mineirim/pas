
--
-- TABLE: atividades_vinculadas
-- 
--  

CREATE TABLE atividades_vinculadas (
  id serial NOT NULL ,
  atividade_id integer NOT NULL ,
  depende_atividade_id integer NOT NULL ,
  observacoes character varying NOT NULL ,
  justificativa character varying NOT NULL 
);

-- 
ALTER TABLE atividades_vinculadas ADD CONSTRAINT pk_vinculo_atividades_id PRIMARY KEY (id);
ALTER TABLE atividades_vinculadas ADD CONSTRAINT fk_vinculo_atividades_depende_atividade_id FOREIGN KEY (depende_atividade_id) REFERENCES atividades (id);
ALTER TABLE atividades_vinculadas ADD CONSTRAINT fk_vinculo_atividade_atividade_id FOREIGN KEY (atividade_id) REFERENCES atividades (id);
