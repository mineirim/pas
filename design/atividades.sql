
--
-- TABLE: atividades
-- 
--  

CREATE TABLE atividades (
  id serial NOT NULL ,
  descricao character varying NOT NULL ,
  operacao_id integer NOT NULL ,
  peso integer DEFAULT 0,
  responsavel_id integer,
  situacao_id integer NOT NULL  DEFAULT 1,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer
);

-- 
ALTER TABLE atividades ADD CONSTRAINT pk_atividades_id PRIMARY KEY (id);
ALTER TABLE atividades ADD CONSTRAINT fk_atividades_operacao_id FOREIGN KEY (operacao_id) REFERENCES operacoes (id);
