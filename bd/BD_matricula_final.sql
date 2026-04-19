CREATE DATABASE MATRICULA;
USE MATRICULA;

-- =========================
-- TABLA ALUMNO
-- =========================
CREATE TABLE ALUMNO (
    ID_ALUMNO INT AUTO_INCREMENT PRIMARY KEY,
    DNI_ALUMNO CHAR(8) UNIQUE NOT NULL,
    NOMBRES VARCHAR(50) NOT NULL,
    APELLIDOS VARCHAR(50) NOT NULL,
    FECHA_NACIMIENTO DATE NOT NULL,
    EDAD INT NOT NULL,
    GENERO CHAR(1) NOT NULL,
    DIRECCION VARCHAR(100) NOT NULL,
    CELULAR CHAR(9) NOT NULL,
    CORREO VARCHAR(80) UNIQUE NOT NULL,
    NOMBRE_APODERADO VARCHAR(50) NOT NULL,
    CELULAR_APODERADO CHAR(9) NOT NULL,
    USERNAME VARCHAR(50) UNIQUE NOT NULL,
    PASSWORD_HASH VARCHAR(255) NOT NULL,
    FECHA_REGISTRO DATETIME DEFAULT CURRENT_TIMESTAMP,
    estado VARCHAR(20) NOT NULL DEFAULT 'activo'
);
-- =========================
-- TABLA USUARIO
-- =========================
CREATE TABLE USUARIO (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    USERNAME VARCHAR(50) UNIQUE NOT NULL,
    PASSWORD_HASH VARCHAR(200) NOT NULL,
    ESTADO TINYINT(1) DEFAULT 1
);

-- =========================
-- TABLA AULA
-- =========================
CREATE TABLE AULA (
    ID_AULA INT AUTO_INCREMENT PRIMARY KEY,
    NIVEL VARCHAR(30) NOT NULL,
    GRADO INT NOT NULL,
    SECCION CHAR(1) NOT NULL,
    VACANTES_TOTALES INT NOT NULL,
    VACANTES_DISPONIBLES INT NOT NULL
);

-- =========================
-- TABLA RESERVA
-- =========================
CREATE TABLE RESERVA (
    ID_RESERVA INT AUTO_INCREMENT PRIMARY KEY,
    ID_ALUMNO INT NOT NULL,
    ID_AULA INT NOT NULL,
    CODIGO_PAGO VARCHAR(20) UNIQUE NOT NULL,
    FECHA_RESERVA DATETIME DEFAULT CURRENT_TIMESTAMP,
    ESTADO_PAGOO VARCHAR(20) DEFAULT 'PENDIENTE'
);
CREATE TABLE CURSO (
    ID_CURSO INT AUTO_INCREMENT PRIMARY KEY,
    NOMBRE VARCHAR(100) NOT NULL,
    DESCRIPCION TEXT,
    HORAS_SEMANA INT NOT NULL
);

-- =========================
-- TABLA MATRICULA
-- =========================
CREATE TABLE MATRICULA (
    ID_MATRICULA INT AUTO_INCREMENT PRIMARY KEY,
    ID_ALUMNO INT NOT NULL,
    ID_AULA INT NOT,
    FECHA_MATRICULA DATETIME DEFAULT CURRENT_TIMESTAMP,
    ANIO_ESCOLAR YEAR NOT NULL,
    ESTADO_MATRICULA VARCHAR(20) NOT NULL DEFAULT 'ACTIVO',

    CONSTRAINT FK_MATRICULA_ALUMNO
        FOREIGN KEY (ID_ALUMNO) REFERENCES ALUMNO(ID_ALUMNO)
        ON DELETE CASCADE,

    CONSTRAINT FK_MATRICULA_AULA
        FOREIGN KEY (ID_AULA) REFERENCES AULA(ID_AULA),

    CONSTRAINT UQ_MATRICULA_ALUMNO_ANIO
        UNIQUE (ID_ALUMNO, ANIO_ESCOLAR)
);

-- =========================
-- RELACIONES
-- =========================
ALTER TABLE RESERVA
ADD CONSTRAINT FK_ALUMNO
FOREIGN KEY (ID_ALUMNO) REFERENCES ALUMNO (ID_ALUMNO)
ON DELETE CASCADE;

ALTER TABLE RESERVA
ADD CONSTRAINT FK_AULA
FOREIGN KEY (ID_AULA) REFERENCES AULA (ID_AULA);

-- =========================
-- DATOS AULA
-- =========================
INSERT INTO AULA (NIVEL, GRADO, SECCION, VACANTES_TOTALES, VACANTES_DISPONIBLES) VALUES
('Secundaria', 3, 'A', 30, 5),
('Secundaria', 3, 'B', 30, 0),
('Primaria', 1, 'A', 25, 25),
('Primaria', 6, 'B', 30, 12);

-- =========================
-- DATOS ALUMNO
-- =========================
INSERT INTO ALUMNO (
    DNI_ALUMNO, NOMBRES, APELLIDOS, FECHA_NACIMIENTO, EDAD, GENERO,
    DIRECCION, CELULAR, CORREO, NOMBRE_APODERADO, CELULAR_APODERADO,
    USERNAME, PASSWORD_HASH, estado
) VALUES
('74829135','Luis Alberto','Ramirez Soto','2007-03-15',18,'M',
'Los Olivos 245','987654321','luis@gmail.com','Martha Soto','923456781',
'lramirez','$2y$10$examplehash1','activo'),

('73648291','Camila Fernanda','Torres Quispe','2006-11-28',18,'F',
'Jr. Puno 514','976543218','camila@gmail.com','Rosa Quispe','934567812',
'ctorres','$2y$10$examplehash2','activo'),

('71234568','Diego Sebastian','Mendoza Cruz','2005-08-09',19,'M',
'SJL Mz B Lt 12','965432187','diego@gmail.com','Carlos Mendoza','945678123',
'dmendoza','$2y$10$examplehash3','inactivo'),

('70192834','Valeria Alejandra','Paredes Rojas','2007-01-21',18,'F',
'Lince Arequipa 1820','954321876','valeria@gmail.com','Patricia Rojas','956789234',
'vparedes','$2y$10$examplehash4','en-proceso'),

('75918342','Anthony Javier','Salazar Peña','2006-06-03',18,'M',
'Surco Las Flores 330','943218765','anthony@gmail.com','Julia Peña','967891245',
'asalazar','$2y$10$examplehash5','activo');

-- =========================
-- DATOS RESERVA
-- =========================
INSERT INTO RESERVA (ID_ALUMNO, ID_AULA, CODIGO_PAGO, ESTADO_PAGOO) VALUES
(1, 1, 'PAGO001', 'PENDIENTE'),
(2, 2, 'PAGO002', 'PAGADO'),
(3, 1, 'PAGO003', 'PENDIENTE'),
(4, 3, 'PAGO004', 'PAGADO');

INSERT INTO CURSO (NOMBRE, DESCRIPCION, HORAS_SEMANA) VALUES
('Matemática', 'Curso enfocado en álgebra, aritmética y geometría.', 6),
('Comunicación', 'Desarrollo de habilidades de lectura y escritura.', 5),
('Historia', 'Estudio de hechos históricos nacionales y mundiales.', 4),
('Ciencia y Tecnología', 'Conceptos básicos de física, química y biología.', 5),
('Inglés', 'Aprendizaje del idioma inglés básico e intermedio.', 3);

INSERT INTO USUARIO (USERNAME, PASSWORD_HASH)
VALUES ('Admin', '$2y$10$heuMG7aElXF5IiS4rCN49.T.smRQfhlCmVuoAh/SPpjQ6YA6qzZO6');

-- =========================
-- VERIFICACIÓN
-- =========================
SELECT * FROM ALUMNO;
SELECT * FROM AULA;
SELECT * FROM RESERVA;
SELECT * FROM USUARIO;