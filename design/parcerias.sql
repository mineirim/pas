
--
-- TABLE: parcerias
-- 
--  

CREATE TABLE pas2011.parcerias (
  id serial NOT NULL ,
  objetivo_especifico_id int NOT NULL ,
  parceiro_id integer NOT NULL ,
  situacao_id smallint NOT NULL  DEFAULT 1,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE pas2011.parcerias ADD CONSTRAINT pk_parceria_id PRIMARY KEY (id);

ALTER TABLE pas2011.parcerias ADD CONSTRAINT fk_parceiro_parceiro_id FOREIGN KEY (parceiro_id) REFERENCES pas2011.parceiros (id);
ALTER TABLE pas2011.parcerias ADD CONSTRAINT fk_parcerias_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id) REFERENCES pas2011.objetivos_especificos (id);
