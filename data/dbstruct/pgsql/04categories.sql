CREATE SEQUENCE {{dbpref}}_categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE {{dbpref}}_categories (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    iconpath text,
    groups character varying(1024) NOT NULL
);

ALTER SEQUENCE {{dbpref}}_categories_id_seq OWNED BY {{dbpref}}_categories.id;

ALTER TABLE ONLY {{dbpref}}_categories ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_categories_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_categories ADD CONSTRAINT {{dbpref}}_categories_id PRIMARY KEY (id);

INSERT INTO {{dbpref}}_categories (id, name, iconpath, groups) VALUES
(1, 'Allgemein', '', '1;2;3');