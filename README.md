# Sistema de Ventas 2026

## Descripción

Sistema de Ventas 2026 es una aplicación web completa para la gestión de ventas, compras, inventario y administración de usuarios, desarrollada con Laravel 12. Este sistema permite gestionar productos, proveedores, clientes, compras y ventas de manera eficiente, con un enfoque en la administración de inventario y control de transacciones.

La aplicación incluye funcionalidades avanzadas como:

- Gestión de productos con categorías y marcas
- Control de inventario con alertas de stock mínimo
- Módulo de compras a proveedores
- Módulo de ventas a clientes con generación de recibos en PDF
- Sistema de roles y permisos basado en Spatie Laravel Permission
- Panel de administración con estadísticas
- Interfaz en español

## Características Principales

### Gestión de Productos

- Crear, editar y eliminar productos
- Organización por categorías y marcas
- Control de stock y precios de compra/venta
- Búsqueda y restauración de productos eliminados

### Inventario y Compras

- Gestión de proveedores
- Sistema de carrito temporal para compras
- Registro de compras con detalles de productos
- Actualización automática de inventario

### Ventas

- Gestión de clientes
- Carrito temporal para ventas
- Generación de recibos en PDF
- Cancelación de ventas

### Administración

- Configuración del sistema (empresa, logo, etc.)
- Gestión de usuarios y roles
- Panel de control con estadísticas

## Requisitos del Sistema

- PHP 8.2.12 o superior
- Composer
- Node.js y npm
- MySQL o PostgreSQL
- Laravel 12

## Instalación

1. Clona el repositorio:

    ```bash
    git clone https://github.com/tu-usuario/sistemaventas2026.git
    cd sistemaventas2026
    ```

2. Instala las dependencias de PHP:

    ```bash
    composer install
    ```

3. Instala las dependencias de JavaScript:

    ```bash
    npm install
    ```

4. Copia el archivo de configuración y configura tu base de datos:

    ```bash
    cp .env.example .env
    ```

    Edita `.env` con tus credenciales de base de datos.

5. Genera la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

6. Ejecuta las migraciones y seeders:

    ```bash
    php artisan migrate --seed
    ```

7. Construye los assets:

    ```bash
    npm run build
    ```

8. Inicia el servidor:

    ```bash
    php artisan serve
    ```

9. Para desarrollo con hot reload:
    ```bash
    npm run dev
    ```

## Uso

1. Accede a la aplicación en `http://localhost:8000`
2. Inicia sesión con las credenciales por defecto (admin/admin) o crea un usuario administrador
3. Navega por el panel de administración para gestionar productos, compras, ventas, etc.

## Estructura del Proyecto

- `app/Models/` - Modelos de Eloquent
- `app/Http/Controllers/` - Controladores
- `resources/views/` - Vistas Blade
- `routes/web.php` - Rutas web
- `database/migrations/` - Migraciones de base de datos
- `public/` - Assets públicos

## Tecnologías Utilizadas

- **Laravel 12** - Framework PHP
- **Tailwind CSS 4** - Framework CSS
- **Bootstrap 5** - Componentes UI adicionales
- **Vite 7** - Herramienta de construcción frontend
- **Pest PHP 3** - Framework de testing
- **Spatie Laravel Permission** - Gestión de permisos
- **Dompdf** - Generación de PDFs

## Testing

Ejecuta los tests con:

```bash
php artisan test
```

## Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit tus cambios (`git commit -am 'Agrega nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Abre un Pull Request

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Soporte

Para soporte o preguntas, por favor abre un issue en el repositorio de GitHub.

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
