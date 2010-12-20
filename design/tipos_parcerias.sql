
--
-- TABLE: tipos_parcerias
-- 
--  

CREATE TABLE tipos_parcerias (
  id serial NOT NULL ,
  descricao character varying NOT NULL ,
  conceito character varying NOT NULL 
);

-- 
ALTER TABLE tipos_parcerias ADD CONSTRAINT pk_tipoparcerias_id PRIMARY KEY (id);
