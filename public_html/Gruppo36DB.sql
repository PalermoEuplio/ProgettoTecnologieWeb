DROP TABLE IF EXISTS utente cascade;

CREATE TABLE utente(
	username varchar(100),
	password varchar(25)
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;