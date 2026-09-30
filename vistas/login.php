<?php
$titulo = 'Banco ADSO';
require __DIR__ . '/_cabecera.php';
?>
        <form action="index.php?ruta=procesar-login" method="POST">
            <?= $campoCsrf ?>

            <div class="form-group">
                <label for="numero_cuenta">Número de cuenta:</label>
                <input type="text" id="numero_cuenta" name="numero_cuenta" required autofocus>
            </div>
            <div class="form-group">
                <label for="clave">Contraseña:</label>
                <input type="password" id="clave" name="clave" required>
            </div>

            <button type="submit" class="btn">Ingresar</button>
        </form>
<?php require __DIR__ . '/_pie.php'; ?>
