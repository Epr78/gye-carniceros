DROP TABLE IF EXISTS entrada_detalles;
DROP TABLE IF EXISTS entradas_compra;
DROP TABLE IF EXISTS despiece_reglas;
DROP TABLE IF EXISTS piezas_base;
DROP TABLE IF EXISTS pedido_detalles;
DROP TABLE IF EXISTS pedidos;
DROP TABLE IF EXISTS receta_productos;
DROP TABLE IF EXISTS recetas;
DROP TABLE IF EXISTS stock;
DROP TABLE IF EXISTS productos;
DROP TABLE IF EXISTS familias;
DROP TABLE IF EXISTS administradores;

CREATE TABLE administradores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE familias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    descripcion VARCHAR(255) DEFAULT NULL,
    activa TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    familia_id INT NOT NULL,
    nombre VARCHAR(120) NOT NULL,
    slug VARCHAR(140) NOT NULL UNIQUE,
    descripcion TEXT DEFAULT NULL,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    tipo_venta ENUM('peso','unidad') NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    en_oferta TINYINT(1) NOT NULL DEFAULT 0,
    precio_oferta DECIMAL(10,2) DEFAULT NULL,
    activo TINYINT(1) NOT NULL DEFAULT 1,
    destacado TINYINT(1) NOT NULL DEFAULT 0,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_productos_familias
        FOREIGN KEY (familia_id) REFERENCES familias(id)
);

CREATE TABLE stock (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL UNIQUE,
    cantidad DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    fecha_actualizacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_stock_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE recetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    slug VARCHAR(160) NOT NULL UNIQUE,
    descripcion_corta VARCHAR(255) DEFAULT NULL,
    elaboracion TEXT NOT NULL,
    imagen VARCHAR(255) DEFAULT NULL,
    activa TINYINT(1) NOT NULL DEFAULT 1,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE receta_productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receta_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad VARCHAR(100) DEFAULT NULL,
    CONSTRAINT fk_receta_productos_receta
        FOREIGN KEY (receta_id) REFERENCES recetas(id),
    CONSTRAINT fk_receta_productos_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(120) NOT NULL,
    telefono VARCHAR(30) NOT NULL,
    email VARCHAR(120) DEFAULT NULL,
    direccion VARCHAR(255) DEFAULT NULL,
    fecha_recogida DATE DEFAULT NULL,
    observaciones TEXT DEFAULT NULL,
    estado ENUM('pendiente','preparado','entregado','cancelado') NOT NULL DEFAULT 'pendiente',
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pedido_detalles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    producto_id INT NOT NULL,
    nombre_producto VARCHAR(120) NOT NULL,
    tipo_venta ENUM('peso','unidad') NOT NULL,
    cantidad DECIMAL(10,2) NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_pedido_detalles_pedido
        FOREIGN KEY (pedido_id) REFERENCES pedidos(id),
    CONSTRAINT fk_pedido_detalles_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE piezas_base (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    slug VARCHAR(140) NOT NULL UNIQUE,
    tipo_unidad ENUM('kg','unidad','caja') NOT NULL DEFAULT 'unidad',
    activa TINYINT(1) NOT NULL DEFAULT 1
);

CREATE TABLE despiece_reglas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pieza_base_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad_resultante DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_despiece_reglas_pieza
        FOREIGN KEY (pieza_base_id) REFERENCES piezas_base(id),
    CONSTRAINT fk_despiece_reglas_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id)
);

CREATE TABLE entradas_compra (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pieza_base_id INT NOT NULL,
    administrador_id INT NOT NULL,
    cantidad_entrada DECIMAL(10,2) NOT NULL,
    observaciones TEXT DEFAULT NULL,
    fecha_creacion DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_entradas_compra_pieza
        FOREIGN KEY (pieza_base_id) REFERENCES piezas_base(id),
    CONSTRAINT fk_entradas_compra_admin
        FOREIGN KEY (administrador_id) REFERENCES administradores(id)
);

CREATE TABLE entrada_detalles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    entrada_compra_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad_generada DECIMAL(10,2) NOT NULL,
    CONSTRAINT fk_entrada_detalles_entrada
        FOREIGN KEY (entrada_compra_id) REFERENCES entradas_compra(id),
    CONSTRAINT fk_entrada_detalles_producto
        FOREIGN KEY (producto_id) REFERENCES productos(id)
);

INSERT INTO administradores (nombre, email, password) VALUES
('Administrador', 'admin@gyecarniceros.local', '$2y$10$w0b0lYd0d9hA0m6mY0fY7u7nD4i8g8M1q9xDg7M8N4U0YV1T2K3aS');

INSERT INTO familias (nombre, slug, descripcion) VALUES
('Vacuno', 'vacuno', 'Productos de vacuno'),
('Pollo', 'pollo', 'Productos de pollo'),
('Cerdo', 'cerdo', 'Productos de cerdo'),
('Elaborados', 'elaborados', 'Hamburguesas y embutidos');

INSERT INTO productos (familia_id, nombre, slug, descripcion, precio, tipo_venta, imagen, en_oferta, precio_oferta, activo, destacado) VALUES
(1, 'Tapa', 'tapa', 'Corte de vacuno ideal para filetes', 14.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Contra', 'contra', 'Corte magro de vacuno', 13.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Babilla', 'babilla', 'Corte tierno de vacuno', 15.50, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Cadera', 'cadera', 'Corte jugoso de vacuno', 16.20, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Redondo', 'redondo', 'Ideal para asar', 15.80, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Morcillo', 'morcillo', 'Perfecto para guisos', 12.90, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Carne para guisar', 'carne-para-guisar', 'Carne de vacuno para guisos', 11.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Carne picada', 'carne-picada', 'Carne picada de vacuno', 10.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Aguja', 'aguja', 'Corte de delantero de vacuno', 13.50, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Espaldilla', 'espaldilla', 'Pieza de vacuno para filetear o guisar', 13.20, 'peso', 'default.jpg', 0, NULL, 1, 0),
(1, 'Cañón', 'canon', 'Corte del delantero', 12.50, 'peso', 'default.jpg', 0, NULL, 1, 0),

(2, 'Alas', 'alas', 'Alitas de pollo frescas', 5.95, 'peso', 'alitaspollo.webp', 0, NULL, 1, 0),
(2, 'Pechuga', 'pechuga', 'Pechuga de pollo fresca', 7.95, 'peso', 'default.jpg', 0, NULL, 1, 1),
(2, 'Jamoncitos', 'jamoncitos', 'Jamoncitos de pollo', 6.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(2, 'Contramuslos', 'contramuslos', 'Contramuslos de pollo', 6.50, 'peso', 'default.jpg', 0, NULL, 1, 0),
(2, 'Traseros', 'traseros', 'Traseros de pollo', 5.90, 'peso', 'default.jpg', 0, NULL, 1, 0),
(2, 'Pollo entero', 'pollo-entero', 'Pollo entero fresco', 1.00, 'unidad', 'Pollo.jpeg', 0, NULL, 1, 1),

(3, 'Jamón', 'jamon', 'Jamón fresco de cerdo', 8.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(3, 'Carne para estofar', 'carne-para-estofar', 'Carne de cerdo para estofado', 7.50, 'peso', 'default.jpg', 0, NULL, 1, 0),
(3, 'Costillas', 'costillas', 'Costillas frescas de cerdo', 8.20, 'peso', 'costillascerdo.webp', 0, NULL, 1, 1),
(3, 'Chuletas de lomo', 'chuletas-de-lomo', 'Chuletas de lomo de cerdo', 8.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(3, 'Chuletas de aguja', 'chuletas-de-aguja', 'Chuletas de aguja de cerdo', 8.75, 'peso', 'default.jpg', 0, NULL, 1, 0),
(3, 'Panceta', 'panceta', 'Panceta fresca de cerdo', 7.95, 'peso', 'default.jpg', 0, NULL, 1, 0),

(4, 'Hamburguesas de ternera', 'hamburguesas-ternera', 'Hamburguesas caseras de ternera', 1.80, 'unidad', 'hm.jpg', 0, NULL, 1, 1),
(4, 'Hamburguesas mixtas', 'hamburguesas-mixtas', 'Hamburguesas mixtas caseras', 1.70, 'unidad', 'hmixta.jpg', 0, NULL, 1, 0),
(4, 'Carne picada mixta', 'carne-picada-mixta', 'Mezcla de cerdo y vacuno', 9.95, 'peso', 'default.jpg', 0, NULL, 1, 0),
(4, 'Chorizo fresco', 'chorizo-fresco', 'Chorizo fresco casero', 9.20, 'peso', 'chorizofresco.webp', 0, NULL, 1, 0),
(4, 'Chorizo criollo', 'chorizo-criollo', 'Chorizo criollo fresco', 9.80, 'peso', 'chorizo.jpeg', 0, NULL, 1, 0),
(4, 'Longaniza', 'longaniza', 'Longaniza fresca', 8.90, 'peso', 'default.jpg', 0, NULL, 1, 0),
(4, 'Morcilla de arroz', 'morcilla-de-arroz', 'Morcilla tradicional de arroz', 8.40, 'peso', 'default.jpg', 0, NULL, 1, 0),
(4, 'Morcilla de cebolla', 'morcilla-de-cebolla', 'Morcilla de cebolla fresca', 8.40, 'peso', 'default.jpg', 0, NULL, 1, 0);

INSERT INTO stock (producto_id, cantidad) VALUES
(1, 0.00),(2, 0.00),(3, 0.00),(4, 0.00),(5, 0.00),(6, 0.00),(7, 0.00),(8, 0.00),(9, 0.00),(10, 0.00),(11, 0.00),
(12, 0.00),(13, 0.00),(14, 0.00),(15, 0.00),(16, 0.00),(17, 0.00),
(18, 0.00),(19, 0.00),(20, 0.00),(21, 0.00),(22, 0.00),(23, 0.00),
(24, 0.00),(25, 0.00),(26, 0.00),(27, 0.00),(28, 0.00),(29, 0.00),(30, 0.00),(31, 0.00);

INSERT INTO piezas_base (nombre, slug, tipo_unidad) VALUES
('Pierna', 'pierna', 'unidad'),
('Delantero', 'delantero', 'unidad'),
('Caja pollo despiece', 'caja-pollo-despiece', 'caja'),
('Caja pollo entero', 'caja-pollo-entero', 'caja'),
('Media canal cerdo', 'media-canal-cerdo', 'unidad'),
('Canal completa cerdo', 'canal-completa-cerdo', 'unidad'),
('Cajas de hamburguesas', 'cajas-hamburguesas', 'caja'),
('Cajas de embutidos', 'cajas-embutidos', 'caja');

INSERT INTO despiece_reglas (pieza_base_id, producto_id, cantidad_resultante) VALUES
(1, 1, 12.00),
(1, 2, 10.00),
(1, 3, 8.00),
(1, 4, 9.00),
(1, 5, 3.00),
(1, 6, 10.00),
(1, 7, 7.00),
(1, 8, 5.50),

(2, 9, 14.00),
(2, 10, 4.50),
(2, 11, 3.00),
(2, 6, 5.00),
(2, 7, 8.00),
(2, 8, 8.00),

(3, 12, 2.50),
(3, 13, 7.50),
(3, 14, 3.50),
(3, 15, 4.00),

(4, 17, 10.00),

(5, 18, 14.00),
(5, 19, 7.00),
(5, 20, 4.00),
(5, 21, 5.00),
(5, 22, 5.00);

INSERT INTO recetas (titulo, slug, descripcion_corta, elaboracion, imagen, activa) VALUES
('Albóndigas caseras', 'albondigas-caseras', 'Receta tradicional con carne picada', 'Mezclar ingredientes, formar albóndigas y cocinar en salsa.', 'default.jpg', 1),
('Pollo al horno', 'pollo-al-horno', 'Pollo jugoso al horno', 'Hornear con especias y patatas hasta dorar.', 'default.jpg', 1);

INSERT INTO receta_productos (receta_id, producto_id, cantidad) VALUES
(1, 8, '500 g'),
(2, 17, '1 unidad');