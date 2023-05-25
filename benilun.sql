--
-- PostgreSQL database dump
--

-- Dumped from database version 14.2
-- Dumped by pg_dump version 14.2

-- Started on 2023-05-24 14:50:13

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 6 (class 2615 OID 25865)
-- Name: topology; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA topology;


ALTER SCHEMA topology OWNER TO postgres;

--
-- TOC entry 4401 (class 0 OID 0)
-- Dependencies: 6
-- Name: SCHEMA topology; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA topology IS 'PostGIS Topology schema';


--
-- TOC entry 2 (class 3079 OID 24815)
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- TOC entry 4402 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry and geography spatial types and functions';


--
-- TOC entry 3 (class 3079 OID 25866)
-- Name: postgis_topology; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis_topology WITH SCHEMA topology;


--
-- TOC entry 4403 (class 0 OID 0)
-- Dependencies: 3
-- Name: EXTENSION postgis_topology; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis_topology IS 'PostGIS topology spatial types and functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 223 (class 1259 OID 26028)
-- Name: evento; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.evento (
    id integer NOT NULL,
    bene1 integer NOT NULL,
    denominazione_bene1 text,
    data_da character varying(256) NOT NULL,
    data_a character varying(256),
    tipo_data character varying(256),
    ruolo_bene1 integer,
    funzione integer,
    bene2 integer,
    denominazione_bene2 text,
    ruolo_bene2 integer,
    bibliografia text,
    schedatore character varying(256) NOT NULL,
    note text,
    stato character varying(4) NOT NULL,
    storia text
);


ALTER TABLE public.evento OWNER TO postgres;

--
-- TOC entry 224 (class 1259 OID 26033)
-- Name: evento_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.evento ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.evento_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 225 (class 1259 OID 26034)
-- Name: funzione; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.funzione (
    funzione character varying(256) NOT NULL,
    descrizione text,
    id integer NOT NULL
);


ALTER TABLE public.funzione OWNER TO postgres;

--
-- TOC entry 226 (class 1259 OID 26039)
-- Name: funzione_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.funzione ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.funzione_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 227 (class 1259 OID 26040)
-- Name: luogo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.luogo (
    id integer NOT NULL,
    identificazione text NOT NULL,
    descrizione text,
    meo character varying(256),
    mec character varying(256),
    toponimo character varying(256),
    esistenza character varying(256),
    comune character varying(256),
    bibliografia text,
    schedatore character varying(256) NOT NULL,
    note text,
    area public.geometry(MultiPolygon,3857) NOT NULL,
    punto public.geometry(Point,3857) NOT NULL,
    stato character varying(4) NOT NULL,
    storia text
);


ALTER TABLE public.luogo OWNER TO postgres;

--
-- TOC entry 228 (class 1259 OID 26045)
-- Name: luogo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.luogo ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.luogo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 229 (class 1259 OID 26046)
-- Name: ruolo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ruolo (
    id integer NOT NULL,
    ruolo character varying NOT NULL,
    descrizione text
);


ALTER TABLE public.ruolo OWNER TO postgres;

--
-- TOC entry 230 (class 1259 OID 26051)
-- Name: ruolo_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

ALTER TABLE public.ruolo ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY (
    SEQUENCE NAME public.ruolo_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1
);


--
-- TOC entry 231 (class 1259 OID 26052)
-- Name: utente; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.utente (
    id character varying(256) NOT NULL,
    nome character varying(256) NOT NULL,
    cognome character varying(256) NOT NULL,
    ruolo character varying(256) DEFAULT 'schedatore'::character varying NOT NULL
);


ALTER TABLE public.utente OWNER TO postgres;

--
-- TOC entry 4387 (class 0 OID 26028)
-- Dependencies: 223
-- Data for Name: evento; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.evento (id, bene1, denominazione_bene1, data_da, data_a, tipo_data, ruolo_bene1, funzione, bene2, denominazione_bene2, ruolo_bene2, bibliografia, schedatore, note, stato, storia) FROM stdin;
\.


--
-- TOC entry 4389 (class 0 OID 26034)
-- Dependencies: 225
-- Data for Name: funzione; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.funzione (funzione, descrizione, id) FROM stdin;
dipende da	\N	1
sconsacrato/a	\N	2
\.


--
-- TOC entry 4391 (class 0 OID 26040)
-- Dependencies: 227
-- Data for Name: luogo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.luogo (id, identificazione, descrizione, meo, mec, toponimo, esistenza, comune, bibliografia, schedatore, note, area, punto, stato, storia) FROM stdin;
\.


--
-- TOC entry 4393 (class 0 OID 26046)
-- Dependencies: 229
-- Data for Name: ruolo; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.ruolo (id, ruolo, descrizione) FROM stdin;
1	chiesa	\N
2	convento	\N
3	parrocchia	\N
\.


--
-- TOC entry 4208 (class 0 OID 25127)
-- Dependencies: 213
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
\.


--
-- TOC entry 4395 (class 0 OID 26052)
-- Dependencies: 231
-- Data for Name: utente; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.utente (id, nome, cognome, ruolo) FROM stdin;
acignoni	Alessandro	Cignoni	revisore
\.


--
-- TOC entry 4209 (class 0 OID 25868)
-- Dependencies: 218
-- Data for Name: topology; Type: TABLE DATA; Schema: topology; Owner: postgres
--

COPY topology.topology (id, name, srid, "precision", hasz) FROM stdin;
\.


--
-- TOC entry 4210 (class 0 OID 25880)
-- Dependencies: 219
-- Data for Name: layer; Type: TABLE DATA; Schema: topology; Owner: postgres
--

COPY topology.layer (topology_id, layer_id, schema_name, table_name, feature_column, feature_type, level, child_id) FROM stdin;
\.


--
-- TOC entry 4404 (class 0 OID 0)
-- Dependencies: 224
-- Name: evento_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evento_id_seq', 11, true);


--
-- TOC entry 4405 (class 0 OID 0)
-- Dependencies: 226
-- Name: funzione_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.funzione_id_seq', 2, true);


--
-- TOC entry 4406 (class 0 OID 0)
-- Dependencies: 228
-- Name: luogo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.luogo_id_seq', 18, true);


--
-- TOC entry 4407 (class 0 OID 0)
-- Dependencies: 230
-- Name: ruolo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ruolo_id_seq', 3, true);


--
-- TOC entry 4227 (class 2606 OID 26059)
-- Name: evento Eventi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT "Eventi_pkey" PRIMARY KEY (id);


--
-- TOC entry 4231 (class 2606 OID 26061)
-- Name: luogo Luogo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.luogo
    ADD CONSTRAINT "Luogo_pkey" PRIMARY KEY (id);


--
-- TOC entry 4229 (class 2606 OID 26063)
-- Name: funzione funzione_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funzione
    ADD CONSTRAINT funzione_pkey PRIMARY KEY (id);


--
-- TOC entry 4233 (class 2606 OID 26065)
-- Name: ruolo ruolo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruolo
    ADD CONSTRAINT ruolo_pkey PRIMARY KEY (id);


--
-- TOC entry 4235 (class 2606 OID 26067)
-- Name: utente utente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utente
    ADD CONSTRAINT utente_pkey PRIMARY KEY (id);


--
-- TOC entry 4236 (class 2606 OID 26068)
-- Name: evento fk_bene1_luogo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_bene1_luogo FOREIGN KEY (bene1) REFERENCES public.luogo(id) NOT VALID;


--
-- TOC entry 4237 (class 2606 OID 26073)
-- Name: evento fk_bene2_luogo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_bene2_luogo FOREIGN KEY (bene2) REFERENCES public.luogo(id) NOT VALID;


--
-- TOC entry 4238 (class 2606 OID 26078)
-- Name: evento fk_funzione_funzione; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_funzione_funzione FOREIGN KEY (funzione) REFERENCES public.funzione(id) NOT VALID;


--
-- TOC entry 4239 (class 2606 OID 26083)
-- Name: evento fk_ruolo1_ruolo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_ruolo1_ruolo FOREIGN KEY (ruolo_bene1) REFERENCES public.ruolo(id) NOT VALID;


--
-- TOC entry 4240 (class 2606 OID 26088)
-- Name: evento fk_ruolo2_ruolo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_ruolo2_ruolo FOREIGN KEY (ruolo_bene2) REFERENCES public.ruolo(id) NOT VALID;


--
-- TOC entry 4241 (class 2606 OID 26093)
-- Name: evento fk_schedatore_utente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_schedatore_utente FOREIGN KEY (schedatore) REFERENCES public.utente(id) NOT VALID;


--
-- TOC entry 4242 (class 2606 OID 26098)
-- Name: luogo fk_schedatore_utente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.luogo
    ADD CONSTRAINT fk_schedatore_utente FOREIGN KEY (schedatore) REFERENCES public.utente(id) NOT VALID;


-- Completed on 2023-05-24 14:50:18

--
-- PostgreSQL database dump complete
--

