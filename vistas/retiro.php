<?php
$titulo = 'Realizar retiro';
require __DIR__ . '/_cabecera.php';
?>
        <form action="index.php?ruta=procesar-retiro" method="POST">
            <?= $campoCsrf ?>

            <div class="form-group">
                <label for="valor">Monto a retirar:</label>
                <input type="number" step="0.01" min="0.01" id="valor" name="valor" required autofocus>
            </div>
            <div class="form-group">
                <label for="clave">Confirma tu contraseña:</label>
                <input type="password" id="clave" name="clave" required>
            </div>

            <button type="submit" class="btn btn-verde">Confirmar retiro</button>
        </form>
        <a class="volver" href="index.php?ruta=panel">Volver al panel</a>
<?php require __DIR__ . '/_pie.php'; ?>
