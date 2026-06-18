<?php
// One-time script: updates DB records for liquor theme
// Run from browser, then DELETE this file.

require_once __DIR__ . '/admin/api/db_config.php';

echo "<h2>Actualizando contenido de la base de datos</h2>";

// ── 1. Slider items ──
echo "<h3>Sliders</h3><ul>";
$slider_updates = [
    ['id' => 2, 'titulo' => 'Colección Premium de Whiskies', 'subtitulo' => 'Descubre los mejores whiskies escoceses, irlandeses y japoneses. Importados directamente para ti.', 'imagen' => 'images/products/237480cb614f0870acffc0643fbcd36b.png', 'texto_boton_1' => 'Ver Colección', 'url_boton_1' => 'shop.php', 'texto_boton_2' => 'Más Info', 'url_boton_2' => 'about.php'],
    ['id' => 3, 'titulo' => 'Vinos Seleccionados', 'subtitulo' => 'De la bodega a tu copa. Vinos tintos, blancos y espumantes de las mejores regiones vitivinícolas.', 'imagen' => 'images/products/4bdc743f510800f49050f73c695b22b3.jpg', 'texto_boton_1' => 'Comprar Vinos', 'url_boton_1' => 'shop.php', 'texto_boton_2' => 'Catálogo', 'url_boton_2' => 'shop.php'],
    ['id' => 4, 'titulo' => 'Cócteles y Mixología', 'subtitulo' => 'Prepárate para sorprender con los mejores licores y accesorios para coctelería. Tu bar en casa.', 'imagen' => 'images/products/01cb3cc57142fa8b6815cc78673653c4.jpg', 'texto_boton_1' => 'Ver Productos', 'url_boton_1' => 'shop.php', 'texto_boton_2' => 'Recetas', 'url_boton_2' => 'blog.php'],
    ['id' => 5, 'titulo' => 'Cervezas Artesanales', 'subtitulo' => 'Explora nuestra selección de cervezas artesanales nacionales e importadas. Sabores únicos.', 'imagen' => 'images/products/2121e8c42250c5cb71030328e0f85915.jpg', 'texto_boton_1' => 'Comprar Ahora', 'url_boton_1' => 'shop.php', 'texto_boton_2' => 'Contáctanos', 'url_boton_2' => 'contact.php'],
    ['id' => 6, 'titulo' => 'Envíos a Domicilio', 'subtitulo' => 'Recibe tus licores favoritos sin salir de casa. Seguro, rápido y discreto. Entregamos a todo Lima.', 'imagen' => 'images/products/ed5763b1d1cd7e3373a3b5c43c4cdb00.jpg', 'texto_boton_1' => 'Hacer Pedido', 'url_boton_1' => 'shop.php', 'texto_boton_2' => 'WhatsApp', 'url_boton_2' => 'https://wa.me/51987654321'],
];

$stmt_slider = $pdo->prepare("UPDATE slider_items SET titulo=:titulo, subtitulo=:subtitulo, imagen=:imagen, texto_boton_1=:texto_boton_1, url_boton_1=:url_boton_1, texto_boton_2=:texto_boton_2, url_boton_2=:url_boton_2 WHERE id=:id");
foreach ($slider_updates as $item) {
    try {
        $stmt_slider->execute($item);
        echo "<li style='color:green;'>✓ Slide #{$item['id']}: \"{$item['titulo']}\"</li>";
    } catch (PDOException $e) {
        echo "<li style='color:red;'>✗ Slide #{$item['id']}: " . $e->getMessage() . "</li>";
    }
}
echo "</ul>";

// ── 2. Testimonials ──
echo "<h3>Testimonios</h3><ul>";
try {
    $stmt_test = $pdo->prepare("UPDATE testimonials SET nombre_autor='Carlos Mendoza', cargo_autor='Cliente frecuente', testimonio_texto='Excelente servicio y atención personalizada. Me ayudaron a elegir el whisky perfecto para mi evento. Muy recomendados.', imagen_autor_url=NULL WHERE id=1");
    $stmt_test->execute();
    echo "<li style='color:green;'>✓ Testimonio #1 actualizado</li>";
} catch (PDOException $e) {
    echo "<li style='color:red;'>✗ Testimonio: " . $e->getMessage() . "</li>";
}

try {
    $pdo->prepare("INSERT IGNORE INTO testimonials (id, nombre_autor, cargo_autor, testimonio_texto, orden, estado) VALUES (2, 'María Fernanda López', 'Cliente verificada', 'La mejor selección de vinos que he encontrado en Lima. Entregas rápidas y productos de primera calidad.', 2, 'activo')")->execute();
    echo "<li style='color:green;'>✓ Testimonio #2 insertado</li>";
} catch (PDOException $e) {
    echo "<li style='color:red;'>✗ Testimonio #2: " . $e->getMessage() . "</li>";
}

try {
    $pdo->prepare("INSERT IGNORE INTO testimonials (id, nombre_autor, cargo_autor, testimonio_texto, orden, estado) VALUES (3, 'Andrés Rivera', 'Socio Premium', 'Gran variedad de cervezas artesanales y precios inmejorables. Sin duda mi licorería de confianza.', 3, 'activo')")->execute();
    echo "<li style='color:green;'>✓ Testimonio #3 insertado</li>";
} catch (PDOException $e) {
    echo "<li style='color:red;'>✗ Testimonio #3: " . $e->getMessage() . "</li>";
}
echo "</ul>";

// ── 3. Section Content ──
echo "<h3>Secciones de contenido</h3><ul>";
try {
    $stmt_sec = $pdo->prepare("UPDATE section_content SET titulo='Productos Destacados', parrafo_principal='Descubre nuestra selección de vinos, whiskies y licores premium cuidadosamente elegidos para ti.', url_boton='shop.php' WHERE id=1");
    $stmt_sec->execute();
    echo "<li style='color:green;'>✓ Section #1 (product_section_intro) actualizada</li>";
} catch (PDOException $e) {
    echo "<li style='color:red;'>✗ Section #1: " . $e->getMessage() . "</li>";
}

try {
    $stmt_sec2 = $pdo->prepare("UPDATE section_content SET titulo='¿Por qué elegirnos?', parrafo_principal='Somos tu licorería de confianza con la mejor selección de marcas nacionales e importadas, atención personalizada y entregas rápidas.', imagen_1_url='images/products/4bdc743f510800f49050f73c695b22b3.jpg', imagen_2_url='images/products/01cb3cc57142fa8b6815cc78673653c4.jpg', imagen_3_url='images/products/2121e8c42250c5cb71030328e0f85915.jpg', url_boton='shop.php' WHERE id=2");
    $stmt_sec2->execute();
    echo "<li style='color:green;'>✓ Section #2 (we_help) actualizada</li>";
} catch (PDOException $e) {
    echo "<li style='color:red;'>✗ Section #2: " . $e->getMessage() . "</li>";
}
echo "</ul>";

echo "<p><strong>¡Todo listo!</strong> Elimina este archivo <code>fix_slider.php</code> del servidor.</p>";
