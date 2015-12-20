CREATE SEQUENCE {{dbpref}}_sessions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE {{dbpref}}_sessions (
    id bigint NOT NULL,
    "userId" bigint NOT NULL,
    "sessionId" character varying(255) NOT NULL,
    login bigint NOT NULL,
    logout bigint NOT NULL,
    lastaction bigint NOT NULL,
    ip character varying(512) NOT NULL
);

ALTER SEQUENCE {{dbpref}}_sessions_id_seq OWNED BY {{dbpref}}_sessions.id;

ALTER TABLE ONLY {{dbpref}}_sessions ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_sessions_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_sessions ADD CONSTRAINT {{dbpref}}_sessions_id PRIMARY KEY (id);