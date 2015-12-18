CREATE TABLE {{dbpref}}_modules (
    id integer NOT NULL,
    modkey character varying(512) NOT NULL,
    version character varying(64) NOT NULL,
    status smallint NOT NULL
);

CREATE SEQUENCE {{dbpref}}_modules_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE {{dbpref}}_modules_id_seq OWNED BY {{dbpref}}_modules.id;

ALTER TABLE ONLY {{dbpref}}_modules ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_modules_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_modules ADD CONSTRAINT {{dbpref}}_modules_id PRIMARY KEY (id);