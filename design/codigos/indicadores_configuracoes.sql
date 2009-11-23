
--
-- TABLE: indicadores_configuracoes
-- Tabela com as configurações do indicador
-- cada indicador pode apresentar de períodos de cálculo
--  

CREATE TABLE indicadores_configuracoes (
  id serial NOT NULL ,
  indicador_id int NOT NULL ,
  tipo_periodo_id int NOT NULL 
);

-- 
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT pk_indicador_config_id PRIMARY KEY (id);
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_indicador_config_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores (id);
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_indicador_config_tipo_periodo_id FOREIGN KEY (tipo_periodo_id) REFERENCES tipos_periodos (id);
