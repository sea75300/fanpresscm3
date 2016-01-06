CREATE SEQUENCE {{dbpref}}_articles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE {{dbpref}}_articles (
    id bigint NOT NULL,
    title character varying(512) NOT NULL,
    content text NOT NULL,
    categories character varying(512) NOT NULL,
    createtime bigint NOT NULL,
    createuser bigint NOT NULL,
    changetime bigint NOT NULL,
    changeuser bigint NOT NULL,
    md5path character varying(255) NOT NULL,
    draft smallint NOT NULL,
    archived smallint NOT NULL,
    pinned smallint NOT NULL,
    postponed smallint NOT NULL,
    deleted smallint NOT NULL,
    comments smallint NOT NULL,
    approval smallint NOT NULL,
    imagepath text
);

ALTER SEQUENCE {{dbpref}}_articles_id_seq OWNED BY {{dbpref}}_articles.id;

ALTER TABLE ONLY {{dbpref}}_articles ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_articles_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_articles ADD CONSTRAINT {{dbpref}}_articles_id PRIMARY KEY (id);

CREATE INDEX {{dbpref}}_articles_approval ON {{dbpref}}_articles USING btree (approval);

CREATE INDEX {{dbpref}}_articles_categories ON {{dbpref}}_articles USING btree (categories);

CREATE INDEX {{dbpref}}_articles_changetime ON {{dbpref}}_articles USING btree (changetime);

CREATE INDEX {{dbpref}}_articles_createuser ON {{dbpref}}_articles USING btree (createuser);

CREATE INDEX {{dbpref}}_articles_deleted ON {{dbpref}}_articles USING btree (deleted);

CREATE INDEX {{dbpref}}_articles_draft ON {{dbpref}}_articles USING btree (draft);

CREATE INDEX {{dbpref}}_articles_pinned ON {{dbpref}}_articles USING btree (pinned);

CREATE INDEX {{dbpref}}_articles_postponed ON {{dbpref}}_articles USING btree (postponed);

CREATE INDEX {{dbpref}}_articles_title ON {{dbpref}}_articles USING btree (title);