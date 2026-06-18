# Licorería Don Lucho - E-Commerce

Sistema de comercio electrónico para la **Licorería Don Lucho**, desarrollado en PHP nativo con Bootstrap 5. Permite gestionar productos, categorías, sliders, navbar, logos, pedidos y testimonios desde un panel administrativo, con carrito de compras persistente y pedidos vía WhatsApp.

---

## Tecnologías

| Tecnología | Versión | Uso |
|---|---|---|
| **PHP** | 7.4+ / 8.x | Backend, lógica del negocio, API REST |
| **MySQL / MariaDB** | 5.7+ / 10.4+ | Base de datos relacional |
| **Bootstrap** | 5.x | Framework CSS responsivo |
| **Tiny Slider 2** | 2.x | Carruseles (slider heroico, testimonios) |
| **Font Awesome 6** | 6.0 beta | Íconos vectoriales |
| **PDO** | - | Conexión segura a la base de datos |
| **localStorage** | - | Persistencia del carrito de compras |
| **AJAX** | - | Operaciones CRUD en el panel admin |

---

## Funcionalidades

### Cliente (Frontend)

| Página | Descripción |
|---|---|
| **Inicio** (`index.php`) | Slider heroico dinámico, productos destacados, sección "Por qué elegirnos", testimonios, preview del blog |
| **Tienda** (`shop.php`) | Catálogo completo de productos con precios y carrito |
| **Producto** (`product-single.php`) | Detalle del producto (descripción, precio, stock, categoría) |
| **Carrito** (`cart.php`) | Resumen del carrito con cantidades, totales y botón de WhatsApp |
| **Checkout** (`checkout.php`) | Formulario de facturación con datos de envío y métodos de pago |
| **Nosotros** (`about.php`) | Información de la empresa, equipo, valores y testimonios |
| **Servicios** (`services.php`) | Servicios ofrecidos y testimonios de clientes |
| **Blog** (`blog.php`) | Artículos sobre vinos, licores, coctelería y maridajes |
| **Contacto** (`contact.php`) | Información de contacto, dirección y formulario |

### Administración (Panel Admin)

| Sección | Descripción |
|---|---|
| **Dashboard** (`admin/dashboard.php`) | Panel principal con acceso rápido a todas las secciones |
| **Productos** (`admin/gestion_productos.php`) | CRUD completo: crear, editar, eliminar, cambiar estado, subir imágenes |
| **Categorías** (`admin/gestion_categorias.php`) | Gestión de categorías de productos |
| **Navbar** (`admin/gestion_navbar.php`) | Menú de navegación: agregar, editar, reordenar enlaces |
| **Slider** (`admin/gestion_slider.php`) | Slides del inicio: imágenes, títulos, botones |
| **Logos** (`admin/gestion_logos.php`) | Logotipos de la marca |
| **Pedidos** (`admin/gestion_pedidos.php`) | Lista de pedidos con cambio de estado (pendiente, procesando, enviado, entregado, cancelado) |

### Carrito de Compras

- Persistencia en **localStorage** (no requiere inicio de sesión)
- Agregar / quitar productos desde tienda y productos destacados
- Ajuste de cantidades en la página del carrito
- Cálculo automático de subtotal y total
- Pedido vía **WhatsApp** con resumen del carrito
- Envío opcional de los datos del pedido al servidor (`admin/api/orders_create.php`)

---

## Instalación

### 1. Requisitos

- XAMPP / WAMP / LAMP con PHP 7.4+ y MySQL 5.7+
- Apache con mod_rewrite (opcional)
- Navegador web moderno

### 2. Clonar o copiar el proyecto

```bash
# En la carpeta htdocs de XAMPP (o www de WAMP)
git clone <repo-url>
# O simplemente copia la carpeta del proyecto
```

### 3. Configurar la base de datos

1. Abre **phpMyAdmin** (`http://localhost/phpmyadmin`)
2. Crea una nueva base de datos llamada **`catalogo`** (utf8mb4_unicode_ci)
3. Importa el archivo `catalogo.sql` (pestaña "Importar")
4. Verifica que se crearon las 13 tablas

### 4. Configurar la conexión

El archivo `admin/api/db_config.php` ya viene configurado para:
```
Host: localhost
Base de datos: catalogo
Usuario: root
Contraseña: (vacío)
```

Si usas credenciales diferentes, edita ese archivo.

### 5. Iniciar el servidor

En XAMPP:
1. Enciende **Apache** y **MySQL**
2. Abre en tu navegador: `http://localhost/SOA_SEM13s2/`

### 6. Contenido inicial (opcional)

Ejecuta el script `fix_slider.php` desde el navegador para actualizar los sliders con contenido de licorería:

```
http://localhost/SOA_SEM13s2/fix_slider.php
```

**Luego elimina el archivo `fix_slider.php` del servidor.**

---

## Estructura del proyecto

```
SOA_SEM13s2/
├── index.php                # Página principal
├── shop.php                 # Tienda / catálogo
├── product-single.php       # Detalle de producto
├── cart.php                 # Carrito de compras
├── checkout.php             # Página de pago
├── thankyou.php             # Confirmación de pedido
├── about.php                # Nosotros
├── services.php             # Servicios
├── blog.php                 # Blog
├── contact.php              # Contacto
├── header.php               # Cabecera / navbar (incluido en todas las páginas)
├── footer.php               # Pie de página (incluido en todas las páginas)
├── fix_slider.php           # Script de migración (eliminar después de usar)
│
├── admin/
│   ├── dashboard.php        # Panel principal
│   ├── gestion_productos.php
│   ├── gestion_categorias.php
│   ├── gestion_navbar.php
│   ├── gestion_slider.php
│   ├── gestion_logos.php
│   ├── gestion_pedidos.php
│   ├── otros.php
│   └── api/                 # Endpoints AJAX (28 archivos)
│       ├── db_config.php
│       ├── productos_*.php
│       ├── categorias_*.php
│       ├── navbar_*.php
│       ├── slider_*.php
│       ├── logos_*.php
│       ├── orders_*.php
│       └── cart_*.php
│
├── css/
│   ├── bootstrap.min.css
│   ├── style.css            # Estilos personalizados
│   └── tiny-slider.css
│
├── js/
│   ├── bootstrap.bundle.min.js
│   ├── custom.js            # Lógica del carrito, sliders, WhatsApp
│   └── tiny-slider.js
│
├── images/
│   ├── products/            # Imágenes de productos (21 archivos)
│   ├── sliders/             # Imágenes de sliders (22 archivos)
│   ├── logos/               # Logotipos
│   └── *.svg / *.png / *.jpg
│
├── scss/
│   └── style.scss           # Fuente SCSS de style.css
│
└── catalogo.sql             # Exportación completa de la BD
```

---

## Base de datos

### Tablas principales

| Tabla | Descripción |
|---|---|
| `products` | Catálogo de productos (21 registros semilla) |
| `categories` | Categorías (11 registros: Wisky, Vinos Tintos, Cervezas Artesanales, etc.) |
| `slider_items` | Slides del carrusel principal (6 registros) |
| `testimonials` | Testimonios de clientes |
| `navbar_items` | Enlaces del menú de navegación |
| `logos` | Logotipos de la marca |
| `blog_posts` | Artículos del blog |
| `orders` | Pedidos realizados |
| `order_items` | Productos dentro de cada pedido |
| `carts` / `cart_items` | Carritos de compra (lado servidor) |
| `section_content` | Contenido dinámico de secciones |
| `why_choose_us_items` | Tarjetas "Por qué elegirnos" |

### SQL útil

**Actualizar sliders con contenido de licorería:**
```sql
UPDATE slider_items SET
  titulo='Colección Premium de Whiskies',
  subtitulo='Descubre los mejores whiskies escoceses, irlandeses y japoneses.',
  imagen='images/products/237480cb614f0870acffc0643fbcd36b.png',
  texto_boton_1='Ver Colección',
  url_boton_1='shop.php'
WHERE id=2;
-- Repetir para ids 3, 4, 5, 6 con diferentes contenidos
```

**Actualizar testimonios con reseñas reales:**
```sql
UPDATE testimonials SET
  testimonio_texto='Excelente atención y la mejor selección de licores.',
  nombre_autor='Carlos Mendoza',
  cargo_autor='Cliente frecuente',
  imagen_autor_url='https://randomuser.me/api/portraits/men/32.jpg'
WHERE id=1;
```

---

## Personalización

### Estilos

- El archivo principal de estilos es `css/style.css`
- La fuente SCSS está en `scss/style.scss`
- Variables de color principales (en SCSS):
  - `$primary: #3b5d50` (verde oscuro)
  - `$secondary: #f9bf29` (dorado)
  - `$dark: #2f2f2f`
  - Font: `Inter`

### Navbar

Los elementos del menú de navegación se administran desde:
```
http://localhost/SOA_SEM13s2/admin/gestion_navbar.php
```

Cada elemento tiene: texto visible, URL, orden y estado (activo/inactivo).

### Slider del inicio

Los slides se administran desde:
```
http://localhost/SOA_SEM13s2/admin/gestion_slider.php
```

Cada slide tiene: título, subtítulo, imagen, texto de botones y enlaces.

---

## API endpoints (AJAX)

Todas las operaciones CRUD del panel admin se realizan mediante peticiones AJAX a los archivos en `admin/api/`:

| Endpoint | Método | Función |
|---|---|---|
| `productos_leer.php` | GET | Listar productos |
| `productos_crear_editar.php` | POST | Crear / editar producto |
| `productos_cambiar_estado.php` | POST | Activar / desactivar / eliminar |
| `productos_eliminar_fisico.php` | POST | Eliminar definitivamente |
| `categorias_leer.php` | GET | Listar categorías |
| `categorias_crear_editar.php` | POST | Crear / editar categoría |
| `categorias_cambiar_estado.php` | POST | Cambiar estado |
| `navbar_leer.php` | GET | Listar ítems del menú |
| `navbar_crear_editar.php` | POST | Crear / editar ítem |
| `navbar_cambiar_estado.php` | POST | Cambiar estado |
| `slider_leer.php` | GET | Listar slides |
| `slider_crear_editar.php` | POST | Crear / editar slide |
| `slider_cambiar_estado.php` | POST | Cambiar estado |
| `slider_eliminar_fisico.php` | POST | Eliminar slide + imagen |
| `logos_leer.php` | GET | Listar logos |
| `logos_crear_editar.php` | POST | Subir / editar logo |
| `logos_cambiar_estado.php` | POST | Cambiar estado |
| `logos_eliminar_fisico.php` | POST | Eliminar logo |
| `orders_read.php` | GET | Listar pedidos |
| `orders_read_single.php` | GET | Detalle de un pedido |
| `orders_create.php` | POST | Crear pedido |
| `orders_update_status.php` | POST | Actualizar estado |
| `cart_add.php` | POST | Agregar al carrito |
| `cart_read.php` | GET | Leer carrito |
| `cart_remove.php` | POST | Quitar del carrito |
| `cart_update.php` | POST | Actualizar cantidad |

---

## Créditos

- **Template original:** Furni de Untree.co (adaptado a licorería)
- **Framework CSS:** Bootstrap 5
- **Carruseles:** Tiny Slider 2
- **Íconos:** Font Awesome 6
- **Fotos de personas:** Random User Generator (randomuser.me)
- **Imágenes de productos:** Catálogo real de productos

---

## Licencia

Proyecto de código abierto para fines educativos y comerciales.
