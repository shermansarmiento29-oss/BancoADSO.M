<?php
$titulo = 'Bienvenido, ' . $nombreCliente;
$claseTarjeta = 'ancha';
require __DIR__ . '/_cabecera.php';
?>
        <p>Cuenta N°: <strong><?= $e($numeroCuenta) ?></strong></p>

        <div class="saldo-box">
            <h3>Saldo disponible</h3>
            <p><?= $moneda($saldoActual) ?></p>
        </div>

        <div class="acciones">
            <a class="btn btn-verde" href="index.php?ruta=retiro">Retirar dinero</a>
            <a class="btn" href="index.php?ruta=transferencia">Transferir</a>
            <a class="btn" href="index.php?ruta=historial-retiros">Historial de retiros</a>
            <a class="btn" href="index.php?ruta=historial-transferencias">Historial de transferencias</a>
            <a class="btn btn-rojo" href="index.php?ruta=logout">Cerrar sesión</a>
        </div>
<?php require __DIR__ . '/_pie.php'; ?>
