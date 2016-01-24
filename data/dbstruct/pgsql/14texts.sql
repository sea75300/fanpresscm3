CREATE SEQUENCE {{dbpref}}_texts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE {{dbpref}}_texts (
    id bigint NOT NULL,
    searchtext character varying(255) NOT NULL,
    replacementtext character varying(255) NOT NULL
);

ALTER SEQUENCE {{dbpref}}_texts_id_seq OWNED BY {{dbpref}}_texts.id;

ALTER TABLE ONLY {{dbpref}}_texts ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_texts_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_texts ADD CONSTRAINT {{dbpref}}_texts_id PRIMARY KEY (id);