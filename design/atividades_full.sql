
SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = pas2011, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

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

--
-- TABLE: atividades_historico
-- 
--  

CREATE TABLE atividades_historico (
  id serial NOT NULL ,
  atividade_id integer NOT NULL ,
  data_inicio date NOT NULL ,
  data_prazo date NOT NULL ,
  data_conclusao date NOT NULL ,
  andamento_id integer NOT NULL  DEFAULT 1,
  avaliacao character varying NOT NULL ,
  percentual integer NOT NULL , -- f
  situacao_id integer NOT NULL ,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone NOT NULL ,
  alteracao_usuario_id integer NOT NULL 
);

-- 
--
-- TABLE: atividades
-- 
--  

CREATE TABLE atividades (
  id serial NOT NULL ,
  descricao character varying NOT NULL ,
  operacao_id integer NOT NULL ,
  peso integer DEFAULT 0,
  responsavel_id integer,
  situacao_id integer NOT NULL  DEFAULT 1,
  inclusao_data timestamp without time zone NOT NULL  DEFAULT now(),
  inclusao_usuario_id integer NOT NULL ,
  alteracao_data timestamp without time zone,
  alteracao_usuario_id integer
);
ALTER TABLE atividades ADD CONSTRAINT pk_atividades_id PRIMARY KEY (id);
ALTER TABLE atividades ADD CONSTRAINT fk_atividades_operacao_id FOREIGN KEY (operacao_id) REFERENCES operacoes (id);

ALTER TABLE atividades_historico ADD CONSTRAINT pk_atividades_historico PRIMARY KEY (id);
ALTER TABLE atividades_historico ADD CONSTRAINT fk_andamento_atividade FOREIGN KEY (andamento_id) REFERENCES andamento (id);
ALTER TABLE atividades_historico ADD CONSTRAINT fk_atividade_historico FOREIGN KEY (atividade_id) REFERENCES atividades (id);


-- 

--
-- TABLE: atividades_vinculadas
-- 
--  

CREATE TABLE atividades_vinculadas (
  id serial NOT NULL ,
  atividade_id integer NOT NULL ,
  depende_atividade_id integer NOT NULL ,
  justificativa character varying,
  observacoes character varying,
  is_pactuado boolean DEFAULT false,
  pacto_usuario_id integer,
  inclusao_data timestamp without time zone NOT NULL DEFAULT now(),
  inclusao_usuario_id integer NOT NULL   ,
  alteracao_data timestamp without time zone,
  alteracao_usuario_id integer
);

-- 
ALTER TABLE atividades_vinculadas ADD CONSTRAINT pk_vinculo_atividades_id PRIMARY KEY (id);
ALTER TABLE atividades_vinculadas ADD CONSTRAINT fk_atividade_dependente FOREIGN KEY (depende_atividade_id) REFERENCES atividades (id);
ALTER TABLE atividades_vinculadas ADD CONSTRAINT fk_vinculo_atividade_atividade_id FOREIGN KEY (atividade_id) REFERENCES atividades (id);
