CREATE SEQUENCE {{dbpref}}_cronjobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


CREATE TABLE {{dbpref}}_cronjobs (
    id bigint NOT NULL,
    cjname character varying(64) NOT NULL,
    lastexec bigint NOT NULL
);

ALTER SEQUENCE {{dbpref}}_cronjobs_id_seq OWNED BY {{dbpref}}_cronjobs.id;

ALTER TABLE ONLY {{dbpref}}_cronjobs ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_cronjobs_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_cronjobs ADD CONSTRAINT {{dbpref}}_cronjobs_id PRIMARY KEY (id);

INSERT INTO {{dbpref}}_cronjobs (id, cjname, lastexec) VALUES
(1, 'anonymizeIps', 0),
(2, 'clearLogs', 0),
(3, 'clearTemp', 0),
(4, 'fmThumbs', 0),
(5, 'postponedArticles', 0),
(6, 'updateCheck', 0),
(7, 'dbBackup', 0),
(8, 'fileindex', 0);