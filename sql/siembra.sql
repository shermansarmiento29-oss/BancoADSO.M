USE db_banco_adso;

-- Inserción de datos iniciales (siembra)
INSERT INTO clientes (id, nombre) VALUES 
(1, 'Ana Gómez'),
(2, 'Carlos Pérez'),
(3, 'María Rodríguez'),
(4, 'Luis Martínez'),
(5, 'Sofia Torres');

INSERT INTO cuentas (id, numero_cuenta, saldo, cliente_id) VALUES 
(1, '1001', 500000.00, 1),
(2, '1002', 1200500.50, 2),
(3, '1003', 75000.00, 3),
(4, '1004', 3200000.00, 4),
(5, '1005', 150000.00, 5);

INSERT INTO usuarios (cuenta_id, clave_hash) VALUES 
(1, '$2y$12$ju3DL/qhaa8iFgB9nHfyg.93unQgEnd2AQRXN1xdnHbA/4jovKYMO'),
(2, '$2y$12$RLRm7LrodiaEBk3q6SHoHeIGCUZCng1x6nRO2kDzAzkutX1HHHICwW'),
(3, '$2y$12$JUNT7c/rLLEKhlnmkzBkAOBDUSUI8XvvRG6VAimM/vx26ep7yIdmO'),
(4, '$2y$12$9Mb9eJE09.jJJOIvXS33iu.5ThaAi44HtbUMKJE5P7iArK4cRj.Sa'),
(5, '$2y$12$NqAm15UDr9cPi52YLvUDledvc7.CZKkz8v9h12jmZxbfM/sOTJUjm');
