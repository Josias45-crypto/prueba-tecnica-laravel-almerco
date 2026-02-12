# Sistema de Gestión de Usuarios y Emails - Grupo Almerco

Sistema web desarrollado con Laravel para la administración de usuarios y envío de emails mediante colas.

## 📋 Características

- ✅ Autenticación de usuarios (Admin y Usuarios normales)
- ✅ CRUD completo de usuarios con validaciones
- ✅ Selectores anidados (País → Estado → Ciudad) con AJAX
- ✅ DataTables con filtros, ordenamiento y paginación server-side
- ✅ Sistema de envío de emails con colas
- ✅ Estados de emails (No enviado / Enviado)
- ✅ Sistema de logs para auditoría
- ✅ Roles diferenciados (Admin / Usuario)

## 🛠️ Tecnologías

- **Backend:** PHP 8.1+ / Laravel 11
- **Frontend:** Bootstrap 5, jQuery, DataTables
- **Base de datos:** MySQL 8.0 / MariaDB
- **Gestión de colas:** Laravel Queue

## 📦 Requisitos

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js >= 16
- NPM

## 🚀 Instalación

### 1. Clonar el repositorio
```bash
git clone https://github.com/Josias45-crypto/prueba-tecnica-laravel-almerco.git
cd prueba-tecnica-laravel-almerco
```

### 2. Instalar dependencias
```bash
composer install
npm install
```

### 3. Configurar archivo .env
```bash
cp .env.example .env
```

Editar el archivo `.env` con tus credenciales de base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=grupo_almerco
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

QUEUE_CONNECTION=database
```

### 4. Generar key de la aplicación
```bash
php artisan key:generate
```

### 5. Ejecutar migraciones y seeders
```bash
php artisan migrate --seed
```

### 6. Compilar assets
```bash
npm run build
```

### 7. Iniciar servidor
```bash
php artisan serve
```

La aplicación estará disponible en: `http://localhost:8000`

## 👤 Credenciales de acceso

### Administrador
- **Email:** admin@grupoalmerco.com
- **Contraseña:** Admin@123

### Usuario Normal
- **Email:** juan@example.com
- **Contraseña:** User@123

## 📧 Sistema de Emails

### Procesar cola de emails

Para enviar los emails encolados, ejecuta:
```bash
php artisan emails:process
```

O para procesar continuamente:
```bash
php artisan queue:work
```

## 📂 Estructura del Proyecto
```
├── app/
│   ├── Console/Commands/     # Comandos Artisan
│   ├── Http/
│   │   ├── Controllers/      # Controladores
│   │   ├── Middleware/       # Middleware personalizado
│   │   └── Requests/         # Form Requests (validaciones)
│   ├── Jobs/                 # Jobs de cola
│   ├── Mail/                 # Mailables
│   ├── Models/               # Modelos Eloquent
│   └── Observers/            # Observers para logs
├── database/
│   ├── migrations/           # Migraciones
│   └── seeders/              # Seeders
├── resources/
│   ├── views/                # Vistas Blade
│   └── sass/                 # Estilos SCSS
└── routes/
    └── web.php               # Rutas web
```

## 🔧 Funcionalidades Principales

### Módulo de Usuarios (Solo Admin)

- Crear usuarios con validaciones estrictas
- Editar usuarios (email y cédula no editables)
- Eliminar usuarios
- Listado con DataTable
- Filtros de búsqueda
- Cálculo automático de edad

### Módulo de Emails

- Crear y enviar emails
- Sistema de colas para envío asíncrono
- Estados: No enviado / Enviado
- Usuarios ven solo sus emails
- Admin ve todos los emails

### Sistema de Logs

- Registro automático de:
  - Creación de usuarios
  - Actualización de usuarios
  - Eliminación de usuarios
  - Creación de emails
  - Cambios de estado de emails

## 📝 Validaciones Implementadas

### Usuarios
- Identificador: numérico, único
- Email: válido, único, no editable
- Contraseña: mín 8 caracteres, 1 número, 1 mayúscula, 1 carácter especial
- Cédula: máx 11 caracteres, no editable
- Fecha de nacimiento: mayor de 18 años
- Celular: 10 dígitos (opcional)

### Emails
- Asunto: obligatorio
- Destinatario: email válido
- Cuerpo: obligatorio

## 🧪 Testing

Para ejecutar pruebas (si se implementan):
```bash
php artisan test
```

## 👨‍💻 Autor

**Josias** - Prueba técnica para Grupo Almerco

## 📄 Licencia

Este proyecto es una prueba técnica desarrollada para Grupo Almerco.
