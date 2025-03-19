CREATE TABLE tfgs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    fecha DATE DEFAULT NULL,
    nota INT CHECK (nota BETWEEN 1 AND 10),
    resumen TEXT,
    palabras_clave VARCHAR(255) DEFAULT NULL,
    integrantes TEXT,
    CONSTRAINT chk_fecha CHECK (fecha REGEXP '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$')
);
INSERT INTO tfgs (titulo, fecha, nota, resumen, palabras_clave, integrantes) 
VALUES
(),
