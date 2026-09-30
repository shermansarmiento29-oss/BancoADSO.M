<?php
$titulo = 'Historial de transferencias';
$claseTarjeta = 'ancha';
require __DIR__ . '/_cabecera.php';
?>
        <?php if (empty($transferencias)): ?>
            <p class="vacio">Aún no has hecho transferencias.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr><th>Fecha</th><th>Cuenta destino</th><th class="valor">Valor</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($transferencias as $t): ?>
                        <tr>
                            <td><?= $e($t->fecha) ?></td>
                            <td><?= $e($t->numero_cuenta_destino) ?></td>
                            <td class="valor"><?= $moneda($t->valor) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a class="volver" href="index.php?ruta=panel">Volver al panel</a>
<?php require __DIR__ . '/_pie.php'; ?>
