CREATE TABLE public.funzione (
    id SERIAL PRIMARY KEY,
    funzione character varying(256) NOT NULL,
    descrizione text
);

CREATE TABLE public.luogo (
    id SERIAL PRIMARY KEY,
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

CREATE TABLE public.ruolo (
    id SERIAL PRIMARY KEY,
    ruolo character varying NOT NULL,
    descrizione text
);

CREATE TABLE public.utente (
    id character varying(256) PRIMARY KEY,
    nome character varying(256) NOT NULL,
    cognome character varying(256) NOT NULL,
    ruolo character varying(256) DEFAULT 'schedatore'::character varying NOT NULL
);

CREATE TABLE public.evento (
    id SERIAL PRIMARY KEY,
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
    storia text,
	CONSTRAINT fk_bene1
		FOREIGN KEY(bene1)
			REFERENCES luogo(id),
	CONSTRAINT fk_ruolo_bene1
		FOREIGN KEY(ruolo_bene1)
			REFERENCES ruolo(id),
	CONSTRAINT fk_bene2
		FOREIGN KEY(bene2)
			REFERENCES luogo(id),
	CONSTRAINT fk_ruolo_bene2
		FOREIGN KEY(ruolo_bene2)
			REFERENCES ruolo(id),
    CONSTRAINT fk_funzione
        FOREIGN KEY(funzione)
            REFERENCES funzione(id)
);

INSERT INTO public.funzione (funzione, descrizione, id) VALUES
	('dipende da', NULL, 1),
	('sconsacrato/a', NULL, 2);


INSERT INTO public.ruolo (id, ruolo, descrizione) VALUES
	(1, 'chiesa', NULL),
	(2, 'convento', NULL),
	(3, 'parrocchia', NULL);


INSERT INTO public.utente (id, nome, cognome, ruolo) VALUES
	('acignoni', 'Alessandro', 'Cignoni', 'revisore');
