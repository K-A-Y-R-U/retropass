<?php

// Función para obtener URLs desde el sitio web
function get_urls_from_site($base_url) {
    $urls = [];
    $to_visit = [$base_url];
    $visited = [];

    while ($to_visit) {
        $current_url = array_shift($to_visit);

        if (in_array($current_url, $visited)) {
            continue;
        }

        $visited[] = $current_url;

        // Obtener contenido de la URL
        $content = @file_get_contents($current_url);
        if ($content === false) {
            continue;
        }

        // Extraer URLs
        preg_match_all('/<a\s+href=["\'](https?:\/\/[^"\']+)["\']/', $content, $matches);
        foreach ($matches[1] as $link) {
            if (strpos($link, $base_url) === 0 && !in_array($link, $urls)) {
                $urls[] = $link;
                $to_visit[] = $link;
            }
        }
    }

    return array_unique($urls);
}

// Guardar sitemap
function save_sitemap($urls) {
    $sitemap_content = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap_content .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $url) {
        $sitemap_content .= '<url>';
        $sitemap_content .= '<loc>' . htmlentities($url) . '</loc>';
        $sitemap_content .= '<changefreq>daily</changefreq>';
        $sitemap_content .= '<priority>0.8</priority>';
        $sitemap_content .= '</url>';
    }
    $sitemap_content .= '</urlset>';

    return file_put_contents(__DIR__ . '/sitemap-pl.xml', $sitemap_content);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generate_sitemap'])) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $base_url = $protocol . '://' . $host . '/';

    $urls = get_urls_from_site($base_url);

    if (empty($urls)) {
        echo '<div class="message error">No se encontraron URLs válidas.</div>';
    } else {
        if (save_sitemap($urls)) {
            echo '<div class="message success">Sitemap generado con éxito.</div>';
        } else {
            echo '<div class="message error">No se pudo guardar el archivo sitemap.</div>';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generador de Sitemap</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #007bff;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .message {
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Generador de Sitemap</h2>
        <form method="POST">
            <button type="submit" name="generate_sitemap">Generar Sitemap</button>
        </form>
    </div>
</body>
</html>
