CREATE DATABASE PWGAAA;
USE PWGAAA;
-- Tabla Usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol ENUM('alumno', 'profesor', 'admin') NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
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

