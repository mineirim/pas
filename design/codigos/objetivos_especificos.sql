
--
-- TABLE: objetivos_especificos
-- 
--  

CREATE TABLE objetivos_especificos (
  id serial NOT NULL ,
  descricao character varying(200),
  menu character varying(30) NOT NULL ,
  recursos character varying,
  cronograma character varying,
  situacao_id smallint DEFAULT 1,
  projeto_id int NOT NULL ,
  ordem integer DEFAULT DEFAULT currval('acoes_id_seq'::regclass),
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE objetivos_especificos ADD CONSTRAINT pk_acao_id PRIMARY KEY (id);

CREATE INDEX objetivos_especificos_projeto_id_index  ON objetivos_especificos(projeto_id);
ALTER TABLE objetivos_especificos ADD CONSTRAINT fk_subprojeto_acao FOREIGN KEY (subprojeto_id) REFERENCES undef (id);
ALTER TABLE objetivos_especificos ADD CONSTRAINT fk_objetivos_especificos_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos (id);
