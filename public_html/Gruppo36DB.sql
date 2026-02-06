DROP TABLE IF EXISTS utente cascade;

CREATE TABLE utente(
	username varchar(100),
	password varchar(255),
	pfp varchar(255)
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

INSERT INTO	 utente (username, password,pfp) VALUES
('Euplio', 'Daje','profilepictures/gokupfp.jpg'),
('Giacomo','tavolo','profilepictures/ranapfp.jpg');

