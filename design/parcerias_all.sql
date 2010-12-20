--
-- TABLE: parceiros
-- 
--  

CREATE TABLE parceiros (
  id serial NOT NULL ,
  nome character varying NOT NULL ,
  sigla character varying NOT NULL ,
  observacoes character varying NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone,
  alteracao_usuario_id integer
);

-- 
ALTER TABLE parceiros ADD CONSTRAINT pk_parceiros_id PRIMARY KEY (id);

-- Table: pas2011.parcerias

-- DROP TABLE pas2011.parcerias;

CREATE TABLE pas2011.parcerias
(
  id serial NOT NULL,
  objetivo_especifico_id integer NOT NULL,
  parceiro_id integer NOT NULL,
  observacoes character varying,
  situacao_id smallint NOT NULL DEFAULT 1,
  inclusao_data timestamp without time zone NOT NULL DEFAULT now(),
  inclusao_usuario_id integer NOT NULL,
  alteracao_data timestamp without time zone NOT NULL DEFAULT now(),
  alteracao_usuario_id integer NOT NULL,
  CONSTRAINT pk_parceria_id PRIMARY KEY (id),
  CONSTRAINT fk_parceiro_parceiro_id FOREIGN KEY (parceiro_id)
      REFERENCES public.parceiros (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT fk_parcerias_objetivo_especifico_id FOREIGN KEY (objetivo_especifico_id)
      REFERENCES pas2011.objetivos_especificos (id) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
);


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


--
-- TABLE: parceria_tipos
-- 
--  

CREATE TABLE pas2011.parceria_tipos (
  id serial NOT NULL ,
  parceria_id integer NOT NULL ,
  tipo_parceria_id integer NOT NULL ,
  inclusao_usuario_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  CONSTRAINT pk_parceria_tipos_id PRIMARY KEY (id)
);
ALTER TABLE pas2011.parceria_tipos ADD CONSTRAINT fk_tiposparcerias_tipo_parceria_id FOREIGN KEY (tipo_parceria_id) REFERENCES tipos_parcerias (id);
ALTER TABLE pas2011.parceria_tipos ADD CONSTRAINT fk_tiposparcerias_parceria_id FOREIGN KEY (parceria_id) REFERENCES pas2011.parcerias (id);
