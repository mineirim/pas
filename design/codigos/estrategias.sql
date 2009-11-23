
--
-- TABLE: estrategias
-- 
--  

CREATE TABLE estrategias (
  id serial NOT NULL ,
  descricao character varying(200),
  situacao_id smallint NOT NULL  DEFAULT 1,
  objetivo_especifico_id integer,
  objetivo_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE estrategias ADD CONSTRAINT pk_estrategia_id PRIMARY KEY (id);

CREATE INDEX estrategias_situacao_id_index  ON estrategias(situacao_id);

CREATE INDEX estrategias_objetivo_id_index  ON estrategias(objetivo_id);
ALTER TABLE estrategias ADD CONSTRAINT fk_objetivo_estrategia FOREIGN KEY (objetivo_id) REFERENCES undef (id);
ALTER TABLE estrategias ADD CONSTRAINT fk_estrategias_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id) REFERENCES objetivos_especificos (id);
