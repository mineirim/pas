
--
-- TABLE: indicadores_configuracoes
-- Tabela com as configurações do indicador
-- cada indicador pode apresentar de períodos de cálculo
--  
drop table indicadores_configuracoes;
CREATE TABLE indicadores_configuracoes (
  id serial NOT NULL ,
  indicador_id int NOT NULL ,
  tipo_periodo_id int NOT NULL ,
  base integer NOT NULL  DEFAULT 1, -- A base é um número múltiplo de 10 ex: indicador por 100, por 1000 etc..
  so_quantidade boolean NOT NULL  DEFAULT false,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT pk_indicador_config_id PRIMARY KEY (id);

-- 
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_ui_indicadores_configuracoes FOREIGN KEY (inclusao_usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_ua_indicadores_configuracoes FOREIGN KEY (alteracao_usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_indicador_config_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores (id) ON UPDATE CASCADE ON DELETE RESTRICT;
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_indicador_config_tipo_periodo_id FOREIGN KEY (tipo_periodo_id) REFERENCES tipos_periodos (id) ON UPDATE CASCADE ON DELETE RESTRICT;
