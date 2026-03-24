# Sistema de Ventas 2026

## Descripción

Sistema de Ventas 2026 es una aplicación web completa para la gestión integral de ventas, compras, inventario y administración de usuarios, desarrollada con Laravel 12. Este sistema permite gestionar productos, proveedores, clientes, compras y ventas de manera eficiente, con un enfoque en la administración de inventario, control de transacciones financieras y operaciones de caja registradora.

La aplicación incluye funcionalidades avanzadas como:

- **Gestión de Productos**: Control de inventario con categorías, marcas, códigos únicos y alertas de stock mínimo
- **Módulo de Compras**: Sistema de carrito temporal para compras a proveedores con actualización automática de inventario
- **Módulo de Ventas**: Carrito temporal para ventas a clientes con generación de recibos en PDF
- **Control de Caja**: Gestión de cajas registradoras con movimientos de ingresos/egresos y conciliación
- **Sistema de Roles y Permisos**: Basado en Spatie Laravel Permission para control de acceso granular
- **Panel de Administración**: Dashboard con estadísticas y configuración del sistema
- **Interfaz en Español**: Localización completa con mensajes de error personalizados
- **Soft Deletes**: Restauración de registros eliminados en productos, clientes, proveedores, etc.

## Características Principales

### Gestión de Productos

- Crear, editar y eliminar productos con códigos únicos (códigos de barras)
- Organización por categorías y marcas con eliminación en cascada
- Control de stock con niveles mínimos de alerta
- Precios de compra y venta independientes
- Búsqueda avanzada por nombre o código
- Restauración de productos eliminados (soft deletes)
- Subida de imágenes de productos

### Inventario y Compras

- Gestión completa de proveedores (empresa, CUIT, contacto)
- Sistema de carrito temporal para compras con sesión
- Registro de compras con detalles de productos y precios
- Actualización automática de inventario al confirmar compra
- Movimientos de caja automáticos (egresos por compras)
- Anulación de compras con reversión de stock
- Validación de caja abierta para transacciones

### Ventas y Clientes

- Gestión de clientes con documentos únicos
- Carrito temporal para ventas con sesión
- Generación automática de recibos en PDF con DomPDF
- Cálculo de totales en backend para seguridad
- Movimientos de caja automáticos (ingresos por ventas)
- Anulación de ventas con reversión de stock
- Validación de stock disponible antes de venta

### Control de Caja Registradora

- Apertura y cierre de cajas con montos iniciales/finales
- Registro automático de movimientos por transacciones
- Ingresos y egresos manuales con descripciones
- Conciliación automática al cerrar caja (esperado vs real)
- Solo una caja abierta permitida simultáneamente
- Historial completo de movimientos por caja

### Administración del Sistema

- Configuración global (empresa, logo, imágenes, contacto)
- Gestión de usuarios con roles y permisos
- Panel de control con estadísticas en tiempo real
- Subida de logos e imágenes de login
- Tema oscuro/claro con alternancia

### Seguridad y Permisos

- Autenticación Laravel con verificación de email
- Sistema de roles basado en Spatie Laravel Permission
- Middleware de autenticación en todas las rutas admin
- Hashing automático de contraseñas
- Validación de permisos por módulo

## Requisitos del Sistema

- **PHP**: 8.2.12 o superior
- **Composer**: Para gestión de dependencias PHP
- **Node.js**: 18+ y npm para assets frontend
- **Base de Datos**: MySQL 8.0+ o PostgreSQL
- **Laravel**: 12.0
- **Espacio en Disco**: Mínimo 500MB para instalación completa
- **Memoria RAM**: 2GB recomendado para desarrollo

## Tecnologías Utilizadas

- **Backend**: PHP 8.2.12, Laravel 12.0
- **Frontend**: Tailwind CSS 4, Bootstrap 5, Blade Templates, jQuery 3.7
- **Base de Datos**: MySQL con Eloquent ORM
- **UI Components**: DataTables, SweetAlert2, Chosen.js, Iconly Icons
- **PDF Generation**: DomPDF 3.1
- **Permissions**: Spatie Laravel Permission 6.24
- **Localization**: Laraveles/Spanish 1.5
- **Testing**: Pest PHP 3.8
- **Build Tool**: Vite 7
- **Development**: Laravel Sail (Docker)

## Instalación

### Paso 1: Clonación del Repositorio

```bash
git clone https://github.com/tu-usuario/sistemaventas2026.git
cd sistemaventas2026
```

### Paso 2: Instalación de Dependencias PHP

```bash
composer install
```

### Paso 3: Instalación de Dependencias JavaScript

```bash
npm install
```

### Paso 4: Configuración del Entorno

Copia el archivo de configuración de ejemplo:

```bash
cp .env.example .env
```

Edita el archivo `.env` con tus configuraciones:

```env
APP_NAME="Sistema de Ventas 2026"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistemaventas2026
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### Paso 5: Generación de Clave de Aplicación

```bash
php artisan key:generate
```

### Paso 6: Migraciones y Seeders

Ejecuta las migraciones para crear las tablas:

```bash
php artisan migrate
```

Ejecuta los seeders para datos iniciales (usuario admin, roles básicos):

```bash
php artisan db:seed
```

O ejecuta ambos en un solo comando:

```bash
php artisan migrate --seed
```

### Paso 7: Construcción de Assets

Para producción:

```bash
npm run build
```

Para desarrollo con hot reload:

```bash
npm run dev
```

### Paso 8: Inicio del Servidor

```bash
php artisan serve
```

La aplicación estará disponible en `http://localhost:8000`

### Paso 9: Configuración Inicial

1. Accede a `http://localhost:8000/login`
2. Inicia sesión con las credenciales por defecto:
    - **Email**: pablo.eluniversoweb@gmail.com
    - **Password**: 12345678

### Panel de Administración

Después del login, accederás al dashboard principal que muestra:

- Cantidad total de roles, usuarios, categorías y marcas
- Navegación lateral con todos los módulos

### Gestión de Usuarios y Roles

1. **Roles**: Crear roles con permisos específicos
2. **Usuarios**: Crear usuarios y asignarles roles
    - Nota: El usuario con ID=1 (admin) no puede ser eliminado

### Gestión de Productos

1. Crear categorías y marcas primero
2. Crear productos con:
    - Código único (para escaneo de códigos de barras)
    - Stock inicial y mínimo
    - Precios de compra y venta
    - Imagen opcional

### Operaciones de Compra

1. Abrir una caja registradora si no hay ninguna abierta
2. Ir a "Compras" → "Nueva Compra"
3. Escanear códigos de productos o buscar manualmente
4. Agregar productos al carrito temporal
5. Modificar precios si es necesario
6. Confirmar compra (actualiza inventario y registra egreso en caja)

### Operaciones de Venta

1. Asegurarse de que hay una caja abierta
2. Ir a "Ventas" → "Nueva Venta"
3. Seleccionar cliente o crear uno nuevo
4. Agregar productos al carrito
5. Generar recibo en PDF
6. Confirmar venta (reduce stock y registra ingreso en caja)

### Control de Caja

1. **Apertura**: Crear nueva caja con monto inicial
2. **Durante el día**: Sistema registra automáticamente movimientos
3. **Ajustes manuales**: Agregar ingresos/egresos extraordinarios
4. **Cierre**: Conciliar montos y cerrar caja

## Estructura de la Base de Datos

### Tablas Principales

| Tabla                  | Descripción              | Campos Clave                                                                   |
| ---------------------- | ------------------------ | ------------------------------------------------------------------------------ |
| `users`                | Usuarios del sistema     | id, name, email, password                                                      |
| `productos`            | Catálogo de productos    | id, nombre, codigo, stock, precio_compra, precio_venta, categoria_id, marca_id |
| `categorias`           | Categorías de productos  | id, nombre                                                                     |
| `marcas`               | Marcas de productos      | id, nombre                                                                     |
| `proveedores`          | Proveedores              | id, nombre, empresa, cuit, telefono, email                                     |
| `clientes`             | Clientes                 | id, nombre, numero_documento, telefono, email                                  |
| `compras`              | Transacciones de compra  | id, fecha, comprobante, precio_final, proveedor_id, caja_id                    |
| `ventas`               | Transacciones de venta   | id, fecha, precio_final, cliente_id, caja_id                                   |
| `detalle_compras`      | Líneas de compra         | id, cantidad, precio_compra, producto_id, compra_id                            |
| `detalle_ventas`       | Líneas de venta          | id, cantidad, precio_venta, venta_id, producto_id                              |
| `cajas`                | Cajas registradoras      | id, fecha_apertura, fecha_cierre, monto_inicial, monto_final                   |
| `movimiento_cajas`     | Movimientos de caja      | id, tipo, descripcion, monto, caja_id                                          |
| `tmp_compras`          | Carrito temporal compras | id, producto_id, cantidad, precio_compra, session_id                           |
| `tmp_ventas`           | Carrito temporal ventas  | id, producto_id, cantidad, precio_venta, session_id                            |
| `configuracions`       | Configuración global     | id, nombre_empresa, direccion, telefono, email, logo                           |
| `roles`                | Roles de usuario         | id, name, guard_name                                                           |
| `permissions`          | Permisos                 | id, name, guard_name                                                           |
| `model_has_roles`      | Asignación usuario-rol   | role_id, model_type, model_id                                                  |
| `role_has_permissions` | Asignación rol-permiso   | permission_id, role_id                                                         |

### Relaciones Clave

- **Producto** → **Categoria** (muchos a uno)
- **Producto** → **Marca** (muchos a uno)
- **Compra** → **Proveedor** (muchos a uno)
- **Compra** → **Caja** (muchos a uno)
- **Venta** → **Cliente** (muchos a uno)
- **Venta** → **Caja** (muchos a uno)
- **DetalleCompra** → **Producto** y **Compra**
- **DetalleVenta** → **Producto** y **Venta**
- **MovimientoCaja** → **Caja** (muchos a uno)

## Rutas de la Aplicación

### Rutas Públicas

- `GET /` - Dashboard (requiere auth)
- `GET /login` - Login
- `GET /register` - Registro
- `GET /password/reset` - Reset de contraseña

### Rutas de Administración (requieren auth)

#### Dashboard

- `GET /admin` - Panel principal

#### Configuración

- `GET /admin/configuracion` - Ver configuración
- `PUT /admin/configuracion` - Actualizar configuración

#### Usuarios y Roles

- `GET /admin/roles` - Listar roles
- `POST /admin/roles` - Crear rol
- `GET /admin/roles/{id}/edit` - Editar rol
- `PUT /admin/roles/{id}` - Actualizar rol
- `DELETE /admin/roles/{id}` - Eliminar rol

- `GET /admin/usuarios` - Listar usuarios
- `POST /admin/usuarios` - Crear usuario
- `GET /admin/usuarios/{id}` - Ver usuario
- `GET /admin/usuarios/{id}/edit` - Editar usuario
- `PUT /admin/usuarios/{id}` - Actualizar usuario
- `DELETE /admin/usuarios/{id}` - Eliminar usuario

#### Productos

- `GET /admin/productos` - Listar productos
- `POST /admin/productos` - Crear producto
- `GET /admin/productos/{id}` - Ver producto
- `GET /admin/productos/{id}/edit` - Editar producto
- `PUT /admin/productos/{id}` - Actualizar producto
- `DELETE /admin/productos/{id}` - Eliminar producto
- `GET /admin/productos/restaurar/{id}` - Restaurar producto

#### Categorías y Marcas

- `GET /admin/categorias` - Listar categorías
- `POST /admin/categorias` - Crear categoría
- `GET /admin/categorias/{id}/edit` - Editar categoría
- `PUT /admin/categorias/{id}` - Actualizar categoría
- `DELETE /admin/categorias/{id}` - Eliminar categoría
- `GET /admin/categorias/restaurar/{id}` - Restaurar categoría

_(Mismas rutas para marcas)_

#### Proveedores y Clientes

- `GET /admin/proveedores` - Listar proveedores
- `POST /admin/proveedores` - Crear proveedor
- `GET /admin/proveedores/{id}` - Ver proveedor
- `GET /admin/proveedores/{id}/edit` - Editar proveedor
- `PUT /admin/proveedores/{id}` - Actualizar proveedor
- `DELETE /admin/proveedores/{id}` - Eliminar proveedor
- `GET /admin/proveedores/restaurar/{id}` - Restaurar proveedor

_(Mismas rutas para clientes)_

#### Compras

- `GET /admin/compras` - Listar compras
- `GET /admin/compras/create` - Nueva compra
- `POST /admin/compras` - Guardar compra
- `GET /admin/compras/{id}` - Ver compra
- `GET /admin/compras/anular/{id}` - Anular compra

#### Carrito de Compras (AJAX)

- `POST /admin/compras/create/tmp` - Agregar producto al carrito
- `DELETE /admin/compras/create/tmp/{id}` - Remover del carrito
- `POST /admin/compras/actualizar-precio` - Actualizar precio

#### Ventas

- `GET /admin/ventas` - Listar ventas
- `GET /admin/ventas/create` - Nueva venta
- `POST /admin/ventas` - Guardar venta
- `GET /admin/ventas/{id}` - Ver venta
- `GET /admin/ventas/pdf/{id}` - Generar PDF
- `GET /admin/ventas/anular/{id}` - Anular venta

#### Carrito de Ventas (AJAX)

- `POST /admin/ventas/create/tmp` - Agregar producto al carrito
- `DELETE /admin/ventas/create/tmp/{id}` - Remover del carrito
- `POST /admin/ventas/actualizar-precio` - Actualizar precio

#### Cajas

- `GET /admin/cajas` - Listar cajas
- `GET /admin/cajas/create` - Nueva caja
- `POST /admin/cajas` - Guardar caja
- `GET /admin/cajas/{id}` - Ver caja
- `GET /admin/cajas/{id}/edit` - Editar caja
- `PUT /admin/cajas/{id}` - Actualizar caja
- `POST /admin/cajas/ingreso/{id}` - Agregar ingreso
- `POST /admin/cajas/egreso/{id}` - Agregar egreso
- `POST /admin/cajas/cerrar/{id}` - Cerrar caja

## Testing

El proyecto utiliza Pest PHP para testing. Para ejecutar los tests:

```bash
# Ejecutar todos los tests
php artisan test

# Ejecutar con cobertura
php artisan test --coverage

# Ejecutar tests específicos
php artisan test --filter=ProductoControllerTest
```

### Tests Incluidos

- Tests de modelos (creación, validación)
- Tests de controladores (CRUD operations)
- Tests de transacciones (compras, ventas)
- Tests de caja registradora
- Tests de permisos y roles

## Desarrollo

### Comandos Útiles

```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generar documentación de API (si se implementa)
php artisan api:generate

# Ejecutar linter
vendor/bin/pint --test

# Corregir estilo de código
vendor/bin/pint
```

### Estructura del Proyecto

```
app/
├── Http/Controllers/          # Controladores
├── Models/                    # Modelos Eloquent
├── Providers/                 # Service Providers
└── Console/                   # Comandos Artisan

bootstrap/
├── app.php                    # Configuración de aplicación
└── providers.php              # Providers adicionales

config/                        # Archivos de configuración
database/
├── factories/                 # Factories para testing
├── migrations/                # Migraciones de BD
└── seeders/                   # Seeders de datos

public/                        # Assets públicos
resources/
├── css/                       # Estilos CSS
├── js/                        # JavaScript
├── lang/                      # Traducciones
└── views/                     # Vistas Blade

routes/
└── web.php                    # Definición de rutas

storage/                       # Archivos temporales
tests/                         # Tests con Pest
vendor/                        # Dependencias Composer
```

## Despliegue

### Producción

1. Configurar variables de entorno para producción
2. Ejecutar migraciones en servidor de producción
3. Construir assets optimizados: `npm run build`
4. Configurar web server (Apache/Nginx) apuntando a `public/`
5. Configurar permisos de storage: `chmod -R 755 storage/`
6. Crear enlace simbólico: `php artisan storage:link`

### Variables de Entorno Críticas

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tu-dominio.com

DB_CONNECTION=mysql
DB_HOST=tu-host-db
DB_DATABASE=tu-base-datos
DB_USERNAME=tu-usuario-db
DB_PASSWORD=tu-password-db

MAIL_MAILER=smtp
MAIL_HOST=tu-smtp-host
MAIL_PORT=587
MAIL_USERNAME=tu-email@dominio.com
MAIL_PASSWORD=tu-password-email
MAIL_ENCRYPTION=tls
```

## Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/nueva-funcionalidad`)
3. Realiza tus cambios siguiendo las convenciones del código
4. Ejecuta tests: `php artisan test`
5. Verifica estilo: `vendor/bin/pint --test`
6. Commit tus cambios (`git commit -am 'Agrega nueva funcionalidad'`)
7. Push a la rama (`git push origin feature/nueva-funcionalidad`)
8. Abre un Pull Request

### Convenciones de Código

- Usar Laravel Pint para formato de código
- Seguir PSR-12 para PHP
- Usar nombres descriptivos en español para variables y métodos
- Incluir PHPDoc en métodos públicos
- Usar type hints en parámetros y retornos
- Mantener consistencia con el código existente

## Problemas Comunes

### Error de Vite Manifest

Si ves "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest":

```bash
npm run build
# o para desarrollo
npm run dev
```

### Problemas de Permisos

```bash
# En Linux/Mac
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# Crear enlace simbólico para storage
php artisan storage:link
```

### Base de Datos

- Asegurarse de que la base de datos existe antes de migrar
- Verificar credenciales en `.env`
- Para reiniciar: `php artisan migrate:fresh --seed`

## Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Soporte

Para soporte técnico o preguntas sobre el sistema:

- **Issues**: Abre un issue en el repositorio de GitHub
- **Email**: Contacta al desarrollador principal
- **Documentación**: Consulta este README para guías detalladas

## Changelog

### Versión 1.0.0

- Lanzamiento inicial con funcionalidades completas
- Gestión de productos, compras, ventas y caja
- Sistema de roles y permisos
- Interfaz en español
- Generación de PDFs
- Soft deletes y restauración

## Limitaciones Conocidas y Mejoras Futuras

### Limitaciones Actuales

- **Permisos no completamente implementados**: El sistema de roles existe pero los permisos específicos por módulo no están configurados en los seeders
- **Posibles problemas de N+1 queries**: Algunos controladores pueden beneficiarse de eager loading optimizado
- **Sin auditoría de transacciones**: No se registra un historial detallado de cambios en productos o transacciones
- **Carrito temporal limitado**: Los carritos TmpCompra/TmpVenta no tienen validación de sesión expirada
- **Sin API REST**: La aplicación es exclusivamente web, sin endpoints API para integraciones
- **Sin exportación/importación**: No hay funcionalidad para exportar datos o importar productos masivamente

### Mejoras Planificadas

- Implementación completa del sistema de permisos
- Optimización de consultas con eager loading
- Sistema de auditoría para cambios críticos
- API REST para integraciones con otros sistemas
- Funcionalidad de exportación (Excel, CSV)
- Dashboard con gráficos avanzados
- Notificaciones por email para stock bajo
- Backup automático de base de datos
- Soporte multi-empresa/tenant

## Créditos

Desarrollado con Laravel 12 y las siguientes librerías principales:

- **Laravel Framework** - Base del sistema
- **Spatie Laravel Permission** - Gestión de permisos
- **DomPDF** - Generación de PDFs
- **Tailwind CSS** - Framework CSS
- **Bootstrap** - Componentes UI
- **DataTables** - Tablas interactivas
- **SweetAlert2** - Notificaciones

---

**Sistema de Ventas 2026** - Solución completa para gestión de ventas y inventario.

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
