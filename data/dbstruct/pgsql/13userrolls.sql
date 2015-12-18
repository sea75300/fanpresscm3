CREATE TABLE {{dbpref}}_userrolls (
    id integer NOT NULL,
    leveltitle character varying(255) NOT NULL
);

CREATE SEQUENCE {{dbpref}}_userrolls_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE {{dbpref}}_userrolls_id_seq OWNED BY {{dbpref}}_userrolls.id;

ALTER TABLE ONLY {{dbpref}}_userrolls ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_userrolls_id_seq'::regclass);

INSERT INTO {{dbpref}}_userrolls (id, leveltitle) VALUES
(1, 'GLOBAL_ADMINISTRATOR'),
(2, 'GLOBAL_EDITOR'),
(3, 'GLOBAL_AUTHOR');

ALTER TABLE ONLY {{dbpref}}_userrolls ADD CONSTRAINT {{dbpref}}_userrolls_id PRIMARY KEY (id);