
--
-- TABLE: tipos_periodos
-- 
--  

CREATE TABLE public.tipos_periodos (
  id serial NOT NULL ,
  periodo character varying NOT NULL ,
  descricao character varying NOT NULL 
);

-- 
ALTER TABLE tipos_periodos ADD CONSTRAINT pk_tipo_periodo_id PRIMARY KEY (id);



--
-- TABLE: objetivos_especificos
-- 
--  

CREATE TABLE objetivos_especificos (
  id serial NOT NULL ,
  descricao character varying(200),
  menu character varying(30) NOT NULL ,
  recursos character varying,
  cronograma character varying,
  situacao_id smallint DEFAULT 1,
  projeto_id int NOT NULL ,
  ordem integer DEFAULT DEFAULT currval('acoes_id_seq'::regclass),
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE objetivos_especificos ADD CONSTRAINT pk_acao_id PRIMARY KEY (id);

CREATE INDEX objetivos_especificos_projeto_id_index  ON objetivos_especificos(projeto_id);
ALTER TABLE objetivos_especificos ADD CONSTRAINT fk_subprojeto_acao FOREIGN KEY (subprojeto_id) REFERENCES undef (id);
ALTER TABLE objetivos_especificos ADD CONSTRAINT fk_objetivos_especificos_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos (id);


--
-- TABLE: metas
-- 
--  

CREATE TABLE metas (
  id serial NOT NULL ,
  descricao character varying(200),
  situacao_id int NOT NULL  DEFAULT 1,
  objetivo_especifico_id int,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE metas ADD CONSTRAINT pk_meta_id PRIMARY KEY (id);

CREATE INDEX metas_situacao_id_index  ON metas(situacao_id);

CREATE INDEX metas_objetivo_especifico_id_index  ON metas(objetivo_especifico_id);
ALTER TABLE metas ADD CONSTRAINT fk_objetivo_meta FOREIGN KEY (objetivo_id) REFERENCES undef (id);
ALTER TABLE metas ADD CONSTRAINT fk_metas_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id) REFERENCES objetivos_especificos (id);


--
-- TABLE: parcerias
-- 
--  

CREATE TABLE parcerias (
  id serial NOT NULL ,
  descricao character varying(200),
  situacao_id smallint NOT NULL  DEFAULT 1,
  objetivo_especifico_id int NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE parcerias ADD CONSTRAINT pk_parceria_id PRIMARY KEY (id);

CREATE INDEX parcerias_situacao_id_index  ON parcerias(situacao_id);

CREATE INDEX parcerias_objetivo_especifico_id_index  ON parcerias(objetivo_especifico_id);
ALTER TABLE parcerias ADD CONSTRAINT fk_meta_parceria FOREIGN KEY (meta_id) REFERENCES metas (id);
ALTER TABLE parcerias ADD CONSTRAINT fk_parcerias_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id) REFERENCES objetivos_especificos (id);



--
-- TABLE: estrategias
-- 
--  

CREATE TABLE estrategias (
  id serial NOT NULL ,
  descricao character varying(200),
  situacao_id smallint NOT NULL  DEFAULT 1,
  objetivo_especifico_id integer,
  objetivo_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id integer NOT NULL 
);

-- 
ALTER TABLE estrategias ADD CONSTRAINT pk_estrategia_id PRIMARY KEY (id);

CREATE INDEX estrategias_situacao_id_index  ON estrategias(situacao_id);

CREATE INDEX estrategias_objetivo_id_index  ON estrategias(objetivo_id);
ALTER TABLE estrategias ADD CONSTRAINT fk_objetivo_estrategia FOREIGN KEY (objetivo_id) REFERENCES undef (id);
ALTER TABLE estrategias ADD CONSTRAINT fk_estrategias_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id) REFERENCES objetivos_especificos (id);



--
-- TABLE: operacoes
-- 
--  

CREATE TABLE operacoes (
  id serial NOT NULL ,
  descricao character varying NOT NULL ,
  meta_id integer NOT NULL ,
  situacao_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usurio_id integer NOT NULL 
);
ALTER TABLE operacoes ADD CONSTRAINT fk_operacoes_meta_id FOREIGN KEY (meta_id) REFERENCES metas (id);

--
-- TABLE: atividades
-- 
--  

CREATE TABLE atividades (
  id serial NOT NULL ,
  descricao character varying NOT NULL ,
  operacao_id integer NOT NULL ,
  valor float,
  responsavel character varying,
  intersecao character varying,
  inicio_data date,
  prazo_data date,
  situacao_id integer NOT NULL  DEFAULT 1,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL  DEFAULT now(),
  alteracao_usuario_id timestamp without time zone NOT NULL  DEFAULT now()
);

-- 
ALTER TABLE atividades ADD CONSTRAINT pk_atividades_id PRIMARY KEY (id);
ALTER TABLE atividades ADD CONSTRAINT fk_atividades_operacao_id FOREIGN KEY (operacao_id) REFERENCES operacoes (id);



--
-- TABLE: indicadores_configuracoes
-- Tabela com as configurações do indicador
-- cada indicador pode apresentar de períodos de cálculo
--  

CREATE TABLE public.indicadores_configuracoes (
  id serial NOT NULL ,
  indicador_id int NOT NULL ,
  tipo_periodo_id int NOT NULL 
);

-- 
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT pk_indicador_config_id PRIMARY KEY (id);
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_indicador_config_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores (id);
ALTER TABLE indicadores_configuracoes ADD CONSTRAINT fk_indicador_config_tipo_periodo_id FOREIGN KEY (tipo_periodo_id) REFERENCES tipos_periodos (id);

--
-- TABLE: indicadores_meta
-- 
--  

CREATE TABLE public.indicadores_meta (
  id serial NOT NULL ,
  meta_id integer NOT NULL ,
  indicador_id integer NOT NULL 
);

-- 
ALTER TABLE indicadores_meta ADD CONSTRAINT pk_indicadores_meta_id PRIMARY KEY (id);
ALTER TABLE indicadores_meta ADD CONSTRAINT pk_indicadores_meta_meta_id FOREIGN KEY (meta_id) REFERENCES metas (id);
ALTER TABLE indicadores_meta ADD CONSTRAINT pk_indicadores_meta_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores (id);