# Banco ADSO

Aplicación bancaria sencilla en PHP + MySQL: login, panel con saldo, retiros, transferencias e historiales.

## Cómo ejecutarla

1. **Instalar el autoload de Composer** (en la carpeta del proyecto):
   ```
   composer install
   ```
2. **Crear la base de datos** (desde phpMyAdmin o la consola):
   ```
   mysql -u root -p < sql/creacion.sql
   mysql -u root -p < sql/siembra.sql
   ```
3. **Configurar la conexión**: revisa `config/basedatos.php`.
   Si quieres un usuario de MySQL con permisos limitados (recomendado), usa `sql/usuario_app.sql`
   y copia `config/basedatos.ejemplo.php` como `config/basedatos.php` con esos datos.
4. **Levantar el servidor** con la carpeta `public/` como raíz:
   ```
   php -S localhost:8000 -t public
   ```
   y abre http://localhost:8000 (requiere PHP 8.1 o superior con `pdo_mysql`).

Cuentas de prueba: `1001` a `1005` (las contraseñas son las de tus hashes de `siembra.sql`).

## Estructura

```
public/             index.php (único punto de entrada) y css/estilos.css
src/Nucleo/         Conexion, Router, Sesion, Csrf, Vista
src/Controladores/  ControladorLogin, ControladorBanco
src/Servicios/      ServicioAutenticacion, ServicioTransacciones (reglas del negocio)
src/Repositorios/   consultas SQL
src/Modelos/        objetos de datos
vistas/             HTML (con _cabecera.php y _pie.php compartidos)
config/             basedatos.php (no se sube a git) y basedatos.ejemplo.php
sql/                creacion.sql, siembra.sql, usuario_app.sql
```

## Para limpiar el repositorio de git

`vendor/` y `config/basedatos.php` ya están en `.gitignore`, pero si ya estaban subidos hay que sacarlos:
```
git rm -r --cached vendor config/basedatos.php src/Nucleo/Index.php
git add . && git commit -m "Corrige errores, seguridad y separa CSS"
```
Si el repositorio de GitHub es público, cambia la contraseña de MySQL: la anterior quedó en el historial.
