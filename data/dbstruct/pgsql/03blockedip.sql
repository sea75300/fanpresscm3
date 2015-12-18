CREATE TABLE {{dbpref}}_blockedip (
    id integer NOT NULL,
    ipaddress character varying(512) NOT NULL,
    iptime bigint NOT NULL,
    userid bigint NOT NULL,
    nocomments smallint NOT NULL,
    nologin smallint NOT NULL,
    noaccess smallint NOT NULL
);

CREATE SEQUENCE {{dbpref}}_blockedip_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE {{dbpref}}_blockedip_id_seq OWNED BY {{dbpref}}_blockedip.id;

ALTER TABLE ONLY {{dbpref}}_blockedip ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_blockedip_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_blockedip ADD CONSTRAINT {{dbpref}}_blockedip_id PRIMARY KEY (id);