CREATE DATABASE PWGAAA;
USE PWGAAA;

CREATE TABLE tfgs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    fecha DATE DEFAULT NULL,
    nota INT CHECK (nota BETWEEN 1 AND 10),
    resumen TEXT,
    palabras_clave VARCHAR(255) DEFAULT NULL,
    integrantes TEXT,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_fecha CHECK (fecha REGEXP '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$')
);


CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('alumno', 'profesor', 'invitado') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE alumno_tfg (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT,
    tfg_id INT,
    FOREIGN KEY (alumno_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (tfg_id) REFERENCES tfgs(id) ON DELETE CASCADE
);

  CREATE TABLE profesor_tfg (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profesor_id INT,
    tfg_id INT,
    FOREIGN KEY (profesor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (tfg_id) REFERENCES tfgs(id) ON DELETE CASCADE
);
  
