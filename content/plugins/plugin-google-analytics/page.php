<?php

// Ruta al archivo settings.json
$settings_file = __DIR__ . '/settings.json';

// Verificar si el archivo settings.json existe, si no, crearlo
if (!file_exists($settings_file)) {
    file_put_contents($settings_file, json_encode([]));
}

// Manejar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Guardar el código de Google Analytics
    $settings = [
        'analytics_code' => $_POST['analytics_code'] ?? ''
    ];
    file_put_contents($settings_file, json_encode($settings));
    echo "<div class='ga-notice ga-success'>Configuración de Google Analytics guardada.</div>";
}

// Obtener el código de Google Analytics guardado
$settings = json_decode(file_get_contents($settings_file), true);
$analytics_code = $settings['analytics_code'] ?? '';

?>

<div class="ga-wrap" style="max-width: 800px; margin: 20px auto; background-color: #fff; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); border-radius: 8px;">
    <h1 style="text-align: center; color: #444;">Google Analytics</h1>
    <p style="text-align: center; color: #666;">Inserta el código de Google Analytics completo en el campo a continuación.</p>
    <form method="post">
        <table class="ga-form-table" style="width: 100%; margin-top: 20px;">
            <tr valign="top">
                <th scope="row" style="text-align: left; padding-bottom: 10px;">Código de Google Analytics</th>
                <td><textarea name="analytics_code" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: monospace; height: 150px;"><?php echo htmlspecialchars($analytics_code); ?></textarea></td>
            </tr>
        </table>
        <button type="submit" style="background-color: #28a745; color: #fff; border: none; padding: 10px 20px; font-size: 16px; border-radius: 4px; cursor: pointer; margin-top: 20px; width: 100%;">Guardar</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const notice = document.querySelector('.ga-notice');
        if (notice) {
            setTimeout(function() {
                notice.style.display = 'none';
            }, 3000);
        }
    });
</script>
