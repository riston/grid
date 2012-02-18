CREATE TABLE user (
	user_id INT NOT NULL AUTO_INCREMENT,
	name VARCHAR(64),
	age TINYINT,
	location VARCHAR(64),
	PRIMARY KEY (user_id)
)
DEFAULT CHARACTER SET = utf8;

INSERT INTO user (name, age, location) VALUES ('Juhan', 34, 'Tallinn');
INSERT INTO user (name, age, location) VALUES ('Miku', 49, 'Kabala');
INSERT INTO user (name, age, location) VALUES ('Tõnu', 34, 'Tartu');
INSERT INTO user (name, age, location) VALUES ('Vahur', 30, 'Pärnu');
