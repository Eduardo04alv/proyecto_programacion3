CREATE TABLE proveedor(
    id_prov INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40),
    apellido VARCHAR(40),
    telefono VARCHAR(15)
);

-- Tabla productos
CREATE TABLE productos(
    id_prod INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(40),
    cantidad INT,
    precio DECIMAL(10,2),
    id_prov INT,
    FOREIGN KEY (id_prov) REFERENCES proveedor(id_prov)
);

-- Tabla facturas 
CREATE TABLE facturas (
    id_factura INT AUTO_INCREMENT PRIMARY KEY,
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(12,2) NOT NULL DEFAULT 0.00
);

-- Tabla detalle_factura
CREATE TABLE detalle_factura (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_factura INT NOT NULL,
    id_prod INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(12,2) GENERATED ALWAYS AS (cantidad * precio_unitario) STORED,
    FOREIGN KEY (id_factura) REFERENCES facturas(id_factura) ON DELETE CASCADE,
    FOREIGN KEY (id_prod) REFERENCES productos(id_prod) ON DELETE RESTRICT
);