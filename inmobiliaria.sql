-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS inmobiliaria;
USE inmobiliaria;

-- Crear la tabla viviendas
CREATE TABLE viviendas (
    id INT(3) AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(15),
    zona VARCHAR(15),
    direccion VARCHAR(30),
    dormitorios INT(1),
    precio FLOAT(10,2),
    tamano INT(5),
    extras SET('Piscina','Jardín','Garage')
);

-- Insertar datos de ejemplo
INSERT INTO viviendas (tipo, zona, direccion, dormitorios, precio, tamano, extras) VALUES
('Casa', 'Norte', 'Av. Libertador 1234', 3, 250000.00, 120, 'Piscina,Jardín'),
('Departamento', 'Centro', 'Calle Falsa 123', 2, 180000.00, 75, 'Garage'),
('Casa', 'Sur', 'Belgrano 456', 4, 320000.00, 150, 'Piscina,Jardín,Garage'),
('Departamento', 'Norte', 'San Martín 789', 1, 120000.00, 45, ''),
('Casa', 'Oeste', 'Mitre 321', 3, 280000.00, 135, 'Jardín,Garage'),
('Departamento', 'Centro', 'Rivadavia 654', 2, 150000.00, 65, 'Garage'),
('Casa', 'Este', 'Sarmiento 987', 5, 450000.00, 200, 'Piscina,Jardín,Garage'),
('Departamento', 'Sur', 'Moreno 159', 2, 160000.00, 70, ''),
('Casa', 'Norte', 'Alvear 753', 4, 380000.00, 180, 'Piscina,Garage'),
('Departamento', 'Oeste', 'Corrientes 852', 3, 200000.00, 90, 'Garage'),
('Casa', 'Centro', 'Pellegrini 456', 3, 290000.00, 140, 'Jardín'),
('Departamento', 'Este', 'Tucumán 321', 1, 110000.00, 40, ''),
('Casa', 'Sur', 'Urquiza 654', 4, 350000.00, 160, 'Piscina,Jardín'),
('Departamento', 'Norte', 'Alem 147', 2, 175000.00, 80, 'Garage'),
('Casa', 'Oeste', 'Perón 963', 5, 420000.00, 190, 'Piscina,Jardín,Garage');