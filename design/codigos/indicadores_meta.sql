
--
-- TABLE: indicadores_meta
-- 
--  

CREATE TABLE indicadores_meta (
  id serial NOT NULL ,
  meta_id integer NOT NULL ,
  indicador_id integer NOT NULL 
);

-- 
ALTER TABLE indicadores_meta ADD CONSTRAINT pk_indicadores_meta_id PRIMARY KEY (id);
ALTER TABLE indicadores_meta ADD CONSTRAINT pk_indicadores_meta_meta_id FOREIGN KEY (meta_id) REFERENCES metas (id);
ALTER TABLE indicadores_meta ADD CONSTRAINT pk_indicadores_meta_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores (id);
