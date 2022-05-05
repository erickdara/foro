CREATE TABLE role(
idRole INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
roleType VARCHAR(50) NOT NULL,
describeRole VARCHAR(100) NOT NULL);

CREATE TABLE user(
idUser INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idRole INT NOT NULL,
usernames VARCHAR(50) NOT NULL,
userMail VARCHAR(50) NOT NULL,
company VARCHAR(50) NULL,
charge VARCHAR(50) NULL,
skills VARCHAR(255) NULL,
userPassword VARCHAR(255),
userImage LONGBLOB,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (idRole) REFERENCES role(idRole) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE topic(
idTopic INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idUser INT NOT NULL,
titleTopic VARCHAR(150) NOT NULL,
describeTopic TEXT NOT NULL,
likes INT NOT NULL DEFAULT 0,
unlikes INT NOT NULL DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (idUser) REFERENCES user(idUser) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE commentary(
idCommentary INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idUser INT NOT NULL,
idTopic INT NOT NULL,
describeCommentary VARCHAR(255) NOT NULL,
likes INT NOT NULL DEFAULT 0,
unlikes INT NOT NULL DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (idTopic) REFERENCES topic(idTopic) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (idUser) REFERENCES user(idUser) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE answer(
idAnswer INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idUser INT NOT NULL,
idCommentary INT NOT NULL,
describeAnswer VARCHAR(255),
likes INT NOT NULL DEFAULT 0,
unlikes INT NOT NULL DEFAULT 0,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (idCommentary) REFERENCES commentary(idCommentary) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (idUser) REFERENCES user(idUser) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE likeTopic(
    idLike INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    idTopic INT,
    idUser INT, 
    typeLike TINYINT,
    created_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,	
    FOREIGN KEY (idTopic) REFERENCES topic(idTopic) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idUser) REFERENCES user(idUser) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE likeCommentary(
    idLike INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    idCommentary INT,
    idUser INT, 
     typeLike TINYINT,
    created_at TIMESTAMP NOT NULL ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,	
    FOREIGN KEY (idCommentary) REFERENCES commentary(idCommentary) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (idUser) REFERENCES user(idUser) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE user_social(
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT(11) NOT NULL,
social_id VARCHAR(255) NOT NULL,
provider VARCHAR(255) NOT NULL, 
created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY(user_id) REFERENCES user(idUser) ON DELETE CASCADE ON UPDATE CASCADE); 

CREATE TABLE likeAnswer(
    idLike INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idAnswer INT NOT NULL,
    idUser INT NOT NULL, 
    typeLike TINYINT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY(idUser) REFERENCES user(idUser) ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY(idAnswer) REFERENCES answer(idAnswer) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE notificationType(
idType INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
notificationType VARCHAR(100) NOT NULL,
describeNotification VARCHAR(100) NOT NULL);

CREATE TABLE notification(
    idNotification INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idUser INT NOT NULL,
    idDestUser INT NOT NULL,
    idTopic INT NOT NULL,
    idNotificationType INT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idUser) REFERENCES user (idUser) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (idDestUser) REFERENCES user (idUser) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (idTopic) REFERENCES topic (idTopic) ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (idNotificationType) REFERENCES notificationType(idType) ON DELETE CASCADE ON UPDATE CASCADE);

CREATE TABLE password_reset (
  id int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  mail varchar(255) NOT NULL,
  token varchar(255) NOT NULL
);

INSERT INTO role (idRole, roleType, describeRole) VALUES (idRole, 'Administrador', 'El administrador a diferencia, puede generar temas en el sistema');

INSERT INTO role (idRole, roleType, describeRole) VALUES (idRole, 'Usuario', 'El usuario se determina cuando se registra en el sistema, este puede interactuar con los temas');

INSERT INTO notificationType(idType, notificationType,describeNotification) VALUES (idType, 'Tema actividad reciente', 'creó el tema');

INSERT INTO notificationType(idType, notificationType,describeNotification) VALUES (idType, 'Comentario actividad reciente', 'ha dejado un comentario sobre');

INSERT INTO notificationType(idType, notificationType,describeNotification) VALUES (idType, 'Respuesta actividad reciente', 'ha respondido un comentario sobre');