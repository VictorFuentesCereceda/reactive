CREATE TABLE answer
(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  user_id INT(11),
  question_id INT(11),
  answer INT(11) NOT NULL,
  CONSTRAINT FK_DADD4A25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id),
  CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)
);
CREATE INDEX IDX_DADD4A251E27F6BF ON answer (question_id);
CREATE INDEX IDX_DADD4A25A76ED395 ON answer (user_id);
CREATE TABLE question
(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  question VARCHAR(200) NOT NULL,
  form_id INT(11),
  CONSTRAINT FK_B6F7494E5FF69B7D FOREIGN KEY (form_id) REFERENCES form (id)
);
CREATE INDEX IDX_B6F7494E5FF69B7D ON question (form_id);
CREATE TABLE role
(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  role VARCHAR(80) NOT NULL
);
CREATE TABLE user
(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  role_id INT(11),
  name VARCHAR(200) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)
);
CREATE INDEX IDX_8D93D649D60322AC ON user (role_id);
CREATE TABLE form
(
  id INT(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL
);