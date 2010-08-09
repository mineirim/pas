
--
-- TABLE: metas_trimestres
-- 
--  

CREATE TABLE metas_trimestres (
  id serial NOT NULL ,
  programa_id integer NOT NULL ,
  projeto_id integer NOT NULL ,
  objetivo_especifico_id integer NOT NULL ,
  meta_id integer NOT NULL ,
  trimestre character varying NOT NULL ,
  percentual double NOT NULL  DEFAULT 0,
  avaliacao_descritiva character varying
);

-- 
ALTER TABLE metas_trimestres ADD CONSTRAINT pk_metas_trimestrais_id PRIMARY KEY (id);
ALTER TABLE metas_trimestres ADD CONSTRAINT  FOREIGN KEY () REFERENCES metas ();
