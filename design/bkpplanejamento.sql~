--
-- PostgreSQL database dump
--

-- Started on 2009-10-24 11:25:47 BRST

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 377 (class 2612 OID 25915)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1549 (class 1259 OID 25916)
-- Dependencies: 1866 1867 1868 6
-- Name: acoes; Type: TABLE; Schema: public; Owner: planejamento; Tablespace: 
--

CREATE TABLE acoes (
    id integer NOT NULL,
    descricao character varying,
    recursos character varying,
    cronograma text,
    menu character varying(30),
    ordem integer,
    situacao_id smallint DEFAULT 1,
    projeto_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.acoes OWNER TO planejamento;

--
-- TOC entry 1550 (class 1259 OID 25925)
-- Dependencies: 1549 6
-- Name: acoes_id_seq; Type: SEQUENCE; Schema: public; Owner: planejamento
--

CREATE SEQUENCE acoes_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.acoes_id_seq OWNER TO planejamento;

--
-- TOC entry 2046 (class 0 OID 0)
-- Dependencies: 1550
-- Name: acoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: planejamento
--

ALTER SEQUENCE acoes_id_seq OWNED BY acoes.id;


--
-- TOC entry 2047 (class 0 OID 0)
-- Dependencies: 1550
-- Name: acoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('acoes_id_seq', 3, true);


--
-- TOC entry 1599 (class 1259 OID 26375)
-- Dependencies: 1924 1925 1926 1927 6
-- Name: atividades; Type: TABLE; Schema: public; Owner: planejamento; Tablespace: 
--

CREATE TABLE atividades (
    id integer NOT NULL,
    descricao character varying(300) NOT NULL,
    operacao_id integer NOT NULL,
    valor integer DEFAULT 0 NOT NULL,
    responsavel character varying(100),
    intersecao character varying(200),
    situacao_id integer DEFAULT 1 NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.atividades OWNER TO planejamento;

--
-- TOC entry 1598 (class 1259 OID 26373)
-- Dependencies: 1599 6
-- Name: atividades_id_seq; Type: SEQUENCE; Schema: public; Owner: planejamento
--

CREATE SEQUENCE atividades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.atividades_id_seq OWNER TO planejamento;

--
-- TOC entry 2048 (class 0 OID 0)
-- Dependencies: 1598
-- Name: atividades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: planejamento
--

ALTER SEQUENCE atividades_id_seq OWNED BY atividades.id;


--
-- TOC entry 2049 (class 0 OID 0)
-- Dependencies: 1598
-- Name: atividades_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('atividades_id_seq', 1, false);


--
-- TOC entry 1551 (class 1259 OID 25927)
-- Dependencies: 1871 1872 1873 6
-- Name: estrategias_acao; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
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


ALTER TABLE public.estrategias_acao OWNER TO postgres;

--
-- TOC entry 2050 (class 0 OID 0)
-- Dependencies: 1551
-- Name: TABLE estrategias_acao; Type: COMMENT; Schema: public; Owner: postgres
--

COMMENT ON TABLE estrategias_acao IS 'as estratégias das ações estão vinculadas ao objetivo da acao';


--
-- TOC entry 1552 (class 1259 OID 25933)
-- Dependencies: 6 1551
-- Name: estrategias_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE estrategias_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.estrategias_acao_id_seq OWNER TO postgres;

--
-- TOC entry 2051 (class 0 OID 0)
-- Dependencies: 1552
-- Name: estrategias_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE estrategias_acao_id_seq OWNED BY estrategias_acao.id;


--
-- TOC entry 2052 (class 0 OID 0)
-- Dependencies: 1552
-- Name: estrategias_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('estrategias_acao_id_seq', 6, true);


--
-- TOC entry 1553 (class 1259 OID 25935)
-- Dependencies: 6
-- Name: grupos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos (
    id integer NOT NULL,
    grupo character varying(50) NOT NULL,
    descricao character varying(200) NOT NULL
);


ALTER TABLE public.grupos OWNER TO postgres;

--
-- TOC entry 1554 (class 1259 OID 25938)
-- Dependencies: 1553 6
-- Name: grupos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.grupos_id_seq OWNER TO postgres;

--
-- TOC entry 2053 (class 0 OID 0)
-- Dependencies: 1554
-- Name: grupos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupos_id_seq OWNED BY grupos.id;


--
-- TOC entry 2054 (class 0 OID 0)
-- Dependencies: 1554
-- Name: grupos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupos_id_seq', 20, true);


--
-- TOC entry 1555 (class 1259 OID 25940)
-- Dependencies: 6
-- Name: grupos_permissoes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE grupos_permissoes (
    id integer NOT NULL,
    grupo_id integer NOT NULL,
    pagina_id integer
);


ALTER TABLE public.grupos_permissoes OWNER TO postgres;

--
-- TOC entry 1556 (class 1259 OID 25943)
-- Dependencies: 1555 6
-- Name: grupos_permissoes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE grupos_permissoes_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.grupos_permissoes_id_seq OWNER TO postgres;

--
-- TOC entry 2055 (class 0 OID 0)
-- Dependencies: 1556
-- Name: grupos_permissoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE grupos_permissoes_id_seq OWNED BY grupos_permissoes.id;


--
-- TOC entry 2056 (class 0 OID 0)
-- Dependencies: 1556
-- Name: grupos_permissoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('grupos_permissoes_id_seq', 7, true);


--
-- TOC entry 1557 (class 1259 OID 25945)
-- Dependencies: 6
-- Name: indicador_config; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicador_config (
    id integer NOT NULL,
    indicador_id integer NOT NULL,
    tipo_periodo_id integer NOT NULL
);


ALTER TABLE public.indicador_config OWNER TO postgres;

--
-- TOC entry 1558 (class 1259 OID 25948)
-- Dependencies: 1557 6
-- Name: indicador_config_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE indicador_config_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicador_config_id_seq OWNER TO postgres;

--
-- TOC entry 2057 (class 0 OID 0)
-- Dependencies: 1558
-- Name: indicador_config_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE indicador_config_id_seq OWNED BY indicador_config.id;


--
-- TOC entry 2058 (class 0 OID 0)
-- Dependencies: 1558
-- Name: indicador_config_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('indicador_config_id_seq', 1, false);


--
-- TOC entry 1559 (class 1259 OID 25950)
-- Dependencies: 1878 1879 6
-- Name: indicadores; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicadores (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.indicadores OWNER TO postgres;

--
-- TOC entry 1560 (class 1259 OID 25958)
-- Dependencies: 1559 6
-- Name: indicadores_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE indicadores_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicadores_id_seq OWNER TO postgres;

--
-- TOC entry 2059 (class 0 OID 0)
-- Dependencies: 1560
-- Name: indicadores_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE indicadores_id_seq OWNED BY indicadores.id;


--
-- TOC entry 2060 (class 0 OID 0)
-- Dependencies: 1560
-- Name: indicadores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('indicadores_id_seq', 151, true);


--
-- TOC entry 1593 (class 1259 OID 26321)
-- Dependencies: 6
-- Name: indicadores_programa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicadores_programa (
    id integer NOT NULL,
    programa_id integer NOT NULL,
    indicador_id integer NOT NULL
);


ALTER TABLE public.indicadores_programa OWNER TO postgres;

--
-- TOC entry 1592 (class 1259 OID 26319)
-- Dependencies: 1593 6
-- Name: indicadores_programa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE indicadores_programa_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicadores_programa_id_seq OWNER TO postgres;

--
-- TOC entry 2061 (class 0 OID 0)
-- Dependencies: 1592
-- Name: indicadores_programa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE indicadores_programa_id_seq OWNED BY indicadores_programa.id;


--
-- TOC entry 2062 (class 0 OID 0)
-- Dependencies: 1592
-- Name: indicadores_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('indicadores_programa_id_seq', 14, true);


--
-- TOC entry 1595 (class 1259 OID 26339)
-- Dependencies: 6
-- Name: indicadores_projeto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE indicadores_projeto (
    id integer NOT NULL,
    projeto_id integer NOT NULL,
    indicador_id integer NOT NULL
);


ALTER TABLE public.indicadores_projeto OWNER TO postgres;

--
-- TOC entry 1594 (class 1259 OID 26337)
-- Dependencies: 6 1595
-- Name: indicadores_projeto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE indicadores_projeto_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.indicadores_projeto_id_seq OWNER TO postgres;

--
-- TOC entry 2063 (class 0 OID 0)
-- Dependencies: 1594
-- Name: indicadores_projeto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE indicadores_projeto_id_seq OWNED BY indicadores_projeto.id;


--
-- TOC entry 2064 (class 0 OID 0)
-- Dependencies: 1594
-- Name: indicadores_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('indicadores_projeto_id_seq', 137, true);


--
-- TOC entry 1561 (class 1259 OID 25970)
-- Dependencies: 1881 1882 1883 6
-- Name: metas_acao; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
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


ALTER TABLE public.metas_acao OWNER TO postgres;

--
-- TOC entry 1562 (class 1259 OID 25976)
-- Dependencies: 1561 6
-- Name: metas_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE metas_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.metas_acao_id_seq OWNER TO postgres;

--
-- TOC entry 2065 (class 0 OID 0)
-- Dependencies: 1562
-- Name: metas_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE metas_acao_id_seq OWNED BY metas_acao.id;


--
-- TOC entry 2066 (class 0 OID 0)
-- Dependencies: 1562
-- Name: metas_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('metas_acao_id_seq', 5, true);


--
-- TOC entry 1563 (class 1259 OID 25978)
-- Dependencies: 6
-- Name: metas_programa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE metas_programa (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    programa_id integer NOT NULL
);


ALTER TABLE public.metas_programa OWNER TO postgres;

--
-- TOC entry 1564 (class 1259 OID 25984)
-- Dependencies: 1563 6
-- Name: metas_programa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE metas_programa_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.metas_programa_id_seq OWNER TO postgres;

--
-- TOC entry 2067 (class 0 OID 0)
-- Dependencies: 1564
-- Name: metas_programa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE metas_programa_id_seq OWNED BY metas_programa.id;


--
-- TOC entry 2068 (class 0 OID 0)
-- Dependencies: 1564
-- Name: metas_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('metas_programa_id_seq', 13, true);


--
-- TOC entry 1565 (class 1259 OID 25986)
-- Dependencies: 6
-- Name: metas_projeto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE metas_projeto (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    projeto_id integer NOT NULL
);


ALTER TABLE public.metas_projeto OWNER TO postgres;

--
-- TOC entry 1566 (class 1259 OID 25992)
-- Dependencies: 6 1565
-- Name: metas_projeto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE metas_projeto_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.metas_projeto_id_seq OWNER TO postgres;

--
-- TOC entry 2069 (class 0 OID 0)
-- Dependencies: 1566
-- Name: metas_projeto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE metas_projeto_id_seq OWNED BY metas_projeto.id;


--
-- TOC entry 2070 (class 0 OID 0)
-- Dependencies: 1566
-- Name: metas_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('metas_projeto_id_seq', 133, true);


--
-- TOC entry 1567 (class 1259 OID 25994)
-- Dependencies: 1887 1888 1889 6
-- Name: objetivos_acao; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
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


ALTER TABLE public.objetivos_acao OWNER TO postgres;

--
-- TOC entry 1568 (class 1259 OID 26000)
-- Dependencies: 6 1567
-- Name: objetivos_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE objetivos_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.objetivos_acao_id_seq OWNER TO postgres;

--
-- TOC entry 2071 (class 0 OID 0)
-- Dependencies: 1568
-- Name: objetivos_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE objetivos_acao_id_seq OWNED BY objetivos_acao.id;


--
-- TOC entry 2072 (class 0 OID 0)
-- Dependencies: 1568
-- Name: objetivos_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('objetivos_acao_id_seq', 3, true);


--
-- TOC entry 1569 (class 1259 OID 26002)
-- Dependencies: 1891 6
-- Name: objetivos_programa; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE objetivos_programa (
    id integer NOT NULL,
    descricao character varying DEFAULT 500 NOT NULL,
    programa_id integer NOT NULL
);


ALTER TABLE public.objetivos_programa OWNER TO postgres;

--
-- TOC entry 1570 (class 1259 OID 26009)
-- Dependencies: 1569 6
-- Name: objetivos_programa_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE objetivos_programa_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.objetivos_programa_id_seq OWNER TO postgres;

--
-- TOC entry 2073 (class 0 OID 0)
-- Dependencies: 1570
-- Name: objetivos_programa_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE objetivos_programa_id_seq OWNED BY objetivos_programa.id;


--
-- TOC entry 2074 (class 0 OID 0)
-- Dependencies: 1570
-- Name: objetivos_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('objetivos_programa_id_seq', 11, true);


--
-- TOC entry 1571 (class 1259 OID 26011)
-- Dependencies: 6
-- Name: objetivos_projeto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE objetivos_projeto (
    id integer NOT NULL,
    descricao character varying NOT NULL,
    projeto_id integer NOT NULL
);


ALTER TABLE public.objetivos_projeto OWNER TO postgres;

--
-- TOC entry 1572 (class 1259 OID 26017)
-- Dependencies: 1571 6
-- Name: objetivos_projeto_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE objetivos_projeto_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.objetivos_projeto_id_seq OWNER TO postgres;

--
-- TOC entry 2075 (class 0 OID 0)
-- Dependencies: 1572
-- Name: objetivos_projeto_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE objetivos_projeto_id_seq OWNED BY objetivos_projeto.id;


--
-- TOC entry 2076 (class 0 OID 0)
-- Dependencies: 1572
-- Name: objetivos_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('objetivos_projeto_id_seq', 122, true);


--
-- TOC entry 1597 (class 1259 OID 26358)
-- Dependencies: 1920 1921 1922 6
-- Name: operacoes; Type: TABLE; Schema: public; Owner: planejamento; Tablespace: 
--

CREATE TABLE operacoes (
    id integer NOT NULL,
    descricao character varying(300) NOT NULL,
    metas_acao_id integer NOT NULL,
    situacao_id integer DEFAULT 1 NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.operacoes OWNER TO planejamento;

--
-- TOC entry 1596 (class 1259 OID 26356)
-- Dependencies: 1597 6
-- Name: operacoes_id_seq; Type: SEQUENCE; Schema: public; Owner: planejamento
--

CREATE SEQUENCE operacoes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.operacoes_id_seq OWNER TO planejamento;

--
-- TOC entry 2077 (class 0 OID 0)
-- Dependencies: 1596
-- Name: operacoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: planejamento
--

ALTER SEQUENCE operacoes_id_seq OWNED BY operacoes.id;


--
-- TOC entry 2078 (class 0 OID 0)
-- Dependencies: 1596
-- Name: operacoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('operacoes_id_seq', 1, false);


--
-- TOC entry 1573 (class 1259 OID 26019)
-- Dependencies: 6
-- Name: paginas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE paginas (
    id integer NOT NULL,
    descricao character varying(100) NOT NULL,
    pagina character varying(200) NOT NULL,
    acao character varying
);


ALTER TABLE public.paginas OWNER TO postgres;

--
-- TOC entry 1574 (class 1259 OID 26025)
-- Dependencies: 1573 6
-- Name: paginas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE paginas_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.paginas_id_seq OWNER TO postgres;

--
-- TOC entry 2079 (class 0 OID 0)
-- Dependencies: 1574
-- Name: paginas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE paginas_id_seq OWNED BY paginas.id;


--
-- TOC entry 2080 (class 0 OID 0)
-- Dependencies: 1574
-- Name: paginas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('paginas_id_seq', 2, true);


--
-- TOC entry 1575 (class 1259 OID 26027)
-- Dependencies: 1895 1896 1897 6
-- Name: parcerias_acao; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
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


ALTER TABLE public.parcerias_acao OWNER TO postgres;

--
-- TOC entry 1576 (class 1259 OID 26033)
-- Dependencies: 1575 6
-- Name: parcerias_acao_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE parcerias_acao_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.parcerias_acao_id_seq OWNER TO postgres;

--
-- TOC entry 2081 (class 0 OID 0)
-- Dependencies: 1576
-- Name: parcerias_acao_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE parcerias_acao_id_seq OWNED BY parcerias_acao.id;


--
-- TOC entry 2082 (class 0 OID 0)
-- Dependencies: 1576
-- Name: parcerias_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('parcerias_acao_id_seq', 7, true);


--
-- TOC entry 1577 (class 1259 OID 26037)
-- Dependencies: 1899 1900 1901 6
-- Name: programas; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE programas (
    id integer NOT NULL,
    descricao character varying(500) NOT NULL,
    interfaces character varying(200) NOT NULL,
    menu character varying(20),
    ordem integer,
    situacao_id smallint DEFAULT 1 NOT NULL,
    responsavel_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.programas OWNER TO postgres;

--
-- TOC entry 1578 (class 1259 OID 26047)
-- Dependencies: 6 1577
-- Name: programas_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE programas_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.programas_id_seq OWNER TO postgres;

--
-- TOC entry 2083 (class 0 OID 0)
-- Dependencies: 1578
-- Name: programas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE programas_id_seq OWNED BY programas.id;


--
-- TOC entry 2084 (class 0 OID 0)
-- Dependencies: 1578
-- Name: programas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('programas_id_seq', 12, true);


--
-- TOC entry 1579 (class 1259 OID 26049)
-- Dependencies: 1904 1905 1906 6
-- Name: projetos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE projetos (
    id integer NOT NULL,
    descricao character varying,
    interfaces character varying,
    menu character varying(20),
    ordem integer,
    situacao_id smallint DEFAULT 1 NOT NULL,
    programa_id integer,
    projeto_id integer,
    responsavel_id integer NOT NULL,
    inclusao_data timestamp without time zone DEFAULT now() NOT NULL,
    inclusao_usuario_id integer NOT NULL,
    alteracao_data timestamp without time zone DEFAULT now() NOT NULL,
    alteracao_usuario_id integer NOT NULL
);


ALTER TABLE public.projetos OWNER TO postgres;

--
-- TOC entry 1580 (class 1259 OID 26058)
-- Dependencies: 1579 6
-- Name: projetos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE projetos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.projetos_id_seq OWNER TO postgres;

--
-- TOC entry 2085 (class 0 OID 0)
-- Dependencies: 1580
-- Name: projetos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE projetos_id_seq OWNED BY projetos.id;


--
-- TOC entry 2086 (class 0 OID 0)
-- Dependencies: 1580
-- Name: projetos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('projetos_id_seq', 113, true);


--
-- TOC entry 1581 (class 1259 OID 26060)
-- Dependencies: 1909 1910 6
-- Name: recursos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
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


ALTER TABLE public.recursos OWNER TO postgres;

--
-- TOC entry 1582 (class 1259 OID 26065)
-- Dependencies: 6 1581
-- Name: recursos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE recursos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.recursos_id_seq OWNER TO postgres;

--
-- TOC entry 2087 (class 0 OID 0)
-- Dependencies: 1582
-- Name: recursos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE recursos_id_seq OWNED BY recursos.id;


--
-- TOC entry 2088 (class 0 OID 0)
-- Dependencies: 1582
-- Name: recursos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('recursos_id_seq', 1, false);


--
-- TOC entry 1583 (class 1259 OID 26067)
-- Dependencies: 6
-- Name: situacoes; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE situacoes (
    id integer NOT NULL,
    descricao character varying(50) NOT NULL
);


ALTER TABLE public.situacoes OWNER TO postgres;

--
-- TOC entry 1584 (class 1259 OID 26070)
-- Dependencies: 1583 6
-- Name: situacoes_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE situacoes_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.situacoes_id_seq OWNER TO postgres;

--
-- TOC entry 2089 (class 0 OID 0)
-- Dependencies: 1584
-- Name: situacoes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE situacoes_id_seq OWNED BY situacoes.id;


--
-- TOC entry 2090 (class 0 OID 0)
-- Dependencies: 1584
-- Name: situacoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('situacoes_id_seq', 2, true);


--
-- TOC entry 1585 (class 1259 OID 26072)
-- Dependencies: 6
-- Name: tipo_periodo; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE tipo_periodo (
    id integer NOT NULL,
    periodo character varying NOT NULL,
    descricao character varying NOT NULL
);


ALTER TABLE public.tipo_periodo OWNER TO postgres;

--
-- TOC entry 1586 (class 1259 OID 26078)
-- Dependencies: 1585 6
-- Name: tipo_periodo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE tipo_periodo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.tipo_periodo_id_seq OWNER TO postgres;

--
-- TOC entry 2091 (class 0 OID 0)
-- Dependencies: 1586
-- Name: tipo_periodo_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE tipo_periodo_id_seq OWNED BY tipo_periodo.id;


--
-- TOC entry 2092 (class 0 OID 0)
-- Dependencies: 1586
-- Name: tipo_periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('tipo_periodo_id_seq', 1, false);


--
-- TOC entry 1587 (class 1259 OID 26080)
-- Dependencies: 6
-- Name: usuarios_id; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_id
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id OWNER TO postgres;

--
-- TOC entry 2093 (class 0 OID 0)
-- Dependencies: 1587
-- Name: usuarios_id; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_id', 1, false);


--
-- TOC entry 1588 (class 1259 OID 26082)
-- Dependencies: 1914 1915 6
-- Name: usuarios; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
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


ALTER TABLE public.usuarios OWNER TO postgres;

--
-- TOC entry 1589 (class 1259 OID 26090)
-- Dependencies: 6
-- Name: usuarios_grupos; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE usuarios_grupos (
    id integer NOT NULL,
    usuario_id integer NOT NULL,
    grupo_id integer NOT NULL
);


ALTER TABLE public.usuarios_grupos OWNER TO postgres;

--
-- TOC entry 1590 (class 1259 OID 26093)
-- Dependencies: 1589 6
-- Name: usuarios_grupos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_grupos_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.usuarios_grupos_id_seq OWNER TO postgres;

--
-- TOC entry 2094 (class 0 OID 0)
-- Dependencies: 1590
-- Name: usuarios_grupos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_grupos_id_seq OWNED BY usuarios_grupos.id;


--
-- TOC entry 2095 (class 0 OID 0)
-- Dependencies: 1590
-- Name: usuarios_grupos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_grupos_id_seq', 191, true);


--
-- TOC entry 1591 (class 1259 OID 26095)
-- Dependencies: 1588 6
-- Name: usuarios_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE usuarios_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.usuarios_id_seq OWNER TO postgres;

--
-- TOC entry 2096 (class 0 OID 0)
-- Dependencies: 1591
-- Name: usuarios_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE usuarios_id_seq OWNED BY usuarios.id;


--
-- TOC entry 2097 (class 0 OID 0)
-- Dependencies: 1591
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuarios_id_seq', 93, true);


--
-- TOC entry 1869 (class 2604 OID 26097)
-- Dependencies: 1550 1549
-- Name: id; Type: DEFAULT; Schema: public; Owner: planejamento
--

ALTER TABLE acoes ALTER COLUMN id SET DEFAULT nextval('acoes_id_seq'::regclass);


--
-- TOC entry 1870 (class 2604 OID 27004)
-- Dependencies: 1550 1549
-- Name: ordem; Type: DEFAULT; Schema: public; Owner: planejamento
--

ALTER TABLE acoes ALTER COLUMN ordem SET DEFAULT currval('acoes_id_seq'::regclass);


--
-- TOC entry 1923 (class 2604 OID 26378)
-- Dependencies: 1598 1599 1599
-- Name: id; Type: DEFAULT; Schema: public; Owner: planejamento
--

ALTER TABLE atividades ALTER COLUMN id SET DEFAULT nextval('atividades_id_seq'::regclass);


--
-- TOC entry 1874 (class 2604 OID 26098)
-- Dependencies: 1552 1551
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE estrategias_acao ALTER COLUMN id SET DEFAULT nextval('estrategias_acao_id_seq'::regclass);


--
-- TOC entry 1875 (class 2604 OID 26099)
-- Dependencies: 1554 1553
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE grupos ALTER COLUMN id SET DEFAULT nextval('grupos_id_seq'::regclass);


--
-- TOC entry 1876 (class 2604 OID 26100)
-- Dependencies: 1556 1555
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE grupos_permissoes ALTER COLUMN id SET DEFAULT nextval('grupos_permissoes_id_seq'::regclass);


--
-- TOC entry 1877 (class 2604 OID 26101)
-- Dependencies: 1558 1557
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE indicador_config ALTER COLUMN id SET DEFAULT nextval('indicador_config_id_seq'::regclass);


--
-- TOC entry 1880 (class 2604 OID 26102)
-- Dependencies: 1560 1559
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE indicadores ALTER COLUMN id SET DEFAULT nextval('indicadores_id_seq'::regclass);


--
-- TOC entry 1917 (class 2604 OID 26324)
-- Dependencies: 1593 1592 1593
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE indicadores_programa ALTER COLUMN id SET DEFAULT nextval('indicadores_programa_id_seq'::regclass);


--
-- TOC entry 1918 (class 2604 OID 26342)
-- Dependencies: 1595 1594 1595
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE indicadores_projeto ALTER COLUMN id SET DEFAULT nextval('indicadores_projeto_id_seq'::regclass);


--
-- TOC entry 1884 (class 2604 OID 26105)
-- Dependencies: 1562 1561
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE metas_acao ALTER COLUMN id SET DEFAULT nextval('metas_acao_id_seq'::regclass);


--
-- TOC entry 1885 (class 2604 OID 26106)
-- Dependencies: 1564 1563
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE metas_programa ALTER COLUMN id SET DEFAULT nextval('metas_programa_id_seq'::regclass);


--
-- TOC entry 1886 (class 2604 OID 26107)
-- Dependencies: 1566 1565
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE metas_projeto ALTER COLUMN id SET DEFAULT nextval('metas_projeto_id_seq'::regclass);


--
-- TOC entry 1890 (class 2604 OID 26108)
-- Dependencies: 1568 1567
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE objetivos_acao ALTER COLUMN id SET DEFAULT nextval('objetivos_acao_id_seq'::regclass);


--
-- TOC entry 1892 (class 2604 OID 26109)
-- Dependencies: 1570 1569
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE objetivos_programa ALTER COLUMN id SET DEFAULT nextval('objetivos_programa_id_seq'::regclass);


--
-- TOC entry 1893 (class 2604 OID 26110)
-- Dependencies: 1572 1571
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE objetivos_projeto ALTER COLUMN id SET DEFAULT nextval('objetivos_projeto_id_seq'::regclass);


--
-- TOC entry 1919 (class 2604 OID 26361)
-- Dependencies: 1597 1596 1597
-- Name: id; Type: DEFAULT; Schema: public; Owner: planejamento
--

ALTER TABLE operacoes ALTER COLUMN id SET DEFAULT nextval('operacoes_id_seq'::regclass);


--
-- TOC entry 1894 (class 2604 OID 26111)
-- Dependencies: 1574 1573
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE paginas ALTER COLUMN id SET DEFAULT nextval('paginas_id_seq'::regclass);


--
-- TOC entry 1898 (class 2604 OID 26112)
-- Dependencies: 1576 1575
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE parcerias_acao ALTER COLUMN id SET DEFAULT nextval('parcerias_acao_id_seq'::regclass);


--
-- TOC entry 1902 (class 2604 OID 27001)
-- Dependencies: 1578 1577
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE programas ALTER COLUMN id SET DEFAULT nextval('programas_id_seq'::regclass);


--
-- TOC entry 1903 (class 2604 OID 27002)
-- Dependencies: 1578 1577
-- Name: ordem; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE programas ALTER COLUMN ordem SET DEFAULT currval('programas_id_seq'::regclass);


--
-- TOC entry 1907 (class 2604 OID 26113)
-- Dependencies: 1580 1579
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE projetos ALTER COLUMN id SET DEFAULT nextval('projetos_id_seq'::regclass);


--
-- TOC entry 1908 (class 2604 OID 27003)
-- Dependencies: 1580 1579
-- Name: ordem; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE projetos ALTER COLUMN ordem SET DEFAULT currval('projetos_id_seq'::regclass);


--
-- TOC entry 1911 (class 2604 OID 26114)
-- Dependencies: 1582 1581
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE recursos ALTER COLUMN id SET DEFAULT nextval('recursos_id_seq'::regclass);


--
-- TOC entry 1912 (class 2604 OID 26115)
-- Dependencies: 1584 1583
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE situacoes ALTER COLUMN id SET DEFAULT nextval('situacoes_id_seq'::regclass);


--
-- TOC entry 1913 (class 2604 OID 26116)
-- Dependencies: 1586 1585
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE tipo_periodo ALTER COLUMN id SET DEFAULT nextval('tipo_periodo_id_seq'::regclass);


--
-- TOC entry 1916 (class 2604 OID 26117)
-- Dependencies: 1590 1589
-- Name: id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE usuarios_grupos ALTER COLUMN id SET DEFAULT nextval('usuarios_grupos_id_seq'::regclass);


--
-- TOC entry 2016 (class 0 OID 25916)
-- Dependencies: 1549
-- Data for Name: acoes; Type: TABLE DATA; Schema: public; Owner: planejamento
--

COPY acoes (id, descricao, recursos, cronograma, situacao_id, projeto_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id, ordem) FROM stdin;
1	Constituição de Grupo de gerenciadores técnicos para ações de atenção básica (AB)	Recurso SES	Janeiro de 2009	1	1	2009-10-22 20:33:07.108184	2	2009-10-22 20:33:07.108184	2	\N
2	Organização de Seminário Estadual de Atenção Básica	Recursos SES	Fevereiro/09 – Pactuação junto ao Conselho Estadual de Saúde, e Grupo Técnico Bipartite da AB\r\nAbril/09 – Pactuação junto à CIB\r\nMaio, junho e julho/09 – organização do evento\r\nAgosto /09 – realização do seminário	1	1	2009-10-23 13:55:49.492393	2	2009-10-23 13:55:49.492393	2	\N
3	Monitoramento e Avaliação da AB	Recursos do PROESF e da SES	Monitoramento e Avaliação contínua  durante o ano	1	1	2009-10-23 13:58:49.620107	2	2009-10-23 13:58:49.620107	2	\N
\.


--
-- TOC entry 2040 (class 0 OID 26375)
-- Dependencies: 1599
-- Data for Name: atividades; Type: TABLE DATA; Schema: public; Owner: planejamento
--

COPY atividades (id, descricao, operacao_id, valor, responsavel, intersecao, situacao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
\.


--
-- TOC entry 2017 (class 0 OID 25927)
-- Dependencies: 1551
-- Data for Name: estrategias_acao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY estrategias_acao (id, descricao, situacao_id, acao_id, objetivo_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
1	Escolha de pessoal  funcionário da SES	1	1	\N	2009-10-22 20:34:53.702256	2	2009-10-22 20:34:53.702256	2
2	Definição de adicional salarial referente ao desempenho da função de apoiador técnico da AB	1	1	\N	2009-10-22 20:35:23.517881	2	2009-10-22 20:35:23.517881	2
3	Pactuação junto ao COSEMS e Conselho Estadual de Saúde das normas para a organização, realização e participação.	1	2	\N	2009-10-23 13:56:22.568792	2	2009-10-23 13:56:22.568792	2
4	Atuação direta  dos apoiadores junto aos municípios	1	3	\N	2009-10-23 13:59:30.640644	2	2009-10-23 13:59:30.640644	2
5	Análise dos dados disponibilizados pelo núcleo de informação da SES	1	3	\N	2009-10-23 13:59:43.102371	2	2009-10-23 13:59:43.102371	2
6	Consultoria para monitoramento e avaliação periódica de AB	1	3	\N	2009-10-23 13:59:58.969977	2	2009-10-23 13:59:58.969977	2
\.


--
-- TOC entry 2018 (class 0 OID 25935)
-- Dependencies: 1553
-- Data for Name: grupos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupos (id, grupo, descricao) FROM stdin;
4	operadores	Operadores do sistema
5	analistas	Analistas de sistema
2	gerentes	Gerente
3	coordenador	Coordenadores de projetos
1	administradores	Administrador do Sistema
19	teste	teste de grupo
6	anonimo	Usuário anônimo
20	usuario	Usuário Comum
\.


--
-- TOC entry 2019 (class 0 OID 25940)
-- Dependencies: 1555
-- Data for Name: grupos_permissoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY grupos_permissoes (id, grupo_id, pagina_id) FROM stdin;
1	1	1
2	5	1
3	3	1
4	2	1
5	1	2
6	5	2
7	2	2
\.


--
-- TOC entry 2020 (class 0 OID 25945)
-- Dependencies: 1557
-- Data for Name: indicador_config; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY indicador_config (id, indicador_id, tipo_periodo_id) FROM stdin;
\.


--
-- TOC entry 2021 (class 0 OID 25950)
-- Dependencies: 1559
-- Data for Name: indicadores; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY indicadores (id, descricao, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
1	municípios com menos de 100 mil hab. apoiados/ total de municípios com menos de 100 mil hab.;	2009-10-19 01:01:04.657081	2	2009-10-19 01:01:04.657081	2
2	nº de ações para implantação do sistema de monitoramento e avaliação realizadas / nº de ações planejadas;	2009-10-19 01:01:20.668967	2	2009-10-19 01:01:20.668967	2
3	nº de programas monitorados/nº total de programas do POA 2009	2009-10-19 01:02:16.646648	2	2009-10-19 01:02:16.646648	2
4	1 - Porcentagem dos municípios monitorados pela SES / total de municípios do Estado;	2009-10-19 01:10:13.057748	2	2009-10-19 01:10:13.057748	2
5	2 – Porcentagem de cobertura PSF em municípios com menos de 100 mil. hab.	2009-10-19 01:10:34.826771	2	2009-10-19 01:10:34.826771	2
6	Numero de ações completadas / total de ações propostas * 100	2009-10-19 01:14:13.771826	2	2009-10-19 01:14:13.771826	2
7	% atendido	2009-10-19 01:18:13.228591	2	2009-10-19 01:18:13.228591	2
8	Número de doses produzidas	2009-10-19 01:23:34.214204	2	2009-10-19 01:23:34.214204	2
9	nº de profissionais qualificados, n° de pessoas beneficiadas	2009-10-19 01:26:50.450115	2	2009-10-19 01:26:50.450115	2
10	1 - % dos profissionais da CRH envolvidos no processo de mudança do modelo gerencial de projetos a partir do “Banco de Idéias da CRH”	2009-10-19 01:29:28.219324	2	2009-10-19 01:29:28.219324	2
11	2 - % dos projetos no Sistema de Gerenciamento de Projetos da CRH. % dos gerentes de projetos e escritório de projetos capacitados no Curso de Gestão de Projetos	2009-10-19 01:29:39.547851	2	2009-10-19 01:29:39.547851	2
12	3 - % dos profissionais da SES participantes no Ciclo de Socialização do Conhecimento. Aumento nos acessos ao BLOG www.redeintegrarh.org\n% de profissionais da CRH envolvidos nas Rodas de Conversa da Rede IntegraRH	2009-10-19 01:29:47.189954	2	2009-10-19 01:29:47.189954	2
13	4 –aumento na articulação e apoio ao desenvolvimento gerencial para os cargos de comando  dos hospitais de administração direta da SES/SP	2009-10-19 01:30:02.059387	2	2009-10-19 01:30:02.059387	2
14	% de diretores certificados e  planos de desenvolvimento individual  implementados	2009-10-19 01:34:08.922907	2	2009-10-19 01:34:08.922907	2
15	% - projetos monitorados/total de projetos do POA 2009, %- planos regionais de desenvolvimento elaborados/total de regiões de saúde, %- propostas da PPI monitoradas/ total de propostas da PPI, %- indicadores do Pacto monitorados/total de indicadores do Pacto	2009-10-19 14:10:03.544791	2	2009-10-19 14:10:03.544791	2
16	nº de ações para implantação do sistema de monitoramento e avaliação realizadas / nº de ações planejadas	2009-10-19 14:14:15.356059	2	2009-10-19 14:14:15.356059	2
17	Taxa de mortalidade infantil e taxa de mortalidade materna	2009-10-19 14:17:19.355499	2	2009-10-19 14:17:19.355499	2
18	Número de avaliações macro regionais trimestrais realizadas/ número total de avaliações trimestrais macro regionais	2009-10-19 14:25:34.365489	2	2009-10-19 14:25:34.365489	2
19	Percentual de instituições monitoradas mensalmente em relação ao total de instituições no programa	2009-10-19 14:35:07.035392	2	2009-10-19 14:35:07.035392	2
20	nº de serviço contratado/nº de serviço existente	2009-10-19 14:39:21.130157	2	2009-10-19 14:39:21.130157	2
21	nº. de auditores capacitados / nº. de auditores designados	2009-10-21 10:15:45.246684	2	2009-10-21 10:15:45.246684	2
22	Metas atingidas de subprojetos/total demetas propostas de todos os subprojetos	2009-10-21 10:18:38.152967	2	2009-10-21 10:18:38.152967	2
23	número de redes monitoradas/ número de redes implantadas	2009-10-21 10:20:57.669612	2	2009-10-21 10:20:57.669612	2
24	Número de Hospitais de Ensino Contratualizados/numero de Hospitais de Ensino Certificados	2009-10-21 10:28:42.393886	2	2009-10-21 10:28:42.393886	2
25	Apresentação da Política Estadual para Hospitais de Pequeno Porte	2009-10-21 10:40:50.559152	2	2009-10-21 10:40:50.559152	2
26	Numero de AME implantado/ Numero de AME programados para implantação	2009-10-21 10:54:51.302086	2	2009-10-21 10:54:51.302086	2
27	Número de redes monitoradas/ número de redes implantadas	2009-10-21 10:59:43.949008	2	2009-10-21 10:59:43.949008	2
28	Total de mulheres com 40 anos ou mais / Total de mulheres que realizaram exames de mamografia /Total de mulheres de realizaram USG / Total de mulheres com resultados BI_RADIS 0 e 3.	2009-10-21 11:02:42.489881	2	2009-10-21 11:02:42.489881	2
29	Número de Complexos Reguladores implantados	2009-10-21 11:06:34.924742	2	2009-10-21 11:06:34.924742	2
30	Número de Complexos Reguladores implantados	2009-10-21 11:08:34.465203	2	2009-10-21 11:08:34.465203	2
31	1) nº de serviços novos.	2009-10-21 13:50:26.245585	2	2009-10-21 13:50:26.245585	2
32	2) % de serviços com Acolhimento com Avaliação de Risco.	2009-10-21 13:50:38.100602	2	2009-10-21 13:50:38.100602	2
33	3) Implantação do Contrato Programa	2009-10-21 13:50:50.126756	2	2009-10-21 13:50:50.126756	2
34	Número de Complexos Reguladores implantados	2009-10-21 14:03:20.502312	2	2009-10-21 14:03:20.502312	2
35	% de atendimento	2009-10-21 14:09:32.878787	2	2009-10-21 14:09:32.878787	2
36	Percentual de pacientes cadastrados/ atendidos	2009-10-21 14:13:00.15162	2	2009-10-21 14:13:00.15162	2
37	Percentual de serviços cadastrados	2009-10-21 14:16:58.979367	2	2009-10-21 14:16:58.979367	2
38	% de publicações e eventos realizados em relação aos previstos em 2009	2009-10-21 14:21:47.271598	2	2009-10-21 14:21:47.271598	2
39	% de unidades com acolhimento com avaliação de risco implantado	2009-10-21 14:33:28.184941	2	2009-10-21 14:33:28.184941	2
40	.	2009-10-21 14:36:23.43569	2	2009-10-21 14:36:23.43569	2
41	1) Número de serviços novos.	2009-10-21 15:16:48.832012	2	2009-10-21 15:16:48.832012	2
42	2) % de leitos ampliados.	2009-10-21 15:17:05.223525	2	2009-10-21 15:17:05.223525	2
43	Fomento da tríplice  inclusão: Trabalhadores, Gestores e Usuários na Atenção e Gestão das práticas de saúde.	2009-10-21 15:22:15.457394	2	2009-10-21 15:22:15.457394	2
44	Propostas de intervenção e ações pactuadas	2009-10-21 15:25:35.822883	2	2009-10-21 15:25:35.822883	2
45	nº de Relatórios elaborados; nº de Boletins Informativos elaborados; percentual de Unidades capacitadas para utilizar o sistema de informações	2009-10-21 15:30:38.311752	2	2009-10-21 15:30:38.311752	2
46	nº de projetos apresentados	2009-10-21 15:32:23.211585	2	2009-10-21 15:32:23.211585	2
47	relatórios produzidos	2009-10-21 15:39:36.000305	2	2009-10-21 15:39:36.000305	2
48	.	2009-10-21 15:50:26.295446	2	2009-10-21 15:50:26.295446	2
49	Carreira de gestor aprovada, normas de processos revistos e publicados, aposentadorias e reposições realizadas, novos sistemas de incentivos desenvolvidos.	2009-10-21 15:55:00.574385	2	2009-10-21 15:55:00.574385	2
50	.	2009-10-21 15:57:44.000606	2	2009-10-21 15:57:44.000606	2
51	Carreira de gestor aprovada, normas de processos revistos e publicados, aposentadorias e reposições realizadas, novos sistemas de incentivos desenvolvidos.	2009-10-21 16:01:16.071266	2	2009-10-21 16:01:16.071266	2
52	vagas criadas e concurso realizado	2009-10-21 16:03:22.79585	2	2009-10-21 16:03:22.79585	2
53	duração do processo de contagem de tempo para ratificação do tempo de contribuição (em meses)	2009-10-21 16:10:03.272146	2	2009-10-21 16:10:03.272146	2
54	nº de profissionais e categorias  contemplados	2009-10-21 16:19:54.157258	2	2009-10-21 16:19:54.157258	2
55	nº de PAREPS em desenvolvimento; sistema de registro implantado; nº salas de EAD implantadas; nº especialistas em gestão em Saúde formados, nº de formadores em EP formados; nº de formadores de nível médio formados	2009-10-21 16:33:05.505565	2	2009-10-21 16:33:05.505565	2
56	nº de PAREPS em desenvolvimento; sistema de registro implantado; nº salas de EAD implantadas; nº especialistas em gestão em Saúde formados, nº de formadores em EP formados; nº de formadores de nível médio formados	2009-10-21 16:34:53.47057	2	2009-10-21 16:34:53.47057	2
57	Número de propostas executadas	2009-10-21 16:46:36.053083	2	2009-10-21 16:46:36.053083	2
58	% de técnicos capacitados, frente à demanda apresentada	2009-10-21 16:50:02.124832	2	2009-10-21 16:50:02.124832	2
59	% de salas instaladas e plataforma implantada.	2009-10-21 16:53:42.155891	2	2009-10-21 16:53:42.155891	2
60	nº de gestores formados	2009-10-21 16:58:41.87621	2	2009-10-21 16:58:41.87621	2
61	Número de profissionais formados	2009-10-21 17:05:53.234126	2	2009-10-21 17:05:53.234126	2
62	Número de técnicos formados	2009-10-21 17:11:50.825175	2	2009-10-21 17:11:50.825175	2
63	Número de técnicos formados	2009-10-21 17:14:24.008413	2	2009-10-21 17:14:24.008413	2
64	1 - % de implantação dos gerenciadores da atenção básica em atividade .	2009-10-21 17:29:36.746307	2	2009-10-21 17:29:36.746307	2
65	2. nº de gestores qualificados	2009-10-21 17:29:47.119902	2	2009-10-21 17:29:47.119902	2
66	3  nº de enfermeiros qualificados	2009-10-21 17:29:59.044817	2	2009-10-21 17:29:59.044817	2
67	4. nº de escolas implantadas e em funcionamento	2009-10-21 17:30:11.535804	2	2009-10-21 17:30:11.535804	2
68	5. relatório de estudo apresentado	2009-10-21 17:30:20.758016	2	2009-10-21 17:30:20.758016	2
69	6. boas formas de gestão do trabalho desenvolvidas e discutidas	2009-10-21 17:30:31.570531	2	2009-10-21 17:30:31.570531	2
70	% de gerentes e enfermeiros qualificados	2009-10-21 17:45:50.750199	2	2009-10-21 17:45:50.750199	2
71	% de gerentes e enfermeiros qualificados	2009-10-21 17:45:51.014486	2	2009-10-21 17:45:51.014486	2
72	% de gerentes e enfermeiros qualificados	2009-10-21 17:46:58.789886	2	2009-10-21 17:46:58.789886	2
73	1 – estudos desenhados e desenvolvidos	2009-10-21 17:51:29.930673	2	2009-10-21 17:51:29.930673	2
74	2 - % de crescimento de bolsas em áreas prioritárias	2009-10-21 17:52:06.921279	2	2009-10-21 17:52:06.921279	2
75	3 - % de bolsas assumidas em projetos de financiamento global da instituição	2009-10-21 17:53:07.925311	2	2009-10-21 17:53:07.925311	2
76	4. % de incorporação de projetos de tutoria, bem como novas formas de financiamento adotadas	2009-10-21 17:53:33.365712	2	2009-10-21 17:53:33.365712	2
77	1 – estudos desenhados e desenvolvidos	2009-10-22 14:42:36.322838	2	2009-10-22 14:42:36.322838	2
78	2 - % de crescimento de bolsas em áreas prioritárias	2009-10-22 14:42:49.68529	2	2009-10-22 14:42:49.68529	2
79	3 - % de bolsas assumidas em projetos de financiamento global da instituição	2009-10-22 14:43:01.3821	2	2009-10-22 14:43:01.3821	2
80	4. % de incorporação de projetos de tutoria, bem como novas formas de financiamento adotadas	2009-10-22 14:43:14.108779	2	2009-10-22 14:43:14.108779	2
81	5. % de instituições avaliadas e modificações/integrações propostas	2009-10-22 14:43:27.033944	2	2009-10-22 14:43:27.033944	2
82	% de programas avaliados, % de recomendações propostas e propostas de integração implementadas.	2009-10-22 14:46:54.398177	2	2009-10-22 14:46:54.398177	2
83	Metodologias novas desenvolvidas no período. Número de patentes solicitadas. Inovações e tecnologias desenvolvidas para insumos, produtos e procedimentos médicos publicados, publicações científicas em revistas indexadas, Ações de capacitação	2009-10-22 14:51:18.956425	2	2009-10-22 14:51:18.956425	2
84	1. TX de Investigação = No. Doenças/Agravos Investigadas x 100\n                                                                                                                                     No. Doenças/Agravos Notificados	2009-10-22 15:50:13.64852	2	2009-10-22 15:50:13.64852	2
85	2.  Nº de municípios do estado de SP com Plano de Ação em Vigilância Sanitária pactuado x 100\nNº de municípios do estado de SP	2009-10-22 15:50:47.526431	2	2009-10-22 15:50:47.526431	2
86	Taxa de alcance de indicadores = nº. de indicadores com meta alcançada no período X 100\n                                                                                                             Nº. total de indicadores estabelecidos	2009-10-22 15:55:56.953172	2	2009-10-22 15:55:56.953172	2
87	1 - TX de Notificação de casos de PFA: No. Casos PFA notificados / Nº menores de 15 anos x 100 mil;	2009-10-22 15:59:30.846653	2	2009-10-22 15:59:30.846653	2
88	2 - Nº. casos suspeitos de sarampo e rubéola investigados adequadamente / Total de casos suspeitos notificados de sarampo e rubéola X 100; 3 - CV = doses aplicadas / população menor de um ano de idade x 100.	2009-10-22 15:59:42.750617	2	2009-10-22 15:59:42.750617	2
89	3 - CV = doses aplicadas / população menor de um ano de idade x 100.\nPara a CV de TV utilizar a população de um ano de idade; Homogeneidade = % de municípios que atingiram a meta/ nº total de municípios	2009-10-22 16:00:17.950458	2	2009-10-22 16:00:17.950458	2
90	2 - Nº. casos suspeitos de sarampo e rubéola investigados adequadamente / Total de casos suspeitos notificados de sarampo e rubéola X 100;	2009-10-22 16:02:13.185928	2	2009-10-22 16:02:13.185928	2
91	3 - CV = doses aplicadas / população menor de um ano de idade x 100.\nPara a CV de TV utilizar a população de um ano de idade; Homogeneidade = % de municípios que atingiram a meta/ nº total de municípios	2009-10-22 16:02:37.342009	2	2009-10-22 16:02:37.342009	2
92	Nº de hospitais notificantes / total de hospitais com critério para notificação X 100	2009-10-22 16:06:05.29838	2	2009-10-22 16:06:05.29838	2
93	nº de casos de meningites bacterianas com etiologia identificada/ nº total de meningites bacterianas	2009-10-22 16:07:46.384678	2	2009-10-22 16:07:46.384678	2
94	1 - Nº. de surtos investigados X 100 /nº total de surtos notificados/ registrados (CVE/ DTA);	2009-10-22 16:11:46.745978	2	2009-10-22 16:11:46.745978	2
95	2 - Tx de realização de exames/ diagnóstico etiológico;	2009-10-22 16:11:59.372856	2	2009-10-22 16:11:59.372856	2
96	3 - Nº. surtos com realização de testes laboratoriais X 100/ Nº total de surtos investigados	2009-10-22 16:12:12.906704	2	2009-10-22 16:12:12.906704	2
97	1 - letalidade da FHD e Leptospirose (nº óbitos pelo agravo X 100/ nº total casos;	2009-10-22 16:15:36.248637	2	2009-10-22 16:15:36.248637	2
98	2 - Incidência (nº casos novos X 100/população exposta;	2009-10-22 16:16:08.275212	2	2009-10-22 16:16:08.275212	2
99	3 - Nº. de exames realizados X 100/ nº total de amostras encaminhadas	2009-10-22 16:16:29.30675	2	2009-10-22 16:16:29.30675	2
100	1 - % de sintomáticos respiratório (SR) examinados;	2009-10-22 16:20:45.933129	2	2009-10-22 16:20:45.933129	2
101	2 - % de cura de B K;	2009-10-22 16:21:01.611689	2	2009-10-22 16:21:01.611689	2
102	3- Coeficiente de mortalidade (nº óbitos por TBC/ nº total de óbitos)	2009-10-22 16:21:29.137461	2	2009-10-22 16:21:29.137461	2
103	1 - Coeficiente de Prevalência no período de 2009 por município (nº casos novos e antigos/ população exposta);	2009-10-22 16:25:01.651409	2	2009-10-22 16:25:01.651409	2
104	2 - Proporção de Cura das Coortes MB2007 e PB2008;	2009-10-22 16:25:16.722271	2	2009-10-22 16:25:16.722271	2
105	3 - Coeficiente de Detecção em menores de 15 anos (nº casos detectados/ população	2009-10-22 16:25:47.38538	2	2009-10-22 16:25:47.38538	2
106	1 -  Número total de óbitos por Aids/ ano;	2009-10-22 16:32:40.471253	2	2009-10-22 16:32:40.471253	2
107	2 - Uma UBS com pontuação cinco em cada um dos municípios habilitados na política de incentivo;	2009-10-22 16:33:12.396818	2	2009-10-22 16:33:12.396818	2
108	3 - Número de UBS realizando triagem sorológica para hepatites B e C /Numero total de UBS	2009-10-22 16:33:50.898415	2	2009-10-22 16:33:50.898415	2
109	número de GVE com notificação implantada / total de GVE x 100	2009-10-22 16:38:38.507878	2	2009-10-22 16:38:38.507878	2
110	Nº de municípios do estado de SP com Plano de Ação em Vigilância Sanitária pactuado x 100\nNº de municípios do estado de SP	2009-10-22 16:41:18.190735	2	2009-10-22 16:41:18.190735	2
111	Nº de Serviços Hemoterápicos cadastrados no SIVSA pelo gestor municipal x 100\nNº de Serviços Hemoterápicos cadastrados no SIVSA	2009-10-22 16:45:20.822861	2	2009-10-22 16:45:20.822861	2
112	Nº de Serviços de Saúde e de Interesse da Saúde cadastrados no SIVSA pelo gestor municipal    X   100\nNº de Serviços de Saúde e de Interesse da Saúde cadastrados no SIVSA	2009-10-22 16:47:43.441496	2	2009-10-22 16:47:43.441496	2
113	Nº de estabelecimentos que comercializam produtos de interesse da saúde cadastrados no SIVSA pelo gestor municipal   x   100\nNº de estabelecimentos que comercializam produtos de interesse da saúde cadastrados no SIVSA	2009-10-22 16:50:36.621762	2	2009-10-22 16:50:36.621762	2
114	1 - Nº de GVS + SGVS do estado de SP capacitados no Módulo 1 do Programa Estadual de      x   100\n                                                                                                    Toxicovigilância	2009-10-22 16:55:24.726425	2	2009-10-22 16:55:24.726425	2
115	2 - Nº. de GVS + SGVS do estado de SP	2009-10-22 16:55:36.564786	2	2009-10-22 16:55:36.564786	2
116	Nº de análises realizadas pelo PROÁGUA com resultados adequados para o parâmetro flúor     x   100\nNº de análises realizadas pelo PROÁGUA para o parâmetro flúor	2009-10-22 16:58:28.929631	2	2009-10-22 16:58:28.929631	2
117	1 - Nº. listas mestras/ Nº UOS (Meta 60%);	2009-10-22 17:02:08.82794	2	2009-10-22 17:02:08.82794	2
118	2 - Nº. de unidades laboratoriais emitindo informações/ Nº de unidades laboratoriais existentes;	2009-10-22 17:02:21.816719	2	2009-10-22 17:02:21.816719	2
119	3 - Nº. de novas tecnologias implantadas	2009-10-22 17:02:33.704476	2	2009-10-22 17:02:33.704476	2
120	Nº de análises realizadas pelo PROÁGUA com resultados adequados para o parâmetro flúor     x   100\nNº de análises realizadas pelo PROÁGUA para o parâmetro flúor	2009-10-22 17:07:28.780753	2	2009-10-22 17:07:28.780753	2
121	1 - Nº. listas mestras/ Nº UOS (Meta 60%);	2009-10-22 17:09:35.811449	2	2009-10-22 17:09:35.811449	2
122	2 - Nº. de unidades laboratoriais emitindo informações/ Nº de unidades laboratoriais existentes;	2009-10-22 17:10:50.791285	2	2009-10-22 17:10:50.791285	2
123	3 - Nº. de novas tecnologias implantadas	2009-10-22 17:11:01.966025	2	2009-10-22 17:11:01.966025	2
124	Nº. de resultados emitidos/ nº de amostras cadastradas	2009-10-22 17:13:21.2845	2	2009-10-22 17:13:21.2845	2
125	Nº. técnicas implantadas/  nº. Técnicas previstas	2009-10-22 17:15:30.24261	2	2009-10-22 17:15:30.24261	2
126	Processo de certificação implantado auditorias realizadas e aprovadas	2009-10-22 17:16:46.65651	2	2009-10-22 17:16:46.65651	2
127	Número de serviços implantados e credenciados\nÍndices de cobertura populacional para o Estado de São Paulo	2009-10-22 17:35:09.993725	2	2009-10-22 17:35:09.993725	2
128	Acesso a primeira consulta odontológica.	2009-10-22 17:37:47.514072	2	2009-10-22 17:37:47.514072	2
129	Número de serviços recredenciados	2009-10-22 17:53:45.986905	2	2009-10-22 17:53:45.986905	2
130	0,50 de cobertura CAPS/ 100.000 habitantes no Estado de São Paulo	2009-10-22 17:57:00.732882	2	2009-10-22 17:57:00.732882	2
131	Índice de cobertura CAPS/ 100.000 habitantes no Estado de São Paulo	2009-10-22 18:01:18.175872	2	2009-10-22 18:01:18.175872	2
132	Número de projetos cadastrados, publicações, metodologias e tecnologias desenvolvidas e \nincorporadas pelo sistema.	2009-10-22 22:37:37.124052	2	2009-10-22 22:37:37.124052	2
133	Número de projetos para inovação apresentados e cadastrados nas Instituições de Pesquisa e relacionadas à agenda de prioridades em CT&I para o SUS-SP.	2009-10-23 09:27:50.816706	2	2009-10-23 09:27:50.816706	2
134	Número de projetos cadastrados  realizados em parcerias com entidades com expertise em C&T relacionadas à agenda de prioridades em C&T para o SUS-SP.	2009-10-23 09:29:30.563641	2	2009-10-23 09:29:30.563641	2
135	Operação descentralizada das fontes de informação do Portal, incluindo a operação e publicação dos acervos das instituições que integram a Rede; Obtenção de Portal de acesso aos textos completos de 4 periódicos científicos dos Institutos de Pesquisa da SES-SP operando com a metodologia SciELO e integrado com o Portal da Rede de Informação e Conhecimento da SES-SP	2009-10-23 09:32:25.115893	2	2009-10-23 09:32:25.115893	2
136	Capacitação de Recursos Humanos	2009-10-23 09:39:32.643286	2	2009-10-23 09:39:32.643286	2
137	Nº de serviços credenciados	2009-10-23 09:42:47.530274	2	2009-10-23 09:42:47.530274	2
138	nº de serviços avaliados e contratados/credenciados	2009-10-23 09:46:13.688391	2	2009-10-23 09:46:13.688391	2
139	Mortalidade Infantil	2009-10-23 09:49:47.070259	2	2009-10-23 09:49:47.070259	2
140	Número de ações/procedimentos realizados pela Secretaria de Estado da Saúde voltadas a estas populações	2009-10-23 09:54:38.561043	2	2009-10-23 09:54:38.561043	2
141	Numero de Vigilâncias Municipais envolvidas em ações nos processos produtivos prioritários em relação com o número total de municípios que apresentam os  processos produtivos prioritários	2009-10-23 09:58:13.453817	2	2009-10-23 09:58:13.453817	2
142	Morbidade Hospitalar por AVC,na população  40 anos, \n                                                  Morbidade Hospitalar por Diabetes na população  30 anos	2009-10-23 10:14:14.256565	2	2009-10-23 10:14:14.256565	2
143	Morbidade Hospitalar por AVC,na população  40 anos, \n Morbidade Hospitalar por Diabetes na população  30 anos	2009-10-23 10:14:58.018435	2	2009-10-23 10:14:58.018435	2
144	Morbidade Hospitalar por AVC,na população  40 anos, \n                                                  Morbidade Hospitalar por Diabetes na população  30 anos	2009-10-23 10:17:39.333192	2	2009-10-23 10:17:39.333192	2
145	Fórum realizado	2009-10-23 10:20:42.913824	2	2009-10-23 10:20:42.913824	2
146	número de interlocutores da DRS capacitados / total de DRSs x 100	2009-10-23 10:25:05.594264	2	2009-10-23 10:25:05.594264	2
147	número de Municípios com interlocutores capacitados / total de Municípios x 100	2009-10-23 10:28:32.50307	2	2009-10-23 10:28:32.50307	2
148	Oficinas de Participação Popular e Ouvidoria no Estado de São Paulo realizadas; seminários temáticos realizados; reuniões de comissões técnicas, grupos de trabalho e reuniões do Pleno do CES realizadas e Curso Piloto para conselheiros  estaduais realizado.	2009-10-23 10:33:17.589639	2	2009-10-23 10:33:17.589639	2
149	Oficinas de Participação Popular e Ouvidoria no Estado de São Paulo realizadas; seminários temáticos realizados; reuniões de comissões técnicas, grupos de trabalho e reuniões do Pleno do CES realizadas e Curso Piloto realizado.	2009-10-23 10:36:18.31483	2	2009-10-23 10:36:18.31483	2
150	Resultados dos Encontros	2009-10-23 10:39:13.609259	2	2009-10-23 10:39:13.609259	2
151	Número de GVS e SGVS do Estado de São Paulo capacitados para a execução das ações do PPVISAT-Canavieiro / Número de GVSs e SGVSs do Estado de São Paulo X 100	2009-10-23 10:57:57.704579	2	2009-10-23 10:57:57.704579	2
\.


--
-- TOC entry 2037 (class 0 OID 26321)
-- Dependencies: 1593
-- Data for Name: indicadores_programa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY indicadores_programa (id, programa_id, indicador_id) FROM stdin;
1	3	1
2	3	2
3	3	3
4	5	7
5	6	9
6	7	31
7	7	32
8	7	33
9	8	83
10	9	84
11	9	85
12	10	127
13	11	145
14	12	148
\.


--
-- TOC entry 2038 (class 0 OID 26339)
-- Dependencies: 1595
-- Data for Name: indicadores_projeto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY indicadores_projeto (id, projeto_id, indicador_id) FROM stdin;
1	1	4
2	1	5
3	2	6
4	4	8
5	5	10
6	5	11
7	5	12
8	5	13
9	6	14
10	7	15
11	8	16
12	9	17
13	10	18
14	11	19
15	12	20
16	13	21
17	14	22
18	15	23
19	16	24
20	17	25
21	18	26
22	19	27
23	20	28
26	23	34
27	24	35
28	25	36
29	27	37
30	29	38
31	30	39
32	31	40
33	32	41
34	32	42
35	33	43
36	34	44
37	35	45
38	36	46
39	37	47
40	38	48
41	39	49
42	40	50
43	41	51
44	42	52
45	43	53
46	44	54
47	45	55
48	46	56
49	47	57
50	48	58
51	49	59
52	50	60
53	51	61
54	52	62
55	53	63
56	54	64
57	54	65
58	54	66
59	54	67
60	54	68
61	54	69
62	55	70
63	55	71
64	55	72
65	56	73
66	56	74
67	56	75
68	56	76
69	57	77
70	57	78
71	57	79
72	57	80
73	57	81
74	58	82
75	65	86
76	66	87
77	66	88
78	66	89
79	66	90
80	66	91
81	67	92
82	68	93
83	69	94
84	69	95
85	69	96
86	70	97
87	70	98
88	70	99
89	71	100
90	71	101
91	71	102
92	72	103
93	72	104
94	72	105
95	73	106
96	73	107
97	73	108
98	74	109
99	75	110
100	76	111
101	77	112
102	78	113
103	79	114
104	79	115
105	80	116
106	81	117
107	81	118
108	81	119
109	82	120
110	83	121
111	83	122
112	83	123
113	84	124
114	85	125
115	86	126
116	87	128
117	90	129
118	91	130
119	92	131
120	95	132
121	96	133
122	97	134
123	98	135
124	99	136
125	100	137
126	101	138
127	102	139
128	103	140
129	104	141
130	107	142
131	107	143
132	108	144
133	109	146
134	110	147
135	111	149
136	112	150
137	113	151
\.


--
-- TOC entry 2022 (class 0 OID 25970)
-- Dependencies: 1561
-- Data for Name: metas_acao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY metas_acao (id, descricao, situacao_id, acao_id, objetivo_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
1	Definição de 81 apoiadores	1	1	\N	2009-10-22 20:35:43.05941	2	2009-10-22 20:35:43.05941	2
2	Distribuição dos 81 gerenciadores pelos 64 Colegiados de Gestão Regional\n( CGR)	1	1	\N	2009-10-22 20:36:04.703484	2	2009-10-22 20:36:04.703484	2
3	Participação dos gestores municipais e técnicos da SES	1	2	\N	2009-10-23 13:56:41.484342	2	2009-10-23 13:56:41.484342	2
4	Divulgação trimestral  dos resultados	1	3	\N	2009-10-23 14:00:09.590632	2	2009-10-23 14:00:09.590632	2
5	CRH	1	3	\N	2009-10-23 14:00:27.131083	2	2009-10-23 14:00:27.131083	2
\.


--
-- TOC entry 2023 (class 0 OID 25978)
-- Dependencies: 1563
-- Data for Name: metas_programa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY metas_programa (id, descricao, programa_id) FROM stdin;
1	Apoiar a gestão da atenção básica em 100% dos municípios com menos de 100 mil habitantes;	3
2	Monitorar e avaliar o POA 2009, coordenar a elaboração do Plano Diretor de Investimento 2009, Implantar sistema de monitoramento e avaliação contínuo	3
3	Atendimento a 100% da demanda	5
4	projetos de qualificação desenvolvidos, projetos de humanização implantados, instrumentos de gestão implementados, inovações gerencias incorporadas	6
5	1) Implantar Acolhimento com avaliação de risco.	7
6	2) Implantar Contrato Programa nos Hospitais de Taipas, Regional Sul e Candido Fontoura.	7
7	3)Ampliar leitos serviços.	7
8	Fortalecimento das Instituições e Desenvolvimento de projetos de pesquisa nas Instituições, em consonância com a agenda de prioridades elencadas pela SES-SP.	8
9	1. Garantir a investigação de pelo menos 80% dos agravos notificados	9
10	2. 100% dos municípios do estado de São Paulo com ações de vigilância sanitária pactuadas com o gestor estadual	9
11	Políticas elaboradas e aprovadas\nReorganização de serviços das Redes de Atenção dos Projetos relacionados ao Programa	10
12	Realizar um fórum estadual de promoção de saúde	11
13	Realização de: Cinco (5) Oficinas de Participação Popular no Estado de São Paulo; Dois Seminários Temáticos; 66 reuniões de Comissões Técnicas e Grupos de Trabalho e 11 reuniões do Pleno do CES; Curso Piloto para conselheiros estaduais de saúde; Dois (2) Encontros sobre Ouvidoria.	12
\.


--
-- TOC entry 2024 (class 0 OID 25986)
-- Dependencies: 1565
-- Data for Name: metas_projeto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY metas_projeto (id, descricao, projeto_id) FROM stdin;
1	81 gerenciadores da Atenção Básica instituídos, 4 avaliações/ano para 415 municípios do projeto Qualis Mais	1
2	Implantar 100% dos sistemas propostos	2
3	Atingir 100% das solicitações do MS	4
4	1. Efetivar  processo de mudança do modelo gerencial da CRH:\n-  Implantar “Banco de Idéias da CRH”	5
5	2. Organizar o processo de trabalho a partir de gerenciamento de projetos.  Apoiar à construção do POA 2009 – programa V. Acompanhar e monitorar o POA 2009 programa V. Finalizar implantação de sistema de gerenciamento de projetos em parceria com a Secretaria de Gestão Pública\n- Implantar “ sistema de apoio a de projetos” da CRH. Realizar capacitação em Gestão de Projetos	5
6	3. Estabelecer ações voltadas à Gestão de Conhecimento. Realizar “Ciclo de Socialização do  Conhecimento”.  Fortalecer o trabalho em rede por meio do Blog da Rede IntegraRH.  Realizar Rodas de conversa da Rede IntegraRH	5
7	4. Articular e Apoiar os planos de desenvolvimento Gerencial. \n- Articular e dar suporte à um plano de desenvolvimento gerencial para os cargos de comando dos hospitais de administração direta da SES/SP	5
8	Certificar Diretores de Hospitais e Diretores de Regionais de Saúde e realizar o plano de desenvolvimento individual quando necessário	6
9	Monitoramento de 100% dos programas do Plano Estadual de Saúde – POA 2009, monitoramento de 100% dos indicadores do Pacto pela Saúde, elaboração de planos de desenvolvimento em 100% das  regiões de saúde, PPI consolidada e com explicitação de recursos tripartites.	7
10	mplantar sistema de monitoramento e avaliação contínuo	8
11	Taxas de mortalidade infantil e materna ns em 2009, DRS Sorocaba e da Baixada Santista, menores do que as registradas em 2008	9
12	Construção do instrumento / Avaliação trimestral de 20% das Macro Regionais	10
13	Monitorar 100% das instituições participantes até o final de 2009	11
14	100% dos serviços com convênios/contratos; 100% das faturas processadas e 100% dos serviços cadastrados.	12
15	100% da capacitação dos auditores, 100 % das auditorias das Redes de Assistência	13
16	Cumprir acima de 70 % das metas estabelecidas em cada subprojeto	14
17	Monitoramento de 80 % das redes implantadas	15
18	Parâmetros técnicos e administrativos para os Hospitais de Ensino	16
19	Monitorar o desempenho e elaborar Política Estadual para Hospitais de Pequeno Porte	17
20	100% dos AME implantados	18
21	Monitoramento de 80% das redes implantadas	19
22	Atendimento a 100% das mulheres na faixa etária de 40 anos ou mais / Atendimento por USG a 100% das mulheres com resultado BI_RADIS 0 e 3 de mamografia	20
25	Implementação de 100% dos Complexos Macro-Reguladores Regionais de Urgência / Emergência	23
26	Atendimento de 100% dos medicamentos da Atenção Básica	24
27	Regionalização dos Serviços e cadastro	27
28	Publicação de 4 Boletins (BIS); publicação de 2 livros; realização de 70 eventos técnico-científicos em 2009	29
29	implantação do Acolhimento com Avaliação de Risco em 100% dos Serviços da Capital e Grande São Paulo	30
30	1)Contrato Programa Hospital Geral de Taipas, Hospital Regional Sul e Hospital infantil Cândido Fontoura.	31
31	2) Integrar os cinco hospitais da Zona Norte (Nova sistemática de manutenção predial e administração de materiais).	31
32	1) Reforma e adequação do Conjunto Hospitalar de Sorocaba e Conjunto Hospitalar  do Mandaqui.	32
33	2) Inaugurar o Hospital de Caieiras	32
34	3) Ampliar o Centro Estadual de Reabilitação	32
35	Formar Trabalhadores em Humanização	33
36	Produção e disseminação de relatórios e boletins analíticos periódicos	34
37	Elaboração de 12  Relatórios gerenciais, 12 Boletins informativos; disponibilizar o acesso ao Sistema de Informação em RH para 100% das unidades da CSS e CRS  e qualificar 100% dos gestores para o uso	35
38	Pactuar projetos de intervenção articulados entre municípios e SES	36
39	3: analisar informações de bancos de dados específicos definindo possibilidades e limites destes bancos.	37
40	disseminar conhecimento em Qualidade de Vida no Trabalho para 100% os gerentes de RH das Unidades (hospitais , institutos e DRS); implantar COMSAT em 30% dos DRS e dos institutos; completar a implantação de SESMT em 40% dos hospitais.	38
41	Implantar Carreira de Gestor, novas formas de remuneração e revisão de aposentadorias	39
42	disseminar conhecimento em Qualidade de Vida no Trabalho para 100% os gerentes de RH das Unidades (hospitais , institutos e DRS); implantar COMSAT em 30% dos DRS e dos institutos; completar a implantação de SESMT em 40% dos hospitais.	40
43	Implantar Carreira de Gestor, novas formas de remuneração e revisão de aposentadorias	41
44	Aprovar na A.L. a carreira de gestor público de saúde	42
45	Redução do tempo do processo de ratificação do tempo de contribuição para 2 meses	43
46	Implantação das novas formas de remuneração até dezembro de 2009	44
47	Implementar o Plano Estadual de Educação Permanente, através da consolidação dos 64 Planos Regionais de EP; implantar um sistema de educação a distancia do governo do estado de São Paulo com a instalação de 20 estações de vídeo-conferência; formar 400 especialistas em Gestão de Saúde; instituir sistema contínuo de formação de formadores; preparar os formadores necessários para a formação de Conselheiros Municipais de Saúde, ACS em quilombolas, THD, Cuidadores de Idosos, e ACS	45
48	Implementar o Plano Estadual de Educação Permanente, através da consolidação dos 64 Planos Regionais de EP; implantar um sistema de educação a distancia do governo do estado de São Paulo com a instalação de 20 estações de vídeo-conferência; formar 400 especialistas em Gestão de Saúde; instituir sistema contínuo de formação de formadores; preparar os formadores necessários para a formação de Conselheiros Municipais de Saúde, ACS em quilombolas, THD, Cuidadores de Idosos, e ACS	46
49	Execução qualificada de 100% dos PAREPS construídos pelos 64 CGR para 2009	47
50	Atender 100% das demandas de capacitação pedagógica aos técnicos envolvidos em EP	48
51	instalar 20 salas de videoconferência na SES; 20 pontos de estudo em TeleSaúde e definir plataforma para EAD	49
52	Formar 300 gestores na 2ª etapa e iniciar a formação de 100 gestores na 3ª etapa	50
53	Qualificar formadores para formação de conselheiros, ACS em Quilombolas, Cuidadores de idosos, Formar cerca de 1200 ACS, 300 THD, 300ACD e desenhar projeto de qualificação para vigilância em saúde	51
54	Formar 33.000 dos Auxiliares de Enfermagem em Técnicos de Enfermagem	52
55	Formar 33.000 dos Auxiliares de Enfermagem em Técnicos de Enfermagem	53
56	1. Implementação, em conjunto com a CPS/Atenção Básica e CRS, de equipes de gerenciadores da atenção básica, para atuarem em todos os CGR cobrindo todos os municípios de menos de 100.000 hab do estado.	54
57	2. Implementação de desenvolvimento individualizado para os gerenciadores de AB	54
58	3. Desenvolver 10 cursos  de qualificação para a gestão da atenção básica – 400 gestores	54
59	4. Iniciar cursos de qualificação para 500 enfermeiros em Saúde da Família no estado de São Paulo	54
60	5. Descrever as formas de contratação de profissionais da atenção básica e perfil profissional em atividade	54
61	6. Desenvolver e propor boas formas de gestão do trabalho	54
62	7. Apoiar a organização e funcionamento de pelo 2 escolas de Saúde da Família no estado, em parceria com instituições universitárias.	54
63	Iniciar a qualificação de 400 gestores e 500 enfermeiros  da atenção básica	55
64	1. Definir metodologias de investigação sobre necessidades de especialistas no SUS	56
65	2. Induzir a formação de especialistas em pelo menos 5 áreas prioritárias para o sistema de saúde.	56
66	3. Propor novas formas de financiamento da RM capazes de associar a oferta de bolsas ao financiamento do conjunto do sistema.	56
67	4. Estudar a adoção de tutorias  e financiamento diferenciados em programas prioritários de RM	56
68	5. Desenvolver metodologia e avaliar pelo menos 10 instituições SES em programas prioritários, visando correção de problemas bem como integração de ações.	56
69	1. Definir metodologias de investigação sobre necessidades de especialistas no SUS	57
70	2. Induzir a formação de especialistas em pelo menos 5 áreas prioritárias para o sistema de saúde.	57
71	3. Propor novas formas de financiamento da RM capazes de associar a oferta de bolsas ao financiamento do conjunto do sistema.	57
72	4. Estudar a adoção de tutorias  e financiamento diferenciados em programas prioritários de RM	57
73	5. Desenvolver metodologia e avaliar pelo menos 10 instituições SES em programas prioritários, visando correção de problemas bem como integração de ações.	57
74	Avaliar 10 instituições SES em programas prioritários	58
75	Atingir ≥ 60% dos indicadores selecionados em cada subprojeto	65
76	1 - Notificar e investigar pelo menos 1 caso de Paralisia Flácida Ascendente (PFA) por 100 mil habitantes menores de 15 anos no Estado de São Paulo (Taxa de Notificação = 1caso/100 mil hab.	66
77	2 - Garantir 80% de investigação adequada e oportuna  e 95% do diagnóstico laboratorial dos casos suspeitos de sarampo e rubéola;	66
78	3 - Atingir 95% de coberturas vacinais em 70% dos municípios.	66
79	Atingir 80% dos hospitais cadastrados no CNES	67
80	Identificar a etiologia de meningites bacterianas em mais de 45% dos casos	68
81	1- Realizar investigação epidemiológica em pelo menos 85% dos surtos notificados/ registrados;	69
82	2 – Realizar exames para diagnóstico etiológico em mais de 60% dos surtos investigados;	69
83	3- Aumentar o número de surtos com identificação etiológica	69
84	1 - Reduzir em 10% da incidência de dengue em relação ao ano epidêmico anterior;	70
85	2 – Reduzir o número de casos de\nLVA em 10%;	70
86	3 - Assegurar o diagnóstico de 100% das amostras de mamíferos encaminhadas para diagnóstico de raiva	70
87	1 - Aumentar o exame de SR em 7,5% ;	71
88	2 - Aumentar a cura dos BK em 2,5% ;	71
89	3 - Reduzir o coeficiente de mortalidade em 7,5%	71
90	1 - Atingir menos de 1 caso de hanseníase por grupo de 10.000habitantes no nível municipal;	72
91	2 - Curar 88% dos casos novos de hanseníase detectados nas coortes de pacientes multibacilares de 2007 e  de Paucibacilares de 2008;	72
92	3 - Monitorarmento 100% dos municípios segundo Detecção	72
93	1 - Reduzir em 10% a taxa de mortalidade geral por AIDS em relação a 2008;	73
94	2 - Implantar pelo menos uma UBS com abordagem sindrômica para as DST em 100% dos municípios prioritários (145);	73
95	3 - Prover testagem sorológica em 100% dos Centros de Testagem e Aconselhamento e em 20% das UBS	73
96	Implantar a ficha de notificação de violência do SINAN em 100% dos GVE	74
97	100% dos municípios do estado de SP com ações de vigilância sanitária pactuadas com o gestor estadual	75
98	35% dos Serviços Hemoterápicos sob controle sanitário pelo gestor municipal	76
99	35% dos serviços de saúde e de interesse da saúde (serviços de terapia renal substitutiva, hospitais,\nmaternidades, centros de parto normal, berçários, bancos de leite materno, UTI adulto e neo-natal,  estabelecimentos que prestam\nassistência odontológica, instituições geriátricas, creches, serviços de diagnóstico e tratamento de câncer de colo de útero e mama e,\nbancos de olhos, tecidos músculo esqueléticos e de pele), sob controle sanitário pelo gestor municipal	77
100	75% dos estabelecimentos que comercializam produtos de interesse da saúde\n(medicamentos, alimentos, produtos para a saúde / correlatos, produtos de higiene, perfumes e saneantes) sob controle sanitário \npelo gestor municipal	78
101	100% dos GVS e SGVS com Sistema Estadual de Toxicovigilância implantado	79
102	80% das análises de água coletadas no estado, para fins de vigilância, adequadas ao parâmetro fluoreto	80
103	1 - Habilitar 60% dos Laboratórios do IAL nos requisitos do Sistema de Qualidade	81
104	2 - Implantar Sistema de Informação Laboratorial disponibilizando os resultados aos Serviços de Vigilância (Regional,  Municipal e Hospitalar)	81
105	3 - Implantar novas tecnologias diagnósticas	81
106	80% das análises de água coletadas no estado, para fins de vigilância, adequadas ao parâmetro fluoreto	82
107	1 - Habilitar 60% dos Laboratórios do IAL nos requisitos do Sistema de Qualidade	83
108	2 - Implantar Sistema de Informação Laboratorial disponibilizando os resultados aos Serviços de Vigilância (Regional,  Municipal e Hospitalar)	83
109	3 - Implantar novas tecnologias diagnósticas	83
110	Realizar exames  e análises em 100% das amostras aceitas pelo IAL para Vigilância Epidemiológica, Vigilância Sanitária e Ambiental segundo as normas exigidas pela Qualidade e Biossegurança, pactuadas com CVE e CVS.	84
111	Desenvolver  e implantar quatro técnicas implantadas	85
112	Realizar 40% das atividades necessárias ao processo de implantação da certificação	86
113	Aumentar em 2% ao ano o acesso à primeira consulta odontológica.	87
114	Reorganização de 50% dos serviços da Rede de Reabilitação Física	90
115	Implantação de 06 CAPS ad	91
116	0,50 CAPS/ 100.000 habitantes no Estado de São Paulo	92
117	Obter a apresentação/realização de novos projetos em acordo com a agenda de prioridades de pesquisa elaborada pelo Conselho Estadual de Ciência, Tecnologia e Inovação em Saúde da SES-SP.	95
118	Capacitar gestores de pesquisa e pesquisadores das instituições nos conceitos, métodos e ferramentas de gestão da inovação	96
119	Aprovação de novos projetos de pesquisa, desenvolvimento ou inovação, em parceria com Instituições / pesquisadores reconhecidos e de notório saber.	97
120	Fortalecimento da comunicação científica dos Institutos de Pesquisa da SES-SP	98
121	Realizar uma capacitação em cada um dos 5 (cinco) DRS que possuem aldeias.	99
122	Um serviço  para Atenção Integral a Adolescentes e Mulheres Vítimas de Violência Sexual  implantado em cada macro-regiao.	100
123	Desenhar a Rede de Atenção à Doença Falciforme	101
124	Redução de 1.5% na Taxa de Mortalidade Infantil no Estado de São Paulo	102
125	Atualização do Plano Estadual de Saúde no Sistema penitenciário e do Plano de Saúde dos adolescentes em conflito com a Lei	103
126	Aumento de 30% nas  Intervenções sanitárias dos processos produtivos prioritários	104
127	Redução  das internações por  Diabetes e AVC em 10% até 2011	107
128	Redução  das internações por  Diabetes e AVC em 10% até 2011	108
129	Capacitar pelo menos 1 interlocutor por DRS em promoção de saúde;  Capacitar pelo menos 1 interlocutor por instituição (Secretarias e sociedade civil)	109
130	30% dos Municípios com interlocutores capacitados em promoção de alimentação saudável	110
131	Realização de: Cinco (5) Oficinas de Participação Popular no Estado de São Paulo; Dois Seminários Temáticos; 66 reuniões de Comissões Técnicas e Grupos de Trabalho e 11 reuniões do Pleno do CES e Curso Piloto para conselheiros estaduais realizado.	111
132	Realização de dois Encontros	112
133	Capacitar 100% dos GVS e SGVS	113
\.


--
-- TOC entry 2025 (class 0 OID 25994)
-- Dependencies: 1567
-- Data for Name: objetivos_acao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY objetivos_acao (id, descricao, situacao_id, acao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
1	Apoiar o desenvolvimento da capacidade de gestão da AB junto aos municípios menores de 100 mil hab.	1	1	2009-10-22 20:33:28.964617	2	2009-10-22 20:33:28.964617	2
2	Ampliar propostas e ações para o Fortalecimento da Atenção Básica no Estado de São Paulo	1	2	2009-10-23 13:56:03.251463	2	2009-10-23 13:56:03.251463	2
3	Melhorar a qualidade e resolução da AB no Estado.	1	3	2009-10-23 13:59:02.07788	2	2009-10-23 13:59:02.07788	2
\.


--
-- TOC entry 2026 (class 0 OID 26002)
-- Dependencies: 1569
-- Data for Name: objetivos_programa; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY objetivos_programa (id, descricao, programa_id) FROM stdin;
1	buscar o aprimoramento da capacidade de gestão estadual do sistema de saúde, fortalecendo: a atenção básica na coordenação do sistema, o planejamento e a programação baseada em informação e participação.	3
2	Garantir o acesso adequado à assistência farmacêutica, de modo a contemplar os diferentes Programas, promovendo uso racional e controlado de medicamentos e promover a ampliação da produção de vacinas e soros e a incorporação de novas tecnologias na produção de imunobiólogicos, biofármacos e hemoderivados	5
3	1 - Desenvolver estratégias e políticas de desenvolvimento e qualificação profissional;	6
4	2 – Desenvolver alternativas mais flexíveis para a gestão de pessoal da administração direta possibilitando ao estado uma resposta mais ágil em termos de seleção, admissão, avaliação, remuneração e profissionalização;	6
5	3 – Geração e disseminação do conhecimento e de estímulo à inovação na área de gestão de pessoas/RH, visando o fortalecimento da capacidade institucional da CRH e da SES/SP.	6
6	Implantar e implementar serviços de saúde da rede própria, segundo os diagnósticos das necessidades regionais, utilizando-se de estratégias que visem qualificar a assistência e a gestão destes serviços, oferecendo serviços eficientes e humanizados.	7
7	Promover a gestão e o desenvolvimento da ciência, tecnologia e inovação, na Secretaria de Estado da Saúde, a fim de garantir a produção do conhecimento científico e tecnológico de interesse no âmbito do SUS/SP, em consonância com a política nacional de C&T em Saúde.	8
8	Exercer a vigilância e controle de riscos, doenças e agravos prioritários do estado de São Paulo	9
9	Promover a equidade na atenção à saúde por meio da adequação da oferta às necessidades de saúde e da ampliação do acesso do usuário às políticas setoriais especialmente aquelas voltadas para mulheres, crianças, idosos, pessoas com deficiência, trabalhadores, saúde mental e populações em situação de desigualdade por fatores genéticos ou por condicionantes de exclusão social.	10
10	Estabelecer a política estadual de promoção de saúde	11
11	Fortalecimento da participação da comunidade e do controle social na gestão do SUS.	12
\.


--
-- TOC entry 2027 (class 0 OID 26011)
-- Dependencies: 1571
-- Data for Name: objetivos_projeto; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY objetivos_projeto (id, descricao, projeto_id) FROM stdin;
1	Apoiar os municípios no fortalecimento da Atenção Básica, monitoramento e avaliação	1
2	Disseminar informação com qualidade e agilidade utilizando-se  de recursos informatizados	2
3	Garantir o abastecimento de vacinas e soros hiperimunes para o PNI	4
4	Possibilitar a incorporação de experiências inovadoras na área de gestão de pessoas e disseminação do conhecimento, com vistas a potencializar as competências organizacionais e gerenciais institucionalizando ações que integrem processos e projetos/ subprojetos.	5
5	Desenvolvimento de ações baseadas em  Competências para dar sustentação ao processo de certificação Ocupacional	6
6	Fortalecer o planejamento e a programação como funções essenciais da SES na gestão estadual do sistema, com ênfase na  regionalização.	7
7	Estabelecer sistema contínuo de avaliação e monitoramento das ações do SUS/SP	8
8	Reduzir a mortalidade infantil e a mortalidade materna nos DRS de Sorocaba, Baixada Santista, Taubaté, Bauru e Registro	9
9	Elaborar o instrumento de acompanhamento e fluxo das linhas de cuidado / Avaliar o cumprimento da programação da PPI nas linhas de cuidado	10
10	Monitorar o desempenho das instituições participantes do programa	11
11	Contratar e manter atualizados os contratos de prestação de serviços de saúde, processar a produção ambulatorial e hospitalar e manter seus cadastros de estabelecimentos e de profissionais atualizados e com qualidade na informação.	12
12	Manter e ampliar as ações de auditoria do Grupo Normativo de Auditoria e Controle de Saude – GNACS, Componente Estadual do Sistema Nacional de Auditoria - SNA	13
13	Organizar a Assistência de Média e Alta Complexidade de acordo com as diretrizes aprovadas	14
14	Monitorar o desempenho das redes de Alta Complexidade implantadas	15
15	Monitoramento das metas pactuadas em contrato para os Hospitais de Ensino,	16
16	Monitoramento dos Hospitais de Pequeno Porte e Definição de Política específica	17
17	Acompanhar as metas fixadas em contrato	18
18	Monitoramento do desempenho das redes de Alta Complexidade implantadas	19
19	Redução de filas de espera para exames de mamografia / Realização de Exames de USG para diagnóstico precoce de mulheres com resultados BI_RADIS 0 e 3 de mamografia.	20
22	Implementar a Política de Regulação no Estado de São Paulo	23
23	Promover e garantir o acesso adequado aos medicamentos necessários à Atenção Básica	24
24	Garantia de acesso com qualidade e segurança, aos medicamentos de dispensação excepcional	25
25	Reorganização e melhoria da qualidade da assistência hemoterápica	27
26	Difundir conhecimentos produzidos no SUS-SP	29
27	1)Humanizar os serviços de saúde através de práticas que agreguem valor à assistência, visando integralidade, equidade e universalidade.	30
28	2)Ampliar o acesso.	30
29	3)Garantir os direitos dos usuários na obtenção de uma assistência integral e individualizada com qualidade.	30
30	Melhorar a qualidade e eficiência dos serviços próprios implantando novas sistemáticas de gerenciamento de serviços de suprimentos, manutenção predial, serviços de apoio diagnóstico e terapêutico, recursos humanos e sistema de avaliação e acompanhamento das atividades assistenciais e execução financeira através da WEB.	31
31	1) Ampliar e modernizar o parque de equipamentos médico hospitalar.	32
32	2) Recuperar e ampliar as estruturas físicas.	32
33	3) Ampliar leitos para UTI de crônicos.	32
34	Implementar a Política de Humanização da Atenção e Gestão do SUS ( DRS, Municípios e Hospitais Públicos.	33
35	Produção e disseminação de informações e estudos acerca da força de trabalho e qualidade de vida em saúde na SES/SP e no SUS no Estado de São Paulo, como suporte e subsidio à formulação de políticas e diretrizes para a gestão do trabalho; propor instrumentos de gestão em RH e qualidade de vida para o SUS no Estado de São Paulo	34
36	1: propiciar acesso às informações em RH relativas aos servidores da SES; realizar e disponibilizar análises acerca de RH no SUS e na SES	35
37	Formular propostas de contratação e instrumentos de gestão que auxiliem a gestão de recursos humanos na atenção básica nos municípios paulistas	36
38	Gerar informação/conhecimento em RH na SES e no SUS com intuito de subsidiar a política de Recursos Humanos no Estado de São Paulo	37
39	Assegurar boas condições de trabalho aos servidores da SES; fortalecer ações em Qualidade de Vida no trabalho; otimização das funções próprias de COMSAT e SESMT nas unidades da SES; ampliar ações de atenção ao trabalhador em processo de adoecimento	38
40	Desenvolver e implementar instrumentos de gestão de Recursos Humanos na SES/SP permitindo maior profissionalização da gestão, agilidade nos processos administrativos e compensação do trabalho mais adequada.	39
41	Assegurar boas condições de trabalho aos servidores da SES; fortalecer ações em Qualidade de Vida no trabalho; otimização das funções próprias de COMSAT e SESMT nas unidades da SES; ampliar ações de atenção ao trabalhador em processo de adoecimento	40
42	Desenvolver e implementar instrumentos de gestão de Recursos Humanos na SES/SP permitindo maior profissionalização da gestão, agilidade nos processos administrativos e compensação do trabalho mais adequada.	41
43	Implantar carreira de Gestor de Saúde na SES	42
44	Agilizar os expedientes relativos à ratificação de tempo de contribuição	43
45	Melhorar o desempenho das unidades da SES; Desenvolver novas formas de remuneração condicionadas à avaliação de desempenho individual e institucional.	44
46	Implementar a Educação Permanente no SUS-SP, estimulando a estruturação dos Planos Regionais de Educação Permanente, direcionados a todas as categorias profissionais, fortalecendo a capacidade de articulação  e desenvolvimento de propostas loco-regionais e do nível central da SES. Pretende ainda, avaliar os resultados dos processos educacionais implementados e ampliar o acesso através da implantação de sistemas de educação à distância.	45
47	Implementar a Educação Permanente no SUS-SP, estimulando a estruturação dos Planos Regionais de Educação Permanente, direcionados a todas as categorias profissionais, fortalecendo a capacidade de articulação  e desenvolvimento de propostas loco-regionais e do nível central da SES. Pretende ainda, avaliar os resultados dos processos educacionais implementados e ampliar o acesso através da implantação de sistemas de educação à distância.	46
48	Apoiar a expansão da Política de EP nas regiões de DRS e colegiados	47
49	Capacitar em metodologias ativas de ensino os técnicos da gestão envolvidos em atividades de docência	48
50	Implantar base tecnológica para EAD na SES/SP, articulada a rede de escolas de governo do estado, bem como ao ProjetoTelesaúde  (Ministério da Saúde) e definir plataforma de trabalho para EAD	49
51	Desenvolver curso de pós-graduação para 400 gestores (estaduais e municipais)	50
52	Qualificar os trabalhadores de nível básico e médio no âmbito do SUSSP	51
53	Habilitar como Técnico de Enfermagem os Auxiliares de  Enfermagem, que atuam em todos os níveis de assistência.	52
54	Habilitar como Técnico de Enfermagem os Auxiliares de  Enfermagem, que atuam em todos os níveis de assistência.	53
55	Apoiar a área de Atenção Básica da SES na implementação de ações de monitoramento , avaliação e melhoria da gestão municipal da atenção básica, bem como na melhoria da gestão do trabalho e na qualificação das equipes municipais	54
56	Desenvolvimento e implementação propostas de qualificação para gestores e enfermeiros da atenção básica	55
57	Subsidiar o aperfeiçoamento  e a incorporação de inovações na política de financiamento de bolsas e na gestão dos programas de residência médica financiados pela SES, orientando a distribuição de bolsas  a necessidade de especialistas identificada pelos gestores do SUS e avaliando melhor os programas em atividade.	56
58	Subsidiar o aperfeiçoamento  e a incorporação de inovações na política de financiamento de bolsas e na gestão dos programas de residência médica financiados pela SES, orientando a distribuição de bolsas  a necessidade de especialistas identificada pelos gestores do SUS e avaliando melhor os programas em atividade.	57
77	Realizar avaliação de funcionamento e estrutura de 10 instituições, em programas prioritários, bem o avalaira a possibilidade de ações integradas e complementares entre eles	58
78	Aprimorar as ações de vigilância e controle das doenças transmissíveis	65
79	Manter sob controle as doenças imunopreveníveis	66
80	Ampliar a implantação do sistema de vigilância das infecções hospitalares (IHs)	67
81	Aprimorar o diagnóstico etiológico das meningites bacterianas e virais	68
82	Identificar surtos de doenças transmitidas por água e alimentos (DTA) visando a adoção de medidas oportunas de prevenção e controle	69
83	Controle das Antropozoonoses	70
84	Reduzir a Morbimortalidade da Tuberculose	71
85	Eliminar a hanseníase em todas as regiões do estado aprimorando a capacidade de diagnóstico e tratamento	72
86	1 - Reduzir a morbimortalidade do HIV/Aids e das hepatites virais e a transmissão de outras DSTs;	73
87	2 - Ampliar oferta de testagem e aconselhamento para hepatites virais nas UBS	73
88	Ampliar as ações de vigilância epidemiológica com respeito às informações que subsidiem políticas públicas para diminuir a morbimortalidade por causas externas	74
89	Controlar o risco sanitário decorrente das atividades fabris, de comércio, armazenamento, transporte e\ncirculação de produtos de interesse da saúde; da prestação de serviços de saúde; dos equipamentos e da prestação de serviços de\ninteresse da saúde	75
90	Monitorar a qualidade da prestação de Serviços Hemoterápicos	76
91	Monitorar a qualidade da prestação de serviços de saúde e de interesse de saúde sob a competência da vigilância sanitária	77
92	Monitorar a qualidade dos produtos de interesse da saúde fabricados, importados, comercializados,\narmazenados, distribuídos, transportados e manipulados no estado de São Paulo	78
93	Controlar o risco sanitário dos eventos toxicológicos	79
94	Implementar a vigilância ambiental no SUS/SP	80
95	Reorganizar e aprimorar a rede laboratorial de Saúde Pública para atender a área de controle de doenças e demais ações de\nsaúde pública necessários para o SUS/SP	81
96	Implementar a vigilância ambiental no SUS/SP	82
97	Reorganizar e aprimorar a rede laboratorial de Saúde Pública para atender a área de controle de doenças e demais ações de\nsaúde pública necessários para o SUS/SP	83
98	Reorganizar e aprimorar a rede laboratorial do IAL para atender a área de controle de doenças e demais ações de saúde pública necessários para o SUS/SP	84
99	Atender a demandas de investigação da vigilância epidemiológica	85
100	Implantar a certificação de coleções de microorganismos no Instituto Adolfo Lutz	86
101	Ampliar o acesso da população aos serviços de saúde bucal.	87
102	Ampliar o acesso e a resolutividade da atenção à saúde da pessoa com deficiência no SUS, promovendo a sua inclusão social.	90
103	Estruturar a rede de assistência integral à saúde de usuários de álcool e outras drogas	91
104	Garantir atenção integral à saúde mental da população em serviços da rede extra-hospitalar	92
105	Promover a produção de conhecimento científico aplicável ao campo da saúde no âmbito do SUS/SP	95
107	Estruturar as instituições para aumentar seu potencial inovador e capacitar as instituições envolvidas no desenho de estratégias de inovação tecnológica alinhados com a estratégia institucional e com as oportunidades oferecidas pelo sistema de CT&I brasileiro	96
108	Fortalecer o desenvolvimento de parcerias com a finalidade de  incrementar a produção de conhecimento científico aplicável ao campo da saúde no âmbito do SUS/SP	97
109	Divulgar a produção de conhecimento técnico e  científico em saúde realizada pela SES-SP e apoiar o desenvolvimento da CT&I na Instituição.	98
110	Reduzir as desigualdades e iniqüidades na atenção integral à saúde indígena	99
111	Aperfeiçoar a atenção integral à saúde da Mulher	100
112	Desenvolver estratégias para facilitar a implantação da política de atenção integral à saúde da população negra.	101
113	.	102
114	Aperfeiçoamento da atenção à saúde da população do sistema penitenciário e dos adolescentes em conflito com a lei	103
115	Reduzir a morbimortalidade dos trabalhadores do Estado de São Paulo	104
116	Implantar a Política Estadual de Saúde do Adulto, voltado para o monitoramente e controle da , Diabetes, Hipertensão e medidas de intervenção sobre os fatores de risco	107
117	Implantar a Política Estadual de Saúde do Adulto, voltado para o monitoramente e controle da , Diabetes, Hipertensão e medidas de intervenção sobre os fatores de risco	108
118	Incrementar o poder técnico e político das comunidades em relação à promoção de saúde	109
119	desenvolver e apoiar ações intra e inter-setoriais de promoção de alimentação saudável	110
120	Qualificar a participação social na Gestão do Sistema, a partir da avaliação de diferentes mecanismos de participação popular nos processos de gestão do SUS, tais como os Conselhos de Saúde, garantindo sua consolidação enquanto conquista, para possibilitar resultados expressivos e duradouros	111
121	Fortalecer as Ouvidorias do SUS-SP, como mecanismo de participação da População	112
122	Intervenção sobre os processos produtivos  para a redução de riscos à saúde	113
\.


--
-- TOC entry 2039 (class 0 OID 26358)
-- Dependencies: 1597
-- Data for Name: operacoes; Type: TABLE DATA; Schema: public; Owner: planejamento
--

COPY operacoes (id, descricao, metas_acao_id, situacao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
\.


--
-- TOC entry 2028 (class 0 OID 26019)
-- Dependencies: 1573
-- Data for Name: paginas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY paginas (id, descricao, pagina, acao) FROM stdin;
1	Manutenção de Programas	programas	
2	Manter Usuários	usuarios	
\.


--
-- TOC entry 2029 (class 0 OID 26027)
-- Dependencies: 1575
-- Data for Name: parcerias_acao; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY parcerias_acao (id, descricao, situacao_id, acao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
1	CRS e CRH	1	1	2009-10-22 20:36:26.127882	2	2009-10-22 20:36:26.127882	2
2	CRH	1	2	2009-10-23 13:57:06.195435	2	2009-10-23 13:57:06.195435	2
3	CRS	1	2	2009-10-23 13:57:15.10278	2	2009-10-23 13:57:15.10278	2
4	GTAE	1	2	2009-10-23 13:57:19.054637	2	2009-10-23 13:57:19.054637	2
5	CRH	1	3	2009-10-23 14:01:39.726984	2	2009-10-23 14:01:39.726984	2
6	CRS	1	3	2009-10-23 14:01:44.608251	2	2009-10-23 14:01:44.608251	2
7	Assessoria gabinete	1	3	2009-10-23 14:01:49.012334	2	2009-10-23 14:01:49.012334	2
\.


--
-- TOC entry 2030 (class 0 OID 26037)
-- Dependencies: 1577
-- Data for Name: programas; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY programas (id, descricao, interfaces, situacao_id, responsavel_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id, menu, ordem) FROM stdin;
3	I - Fortalecimento e aperfeiçoamento da capacidade de gestão estadual	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	8	2009-10-16 12:43:51.60475	2	2009-10-16 12:43:51.60475	2	PROGRAMA I	\N
5	III GARANTIA DA EFICIÊNCIA, QUALIDADE E SEGURANÇA NA ASSISTÊNCIA FARMACÊUTICA E NOS OUTROS INSUMOS PARA A SAÚDE.	.	1	10	2009-10-19 01:16:41.890469	2	2009-10-19 01:18:56	2	PROGRAMA III	\N
6	V - Gestão da Educação e do Trabalho no SUS	Fundap, Cosems, Instituições de Ensino, demais Coordenadorias e Órgãos da SES, outras secretarias do Estado de SP, MS, ObservaRHSP	1	12	2009-10-19 01:25:36.193403	2	2009-10-21 01:47:19	2	PROGRAMA V	\N
7	IV – Investir e melhorar os serviços próprios de saúde estaduais	Coordenadoria de Recursos Humanos e Instituições de Ensino	1	11	2009-10-21 13:48:55.469989	2	2009-10-21 13:48:55.469989	2	PROGRAMA IV	\N
8	VI – Tecnologias e Inovações em Saúde	.	1	13	2009-10-22 14:50:33.18928	2	2009-10-22 02:51:44	2	PROGRAMA VI	\N
9	VII - Controle de Riscos, Doenças e Agravos Prioritários no Estado de São Paulo	CSS, CRS, CCTIES, FESIMA, IAL, Instituto Pasteur, CVS, CPS/GTAE, CRH	1	14	2009-10-22 15:48:12.258134	2	2009-10-22 15:48:12.258134	2	PROGRAMA VII	\N
10	VIII - Desenvolvimento de serviços e ações de saúde para segmentos da população mais vulneráveis aos riscos de doenças ou com necessidades específicas.	Programas I, II, II, IV, V, VI, IX, X	1	15	2009-10-22 17:34:29.390804	2	2009-10-22 17:34:29.390804	2	PROGRAMA VIII	\N
4	II - AMPLIAÇÃO DO ACESSO DA POPULAÇÃO, COM REDUÇÃO DE DESIGUALDADES REGIONAIS E APERFEIÇOAMENTO DA QUALIDADE DAS AÇÕES E SERVIÇOS DE SAÚDE	xxxx	1	9	2009-10-19 01:06:04.816344	2	2009-10-22 08:05:48	2	PROGRAMA II	\N
11	IX - Incentivo ao desenvolvimento de ações de Promoção em Saúde no SUS	SES (CPS/GTAE, CRATOD, IS, CRS, CRH, GABINETE DO SECRETARIO)	1	76	2009-10-23 10:19:56.711902	2	2009-10-23 10:19:56.711902	2	PROGRAMA IX	\N
12	X - Fortalecimento da participação da comunidade e do controle social na gestão do SUS	CRH, CGA,CPS,CRS e GS	1	16	2009-10-23 10:31:59.433859	2	2009-10-23 10:31:59.433859	2	PROGRAMA X	\N
1	s	s	1	16	2009-10-24 10:19:51.717027	2	2009-10-24 10:19:51.717027	2	aa	\N
\.


--
-- TOC entry 2031 (class 0 OID 26049)
-- Dependencies: 1579
-- Data for Name: projetos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY projetos (id, descricao, interfaces, situacao_id, programa_id, responsavel_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id, menu, projeto_id, ordem) FROM stdin;
1	PROJETO I.1 – Fortalecimento e Aperfeiçoamento da Atenção Básica	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	3	17	2009-10-19 01:08:34.766655	2	2009-10-19 01:08:34.766655	2	PROJETO I.1	\N	\N
2	PROJETO I.2 – Aprimoramento dos Sistemas de Informação do SUS/SP	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	3	18	2009-10-19 01:12:30.049265	2	2009-10-19 01:12:30.049265	2	PROJETO I.2	\N	\N
4	PROJETO III. 1 – Ampliação da produção de vacinas e soros hiperimunes e incorporação de tecnologias e produtos imunobiológicos, biofármacos e hemoderivados.	.	1	5	2	2009-10-19 01:22:17.890813	2	2009-10-21 11:16:26	2	PROJETO III. 1	\N	\N
5	PROJETO V.1. – Processo Organizacionais Integrados	SPG, Instituições de Ensino, demais Coordenadorias e Órgãos da SES	1	6	24	2009-10-19 01:28:14.058493	2	2009-10-19 01:41:05	2	PROJETO V.1	\N	\N
6	SUBPROJETO V.1.1 – Certificação Ocupacional	CSS E CRS	1	6	24	2009-10-19 01:31:23.377459	2	2009-10-19 01:41:34	2	SUBPROJETO V.1.1	5	\N
7	PROJETO I.3 – Fortalecimento do planejamento na SES com ênfase nas regiões de saúde.	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	3	27	2009-10-19 14:07:16.778046	2	2009-10-19 14:07:16.778046	2	PROJETO I.3	\N	\N
8	PROJETO I.4 – Avaliação e monitoramento do SUS/SP	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	3	26	2009-10-19 14:13:02.368297	2	2009-10-19 14:13:02.368297	2	PROJETO I.4	\N	\N
9	PROJETO I.5 – Redução da Mortalidade Infantil e Materna	Demais projetos da CPS e todas as Coordenadorias – GTAE, CRS, CCD, CSS, CGCSS, CRH, CCTIES, CODES e CGA	1	3	28	2009-10-19 14:15:57.769544	2	2009-10-19 14:15:57.769544	2	PROJETO I.5	\N	\N
24	PROJETO III. 2. – Promoção de acesso adequado à Assistência Farmacêutica Básica	CGA, CPS, CCD, CRS, CSS , CRH	1	5	39	2009-10-21 14:08:21.159949	2	2009-10-21 14:08:21.159949	2	PROJETO III. 2	\N	\N
14	PROJETO II. 5 – Ampliação do acesso e melhoria da organização e a qualidade da Assistência de Média e Alta Complexidade Ambulatorial e Hospitalar	.	1	4	21	2009-10-21 10:17:09.616842	2	2009-10-21 10:17:09.616842	2	PROJETO II. 5	\N	\N
25	PROJETO III. 3 – Ampliação do acesso a medicamentos de dispensação excepcional	CGA,CRS,CRH	1	5	40	2009-10-21 14:12:15.258718	2	2009-10-21 14:12:15.258718	2	PROJETO III. 3	\N	\N
10	PROJETO II. 1 – Monitoramento da Programação Pactuada e Integrada do Estado de São Paulo	CPS, CSS, CGCSS 	1	4	21	2009-10-19 14:24:44.782518	2	2009-10-21 01:53:42	2	PROJETO II. 1	\N	\N
11	PROJETO II. 2 – Manutenções de Programas de Auxílio Financeiros às Entidades Filantrópicas do Estado - Pró Santa Casa	CGA, CPS, GS 	1	4	22	2009-10-19 14:33:59.196706	2	2009-10-21 01:54:58	2	PROJETO II. 2	\N	\N
12	PROJETO II. 3 – Avaliação, monitoramento e contratualização dos Prestadores de Serviços de Saúde ao SUS-SP.	CPS, CGCSS, CSS	1	4	29	2009-10-19 14:36:55.574826	2	2009-10-21 01:55:25	2	PROJETO II. 3	\N	\N
13	PROJETO II. 4 – Implementação e Ampliação das ações de auditoria	CPS, CRH, CGCSS, CSS	1	4	30	2009-10-21 10:14:43.847949	2	2009-10-21 01:55:53	2	PROJETO II. 4	\N	\N
15	SUBPROJETO II. 5.1 – Monitoramento da Prestação da Assistência dos Serviços SUS/SP	CGCSS, CSS, CPS 	1	4	31	2009-10-21 10:19:49.555188	2	2009-10-21 01:57:02	2	SUBPROJETO II. 5.1	14	\N
16	SUBPROJETO II. 5.2 – Monitoramento da Prestação da Assistência dos Serviços SUS/SP	GS, CPS, CSS, CGCSS 	1	4	32	2009-10-21 10:27:42.874274	2	2009-10-21 01:58:30	2	SUBPROJETO II. 5.2	14	\N
17	SUBPROJETO II. 5.3 – Monitoramento da Prestação da Assistência dos Serviços SUS/SP	CSS, CGCSS, CPS 	1	4	32	2009-10-21 10:39:08.493358	2	2009-10-21 01:58:53	2	SUBPROJETO II. 5.3	14	\N
18	SUBPROJETO II. 5.4 – Monitoramento dos Ambulatórios Médicos de Especialidades – AME	GS, CGCSS	1	4	34	2009-10-21 10:53:45.202091	2	2009-10-21 01:59:31	2	SUBPROJETO II. 5.4	14	\N
19	SUBPROJETO II. 5.5 – Monitoramento da Prestação da Assistência dos Serviços SUS/SP	CPS, CSS, CGCSS	1	4	35	2009-10-21 10:59:03.243971	2	2009-10-21 01:59:58	2	SUBPROJETO II. 5.5	14	\N
20	SUBPROJETO II. 5.6 – Organização dos mutirões de exames e procedimentos	CPS, CGCSS, CSS 	1	4	37	2009-10-21 11:01:57.250637	2	2009-10-21 02:00:22	2	SUBPROJETO II. 5.6	14	\N
23	PROJETO II. 6 – Aperfeiçoamentos dos mecanismos de regulação dos serviços de saúde do SUS/SP	CPS, CGCSS, CSS	1	4	38	2009-10-21 14:02:32.170028	2	2009-10-21 14:02:32.170028	2	PROJETO II. 6	\N	\N
27	PROJETO III. 4 – Reorganização da Hemorrede no Estado	.	1	5	38	2009-10-21 14:15:59.439943	2	2009-10-21 14:15:59.439943	2	PROJETO III. 4	\N	\N
29	PROJETO III. 5. – Difusão do conhecimento		1	5	38	2009-10-21 14:18:27.7646	2	2009-10-21 14:18:27.7646	2	PROJETO III. 5	\N	\N
26	PROJETO III. 4 – Reorganização da Hemorrede no Estado	.	2	5	38	2009-10-21 14:14:37.641673	2	2009-10-21 02:19:19	2	PROJETO III. 4	\N	\N
28	PROJETO III. 5. – Difusão do conhecimento		2	5	38	2009-10-21 14:17:51.927127	2	2009-10-21 02:20:37	2	PROJETO III. 5	\N	\N
30	PROJETO IV. 1 – Humanizar os Serviços de Saúde	Coordenadoria de Recursos Humanos e Instituições de Ensino	1	7	43	2009-10-21 14:31:02.572423	2	2009-10-21 14:31:02.572423	2	PROJETO IV. 1	\N	\N
31	PROJETO IV. 2 – Melhorar a Qualidade e Eficiência dos Serviços Próprios Estaduais, com Cronograma e Planejamento para Estímulo ao aperfeiçoamento da Administração / Gerenciamento Direto	Coordenadoria Geral da Administração (Depto Técnico de Engenharia), Coordenadoria de Gestão de Contratos de Serviços de Saúde	1	7	11	2009-10-21 14:34:42.111196	2	2009-10-21 14:34:42.111196	2	PROJETO IV. 2	\N	\N
32	PROJETO IV. 3 – Modernizar e Ampliar os Serviços da Rede Própria Estadual	Coordenadoria Geral da Administração (Depto Técnico de Engenharia), Coordenadoria de Gestão de Contratos de Serviços de Saúde	1	7	44	2009-10-21 14:58:18.033386	2	2009-10-21 14:58:18.033386	2	PROJETO IV. 3	\N	\N
33	PROJETO V. 2 – Política de Humanização na SES	CSS/CRS/CPS	1	6	45	2009-10-21 15:21:03.198532	2	2009-10-21 15:21:03.198532	2	PROJETO V. 2	\N	\N
34	PROJETO V. 3 – Informação sobre gestão do trabalho na SES e no SUS	.	1	6	46	2009-10-21 15:24:48.552536	2	2009-10-21 15:24:48.552536	2	PROJETO V. 3	\N	\N
35	SUBPROJETO V.3.1 – Gestão da informação em RH no SUS e na SES	ObservaRHSP/outras CoordenadoriasSES	1	6	47	2009-10-21 15:29:52.137351	2	2009-10-21 15:29:52.137351	2	SUBPROJETO V.3.1	34	\N
36	SUBPROJETO V. 3. 2 – Apoio na Gestão do trabalho nos municípios de pequeno porte	CRS, Cosems, municípios 	1	6	46	2009-10-21 15:31:30.559941	2	2009-10-21 15:31:30.559941	2	SUBPROJETO V. 3. 2	34	\N
37	SUBPROJETO V.3.3 – Produção de informação e conhecimento em RH referente a analise de grandes bancos de dados, no estado de São Paulo	ObservaRHSP/ Cosems / Coordenadorias SES	1	6	48	2009-10-21 15:38:07.507976	2	2009-10-21 15:38:07.507976	2	SUBPROJETO V.3.3	34	\N
38	PROJETO V. 4 – Melhoria da qualidade de vida e ambiente de trabalho	.	2	6	49	2009-10-21 15:46:34.721154	2	2009-10-21 03:55:35	2	PROJETO V. 4	34	\N
39	PROJETO: V. 5 – Instrumentos de Gestão de Recursos Humanos para a SES/SP	.	2	6	51	2009-10-21 15:54:14.564838	2	2009-10-21 03:55:59	2	PROJETO: V. 5	34	\N
40	PROJETO V. 4 – Melhoria da qualidade de vida e ambiente de trabalho	.	1	6	49	2009-10-21 15:56:58.503058	2	2009-10-21 15:56:58.503058	2	PROJETO V. 4	\N	\N
41	PROJETO: V. 5 – Instrumentos de Gestão de Recursos Humanos para a SES/SP	.	1	6	51	2009-10-21 16:00:28.942311	2	2009-10-21 16:00:28.942311	2	PROJETO: V. 5	\N	\N
47	SUBPROJETO V.6.1 – Estruturação do Sistema de Educação Permanente	.	1	6	55	2009-10-21 16:45:48.821577	2	2009-10-21 16:45:48.821577	2	SUBPROJETO V.6.1	46	\N
42	SUBPROJETO V.5.1 – Implantação da carreira de Gestor de Saúde	Secretaria de Gestão Pública, Gabinete do Secretário, Casa Civil, Assembléia Legislativa 	1	6	51	2009-10-21 16:02:25.483923	2	2009-10-21 16:02:25.483923	2	SUBPROJETO V.5.1	41	\N
43	SUBPROJETO V.5.2 – Gestão de Processos de Ratificação de Tempo de Contribuição - Aposentadoria	Todas as Coordenadorias da SES, em especial as áreas de RH	1	6	52	2009-10-21 16:08:47.032679	2	2009-10-21 16:08:47.032679	2	SUBPROJETO V.5.2	41	\N
44	SUBPROJETO V.5.3 – Desenvolvimento de novas formas de remuneração variável para servidores da SES/SP	Demais Coordenadorias SES, em particular CSS, CCD	1	6	53	2009-10-21 16:19:09.945992	2	2009-10-21 16:19:09.945992	2	SUBPROJETO V.5.3	41	\N
45	PROJETO V. 6 – Desenvolvimento da Educação Permanente no âmbito da SES/SP	Coordenadorias de SES e Gabinete, Cosems, instituições de ensino	2	6	54	2009-10-21 16:32:15.250586	2	2009-10-21 04:33:16	2	PROJETO V. 6	41	\N
46	PROJETO V. 6 – Desenvolvimento da Educação Permanente no âmbito da SES/SP	Coordenadorias de SES e Gabinete, Cosems, instituições de ensino	1	6	54	2009-10-21 16:34:13.821043	2	2009-10-21 16:34:13.821043	2	PROJETO V. 6	\N	\N
48	SUBPROJETO V.6.2 – Formação de Formadores	.	1	6	56	2009-10-21 16:48:54.971405	2	2009-10-21 16:48:54.971405	2	SUBPROJETO V.6.2	46	\N
49	SUBPROJETO V.6.3 – Implantação do Ensino à Distância – EAD	.	1	6	57	2009-10-21 16:52:34.973818	2	2009-10-21 16:52:34.973818	2	SUBPROJETO V.6.3	46	\N
50	SUBPROJETO V.6.4 – Especialização em Gestão Pública no SUS	.	1	6	38	2009-10-21 16:57:12.796336	2	2009-10-21 16:57:12.796336	2	SUBPROJETO V.6.4	46	\N
51	SUBPROJETO V.6.5 – Educação Permanente para os trabalhadores de nível fundamental e médio de	.	1	6	59	2009-10-21 17:04:27.796409	2	2009-10-21 17:04:27.796409	2	SUBPROJETO V.6.5	46	\N
52	PROJETO V.7 – Formação de técnicos de Enfermagem para o Estado de São Paulo	.	2	6	60	2009-10-21 17:10:51.242892	2	2009-10-21 05:12:37	2	PROJETO V.7	46	\N
53	PROJETO V.7 – Formação de técnicos de Enfermagem para o Estado de São Paulo	.	1	6	60	2009-10-21 17:13:34.071629	2	2009-10-21 17:13:34.071629	2	PROJETO V.7	\N	\N
54	PROJETO V.8 – Apoio á Qualificação da Atenção Básica na SES/SUS -SP	CPS/AB; CRS, Instituições de Ensino, Ministério da Saúde, COSEMS/municípios, ObservaRHSP, CGA	1	6	61	2009-10-21 17:26:33.708505	2	2009-10-21 17:26:33.708505	2	PROJETO V.8	\N	\N
55	SUBPROJETO V.8.1 – Qualificação de profissionais da atenção básica	CRS, CPS/AB, Instituições de Ensino, Cosems	1	6	54	2009-10-21 17:44:01.709081	2	2009-10-21 17:44:01.709081	2	SUBPROJETO V.8.1	54	\N
56	PROJETO V.9 – Aperfeiçoamento e inovação na Política de Residência Médica da SES	CRS, CSS, CGCSS, Gabinete, ObservaRHSP, Instituições formadoras, FUNDAP, CRM, CFM, MS, municípios, gerentes de serviços, parcerias externas	2	6	61	2009-10-21 17:48:26.453324	2	2009-10-21 05:53:46	2	PROJETO V.9	54	\N
57	PROJETO V.9 – Aperfeiçoamento e inovação na Política de Residência Médica da SES	CRS, CSS, CGCSS, Gabinete, ObservaRHSP, Instituições formadoras, FUNDAP, CRM, CFM, MS, municípios, gerentes de serviços, parcerias externas	1	6	61	2009-10-22 12:06:42.948631	2	2009-10-22 02:40:19	2	PROJETO V.9	\N	\N
58	SUBPROJETO V.9.1 – Avaliação da Residência Médica na SES	CSS, FUNDAP, parcerias externas	1	6	62	2009-10-22 14:45:58.092805	2	2009-10-22 14:45:58.092805	2	SUBPROJETO V.9.1	57	\N
65	PROJETO VII. 1 – Melhoria da vigilância e controle das doenças transmissíveis	.	1	9	63	2009-10-22 15:54:12.486667	2	2009-10-22 15:54:12.486667	2	PROJETO VII. 1	\N	\N
66	SUBPROJETO VII. 1.1 – Vigilância das doenças agudas imunopreveníveis	.	1	9	64	2009-10-22 15:57:38.967484	2	2009-10-22 15:57:38.967484	2	SUBPROJETO VII. 1.1	65	\N
67	SUBPROJETO VII. 1.2 – Vigilância das infecções hospitalares	CVS, CSS, CRS, CCTIES, IAL	1	9	65	2009-10-22 16:05:11.410463	2	2009-10-22 16:05:11.410463	2	SUBPROJETO VII. 1.2	65	\N
68	SUBPROJETO VII. 1.3 – Vigilância das meningites	CVS, CSS, CRS, IAL	1	9	64	2009-10-22 16:07:06.957636	2	2009-10-22 16:07:06.957636	2	SUBPROJETO VII. 1.3	65	\N
69	SUBPROJETO VII. 1.4 – Vigilância de surtos de doenças transmitidas por água e alimentos	CVS, CSS, CRS, IAL	1	9	66	2009-10-22 16:10:24.701322	2	2009-10-22 16:10:24.701322	2	SUBPROJETO VII. 1.4	65	\N
70	SUBPROJETO VII.1.5 – Controle de Antropozoonoses	SUCEN, CVS	1	9	67	2009-10-22 16:14:05.802353	2	2009-10-22 16:14:05.802353	2	SUBPROJETO VII.1.5	65	\N
71	SUBPROJETO VII.1.6 – Controle da tuberculose	CRTAIDS, CCTIES, Atenção Básica, CRS e CSS, IAL	1	9	68	2009-10-22 16:18:51.816411	2	2009-10-22 16:18:51.816411	2	SUBPROJETO VII.1.6	65	\N
72	SUBPROJETO VII.1.7 – Eliminação da hanseníase em todas as Regiões do Estado	CCTIES, Atenção Básica, CRS e CSS, IAL	1	9	69	2009-10-22 16:23:01.246552	2	2009-10-22 16:23:01.246552	2	SUBPROJETO VII.1.7	65	\N
73	SUBPROJETO VII.1.8 – Reduzir a morbimortalidade do HIV/Aids e das hepatites virais, a transmissão vertical do HIV e a transmissão de outras DSTs.	IAL. Saúde da Mulher, Atenção Básica, Assistência Farmacêutica, Vigilância Sanitária, CPS, CRS.	1	9	70	2009-10-22 16:29:01.272886	2	2009-10-22 16:29:01.272886	2	SUBPROJETO VII.1.8	65	\N
74	PROJETO VII. 2 – Implementação das ações de vigilância da morbimortalidade decorrente de  causas externas	GTAE / CPS (saúde da mulher, da criança, do idoso, atenção básica, saúde mental )	1	9	71	2009-10-22 16:37:52.783843	2	2009-10-22 16:37:52.783843	2	PROJETO VII. 2	\N	\N
75	PROJETO VII. 3 – APERFEIÇOAMENTO DA VIGILÂNCIA SANITÁRIA	.	1	9	72	2009-10-22 16:40:25.132656	2	2009-10-22 16:40:25.132656	2	PROJETO VII. 3	\N	\N
76	SUBPROJETO VII. 3.1 – CONTROLE SANITÁRIO DOS SERVIÇOS HEMOTERÁPICOS	GVS / SGVS / IAL / CVE / CCD / CRS / CCSS / CPS / CGR	1	9	73	2009-10-22 16:44:05.955154	2	2009-10-22 16:44:05.955154	2	SUBPROJETO VII. 3.1	75	\N
77	SUBPROJETO VII. 3.2 – CONTROLE SANITÁRIO DOS SERVIÇOS DE SAÚDE E DE INTERESSE DA SAÚDE	GVS / SGVS / IAL / CVE / CCD / CRS / CCSS / CPS / CGR	1	9	73	2009-10-22 16:46:28.168415	2	2009-10-22 16:46:28.168415	2	SUBPROJETO VII. 3.2	75	\N
78	SUBPROJETO VII. 3.3 – CONTROLE SANITÁRIO DE PRODUTOS DE SAÚDE E DE INTERESSE DA SAÚDE	GVS / SGVS / IAL / CVE / CCD / CRS / CCSS / CPS / CGR	1	9	74	2009-10-22 16:49:58.950271	2	2009-10-22 16:49:58.950271	2	SUBPROJETO VII. 3.3	75	\N
79	SUBPROJETO VII. 3.4 – SISTEMA ESTADUAL DE TOXICOVIGILÂNCIA	GVS / SGVS / IAL / CVE / CCD / CPS / CEREST / CRST / CGR	1	9	75	2009-10-22 16:54:27.121481	2	2009-10-22 16:54:27.121481	2	SUBPROJETO VII. 3.4	75	\N
81	PROJETO VII. 5 – REORGANIZAR e APRIMORAR A REDE LABORATORIAL DE SAÚDE PÚBLICA	.	2	9	77	2009-10-22 17:00:07.500713	2	2009-10-22 05:03:45	2	PROJETO VII. 5	75	\N
80	PROJETO VII. 4 – IMPLEMENTAÇÃO DA VIGILÂNCIA AMBIENTAL	CRS / IAL / CVS	2	9	76	2009-10-22 16:57:36.863092	2	2009-10-22 05:04:05	2	PROJETO VII. 4	75	\N
82	PROJETO VII. 4 – IMPLEMENTAÇÃO DA VIGILÂNCIA AMBIENTAL	CRS / IAL / CVS	1	9	76	2009-10-22 17:06:54.310551	2	2009-10-22 17:06:54.310551	2	PROJETO VII. 4	\N	\N
83	PROJETO VII. 5 – REORGANIZAR e APRIMORAR A REDE LABORATORIAL DE SAÚDE PÚBLICA	.	1	9	77	2009-10-22 17:08:09.824052	2	2009-10-22 17:08:09.824052	2	PROJETO VII. 5	\N	\N
84	SUBPROJETO VII. 5. 1 – APRIMORAR A REDE LABORATORIAL DO IAL	FOSP, CRS, DRSs, Laboratórios de Hospitais Estaduais, CVS,CVE, I Pasteur, GVEs e GVSs.	1	9	77	2009-10-22 17:12:36.254084	2	2009-10-22 17:12:36.254084	2	SUBPROJETO VII. 5. 1	83	\N
85	SUBPROJETO VII. 5.2 – IMPLANTAR NOVAS TÉCNICAS DIAGNÓSTICAS	CVE	1	9	78	2009-10-22 17:14:54.269102	2	2009-10-22 17:14:54.269102	2	SUBPROJETO VII. 5.2	83	\N
86	SUBPROJETO VII. 5.3 – CERTIFICAÇÃO DE COLEÇÕES ESTABELECIDAS	CVE/ CVS/ CRT-AIDS/ Municípios	1	9	78	2009-10-22 17:16:07.375225	2	2009-10-22 17:16:07.375225	2	SUBPROJETO VII. 5.3	83	\N
87	PROJETO VIII. 1 – Atenção à Saúde Bucal	CPS (Atenção Básica); CRH (CIES) CCD; CRS (DRS); CSS; CGCSS.	1	10	79	2009-10-22 17:37:03.405462	2	2009-10-22 17:37:03.405462	2	PROJETO VIII. 1	\N	\N
90	PROJETO VIII. 3 – Atenção Integral à Saúde da Pessoa com Deficiência	CGR, DRS, CSS, CPS, GES, CRH, SEDPcD	1	10	81	2009-10-22 17:52:40.897102	2	2009-10-22 17:52:40.897102	2	PROJETO VIII. 3	\N	\N
91	PROJETO VIII. 4 – Atenção integral à saúde de usuários de álcool e outras drogas	Gabinete da SES-SP, Programas: I (Projeto 1),  II (Projeto 2),  V (Projeto 4), VIII (Projeto 5);  CIB, CES, DRS e CGR	1	10	82	2009-10-22 17:55:58.005992	2	2009-10-22 17:55:58.005992	2	PROJETO VIII. 4	\N	\N
92	PROJETO VIII. 5 – Atenção integral à saúde mental	Gabinete SES-SP; Programas II, IV, e V; Projetos do Programa VIII	1	10	83	2009-10-22 17:59:34.238457	2	2009-10-22 06:03:29	2	PROJETO VIII. 5	\N	\N
95	PROJETO VI.1 – Promoção, organização e acompanhamento do desenvolvimento científico e tecnológico de interesse para o SUS-SP.	CRH, CRS, CCD, CCTIES, Instituto Pasteur, Instituto Lauro de Souza Lima, Instituto Dante Pazzanese de Cardiologia, \r\nInstituto Butantan, Instituto Adolfo Lutz, Instituto de Saúde, Instituto de Infectologia Emílio Ribas, CVS, CVE e CRT-AIDS,\r\nInstituto Clemente Ferreira, Universidades.	1	8	13	2009-10-22 22:32:04.53468	2	2009-10-22 22:32:04.53468	2	PROJETO VI.1	\N	\N
96	PROJETO VI. 2 – Organização e Planejamento para Inovação	CRH, CRS, CCD, CCTIES, Instituto Pasteur, Instituto Lauro de Souza Lima, Instituto Dante Pazzanese de Cardiologia, Instituto Butantan, Instituto Adolfo Lutz, Instituto de Saúde, Instituto de Infectologia Emílio Ribas, CVS, CVE e CRT-AIDS, Instituto Clemente Ferreira, Universidades.	1	8	13	2009-10-23 09:26:53.053977	2	2009-10-23 09:26:53.053977	2	PROJETO VI. 2	\N	\N
97	PROJETO VI. 3 – Promoção de parcerias para incrementar a capacidade técnica-científica das Instituições.	CRH, CRS, CCD, CCTIES, Instituto Pasteur, Instituto Lauro de Souza Lima, Instituto Dante Pazzanese de Cardiologia, Instituto Butantan, Instituto Adolfo Lutz, Instituto de Saúde, Instituto de Infectologia Emílio Ribas, CVS, CVE e CRT-AIDS, Instituto Clemente Ferreira, Universidades.	1	8	13	2009-10-23 09:28:49.92211	2	2009-10-23 09:28:49.92211	2	PROJETO VI. 3	\N	\N
98	PROJETO VI. 4 – Difusão do Conhecimento Científico e ampliação dos serviços de informação.	CRH, CRS, CCD, CCTIES, Instituto Pasteur, Instituto Lauro de Souza Lima, Instituto Dante Pazzanese de Cardiologia, Instituto Butantan, Instituto Adolfo Lutz, Instituto de Saúde, Instituto de Infectologia Emílio Ribas, CVS, CVE e CRT-AIDS, Instituto Clemente Ferreira, Universidades.	1	8	13	2009-10-23 09:30:19.416642	2	2009-10-23 09:30:19.416642	2	PROJETO VI. 4	\N	\N
99	PROJETO VIII.6 – Assistência integral à Saúde às Populações Indígenas	PROGRAMAS I, II, IV, VII, V, VIII	1	10	84	2009-10-23 09:38:17.874104	2	2009-10-23 09:38:17.874104	2	PROJETO VIII.6	\N	\N
100	PROJETO VIII. 7 – Atenção Integral a Saúde da Mulher	Gabinete SES/SP, PROGRAMAS I, II, III, IV, VIII	1	10	85	2009-10-23 09:41:49.781989	2	2009-10-23 09:41:49.781989	2	PROJETO VIII. 7	\N	\N
101	PROJETO VIII. 8 – Atenção Integral à Saúde da População Negra	Programas: I (Projeto 1,2,); III (Projeto 4),  V (projeto 4), VII (projeto 1) VIII (Projeto 7 e 9)\r\nGabinete, CGR	1	10	38	2009-10-23 09:44:35.117568	2	2009-10-23 09:44:35.117568	2	PROJETO VIII. 8	\N	\N
102	PROJETO VIII. 9 – Atenção Integral à Saúde da Criança	Projetos: I.1, I.5, V.2, VII.1.5,VIII.1,VIII.3,VIII.7,VIII.8,VIII.11	1	10	87	2009-10-23 09:48:39.321451	2	2009-10-23 09:48:39.321451	2	PROJETO VIII. 9	\N	\N
103	PROJETO VIII. 10 – Aperfeiçoar a atenção à saúde da população do sistema penitenciário e dos adolescentes em conflito com a lei	Gabinete ,CGR e DRS\r\nPROGRAMA I (Projeto 1,2,)PROGRAMA II(PROJETO 5) Programa IV (PROJETO2)\r\nPROGRAMA V  (PROJETO 4) e VII (PROJETO 1) e programa VIII (Projeto 7 e 9)	1	10	88	2009-10-23 09:53:33.187084	2	2009-10-23 09:53:33.187084	2	PROJETO VIII. 10	\N	\N
104	PROJETO VIII. 11 – Atenção Integral à Saúde do Trabalhador	CCD, CRS, CRH, CPS	1	10	89	2009-10-23 09:57:20.500997	2	2009-10-23 09:57:20.500997	2	PROJETO VIII. 11	\N	\N
107	PROJETO VIII. 12 – Atenção Integral  à Hipertensão Arterial Sistêmica (HAS) e Diabetes Mellitus(DM)	PROGRAMAS I, II, IV; Projetos VIII ,VIII.2, VIII. VIII.8IX,IX.1,X	2	10	2	2009-10-23 10:12:41.915756	2	2009-10-23 10:15:57	2	PROJETO VIII. 12	104	\N
108	PROJETO VIII. 12 – Atenção Integral  à Hipertensão Arterial Sistêmica (HAS) e Diabetes Mellitus(DM)	PROGRAMAS I, II, IV; Projetos VIII ,VIII.2, VIII. VIII.8IX,IX.1,X	1	10	2	2009-10-23 10:16:54.037622	2	2009-10-23 10:16:54.037622	2	PROJETO VIII. 12	\N	\N
109	PROJETO IX. 1 – Desenvolvimento de habilidades individuais na comunidade de forma a torná-la coletivamente promotora da sua saúde	SES (CPS/GTAE, CRATOD, IS, CRS, CRH, GABINETE DO SECRETARIO)	1	11	71	2009-10-23 10:22:04.392868	2	2009-10-23 10:22:04.392868	2	PROJETO IX. 1	\N	\N
110	PROJETO IX. 2 – Promoção de Alimentação Saudável.	SES (CPS/GTAE, CRATOD, IS, CRS, CRH, GABINETE DO SECRETARIO)	1	11	91	2009-10-23 10:27:23.31399	2	2009-10-23 10:27:23.31399	2	PROJETO IX. 2	\N	\N
111	PROJETO X.1 – Participação Social	.	1	12	92	2009-10-23 10:35:21.665039	2	2009-10-23 10:35:21.665039	2	PROJETO X.1	\N	\N
112	PROJETO X. 2 – APERFEIÇOAR O SISTEMA DE OUVIDORIA NA SAÚDE	.	1	12	93	2009-10-23 10:38:10.395628	2	2009-10-23 10:38:10.395628	2	PROJETO X. 2	\N	\N
113	SUBPROJETO VIII. 11.2 – Controle Sanitário dos riscos à saúde nos processos produtivos	CCD, CRS, CPS	1	10	90	2009-10-23 10:56:52.752201	2	2009-10-23 10:56:52.752201	2	SUBPROJ  VIII. 11.2	104	\N
\.


--
-- TOC entry 2032 (class 0 OID 26060)
-- Dependencies: 1581
-- Data for Name: recursos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY recursos (id, fonte, valor, destino, situacao, meta_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin;
\.


--
-- TOC entry 2033 (class 0 OID 26067)
-- Dependencies: 1583
-- Data for Name: situacoes; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY situacoes (id, descricao) FROM stdin;
1	ativo
2	inativo
\.


--
-- TOC entry 2034 (class 0 OID 26072)
-- Dependencies: 1585
-- Data for Name: tipo_periodo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY tipo_periodo (id, periodo, descricao) FROM stdin;
\.


--
-- TOC entry 2035 (class 0 OID 26082)
-- Dependencies: 1588
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: postgres
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
23	Otávio de A. Mercadante	otavio.m	842a9fb931794ce878e1eea920fc905e	otavio@	1	26c14068f5666bbf781496fee158241f
24	Aniara Corrêa	aniara.c	696cf119ac526540b828435394c55fd7	aniara@	1	16debee2b414ab2354d74be84bfcd0d7
25	Lucia Chibante	lucia.chibante	f7a2a6f6315babc79f0bbd12d489c8f4	lucia@	1	fabcf4e9e6b0e228898b8bc27a8b0f60
26	Mônica A M Cecilio	monica.cecilio	1d3e4291771ab242ee5972d25ef3f6da	monica@	1	e6ccb96929086048a065c2abddc53eaf
27	Suely Vallim	suely.vallim	970fe01313dbaa15acf0f1508a01636b	suely@	1	bf1aa45654fd3e1a54625f61816022fb
28	Tania Lago	tania.lago	5998bbbecd896b4e124b6fc7af768531	tania@	1	1ff6724aef5dc58d6178e877a4e52269
29	Rosana M Tamelini	rosana.tamenelini	b85b59c2093da4aef588f303e0381ad3	rosana	1	2de09a4a11f877e0c634f063160087b3
30	Vanderlei Soares Moya	vanderlei.moya	e72aeab00ce3f694dc93a2d31650e5e9	vanderlei@	1	60728ddcec2e1b03752350f3b59cb2f8
31	Mario Malamo	mario.malamo	5db89abc83205414f6dfc69db8ee8cad	mario@	1	e0268ecd5aabc5664fbe9a5d65b87720
32	Adriana Magalhães	adriana.m	8f3d63224ece1f9efd9a15126384b0d9	adriana.m@	1	b8abbbed3622932a658c3944384c4c50
33	Edson Keiji Yamamoto	edson.k	0f8fdc7f5b7f38dcbf66733c876ce6c9	edson.k@	1	33f1f016e05a41a9c8377f45f7491e23
34	Astrid Toloi	astrid.t	291ff450446d0a6686e94680f4f2aa84	astrid@	1	cc80cfedf807b6b67bb4eb3a02860270
35	Paula Tanaka	paula.t	a623b6f4081266ab2d5d59be388240f4	paula.t@	1	fdbb58cd207bcae300fb525153be079f
36	Silvio Augusto Margarida	silvio.a	d62ba395ba518691f24f851d058325ca	silvio.a@	1	33f550171807d71936d2bd280700e00b
37	Márcia Zemella Marques	marcia.z	e36c91552bf8f8b7dea8c88ac0bf31b9	marcia@	1	a864f7e8b6e9266326e3d3345f3cc4ac
38	Adalgisa Nomura  	adalgisa.n	5467a8e7f139a9862b1a5807a55074f0	adalgisa@	1	b0356706cc40b1b1c201c295bf7acb15
39	Maria do Carmo M.Schiavon	maria.schiavom	f5591a5192236162488076f840d6ea29	maria@	1	9e2cac570c19d3c970406e12366c2699
40	Eliana Satiko Shiine Gravinez	eliana.satiko	98e18f54574b30e686bc47f0cdb763c0	eliana@	1	33cea8c7dd8692afb03fade03b7fc9d9
41	Osvaldo Donnini	osvaldo.d	2188854dc822dd52268710e7c0158a71	osvaldo@	1	c72e2ed6f94652261360d989167fb3f9
42	Luíza S. Heimann	luiza.heimann	107fd1293aae08129ee10f4153a71b99	luiza@	1	cb110aa8c4a9e37b24c4d700574b7e6b
43	Débora Rita Bujarto Santana	debora.rita	9b8a2f020a2494dccf80e7cbd3c84a74	debora@	1	f1f6a3dbd8b0e9544ef08e8eb4ccc32d
44	Marcio Cidade Gomes	marcio.cidade	449e3865a81639b7d29806916cf7462f	marcio@	1	92b45483fa1292318c762cd601e66280
45	Cleusa Abreu	cleusa.abreu	5cf468f97401eae881c1a9b47e9be74d	cleusa@	1	bfa7641f7e742903d7ad5bd867f6870a
46	Arnaldo Sala	arnaldo.s	c36d2ad1d76bbedc16900cf32b757f3b	arnaldo@	1	dfb53d30f35a11138c56cd4b6063f5c1
47	Francisco Pires	francisco.p	d17a5955e124e6d7c65c64c6dc5967af	francisco.p@	1	c182c9df4fecf0ddf156c3149cc8ac32
48	Adriana Carro	adriana.c	d4b19e9cd1b7d02b9e24855a291f547c	adriana@	1	227e0ec2d5af016edcf20c1c319a258f
49	Claudia Carnevalle	claudia.carnevalle	e7e94a884326c4b1462ab0986078b9bc	claudia@	1	4c6616b6d02ff52b8f7b59b6213ae2c6
50	Stella Puppini	stella.p	34a22b96ba534c83b1d1987d77e06d5b	stella@	1	033e352e29bc1507a798e4d8b12f99da
51	Nivaldo Teixeira	nivaldo.t	e48b1db7bb60fe29686bbd5cbda7d72d	nivaldo@	1	7d6632b125818f02a974fcd9b5e92187
52	Regina Sancia	regina.s	187f37310da9980233cad821256d2095	regina@	1	749f4c61585aba78558f4b9d88fc5813
53	Maria Aparecida Novaes	maria.aparecida	8bbbb94b7b31b50c671557c9b43d3bf8	maria.aparecida@	1	7de5fbc50111635780595223f9bd89f6
54	Karina Calife	karina.c	4b4e910ba6b2a3fc87ebe76e2b6f0b14	karina@	1	6f11efa24707fd5951271a82954bf2d4
55	Otília Simões	otilia.s	eca2c61532cf7afb3f7f6800e1470905	otilia@	1	c14c962276f9bf5df7bea6ea20ac2922
56	Cristina Alonso e Carolina Feitora	cristina.alonso	b615900fa37423169481770baabbd2a8	cristina@	1	8eab909605817ccbba9666d193ca102d
57	Yamara Martins	yamara.m	f26fe1aaacdaeab452671fe82ec38ed3	yamara@	1	da7c58d73f50358376bf00d88e331ecf
58	Neil Boaretti	neil.b	f0854e221f736af7c551fcb2e281ab80	neil@	1	4f450f083505172f36cb1aca7a991040
59	Cecilia Maria Castex Aly	cecilia.maria	0a021a399ac9eb884f4ba8566124e325	cecilia@	1	b50aa8792e44dec1b9fcff0f55a755da
60	Luci Emi Guibu	luci.emi	4a4e84f17724737c8e8b42698beabb23	luci@	1	60bc2708652d81f2a645719c5cb93db9
61	Paulo Seixas	paulo.s	280a1e40f66a2eaeee41b96ed08c33bc	paulo.s@	1	629d40d980fb4bcc0d9e3320534a92dc
62	Irene Abramovich	irene.a	d1c65d0f1ed78138c63ce17a1c8ea0ca	irene@	1	ce48553b9f554d425d4e51b8f60d73b8
63	Ana Freitas Ribeiro	ana.freitas	d48c74958974d27d95e96f2ff21354dc	ana@	1	aac6b052fee0892b179be847e65bbc79
64	Telma Regina M. P. Carvalhanas	telma.r	4c35abdc30f6d8caaceeb5ecef6e7d49	telma@	1	868438b88e687bf5d019e1577a2fe1a6
65	Denise Brandão	denise.b	90001df751fc94a48b6fc77fceb6eff1	denise@	1	1d84b20e0c93d7ed0c7c6fcb95aa01df
66	Maria Bernadete de Paula Eduardo	maria.bernadete	6e52c4c572341ccf752f575f8930ff5e	maria.b@	1	161eff2c7e0d60775593bf39adeb7b32
67	Melissa Mascheretti	melissa.m	dd32de9cb1d98afa9a45961ac0462c07	melissa@	1	91800a93f399e8883e0f1d09390c3093
68	Vera Galesi	vera.g	0517f24627c9e157dcb537d078c34eb4	vera@	1	02ddb04aa7786b12966feaa23abbb5fe
69	Mary Lise Marzliak	mary.lise	6ab7388c55051021387bac81f4e369ec	mary@	1	4d8b4a34f7b6fb9d551149f8d75a75be
70	Maria Clara Gianna	maria.clara	6d16df9f4ee4208c7d3be01d2e86dcee	maria.clara@	1	1745ec60d73d4bc85ae26617fd0a19d3
71	Sergio Sanfins	sergio.s	8163493bf31f583e6527dbf6054d0297	sergio@	1	7d2ed3aa7aab6aca69cb229d8b593bea
72	CRISTINA MEGID (CVS / CCD)	cristina.m	06a53bc91749b46c59e9b4a1c5db5bd0	cristina.m@	1	4f1a835ce4afe651a0501d3a9c527d59
73	MARIA APARECIDA AGUIAR (SERSA / CVS)	maria.aguiar	aad4df049fd47b7bfb24d61dd7a45fbb	maria.aguiar@	1	114f3503d8eb68445bf18e1254a32373
74	ISABEL L. A. MORAES	isabel.moraes	c075279679ee4b32a41002f102dc6eb9	isabel@	1	f0f06a06c32936b910fce3dc47ec1fd5
75	ELIANE GANDOLFI (GTOX / CCD)	eliane.g	081a3a2496de6a7f66499cb0b6530fbf	eliane@	1	2c1b554b9dfae5a9edfc5e9c60e4338d
76	CLELIA ARANDA	clelia.a	1d50cb779c472f20605422951f02c62c	clelia@	1	e5bace0a2822a6b66c0fc3afae458070
77	Marta Salomão	marta.s	ca3effc8be7410579e81fafb44848ebf	marta.s@	1	f511cb7a9a17cab9d57a46ce97d70e94
78	Júlia de Souza Felippe	julia.souza	feae773cb2bd2cb3252fdb2c21c8c9cb	julia@	1	9f69418cff1f1c262755f729a0d1bd61
79	Tânia Regina Tura Mendonça	tania.r	894dc0462a1aafdc951048f98b82e640	tania.r@	1	21124da2f2a22465356ac044abe16685
80	Marília Cristina Prado Louvison	marilia.prado	785002bf4468f986fd32dcfabe36514e	marilia@	1	9d105031eb976a30cbda1bfd3af567d8
81	Márcia Tiveron	marcia.t	8a69b47c7dc40813df371a0eb0bbc851	marcia.t@	1	89204de2145259a7505f0c280d0b6ac9
82	Márcia Aparecida Ferreira de Oliveira	marcia.a	90f9b7ce11d1c9c59f96a54e89eacb74	marcia.a@	1	4135cec647146ace4b0f944735039e7b
83	Regina Bichaff	regina.b	d076233e79bd6ecfc471cde26b3ea21a	regina.b@	1	afa3f1792f31f1f70eb05b93eb7450e1
84	Augusta Sato	augusta.s	28b0772e8ab73d6481aea4ab10a92fc7	augusta@	1	1b919e11169d8b5fa1464b8d077f9a70
85	Cláudia Medeiros de Castro	claudia.medeiros	f4b4be43c084ca93285338d4430c87a0	claudia.medeiros@	1	9fa224b37901cc9f0dfe5c10cf4dc6eb
86	Luís Eduardo Batista	luis.e	fc88ddc2a628f24d505323d3126d02eb	luis@	1	252d4fe43db959fe17f20795bebfcbda
87	Sandra Regina de Souza	sandra.r	9a3d86290e95275851eac97632252b80	sandra@	1	588f1d30a5a109aee62a97f2c23dbcba
88	Maria Luiza Rebouças Stucchi	maria.luiza	ab1f7653e5d554c5ac6e25efb9c03fb6	maria.luiza@	1	62add4ee98ecc2ca054971780e23b9bf
89	Francisco Drumond Marcondes	francisco.d	fadce9b50ae03cf3e7df8c51a1a071c3	francisco.d@	1	5e1aa167a01ddfa6777efdc9f6430925
90	Elba Pinheiro A. Custódio	elba.p	c6720f02db23a9aab5db6325c651cab2	elba@	1	39afbb46ed48b2bc757afba236201d75
91	Adriana Bouças Ribeiro	adriana.b	102f2fda665738a564a368b6af03c769	adriana.b@	1	e6c0eae06b7ca8e34dff83628a892d13
92	Liliana Risolia Navarro	liliana.r	e6e3f10349ceb70c27098c2abc1a3c95	liliana@	1	8e6b411c64bfa43db6870fc10625e229
93	Elza Ferreira Lobo	elza.lobo	2acfeef32ab9487f9826452c572f276a	elza@	1	71951a786bcae1910a55ad5a9156426f
\.


--
-- TOC entry 2036 (class 0 OID 26090)
-- Dependencies: 1589
-- Data for Name: usuarios_grupos; Type: TABLE DATA; Schema: public; Owner: postgres
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
50	23	4
51	23	3
52	24	4
53	24	3
54	25	4
55	25	3
56	26	4
57	26	3
58	27	4
59	27	3
60	28	4
61	28	3
62	29	4
63	29	3
64	30	4
65	30	3
66	31	4
67	31	3
68	32	4
69	32	3
70	33	4
71	33	3
72	34	4
73	34	3
74	35	4
75	35	3
76	36	4
77	36	3
78	37	4
79	37	3
80	38	4
81	38	3
82	39	4
83	39	3
84	40	4
85	40	3
86	41	4
87	41	3
88	42	4
89	42	3
90	43	4
91	43	3
92	44	4
93	44	3
94	45	4
95	45	3
96	46	4
97	46	3
98	47	4
99	47	3
100	48	4
101	48	3
102	49	4
103	49	3
104	50	4
105	50	3
106	51	4
107	51	3
108	52	4
109	52	3
110	53	4
111	53	3
112	54	4
113	54	3
114	55	4
115	55	3
116	56	4
117	56	3
118	57	4
119	57	3
120	58	4
121	58	3
122	59	4
123	59	3
124	60	4
125	60	3
126	61	4
127	61	3
128	62	4
129	62	3
130	63	4
131	63	3
132	64	4
133	64	3
134	65	4
135	65	3
136	66	4
137	66	3
138	67	4
139	67	3
140	68	4
141	68	3
142	69	4
143	69	3
144	70	4
145	70	3
146	71	4
147	71	3
148	72	4
149	72	3
150	73	4
151	73	3
152	74	4
153	74	3
154	75	4
155	75	3
156	76	4
157	76	3
158	77	4
159	77	3
160	78	4
161	78	3
162	79	4
163	79	3
164	80	4
165	80	3
166	81	4
167	81	3
168	82	4
169	82	3
170	83	4
171	83	3
172	84	4
173	84	3
174	85	4
175	85	3
176	86	4
177	86	3
178	87	4
179	87	3
180	88	4
181	88	3
182	89	4
183	89	3
184	90	4
185	90	3
186	91	4
187	91	3
188	92	4
189	92	3
190	93	4
191	93	3
\.


--
-- TOC entry 1930 (class 2606 OID 26119)
-- Dependencies: 1549 1549
-- Name: pk_acao_id; Type: CONSTRAINT; Schema: public; Owner: planejamento; Tablespace: 
--

ALTER TABLE ONLY acoes
    ADD CONSTRAINT pk_acao_id PRIMARY KEY (id);


--
-- TOC entry 1991 (class 2606 OID 26387)
-- Dependencies: 1599 1599
-- Name: pk_atividade_id; Type: CONSTRAINT; Schema: public; Owner: planejamento; Tablespace: 
--

ALTER TABLE ONLY atividades
    ADD CONSTRAINT pk_atividade_id PRIMARY KEY (id);


--
-- TOC entry 1934 (class 2606 OID 26121)
-- Dependencies: 1551 1551
-- Name: pk_estrategia_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY estrategias_acao
    ADD CONSTRAINT pk_estrategia_id PRIMARY KEY (id);


--
-- TOC entry 1938 (class 2606 OID 26123)
-- Dependencies: 1555 1555
-- Name: pk_grupo_permissao_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos_permissoes
    ADD CONSTRAINT pk_grupo_permissao_id PRIMARY KEY (id);


--
-- TOC entry 1940 (class 2606 OID 26125)
-- Dependencies: 1557 1557
-- Name: pk_indicador_configs_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicador_config
    ADD CONSTRAINT pk_indicador_configs_id PRIMARY KEY (id);


--
-- TOC entry 1942 (class 2606 OID 26127)
-- Dependencies: 1559 1559
-- Name: pk_indicador_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicadores
    ADD CONSTRAINT pk_indicador_id PRIMARY KEY (id);


--
-- TOC entry 1983 (class 2606 OID 26326)
-- Dependencies: 1593 1593
-- Name: pk_indicadores_programa_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicadores_programa
    ADD CONSTRAINT pk_indicadores_programa_id PRIMARY KEY (id);


--
-- TOC entry 1985 (class 2606 OID 26344)
-- Dependencies: 1595 1595
-- Name: pk_indicadores_projeto_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY indicadores_projeto
    ADD CONSTRAINT pk_indicadores_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1946 (class 2606 OID 26133)
-- Dependencies: 1561 1561
-- Name: pk_meta_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY metas_acao
    ADD CONSTRAINT pk_meta_id PRIMARY KEY (id);


--
-- TOC entry 1948 (class 2606 OID 26135)
-- Dependencies: 1563 1563
-- Name: pk_meta_programas_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY metas_programa
    ADD CONSTRAINT pk_meta_programas_id PRIMARY KEY (id);


--
-- TOC entry 1950 (class 2606 OID 26137)
-- Dependencies: 1565 1565
-- Name: pk_metas_projeto_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY metas_projeto
    ADD CONSTRAINT pk_metas_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1952 (class 2606 OID 26139)
-- Dependencies: 1567 1567
-- Name: pk_objetivos_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY objetivos_acao
    ADD CONSTRAINT pk_objetivos_id PRIMARY KEY (id);


--
-- TOC entry 1954 (class 2606 OID 26141)
-- Dependencies: 1569 1569
-- Name: pk_objetivos_programas_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY objetivos_programa
    ADD CONSTRAINT pk_objetivos_programas_id PRIMARY KEY (id);


--
-- TOC entry 1956 (class 2606 OID 26143)
-- Dependencies: 1571 1571
-- Name: pk_objetivos_projeto_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY objetivos_projeto
    ADD CONSTRAINT pk_objetivos_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1988 (class 2606 OID 26366)
-- Dependencies: 1597 1597
-- Name: pk_operacao_id; Type: CONSTRAINT; Schema: public; Owner: planejamento; Tablespace: 
--

ALTER TABLE ONLY operacoes
    ADD CONSTRAINT pk_operacao_id PRIMARY KEY (id);


--
-- TOC entry 1960 (class 2606 OID 26145)
-- Dependencies: 1575 1575
-- Name: pk_parceria_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY parcerias_acao
    ADD CONSTRAINT pk_parceria_id PRIMARY KEY (id);


--
-- TOC entry 1958 (class 2606 OID 26147)
-- Dependencies: 1573 1573
-- Name: pk_permissao_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY paginas
    ADD CONSTRAINT pk_permissao_id PRIMARY KEY (id);


--
-- TOC entry 1962 (class 2606 OID 26149)
-- Dependencies: 1577 1577
-- Name: pk_programas_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT pk_programas_id PRIMARY KEY (id);


--
-- TOC entry 1966 (class 2606 OID 26151)
-- Dependencies: 1579 1579
-- Name: pk_projeto_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY projetos
    ADD CONSTRAINT pk_projeto_id PRIMARY KEY (id);


--
-- TOC entry 1970 (class 2606 OID 26153)
-- Dependencies: 1581 1581
-- Name: pk_recursos_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY recursos
    ADD CONSTRAINT pk_recursos_id PRIMARY KEY (id);


--
-- TOC entry 1936 (class 2606 OID 26155)
-- Dependencies: 1553 1553
-- Name: pk_roles_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY grupos
    ADD CONSTRAINT pk_roles_id PRIMARY KEY (id);


--
-- TOC entry 1974 (class 2606 OID 26157)
-- Dependencies: 1583 1583
-- Name: pk_situacao_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY situacoes
    ADD CONSTRAINT pk_situacao_id PRIMARY KEY (id);


--
-- TOC entry 1976 (class 2606 OID 26159)
-- Dependencies: 1585 1585
-- Name: pk_tipo_periodo_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY tipo_periodo
    ADD CONSTRAINT pk_tipo_periodo_id PRIMARY KEY (id);


--
-- TOC entry 1981 (class 2606 OID 26161)
-- Dependencies: 1589 1589
-- Name: pk_users_roles_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuarios_grupos
    ADD CONSTRAINT pk_users_roles_id PRIMARY KEY (id);


--
-- TOC entry 1978 (class 2606 OID 26163)
-- Dependencies: 1588 1588
-- Name: pk_usuarios_id; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT pk_usuarios_id PRIMARY KEY (id);


--
-- TOC entry 1928 (class 1259 OID 26164)
-- Dependencies: 1549
-- Name: acoes_projeto_id_index; Type: INDEX; Schema: public; Owner: planejamento; Tablespace: 
--

CREATE INDEX acoes_projeto_id_index ON acoes USING btree (projeto_id);


--
-- TOC entry 1989 (class 1259 OID 26393)
-- Dependencies: 1599
-- Name: atividades_operacao_id_index; Type: INDEX; Schema: public; Owner: planejamento; Tablespace: 
--

CREATE INDEX atividades_operacao_id_index ON atividades USING btree (operacao_id);


--
-- TOC entry 1931 (class 1259 OID 26165)
-- Dependencies: 1551
-- Name: estrategias_objetivo_id_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX estrategias_objetivo_id_index ON estrategias_acao USING btree (objetivo_id);


--
-- TOC entry 1932 (class 1259 OID 26166)
-- Dependencies: 1551
-- Name: estrategias_situacao_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX estrategias_situacao_index ON estrategias_acao USING btree (situacao_id);


--
-- TOC entry 1943 (class 1259 OID 26167)
-- Dependencies: 1561
-- Name: metas_objetivo_id_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX metas_objetivo_id_index ON metas_acao USING btree (objetivo_id);


--
-- TOC entry 1944 (class 1259 OID 26168)
-- Dependencies: 1561
-- Name: metas_situacao_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX metas_situacao_index ON metas_acao USING btree (situacao_id);


--
-- TOC entry 1986 (class 1259 OID 26372)
-- Dependencies: 1597
-- Name: operacoes_metas_acao_id_index; Type: INDEX; Schema: public; Owner: planejamento; Tablespace: 
--

CREATE INDEX operacoes_metas_acao_id_index ON operacoes USING btree (metas_acao_id);


--
-- TOC entry 1963 (class 1259 OID 26169)
-- Dependencies: 1577
-- Name: programas_alteracao_usuario_id_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX programas_alteracao_usuario_id_index ON programas USING btree (alteracao_usuario_id);


--
-- TOC entry 1964 (class 1259 OID 26170)
-- Dependencies: 1577
-- Name: programas_responsavel_id_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX programas_responsavel_id_index ON programas USING btree (responsavel_id);


--
-- TOC entry 1967 (class 1259 OID 26171)
-- Dependencies: 1579
-- Name: projetos_programa_id_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX projetos_programa_id_index ON projetos USING btree (programa_id);


--
-- TOC entry 1968 (class 1259 OID 26172)
-- Dependencies: 1579
-- Name: projetos_situacao_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX projetos_situacao_index ON projetos USING btree (situacao_id);


--
-- TOC entry 1971 (class 1259 OID 26173)
-- Dependencies: 1581
-- Name: recursos_meta_id_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX recursos_meta_id_index ON recursos USING btree (meta_id);


--
-- TOC entry 1972 (class 1259 OID 26174)
-- Dependencies: 1581
-- Name: recursos_situacao_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX recursos_situacao_index ON recursos USING btree (situacao);


--
-- TOC entry 1979 (class 1259 OID 26175)
-- Dependencies: 1588
-- Name: usuarios_username_index; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX usuarios_username_index ON usuarios USING btree (username);


--
-- TOC entry 2001 (class 2606 OID 26176)
-- Dependencies: 1549 1567 1929
-- Name: fk_acao_objetivo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY objetivos_acao
    ADD CONSTRAINT fk_acao_objetivo FOREIGN KEY (acao_id) REFERENCES acoes(id);


--
-- TOC entry 1992 (class 2606 OID 26181)
-- Dependencies: 1579 1549 1965
-- Name: fk_acoes_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: planejamento
--

ALTER TABLE ONLY acoes
    ADD CONSTRAINT fk_acoes_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id);


--
-- TOC entry 2015 (class 2606 OID 26388)
-- Dependencies: 1987 1599 1597
-- Name: fk_atividade_operacao_id; Type: FK CONSTRAINT; Schema: public; Owner: planejamento
--

ALTER TABLE ONLY atividades
    ADD CONSTRAINT fk_atividade_operacao_id FOREIGN KEY (operacao_id) REFERENCES operacoes(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1994 (class 2606 OID 26186)
-- Dependencies: 1935 1553 1555
-- Name: fk_grupo_paginas; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_permissoes
    ADD CONSTRAINT fk_grupo_paginas FOREIGN KEY (grupo_id) REFERENCES grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2008 (class 2606 OID 26191)
-- Dependencies: 1935 1589 1553
-- Name: fk_grupo_usuarios; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_grupos
    ADD CONSTRAINT fk_grupo_usuarios FOREIGN KEY (grupo_id) REFERENCES grupos(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1996 (class 2606 OID 26196)
-- Dependencies: 1941 1557 1559
-- Name: fk_indicador_config_indicador_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicador_config
    ADD CONSTRAINT fk_indicador_config_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores(id);


--
-- TOC entry 1997 (class 2606 OID 26201)
-- Dependencies: 1585 1975 1557
-- Name: fk_indicador_config_tipo_periodo_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicador_config
    ADD CONSTRAINT fk_indicador_config_tipo_periodo_id FOREIGN KEY (tipo_periodo_id) REFERENCES tipo_periodo(id);


--
-- TOC entry 2012 (class 2606 OID 26345)
-- Dependencies: 1941 1595 1559
-- Name: fk_indicador_projeto_indicador_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicadores_projeto
    ADD CONSTRAINT fk_indicador_projeto_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2013 (class 2606 OID 26350)
-- Dependencies: 1595 1965 1579
-- Name: fk_indicador_projeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicadores_projeto
    ADD CONSTRAINT fk_indicador_projeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2010 (class 2606 OID 26327)
-- Dependencies: 1559 1941 1593
-- Name: fk_indicadorprograma_indicador_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicadores_programa
    ADD CONSTRAINT fk_indicadorprograma_indicador_id FOREIGN KEY (indicador_id) REFERENCES indicadores(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2011 (class 2606 OID 26332)
-- Dependencies: 1961 1577 1593
-- Name: fk_indicadorprograma_programa_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY indicadores_programa
    ADD CONSTRAINT fk_indicadorprograma_programa_id FOREIGN KEY (programa_id) REFERENCES programas(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1999 (class 2606 OID 26226)
-- Dependencies: 1961 1563 1577
-- Name: fk_metasprograma_programa_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY metas_programa
    ADD CONSTRAINT fk_metasprograma_programa_id FOREIGN KEY (programa_id) REFERENCES programas(id) ON DELETE CASCADE;


--
-- TOC entry 2000 (class 2606 OID 26231)
-- Dependencies: 1965 1579 1565
-- Name: fk_metasprojeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY metas_projeto
    ADD CONSTRAINT fk_metasprojeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE;


--
-- TOC entry 1993 (class 2606 OID 26236)
-- Dependencies: 1951 1567 1551
-- Name: fk_objetivo_estrategia; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY estrategias_acao
    ADD CONSTRAINT fk_objetivo_estrategia FOREIGN KEY (objetivo_id) REFERENCES objetivos_acao(id);


--
-- TOC entry 1998 (class 2606 OID 26241)
-- Dependencies: 1567 1951 1561
-- Name: fk_objetivo_meta; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY metas_acao
    ADD CONSTRAINT fk_objetivo_meta FOREIGN KEY (objetivo_id) REFERENCES objetivos_acao(id);


--
-- TOC entry 2002 (class 2606 OID 26246)
-- Dependencies: 1577 1569 1961
-- Name: fk_objetivoprograma_programa_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY objetivos_programa
    ADD CONSTRAINT fk_objetivoprograma_programa_id FOREIGN KEY (programa_id) REFERENCES programas(id) ON DELETE CASCADE;


--
-- TOC entry 2003 (class 2606 OID 26251)
-- Dependencies: 1571 1965 1579
-- Name: fk_objetivosprojeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY objetivos_projeto
    ADD CONSTRAINT fk_objetivosprojeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON DELETE CASCADE;


--
-- TOC entry 2014 (class 2606 OID 26367)
-- Dependencies: 1945 1597 1561
-- Name: fk_operacao_metas_acao_id; Type: FK CONSTRAINT; Schema: public; Owner: planejamento
--

ALTER TABLE ONLY operacoes
    ADD CONSTRAINT fk_operacao_metas_acao_id FOREIGN KEY (metas_acao_id) REFERENCES metas_acao(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2004 (class 2606 OID 26256)
-- Dependencies: 1977 1577 1588
-- Name: fk_programas_responsavel_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT fk_programas_responsavel_id FOREIGN KEY (responsavel_id) REFERENCES usuarios(id);


--
-- TOC entry 2006 (class 2606 OID 26261)
-- Dependencies: 1961 1577 1579
-- Name: fk_projetos_programa_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY projetos
    ADD CONSTRAINT fk_projetos_programa_id FOREIGN KEY (programa_id) REFERENCES programas(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2005 (class 2606 OID 26266)
-- Dependencies: 1577 1583 1973
-- Name: fk_situacoes_programas; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY programas
    ADD CONSTRAINT fk_situacoes_programas FOREIGN KEY (situacao_id) REFERENCES situacoes(id) ON UPDATE CASCADE ON DELETE RESTRICT;


--
-- TOC entry 2007 (class 2606 OID 26271)
-- Dependencies: 1579 1965 1579
-- Name: fk_subprojeto_projeto_id; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY projetos
    ADD CONSTRAINT fk_subprojeto_projeto_id FOREIGN KEY (projeto_id) REFERENCES projetos(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2009 (class 2606 OID 26276)
-- Dependencies: 1589 1977 1588
-- Name: fk_usuario_grupos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY usuarios_grupos
    ADD CONSTRAINT fk_usuario_grupos FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1995 (class 2606 OID 26281)
-- Dependencies: 1555 1957 1573
-- Name: pagina_grupos; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY grupos_permissoes
    ADD CONSTRAINT pagina_grupos FOREIGN KEY (pagina_id) REFERENCES paginas(id) ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2045 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2009-10-24 11:25:48 BRST

--
-- PostgreSQL database dump complete
--

