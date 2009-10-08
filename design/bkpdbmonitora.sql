--
-- PostgreSQL database dump
--

-- Started on 2009-10-08 08:23:12 BRT

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 2012 (class 1262 OID 16387)
-- Name: dbmonitora; Type: DATABASE; Schema: -; Owner: dbmonitora
--

CREATE DATABASE dbmonitora WITH TEMPLATE = template0 ENCODING = 'UTF8';


ALTER DATABASE dbmonitora OWNER TO dbmonitora;

\connect dbmonitora

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 371 (class 2612 OID 16398)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1582 (class 1259 OID 17549)
-- Dependencies: 1888 1889 1890 6
-- Name: acoes; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE acoes (
    id integer NOT NULL,
    descricao character varying(200),
    recursos character varying(200),
    cronograma text,
    situacao_id smallint DEFAULT 1,
    projeto_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.acoes OWNER TO dbmonitora;

--
-- TOC entry 1581 (class 1259 OID 17547)
-- Dependencies: 6 1582
-- Name: acoes_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE acoes_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.acoes_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2015 (class 0 OID 0)
-- Dependencies: 1581
-- Name: acoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE acoes_id_seq OWNED BY acoes.id;


--
-- TOC entry 2016 (class 0 OID 0)
-- Dependencies: 1581
-- Name: acoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('acoes_id_seq', 44, true);


--
-- TOC entry 1586 (class 1259 OID 17584)
-- Dependencies: 1896 1897 1898 6
-- Name: estrategias_acao; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE estrategias_acao (
    id integer NOT NULL,
    descricao character varying(200),
    situacao_id integer DEFAULT 1 NOT NULL,
    acao_id integer NOT NULL,
    objetivo_id integer,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.estrategias_acao OWNER TO dbmonitora;

--
-- TOC entry 2017 (class 0 OID 0)
-- Dependencies: 1586
-- Name: TABLE estrategias_acao; Type: COMMENT; Schema: public; Owner: dbmonitora
--

COMMENT ON TABLE estrategias_acao IS 'as estratégias das ações estão vinculadas ao objetivo da acao';


--
-- TOC entry 1585 (class 1259 OID 17582)
-- Dependencies: 1586 6
-- Name: estrategias_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE estrategias_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.estrategias_acao_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2018 (class 0 OID 0)
-- Dependencies: 1585
-- Name: estrategias_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE estrategias_acao_id_seq OWNED BY estrategias_acao.id;


--
-- TOC entry 2019 (class 0 OID 0)
-- Dependencies: 1585
-- Name: estrategias_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('estrategias_acao_id_seq', 33, true);


--
-- TOC entry 1543 (class 1259 OID 17073)
-- Dependencies: 6
-- Name: grupos; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE grupos (
    id integer NOT NULL,
    grupo character varying(50) NOT NULL,
    descricao character varying(200) NOT NULL
);


ALTER TABLE public.grupos OWNER TO dbmonitora;

--
-- TOC entry 1544 (class 1259 OID 17076)
-- Dependencies: 1543 6
-- Name: grupos_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE grupos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.grupos_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2020 (class 0 OID 0)
-- Dependencies: 1544
-- Name: grupos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE grupos_id_seq OWNED BY grupos.id;


--
-- TOC entry 2021 (class 0 OID 0)
-- Dependencies: 1544
-- Name: grupos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('grupos_id_seq', 19, true);


--
-- TOC entry 1545 (class 1259 OID 17078)
-- Dependencies: 6
-- Name: grupos_permissoes; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE grupos_permissoes (
    id integer NOT NULL,
    grupo_id integer NOT NULL,
    pagina_id integer
);


ALTER TABLE public.grupos_permissoes OWNER TO dbmonitora;

--
-- TOC entry 1546 (class 1259 OID 17081)
-- Dependencies: 1545 6
-- Name: grupos_permissoes_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE grupos_permissoes_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.grupos_permissoes_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2022 (class 0 OID 0)
-- Dependencies: 1546
-- Name: grupos_permissoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE grupos_permissoes_id_seq OWNED BY grupos_permissoes.id;


--
-- TOC entry 2023 (class 0 OID 0)
-- Dependencies: 1546
-- Name: grupos_permissoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('grupos_permissoes_id_seq', 47, true);


--
-- TOC entry 1547 (class 1259 OID 17083)
-- Dependencies: 6
-- Name: indicador_config; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE indicador_config (
    id integer NOT NULL,
    indicador_id integer NOT NULL,
    tipo_periodo_id integer NOT NULL
);


ALTER TABLE public.indicador_config OWNER TO dbmonitora;

--
-- TOC entry 1548 (class 1259 OID 17086)
-- Dependencies: 6 1547
-- Name: indicador_config_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE indicador_config_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicador_config_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2024 (class 0 OID 0)
-- Dependencies: 1548
-- Name: indicador_config_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE indicador_config_id_seq OWNED BY indicador_config.id;


--
-- TOC entry 2025 (class 0 OID 0)
-- Dependencies: 1548
-- Name: indicador_config_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('indicador_config_id_seq', 1, false);


--
-- TOC entry 1549 (class 1259 OID 17088)
-- Dependencies: 1860 1861 6
-- Name: indicadores; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE indicadores (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.indicadores OWNER TO dbmonitora;

--
-- TOC entry 1550 (class 1259 OID 17096)
-- Dependencies: 6 1549
-- Name: indicadores_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE indicadores_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicadores_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2026 (class 0 OID 0)
-- Dependencies: 1550
-- Name: indicadores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE indicadores_id_seq OWNED BY indicadores.id;


--
-- TOC entry 2027 (class 0 OID 0)
-- Dependencies: 1550
-- Name: indicadores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('indicadores_id_seq', 1, false);


--
-- TOC entry 1551 (class 1259 OID 17098)
-- Dependencies: 6
-- Name: indicadores_programa; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE indicadores_programa (
    id integer NOT NULL,
    programa_id integer NOT NULL,
    indicador_config_id integer NOT NULL
);


ALTER TABLE public.indicadores_programa OWNER TO dbmonitora;

--
-- TOC entry 1552 (class 1259 OID 17101)
-- Dependencies: 1551 6
-- Name: indicadores_programa_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE indicadores_programa_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicadores_programa_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2028 (class 0 OID 0)
-- Dependencies: 1552
-- Name: indicadores_programa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE indicadores_programa_id_seq OWNED BY indicadores_programa.id;


--
-- TOC entry 2029 (class 0 OID 0)
-- Dependencies: 1552
-- Name: indicadores_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('indicadores_programa_id_seq', 1, false);


--
-- TOC entry 1553 (class 1259 OID 17103)
-- Dependencies: 6
-- Name: indicadores_projeto; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE indicadores_projeto (
    id integer NOT NULL,
    projeto_id integer NOT NULL,
    indicador_config_id integer NOT NULL
);


ALTER TABLE public.indicadores_projeto OWNER TO dbmonitora;

--
-- TOC entry 1554 (class 1259 OID 17106)
-- Dependencies: 6 1553
-- Name: indicadores_projeto_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE indicadores_projeto_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicadores_projeto_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2030 (class 0 OID 0)
-- Dependencies: 1554
-- Name: indicadores_projeto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE indicadores_projeto_id_seq OWNED BY indicadores_projeto.id;


--
-- TOC entry 2031 (class 0 OID 0)
-- Dependencies: 1554
-- Name: indicadores_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('indicadores_projeto_id_seq', 1, false);


--
-- TOC entry 1588 (class 1259 OID 17602)
-- Dependencies: 1900 1901 1902 6
-- Name: metas_acao; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE metas_acao (
    id integer NOT NULL,
    descricao character varying(200),
    situacao_id integer DEFAULT 1 NOT NULL,
    acao_id integer NOT NULL,
    objetivo_id integer,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.metas_acao OWNER TO dbmonitora;

--
-- TOC entry 1587 (class 1259 OID 17600)
-- Dependencies: 1588 6
-- Name: metas_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE metas_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.metas_acao_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2032 (class 0 OID 0)
-- Dependencies: 1587
-- Name: metas_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE metas_acao_id_seq OWNED BY metas_acao.id;


--
-- TOC entry 2033 (class 0 OID 0)
-- Dependencies: 1587
-- Name: metas_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('metas_acao_id_seq', 15, true);


--
-- TOC entry 1555 (class 1259 OID 17115)
-- Dependencies: 6
-- Name: metas_programa; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE metas_programa (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    programa_id integer NOT NULL
);


ALTER TABLE public.metas_programa OWNER TO dbmonitora;

--
-- TOC entry 1556 (class 1259 OID 17121)
-- Dependencies: 6 1555
-- Name: metas_programa_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE metas_programa_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.metas_programa_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2034 (class 0 OID 0)
-- Dependencies: 1556
-- Name: metas_programa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE metas_programa_id_seq OWNED BY metas_programa.id;


--
-- TOC entry 2035 (class 0 OID 0)
-- Dependencies: 1556
-- Name: metas_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('metas_programa_id_seq', 14, true);


--
-- TOC entry 1557 (class 1259 OID 17123)
-- Dependencies: 6
-- Name: metas_projeto; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE metas_projeto (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    projeto_id integer NOT NULL
);


ALTER TABLE public.metas_projeto OWNER TO dbmonitora;

--
-- TOC entry 1558 (class 1259 OID 17129)
-- Dependencies: 1557 6
-- Name: metas_projeto_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE metas_projeto_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.metas_projeto_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2036 (class 0 OID 0)
-- Dependencies: 1558
-- Name: metas_projeto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE metas_projeto_id_seq OWNED BY metas_projeto.id;


--
-- TOC entry 2037 (class 0 OID 0)
-- Dependencies: 1558
-- Name: metas_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('metas_projeto_id_seq', 17, true);


--
-- TOC entry 1584 (class 1259 OID 17568)
-- Dependencies: 1892 1893 1894 6
-- Name: objetivos_acao; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE objetivos_acao (
    id integer NOT NULL,
    descricao character varying(200),
    situacao_id smallint DEFAULT 1 NOT NULL,
    acao_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.objetivos_acao OWNER TO dbmonitora;

--
-- TOC entry 1583 (class 1259 OID 17566)
-- Dependencies: 6 1584
-- Name: objetivos_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE objetivos_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.objetivos_acao_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2038 (class 0 OID 0)
-- Dependencies: 1583
-- Name: objetivos_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE objetivos_acao_id_seq OWNED BY objetivos_acao.id;


--
-- TOC entry 2039 (class 0 OID 0)
-- Dependencies: 1583
-- Name: objetivos_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('objetivos_acao_id_seq', 130, true);


--
-- TOC entry 1559 (class 1259 OID 17139)
-- Dependencies: 1867 6
-- Name: objetivos_programa; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE objetivos_programa (
    id integer NOT NULL,
    descricao character varying DEFAULT 500 NOT NULL,
    programa_id integer NOT NULL
);


ALTER TABLE public.objetivos_programa OWNER TO dbmonitora;

--
-- TOC entry 1560 (class 1259 OID 17146)
-- Dependencies: 1559 6
-- Name: objetivos_programa_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE objetivos_programa_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.objetivos_programa_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2040 (class 0 OID 0)
-- Dependencies: 1560
-- Name: objetivos_programa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE objetivos_programa_id_seq OWNED BY objetivos_programa.id;


--
-- TOC entry 2041 (class 0 OID 0)
-- Dependencies: 1560
-- Name: objetivos_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('objetivos_programa_id_seq', 7, true);


--
-- TOC entry 1561 (class 1259 OID 17148)
-- Dependencies: 6
-- Name: objetivos_projeto; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE objetivos_projeto (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    projeto_id integer NOT NULL
);


ALTER TABLE public.objetivos_projeto OWNER TO dbmonitora;

--
-- TOC entry 1562 (class 1259 OID 17154)
-- Dependencies: 1561 6
-- Name: objetivos_projeto_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE objetivos_projeto_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.objetivos_projeto_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2042 (class 0 OID 0)
-- Dependencies: 1562
-- Name: objetivos_projeto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE objetivos_projeto_id_seq OWNED BY objetivos_projeto.id;


--
-- TOC entry 2043 (class 0 OID 0)
-- Dependencies: 1562
-- Name: objetivos_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('objetivos_projeto_id_seq', 18, true);


--
-- TOC entry 1563 (class 1259 OID 17156)
-- Dependencies: 6
-- Name: paginas; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE paginas (
    id integer NOT NULL,
    descricao character varying(100) NOT NULL,
    pagina character varying(200) NOT NULL,
    acao character varying
);


ALTER TABLE public.paginas OWNER TO dbmonitora;

--
-- TOC entry 1564 (class 1259 OID 17162)
-- Dependencies: 1563 6
-- Name: paginas_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE paginas_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.paginas_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2044 (class 0 OID 0)
-- Dependencies: 1564
-- Name: paginas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE paginas_id_seq OWNED BY paginas.id;


--
-- TOC entry 2045 (class 0 OID 0)
-- Dependencies: 1564
-- Name: paginas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('paginas_id_seq', 11, true);


--
-- TOC entry 1590 (class 1259 OID 17706)
-- Dependencies: 1904 1905 1906 6
-- Name: parcerias_acao; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE parcerias_acao (
    id integer NOT NULL,
    descricao character varying(200),
    situacao_id smallint DEFAULT 1 NOT NULL,
    acao_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.parcerias_acao OWNER TO dbmonitora;

--
-- TOC entry 1589 (class 1259 OID 17704)
-- Dependencies: 6 1590
-- Name: parcerias_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE parcerias_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.parcerias_acao_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2046 (class 0 OID 0)
-- Dependencies: 1589
-- Name: parcerias_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE parcerias_acao_id_seq OWNED BY parcerias_acao.id;


--
-- TOC entry 2047 (class 0 OID 0)
-- Dependencies: 1589
-- Name: parcerias_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('parcerias_acao_id_seq', 7, true);


--
-- TOC entry 1565 (class 1259 OID 17171)
-- Dependencies: 6
-- Name: programas_id; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE programas_id
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.programas_id OWNER TO dbmonitora;

--
-- TOC entry 2048 (class 0 OID 0)
-- Dependencies: 1565
-- Name: programas_id; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('programas_id', 1, false);


--
-- TOC entry 1566 (class 1259 OID 17173)
-- Dependencies: 1871 1872 1873 1874 6
-- Name: programas; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE programas (
    id integer DEFAULT nextval('programas_id'::regclass) NOT NULL,
    descricao character varying(500) NOT NULL,
    interfaces character varying(200) NOT NULL,
    situacao_id smallint DEFAULT 1 NOT NULL,
    responsavel_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL,
    menu character varying(20)
);


ALTER TABLE public.programas OWNER TO dbmonitora;

--
-- TOC entry 1567 (class 1259 OID 17183)
-- Dependencies: 6 1566
-- Name: programas_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE programas_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.programas_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2049 (class 0 OID 0)
-- Dependencies: 1567
-- Name: programas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE programas_id_seq OWNED BY programas.id;


--
-- TOC entry 2050 (class 0 OID 0)
-- Dependencies: 1567
-- Name: programas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('programas_id_seq', 25, true);


--
-- TOC entry 1568 (class 1259 OID 17185)
-- Dependencies: 1875 1876 1877 6
-- Name: projetos; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE projetos (
    id integer NOT NULL,
    descricao character varying,
    interfaces character varying(200),
    situacao_id smallint DEFAULT 1 NOT NULL,
    programa_id integer,
    responsavel_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL,
    menu character varying(20),
    projeto_id integer
);


ALTER TABLE public.projetos OWNER TO dbmonitora;

--
-- TOC entry 1569 (class 1259 OID 17194)
-- Dependencies: 6 1568
-- Name: projetos_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE projetos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.projetos_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2051 (class 0 OID 0)
-- Dependencies: 1569
-- Name: projetos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE projetos_id_seq OWNED BY projetos.id;


--
-- TOC entry 2052 (class 0 OID 0)
-- Dependencies: 1569
-- Name: projetos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('projetos_id_seq', 20, true);


--
-- TOC entry 1570 (class 1259 OID 17196)
-- Dependencies: 1879 1880 6
-- Name: recursos; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE recursos (
    id integer NOT NULL,
    fonte character varying(200),
    valor double precision,
    destino character varying(200),
    situacao smallint,
    meta_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id timestamp without time zone NOT NULL
);


ALTER TABLE public.recursos OWNER TO dbmonitora;

--
-- TOC entry 1571 (class 1259 OID 17201)
-- Dependencies: 1570 6
-- Name: recursos_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE recursos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.recursos_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2053 (class 0 OID 0)
-- Dependencies: 1571
-- Name: recursos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE recursos_id_seq OWNED BY recursos.id;


--
-- TOC entry 2054 (class 0 OID 0)
-- Dependencies: 1571
-- Name: recursos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('recursos_id_seq', 1, false);


--
-- TOC entry 1572 (class 1259 OID 17203)
-- Dependencies: 6
-- Name: situacoes; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE situacoes (
    id integer NOT NULL,
    descricao character varying(50) NOT NULL
);


ALTER TABLE public.situacoes OWNER TO dbmonitora;

--
-- TOC entry 1573 (class 1259 OID 17206)
-- Dependencies: 6 1572
-- Name: situacoes_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE situacoes_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.situacoes_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2055 (class 0 OID 0)
-- Dependencies: 1573
-- Name: situacoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE situacoes_id_seq OWNED BY situacoes.id;


--
-- TOC entry 2056 (class 0 OID 0)
-- Dependencies: 1573
-- Name: situacoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('situacoes_id_seq', 2, true);


--
-- TOC entry 1574 (class 1259 OID 17208)
-- Dependencies: 6
-- Name: tipo_periodo; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE tipo_periodo (
    id integer NOT NULL,
    periodo character varying NOT NULL,
    descricao character varying NOT NULL
);


ALTER TABLE public.tipo_periodo OWNER TO dbmonitora;

--
-- TOC entry 1575 (class 1259 OID 17214)
-- Dependencies: 6 1574
-- Name: tipo_periodo_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE tipo_periodo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tipo_periodo_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2057 (class 0 OID 0)
-- Dependencies: 1575
-- Name: tipo_periodo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE tipo_periodo_id_seq OWNED BY tipo_periodo.id;


--
-- TOC entry 2058 (class 0 OID 0)
-- Dependencies: 1575
-- Name: tipo_periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('tipo_periodo_id_seq', 1, false);


--
-- TOC entry 1576 (class 1259 OID 17216)
-- Dependencies: 6
-- Name: usuarios_id; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE usuarios_id
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id OWNER TO dbmonitora;

--
-- TOC entry 2059 (class 0 OID 0)
-- Dependencies: 1576
-- Name: usuarios_id; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('usuarios_id', 1, false);


--
-- TOC entry 1577 (class 1259 OID 17218)
-- Dependencies: 1884 1885 6
-- Name: usuarios; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE usuarios (
    id integer DEFAULT nextval('usuarios_id'::regclass) NOT NULL,
    nome character varying NOT NULL,
    username character varying(30) NOT NULL,
    password character varying(64) NOT NULL,
    email character varying(100) NOT NULL,
    situacao smallint DEFAULT 1 NOT NULL,
    salt character varying
);


ALTER TABLE public.usuarios OWNER TO dbmonitora;

--
-- TOC entry 1578 (class 1259 OID 17226)
-- Dependencies: 6
-- Name: usuarios_grupos; Type: TABLE; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE TABLE usuarios_grupos (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    grupo_id integer NOT NULL
);


ALTER TABLE public.usuarios_grupos OWNER TO dbmonitora;

--
-- TOC entry 1579 (class 1259 OID 17229)
-- Dependencies: 1578 6
-- Name: usuarios_grupos_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE usuarios_grupos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.usuarios_grupos_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2060 (class 0 OID 0)
-- Dependencies: 1579
-- Name: usuarios_grupos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE usuarios_grupos_id_seq OWNED BY usuarios_grupos.id;


--
-- TOC entry 2061 (class 0 OID 0)
-- Dependencies: 1579
-- Name: usuarios_grupos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('usuarios_grupos_id_seq', 49, true);


--
-- TOC entry 1580 (class 1259 OID 17231)
-- Dependencies: 6 1577
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: dbmonitora
--

CREATE SEQUENCE usuarios_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id_seq OWNER TO dbmonitora;

--
-- TOC entry 2062 (class 0 OID 0)
-- Dependencies: 1580
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: dbmonitora
--

ALTER SEQUENCE usuarios_id_seq OWNED BY usuarios.id;


--
-- TOC entry 2063 (class 0 OID 0)
-- Dependencies: 1580
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: dbmonitora
--

SELECT pg_catalog.setval('usuarios_id_seq', 22, true);


--
-- TOC entry 1887 (class 2604 OID 17552)
-- Dependencies: 1581 1582 1582
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE acoes ALTER COLUMN id SET DEFAULT nextval('acoes_id_seq'::regclass);


--
-- TOC entry 1895 (class 2604 OID 17587)
-- Dependencies: 1586 1585 1586
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE estrategias_acao ALTER COLUMN id SET DEFAULT nextval('estrategias_acao_id_seq'::regclass);


--
-- TOC entry 1857 (class 2604 OID 17236)
-- Dependencies: 1544 1543
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE grupos ALTER COLUMN id SET DEFAULT nextval('grupos_id_seq'::regclass);


--
-- TOC entry 1858 (class 2604 OID 17237)
-- Dependencies: 1546 1545
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE grupos_permissoes ALTER COLUMN id SET DEFAULT nextval('grupos_permissoes_id_seq'::regclass);


--
-- TOC entry 1859 (class 2604 OID 17238)
-- Dependencies: 1548 1547
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE indicador_config ALTER COLUMN id SET DEFAULT nextval('indicador_config_id_seq'::regclass);


--
-- TOC entry 1862 (class 2604 OID 17239)
-- Dependencies: 1550 1549
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE indicadores ALTER COLUMN id SET DEFAULT nextval('indicadores_id_seq'::regclass);


--
-- TOC entry 1863 (class 2604 OID 17240)
-- Dependencies: 1552 1551
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE indicadores_programa ALTER COLUMN id SET DEFAULT nextval('indicadores_programa_id_seq'::regclass);


--
-- TOC entry 1864 (class 2604 OID 17241)
-- Dependencies: 1554 1553
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE indicadores_projeto ALTER COLUMN id SET DEFAULT nextval('indicadores_projeto_id_seq'::regclass);


--
-- TOC entry 1899 (class 2604 OID 17605)
-- Dependencies: 1588 1587 1588
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE metas_acao ALTER COLUMN id SET DEFAULT nextval('metas_acao_id_seq'::regclass);


--
-- TOC entry 1865 (class 2604 OID 17243)
-- Dependencies: 1556 1555
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE metas_programa ALTER COLUMN id SET DEFAULT nextval('metas_programa_id_seq'::regclass);


--
-- TOC entry 1866 (class 2604 OID 17244)
-- Dependencies: 1558 1557
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE metas_projeto ALTER COLUMN id SET DEFAULT nextval('metas_projeto_id_seq'::regclass);


--
-- TOC entry 1891 (class 2604 OID 17571)
-- Dependencies: 1583 1584 1584
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE objetivos_acao ALTER COLUMN id SET DEFAULT nextval('objetivos_acao_id_seq'::regclass);


--
-- TOC entry 1868 (class 2604 OID 17246)
-- Dependencies: 1560 1559
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE objetivos_programa ALTER COLUMN id SET DEFAULT nextval('objetivos_programa_id_seq'::regclass);


--
-- TOC entry 1869 (class 2604 OID 17247)
-- Dependencies: 1562 1561
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE objetivos_projeto ALTER COLUMN id SET DEFAULT nextval('objetivos_projeto_id_seq'::regclass);


--
-- TOC entry 1870 (class 2604 OID 17248)
-- Dependencies: 1564 1563
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE paginas ALTER COLUMN id SET DEFAULT nextval('paginas_id_seq'::regclass);


--
-- TOC entry 1903 (class 2604 OID 17709)
-- Dependencies: 1590 1589 1590
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE parcerias_acao ALTER COLUMN id SET DEFAULT nextval('parcerias_acao_id_seq'::regclass);


--
-- TOC entry 1878 (class 2604 OID 17250)
-- Dependencies: 1569 1568
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE projetos ALTER COLUMN id SET DEFAULT nextval('projetos_id_seq'::regclass);


--
-- TOC entry 1881 (class 2604 OID 17251)
-- Dependencies: 1571 1570
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE recursos ALTER COLUMN id SET DEFAULT nextval('recursos_id_seq'::regclass);


--
-- TOC entry 1882 (class 2604 OID 17252)
-- Dependencies: 1573 1572
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE situacoes ALTER COLUMN id SET DEFAULT nextval('situacoes_id_seq'::regclass);


--
-- TOC entry 1883 (class 2604 OID 17253)
-- Dependencies: 1575 1574
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE tipo_periodo ALTER COLUMN id SET DEFAULT nextval('tipo_periodo_id_seq'::regclass);


--
-- TOC entry 1886 (class 2604 OID 17254)
-- Dependencies: 1579 1578
-- Name: id; Type: DEFAULT; Schema: public; Owner: dbmonitora
--

ALTER TABLE usuarios_grupos ALTER COLUMN id SET DEFAULT nextval('usuarios_grupos_id_seq'::regclass);


--
-- TOC entry 2005 (class 0 OID 17549)
-- Dependencies: 1582
-- Data for Name: acoes; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY acoes (id, descricao, recursos, cronograma, situacao_id, projeto_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
40	Constituição de Grupo de gerenciadores técnicos para ações de atenção básica (AB)	Recurso SES	Janeiro de 2009	1	3	2009-09-18 18:51:46.872521	2	2009-09-18 18:51:46.872521	2
42	Organização de Seminário Estadual de Atenção Básica	Recursos SES	Fevereiro/09 – Pactuação junto ao Conselho Estadual de Saúde, e Grupo Técnico Bipartite da AB\r\nAbril/09 – Pactuação junto à CIB\r\nMaio, junho e julho/09 – organização do evento\r\nAgosto /09 – realização do seminário	1	3	2009-09-18 19:10:04.354959	2	2009-09-18 19:10:04.354959	2
43	açao do subprojetoasdfsdf	recurso tal	janeiro	1	15	2009-09-20 17:54:54.25746	2	2009-09-24 11:38:07	2
44	Ação de Teste	Recurso SES	Cronograma Tal	1	11	2009-10-08 00:22:51.376431	2	2009-10-08 00:22:51.376431	2
\.


--
-- TOC entry 2007 (class 0 OID 17584)
-- Dependencies: 1586
-- Data for Name: estrategias_acao; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY estrategias_acao (id, descricao, situacao_id, acao_id, objetivo_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
14	Escolha de pessoal  funcionário da SES	1	40	\N	2009-09-18 18:59:25.981851	2	2009-09-18 18:59:25.981851	2
15	Definição de adicional salarial referente ao desempenho da função de apoiador técnico da AB	1	40	\N	2009-09-18 18:59:46.154349	2	2009-09-18 18:59:46.154349	2
16	Pactuação junto ao COSEMS e Conselho Estadual de Saúde das normas para a organização, realização e participação.	1	42	\N	2009-09-18 19:10:52.747083	2	2009-09-18 19:10:52.747083	2
17	est 1	1	43	\N	2009-09-24 23:38:17.798225	2	2009-09-24 23:38:17.798225	2
20	asdlfk	1	40	\N	2009-10-04 23:27:20.957353	2	2009-10-04 23:27:20.957353	2
26	ASDFDF	1	43	\N	2009-10-07 23:54:31.660315	2	2009-10-07 23:54:31.660315	2
27	adfadsf	1	43	\N	2009-10-07 23:54:42.575596	2	2009-10-07 23:54:42.575596	2
28	adfadsf	1	43	\N	2009-10-07 23:54:52.670353	2	2009-10-07 23:54:52.670353	2
29	adsfdsasdfsdfsdfsdf	1	43	\N	2009-10-07 23:57:48.656797	2	2009-10-07 23:57:48.656797	2
30	adsfdsasdfsdfsdfsdfsadf	1	43	127	2009-10-07 23:59:10.728303	2	2009-10-07 23:59:10.728303	2
31	adsfdsasdfsdfsdfsdfsadfasdf	1	43	\N	2009-10-07 23:59:19.798025	2	2009-10-07 23:59:19.798025	2
32	asdf	1	43	129	2009-10-08 00:01:44.577202	2	2009-10-08 00:01:44.577202	2
33	estrategia	1	44	\N	2009-10-08 00:25:35.95674	2	2009-10-08 00:25:35.95674	2
\.


--
-- TOC entry 1987 (class 0 OID 17073)
-- Dependencies: 1543
-- Data for Name: grupos; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY grupos (id, grupo, descricao) FROM stdin;
4	operadores	Operadores do sistema
5	analistas	Analistas de sistema
2	gerentes	Gerente
3	coordenador	Coordenadores de projetos
1	administradores	Administrador do Sistema
19	teste	teste de grupo
6	anonimo	Usuário anônimo
\.


--
-- TOC entry 1988 (class 0 OID 17078)
-- Dependencies: 1545
-- Data for Name: grupos_permissoes; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY grupos_permissoes (id, grupo_id, pagina_id) FROM stdin;
1	1	\N
\.


--
-- TOC entry 1989 (class 0 OID 17083)
-- Dependencies: 1547
-- Data for Name: indicador_config; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY indicador_config (id, indicador_id, tipo_periodo_id) FROM stdin;
\.


--
-- TOC entry 1990 (class 0 OID 17088)
-- Dependencies: 1549
-- Data for Name: indicadores; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY indicadores (id, descricao, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
\.


--
-- TOC entry 1991 (class 0 OID 17098)
-- Dependencies: 1551
-- Data for Name: indicadores_programa; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY indicadores_programa (id, programa_id, indicador_config_id) FROM stdin;
\.


--
-- TOC entry 1992 (class 0 OID 17103)
-- Dependencies: 1553
-- Data for Name: indicadores_projeto; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY indicadores_projeto (id, projeto_id, indicador_config_id) FROM stdin;
\.


--
-- TOC entry 2008 (class 0 OID 17602)
-- Dependencies: 1588
-- Data for Name: metas_acao; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY metas_acao (id, descricao, situacao_id, acao_id, objetivo_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
10	Definição de 81 apoiadores	1	40	\N	2009-09-18 19:00:15.840866	2	2009-09-18 19:00:15.840866	2
11	Distribuição dos 81 gerenciadores pelos 64 Colegiados de Gestão Regional\n( CGR)	1	40	\N	2009-09-18 19:00:29.618838	2	2009-09-18 19:00:29.618838	2
12	Participação dos gestores municipais e técnicos da SES	1	42	\N	2009-09-18 19:11:12.732912	2	2009-09-18 19:11:12.732912	2
13	met1	1	43	\N	2009-09-24 23:38:24.9785	2	2009-09-24 23:38:24.9785	2
14	meta com objetivo	1	43	127	2009-10-08 00:02:00.597537	2	2009-10-08 00:02:00.597537	2
15	dfasdf	1	43	129	2009-10-08 00:02:31.956258	2	2009-10-08 00:02:31.956258	2
\.


--
-- TOC entry 1993 (class 0 OID 17115)
-- Dependencies: 1555
-- Data for Name: metas_programa; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY metas_programa (id, descricao, programa_id) FROM stdin;
6	Atendimento a 100% da demanda	5
7	1) Implantar Acolhimento com avaliação de risco.	6
8	2) Implantar Contrato Programa nos Hospitais de Taipas, Regional Sul e Candido Fontoura.	6
9	3)Ampliar leitos serviços.	6
1	Apoiar a gestão da atenção básica em 100% dos municípios com menos de 100 mil habitantes;	2
5	Monitorar e avaliar o POA 2009, coordenar a elaboração do Plano Diretor de Investimento 2009, Implantar sistema de monitoramento e avaliação contínuo.	2
11	objetivo 2	14
12	meta1	15
13	Meta 1	25
14	Meta 2	25
\.


--
-- TOC entry 1994 (class 0 OID 17123)
-- Dependencies: 1557
-- Data for Name: metas_projeto; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY metas_projeto (id, descricao, projeto_id) FROM stdin;
1	81 gerenciadores da Atenção Básica instituídos, 4 avaliações/ano para 415 municípios do projeto Qualis Mais	3
6	Monitorar 100% das instituições participantes até o final de 2009	11
5	Construção do instrumento	10
7	Avaliação trimestral de 20% das Macro Regionais	10
12	meta tal	15
13	Meta x	17
14	submeta x	18
15	asdfasdf	19
16	asdf	3
17	safdfsad	20
\.


--
-- TOC entry 2006 (class 0 OID 17568)
-- Dependencies: 1584
-- Data for Name: objetivos_acao; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY objetivos_acao (id, descricao, situacao_id, acao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
123	Apoiar o desenvolvimento da capacidade de gestão da AB junto aos municípios menores de 100 mil hab.	1	40	2009-09-18 18:58:39.878029	2	2009-09-18 18:58:39.878029	2
124	Ampliar propostas e ações para o Fortalecimento da Atenção Básica no Estado de São Paulo	1	42	2009-09-18 19:10:36.019038	2	2009-09-18 19:10:36.019038	2
125	segundo	1	40	2009-09-20 18:19:53.690036	2	2009-09-20 18:19:53.690036	2
126	terceiro objetivo	1	40	2009-09-20 18:20:15.401195	2	2009-09-20 18:20:15.401195	2
127	obj1	1	43	2009-09-24 23:38:13.65449	2	2009-09-24 23:38:13.65449	2
128	xxx	1	40	2009-09-24 23:39:58.626125	2	2009-09-24 23:39:58.626125	2
129	mais um objetivo	1	43	2009-10-08 00:01:32.916018	2	2009-10-08 00:01:32.916018	2
130	objetivo 1	1	44	2009-10-08 00:22:58.396113	2	2009-10-08 00:22:58.396113	2
\.


--
-- TOC entry 1995 (class 0 OID 17139)
-- Dependencies: 1559
-- Data for Name: objetivos_programa; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY objetivos_programa (id, descricao, programa_id) FROM stdin;
1	Buscar o aprimoramento da capacidade de gestão estadual do sistema de saúde, fortalecendo: a atenção básica na coordenação do sistema, o planejamento e a programação baseada em informação e participação.	2
5	obj 1	15
6	objetivo 1	25
7	Objetivo 2	25
\.


--
-- TOC entry 1996 (class 0 OID 17148)
-- Dependencies: 1561
-- Data for Name: objetivos_projeto; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY objetivos_projeto (id, descricao, projeto_id) FROM stdin;
2	objetivo teste	3
3	objetivo teste 3 dois	3
5	Monitorar o desempenho das instituições participantes do programa	11
4	Elaborar o instrumento de acompanhamento e fluxo das linhas de cuidado	10
6	Avaliar o cumprimento da programação da PPI nas linhas de cuidado	10
11	objetivo tal	15
12	Objetivo x	17
13	sub objetivo	18
14	objetivo xx	17
15	asdfasdf	19
16	sdfa	3
17	fgasdfg	18
18	arfds	20
\.


--
-- TOC entry 1997 (class 0 OID 17156)
-- Dependencies: 1563
-- Data for Name: paginas; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY paginas (id, descricao, pagina, acao) FROM stdin;
1	Pagina principal	index	index
\.


--
-- TOC entry 2009 (class 0 OID 17706)
-- Dependencies: 1590
-- Data for Name: parcerias_acao; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY parcerias_acao (id, descricao, situacao_id, acao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
3	SES	1	40	2009-10-04 18:33:09.497857	2	2009-10-04 18:33:09.497857	2
4	asdfdsf	1	40	2009-10-04 18:33:18.283535	2	2009-10-04 18:33:18.283535	2
5	adsfadsf	1	40	2009-10-04 18:33:51.708894	2	2009-10-04 18:33:51.708894	2
7	p1	1	43	2009-10-08 00:06:47.387729	2	2009-10-08 00:06:47.387729	2
\.


--
-- TOC entry 1998 (class 0 OID 17173)
-- Dependencies: 1566
-- Data for Name: programas; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY programas (id, descricao, interfaces, situacao_id, responsavel_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id, menu) FROM stdin;
7	V – GESTÃO DA EDUCAÇÃO E DO TRABALHO DO SUS	Fundap, Cosems, Instituições de Ensino, demais Coordenadorias e Órgãos da SES, outras secretarias do Estado de SP, MS, ObservaRHSP	1	12	2009-08-17 13:53:15.321	2	2009-08-17 13:53:15.321	2	PROGRAMA V
8	VI – TECNOLOGIAS E INOVAÇÕES EM SAÚDE	.	1	13	2009-08-17 13:56:28.301	2	2009-08-17 13:56:28.301	2	PROGRAMA VI
9	VII – CONTROLE DE RISCOS, DOENÇAS E AGRAVOS PRIORITÁRIOS NO ESTADO DE SÃO PAULO.	CSS, CRS, CCTIES, FESIMA, IAL, Instituto Pasteur, CVS, CPS/GTAE, CRH	1	14	2009-08-17 13:59:24.208	2	2009-08-17 13:59:24.208	2	PROGRAMA VII
11	VIII – DESENVOLVIMENTO DE SERVIÇOS E AÇÕES DE SAÚDE PARA SEGUIMENTOS DA POPULAÇÃO MAIS VULNERÁVEIS AOS RISCOS DE DOENÇAS OU COM NECESSIDADES ESPECÍFICAS	Programas I, II, II, IV, V, VI, IX, X	1	15	2009-08-17 14:03:01.154	2	2009-08-17 14:03:01.154	2	PROGRAMA VIII
12	IX – INCENTIVO AO DESENVOLVIMENTO DE AÇÕES DE PROMOÇÃO EM SAÚDE NO SUS	SES (CPS/GTAE, CRATOD, IS, CRS, CRH, GABINETE DO SECRETARIO)	1	14	2009-08-17 14:04:07.679	2	2009-08-17 14:04:07.679	2	PROGRAMA IX
13	X – FORTALECIMENTO DA PARTICIPAÇÃO DA COMUNIDADE E DO CONTROLE SOCIAL NA GESTÃO DO SUS	CRH, CGA,CPS,CRS e GS	1	16	2009-08-17 14:06:52.825	2	2009-08-17 14:06:52.825	2	PROGRAMA X
4	II - AMPLIAÇÃO DO ACESSO DA POPULAÇÃO, COM REDUÇÃO DE DESIGUALDADES REGIONAIS E APERFEIÇOAMENTO DA QUALIDADE DAS AÇÕES E SERVIÇOS DE SAÚDE	.	1	9	2009-08-17 11:54:46.841	2	2009-08-23 07:41:07	2	PROGRAMA II
5	III – GARANTIA DA EFICIÊNCIA, QUALIDADE E SEGURANÇA NA ASSISTÊNCIA FARMACÊUTICA E NOS OUTROS INSUMOS PARA A SAÚDE.	.	1	10	2009-08-17 13:39:45.21	2	2009-08-23 01:23:57	2	PROGRAMA III
6	IV – INVESTIR E MELHORAR OS SERVIÇOS PRÓPRIOS DE SAÚDE ESTADUAIS	Coordenadoria de Recursos Humanos e Instituições de Ensino	1	11	2009-08-17 13:46:15.682	2	2009-08-23 01:25:15	2	PROGRAMA IV
14	teste	sdfasdf	2	2	2009-08-23 19:58:28.783375	2	2009-08-23 08:28:53	2	descteste
15	teste2	asdf	2	2	2009-08-23 20:09:40.543811	2	2009-08-23 08:31:26	2	menuteste2
25	Novo programa	asdfasdfasdf	2	22	2009-09-24 21:33:58.049133	2	2009-09-24 11:29:55	2	xxxxxxxxsssss
2	I - FORTALECIMENTO E APERFEIÇOAMENTO DA CAPACIDADE DE GESTÃO ESTADUAL	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	8	2009-08-17 11:48:23.12	2	2009-09-24 11:36:20	2	PROGRAMA I
\.


--
-- TOC entry 1999 (class 0 OID 17185)
-- Dependencies: 1568
-- Data for Name: projetos; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY projetos (id, descricao, interfaces, situacao_id, programa_id, responsavel_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id, menu, projeto_id) FROM stdin;
4	PROJETO I.2 – Aprimoramento dos Sistemas de Informação do SUS/SP	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	2	18	2009-08-17 16:21:51.825	2	2009-08-17 16:21:51.825	2	PROJETO I.2	\N
3	PROJETO I.1 – Fortalecimento e Aperfeiçoamento da Atenção Básica	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	2	17	2009-08-17 15:57:59.819	2	2009-08-29 11:22:46	2	PROJETO I	\N
11	PROJETO II. 2 – Manutenções de Programas de Auxílio Financeiros às Entidades Filantrópicas do Estado - Pró Santa Casa	CGA, CPS, GS 	1	4	22	2009-08-29 12:52:07.884228	2	2009-08-29 12:52:07.884228	2	PROJETO II.2	\N
10	PROJETO II. 1 – Monitoramento da Programação Pactuada e Integrada do Estado de São Paulo	CPS, CSS, CGCSS	1	4	21	2009-08-29 12:13:53.433061	2	2009-08-29 12:55:27	2	PROJETO II.1	\N
15	Subprojeto I	;alksdfj  a;sdlfkjasdf;lkjasdf	1	2	2	2009-09-20 17:53:23.544016	2	2009-09-20 17:53:23.544016	2	subprojeto I	3
17	Projeto testeasdfasdfsdfsdaf	projeto	1	2	2	2009-09-24 23:05:17.313194	2	2009-09-24 11:19:40	2	projetox	\N
19	Mais um teste	asdfsadf	2	2	2	2009-09-24 23:28:30.27303	2	2009-09-24 11:34:08	2	xxxx	\N
18	Subprojeto xasdfadsf	salsdfkj	1	2	2	2009-09-24 23:13:18.542268	2	2009-09-24 11:39:26	2	subx	17
20	sub subprojeto	/zskfdj	1	2	2	2009-10-07 19:07:10.786592	2	2009-10-07 19:07:10.786592	2	sss	15
\.


--
-- TOC entry 2000 (class 0 OID 17196)
-- Dependencies: 1570
-- Data for Name: recursos; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY recursos (id, fonte, valor, destino, situacao, meta_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
\.


--
-- TOC entry 2001 (class 0 OID 17203)
-- Dependencies: 1572
-- Data for Name: situacoes; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY situacoes (id, descricao) FROM stdin;
1	Ativo
2	Inativo
\.


--
-- TOC entry 2002 (class 0 OID 17208)
-- Dependencies: 1574
-- Data for Name: tipo_periodo; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY tipo_periodo (id, periodo, descricao) FROM stdin;
\.


--
-- TOC entry 2003 (class 0 OID 17218)
-- Dependencies: 1577
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY usuarios (id, nome, username, password, email, situacao, salt) FROM stdin;
2	Marcone	marcone	2fb64b93b10c9687ad6b19f563fb0678	conca@mineirim.com	1	7bc25b2859701edae9b83011039ae886
6	Hugo Rodrigues	hugo	3f80bac6eeca65868ab2a79a4f9ead88	hugo@pbh.gov.br	1	88b21d284d79db949e747a437d88d862
8	Silvany Lemes Cruvinel Portas	silvany.portas	7e176dbc80454752fec46dd515746dee	silvany@	1	86bfeb4bcb0569b2413ef5ef0b15a55e
9	Luiz Maria Ramos Filho	luiz.filho	534af223ea7c50113e554dba7bdfadc3	luiz@	1	8eaa3dc683c88d83fb8f1566a45fe2ec
10	Ricardo Oliva	ricardo.oliva	fbcd43723027019f6d430a75047a47a0	ricardo@	1	db177ce7bb06c6317decf4f809e39a76
11	Ricardo Tardelli	ricardo.tardelli	f82de821e57976a4a799fd918b1f3817	ricardot@	1	765026ca6274c756b52bc8b96f46659b
12	Paulo Henrique D’ Ângelo Seixas	paulo.seixas	f6b0539bd0e9c59fa3419b7a31d91941	paulo@	1	95b62e43ae80ff2b32b642fbd04f2943
13	Sueli Gonsalez Saes	sueli.saes	eb8329e699ce3515379bb1b3b423e0cf	sueli	1	58ecf7939acbef81b57501db75981623
14	Clélia Maria S. de Souza Aranda	clelia.aranda	ef98e425468dec705ea899ce9a522c84	clelia	1	9c88690b7cd3de238f98f7f439136503
15	Sônia Barros	sonia.barros	2a93da9fdebe8b3f1aaf5ddd3c8aaf7f	sonia@	1	a5dfbe7bc09a1c4a7e846843c9d3848f
16	Mariângela Guanaes Bortolo da Cruz	mariangela.cruz	a5cd81b03c5fec81f290dc9f6ad2c8e4	mariangela	1	dc1178905ee54ff686f78151230320a1
17	Marta Campagnoni Andrade	marta.andrade	5ef9c330970f75f29e1ecd4dac7171a3	marta@	1	ed0f81c4c06f93585688041f4302e1d8
18	André Luiz de Almeida	andre.almeida	df68074e194abd07483c99cddca84487	andre	1	ee6f1cc616b48d93de6ee46c2384b1ce
19	Francisco Cardoso	chico	cbda27b272b6e8886cdf697093e01131	cardoso@medicina.ufmg.br	1	0f0b1553bc84be04494447970d23986d
20	cardoso	cardoso	8def13d2fec3ceddf8f54196de1174df	cardoso@medicina.ufmg.br	1	51043f5380b151414a8804bd4eec9788
21	Fátima Palmeira Bombarda	fatima.bombarda	04c84e073fe00d75a7306d3ee045c155	fatima@	1	4605372f8f9d4c1c9ac072831b3cf61a
22	Edson Lopes Mergulhão	edson.mergulhao	8692edce8bc9cf6de27f9efae5edc7bd	edson@	1	64a8b9fe5ddd11188b77a1875018c466
\.


--
-- TOC entry 2004 (class 0 OID 17226)
-- Dependencies: 1578
-- Data for Name: usuarios_grupos; Type: TABLE DATA; Schema: public; Owner: dbmonitora
--

COPY usuarios_grupos (id, usuario_id, grupo_id) FROM stdin;
4	2	1
6	6	4
7	6	5
8	6	1
11	8	4
12	8	2
13	8	3
14	9	4
15	9	3
16	10	4
17	10	3
18	11	4
19	11	2
20	11	3
21	12	4
22	12	2
23	12	3
24	13	4
25	13	2
26	13	3
27	14	4
28	14	2
29	14	3
30	15	4
31	15	2
32	15	3
33	16	4
34	16	2
35	16	3
36	17	6
37	17	2
38	17	3
39	18	4
40	18	2
41	18	3
42	19	5
43	19	2
44	19	3
45	19	1
46	20	6
47	21	4
48	21	3
49	22	3
\.


--
-- TOC entry 1952 (class 2606 OID 17559)
-- Dependencies: 1582 1582
-- Name: pk_acao_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY acoes
    ADD CONSTRAINT pk_acao_id PRIMARY KEY (id);


--
-- TOC entry 1958 (class 2606 OID 17592)
-- Dependencies: 1586 1586
-- Name: pk_estrategia_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY estrategias_acao
    ADD CONSTRAINT pk_estrategia_id PRIMARY KEY (id);


--
-- TOC entry 1910 (class 2606 OID 17262)
-- Dependencies: 1545 1545
-- Name: pk_grupo_permissao_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY grupos_permissoes
    ADD CONSTRAINT pk_grupo_permissao_id PRIMARY KEY (id);


--
-- TOC entry 1912 (class 2606 OID 17264)
-- Dependencies: 1547 1547
-- Name: pk_indicador_configs_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY indicador_config
    ADD CONSTRAINT pk_indicador_configs_id PRIMARY KEY (id);


--
-- TOC entry 1914 (class 2606 OID 17266)
-- Dependencies: 1549 1549
-- Name: pk_indicador_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY indicadores
    ADD CONSTRAINT pk_indicador_id PRIMARY KEY (id);


--
-- TOC entry 1916 (class 2606 OID 17268)
-- Dependencies: 1551 1551
-- Name: pk_indicadores_programa_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY indicadores_programa
    ADD CONSTRAINT pk_indicadores_programa_id PRIMARY KEY (id);


--
-- TOC entry 1918 (class 2606 OID 17270)
-- Dependencies: 1553 1553
-- Name: pk_indicadores_projeto_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY indicadores_projeto
    ADD CONSTRAINT pk_indicadores_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1962 (class 2606 OID 17609)
-- Dependencies: 1588 1588
-- Name: pk_meta_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY metas_acao
    ADD CONSTRAINT pk_meta_id PRIMARY KEY (id);


--
-- TOC entry 1920 (class 2606 OID 17274)
-- Dependencies: 1555 1555
-- Name: pk_meta_programas_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY metas_programa
    ADD CONSTRAINT pk_meta_programas_id PRIMARY KEY (id);


--
-- TOC entry 1922 (class 2606 OID 17276)
-- Dependencies: 1557 1557
-- Name: pk_metas_projeto_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY metas_projeto
    ADD CONSTRAINT pk_metas_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1954 (class 2606 OID 17576)
-- Dependencies: 1584 1584
-- Name: pk_objetivos_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY objetivos_acao
    ADD CONSTRAINT pk_objetivos_id PRIMARY KEY (id);


--
-- TOC entry 1924 (class 2606 OID 17280)
-- Dependencies: 1559 1559
-- Name: pk_objetivos_programas_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY objetivos_programa
    ADD CONSTRAINT pk_objetivos_programas_id PRIMARY KEY (id);


--
-- TOC entry 1926 (class 2606 OID 17282)
-- Dependencies: 1561 1561
-- Name: pk_objetivos_projeto_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY objetivos_projeto
    ADD CONSTRAINT pk_objetivos_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1964 (class 2606 OID 17713)
-- Dependencies: 1590 1590
-- Name: pk_parceria_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY parcerias_acao
    ADD CONSTRAINT pk_parceria_id PRIMARY KEY (id);


--
-- TOC entry 1928 (class 2606 OID 17286)
-- Dependencies: 1563 1563
-- Name: pk_permissao_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY paginas
    ADD CONSTRAINT pk_permissao_id PRIMARY KEY (id);


--
-- TOC entry 1930 (class 2606 OID 17288)
-- Dependencies: 1566 1566
-- Name: pk_programas_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT pk_programas_id PRIMARY KEY (id);


--
-- TOC entry 1934 (class 2606 OID 17290)
-- Dependencies: 1568 1568
-- Name: pk_projeto_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY projetos
    ADD CONSTRAINT pk_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1938 (class 2606 OID 17292)
-- Dependencies: 1570 1570
-- Name: pk_recursos_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY recursos
    ADD CONSTRAINT pk_recursos_id PRIMARY KEY (id);


--
-- TOC entry 1908 (class 2606 OID 17294)
-- Dependencies: 1543 1543
-- Name: pk_roles_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY grupos
    ADD CONSTRAINT pk_roles_id PRIMARY KEY (id);


--
-- TOC entry 1942 (class 2606 OID 17296)
-- Dependencies: 1572 1572
-- Name: pk_situacao_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY situacoes
    ADD CONSTRAINT pk_situacao_id PRIMARY KEY (id);


--
-- TOC entry 1944 (class 2606 OID 17298)
-- Dependencies: 1574 1574
-- Name: pk_tipo_periodo_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY tipo_periodo
    ADD CONSTRAINT pk_tipo_periodo_id PRIMARY KEY (id);


--
-- TOC entry 1949 (class 2606 OID 17300)
-- Dependencies: 1578 1578
-- Name: pk_users_roles_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY usuarios_grupos
    ADD CONSTRAINT pk_users_roles_id PRIMARY KEY (id);


--
-- TOC entry 1946 (class 2606 OID 17302)
-- Dependencies: 1577 1577
-- Name: pk_usuarios_id; Type: CONSTRAINT; Schema: public; Owner: dbmonitora; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT pk_usuarios_id PRIMARY KEY (id);


--
-- TOC entry 1950 (class 1259 OID 17565)
-- Dependencies: 1582
-- Name: acoes_projeto_id_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX acoes_projeto_id_index ON acoes USING btree (projeto_id);


--
-- TOC entry 1955 (class 1259 OID 17598)
-- Dependencies: 1586
-- Name: estrategias_objetivo_id_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX estrategias_objetivo_id_index ON estrategias_acao USING btree (objetivo_id);


--
-- TOC entry 1956 (class 1259 OID 17599)
-- Dependencies: 1586
-- Name: estrategias_situacao_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX estrategias_situacao_index ON estrategias_acao USING btree (situacao_id);


--
-- TOC entry 1959 (class 1259 OID 17615)
-- Dependencies: 1588
-- Name: metas_objetivo_id_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX metas_objetivo_id_index ON metas_acao USING btree (objetivo_id);


--
-- TOC entry 1960 (class 1259 OID 17616)
-- Dependencies: 1588
-- Name: metas_situacao_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX metas_situacao_index ON metas_acao USING btree (situacao_id);


--
-- TOC entry 1931 (class 1259 OID 17312)
-- Dependencies: 1566
-- Name: programas_alteracao_usuario_id_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX programas_alteracao_usuario_id_index ON programas USING btree (alteracao_usuario_id);


--
-- TOC entry 1932 (class 1259 OID 17313)
-- Dependencies: 1566
-- Name: programas_responsavel_id_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX programas_responsavel_id_index ON programas USING btree (responsavel_id);


--
-- TOC entry 1935 (class 1259 OID 17314)
-- Dependencies: 1568
-- Name: projetos_programa_id_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX projetos_programa_id_index ON projetos USING btree (programa_id);


--
-- TOC entry 1936 (class 1259 OID 17315)
-- Dependencies: 1568
-- Name: projetos_situacao_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX projetos_situacao_index ON projetos USING btree (situacao_id);


--
-- TOC entry 1939 (class 1259 OID 17316)
-- Dependencies: 1570
-- Name: recursos_meta_id_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX recursos_meta_id_index ON recursos USING btree (meta_id);


--
-- TOC entry 1940 (class 1259 OID 17317)
-- Dependencies: 1570
-- Name: recursos_situacao_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX recursos_situacao_index ON recursos USING btree (situacao);


--
-- TOC entry 1947 (class 1259 OID 17318)
-- Dependencies: 1577
-- Name: usuarios_username_index; Type: INDEX; Schema: public; Owner: dbmonitora; Tablespace: 
--

CREATE INDEX usuarios_username_index ON usuarios USING btree (username);


--
-- TOC entry 1984 (class 2606 OID 17577)
-- Dependencies: 1584 1951 1582
-- Name: fk_acao_objetivo; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY objetivos_acao
    ADD CONSTRAINT fk_acao_objetivo FOREIGN KEY (acao_id) REFERENCES acoes(id);


--
-- TOC entry 1983 (class 2606 OID 17560)
-- Dependencies: 1933 1582 1568
-- Name: fk_acoes_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY acoes
    ADD CONSTRAINT fk_acoes_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id);


--
-- TOC entry 1965 (class 2606 OID 17329)
-- Dependencies: 1545 1543 1907
-- Name: fk_grupo_paginas; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY grupos_permissoes
    ADD CONSTRAINT fk_grupo_paginas FOREIGN KEY (grupo_id) REFERENCES grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1981 (class 2606 OID 17334)
-- Dependencies: 1543 1578 1907
-- Name: fk_grupo_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY usuarios_grupos
    ADD CONSTRAINT fk_grupo_usuarios FOREIGN KEY (grupo_id) REFERENCES grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1967 (class 2606 OID 17339)
-- Dependencies: 1549 1913 1547
-- Name: fk_indicador_config_indicador_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY indicador_config
    ADD CONSTRAINT fk_indicador_config_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores(id);


--
-- TOC entry 1968 (class 2606 OID 17344)
-- Dependencies: 1574 1547 1943
-- Name: fk_indicador_config_tipo_periodo_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY indicador_config
    ADD CONSTRAINT fk_indicador_config_tipo_periodo_id FOREIGN KEY (tipo_periodo_id) REFERENCES tipo_periodo(id);


--
-- TOC entry 1971 (class 2606 OID 17349)
-- Dependencies: 1547 1553 1911
-- Name: fk_indicador_projeto_indicador_config_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY indicadores_projeto
    ADD CONSTRAINT fk_indicador_projeto_indicador_config_id FOREIGN KEY (indicador_config_id) REFERENCES indicador_config(id);


--
-- TOC entry 1972 (class 2606 OID 17354)
-- Dependencies: 1553 1933 1568
-- Name: fk_indicador_projeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY indicadores_projeto
    ADD CONSTRAINT fk_indicador_projeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id);


--
-- TOC entry 1969 (class 2606 OID 17359)
-- Dependencies: 1547 1551 1911
-- Name: fk_indicadorprograma_indicador_config_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY indicadores_programa
    ADD CONSTRAINT fk_indicadorprograma_indicador_config_id FOREIGN KEY (indicador_config_id) REFERENCES indicador_config(id);


--
-- TOC entry 1970 (class 2606 OID 17364)
-- Dependencies: 1929 1551 1566
-- Name: fk_indicadorprograma_programa_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY indicadores_programa
    ADD CONSTRAINT fk_indicadorprograma_programa_id FOREIGN KEY (programa_id) REFERENCES programas(id);


--
-- TOC entry 1973 (class 2606 OID 17444)
-- Dependencies: 1566 1555 1929
-- Name: fk_metasprograma_programa_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY metas_programa
    ADD CONSTRAINT fk_metasprograma_programa_id FOREIGN KEY (programa_id) REFERENCES programas(id) ON DELETE CASCADE;


--
-- TOC entry 1974 (class 2606 OID 17449)
-- Dependencies: 1933 1557 1568
-- Name: fk_metasprojeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY metas_projeto
    ADD CONSTRAINT fk_metasprojeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE;


--
-- TOC entry 1985 (class 2606 OID 17593)
-- Dependencies: 1953 1586 1584
-- Name: fk_objetivo_estrategia; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY estrategias_acao
    ADD CONSTRAINT fk_objetivo_estrategia FOREIGN KEY (objetivo_id) REFERENCES objetivos_acao(id);


--
-- TOC entry 1986 (class 2606 OID 17610)
-- Dependencies: 1953 1588 1584
-- Name: fk_objetivo_meta; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY metas_acao
    ADD CONSTRAINT fk_objetivo_meta FOREIGN KEY (objetivo_id) REFERENCES objetivos_acao(id);


--
-- TOC entry 1975 (class 2606 OID 17454)
-- Dependencies: 1566 1559 1929
-- Name: fk_objetivoprograma_programa_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY objetivos_programa
    ADD CONSTRAINT fk_objetivoprograma_programa_id FOREIGN KEY (programa_id) REFERENCES programas(id) ON DELETE CASCADE;


--
-- TOC entry 1976 (class 2606 OID 17459)
-- Dependencies: 1561 1568 1933
-- Name: fk_objetivosprojeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY objetivos_projeto
    ADD CONSTRAINT fk_objetivosprojeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE;


--
-- TOC entry 1977 (class 2606 OID 17414)
-- Dependencies: 1577 1945 1566
-- Name: fk_programas_responsavel_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT fk_programas_responsavel_id FOREIGN KEY (responsavel_id) REFERENCES usuarios(id);


--
-- TOC entry 1979 (class 2606 OID 17419)
-- Dependencies: 1929 1568 1566
-- Name: fk_projeto_programa; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY projetos
    ADD CONSTRAINT fk_projeto_programa FOREIGN KEY (programa_id) REFERENCES programas(id);


--
-- TOC entry 1978 (class 2606 OID 17424)
-- Dependencies: 1941 1566 1572
-- Name: fk_situacoes_programas; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT fk_situacoes_programas FOREIGN KEY (situacao_id) REFERENCES situacoes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 1980 (class 2606 OID 17469)
-- Dependencies: 1933 1568 1568
-- Name: fk_subprojeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY projetos
    ADD CONSTRAINT fk_subprojeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id);


--
-- TOC entry 1982 (class 2606 OID 17429)
-- Dependencies: 1578 1945 1577
-- Name: fk_usuario_grupos; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY usuarios_grupos
    ADD CONSTRAINT fk_usuario_grupos FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1966 (class 2606 OID 17434)
-- Dependencies: 1927 1545 1563
-- Name: pagina_grupos; Type: FK CONSTRAINT; Schema: public; Owner: dbmonitora
--

ALTER TABLE ONLY grupos_permissoes
    ADD CONSTRAINT pagina_grupos FOREIGN KEY (pagina_id) REFERENCES paginas(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2014 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2009-10-08 08:23:12 BRT

--
-- PostgreSQL database dump complete
--

