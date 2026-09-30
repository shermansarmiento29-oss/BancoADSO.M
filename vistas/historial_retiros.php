<?php
$titulo = 'Historial de retiros';
$claseTarjeta = 'ancha';
require __DIR__ . '/_cabecera.php';
?>
        <?php if (empty($retiros)): ?>
            <p class="vacio">Aún no has hecho retiros.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr><th>Fecha</th><th class="valor">Valor</th></tr>
                </thead>
                <tbody>
                    <?php foreach ($retiros as $retiro): ?>
                        <tr>
                            <td><?= $e($retiro->fecha) ?></td>
                            <td class="valor"><?= $moneda($retiro->valor) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        <a class="volver" href="index.php?ruta=panel">Volver al panel</a>
<?php require __DIR__ . '/_pie.php'; ?>
