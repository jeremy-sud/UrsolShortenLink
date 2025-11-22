# Acortador de URLs - Sistemas Ursol S.A.

**Versión Oficial 1.0**
**Desarrollado por:** RepDev para Sistemas Ursol S.A.

Este repositorio contiene el código fuente del Acortador de URLs oficial de Sistemas Ursol. Una herramienta diseñada para ser rápida, segura y fácil de desplegar en entornos de hosting compartido estándar.

## Características

- **Stack Tecnológico**: PHP 8+ y MySQL. (Sin dependencias de Node.js en producción).
- **Diseño Premium**: Interfaz de usuario moderna, minimalista y "panorámica" con modo oscuro.
- **Tipografía**: Fuente 'Outfit' para una legibilidad moderna.
- **Funcionalidades**:
  - Acortado de URLs largas.
  - Redirección rápida y segura.
  - Contador de clics (base de datos).
  - Copia al portapapeles con un clic.
  - Espacio para publicidad integrado.

## Estructura del Proyecto

```
/
├── index.php           # Interfaz de usuario (Frontend)
├── api/
│   └── shorten.php     # Endpoint API para acortar
├── redirect.php        # Lógica de redirección
├── db.php              # Conexión a Base de Datos
├── .htaccess           # Reglas de reescritura (URLs amigables)
├── assets/             # Recursos estáticos (si los hubiera)
└── _node_backup/       # Respaldo del código original (Node.js) - No subir a producción
```

## Guía de Instalación y Despliegue

### Requisitos del Servidor

- **PHP**: Versión 7.4 o superior.
- **MySQL/MariaDB**: Base de datos.
- **Servidor Web**: Apache (con `mod_rewrite` habilitado para `.htaccess`).

### Paso 1: Base de Datos

1.  Crea una base de datos en tu servidor (ej. `ursol_shortener`).
2.  Importa el siguiente esquema SQL (o deja que `db.php` lo intente crear automáticamente):
    ```sql
    CREATE TABLE IF NOT EXISTS url_shorter_db (
        id INT AUTO_INCREMENT PRIMARY KEY,
        original_url TEXT NOT NULL,
        short_code VARCHAR(10) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        clicks INT DEFAULT 0
    );
    ```

### Paso 2: Configuración

1.  Edita el archivo `db.php` con tus credenciales reales:
    ```php
    $host = 'localhost';
    $user = 'tu_usuario_real';
    $pass = 'tu_contraseña_real';
    $db   = 'nombre_de_tu_bd';
    ```

### Paso 3: Subida de Archivos

1.  Sube los siguientes archivos a tu carpeta pública (`public_html`):
    - `index.php`
    - `db.php`
    - `redirect.php`
    - `.htaccess`
    - Carpeta `api/`
2.  **NO** subas la carpeta `_node_backup` ni `.git`.

### Paso 4: Verificación

- Accede a tu dominio (ej. `ursol.com`).
- Prueba acortar un enlace.
- Verifica que la redirección funcione.

## Soporte

Para soporte técnico o reportar errores, contactar a **RepDev** a través de los canales oficiales de Sistemas Ursol S.A.

---

&copy; 2025 Sistemas Ursol S.A. Todos los derechos reservados.
