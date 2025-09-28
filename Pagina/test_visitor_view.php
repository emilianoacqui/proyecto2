<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test - Vista Visitante</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { 
            border: 2px solid #007cba; 
            margin: 20px 0; 
            padding: 20px; 
            border-radius: 8px;
        }
        .success { background: #d4edda; border-color: #28a745; }
        .error { background: #f8d7da; border-color: #dc3545; }
        .info { background: #d1ecf1; border-color: #17a2b8; }
        pre { background: #f8f9fa; padding: 10px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>
    <h1>🧪 Test de Vista Visitante</h1>
    
    <div class="test-section info">
        <h3>📋 Instrucciones de Prueba</h3>
        <ol>
            <li>Ve a <a href="index.php?cms_admin_token=true" target="_blank">index.php?cms_admin_token=true</a></li>
            <li>Haz clic en "✏️ Editar esta página"</li>
            <li>Modifica algún texto en las secciones principales (no solo footer)</li>
            <li>Haz clic en "💾 Guardar cambios"</li>
            <li>Ve a <a href="index.php" target="_blank">index.php</a> (sin token) - deberías ver los cambios</li>
        </ol>
    </div>

    <div class="test-section">
        <h3>🔍 Estado Actual del Sistema</h3>
        <?php
        require_once 'PagesManagerClass.php';
        
        function md5($str) {
            $hash = 0;
            if (strlen($str) == 0) return $hash;
            for ($i = 0; $i < strlen($str); $i++) {
                $char = ord($str[$i]);
                $hash = (($hash << 5) - $hash) + $char;
                $hash = $hash & $hash;
            }
            return abs($hash);
        }
        
        $manager = new PagesManager();
        $pages = $manager->getAllPages();
        $indexPage = null;
        
        foreach ($pages as $page) {
            if (isset($page['url']) && $page['url'] === 'index.php') {
                $indexPage = $page;
                break;
            }
        }
        
        if ($indexPage) {
            echo '<div class="success">';
            echo '<h4>✅ Página index.php encontrada</h4>';
            echo '<p><strong>Nombre:</strong> ' . htmlspecialchars($indexPage['name']) . '</p>';
            echo '<p><strong>ID:</strong> ' . htmlspecialchars($indexPage['id']) . '</p>';
            echo '<p><strong>Última modificación:</strong> ' . htmlspecialchars($indexPage['lastModified']) . '</p>';
            echo '<p><strong>Contenido guardado:</strong> ' . (strlen($indexPage['content']) > 0 ? 'Sí (' . strlen($indexPage['content']) . ' caracteres)' : 'No') . '</p>';
            echo '</div>';
        } else {
            echo '<div class="error">';
            echo '<h4>❌ No se encontró página index.php guardada</h4>';
            echo '<p>Esto significa que aún no has editado y guardado el index.</p>';
            echo '</div>';
        }
        ?>
    </div>

    <div class="test-section">
        <h3>🔧 Debugging</h3>
        <p>Si los cambios no se ven, abre la consola del navegador (F12) y busca estos mensajes:</p>
        <pre>
🔍 Buscando contenido para: index.php con ID: existing_[número]
✅ Contenido cargado del servidor
o
✅ Contenido cargado de localStorage: [nombre de página]
        </pre>
        
        <p><strong>Si ves "ℹ️ No se encontró contenido guardado":</strong> El contenido no se guardó correctamente.</p>
        <p><strong>Si ves los mensajes de carga pero no se muestra:</strong> Hay un problema con el CSS o el DOM.</p>
    </div>

    <div class="test-section">
        <h3>🚀 Enlaces de Prueba</h3>
        <p>
            <a href="index.php?cms_admin_token=true" target="_blank" style="background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;">Modo Admin</a>
            <a href="index.php" target="_blank" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; margin-left: 10px;">Modo Visitante</a>
        </p>
    </div>
</body>
</html>
