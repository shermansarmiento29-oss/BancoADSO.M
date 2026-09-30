CREATE DATABASE IF NOT EXISTS db_banco_adso
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_banco_adso;

-- 1. Clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Cuentas (el saldo nunca puede quedar negativo)
CREATE TABLE IF NOT EXISTS cuentas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_cuenta VARCHAR(50) NOT NULL UNIQUE,
    saldo DECIMAL(12,2) NOT NULL DEFAULT 0.00,
    cliente_id INT NOT NULL,
    CONSTRAINT chk_saldo_no_negativo CHECK (saldo >= 0),
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Usuarios (Acceso)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL UNIQUE,
    clave_hash VARCHAR(255) NOT NULL,
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Retiros
CREATE TABLE IF NOT EXISTS retiros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_id INT NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_retiro_positivo CHECK (valor > 0),
    FOREIGN KEY (cuenta_id) REFERENCES cuentas(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Transferencias
CREATE TABLE IF NOT EXISTS transferencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cuenta_origen_id INT NOT NULL,
    cuenta_destino_id INT NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT chk_transferencia_positiva CHECK (valor > 0),
    CONSTRAINT chk_cuentas_distintas CHECK (cuenta_origen_id <> cuenta_destino_id),
    FOREIGN KEY (cuenta_origen_id) REFERENCES cuentas(id) ON DELETE RESTRICT,
    FOREIGN KEY (cuenta_destino_id) REFERENCES cuentas(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
