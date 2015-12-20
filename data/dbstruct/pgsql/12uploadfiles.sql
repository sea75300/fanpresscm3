CREATE SEQUENCE {{dbpref}}_uploadfiles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE {{dbpref}}_uploadfiles (
    id bigint NOT NULL,
    userid bigint NOT NULL,
    filename character varying(255) NOT NULL,
    filetime bigint NOT NULL
);

ALTER SEQUENCE {{dbpref}}_uploadfiles_id_seq OWNED BY {{dbpref}}_uploadfiles.id;

ALTER TABLE ONLY {{dbpref}}_uploadfiles ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_uploadfiles_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_uploadfiles ADD CONSTRAINT {{dbpref}}_uploadfiles_id PRIMARY KEY (id);