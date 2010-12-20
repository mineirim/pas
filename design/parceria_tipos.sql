
--
-- TABLE: parceria_tipos
-- 
--  

CREATE TABLE parceria_tipos (
  id serial NOT NULL ,
  parceria_id integer NOT NULL ,
  tipo_parceria_id integer NOT NULL ,
  inclusao_usuario_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now()
);
ALTER TABLE parceria_tipos ADD CONSTRAINT fk_tiposparcerias_tipo_parceria_id FOREIGN KEY (tipo_parceria_id) REFERENCES tipos_parcerias (id);
ALTER TABLE parceria_tipos ADD CONSTRAINT fk_tiposparcerias_parceria_id FOREIGN KEY (parceria_id) REFERENCES parcerias (id);
