
--
-- TABLE: andamento
-- 
--  

CREATE TABLE andamento (
  id serial NOT NULL ,
  descricao character varying NOT NULL ,
  conceito character varying NOT NULL 
);

-- 
ALTER TABLE andamento ADD CONSTRAINT pk_andamento PRIMARY KEY (id);
