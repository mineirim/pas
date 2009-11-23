
--
-- TABLE: tipos_periodos
-- 
--  

CREATE TABLE tipos_periodos (
  id serial NOT NULL ,
  periodo character varying NOT NULL ,
  descricao character varying NOT NULL 
);

-- 
ALTER TABLE tipos_periodos ADD CONSTRAINT pk_tipo_periodo_id PRIMARY KEY (id);
