
--
-- TABLE: parceiros
-- 
--  

CREATE TABLE pas2011.parceiros (
  id serial NOT NULL ,
  nome character varying NOT NULL ,
  sigla character varying NOT NULL ,
  observacoes character varying NOT NULL 
);

-- 
ALTER TABLE pas2011.parceiros ADD CONSTRAINT pk_parceiros_id PRIMARY KEY (id);
