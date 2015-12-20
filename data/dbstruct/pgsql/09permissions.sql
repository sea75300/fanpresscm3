CREATE SEQUENCE {{dbpref}}_permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE {{dbpref}}_permissions (
    id bigint NOT NULL,
    rollid bigint NOT NULL,
    "permissionData" text NOT NULL
);

ALTER SEQUENCE {{dbpref}}_permissions_id_seq OWNED BY {{dbpref}}_permissions.id;

ALTER TABLE ONLY {{dbpref}}_permissions ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_permissions_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_permissions ADD CONSTRAINT {{dbpref}}_permissions_id PRIMARY KEY (id);

INSERT INTO {{dbpref}}_permissions (id, rollid, "permissionData") VALUES
(1, 1, '{"article":{"add":1,"edit":1,"editall":1,"delete":1,"archive":1,"approve":0,"revisions":1},"comment":{"edit":1,"editall":1,"delete":1,"approve":1,"private":1},"system":{"categories":1,"options":1,"users":1,"rolls":1,"permissions":1,"templates":1,"smileys":1,"update":1,"logs":1},"modules":{"install":1,"uninstall":1,"enable":1,"configure":1},"uploads":{"add":1,"delete":1,"thumbs":1,"rename":1}}'),
(2, 2, '{"article":{"add":1,"edit":1,"editall":1,"delete":1,"archive":1,"approve":0,"revisions":1},"comment":{"edit":1,"editall":1,"delete":1,"approve":1,"private":1},"system":{"categories":1,"options":1,"users":0,"rolls":1,"permissions":0,"templates":1,"smileys":1,"update":0,"logs":0},"modules":{"install":0,"uninstall":0,"enable":0,"configure":1},"uploads":{"add":1,"delete":1,"thumbs":1,"rename":1}}'),
(3, 3, '{"article":{"add":1,"edit":1,"editall":0,"delete":0,"archive":0,"approve":1,"revisions":0},"comment":{"edit":1,"editall":0,"delete":0,"approve":0,"private":0},"system":{"categories":0,"options":0,"users":0,"rolls":0,"permissions":0,"templates":0,"smileys":0,"update":0,"logs":0},"modules":{"install":0,"uninstall":0,"enable":0,"configure":0},"uploads":{"add":1,"delete":0,"thumbs":1,"rename":0}}');