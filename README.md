# Sistema de Login en PHP + MySQL (XAMPP)

Login, registro y panel protegido con sesiones. Contraseñas con `password_hash`, consultas preparadas (PDO) y token CSRF.

## Estructura

```
login-php/
├── assets/style.css
├── config/db.php        <- datos de conexión a la BD
├── database.sql         <- script para crear la BD y la tabla
├── index.php
├── register.php
├── login.php
├── dashboard.php
├── logout.php
└── .gitignore
```

## PARTE 1 — Probarlo en local con XAMPP

1. Abre **XAMPP Control Panel** y pulsa **Start** en **Apache** y **MySQL**.
2. Copia la carpeta `login-php` dentro de `C:\xampp\htdocs\`.
3. Entra a http://localhost/phpmyadmin → pestaña **Importar** → elige `database.sql` → **Continuar**.
   (Esto crea la base `login_db` con la tabla `usuarios`.)
4. Abre http://localhost/login-php/ y crea una cuenta.
5. Si cambiaste la contraseña de root en MySQL, edítala en `config/db.php`.

## PARTE 2 — Abrirlo en Visual Studio Code

1. Abre VS Code → **Archivo → Abrir carpeta** → `C:\xampp\htdocs\login-php`.
2. Extensiones recomendadas: **PHP Intelephense** y **PHP Server** (opcional).

## PARTE 3 — Subirlo a GitHub

1. Crea cuenta en https://github.com e instala Git: https://git-scm.com/downloads
2. Configura Git (una sola vez), en la terminal de VS Code (`Ctrl + ñ`):
   ```
   git config --global user.name "Tu Nombre"
   git config --global user.email "tu_correo@ejemplo.com"
   ```
3. En GitHub: **New repository** → nombre `login-php` → déjalo vacío (sin README) → **Create repository**.
4. En la terminal de VS Code, dentro de la carpeta del proyecto:
   ```
   git init
   git add .
   git commit -m "Primer commit: sistema de login"
   git branch -M main
   git remote add origin https://github.com/TU_USUARIO/login-php.git
   git push -u origin main
   ```
5. Te pedirá iniciar sesión en GitHub (se abre el navegador). Listo: refresca el repositorio y verás los archivos.

Para subir cambios futuros:
```
git add .
git commit -m "Descripción del cambio"
git push
```

## PARTE 4 — Desplegarlo en internet

> ⚠️ **GitHub Pages NO sirve para PHP** (solo hospeda HTML/CSS/JS). Necesitas un hosting con PHP y MySQL. Opción gratuita: **InfinityFree**.

1. Crea cuenta en https://www.infinityfree.com → **Create Account** → elige un subdominio gratis.
2. En el panel (**Client Area**) → **MySQL Databases** → crea una base de datos. Anota: **host** (algo como `sqlXXX.infinityfree.com`), **nombre de BD**, **usuario** y **contraseña**.
3. Abre **phpMyAdmin** desde ese panel, selecciona tu base y en **Importar** sube `database.sql`.
   - Antes de importar, **borra las 2 primeras líneas** del archivo (`CREATE DATABASE...` y `USE login_db;`), porque en el hosting la base ya existe con otro nombre.
4. Edita `config/db.php` con los datos del hosting:
   ```php
   $host = 'sqlXXX.infinityfree.com';
   $db   = 'if0_XXXXXXX_login';
   $user = 'if0_XXXXXXX';
   $pass = 'TU_CONTRASEÑA';
   ```
5. Sube los archivos: en el panel → **Online File Manager** (o usa FileZilla con los datos FTP) → carpeta `htdocs` → sube todo el contenido de `login-php` (sin `.git`).
6. Entra a `http://tusubdominio.epizy.com/` (o el dominio que te asignen).

### Cuidado con las contraseñas
No subas a GitHub el `config/db.php` con datos reales de producción. Mantén en GitHub la versión local (root, sin contraseña) y edita el archivo directamente en el hosting.

## Seguridad incluida
- `password_hash()` / `password_verify()`
- PDO con consultas preparadas (anti SQL Injection)
- `htmlspecialchars` en todas las salidas (anti XSS)
- Token CSRF en formularios
- `session_regenerate_id()` al iniciar sesión
