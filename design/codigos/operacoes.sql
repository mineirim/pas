
--
-- TABLE: operacoes
-- 
--  

CREATE TABLE operacoes (
  id serial NOT NULL ,
  descricao character varying NOT NULL ,
  meta_id integer NOT NULL ,
  situacao_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usurio_id integer NOT NULL 
);
ALTER TABLE operacoes ADD CONSTRAINT fk_operacoes_meta_id FOREIGN KEY (meta_id) REFERENCES metas (id);
