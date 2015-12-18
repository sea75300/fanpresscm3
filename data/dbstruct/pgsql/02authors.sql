CREATE TABLE {{dbpref}}_authors (
    id integer NOT NULL,
    username character varying(255) NOT NULL,
    passwd character varying(255) NOT NULL,
    salt character varying(255) NOT NULL,
    displayname character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    registertime bigint NOT NULL,
    roll integer NOT NULL,
    usrmeta bytea NOT NULL,
    disabled smallint NOT NULL
);

CREATE SEQUENCE {{dbpref}}_authors_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE {{dbpref}}_authors_id_seq OWNED BY {{dbpref}}_authors.id;

ALTER TABLE ONLY {{dbpref}}_authors ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_authors_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_authors ADD CONSTRAINT {{dbpref}}_authors_id PRIMARY KEY (id);