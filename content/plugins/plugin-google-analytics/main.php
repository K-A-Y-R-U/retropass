<?php

// Ruta al archivo settings.json
$settings_file = __DIR__ . '/settings.json';

// Verificar si el archivo settings.json existe, si no, retornar sin hacer nada
if (!file_exists($settings_file)) {
    return;
}

// Leer el contenido de settings.json
$settings = json_decode(file_get_contents($settings_file), true);

// Obtener el código de Google Analytics desde el archivo de configuración
$analytics_code = $settings['analytics_code'] ?? '';

// Si el código de Google Analytics está presente, lo insertamos en las páginas del sitio
if ($analytics_code) {
    echo "
    <!-- Google Analytics -->
    $analytics_code
    <!-- Fin de Google Analytics -->
    ";
}
