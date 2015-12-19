CREATE TABLE {{dbpref}}_config (
    id bigint NOT NULL,
    config_name character varying(255) NOT NULL,
    config_value text NOT NULL
);

CREATE SEQUENCE {{dbpref}}_config_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;

ALTER SEQUENCE {{dbpref}}_config_id_seq OWNED BY {{dbpref}}_config.id;

ALTER TABLE ONLY {{dbpref}}_config ALTER COLUMN id SET DEFAULT nextval('{{dbpref}}_config_id_seq'::regclass);

INSERT INTO {{dbpref}}_config (id, config_name, config_value) VALUES
(1, 'system_version', ''),
(2, 'system_email', ''),
(3, 'system_url', ''),
(4, 'system_lang', ''),
(5, 'system_dtmask', 'd.m.Y H:i:s'),
(6, 'system_timezone', 'Europe/Berlin'),
(7, 'system_session_length', '18000'),
(8, 'system_mode', '0'),
(9, 'system_css_path', ''),
(10, 'system_show_share', '1'),
(11, 'system_comments_enabled', '1'),
(12, 'system_cache_timeout', '86400'),
(13, 'system_loader_jquery', '1'),
(14, 'system_editor', '0'),
(15, 'system_editor_css', ''),
(16, 'system_editor_fontsize', '12pt'),
(17, 'system_maintenance', 0),
(18, 'system_loginfailed_locked', 3),
(19, 'articles_revisions', '1'),
(20, 'articles_trash', '1'),
(21, 'articles_limit', '5'),
(22, 'articles_template_active', 'articlelist'),
(23, 'articles_archive_show', '1'),
(24, 'articles_sort', 'createtime'),
(25, 'articles_sort_order', 'DESC'),
(26, 'article_template_active', 'articlesingle'),
(27, 'articles_rss', '1'),
(28, 'comments_template_active', 'comments'),
(29, 'comments_flood', '300'),
(30, 'comments_email_optional', '1'),
(31, 'comments_confirm', '1'),
(32, 'comments_antispam_question', ''),
(33, 'comments_antispam_answer', ''),
(34, 'comments_notify', '0'),
(35, 'comments_markspam_commentcount', '2'),
(36, 'files_img_thumb_minwidth', '500'),
(37, 'files_img_thumb_minheight', '500'),
(38, 'file_img_thumb_width', '100'),
(39, 'file_img_thumb_height', '100'),
(40, 'file_uploader_new', '1'),
(41, 'twitter_data', '{"consumer_key":"","consumer_secret":"","user_token":"","user_secret":""}'),
(42, 'twitter_events', '{"create":0,"update":0}');

ALTER TABLE ONLY {{dbpref}}_config ADD CONSTRAINT {{dbpref}}_config_id PRIMARY KEY (id);