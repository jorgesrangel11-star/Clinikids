CREATE TABLE IF NOT EXISTS tutores (
    id_tutor INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    mail VARCHAR(100) NOT NULL UNIQUE, 
    pass VARCHAR(255) NOT NULL, 
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE IF NOT EXISTS pediatras (
    id_pediatra INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cedula VARCHAR(20) NOT NULL UNIQUE,
    especialidad VARCHAR(100) NOT NULL,
    mail VARCHAR(100) NOT NULL UNIQUE,
    pass VARCHAR(255) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    id_tutor INT,
    FOREIGN KEY (id_tutor) REFERENCES tutores(id_tutor)
);

CREATE TABLE IF NOT EXISTS citas (
    id_cita INT AUTO_INCREMENT PRIMARY KEY,
    id_tutor INT,
    id_paciente INT,
    id_pediatra INT,
    fecha_cita DATE NOT NULL,
    hora_cita TIME NOT NULL,
    motivo TEXT,
    estatus ENUM('Pendiente', 'Confirmada', 'Pagada') DEFAULT 'Pendiente',
    FOREIGN KEY (id_tutor) REFERENCES tutores(id_tutor),
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente),
    FOREIGN KEY (id_pediatra) REFERENCES pediatras(id_pediatra)
);