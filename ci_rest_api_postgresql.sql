--
-- PostgreSQL database dump
--

-- Dumped from database version 13.4
-- Dumped by pg_dump version 13.4

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
-- Name: id_books_seq; Type: SEQUENCE; Schema: public; Owner: andabral
--

CREATE SEQUENCE public.id_books_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_books_seq OWNER TO andabral;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: books; Type: TABLE; Schema: public; Owner: andabral
--

CREATE TABLE public.books (
    id integer DEFAULT nextval('public.id_books_seq'::regclass) NOT NULL,
    title character varying(255) NOT NULL,
    author character varying(255) NOT NULL,
    created_at timestamp without time zone DEFAULT LOCALTIMESTAMP(0) NOT NULL,
    updated_at timestamp without time zone DEFAULT LOCALTIMESTAMP(0) NOT NULL
);


ALTER TABLE public.books OWNER TO andabral;

--
-- Name: id_users_authentication_seq; Type: SEQUENCE; Schema: public; Owner: andabral
--

CREATE SEQUENCE public.id_users_authentication_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.id_users_authentication_seq OWNER TO andabral;

--
-- Name: users; Type: TABLE; Schema: public; Owner: andabral
--

CREATE TABLE public.users (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    last_login timestamp without time zone NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE public.users OWNER TO andabral;

--
-- Name: users_authentication; Type: TABLE; Schema: public; Owner: andabral
--

CREATE TABLE public.users_authentication (
    id integer DEFAULT nextval('public.id_users_authentication_seq'::regclass) NOT NULL,
    users_id integer NOT NULL,
    token character varying(255) NOT NULL,
    estado smallint DEFAULT 1 NOT NULL,
    expired_at timestamp without time zone NOT NULL,
    created_at timestamp without time zone DEFAULT LOCALTIMESTAMP(0) NOT NULL,
    updated_at timestamp without time zone DEFAULT LOCALTIMESTAMP(0) NOT NULL
);


ALTER TABLE public.users_authentication OWNER TO andabral;

--
-- Data for Name: books; Type: TABLE DATA; Schema: public; Owner: andabral
--

INSERT INTO public.books VALUES (1, 'Mami', 'Admin123$', '2023-05-06 20:17:00', '2023-05-06 20:17:00');


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: andabral
--

INSERT INTO public.users VALUES (1, 'admin', '$1$Dtqyvz7/$wZSaZbfHgn0UbLlVi1HHp0', 'Admin', '2023-05-06 20:12:45', '2015-12-25 10:35:16', '2015-12-25 10:35:16');


--
-- Data for Name: users_authentication; Type: TABLE DATA; Schema: public; Owner: andabral
--

INSERT INTO public.users_authentication VALUES (4, 1, '$5$rounds=5000$fragatausesystri$QOhYJQH1JbJDXY4uzQl4q8mWfv1/VIGNV46wV3ysfJ4', 1, '2023-05-07 08:17:00', '2023-05-06 20:12:45', '2023-05-06 20:17:00');


--
-- Name: id_books_seq; Type: SEQUENCE SET; Schema: public; Owner: andabral
--

SELECT pg_catalog.setval('public.id_books_seq', 1, true);


--
-- Name: id_users_authentication_seq; Type: SEQUENCE SET; Schema: public; Owner: andabral
--

SELECT pg_catalog.setval('public.id_users_authentication_seq', 4, true);


--
-- Name: users_authentication _copy_1; Type: CONSTRAINT; Schema: public; Owner: andabral
--

ALTER TABLE ONLY public.users_authentication
    ADD CONSTRAINT _copy_1 PRIMARY KEY (id);


--
-- Name: users _copy_2; Type: CONSTRAINT; Schema: public; Owner: andabral
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT _copy_2 PRIMARY KEY (id);


--
-- Name: books books_pkey; Type: CONSTRAINT; Schema: public; Owner: andabral
--

ALTER TABLE ONLY public.books
    ADD CONSTRAINT books_pkey PRIMARY KEY (id);


--
-- Name: username; Type: INDEX; Schema: public; Owner: andabral
--

CREATE UNIQUE INDEX username ON public.users USING btree (username);


--
-- Name: users_authentication fk_users_authentication_users_1; Type: FK CONSTRAINT; Schema: public; Owner: andabral
--

ALTER TABLE ONLY public.users_authentication
    ADD CONSTRAINT fk_users_authentication_users_1 FOREIGN KEY (users_id) REFERENCES public.users(id);


--
-- PostgreSQL database dump complete
--

