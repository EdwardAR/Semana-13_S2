-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-06-2025 a las 19:45:16
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `catalogo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `resumen` text DEFAULT NULL,
  `contenido_completo` text NOT NULL,
  `imagen_principal_url` varchar(255) DEFAULT NULL,
  `autor_nombre` varchar(150) DEFAULT NULL,
  `fecha_publicacion` date DEFAULT NULL,
  `mostrar_en_inicio` tinyint(1) DEFAULT 0,
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `titulo`, `resumen`, `contenido_completo`, `imagen_principal_url`, `autor_nombre`, `fecha_publicacion`, `mostrar_en_inicio`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Ideas para Propietarios de Primera Vivienda', 'Resumen de ideas para propietarios...', 'Contenido completo de ideas para propietarios...', 'images/post-1.jpg', 'Kristin Watson', '2021-12-19', 1, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46'),
(2, 'Cómo Mantener Tus Muebles Limpios', 'Resumen sobre limpieza de muebles...', 'Contenido completo sobre limpieza de muebles...', 'images/post-2.jpg', 'Robert Fox', '2021-12-15', 1, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46'),
(3, 'Ideas de Muebles para Apartamentos Pequeños', 'Resumen de ideas para apartamentos pequeños...', 'Contenido completo de ideas para apartamentos pequeños...', 'images/post-3.jpg', 'Kristin Watson', '2021-12-12', 1, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `price_at_addition` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL COMMENT 'URL amigable, autogenerado',
  `estado` enum('activo','inactivo','eliminado') NOT NULL DEFAULT 'activo',
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `nombre`, `slug`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Wisky', 'wisky', 'activo', '2025-06-15 04:46:16', '2025-06-15 04:46:31'),
(2, 'Vinos Tintos', 'vinos-tintos', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(3, 'Vinos Blancos', 'vinos-blancos', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(4, 'Cervezas Artesanales', 'cervezas-artesanales', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(5, 'Licores y Cremas', 'licores-cremas', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(6, 'Whiskies y Bourbons', 'whiskies-bourbons', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(7, 'Rones y Cachaças', 'rones-cachacas', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(8, 'Ginebras', 'ginebras', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(9, 'Vodkas', 'vodkas', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(10, 'Tequilas y Mezcales', 'tequilas-mezcales', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45'),
(11, 'Bebidas Sin Alcohol', 'bebidas-sin-alcohol', 'activo', '2025-06-15 05:59:45', '2025-06-15 05:59:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `logos`
--

CREATE TABLE `logos` (
  `id` int(11) NOT NULL,
  `nombre_referencia` varchar(100) NOT NULL COMMENT 'Ej: principal, favicon, admin_logo',
  `ruta_imagen` varchar(255) NOT NULL,
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `logos`
--

INSERT INTO `logos` (`id`, `nombre_referencia`, `ruta_imagen`, `estado`, `created_at`, `updated_at`) VALUES
(4, 'Principal', 'images/logos/d832f446d15b69e669a40e275ca5be7e.png', 'activo', '2025-06-14 11:42:07', '2025-06-14 11:43:04'),
(5, 'Navidad', 'images/logos/b798d6d7d4da505aaef1ec759e4556ce.png', 'activo', '2025-06-14 11:42:23', '2025-06-14 11:42:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `navbar_items`
--

CREATE TABLE `navbar_items` (
  `id` int(11) NOT NULL,
  `texto_visible` varchar(100) NOT NULL,
  `url_enlace` varchar(255) NOT NULL,
  `orden` int(11) DEFAULT 0,
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `navbar_items`
--

INSERT INTO `navbar_items` (`id`, `texto_visible`, `url_enlace`, `orden`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Inicio', 'index.php', 1, 'activo', '2025-06-10 06:25:45', '2025-06-14 11:35:45'),
(2, 'Tienda', 'shop.php', 2, 'activo', '2025-06-10 06:25:45', '2025-06-14 11:35:50'),
(3, 'Nosotros', 'about.php', 3, 'activo', '2025-06-10 06:25:45', '2025-06-14 11:35:54'),
(4, 'Servicios', 'services.php', 4, 'activo', '2025-06-10 06:25:45', '2025-06-14 11:35:59'),
(5, 'Blog', 'blog.php', 5, 'activo', '2025-06-10 06:25:45', '2025-06-14 11:36:03'),
(6, 'Contáctanos', 'contact.php', 6, 'eliminado', '2025-06-10 06:25:45', '2025-06-14 11:37:58'),
(7, 'Otros', 'http://localhost/catalogo/admin/otros.html', 3, 'activo', '2025-06-10 07:33:33', '2025-06-10 07:33:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `shipping_address` text NOT NULL,
  `order_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_at_order` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion_corta` text DEFAULT NULL,
  `descripcion_larga` text DEFAULT NULL,
  `precio` decimal(10,2) NOT NULL,
  `imagen_url` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `destacado_en_inicio` tinyint(1) DEFAULT 0,
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `category_id` int(11) DEFAULT NULL,
  `categoria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`id`, `nombre`, `descripcion_corta`, `descripcion_larga`, `precio`, `imagen_url`, `stock`, `destacado_en_inicio`, `estado`, `created_at`, `updated_at`, `category_id`, `categoria_id`) VALUES
(3, 'SANTA TERESA', 'Ron SANTA TERESA Solera 1796 Botella 750ml', 'Santa Teresa 1796, es un ron Súper Premium, audaz y elegante, hecho con una mezcla de rones desde 4 y hasta 35 años de envejecimiento en barricas de roble, a través del complejo proceso de añejamiento de Solera. El resultado es un ron suave, seco y balanceado que evoluciona en cada sorbo. Para realzar sus sabores, disfrútalo en vaso corto, con una roca de hielo, agua gasificada y un twist de naranja', 209.30, 'images/products/237480cb614f0870acffc0643fbcd36b.png', 50, 1, 'activo', '2025-06-10 06:25:46', '2025-06-15 18:23:34', NULL, 1),
(4, 'Vino Tinto Reserva Malbec', 'Elegante Malbec con notas de frutos rojos y roble.', 'Vino tinto de guarda, 12 meses en barrica. Intenso color rubí, aromas a ciruela, vainilla y chocolate. Ideal para carnes rojas y quesos maduros.', 18.50, 'images/products/4bdc743f510800f49050f73c695b22b3.jpg', 50, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:36:32', NULL, 1),
(5, 'Vino Blanco Sauvignon Blanc', 'Fresco y vibrante con toques cítricos y herbáceos.', 'Sauvignon Blanc joven, sin paso por madera. Aroma a pomelo, maracuyá y espárragos. Perfecto para pescados, mariscos y ensaladas.', 12.00, 'images/products/9c13431219f9b20645da7cbf4c3e643f.jpg', 60, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:37:04', NULL, 2),
(6, 'Cerveza IPA Artesanal', 'IPA lupulada con amargor equilibrado y aromas a pino.', 'Cerveza Indian Pale Ale, 6.5% ABV. Fermentada con lúpulos cítricos y resinosos. Marida con comida picante y hamburguesas.', 4.20, 'images/products/2121e8c42250c5cb71030328e0f85915.jpg', 120, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:36:55', NULL, 3),
(7, 'Licor Crema de Whisky', 'Suave crema irlandesa con toques de cacao y vainilla.', 'Delicioso licor de crema, ideal para disfrutar solo con hielo o en cócteles. Textura sedosa y dulzura equilibrada.', 25.00, 'images/products/01cb3cc57142fa8b6815cc78673653c4.jpg', 40, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:36:45', NULL, 4),
(8, 'Whisky Escocés Single Malt 12 Años', 'Single Malt clásico, notas ahumadas y dulzura de jerez.', 'Whisky de malta única, añejado 12 años en barricas de roble. Complejo, con toques de turba, fruta seca y especias.', 55.99, 'images/products/7abbf4e9b20712de89f30f44e0cb67ac.jpg', 30, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:36:21', NULL, 5),
(9, 'Ron Añejo Gran Reserva', 'Ron oscuro, profundo y sedoso, ideal para la coctelería.', 'Ron de melaza, añejado por más de 7 años en barricas. Notas de caramelo, vainilla, roble y especias. Perfecto para cócteles clásicos o solo.', 38.00, 'images/products/5d9981d3799841cd65c5c3022f5f6260.png', 45, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:36:13', NULL, 6),
(10, 'Ginebra Premium Botánica', 'Ginebra floral con un toque de pepino y rosa.', 'Ginebra destilada con botánicos selectos, incluyendo pétalos de rosa y pepino. Fresca y aromática, ideal para Gin Tonics elegantes.', 32.50, 'images/products/8e30437cfd82e6943772d9f1722045d7.jpg', 55, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:36:03', NULL, 7),
(11, 'Vodka Ultra Suave Triple Destilación', 'Vodka cristalino con un final limpio y sedoso.', 'Vodka de grano, destilado tres veces para una pureza excepcional. Sin impurezas, ideal para cócteles o solo muy frío.', 22.00, 'images/products/e39476a34138b7ae3b1d672bf21b186b.jpg', 70, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:35:37', NULL, 8),
(12, 'Tequila Reposado 100% Agave', 'Tequila de agave azul, suave y con toques de roble.', 'Tequila reposado durante 6 meses en barricas de roble. Ideal para margaritas o para beber a sorbos. Sabor auténtico a agave.', 42.00, 'images/products/df4e796410795d84022fa73a936da9ef.jpg', 35, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:35:28', NULL, 9),
(13, 'Cerveza Corono Cero sin Alcohol ', 'Lager refrescante y ligera, con todo el sabor.', 'Cerveza sin alcohol, ideal para cualquier momento del día. Sabor balanceado y final limpio. Perfecta para quienes buscan sabor sin alcohol.', 3.50, 'images/products/56eebf73a6cf8d412fb770b43f57e15a.jpg', 80, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:35:18', NULL, 4),
(14, 'Vino Rosado Seco Provenzal', 'Rosado pálido, aromas de fresa y cítricos.', 'Vino rosado ligero y seco, estilo Provenza. Fresco, con notas de frutas rojas y flores. Ideal como aperitivo o con ensaladas.', 15.00, 'images/products/82a39eda5812c8ec02d1238953c82271.jpg', 40, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:33:35', NULL, 1),
(15, 'Whisky Japonés Blended', 'Mezcla armoniosa de maltas y grano, delicado y complejo.', 'Whisky japonés de alta calidad, envejecido en barricas de roble. Notas de fruta, miel y un ligero ahumado. Muy equilibrado.', 65.00, 'images/products/027fa0e2ebe34c387f40ce1e89ba393b.jpg', 25, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:33:04', NULL, 5),
(16, 'Ron Blanco Caribeño Premium', 'Ron cristalino, perfecto para mojitos y daiquiris.', 'Ron destilado de melaza, sin añejar. Sabor limpio y notas sutiles de caña de azúcar. Base ideal para la coctelería tropical.', 28.00, 'images/products/ffc8af21b0b9aec2bbd17f609875d9ad.jpg', 50, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:32:34', NULL, 6),
(17, 'Cerveza Stout Irlandesa', 'Cerveza oscura con sabor a café y chocolate.', 'Stout de cuerpo completo, 4.5% ABV. Aroma a malta tostada, café y un toque de chocolate amargo. Ideal para acompañar postres o carnes estofadas.', 4.80, 'images/products/101064364428234b49c25f4e52f76eca.jpg', 90, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:31:54', NULL, 3),
(18, 'Licor de Hierbas Digestivo', 'Amargo tradicional con una mezcla de hierbas alpinas.', 'Licor digestivo elaborado con una selección de hierbas y raíces. Ideal para después de las comidas. Sabor intenso y complejo.', 20.00, 'images/products/1aec9b05f46cfc0ba1fdccc222a111d3.jpg', 30, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:25:31', NULL, 4),
(19, 'Ginebra Rosa Frutos Rojos', 'Ginebra vibrante con sabor natural a fresas y frambuesas.', 'Ginebra infusionada con frutos rojos, ofreciendo un sabor dulce y afrutado. Perfecta para cócteles con un toque veraniego.', 30.00, 'images/products/8fc6bcbe2fdba58243441f09e02d72c8.jpg', 48, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:22:59', NULL, 7),
(20, 'Vino Espumoso Brut Cava', 'Cava tradicional, burbujas finas y refrescantes.', 'Vino espumoso Brut, método tradicional. Aromas a manzana verde y pan tostado. Ideal para celebraciones y aperitivos.', 16.00, 'images/products/31d4444182fff1a242042fded0488e2f.jpg', 55, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:22:09', NULL, 2),
(21, 'Mezcal Joven Artesanal', 'Mezcal ahumado con un perfil mineral y herbal.', 'Mezcal de agave Espadín, cocido en horno cónico de piedra y destilado en alambique de cobre. Notas ahumadas, tierra mojada y frutas maduras. Ideal para beber solo.', 49.99, 'images/products/ed5763b1d1cd7e3373a3b5c43c4cdb00.jpg', 28, 0, 'activo', '2025-06-15 11:02:24', '2025-06-15 18:21:18', NULL, 9),
(22, 'Sidra de Manzana sin Alcohol', 'Sidra dulce y refrescante, ideal para toda la familia.', 'Bebida carbonatada a base de zumo de manzana fresco. Sin alcohol, perfecta como alternativa refrescante. Servir fría.', 3.00, 'images/products/79dde89df683021dd672268716dc370a.jpg', 100, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 19:13:43', NULL, 10),
(23, 'Whisky Bourbon Americano', 'Bourbon de maíz, suave con notas de vainilla y caramelo.', 'Whisky de Kentucky, añejado en barricas de roble carbonizado. Dulce, con toques de vainilla, caramelo y especias. Para beber solo o en cócteles como el Old Fashioned.', 39.50, 'images/products/13aa17a35cdbcf9afb4b506c66b5c59d.jpg', 38, 1, 'activo', '2025-06-15 11:02:24', '2025-06-15 17:53:06', NULL, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `section_content`
--

CREATE TABLE `section_content` (
  `id` int(11) NOT NULL,
  `identificador_seccion` varchar(100) NOT NULL COMMENT 'Ej: we_help_index, product_section_intro_index',
  `titulo` varchar(255) DEFAULT NULL,
  `parrafo_principal` text DEFAULT NULL,
  `imagen_1_url` varchar(255) DEFAULT NULL,
  `imagen_2_url` varchar(255) DEFAULT NULL,
  `imagen_3_url` varchar(255) DEFAULT NULL,
  `texto_boton` varchar(50) DEFAULT NULL,
  `url_boton` varchar(255) DEFAULT NULL,
  `list_items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Para listas de características, almacenadas como array de strings JSON' CHECK (json_valid(`list_items`)),
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `section_content`
--

INSERT INTO `section_content` (`id`, `identificador_seccion`, `titulo`, `parrafo_principal`, `imagen_1_url`, `imagen_2_url`, `imagen_3_url`, `texto_boton`, `url_boton`, `list_items`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'product_section_intro_index', 'Fabricado con excelente material.', 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique.', NULL, NULL, NULL, 'Explorar', 'shop.html', NULL, 'activo', '2025-06-10 06:25:45', '2025-06-10 06:25:45'),
(2, 'we_help_index', 'Te Ayudamos a Crear Diseños de Interiores Modernos', 'Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada', 'images/img-grid-1.jpg', 'images/img-grid-2.jpg', 'images/img-grid-3.jpg', 'Explorar', '#', '[\"Donec vitae odio quis nisl dapibus malesuada\", \"Donec vitae odio quis nisl dapibus malesuada\", \"Donec vitae odio quis nisl dapibus malesuada\", \"Donec vitae odio quis nisl dapibus malesuada\"]', 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `slider_items`
--

CREATE TABLE `slider_items` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` text NOT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `texto_boton_1` varchar(100) DEFAULT NULL,
  `url_boton_1` varchar(255) DEFAULT NULL,
  `texto_boton_2` varchar(100) DEFAULT NULL,
  `url_boton_2` varchar(255) DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `slider_items`
--

INSERT INTO `slider_items` (`id`, `titulo`, `subtitulo`, `imagen`, `texto_boton_1`, `url_boton_1`, `texto_boton_2`, `url_boton_2`, `orden`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Bienvenido a Furni', 'Descubre la comodidad y el estilo para tu hogar con nuestra exclusiva colección de muebles. Tu espacio, tu esencia.', 'images/sliders/feaf967df6d35e8b645f829e86a8b631.jpg', 'Explorar Ahora', 'shop.php', 'Conócenos', 'about.php', 1, 'inactivo', '2025-06-14 12:48:14', '2025-06-19 08:03:36'),
(2, 'Oferta Especial de Primavera', 'Renueva tu sala con descuentos increíbles en sofás y sillones. ¡No te lo pierdas!', 'images/sliders/fd72f313a3abced4c4d4d8bcc591c32e.png', 'Ver Ofertas', 'shop.php', 'WhatsApp', 'contact.php', 2, 'activo', '2025-06-14 12:48:14', '2025-06-14 14:13:22'),
(3, 'Diseño Minimalista para tu Hogar', 'Líneas limpias y funcionalidad en cada pieza. Crea un ambiente sereno y moderno.', 'images/sliders/9f6e1d1a7e0a6a51a0d51b5cce80d288.png', 'Descubrir Estilo', 'shop.php?style=minimalista', 'Blog de Diseño', 'blog.php', 3, 'activo', '2025-06-14 12:48:14', '2025-06-14 14:15:10'),
(4, 'Nueva Colección de Dormitorios', 'Transforma tu descanso con nuestras camas y mesas de noche de diseño. Confort y elegancia asegurados.', 'images/sliders/b63d1faa44dc0775b0464d8b8f8ad57b.png', 'Comprar Ahora', 'shop.php?category=dormitorios', '', '', 4, 'activo', '2025-06-14 12:48:14', '2025-06-14 13:17:58'),
(5, 'Inspiración para tu Oficina en Casa', 'Muebles ergonómicos y estéticos para potenciar tu productividad y bienestar.', 'images/sliders/7c5bc98fe0055276619de090896e9d64.png', 'Ver Productos', 'shop.php?category=oficina', 'Contáctanos', 'contact.php', 5, 'activo', '2025-06-14 12:48:14', '2025-06-14 14:15:22'),
(6, 'Accesorios que Marcan la Diferencia', 'Pequeños detalles que elevan el estilo de cualquier rincón de tu casa.', 'images/sliders/64cfa66fa96814450806b1ad8a6f8b99.png', 'Comprar Accesorios', 'shop.php?category=accesorios', '', '', 60, 'activo', '2025-06-14 12:48:14', '2025-06-14 12:59:32');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `testimonials`
--

CREATE TABLE `testimonials` (
  `id` int(11) NOT NULL,
  `nombre_autor` varchar(150) NOT NULL,
  `cargo_autor` varchar(150) DEFAULT NULL,
  `imagen_autor_url` varchar(255) DEFAULT NULL,
  `testimonio_texto` text NOT NULL,
  `orden` int(11) DEFAULT 0,
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `testimonials`
--

INSERT INTO `testimonials` (`id`, `nombre_autor`, `cargo_autor`, `imagen_autor_url`, `testimonio_texto`, `orden`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Maria Jones', 'CEO, Co-Fundadora, XYZ Inc.', 'images/person-1.png', 'Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Integer convallis volutpat dui quis scelerisque.', 1, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `why_choose_us_items`
--

CREATE TABLE `why_choose_us_items` (
  `id` int(11) NOT NULL,
  `icono_svg_nombre` varchar(100) DEFAULT NULL COMMENT 'Nombre del archivo SVG en images/ o clase de FontAwesome',
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `orden` int(11) DEFAULT 0,
  `estado` enum('activo','inactivo','eliminado') DEFAULT 'activo',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `why_choose_us_items`
--

INSERT INTO `why_choose_us_items` (`id`, `icono_svg_nombre`, `titulo`, `descripcion`, `orden`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'truck.svg', 'Envío Rápido y Gratis', 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.', 1, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46'),
(2, 'bag.svg', 'Fácil de Comprar', 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.', 2, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46'),
(3, 'support.svg', 'Soporte 24/7', 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.', 3, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46'),
(4, 'return.svg', 'Devoluciones Sin Problemas', 'Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.', 4, 'activo', '2025-06-10 06:25:46', '2025-06-10 06:25:46');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cart_item_cart` (`cart_id`),
  ADD KEY `fk_cart_item_product` (`product_id`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD UNIQUE KEY `idx_slug` (`slug`),
  ADD KEY `idx_estado` (`estado`);

--
-- Indices de la tabla `logos`
--
ALTER TABLE `logos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_referencia` (`nombre_referencia`);

--
-- Indices de la tabla `navbar_items`
--
ALTER TABLE `navbar_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_order_item_order` (`order_id`),
  ADD KEY `fk_order_item_product` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_category` (`category_id`),
  ADD KEY `fk_product_category` (`categoria_id`);

--
-- Indices de la tabla `section_content`
--
ALTER TABLE `section_content`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identificador_seccion` (`identificador_seccion`);

--
-- Indices de la tabla `slider_items`
--
ALTER TABLE `slider_items`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `why_choose_us_items`
--
ALTER TABLE `why_choose_us_items`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `logos`
--
ALTER TABLE `logos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `navbar_items`
--
ALTER TABLE `navbar_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `section_content`
--
ALTER TABLE `section_content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `slider_items`
--
ALTER TABLE `slider_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `why_choose_us_items`
--
ALTER TABLE `why_choose_us_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `fk_cart_item_cart` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cart_item_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_item_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_order_item_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`categoria_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
