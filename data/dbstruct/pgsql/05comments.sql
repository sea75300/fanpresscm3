CREATE TABLE {{dbpref}}_comments (
    id bigint NOT NULL,
    articleid bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    website character varying(255) NOT NULL,
    text text NOT NULL,
    private smallint NOT NULL,
    approved smallint NOT NULL,
    spammer smallint NOT NULL,
    ipaddress character varying(512) NOT NULL,
    createtime bigint NOT NULL,
    changetime bigint NOT NULL,
    changeuser bigint NOT NULL
);

CREATE SEQUENCE {{dbpref}}_comments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE {{dbpref}}_comments_id_seq OWNED BY {{dbpref}}_comments.id;

ALTER TABLE ONLY {{dbpref}}_comments ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_comments_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_comments ADD CONSTRAINT {{dbpref}}_comments_id PRIMARY KEY (id);