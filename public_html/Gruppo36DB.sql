DROP TABLE IF EXISTS utente cascade;

CREATE TABLE utente(
	username varchar(100),
	password varchar(25),
	id_utente integer
);

GRANT ALL PRIVILEGES ON ALL TABLES IN SCHEMA public TO www;
GRANT ALL PRIVILEGES ON ALL SEQUENCES IN SCHEMA public TO www;

INSERT INTO	 utente (username, password, id_utente) VALUES
('Euplio', 'Daje', 2),
('Giacomo','tavolo',4);