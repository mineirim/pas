
--
-- TABLE: metas
-- 
--  

CREATE TABLE metas (
  id serial NOT NULL ,
  descricao character varying(200),
  situacao_id int NOT NULL  DEFAULT 1,
  objetivo_especifico_id int,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE metas ADD CONSTRAINT pk_meta_id PRIMARY KEY (id);

CREATE INDEX metas_situacao_id_index  ON metas(situacao_id);

CREATE INDEX metas_objetivo_especifico_id_index  ON metas(objetivo_especifico_id);
ALTER TABLE metas ADD CONSTRAINT fk_objetivo_meta FOREIGN KEY (objetivo_id) REFERENCES undef (id);
ALTER TABLE metas ADD CONSTRAINT fk_metas_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id) REFERENCES objetivos_especificos (id);
