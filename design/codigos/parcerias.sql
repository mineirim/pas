
--
-- TABLE: parcerias
-- 
--  

CREATE TABLE parcerias (
  id serial NOT NULL ,
  descricao character varying(200),
  situacao_id smallint NOT NULL  DEFAULT 1,
  objetivo_especifico_id int NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE parcerias ADD CONSTRAINT pk_parceria_id PRIMARY KEY (id);

CREATE INDEX parcerias_situacao_id_index  ON parcerias(situacao_id);

CREATE INDEX parcerias_objetivo_especifico_id_index  ON parcerias(objetivo_especifico_id);
ALTER TABLE parcerias ADD CONSTRAINT fk_meta_parceria FOREIGN KEY (meta_id) REFERENCES metas (id);
ALTER TABLE parcerias ADD CONSTRAINT fk_parcerias_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id) REFERENCES objetivos_especificos (id);
