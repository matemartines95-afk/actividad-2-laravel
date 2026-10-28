# Actividad 2 — Migración e integración con Laravel

**Curso:** 3.º ME — Programación Full Stack  
**Objetivo:** migrar el sistema PHP MVC a Laravel, conservar registro/login/perfil y persistir usuarios en MySQL.

## Qué incluye
- Rutas web con nombres.
- `UsuarioController` para registro, autenticación, perfil, actualización y logout.
- Modelo `User` con asignación masiva controlada y contraseña oculta.
- Migración para añadir `edad` a `users`.
- Vistas Blade de registro, login y perfil con Bootstrap.
- `fetch()` para registrar, iniciar sesión y actualizar el perfil sin recargar para mostrar mensajes.
- Pruebas automatizadas de los flujos principales.
- Esta documentación de instalación.

> Este paquete contiene los archivos de la actividad para copiar en un proyecto Laravel nuevo. No contiene `vendor/` ni todo el framework: se generan con Composer siguiendo los pasos de abajo.

## 1. Crear el proyecto
Desde la terminal de Visual Studio Code, en la carpeta donde guardás los proyectos:

```bash
composer create-project laravel/laravel sistema-usuarios
cd sistema-usuarios
```

Copiá las carpetas y archivos de este ZIP dentro de `sistema-usuarios`, manteniendo las rutas. Si reemplazás un archivo que ya existe, conservá una copia antes.

## 2. Crear la base de datos
En phpMyAdmin o en MySQL, creá una base de datos vacía llamada `sistema_usuarios`.

En `.env`, configurá las credenciales de tu instalación local. Ejemplo para XAMPP, si `root` no tiene contraseña:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_usuarios
DB_USERNAME=root
DB_PASSWORD=
```

Si tu usuario tiene contraseña, escribila en `DB_PASSWORD`. No subas `.env` a GitHub.

## 3. Ejecutar migraciones
Con MySQL encendido, ejecutá:

```bash
php artisan config:clear
php artisan key:generate
php artisan migrate
```

La migración estándar de Laravel crea `users`; la migración incluida agrega `edad`.

**Importante:** usá una base vacía para esta actividad. No ejecutes `migrate:fresh` sobre la base real de PediYun ni sobre otra base que contenga datos que quieras conservar.

## 4. Iniciar
```bash
php artisan serve
```

Abrí `http://127.0.0.1:8000/registro`.

## 5. Pruebas manuales obligatorias
1. Registrá un usuario válido: debe aparecer en `users`.
2. Intentá registrar el mismo email: debe rechazarse.
3. Probá edad 17 y contraseña de menos de 6 caracteres: deben rechazarse.
4. Iniciá sesión con la cuenta creada: debe abrir el perfil.
5. Abrí `/perfil` en una ventana privada sin iniciar sesión: debe redirigir a login.
6. Cambiá nombre y edad: verificá los cambios en MySQL.
7. Cerrá sesión e intentá volver al perfil: debe quedar protegido.

También se puede ejecutar la suite de pruebas (requiere configurar el entorno de testing):
```bash
php artisan test
```

## Flujo MVC
Vista Blade → JavaScript `fetch()` → ruta en `routes/web.php` → `UsuarioController` → modelo `User`/Eloquent → MySQL → respuesta JSON o vista.

## Seguridad aplicada
- Validación del lado del servidor.
- Email único.
- Contraseña guardada con hash.
- Sesión regenerada después del login.
- Perfil protegido con middleware `auth`.
- Actualización limitada a nombre y edad del usuario autenticado.
- Logout por POST, invalida la sesión y renueva el token CSRF.
- Mensajes de error insertados con `textContent` en JavaScript, evitando interpretar HTML arbitrario.

## Entrega Git
```bash
git init
git add .
git commit -m "Migrar sistema de usuarios a Laravel"
```

No subir `.env`, credenciales ni `vendor/`.
