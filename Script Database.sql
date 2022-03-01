CREATE DATABASE databaseforo;

USE DATABASE databaseforo;

CREATE TABLE rol(
idRol INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
tipoRol VARCHAR(50) NOT NULL,
describeRol VARCHAR(100) NOT NULL);

CREATE TABLE usuario(
idUsuario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idRol INT NOT NULL,
usuNombres VARCHAR(50) NOT NULL,
usuApellidos VARCHAR(50) NOT NULL,
usuCorreo VARCHAR(50) NOT NULL,
usuImagen LONGBLOB,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (idRol) REFERENCES rol(idRol) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE tema(
idTema INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idUsuario INT NOT NULL,
tituloTema VARCHAR(50) NOT NULL,
describeTema VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE comentario(
idComentario INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idUsuario INT NOT NULL,
idTema INT NOT NULL,
describeComentario VARCHAR(255) NOT NULL,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (idTema) REFERENCES tema(idTema) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE);

CREATE TABLE respuesta(
idRespuesta INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
idUsuario INT NOT NULL,
idComentario INT NOT NULL,
describeRespuesta VARCHAR(255),
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (idComentario) REFERENCES comentario(idComentario) ON UPDATE CASCADE ON DELETE CASCADE,
FOREIGN KEY (idUsuario) REFERENCES usuario(idUsuario) ON UPDATE CASCADE ON DELETE CASCADE);

INSERT INTO rol (idRol, tipoRol, describeRol) VALUES (idRol, 'Admin', 'El administrador a diferencia, puede generar temas en el sistema')

INSERT INTO rol (idRol, tipoRol, describeRol) VALUES (idRol, 'User', 'El usuario se determina cuando se registra en el sistema, este puede interactuar con los temas')

INSERT INTO rol (idRol, tipoRol, describeRol) VALUES (idRol, 'Strange', 'El invitado solo puede leer el foro, pero no puede interactuar con el sistema')

INSERT INTO usuario (idUsuario, idRol, usuNombres, usuApellidos, usuCorreo, usuImagen, created_at)
VALUES (idUsuario, 1, 'Erick', 'Rangel', 'Erick@', '',created_at)

INSERT INTO tema (idTema, idUsuario, tituloTema, describeTema, created_at) 
VALUES (idTema, 1, 'Transformación digital', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC.', created_at);
