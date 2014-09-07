--
-- PostgreSQL database dump
--

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- Name: first_accum(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION first_accum(text, text) RETURNS text
    LANGUAGE sql
    AS $_$select coalesce($1,$2)$_$;


ALTER FUNCTION public.first_accum(text, text) OWNER TO postgres;

--
-- Name: first_accum(boolean, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION first_accum(boolean, boolean) RETURNS boolean
    LANGUAGE sql
    AS $_$select coalesce($1,$2)$_$;


ALTER FUNCTION public.first_accum(boolean, boolean) OWNER TO postgres;

--
-- Name: first_accum(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION first_accum(integer, integer) RETURNS integer
    LANGUAGE sql
    AS $_$select coalesce($1,$2)$_$;


ALTER FUNCTION public.first_accum(integer, integer) OWNER TO postgres;

--
-- Name: first_accum(double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION first_accum(double precision, double precision) RETURNS double precision
    LANGUAGE sql
    AS $_$select coalesce($1,$2)$_$;


ALTER FUNCTION public.first_accum(double precision, double precision) OWNER TO postgres;

--
-- Name: last_accum(text, text); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION last_accum(text, text) RETURNS text
    LANGUAGE sql
    AS $_$select $2$_$;


ALTER FUNCTION public.last_accum(text, text) OWNER TO postgres;

--
-- Name: last_accum(boolean, boolean); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION last_accum(boolean, boolean) RETURNS boolean
    LANGUAGE sql
    AS $_$select $2$_$;


ALTER FUNCTION public.last_accum(boolean, boolean) OWNER TO postgres;

--
-- Name: last_accum(integer, integer); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION last_accum(integer, integer) RETURNS integer
    LANGUAGE sql
    AS $_$select $2$_$;


ALTER FUNCTION public.last_accum(integer, integer) OWNER TO postgres;

--
-- Name: last_accum(double precision, double precision); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION last_accum(double precision, double precision) RETURNS double precision
    LANGUAGE sql
    AS $_$select $2$_$;


ALTER FUNCTION public.last_accum(double precision, double precision) OWNER TO postgres;

--
-- Name: first(text); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE first(text) (
    SFUNC = public.first_accum,
    STYPE = text
);


ALTER AGGREGATE public.first(text) OWNER TO postgres;

--
-- Name: first(boolean); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE first(boolean) (
    SFUNC = public.first_accum,
    STYPE = boolean
);


ALTER AGGREGATE public.first(boolean) OWNER TO postgres;

--
-- Name: first(integer); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE first(integer) (
    SFUNC = public.first_accum,
    STYPE = integer
);


ALTER AGGREGATE public.first(integer) OWNER TO postgres;

--
-- Name: first(double precision); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE first(double precision) (
    SFUNC = public.first_accum,
    STYPE = double precision
);


ALTER AGGREGATE public.first(double precision) OWNER TO postgres;

--
-- Name: last(text); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE last(text) (
    SFUNC = public.last_accum,
    STYPE = text
);


ALTER AGGREGATE public.last(text) OWNER TO postgres;

--
-- Name: last(boolean); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE last(boolean) (
    SFUNC = public.last_accum,
    STYPE = boolean
);


ALTER AGGREGATE public.last(boolean) OWNER TO postgres;

--
-- Name: last(integer); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE last(integer) (
    SFUNC = public.last_accum,
    STYPE = integer
);


ALTER AGGREGATE public.last(integer) OWNER TO postgres;

--
-- Name: last(double precision); Type: AGGREGATE; Schema: public; Owner: postgres
--

CREATE AGGREGATE last(double precision) (
    SFUNC = public.last_accum,
    STYPE = double precision
);


ALTER AGGREGATE public.last(double precision) OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: cms_acls; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_acls (
    acl_id bigint NOT NULL,
    acl_aro_id bigint DEFAULT 0,
    acl_aro_type smallint DEFAULT 0,
    acl_aco_id bigint DEFAULT 0,
    acl_aco_type smallint DEFAULT 0,
    acl_action smallint DEFAULT 0,
    acl_allowed boolean
);


ALTER TABLE public.cms_acls OWNER TO postgres;

--
-- Name: acls_acl_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE acls_acl_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.acls_acl_id_seq OWNER TO postgres;

--
-- Name: acls_acl_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE acls_acl_id_seq OWNED BY cms_acls.acl_id;


--
-- Name: art_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE art_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.art_id_seq OWNER TO postgres;

--
-- Name: cms_abtests; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_abtests (
    abt_id bigint NOT NULL,
    abt_name character varying(256) DEFAULT ''::character varying,
    abt_lang character varying(7),
    abt_uri text DEFAULT ''::text NOT NULL,
    abt_site_id smallint DEFAULT 0 NOT NULL,
    abt_page_id bigint NOT NULL,
    abt_parameter text DEFAULT ''::text
);


ALTER TABLE public.cms_abtests OWNER TO postgres;

--
-- Name: cms_abtests_abt_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cms_abtests_abt_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cms_abtests_abt_id_seq OWNER TO postgres;

--
-- Name: cms_abtests_abt_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cms_abtests_abt_id_seq OWNED BY cms_abtests.abt_id;


--
-- Name: cms_aro_groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_aro_groups (
    acl_aro_id bigint NOT NULL,
    acl_aro_type smallint DEFAULT 0 NOT NULL,
    grp_id bigint NOT NULL
);


ALTER TABLE public.cms_aro_groups OWNER TO postgres;

--
-- Name: cms_articles; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_articles (
    art_id bigint DEFAULT nextval('art_id_seq'::regclass) NOT NULL,
    art_title text,
    art_content text,
    art_parameter character varying(128)
);


ALTER TABLE public.cms_articles OWNER TO postgres;

--
-- Name: cms_clickpics; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_clickpics (
    ckp_cpt_id bigint NOT NULL,
    ckp_lang character varying(128) NOT NULL,
    ckp_picture_url character varying(128) NOT NULL,
    ckp_link_url character varying(128) NOT NULL
);


ALTER TABLE public.cms_clickpics OWNER TO postgres;

--
-- Name: cpt_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cpt_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cpt_id_seq OWNER TO postgres;

--
-- Name: cms_components; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_components (
    cpt_id bigint DEFAULT nextval('cpt_id_seq'::regclass) NOT NULL,
    cpt_site_id smallint NOT NULL,
    cpt_name character varying(256),
    cpt_role character varying(256),
    cpt_class character varying(256),
    cpt_substitute_id bigint,
    cpt_supported_langs character varying(256),
    cpt_parameter text,
    cpt_type character varying(256)
);


ALTER TABLE public.cms_components OWNER TO postgres;

--
-- Name: cms_contexts; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_contexts (
    ctx_id bigint NOT NULL,
    ctx_component_id bigint NOT NULL,
    ctx_zone character varying(128) NOT NULL,
    ctx_order smallint DEFAULT 0 NOT NULL,
    ctx_class character varying(32)
);


ALTER TABLE public.cms_contexts OWNER TO postgres;

--
-- Name: dom_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE dom_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.dom_id_seq OWNER TO postgres;

--
-- Name: cms_domains; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_domains (
    dom_id smallint DEFAULT nextval('dom_id_seq'::regclass) NOT NULL,
    dom_mnem character varying(128) NOT NULL,
    dom_base character varying(128) NOT NULL,
    dom_languages character varying(64) NOT NULL,
    dom_site_id smallint DEFAULT 0 NOT NULL,
    dom_root character varying(256)
);


ALTER TABLE public.cms_domains OWNER TO postgres;

--
-- Name: cms_google_adwords; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_google_adwords (
    gaw_id bigint NOT NULL,
    gaw_page_id bigint NOT NULL,
    gaw_parameter character varying(256) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.cms_google_adwords OWNER TO postgres;

--
-- Name: cms_google_adwords_gaw_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cms_google_adwords_gaw_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cms_google_adwords_gaw_id_seq OWNER TO postgres;

--
-- Name: cms_google_adwords_gaw_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE cms_google_adwords_gaw_id_seq OWNED BY cms_google_adwords.gaw_id;


--
-- Name: cms_googleanalytics; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_googleanalytics (
    gaq_cpt_id bigint NOT NULL,
    gaq_lang character varying(128) NOT NULL,
    gaq_category character varying(128) NOT NULL,
    gaq_action character varying(128) NOT NULL,
    gaq_label character varying(128) NOT NULL,
    gaq_value character varying(128) NOT NULL
);


ALTER TABLE public.cms_googleanalytics OWNER TO postgres;

--
-- Name: cms_groups; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_groups (
    grp_id bigint NOT NULL,
    grp_bound_left integer,
    grp_bound_right integer,
    grp_name character varying(64) NOT NULL
);


ALTER TABLE public.cms_groups OWNER TO postgres;

--
-- Name: cms_htmlblocks; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_htmlblocks (
    hbk_cpt_id bigint NOT NULL,
    hbk_lang character varying(128) NOT NULL,
    hbk_title character varying(128) NOT NULL,
    hbk_content text
);


ALTER TABLE public.cms_htmlblocks OWNER TO postgres;

--
-- Name: lay_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE lay_id_seq
    START WITH 8
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.lay_id_seq OWNER TO postgres;

--
-- Name: cms_layouts; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_layouts (
    lay_id bigint DEFAULT nextval('lay_id_seq'::regclass) NOT NULL,
    lay_site_id smallint NOT NULL,
    lay_name character varying(256),
    lay_type character varying(64) DEFAULT 'page'::character varying
);


ALTER TABLE public.cms_layouts OWNER TO postgres;

--
-- Name: cms_multiclickpics; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_multiclickpics (
    mcp_id bigint NOT NULL,
    mcp_cpt_id bigint,
    mcp_lang character varying(128),
    mcp_picture_url character varying(128) NOT NULL,
    mcp_link_url character varying(128) NOT NULL
);


ALTER TABLE public.cms_multiclickpics OWNER TO postgres;

--
-- Name: pge_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE pge_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.pge_id_seq OWNER TO postgres;

--
-- Name: cms_pages; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_pages (
    pge_id bigint DEFAULT nextval('pge_id_seq'::regclass) NOT NULL,
    pge_site_id smallint DEFAULT 0 NOT NULL,
    pge_lang character varying(7),
    pge_uri text,
    pge_uri_part text DEFAULT ''::text,
    pge_ctrl_properties character varying(256),
    pge_context_id bigint,
    pge_content_id bigint,
    pge_group bigint DEFAULT 0,
    pge_parent_group bigint DEFAULT 0,
    pge_title character varying(256),
    pge_order smallint DEFAULT 0 NOT NULL,
    pge_status smallint DEFAULT 0 NOT NULL,
    pge_publish_date timestamp without time zone DEFAULT now(),
    pge_description text,
    pge_keywords text,
    pge_robots character varying(17),
    pge_controller character varying(256),
    pge_type character varying(256),
    pge_meta_title character varying(256) DEFAULT ''::character varying,
    pge_short_title character varying(256) DEFAULT ''::character varying,
    pge_menu boolean DEFAULT false
);


ALTER TABLE public.cms_pages OWNER TO postgres;

--
-- Name: cms_pge_group_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE cms_pge_group_seq
    START WITH 4
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.cms_pge_group_seq OWNER TO postgres;

--
-- Name: cms_sites; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_sites (
    sit_id smallint NOT NULL,
    sit_name character varying(256) DEFAULT ''::character varying NOT NULL
);


ALTER TABLE public.cms_sites OWNER TO postgres;

--
-- Name: cms_strings; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_strings (
    str_site_id smallint NOT NULL,
    str_name character varying(64) NOT NULL,
    str_lang character varying(7) NOT NULL,
    str_value text
);


ALTER TABLE public.cms_strings OWNER TO postgres;

--
-- Name: cms_users; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE cms_users (
    usr_id bigint NOT NULL,
    usr_first_name character varying(128) NOT NULL,
    usr_last_name character varying(128) NOT NULL,
    usr_login character varying(128) NOT NULL,
    usr_email character varying(128) NOT NULL,
    usr_password character varying(64) NOT NULL,
    usr_profile character varying(16)
);


ALTER TABLE public.cms_users OWNER TO postgres;

--
-- Name: ctx_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE ctx_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.ctx_id_seq OWNER TO postgres;

--
-- Name: groups_grp_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE groups_grp_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.groups_grp_id_seq OWNER TO postgres;

--
-- Name: groups_grp_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE groups_grp_id_seq OWNED BY cms_groups.grp_id;


--
-- Name: multiclickpics_mcp_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE multiclickpics_mcp_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.multiclickpics_mcp_id_seq OWNER TO postgres;

--
-- Name: multiclickpics_mcp_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE multiclickpics_mcp_id_seq OWNED BY cms_multiclickpics.mcp_id;


--
-- Name: users_usr_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE users_usr_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_usr_id_seq OWNER TO postgres;

--
-- Name: users_usr_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE users_usr_id_seq OWNED BY cms_users.usr_id;


--
-- Name: abt_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE cms_abtests ALTER COLUMN abt_id SET DEFAULT nextval('cms_abtests_abt_id_seq'::regclass);


--
-- Name: acl_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE cms_acls ALTER COLUMN acl_id SET DEFAULT nextval('acls_acl_id_seq'::regclass);


--
-- Name: gaw_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE cms_google_adwords ALTER COLUMN gaw_id SET DEFAULT nextval('cms_google_adwords_gaw_id_seq'::regclass);


--
-- Name: grp_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE cms_groups ALTER COLUMN grp_id SET DEFAULT nextval('groups_grp_id_seq'::regclass);


--
-- Name: mcp_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE cms_multiclickpics ALTER COLUMN mcp_id SET DEFAULT nextval('multiclickpics_mcp_id_seq'::regclass);


--
-- Name: usr_id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE cms_users ALTER COLUMN usr_id SET DEFAULT nextval('users_usr_id_seq'::regclass);


--
-- Name: acls_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_acls
    ADD CONSTRAINT acls_pkey PRIMARY KEY (acl_id);


--
-- Name: aro_groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_aro_groups
    ADD CONSTRAINT aro_groups_pkey PRIMARY KEY (acl_aro_id, acl_aro_type, grp_id);


--
-- Name: articles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_articles
    ADD CONSTRAINT articles_pkey PRIMARY KEY (art_id);


--
-- Name: clickpics_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_clickpics
    ADD CONSTRAINT clickpics_pkey PRIMARY KEY (ckp_cpt_id, ckp_lang);


--
-- Name: cms_abtests_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_abtests
    ADD CONSTRAINT cms_abtests_pkey PRIMARY KEY (abt_id);


--
-- Name: cms_google_adwords_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_google_adwords
    ADD CONSTRAINT cms_google_adwords_pkey PRIMARY KEY (gaw_id);


--
-- Name: cms_sites_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_sites
    ADD CONSTRAINT cms_sites_pkey PRIMARY KEY (sit_id);


--
-- Name: components_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_components
    ADD CONSTRAINT components_pkey PRIMARY KEY (cpt_id);


--
-- Name: contexts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_contexts
    ADD CONSTRAINT contexts_pkey PRIMARY KEY (ctx_id, ctx_component_id, ctx_zone, ctx_order);


--
-- Name: googleanalytics_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_googleanalytics
    ADD CONSTRAINT googleanalytics_pkey PRIMARY KEY (gaq_cpt_id, gaq_lang);


--
-- Name: groups_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_groups
    ADD CONSTRAINT groups_pkey PRIMARY KEY (grp_id);


--
-- Name: htmlblocks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_htmlblocks
    ADD CONSTRAINT htmlblocks_pkey PRIMARY KEY (hbk_cpt_id, hbk_lang);


--
-- Name: layouts_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_layouts
    ADD CONSTRAINT layouts_pkey PRIMARY KEY (lay_id);


--
-- Name: multiclickpics_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_multiclickpics
    ADD CONSTRAINT multiclickpics_pkey PRIMARY KEY (mcp_id);


--
-- Name: pages_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (pge_id);


--
-- Name: strings_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_strings
    ADD CONSTRAINT strings_pkey PRIMARY KEY (str_site_id, str_name, str_lang);


--
-- Name: users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_users
    ADD CONSTRAINT users_pkey PRIMARY KEY (usr_id);


--
-- Name: websites_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY cms_domains
    ADD CONSTRAINT websites_pkey PRIMARY KEY (dom_id);


--
-- Name: acls_aco_id_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX acls_aco_id_idx ON cms_acls USING btree (acl_aco_id);


--
-- Name: acls_action_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX acls_action_idx ON cms_acls USING btree (acl_action);


--
-- Name: acls_aro_id_idx; Type: INDEX; Schema: public; Owner: postgres; Tablespace: 
--

CREATE INDEX acls_aro_id_idx ON cms_acls USING btree (acl_aro_id);


--
-- Name: aro_groups_grp_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_aro_groups
    ADD CONSTRAINT aro_groups_grp_id_fkey FOREIGN KEY (grp_id) REFERENCES cms_groups(grp_id);


--
-- Name: clickpics_ckp_cpt_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_clickpics
    ADD CONSTRAINT clickpics_ckp_cpt_id_fkey FOREIGN KEY (ckp_cpt_id) REFERENCES cms_components(cpt_id);


--
-- Name: cms_abtests_abt_page_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_abtests
    ADD CONSTRAINT cms_abtests_abt_page_id_fkey FOREIGN KEY (abt_page_id) REFERENCES cms_pages(pge_id);


--
-- Name: cms_components_cpt_site_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_components
    ADD CONSTRAINT cms_components_cpt_site_id_fkey FOREIGN KEY (cpt_site_id) REFERENCES cms_sites(sit_id);


--
-- Name: cms_domains_dom_site_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_domains
    ADD CONSTRAINT cms_domains_dom_site_id_fkey FOREIGN KEY (dom_site_id) REFERENCES cms_sites(sit_id);


--
-- Name: cms_google_adwords_gaw_page_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_google_adwords
    ADD CONSTRAINT cms_google_adwords_gaw_page_id_fkey FOREIGN KEY (gaw_page_id) REFERENCES cms_pages(pge_id);


--
-- Name: cms_layouts_lay_site_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_layouts
    ADD CONSTRAINT cms_layouts_lay_site_id_fkey FOREIGN KEY (lay_site_id) REFERENCES cms_sites(sit_id);


--
-- Name: cms_pages_pge_site_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_pages
    ADD CONSTRAINT cms_pages_pge_site_id_fkey FOREIGN KEY (pge_site_id) REFERENCES cms_sites(sit_id);


--
-- Name: cms_strings_str_site_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_strings
    ADD CONSTRAINT cms_strings_str_site_id_fkey FOREIGN KEY (str_site_id) REFERENCES cms_sites(sit_id);


--
-- Name: contexts_ctx_component_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_contexts
    ADD CONSTRAINT contexts_ctx_component_id_fkey FOREIGN KEY (ctx_component_id) REFERENCES cms_components(cpt_id);


--
-- Name: googleanalytics_gaq_cpt_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_googleanalytics
    ADD CONSTRAINT googleanalytics_gaq_cpt_id_fkey FOREIGN KEY (gaq_cpt_id) REFERENCES cms_components(cpt_id);


--
-- Name: htmlblocks_hbk_cpt_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_htmlblocks
    ADD CONSTRAINT htmlblocks_hbk_cpt_id_fkey FOREIGN KEY (hbk_cpt_id) REFERENCES cms_components(cpt_id);


--
-- Name: multiclickpics_mcp_cpt_id_fkey; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY cms_multiclickpics
    ADD CONSTRAINT multiclickpics_mcp_cpt_id_fkey FOREIGN KEY (mcp_cpt_id) REFERENCES cms_components(cpt_id);


--
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--

INSERT INTO cms_users (usr_first_name, usr_last_name, usr_login, usr_email, usr_password, usr_profile) VALUES ('Admin', 'Istrator', 'admin', 'nop@nowhere.com', '372eeffaba2b5b61fb02513ecb84f1ff', 'admin_app');
-- Allow group (aro_type=1) 1 (aro_id) to access app
INSERT INTO cms_acls (acl_aro_id, acl_aro_type, acl_aco_id, acl_aco_type, acl_action, acl_allowed) VALUES (1, 1, 0, 0, 3, true);
-- Allow group (aro_type=1) 2 (aro_id) to access admin
INSERT INTO cms_acls (acl_aro_id, acl_aro_type, acl_aco_id, acl_aco_type, acl_action, acl_allowed) VALUES (2, 1, 0, 0, 1, true);
-- Allow group (aro_type=1) 3 (aro_id) to change site in admin
INSERT INTO cms_acls (acl_aro_id, acl_aro_type, acl_aco_id, acl_aco_type, acl_action, acl_allowed) VALUES (3, 1, 0, 0, 2, true);
INSERT INTO cms_groups (grp_bound_left, grp_bound_right, grp_name) VALUES (1, 6, 'Utilisateurs');
INSERT INTO cms_groups (grp_bound_left, grp_bound_right, grp_name) VALUES (2, 5, 'Administrateurs de site');
INSERT INTO cms_groups (grp_bound_left, grp_bound_right, grp_name) VALUES (3, 4, 'Administrateurs de l''application');
-- Add user 1 in the group "Administrateurs de l'application"
INSERT INTO cms_aro_groups (acl_aro_id, acl_aro_type, grp_id) VALUES (1, 2, 3);

INSERT INTO cms_sites (sit_id, sit_name) VALUES (1, 'default');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'page_article_name', 'fr', 'Article');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'page_redirect_name', 'fr', 'Redirection');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_adsense_name', 'fr', 'Google Ad Sense');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_breadcrumb_name', 'fr', 'Fil d''Ariane');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_clickpic_name', 'fr', 'Clickable Picture');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_galleryblock_name', 'fr', 'Gallerie d''images');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_googleadwords_name', 'fr', 'Google AdWords');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_googleanalytics_name', 'fr', 'Google Analytics');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_googleanalyticseventtracker_name', 'fr', 'Google Analytics Event Tracker');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_htmlblock_name', 'fr', 'Block HTML');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_menu_name', 'fr', 'Menu');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_multiclickpic_name', 'fr', 'Multi Clickable Picture');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_socialnetworks_name', 'fr', 'R&acute;seaux sociaux');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_socialwidget_name', 'fr', 'Widget réseaux sociaux');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_template_name', 'fr', 'Gestionnaire de gabarit');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'component_textblock_name', 'fr', 'Block Texte');

-- Rouge template strings
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_name', 'fr', 'Rouge');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_page_article', 'fr', 'Article');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_class_standard', 'fr', 'Standard');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_head', 'fr', 'En-tête HTML');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_body-begin', 'fr', 'Début de contenu HTML');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_banner', 'fr', 'Bannière');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_menu', 'fr', 'Menu');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_sidebar', 'fr', 'Bar latérale');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_main', 'fr', 'Contenu central');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_footer', 'fr', 'Pied de page');
INSERT INTO cms_strings (str_site_id, str_name, str_lang, str_value) VALUES (1, 'template_rouge_zone_body-end', 'fr', 'Fin de contenu HTML');

INSERT INTO cms_sites (sit_id, sit_name) VALUES (2, 'Zenolithe');
INSERT INTO cms_domains (dom_mnem, dom_base, dom_languages, dom_site_id, dom_root) VALUES ('Zenolithe', 'http://tigrou.lodgis.net/app/', 'fr', 2, '');
INSERT INTO cms_pages (pge_site_id,
    pge_lang,
    pge_uri,
    pge_uri_part,
    pge_ctrl_properties,
    pge_context_id,
    pge_content_id,
    pge_group,
    pge_parent_group,
    pge_title,
    pge_order,
    pge_status,
    pge_publish_date,
    pge_description,
    pge_keywords,
    pge_robots,
    pge_controller,
    pge_type,
    pge_meta_title,
    pge_short_title,
    pge_menu)
  VALUES (2,
    'fr',
    '',
    '',
    '',
    0,
    0,
    1,
    0,
    'Accueil',
    0,
    2,
    now(),
    'Accueil',
    '',
    '',
    'cms/pages.article.view',
    'article',
    'Accueil',
    'Accueil',
    't');
    
INSERT INTO cms_components (cpt_site_id, cpt_name, cpt_role, cpt_class, cpt_substitute_id, cpt_supported_langs, cpt_parameter, cpt_type) VALUES (2, 'Gestionnaire de gabarit', 'interceptor', 'templating', 0, 'all', 'rouge', 'template');
