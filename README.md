# Tienda de Guitarras

Pequeña aplicación PHP para gestionar productos y ventas (carrito, facturas, usuarios con roles).

## Resumen
- PHP + PDO (MySQL/MariaDB)
- Estructura: `public/` (puntos de entrada) y `src/` (vistas, controllers, includes)
- Autenticación por sesiones con roles (`user`, `admin`)
- Vistas principales: productos, compra, pedidos, crear/editar producto, login, register

---

## Requisitos
- PHP 7.4+ (extensión PDO + pdo_mysql)
- MySQL / MariaDB
- Servidor web o servidor embebido PHP

---

## Instalación rápida (Windows)

1. Clona o copia el proyecto en tu máquina.
2. Configura la conexión a la base de datos en:
   - `d:\Programación\Php\Proyecto USFA\tienda-guitarras\src\includes\db.php`
   - Ajusta host, dbname, usuario y contraseña.
3. Inicia el servidor embebido desde la carpeta `public`:
   - Abre PowerShell/Terminal en `d:\Programación\Php\Proyecto USFA\tienda-guitarras\public`
   - Ejecuta:
     ```
     php -S localhost:8000
     ```
   - Abre en el navegador: `http://localhost:8000`

> Nota: el archivo `src/includes/init_db.php` crea automáticamente las tablas necesarias (si no existen) al cargar la app. Asegúrate de que las credenciales en `db.php` permitan crear tablas.

---

## Credenciales admin por defecto (si se seed)
Si usas el seed incluido en `init_db.php`, por defecto puede crearse un admin inicial (cambia estas credenciales inmediatamente):
- Email: `admin@tudominio.com`
- Usuario: `admin`
- Contraseña: `admin123`  (CAMBIAR)

---

## Rutas / Vistas (enrutadas por `public/index.php`)
- `index.php?page=productos` — lista de productos (protegida si así está configurado)
- `index.php?page=compra` — confirmar compra (protegida)
- `index.php?page=pedidos` — lista de pedidos (solo admin)
- `index.php?page=create_product` — formulario crear producto (solo admin)
- `index.php?page=edit_product&id=ID` — editar producto (solo admin)
- `index.php?page=login` — iniciar sesión
- `index.php?page=register` — registrar usuario

Puntos de entrada (endpoints) en `public/`:
- `public/login.php` — procesar login (POST)
- `public/register.php` — procesar registro (POST)
- `public/logout.php` — cerrar sesión
- `public/create_product.php` — crear producto (POST, admin)
- `public/edit_product.php` — editar producto (POST, admin)
- `public/delete_product.php` — eliminar producto (POST, admin)
- `public/save_invoice.php` — guardar factura (POST)

---

## Autenticación y roles
- Al hacer login se setean en sesión:
  - `$_SESSION['user_id']`, `$_SESSION['username']`, `$_SESSION['role']`
- El enrutador (`public/index.php`) controla el acceso a páginas protegidas y redirige a `index.php?page=login` si no hay sesión o si el rol no permite acceso.
- Para mostrar/ocultar elementos en el header o vistas, se comprueba `$_SESSION['role']`.

---

## Guardar el autor del pedido
- La tabla `invoice` puede contener `user_id` y `user_name`. `save_invoice.php` toma el usuario de sesión (si existe) y guarda esos valores.
- En la vista `pedidos` se hace `LEFT JOIN` con `users` para mostrar el username cuando existe.

---

## Añadir/editar/eliminar productos (admin)
- Botón eliminar/editar aparece solo para admins.
- Eliminación usando `fetch()` a `public/delete_product.php` y eliminación visual inmediata si la petición es exitosa.
- Edición: vista `edit_product.php` y endpoint `public/edit_product.php`.

---

## Favicons
- Coloca los archivos en `public/img/`:
  - `favicon.svg`, `apple-touch-icon.png` y coloca `favicon.ico` en `public/`.
- Añade los enlaces en `<head>` (archivo `src/includes/header.php`).

---

## Errores comunes / Debug
- Warning `session_start(): Session cannot be started after headers have already been sent`:
  - Asegúrate de llamar `session_start()` en `public/index.php` antes de incluir `header.php` o emitir HTML.
  - No tener espacios, líneas en blanco ni BOM antes de `<?php` en ningún archivo incluido (usar UTF-8 sin BOM).
  - Alternativa temporal: `ob_start()` al inicio, pero mejor corregir el orden y BOM.
- Si `$_SESSION['username']` no aparece:
  - Verifica que `public/login.php` ejecute `session_start()` y que al autenticar escriba `$_SESSION['username']`.
  - Revisa cookies en el navegador.
- Problemas con rutas de archivos (imágenes, CSS): usar rutas relativas desde `public/` (por ejemplo `/css/styles.css`, `/img/...`).

---

## Estructura de archivos (resumen)
- public/
  - index.php (enrutador)
  - login.php, register.php, logout.php, create_product.php, edit_product.php, delete_product.php, save_invoice.php
  - css/, js/, img/
- src/
  - views/ (productos.php, compra.php, pedidos.php, create_product.php, edit_product.php, login.php, register.php)
  - controllers/
  - includes/ (db.php, init_db.php, header.php, footer.php)

---
