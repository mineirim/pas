
--
-- TABLE: parceiros
-- 
--  

CREATE TABLE parceiros (
  id serial NOT NULL ,
  nome character varying NOT NULL ,
  sigla character varying NOT NULL ,
  observacoes character varying NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone,
  alteracao_usuario_id integer
);

-- 
ALTER TABLE parceiros ADD CONSTRAINT pk_parceiros_id PRIMARY KEY (id);
