
--
-- TABLE: interfaces
-- 
--  

CREATE TABLE pas2011.interfaces (
  id serial NOT NULL ,
  objetivo_especifico_id integer NOT NULL ,
  setor_id integer NOT NULL ,
  situacao_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone,
  alteracao_usuario_id integer NOT NULL 
);
ALTER TABLE pas2011.interfaces ADD CONSTRAINT fk_interface_setor_id FOREIGN KEY (setor_id) REFERENCES setores (id);
ALTER TABLE pas2011.interfaces ADD CONSTRAINT fk_objetivo_especifico_interface FOREIGN KEY (objetivo_especifico_id) REFERENCES pas2011.objetivos_especificos (id);
