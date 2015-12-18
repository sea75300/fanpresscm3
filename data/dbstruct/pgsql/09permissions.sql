CREATE TABLE {{dbpref}}_permissions (
    id integer NOT NULL,
    rollid bigint NOT NULL,
    permissionData bytea NOT NULL
);

CREATE SEQUENCE {{dbpref}}_permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE {{dbpref}}_permissions_id_seq OWNED BY {{dbpref}}_permissions.id;

ALTER TABLE ONLY {{dbpref}}_permissions ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_permissions_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_permissions ADD CONSTRAINT {{dbpref}}_permissions_id PRIMARY KEY (id);