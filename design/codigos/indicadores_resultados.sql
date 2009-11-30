
--
-- TABLE: indicadores_resultados
-- 
--  

CREATE TABLE indicadores_resultados (
  id serial NOT NULL ,
  indicador_configuracao_id integer NOT NULL ,
  competencia integer NOT NULL ,
  numerador float NOT NULL ,
  denominador float NOT NULL ,
  resultado float NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE indicadores_resultados ADD CONSTRAINT pk_indicadores_resultados_id PRIMARY KEY (id);

CREATE INDEX indicadores_resultados_competencia_index  ON indicadores_resultados(competencia);
ALTER TABLE indicadores_resultados ADD CONSTRAINT fk_indicadores_resultados_configuracao_id FOREIGN KEY (indicador_configuracao_id) REFERENCES indicadores_configuracoes (id);
