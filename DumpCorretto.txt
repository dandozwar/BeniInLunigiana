--
-- PostgreSQL database dump
--

-- Dumped from database version 14.2
-- Dumped by pg_dump version 14.2

-- Started on 2023-02-20 12:21:11

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
-- TOC entry 7 (class 2615 OID 16395)
-- Name: topology; Type: SCHEMA; Schema: -; Owner: postgres
--

CREATE SCHEMA topology;


ALTER SCHEMA topology OWNER TO postgres;

--
-- TOC entry 4388 (class 0 OID 0)
-- Dependencies: 7
-- Name: SCHEMA topology; Type: COMMENT; Schema: -; Owner: postgres
--

COMMENT ON SCHEMA topology IS 'PostGIS Topology schema';


--
-- TOC entry 2 (class 3079 OID 16396)
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- TOC entry 4389 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry and geography spatial types and functions';


--
-- TOC entry 3 (class 3079 OID 17427)
-- Name: postgis_topology; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis_topology WITH SCHEMA topology;


--
-- TOC entry 4390 (class 0 OID 0)
-- Dependencies: 3
-- Name: EXTENSION postgis_topology; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION postgis_topology IS 'PostGIS topology spatial types and functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 223 (class 1259 OID 17587)
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
-- TOC entry 228 (class 1259 OID 17665)
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
-- TOC entry 224 (class 1259 OID 17592)
-- Name: funzione; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.funzione (
    funzione character varying(256) NOT NULL,
    descrizione text,
    id integer NOT NULL
);


ALTER TABLE public.funzione OWNER TO postgres;

--
-- TOC entry 229 (class 1259 OID 17666)
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
-- TOC entry 225 (class 1259 OID 17597)
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
-- TOC entry 230 (class 1259 OID 17667)
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
-- TOC entry 226 (class 1259 OID 17602)
-- Name: ruolo; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ruolo (
    id integer NOT NULL,
    ruolo character varying NOT NULL,
    descrizione text
);


ALTER TABLE public.ruolo OWNER TO postgres;

--
-- TOC entry 231 (class 1259 OID 17668)
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
-- TOC entry 227 (class 1259 OID 17607)
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
-- TOC entry 4374 (class 0 OID 17587)
-- Dependencies: 223
-- Data for Name: evento; Type: TABLE DATA; Schema: public; Owner: postgres
--


--
-- TOC entry 4375 (class 0 OID 17592)
-- Dependencies: 224
-- Data for Name: funzione; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4376 (class 0 OID 17597)
-- Dependencies: 225
-- Data for Name: luogo; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4377 (class 0 OID 17602)
-- Dependencies: 226
-- Data for Name: ruolo; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4195 (class 0 OID 16706)
-- Dependencies: 213
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4378 (class 0 OID 17607)
-- Dependencies: 227
-- Data for Name: utente; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 4196 (class 0 OID 17429)
-- Dependencies: 218
-- Data for Name: topology; Type: TABLE DATA; Schema: topology; Owner: postgres
--



--
-- TOC entry 4197 (class 0 OID 17441)
-- Dependencies: 219
-- Data for Name: layer; Type: TABLE DATA; Schema: topology; Owner: postgres
--



--
-- TOC entry 4391 (class 0 OID 0)
-- Dependencies: 228
-- Name: evento_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.evento_id_seq', 11, true);


--
-- TOC entry 4392 (class 0 OID 0)
-- Dependencies: 229
-- Name: funzione_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.funzione_id_seq', 2, true);


--
-- TOC entry 4393 (class 0 OID 0)
-- Dependencies: 230
-- Name: luogo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.luogo_id_seq', 18, true);


--
-- TOC entry 4394 (class 0 OID 0)
-- Dependencies: 231
-- Name: ruolo_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.ruolo_id_seq', 3, true);


--
-- TOC entry 4214 (class 2606 OID 17614)
-- Name: evento Eventi_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT "Eventi_pkey" PRIMARY KEY (id);


--
-- TOC entry 4218 (class 2606 OID 17616)
-- Name: luogo Luogo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.luogo
    ADD CONSTRAINT "Luogo_pkey" PRIMARY KEY (id);


--
-- TOC entry 4216 (class 2606 OID 17618)
-- Name: funzione funzione_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.funzione
    ADD CONSTRAINT funzione_pkey PRIMARY KEY (id);


--
-- TOC entry 4220 (class 2606 OID 17620)
-- Name: ruolo ruolo_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ruolo
    ADD CONSTRAINT ruolo_pkey PRIMARY KEY (id);


--
-- TOC entry 4222 (class 2606 OID 17622)
-- Name: utente utente_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.utente
    ADD CONSTRAINT utente_pkey PRIMARY KEY (id);


--
-- TOC entry 4223 (class 2606 OID 17623)
-- Name: evento fk_bene1_luogo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_bene1_luogo FOREIGN KEY (bene1) REFERENCES public.luogo(id) NOT VALID;


--
-- TOC entry 4224 (class 2606 OID 17628)
-- Name: evento fk_bene2_luogo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_bene2_luogo FOREIGN KEY (bene2) REFERENCES public.luogo(id) NOT VALID;


--
-- TOC entry 4225 (class 2606 OID 17633)
-- Name: evento fk_funzione_funzione; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_funzione_funzione FOREIGN KEY (funzione) REFERENCES public.funzione(id) NOT VALID;


--
-- TOC entry 4226 (class 2606 OID 17638)
-- Name: evento fk_ruolo1_ruolo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_ruolo1_ruolo FOREIGN KEY (ruolo_bene1) REFERENCES public.ruolo(id) NOT VALID;


--
-- TOC entry 4227 (class 2606 OID 17643)
-- Name: evento fk_ruolo2_ruolo; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_ruolo2_ruolo FOREIGN KEY (ruolo_bene2) REFERENCES public.ruolo(id) NOT VALID;


--
-- TOC entry 4228 (class 2606 OID 17648)
-- Name: evento fk_schedatore_utente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.evento
    ADD CONSTRAINT fk_schedatore_utente FOREIGN KEY (schedatore) REFERENCES public.utente(id) NOT VALID;


--
-- TOC entry 4229 (class 2606 OID 17653)
-- Name: luogo fk_schedatore_utente; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.luogo
    ADD CONSTRAINT fk_schedatore_utente FOREIGN KEY (schedatore) REFERENCES public.utente(id) NOT VALID;


-- Completed on 2023-02-20 12:21:12

--
-- PostgreSQL database dump complete
--

