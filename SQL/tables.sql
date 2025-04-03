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
    rol ENUM('alumno', 'profesor', 'admin') NOT NULL,
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
  
//PROBAR
CREATE DATABASE PWGAAA;
USE PWGAAA;

-- Nueva tabla TFGs (Probar)
CREATE TABLE tfgs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    fecha DATE DEFAULT NULL,
    resumen TEXT,
    palabras_clave VARCHAR(255) DEFAULT NULL,
    integrante1 INT NOT NULL,
    integrante2 INT DEFAULT NULL,
    integrante3 INT DEFAULT NULL,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_fecha CHECK (fecha REGEXP '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$'),
    CONSTRAINT fk_integrante1 FOREIGN KEY (integrante1) REFERENCES usuarios(id) ON DELETE CASCADE,
    CONSTRAINT fk_integrante2 FOREIGN KEY (integrante2) REFERENCES usuarios(id) ON DELETE SET NULL,
    CONSTRAINT fk_integrante3 FOREIGN KEY (integrante3) REFERENCES usuarios(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Tabla TFGs (se eliminó la columna "nota" para trasladarla a la tabla de notas)
CREATE TABLE tfgs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    fecha DATE DEFAULT NULL,
    resumen TEXT,
    palabras_clave VARCHAR(255) DEFAULT NULL,
    integrantes TEXT,
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_fecha CHECK (fecha REGEXP '^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$')
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('alumno', 'profesor', 'admin') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Relación muchos a muchos entre alumnos y TFGs
CREATE TABLE alumno_tfg (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    tfg_id INT NOT NULL,
    FOREIGN KEY (alumno_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (tfg_id) REFERENCES tfgs(id) ON DELETE CASCADE,
    UNIQUE (alumno_id, tfg_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Relación muchos a muchos entre profesores y TFGs
CREATE TABLE profesor_tfg (
    id INT AUTO_INCREMENT PRIMARY KEY,
    profesor_id INT NOT NULL,
    tfg_id INT NOT NULL,
    FOREIGN KEY (profesor_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (tfg_id) REFERENCES tfgs(id) ON DELETE CASCADE,
    UNIQUE (profesor_id, tfg_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla Notas: relaciona un alumno con un TFG y almacena la nota asignada
CREATE TABLE notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    tfg_id INT NOT NULL,
    nota INT CHECK (nota BETWEEN 1 AND 10),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (alumno_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (tfg_id) REFERENCES tfgs(id) ON DELETE CASCADE,
    UNIQUE (alumno_id, tfg_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabla Archivos: metadatos de archivos asociados a un TFG
CREATE TABLE archivos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tfg_id INT NOT NULL,
    nombre VARCHAR(255) NOT NULL,
    ruta VARCHAR(255) NOT NULL,
    tipo VARCHAR(50) DEFAULT NULL,
    tamaño INT DEFAULT NULL,  -- Tamaño en bytes
    fecha_subida TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tfg_id) REFERENCES tfgs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

