CREATE SEQUENCE {{dbpref}}_smileys_id_seq
    START WITH 39
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

CREATE TABLE {{dbpref}}_smileys (
    id bigint NOT NULL,
    smileycode character varying(32) NOT NULL,
    filename character varying(255) NOT NULL
);

ALTER SEQUENCE {{dbpref}}_smileys_id_seq OWNED BY {{dbpref}}_smileys.id;

ALTER TABLE ONLY {{dbpref}}_smileys ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_smileys_id_seq'::regclass);

ALTER TABLE ONLY {{dbpref}}_smileys ADD CONSTRAINT {{dbpref}}_smileys_id PRIMARY KEY (id);

INSERT INTO {{dbpref}}_smileys (id, smileycode, filename) VALUES
(1, ':annoyed:', 'annoyed.gif'),
(2, ':D', 'biggrin.gif'),
(3, ':blah:', 'blah.gif'),
(4, ':|', 'blank.gif'),
(5, ':blush:', 'blush.gif'),
(6, ':bored:', 'bored.gif'),
(7, ':bounce:', 'bounce.gif'),
(8, ':confused:', 'confused.gif'),
(9, ':cool:', 'cool.gif'),
(10, ':cry:', 'cry.gif'),
(11, ':cute:', 'cute.gif'),
(12, ':evil:', 'evil.gif'),
(13, ':frustrated:', 'frustrated.gif'),
(14, ':grins:', 'grin.gif'),
(15, ':gross:', 'gross.gif'),
(16, ':grr:', 'grr.gif'),
(17, ':heart.gif:', 'heart.gif'),
(18, ':huh:', 'huh.gif'),
(19, ':kiss:', 'kissy.gif'),
(20, ':lol:', 'laugh.gif'),
(21, ':love:', 'love.gif'),
(22, ':mad:', 'mad.gif'),
(23, ':nono:', 'no.gif'),
(24, ':ouch:', 'ouch.gif'),
(25, ':(', 'sad.gif'),
(26, ':secret:', 'secret.gif'),
(27, ':shocked:', 'shocked.gif'),
(28, ':sleepy:', 'sleepy.gif'),
(29, ':)', 'smile.gif'),
(30, ':spin:', 'spin.gif'),
(31, ':sweat:', 'sweatdrop.gif'),
(32, ':think:', 'thinking.gif'),
(33, ':P', 'tongue.gif'),
(34, ':whoa:', 'whoa.gif'),
(35, ';)', 'wink.gif'),
(36, ':whoohoo:', 'woohoo.gif'),
(37, ':yeah:', 'yes.gif'),
(38, ':yummy:', 'yum.gif');