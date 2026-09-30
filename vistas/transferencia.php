<?php
$titulo = 'Transferir dinero';
require __DIR__ . '/_cabecera.php';
?>
        <form action="index.php?ruta=procesar-transferencia" method="POST">
            <?= $campoCsrf ?>

            <div class="form-group">
                <label for="cuenta_destino">Cuenta destino:</label>
                <input type="text" id="cuenta_destino" name="cuenta_destino" required autofocus>
            </div>
            <div class="form-group">
                <label for="valor">Monto a transferir:</label>
                <input type="number" step="0.01" min="0.01" id="valor" name="valor" required>
            </div>
            <div class="form-group">
                <label for="clave">Confirma tu contraseña:</label>
                <input type="password" id="clave" name="clave" required>
            </div>

            <button type="submit" class="btn">Realizar transferencia</button>
        </form>
        <a class="volver" href="index.php?ruta=panel">Volver al panel</a>
<?php require __DIR__ . '/_pie.php'; ?>
