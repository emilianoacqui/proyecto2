<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔍 GUÍA: Cómo Encontrar el Problema</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f0f0f0; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        .step { background: #e3f2fd; border-left: 4px solid #2196f3; padding: 15px; margin: 10px 0; }
        .critical { background: #ffebee; border-left: 4px solid #f44336; padding: 15px; margin: 10px 0; }
        .success { background: #e8f5e8; border-left: 4px solid #4caf50; padding: 15px; margin: 10px 0; }
        .code { background: #f5f5f5; padding: 10px; border-radius: 4px; font-family: monospace; margin: 10px 0; }
        .btn { background: #007cba; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; margin: 5px; }
        .btn:hover { background: #005a87; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .btn-warning { background: #ffc107; color: #000; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 GUÍA COMPLETA: Cómo Encontrar el Problema</h1>
        
        <div class="critical">
            <h3>🚨 PROBLEMA ACTUAL:</h3>
            <p>Pantalla en blanco en modo admin, pero funciona en modo visitante.</p>
            <p><strong>Tu objetivo:</strong> Encontrar exactamente qué está causando esto.</p>
        </div>

        <h2>📋 PASO A PASO - DIAGNÓSTICO MANUAL</h2>

        <div class="step">
            <h3>🔍 PASO 1: Abrir Herramientas de Desarrollador</h3>
            <ol>
                <li>Abre <code>index.php?cms_admin_token=true</code></li>
                <li>Presiona <strong>F12</strong> (o Ctrl+Shift+I)</li>
                <li>Ve a la pestaña <strong>"Console"</strong></li>
                <li><strong>¿Qué ves?</strong> Anota TODOS los mensajes</li>
            </ol>
        </div>

        <div class="step">
            <h3>🔍 PASO 2: Verificar Elementos DOM</h3>
            <p>En la consola, escribe estos comandos uno por uno:</p>
            <div class="code">
// Comando 1: Verificar si existen los elementos
console.log('cms-root:', document.getElementById('cms-root'));
console.log('original-content:', document.getElementById('original-content'));

// Comando 2: Verificar sus estilos
const cmsRoot = document.getElementById('cms-root');
const originalContent = document.getElementById('original-content');
console.log('cms-root display:', cmsRoot ? cmsRoot.style.display : 'No existe');
console.log('original-content display:', originalContent ? originalContent.style.display : 'No existe');

// Comando 3: Verificar clases del body
console.log('body classes:', document.body.className);
console.log('loading-cms-content:', document.body.classList.contains('loading-cms-content'));
            </div>
            <p><strong>¿Qué resultados obtienes?</strong> Anota cada uno.</p>
        </div>

        <div class="step">
            <h3>🔍 PASO 3: Verificar localStorage</h3>
            <p>En la consola, escribe:</p>
            <div class="code">
// Verificar localStorage
const savedPages = JSON.parse(localStorage.getItem('savedPages') || '[]');
console.log('Páginas guardadas:', savedPages);
console.log('Cantidad:', savedPages.length);

// Verificar si hay contenido para index.php
const currentUrl = 'index.php';
const pageId = 'existing_' + (currentUrl.split('').reduce((a,b)=>{a=((a<<5)-a)+b.charCodeAt(0);return a&a},0)).toString();
console.log('ID buscado:', pageId);
console.log('Página encontrada:', savedPages.find(page => page.id === pageId));
            </div>
            <p><strong>¿Qué ves?</strong> ¿Hay páginas guardadas? ¿Se encuentra la página?</p>
        </div>

        <div class="step">
            <h3>🔍 PASO 4: Verificar CSS</h3>
            <p>En la consola, escribe:</p>
            <div class="code">
// Verificar estilos CSS aplicados
const cmsRoot = document.getElementById('cms-root');
const originalContent = document.getElementById('original-content');

if (cmsRoot) {
    const cmsStyles = window.getComputedStyle(cmsRoot);
    console.log('cms-root CSS:', {
        display: cmsStyles.display,
        visibility: cmsStyles.visibility,
        opacity: cmsStyles.opacity,
        height: cmsStyles.height
    });
}

if (originalContent) {
    const originalStyles = window.getComputedStyle(originalContent);
    console.log('original-content CSS:', {
        display: originalStyles.display,
        visibility: originalStyles.visibility,
        opacity: originalStyles.opacity,
        height: originalStyles.height
    });
}
            </div>
            <p><strong>¿Qué valores obtienes?</strong> ¿Alguno está en "none" o "0"?</p>
        </div>

        <div class="step">
            <h3>🔍 PASO 5: Verificar JavaScript</h3>
            <p>En la consola, escribe:</p>
            <div class="code">
// Verificar si las funciones existen
console.log('loadSavedContent:', typeof loadSavedContent);
console.log('enableEditMode:', typeof enableEditMode);
console.log('saveChanges:', typeof saveChanges);

// Verificar si hay errores
console.log('Errores en la página:', window.onerror);
            </div>
            <p><strong>¿Las funciones existen?</strong> ¿Hay algún error?</p>
        </div>

        <div class="step">
            <h3>🔍 PASO 6: Verificar Red</h3>
            <ol>
                <li>Ve a la pestaña <strong>"Network"</strong> en DevTools</li>
                <li>Recarga la página (F5)</li>
                <li>Busca archivos que fallen (aparecen en rojo)</li>
                <li><strong>¿Hay algún archivo que falle?</strong> ¿Cuáles?</li>
            </ol>
        </div>

        <div class="step">
            <h3>🔍 PASO 7: Verificar Elementos</h3>
            <ol>
                <li>Ve a la pestaña <strong>"Elements"</strong> en DevTools</li>
                <li>Busca <code>&lt;div id="cms-root"&gt;</code></li>
                <li>Busca <code>&lt;div id="original-content"&gt;</code></li>
                <li><strong>¿Existen?</strong> ¿Tienen contenido?</li>
                <li>Haz clic derecho en cada uno → <strong>"Inspect"</strong></li>
                <li><strong>¿Qué estilos tienen aplicados?</strong></li>
            </ol>
        </div>

        <h2>🎯 INTERPRETAR RESULTADOS</h2>

        <div class="success">
            <h3>✅ SI VES ESTO, EL PROBLEMA ES:</h3>
            <ul>
                <li><strong>cms-root = null:</strong> El elemento no existe en el HTML</li>
                <li><strong>original-content = null:</strong> El elemento no existe en el HTML</li>
                <li><strong>display = "none":</strong> El CSS está ocultando el elemento</li>
                <li><strong>height = "0px":</strong> El elemento no tiene altura</li>
                <li><strong>Páginas guardadas = 0:</strong> No hay contenido guardado</li>
                <li><strong>Errores en Console:</strong> JavaScript está fallando</li>
            </ul>
        </div>

        <div class="critical">
            <h3>🚨 SOLUCIONES SEGÚN EL PROBLEMA:</h3>
            <ul>
                <li><strong>Elementos no existen:</strong> Problema en el HTML de index.php</li>
                <li><strong>CSS oculta elementos:</strong> Problema en los estilos CSS</li>
                <li><strong>JavaScript falla:</strong> Problema en cms-admin.js</li>
                <li><strong>No hay contenido:</strong> Problema en localStorage o servidor</li>
            </ul>
        </div>

        <h2>🔧 HERRAMIENTAS DE DIAGNÓSTICO</h2>

        <div style="margin-top: 20px;">
            <a href="DIAGNOSTICO_CRITICO.php" class="btn btn-success">🔍 Diagnóstico Automático</a>
            <a href="SOLUCION_INMEDIATA.php" class="btn btn-warning">🔧 Solución Inmediata</a>
            <a href="CMS_EMERGENCIA.php" class="btn btn-danger">🚨 CMS de Emergencia</a>
        </div>

        <div class="step">
            <h3>📝 FORMULARIO DE REPORTE</h3>
            <p>Después de hacer todos los pasos, anota:</p>
            <div class="code">
1. ¿Qué mensajes ves en Console?
2. ¿Existen cms-root y original-content?
3. ¿Qué estilos tienen aplicados?
4. ¿Hay páginas en localStorage?
5. ¿Hay errores en Network?
6. ¿Las funciones JavaScript existen?
            </div>
            <p><strong>Con esta información podré ayudarte exactamente.</strong></p>
        </div>
    </div>
</body>
</html>
