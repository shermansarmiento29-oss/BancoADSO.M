<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Banco ADSO - <?= $e($titulo ?? '') ?></title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <main class="tarjeta <?= $e($claseTarjeta ?? '') ?>">
        <h2><?= $e($titulo ?? '') ?></h2>

        <?php if (!empty($flash)): ?>
            <div class="mensaje <?= $e($flash['tipo']) ?>"><?= $e($flash['texto']) ?></div>
        <?php endif; ?>
