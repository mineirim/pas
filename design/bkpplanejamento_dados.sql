--
-- PostgreSQL database dump
--

-- Started on 2009-10-18 17:02:30 BRST

SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

SET search_path = public, pg_catalog;

--
-- TOC entry 2012 (class 0 OID 0)
-- Dependencies: 1581
-- Name: acoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('acoes_id_seq', 44, true);


--
-- TOC entry 2013 (class 0 OID 0)
-- Dependencies: 1585
-- Name: estrategias_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('estrategias_acao_id_seq', 33, true);


--
-- TOC entry 2014 (class 0 OID 0)
-- Dependencies: 1544
-- Name: grupos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('grupos_id_seq', 20, true);


--
-- TOC entry 2015 (class 0 OID 0)
-- Dependencies: 1546
-- Name: grupos_permissoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('grupos_permissoes_id_seq', 47, true);


--
-- TOC entry 2016 (class 0 OID 0)
-- Dependencies: 1548
-- Name: indicador_config_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('indicador_config_id_seq', 1, false);


--
-- TOC entry 2017 (class 0 OID 0)
-- Dependencies: 1550
-- Name: indicadores_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('indicadores_id_seq', 1, false);


--
-- TOC entry 2018 (class 0 OID 0)
-- Dependencies: 1552
-- Name: indicadores_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('indicadores_programa_id_seq', 1, false);


--
-- TOC entry 2019 (class 0 OID 0)
-- Dependencies: 1554
-- Name: indicadores_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('indicadores_projeto_id_seq', 1, false);


--
-- TOC entry 2020 (class 0 OID 0)
-- Dependencies: 1587
-- Name: metas_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('metas_acao_id_seq', 15, true);


--
-- TOC entry 2021 (class 0 OID 0)
-- Dependencies: 1556
-- Name: metas_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('metas_programa_id_seq', 14, true);


--
-- TOC entry 2022 (class 0 OID 0)
-- Dependencies: 1558
-- Name: metas_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('metas_projeto_id_seq', 17, true);


--
-- TOC entry 2023 (class 0 OID 0)
-- Dependencies: 1583
-- Name: objetivos_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('objetivos_acao_id_seq', 130, true);


--
-- TOC entry 2024 (class 0 OID 0)
-- Dependencies: 1560
-- Name: objetivos_programa_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('objetivos_programa_id_seq', 7, true);


--
-- TOC entry 2025 (class 0 OID 0)
-- Dependencies: 1562
-- Name: objetivos_projeto_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('objetivos_projeto_id_seq', 18, true);


--
-- TOC entry 2026 (class 0 OID 0)
-- Dependencies: 1564
-- Name: paginas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('paginas_id_seq', 11, true);


--
-- TOC entry 2027 (class 0 OID 0)
-- Dependencies: 1589
-- Name: parcerias_acao_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('parcerias_acao_id_seq', 7, true);


--
-- TOC entry 2028 (class 0 OID 0)
-- Dependencies: 1565
-- Name: programas_id; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('programas_id', 1, false);


--
-- TOC entry 2029 (class 0 OID 0)
-- Dependencies: 1567
-- Name: programas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('programas_id_seq', 25, true);


--
-- TOC entry 2030 (class 0 OID 0)
-- Dependencies: 1569
-- Name: projetos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('projetos_id_seq', 20, true);


--
-- TOC entry 2031 (class 0 OID 0)
-- Dependencies: 1571
-- Name: recursos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('recursos_id_seq', 1, false);


--
-- TOC entry 2032 (class 0 OID 0)
-- Dependencies: 1573
-- Name: situacoes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('situacoes_id_seq', 2, true);


--
-- TOC entry 2033 (class 0 OID 0)
-- Dependencies: 1575
-- Name: tipo_periodo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('tipo_periodo_id_seq', 5, true);


--
-- TOC entry 2034 (class 0 OID 0)
-- Dependencies: 1576
-- Name: usuarios_id; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('usuarios_id', 1, false);


--
-- TOC entry 2035 (class 0 OID 0)
-- Dependencies: 1579
-- Name: usuarios_grupos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('usuarios_grupos_id_seq', 49, true);


--
-- TOC entry 2036 (class 0 OID 0)
-- Dependencies: 1580
-- Name: usuarios_id_seq; Type: SEQUENCE SET; Schema: public; Owner: planejamento
--

SELECT pg_catalog.setval('usuarios_id_seq', 22, true);


--
-- TOC entry 2005 (class 0 OID 17549)
-- Dependencies: 1582
-- Data for Name: acoes; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE acoes DISABLE TRIGGER ALL;

COPY acoes (id, descricao, recursos, cronograma, situacao_id, projeto_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin WITH DELIMITER AS '\t';
40	Constituição de Grupo de gerenciadores técnicos para ações de atenção básica (AB)	Recurso SES	Janeiro de 2009	1	3	2009-09-18 18:51:46.872521	2	2009-09-18 18:51:46.872521	2
42	Organização de Seminário Estadual de Atenção Básica	Recursos SES	Fevereiro/09 – Pactuação junto ao Conselho Estadual de Saúde, e Grupo Técnico Bipartite da AB\r\nAbril/09 – Pactuação junto à CIB\r\nMaio, junho e julho/09 – organização do evento\r\nAgosto /09 – realização do seminário	1	3	2009-09-18 19:10:04.354959	2	2009-09-18 19:10:04.354959	2
43	açao do subprojetoasdfsdf	recurso tal	janeiro	1	15	2009-09-20 17:54:54.25746	2	2009-09-24 11:38:07	2
44	Ação de Teste	Recurso SES	Cronograma Tal	1	11	2009-10-08 00:22:51.376431	2	2009-10-08 00:22:51.376431	2
\.


ALTER TABLE acoes ENABLE TRIGGER ALL;

--
-- TOC entry 2007 (class 0 OID 17584)
-- Dependencies: 1586
-- Data for Name: estrategias_acao; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE estrategias_acao DISABLE TRIGGER ALL;

COPY estrategias_acao (id, descricao, situacao_id, acao_id, objetivo_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE estrategias_acao ENABLE TRIGGER ALL;

--
-- TOC entry 1987 (class 0 OID 17073)
-- Dependencies: 1543
-- Data for Name: grupos; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE grupos DISABLE TRIGGER ALL;

COPY grupos (id, grupo, descricao) FROM stdin WITH DELIMITER AS '\t';
4	operadores	Operadores do sistema
5	analistas	Analistas de sistema
2	gerentes	Gerente
3	coordenador	Coordenadores de projetos
1	administradores	Administrador do Sistema
19	teste	teste de grupo
6	anonimo	Usuário anônimo
20	usuario	Usuário comum
\.


ALTER TABLE grupos ENABLE TRIGGER ALL;

--
-- TOC entry 1988 (class 0 OID 17078)
-- Dependencies: 1545
-- Data for Name: grupos_permissoes; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE grupos_permissoes DISABLE TRIGGER ALL;

COPY grupos_permissoes (id, grupo_id, pagina_id) FROM stdin WITH DELIMITER AS '\t';
1	1	\N
\.


ALTER TABLE grupos_permissoes ENABLE TRIGGER ALL;

--
-- TOC entry 1990 (class 0 OID 17088)
-- Dependencies: 1549
-- Data for Name: indicadores; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE indicadores DISABLE TRIGGER ALL;

COPY indicadores (id, descricao, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin WITH DELIMITER AS '\t';
\.


ALTER TABLE indicadores ENABLE TRIGGER ALL;

--
-- TOC entry 1989 (class 0 OID 17083)
-- Dependencies: 1547
-- Data for Name: indicadores_configs; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE indicadores_configs DISABLE TRIGGER ALL;

COPY indicadores_configs (id, indicador_id, tipo_periodo_id) FROM stdin WITH DELIMITER AS '\t';
\.


ALTER TABLE indicadores_configs ENABLE TRIGGER ALL;

--
-- TOC entry 1991 (class 0 OID 17098)
-- Dependencies: 1551
-- Data for Name: indicadores_programa; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE indicadores_programa DISABLE TRIGGER ALL;

COPY indicadores_programa (id, programa_id, indicador_config_id) FROM stdin WITH DELIMITER AS '\t';
\.


ALTER TABLE indicadores_programa ENABLE TRIGGER ALL;

--
-- TOC entry 1992 (class 0 OID 17103)
-- Dependencies: 1553
-- Data for Name: indicadores_projeto; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE indicadores_projeto DISABLE TRIGGER ALL;

COPY indicadores_projeto (id, projeto_id, indicador_config_id) FROM stdin WITH DELIMITER AS '\t';
\.


ALTER TABLE indicadores_projeto ENABLE TRIGGER ALL;

--
-- TOC entry 2008 (class 0 OID 17602)
-- Dependencies: 1588
-- Data for Name: metas_acao; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE metas_acao DISABLE TRIGGER ALL;

COPY metas_acao (id, descricao, situacao_id, acao_id, objetivo_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin WITH DELIMITER AS '\t';
10	Definição de 81 apoiadores	1	40	\N	2009-09-18 19:00:15.840866	2	2009-09-18 19:00:15.840866	2
11	Distribuição dos 81 gerenciadores pelos 64 Colegiados de Gestão Regional\n( CGR)	1	40	\N	2009-09-18 19:00:29.618838	2	2009-09-18 19:00:29.618838	2
12	Participação dos gestores municipais e técnicos da SES	1	42	\N	2009-09-18 19:11:12.732912	2	2009-09-18 19:11:12.732912	2
13	met1	1	43	\N	2009-09-24 23:38:24.9785	2	2009-09-24 23:38:24.9785	2
14	meta com objetivo	1	43	127	2009-10-08 00:02:00.597537	2	2009-10-08 00:02:00.597537	2
15	dfasdf	1	43	129	2009-10-08 00:02:31.956258	2	2009-10-08 00:02:31.956258	2
\.


ALTER TABLE metas_acao ENABLE TRIGGER ALL;

--
-- TOC entry 1993 (class 0 OID 17115)
-- Dependencies: 1555
-- Data for Name: metas_programa; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE metas_programa DISABLE TRIGGER ALL;

COPY metas_programa (id, descricao, programa_id) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE metas_programa ENABLE TRIGGER ALL;

--
-- TOC entry 1994 (class 0 OID 17123)
-- Dependencies: 1557
-- Data for Name: metas_projeto; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE metas_projeto DISABLE TRIGGER ALL;

COPY metas_projeto (id, descricao, projeto_id) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE metas_projeto ENABLE TRIGGER ALL;

--
-- TOC entry 2006 (class 0 OID 17568)
-- Dependencies: 1584
-- Data for Name: objetivos_acao; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE objetivos_acao DISABLE TRIGGER ALL;

COPY objetivos_acao (id, descricao, situacao_id, acao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin WITH DELIMITER AS '\t';
123	Apoiar o desenvolvimento da capacidade de gestão da AB junto aos municípios menores de 100 mil hab.	1	40	2009-09-18 18:58:39.878029	2	2009-09-18 18:58:39.878029	2
124	Ampliar propostas e ações para o Fortalecimento da Atenção Básica no Estado de São Paulo	1	42	2009-09-18 19:10:36.019038	2	2009-09-18 19:10:36.019038	2
125	segundo	1	40	2009-09-20 18:19:53.690036	2	2009-09-20 18:19:53.690036	2
126	terceiro objetivo	1	40	2009-09-20 18:20:15.401195	2	2009-09-20 18:20:15.401195	2
127	obj1	1	43	2009-09-24 23:38:13.65449	2	2009-09-24 23:38:13.65449	2
128	xxx	1	40	2009-09-24 23:39:58.626125	2	2009-09-24 23:39:58.626125	2
129	mais um objetivo	1	43	2009-10-08 00:01:32.916018	2	2009-10-08 00:01:32.916018	2
130	objetivo 1	1	44	2009-10-08 00:22:58.396113	2	2009-10-08 00:22:58.396113	2
\.


ALTER TABLE objetivos_acao ENABLE TRIGGER ALL;

--
-- TOC entry 1995 (class 0 OID 17139)
-- Dependencies: 1559
-- Data for Name: objetivos_programa; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE objetivos_programa DISABLE TRIGGER ALL;

COPY objetivos_programa (id, descricao, programa_id) FROM stdin WITH DELIMITER AS '\t';
1	Buscar o aprimoramento da capacidade de gestão estadual do sistema de saúde, fortalecendo: a atenção básica na coordenação do sistema, o planejamento e a programação baseada em informação e participação.	2
5	obj 1	15
6	objetivo 1	25
7	Objetivo 2	25
\.


ALTER TABLE objetivos_programa ENABLE TRIGGER ALL;

--
-- TOC entry 1996 (class 0 OID 17148)
-- Dependencies: 1561
-- Data for Name: objetivos_projeto; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE objetivos_projeto DISABLE TRIGGER ALL;

COPY objetivos_projeto (id, descricao, projeto_id) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE objetivos_projeto ENABLE TRIGGER ALL;

--
-- TOC entry 1997 (class 0 OID 17156)
-- Dependencies: 1563
-- Data for Name: paginas; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE paginas DISABLE TRIGGER ALL;

COPY paginas (id, descricao, pagina, acao) FROM stdin WITH DELIMITER AS '\t';
1	Pagina principal	index	index
\.


ALTER TABLE paginas ENABLE TRIGGER ALL;

--
-- TOC entry 2009 (class 0 OID 17706)
-- Dependencies: 1590
-- Data for Name: parcerias_acao; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE parcerias_acao DISABLE TRIGGER ALL;

COPY parcerias_acao (id, descricao, situacao_id, acao_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin WITH DELIMITER AS '\t';
3	SES	1	40	2009-10-04 18:33:09.497857	2	2009-10-04 18:33:09.497857	2
4	asdfdsf	1	40	2009-10-04 18:33:18.283535	2	2009-10-04 18:33:18.283535	2
5	adsfadsf	1	40	2009-10-04 18:33:51.708894	2	2009-10-04 18:33:51.708894	2
7	p1	1	43	2009-10-08 00:06:47.387729	2	2009-10-08 00:06:47.387729	2
\.


ALTER TABLE parcerias_acao ENABLE TRIGGER ALL;

--
-- TOC entry 1998 (class 0 OID 17173)
-- Dependencies: 1566
-- Data for Name: programas; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE programas DISABLE TRIGGER ALL;

COPY programas (id, descricao, interfaces, situacao_id, responsavel_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id, menu) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE programas ENABLE TRIGGER ALL;

--
-- TOC entry 1999 (class 0 OID 17185)
-- Dependencies: 1568
-- Data for Name: projetos; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE projetos DISABLE TRIGGER ALL;

COPY projetos (id, descricao, interfaces, situacao_id, programa_id, responsavel_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id, menu, projeto_id) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE projetos ENABLE TRIGGER ALL;

--
-- TOC entry 2000 (class 0 OID 17196)
-- Dependencies: 1570
-- Data for Name: recursos; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE recursos DISABLE TRIGGER ALL;

COPY recursos (id, fonte, valor, destino, situacao, meta_id, inclusao_data, inclusao_usuario_id, alteracao_data, alteracao_usuario_id) FROM stdin WITH DELIMITER AS '\t';
\.


ALTER TABLE recursos ENABLE TRIGGER ALL;

--
-- TOC entry 2001 (class 0 OID 17203)
-- Dependencies: 1572
-- Data for Name: situacoes; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE situacoes DISABLE TRIGGER ALL;

COPY situacoes (id, descricao) FROM stdin WITH DELIMITER AS '\t';
1	Ativo
2	Inativo
\.


ALTER TABLE situacoes ENABLE TRIGGER ALL;

--
-- TOC entry 2002 (class 0 OID 17208)
-- Dependencies: 1574
-- Data for Name: tipos_periodo; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE tipos_periodo DISABLE TRIGGER ALL;

COPY tipos_periodo (id, periodo, descricao) FROM stdin WITH DELIMITER AS '\t';
2	mensal	Indicador carregado mensalmente
3	anual	Indicador carregado anualmente
4	anualizado	Indicador anualizado tendo como base o último mês de referência
5	manual	Indicador informado manualmente
\.


ALTER TABLE tipos_periodo ENABLE TRIGGER ALL;

--
-- TOC entry 2003 (class 0 OID 17218)
-- Dependencies: 1577
-- Data for Name: usuarios; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE usuarios DISABLE TRIGGER ALL;

COPY usuarios (id, nome, username, password, email, situacao, salt) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE usuarios ENABLE TRIGGER ALL;

--
-- TOC entry 2004 (class 0 OID 17226)
-- Dependencies: 1578
-- Data for Name: usuarios_grupos; Type: TABLE DATA; Schema: public; Owner: planejamento
--

ALTER TABLE usuarios_grupos DISABLE TRIGGER ALL;

COPY usuarios_grupos (id, usuario_id, grupo_id) FROM stdin WITH DELIMITER AS '\t';
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


ALTER TABLE usuarios_grupos ENABLE TRIGGER ALL;

-- Completed on 2009-10-18 17:02:30 BRST

--
-- PostgreSQL database dump complete
--

