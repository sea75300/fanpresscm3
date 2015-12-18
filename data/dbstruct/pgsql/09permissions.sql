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

INSERT INTO {{dbpref}}_permissions (id, rollid, permissionData) VALUES
(1, 1, 0x7b2261727469636c65223a7b22616464223a312c2265646974223a312c2265646974616c6c223a312c2264656c657465223a312c2261726368697665223a312c22617070726f7665223a302c227265766973696f6e73223a317d2c22636f6d6d656e74223a7b2265646974223a312c2265646974616c6c223a312c2264656c657465223a312c22617070726f7665223a312c2270726976617465223a317d2c2273797374656d223a7b2263617465676f72696573223a312c226f7074696f6e73223a312c227573657273223a312c22726f6c6c73223a312c227065726d697373696f6e73223a312c2274656d706c61746573223a312c22736d696c657973223a312c22757064617465223a312c226c6f6773223a317d2c226d6f64756c6573223a7b22696e7374616c6c223a312c22756e696e7374616c6c223a312c22656e61626c65223a312c22636f6e666967757265223a317d2c2275706c6f616473223a7b22616464223a312c2264656c657465223a312c227468756d6273223a312c2272656e616d65223a317d7d),
(2, 2, 0x7b2261727469636c65223a7b22616464223a312c2265646974223a312c2265646974616c6c223a312c2264656c657465223a312c2261726368697665223a312c22617070726f7665223a302c227265766973696f6e73223a317d2c22636f6d6d656e74223a7b2265646974223a312c2265646974616c6c223a312c2264656c657465223a312c22617070726f7665223a312c2270726976617465223a317d2c2273797374656d223a7b2263617465676f72696573223a312c226f7074696f6e73223a312c227573657273223a302c22726f6c6c73223a312c227065726d697373696f6e73223a302c2274656d706c61746573223a312c22736d696c657973223a312c22757064617465223a302c226c6f6773223a307d2c226d6f64756c6573223a7b22696e7374616c6c223a302c22756e696e7374616c6c223a302c22656e61626c65223a302c22636f6e666967757265223a317d2c2275706c6f616473223a7b22616464223a312c2264656c657465223a312c227468756d6273223a312c2272656e616d65223a317d7d),
(3, 3, 0x7b2261727469636c65223a7b22616464223a312c2265646974223a312c2265646974616c6c223a302c2264656c657465223a302c2261726368697665223a302c22617070726f7665223a312c227265766973696f6e73223a307d2c22636f6d6d656e74223a7b2265646974223a312c2265646974616c6c223a302c2264656c657465223a302c22617070726f7665223a302c2270726976617465223a307d2c2273797374656d223a7b2263617465676f72696573223a302c226f7074696f6e73223a302c227573657273223a302c22726f6c6c73223a302c227065726d697373696f6e73223a302c2274656d706c61746573223a302c22736d696c657973223a302c22757064617465223a302c226c6f6773223a307d2c226d6f64756c6573223a7b22696e7374616c6c223a302c22756e696e7374616c6c223a302c22656e61626c65223a302c22636f6e666967757265223a307d2c2275706c6f616473223a7b22616464223a312c2264656c657465223a302c227468756d6273223a312c2272656e616d65223a307d7d);

ALTER TABLE ONLY {{dbpref}}_permissions ADD CONSTRAINT {{dbpref}}_permissions_id PRIMARY KEY (id);