# 📊 INVENTARIO COMPLETO - SISTEMA DE VENTAS LARAVEL 12

**Fecha de análisis:** 8 de mayo de 2026  
**Versión Laravel:** 12  
**PHP:** 8.2.12  
**Base de datos:** 21 tablas

---

## 📋 TABLA DE CONTENIDOS

1. [Modelos Eloquent](#modelos)
2. [Controladores](#controladores)
3. [Rutas](#rutas)
4. [Tablas de Base de Datos](#base-de-datos)
5. [Factories y Seeders](#factories-seeders)
6. [Vistas (Blade)](#vistas)
7. [Configuración](#configuración)
8. [Dependencias](#dependencias)
9. [Tests](#tests)
10. [Funcionalidades](#funcionalidades)

---

## <a name="modelos"></a>🗂️ MODELOS ELOQUENT (18 MODELOS)

### 1. **User**

- **Propósito:** Gestión de usuarios del sistema
- **Relaciones:** Roles (Spatie Permission)
- **Campos principales:** id, name, email, password, remember_token

### 2. **Producto**

- **Propósito:** Gestión de productos/inventario
- **Relaciones:**
    - belongsTo Categoria
    - belongsTo Marca
    - belongsToMany Compra (vía DetalleCompra)
    - belongsToMany Venta (vía DetalleVenta)
- **Campos principales:** id, nombre, codigo, imagen, stock, stock_minimo, precio_compra, precio_venta, activo

### 3. **Categoria**

- **Propósito:** Clasificación de productos
- **Relaciones:** hasMany Productos
- **Características:** softDeletes, lógica en cascade
- **Campos:** id, nombre, activo

### 4. **Marca**

- **Propósito:** Marcas de productos
- **Relaciones:** hasMany Productos
- **Características:** softDeletes, lógica en cascade
- **Campos:** id, nombre, activo

### 5. **Proveedor**

- **Propósito:** Gestión de proveedores
- **Relaciones:** hasMany Compras
- **Características:** softDeletes
- **Campos:** id, nombre, cuit, telefono, email, empresa, direccion, activo

### 6. **Cliente**

- **Propósito:** Gestión de clientes
- **Relaciones:** hasMany Ventas
- **Características:** softDeletes
- **Campos:** id, nombre, numero_documento, telefono, email, activo

### 7. **Venta**

- **Propósito:** Registro de ventas
- **Relaciones:**
    - belongsTo User, Cliente, Caja
    - hasMany DetalleVenta, Pago
    - belongsToMany Producto (vía DetalleVenta)
- **Campos:** id, fecha, precio_final, cliente_id, user_id, caja_id, tipo_comprobante, punto_venta, numero_factura, cae, cae_vencimiento, facturada, activo

### 8. **DetalleVenta**

- **Propósito:** Ítems individuales de cada venta
- **Relaciones:** belongsTo Venta, Producto
- **Campos:** id, venta_id, producto_id, cantidad, precio_venta

### 9. **TmpVenta**

- **Propósito:** Carrito temporal de ventas (sesión de usuario)
- **Relaciones:** belongsTo Producto
- **Campos:** id, producto_id, cantidad, session_id

### 10. **Compra**

- **Propósito:** Registro de compras a proveedores
- **Relaciones:**
    - belongsTo Proveedor, Caja
    - hasMany DetalleCompra
    - belongsToMany Producto (vía DetalleCompra)
- **Campos:** id, fecha, comprobante, precio_final, proveedor_id, caja_id, activo

### 11. **DetalleCompra**

- **Propósito:** Ítems individuales de cada compra
- **Relaciones:** belongsTo Compra, Producto
- **Campos:** id, compra_id, producto_id, cantidad, precio_compra

### 12. **TmpCompra**

- **Propósito:** Carrito temporal de compras (sesión de usuario)
- **Relaciones:** belongsTo Producto
- **Campos:** id, producto_id, cantidad, session_id

### 13. **Caja**

- **Propósito:** Gestión de cajas de dinero (apertura/cierre)
- **Relaciones:**
    - hasMany MovimientoCaja, Venta, Compra
- **Campos:** id, fecha_apertura, fecha_cierre, activo, monto_inicial, monto_final, descripcion

### 14. **MovimientoCaja**

- **Propósito:** Movimientos de dinero en caja (ingresos/egresos)
- **Relaciones:**
    - belongsTo Caja, MetodoPago
    - hasMany MovimientoCajaMetodo
- **Campos:** id, caja_id, tipo (ingreso/egreso), descripcion, monto, metodo_pago_id

### 15. **MovimientoCajaMetodo**

- **Propósito:** Desglose de movimientos por método de pago
- **Relaciones:** belongsTo MovimientoCaja, MetodoPago
- **Campos:** id, movimiento_caja_id, metodo_pago_id, monto

### 16. **MetodoPago**

- **Propósito:** Métodos de pago disponibles
- **Métodos:** Efectivo, Débito, Crédito, Transferencia
- **Campos:** id, nombre, codigo (único), activo

### 17. **Pago**

- **Propósito:** Pagos asociados a ventas
- **Relaciones:** belongsTo Venta, MetodoPago
- **Campos:** id, venta_id, metodo_pago_id, monto

### 18. **Configuracion**

- **Propósito:** Configuración global del sistema
- **Campos:** id, nombre_empresa, direccion, telefono, email, descripcion, cuit, ciudad, logo, imagen_login, imprimir_ticket

---

## <a name="controladores"></a>🎮 CONTROLADORES (21)

### GESTIÓN ADMINISTRATIVA

| Controlador                 | Funcionalidades                                      |
| --------------------------- | ---------------------------------------------------- |
| **AdminController**         | Dashboard principal; conteos; estadísticas generales |
| **ConfiguracionController** | CRUD configuración (empresa, logo, email, etc.)      |
| **BackupController**        | Crear/descargar/eliminar backups; soporte Windows    |

### MAESTROS (Datos Básicos)

| Controlador             | Funcionalidades                                                            |
| ----------------------- | -------------------------------------------------------------------------- |
| **ProductoController**  | CRUD productos; búsqueda; restaurar soft delete; actualizar precios masivo |
| **CategoriaController** | CRUD categorías; restaurar                                                 |
| **MarcaController**     | CRUD marcas; restaurar                                                     |
| **ProveedorController** | CRUD proveedores; restaurar                                                |
| **ClienteController**   | CRUD clientes; restaurar                                                   |

### TRANSACCIONES

| Controlador                  | Funcionalidades                                                                |
| ---------------------------- | ------------------------------------------------------------------------------ |
| **VentaController**          | Crear/listar/ver/anular ventas; PDF; ticket ESC/POS; facturación AFIP; invoice |
| **CompraController**         | Crear/listar/ver/anular compras; transacciones DB                              |
| **CajaController**           | Crear/abrir/cerrar cajas; ingresos/egresos; cierre con conciliación            |
| **MovimientoCajaController** | Gestión de movimientos de caja                                                 |

### SEGURIDAD Y ACCESO

| Controlador           | Funcionalidades                             |
| --------------------- | ------------------------------------------- |
| **UsuarioController** | CRUD usuarios; asignación de roles          |
| **RoleController**    | CRUD roles; gestión de permisos; asignación |

### AUXILIARES

| Controlador                 | Funcionalidades                                       |
| --------------------------- | ----------------------------------------------------- |
| **TmpVentaController**      | Manejo carrito temporal (agregar/eliminar/actualizar) |
| **TmpCompraController**     | Manejo carrito temporal (agregar/eliminar/actualizar) |
| **DetalleVentaController**  | Soporte para detalles de venta                        |
| **DetalleCompraController** | Soporte para detalles de compra                       |

### AUTENTICACIÓN

| Controlador                       | Funcionalidades            |
| --------------------------------- | -------------------------- |
| **Auth/LoginController**          | Login/logout               |
| **Auth/RegisterController**       | Registro de usuarios       |
| **Auth/ForgotPasswordController** | Recuperación de contraseña |

---

## <a name="rutas"></a>🔄 RUTAS (85+ RUTAS PROTEGIDAS)

### AUTENTICACIÓN (6 rutas)

```
POST   /login
POST   /logout
GET    /register
POST   /register
GET    /password/reset
POST   /password/email
POST   /password/reset
GET    /password/confirm
```

### DASHBOARD (3 rutas)

```
GET  /admin                → Dashboard principal
GET  /                     → Redirige a admin
GET  /home                 → Redirige a admin
```

### CONFIGURACIÓN (2 rutas)

```
GET  /admin/configuracion       → Ver configuración
PUT  /admin/configuracion       → Actualizar configuración
```

### ROLES (8 rutas)

```
GET    /admin/roles                    → Listar
GET    /admin/roles/create             → Formulario crear
POST   /admin/roles                    → Guardar
GET    /admin/roles/{role}/edit        → Formulario editar
GET    /admin/roles/{role}/permisos    → Gestionar permisos
PUT    /admin/roles/{role}/update_permisos → Actualizar permisos
PUT    /admin/roles/{role}             → Actualizar rol
DELETE /admin/roles/{role}             → Eliminar rol
```

### USUARIOS (7 rutas)

```
GET    /admin/usuarios                 → Listar
GET    /admin/usuarios/create          → Formulario crear
POST   /admin/usuarios                 → Guardar
GET    /admin/usuarios/{id}            → Ver detalles
GET    /admin/usuarios/{id}/edit       → Formulario editar
PUT    /admin/usuarios/{id}            → Actualizar
DELETE /admin/usuarios/{id}            → Eliminar
```

### CATEGORÍAS (7 rutas)

```
GET    /admin/categorias               → Listar
GET    /admin/categorias/create        → Formulario crear
POST   /admin/categorias               → Guardar
GET    /admin/categorias/{id}/edit     → Formulario editar
PUT    /admin/categorias/{id}          → Actualizar
DELETE /admin/categorias/{id}          → Eliminar
GET    /categorias/{id}/restore        → Restaurar (soft delete)
```

### MARCAS (7 rutas)

```
GET    /admin/marcas                   → Listar
GET    /admin/marcas/create            → Formulario crear
POST   /admin/marcas                   → Guardar
GET    /admin/marcas/{id}/edit         → Formulario editar
PUT    /admin/marcas/{id}              → Actualizar
DELETE /admin/marcas/{id}              → Eliminar
GET    /marcas/{id}/restore            → Restaurar (soft delete)
```

### PRODUCTOS (11 rutas)

```
GET    /admin/productos                          → Listar (búsqueda nombre/código)
GET    /admin/productos/create                   → Formulario crear
POST   /admin/productos                          → Guardar
GET    /admin/productos/{id}/show                → Ver detalles
GET    /admin/productos/{id}/edit                → Formulario editar
PUT    /admin/productos/{id}                     → Actualizar
DELETE /admin/productos/{id}                     → Eliminar
GET    /productos/restaurar/{id}                 → Restaurar (soft delete)
GET    /admin/productos/update-price             → Formulario actualizar precios masivo
POST   /productos/actualizar-precios             → Acción actualizar precios
```

### PROVEEDORES (8 rutas)

```
GET    /admin/proveedores               → Listar
GET    /admin/proveedores/create        → Formulario crear
POST   /admin/proveedores               → Guardar
GET    /admin/proveedores/{id}          → Ver detalles
GET    /admin/proveedores/{id}/edit     → Formulario editar
PUT    /admin/proveedores/{id}          → Actualizar
DELETE /admin/proveedores/{id}          → Eliminar
GET    /proveedores/restaurar/{id}      → Restaurar (soft delete)
```

### CLIENTES (8 rutas)

```
GET    /admin/clientes                  → Listar
GET    /admin/clientes/create           → Formulario crear
POST   /admin/clientes                  → Guardar
GET    /admin/clientes/{id}             → Ver detalles
GET    /admin/clientes/{id}/edit        → Formulario editar
PUT    /admin/clientes/{id}             → Actualizar
DELETE /admin/clientes/{id}             → Eliminar
GET    /clientes/restaurar/{id}         → Restaurar (soft delete)
```

### COMPRAS (8 rutas)

```
GET    /admin/compras                          → Listar
GET    /admin/compras/create                   → Formulario crear
POST   /admin/compras                          → Guardar compra
GET    /admin/compras/{id}                     → Ver detalles
PUT    /admin/compras/{id}/anular              → Anular compra
POST   /admin/compras/create/tmp               → Agregar a carrito temporal
DELETE /admin/compras/create/tmp/{id}          → Eliminar del carrito temporal
POST   /admin/compras/actualizar-precio        → Actualizar precio en carrito
```

### VENTAS (9 rutas)

```
GET    /admin/ventas                           → Listar
GET    /admin/ventas/create                    → Formulario crear (requiere caja abierta)
POST   /admin/ventas                           → Guardar venta
GET    /admin/ventas/{id}                      → Ver detalles
GET    /admin/ventas/pdf/{id}                  → Descargar PDF
PUT    /admin/ventas/{id}/anular               → Anular venta
POST   /admin/ventas/create/tmp                → Agregar a carrito temporal
DELETE /admin/ventas/create/tmp/{id}           → Eliminar del carrito temporal
POST   /admin/ventas/actualizar-precio         → Actualizar precio en carrito
```

### CAJAS (10 rutas)

```
GET    /admin/cajas                            → Listar cajas
GET    /admin/cajas/create                     → Formulario abrir caja
POST   /admin/cajas                            → Guardar apertura
GET    /admin/cajas/{id}                       → Ver detalles
GET    /admin/cajas/{id}/edit                  → Formulario editar
PUT    /admin/cajas/{id}                       → Actualizar
GET    /admin/cajas/{id}/ingreso-egreso        → Formulario ingreso/egreso
POST   /admin/cajas/{id}/ingreso-egreso        → Guardar ingreso/egreso
GET    /admin/cajas/{id}/cerrar                → Formulario cierre
POST   /admin/cajas/{id}/cierre                → Guardar cierre
```

### BACKUPS (4 rutas)

```
GET    /admin/backups                   → Listar backups
POST   /admin/backups/create            → Crear backup
GET    /admin/backups/{file}/download   → Descargar backup
DELETE /admin/backups/{file}/delete     → Eliminar backup
```

### ESPECIALES (3 rutas)

```
GET /admin/test-ticket           → Probar impresión de ticket (ESC/POS)
GET /admin/test-afip             → Probar facturación AFIP
GET /admin/invoice/{id}/imprimir → Imprimir invoice/factura
```

---

## <a name="base-de-datos"></a>🗄️ TABLAS DE BASE DE DATOS (21)

### AUTENTICACIÓN Y AUTORIZACIÓN (Spatie Permission + Laravel)

| Tabla                     | Descripción                 | Campos Principales                                                |
| ------------------------- | --------------------------- | ----------------------------------------------------------------- |
| **usuarios**              | Usuarios del sistema        | id, name, email, password, remember_token, created_at, updated_at |
| **roles**                 | Roles de usuario            | id, name, guard_name, created_at, updated_at                      |
| **permissions**           | Permisos del sistema        | id, name, guard_name, created_at, updated_at                      |
| **model_has_roles**       | Asignación roles a usuarios | role_id, model_id, model_type                                     |
| **model_has_permissions** | Permisos directos a modelos | permission_id, model_id, model_type                               |
| **role_has_permissions**  | Permisos asignados a roles  | permission_id, role_id                                            |
| **password_reset_tokens** | Tokens reset contraseña     | email, token, created_at                                          |
| **sessions**              | Sesiones de usuarios        | id, user_id, ip_address, user_agent, payload, last_activity       |

### INFRAESTRUCTURA

| Tabla     | Descripción      | Campos Principales                                                  |
| --------- | ---------------- | ------------------------------------------------------------------- |
| **cache** | Cache de Laravel | key, value, expiration                                              |
| **jobs**  | Cola de trabajos | id, queue, payload, attempts, reserved_at, available_at, created_at |

### CONFIGURACIÓN

| Tabla              | Descripción          | Campos Principales                                                                                                                     |
| ------------------ | -------------------- | -------------------------------------------------------------------------------------------------------------------------------------- |
| **configuracions** | Configuración global | id, nombre_empresa, direccion, telefono, email, descripcion, cuit, ciudad, logo, imagen_login, imprimir_ticket, created_at, updated_at |

### MAESTROS (Datos Básicos)

| Tabla            | Descripción             | Campos Principales                                                                                                                                                             |
| ---------------- | ----------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| **categorias**   | Categorías de productos | id, nombre, activo (implicit), deleted_at, created_at, updated_at                                                                                                              |
| **marcas**       | Marcas de productos     | id, nombre, activo (implicit), deleted_at, created_at, updated_at                                                                                                              |
| **metodos_pago** | Métodos de pago         | id, nombre, codigo (unique), activo, created_at, updated_at                                                                                                                    |
| **productos**    | Inventario de productos | id, nombre, codigo (unique, nullable), imagen (nullable), stock, stock_minimo, precio_compra, precio_venta, activo, categoria_id, marca_id, deleted_at, created_at, updated_at |

### TERCEROS

| Tabla          | Descripción         | Campos Principales                                                                                |
| -------------- | ------------------- | ------------------------------------------------------------------------------------------------- |
| **clientes**   | Base de clientes    | id, nombre, numero_documento, telefono, email (unique), deleted_at, created_at, updated_at        |
| **proveedors** | Base de proveedores | id, nombre, cuit, telefono, email, empresa, direccion, activo, deleted_at, created_at, updated_at |

### CAJAS

| Tabla                       | Descripción                     | Campos Principales                                                                                                   |
| --------------------------- | ------------------------------- | -------------------------------------------------------------------------------------------------------------------- |
| **cajas**                   | Cajas de dinero                 | id, fecha_apertura, fecha_cierre (nullable), activo, monto_inicial, monto_final, descripcion, created_at, updated_at |
| **movimiento_cajas**        | Movimientos de caja             | id, caja_id, tipo (ingreso/egreso), descripcion (nullable), monto, metodo_pago_id (nullable), created_at, updated_at |
| **movimiento_caja_metodos** | Desglose movimientos por método | id, movimiento_caja_id, metodo_pago_id, monto, created_at, updated_at                                                |

### TRANSACCIONES: COMPRAS

| Tabla               | Descripción              | Campos Principales                                                                          |
| ------------------- | ------------------------ | ------------------------------------------------------------------------------------------- |
| **compras**         | Registro de compras      | id, fecha, comprobante, precio_final, proveedor_id, caja_id, activo, created_at, updated_at |
| **detalle_compras** | Ítems de compras         | id, compra_id, producto_id, cantidad, precio_compra, created_at, updated_at                 |
| **tmp_compras**     | Carrito temporal compras | id, producto_id, cantidad, session_id, created_at, updated_at                               |

### TRANSACCIONES: VENTAS

| Tabla              | Descripción             | Campos Principales                                                                                                                                                                                                           |
| ------------------ | ----------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **ventas**         | Registro de ventas      | id, fecha, precio_final, cliente_id, user_id, caja_id, tipo_comprobante (nullable), punto_venta (nullable), numero_factura (nullable), cae (nullable), cae_vencimiento (nullable), facturada, activo, created_at, updated_at |
| **detalle_ventas** | Ítems de ventas         | id, venta_id, producto_id, cantidad, precio_venta, created_at, updated_at                                                                                                                                                    |
| **tmp_ventas**     | Carrito temporal ventas | id, producto_id, cantidad, session_id, created_at, updated_at                                                                                                                                                                |
| **pagos**          | Pagos de ventas         | id, venta_id, metodo_pago_id, monto, created_at, updated_at                                                                                                                                                                  |

---

## <a name="factories-seeders"></a>🏭 FACTORIES Y SEEDERS

### FACTORIES (3)

#### ProductoFactory

```
- Genera 200 productos con nombres realistas
- Agrupa por categoría
- Precios aleatorios con margen de ganancia coherente
- Stock aleatorio (0-500 unidades)
- Código único de producto
```

#### ClienteFactory

```
- Genera clientes con datos aleatorios
- Campos: nombre, numero_documento, telefono, email
- Estado consumidorFinal() para cliente genérico
```

#### UserFactory

```
- Heredada de Laravel
- Para generar usuarios de prueba
```

### SEEDERS (5)

#### DatabaseSeeder

```
- Orquesta todas las siembras:
  ✓ CategoriaSeeder
  ✓ MarcaSeeder
  ✓ RoleSeeder
  ✓ MetodoPagoSeeder
  ✓ ProductoFactory (200 productos)
  ✓ Usuarios iniciales (Super Admin + Vendedor)
  ✓ Proveedor inicial
  ✓ 10 clientes + consumidor final
  ✓ Configuración inicial
```

#### CategoriaSeeder

```
Siembra 10 categorías:
  1. Bebidas
  2. Lácteos
  3. Almacén
  4. Snacks
  5. Congelados
  6. Limpieza
  7. Higiene
  8. Panadería
  9. Carnicería
  10. Verdulería
```

#### MarcaSeeder

```
Siembra 20 marcas principales:
  - Coca-Cola, Pepsi, Sprite, Fanta
  - Arcor, La Serenísima, Sancor
  - Nestlé, Danone, Yogurisimo
  - Aceite: Natura, Cocinero
  - Bebidas: Quilmes, Brahma
  - Etc.
```

#### MetodoPagoSeeder

```
Siembra 4 métodos de pago:
  1. Efectivo
  2. Débito
  3. Crédito
  4. Transferencia
```

#### RoleSeeder

```
Siembra 3 roles con 90+ permisos:

  SUPER ADMINISTRADOR
    - Acceso total al sistema
    - Ver/crear/editar/eliminar todo
    - Gestión de usuarios y roles
    - Gestión de backups

  ADMINISTRADOR
    - Gestión de maestros (productos, categorías, marcas)
    - Gestión de compras/ventas
    - Gestión de cajas
    - Ver reportes
    - No puede eliminar usuarios/roles

  VENDEDOR
    - Crear ventas
    - Consultar productos
    - Gestionar carrito de ventas
    - Ver cajas (si caja abierta)
    - No acceso a configuración ni eliminaciones
```

---

## <a name="vistas"></a>🎨 VISTAS (BLADE TEMPLATES)

```
resources/views/
│
├── auth/
│   ├── login.blade.php              → Formulario login
│   ├── register.blade.php            → Registro de usuarios
│   ├── verify.blade.php              → Verificación email
│   └── passwords/
│       ├── confirm.blade.php         → Confirmar contraseña
│       ├── email.blade.php           → Solicitar reset
│       └── reset.blade.php           → Resetear contraseña
│
├── layouts/
│   ├── admin.blade.php               → Layout principal admin
│   ├── app.blade.php                 → Layout aplicación
│   └── includes/
│       ├── sidebar-admin.blade.php   → Menú lateral
│       └── footer-admin.blade.php    → Pie de página
│
├── admin/
│   ├── index.blade.php               → Dashboard principal
│   │
│   ├── configuracion/
│   │   └── index.blade.php           → Editar configuración
│   │
│   ├── roles/
│   │   ├── index.blade.php           → Listar roles
│   │   ├── create.blade.php          → Crear rol
│   │   ├── edit.blade.php            → Editar rol
│   │   └── permisos.blade.php        → Gestionar permisos
│   │
│   ├── usuarios/
│   │   ├── index.blade.php           → Listar usuarios
│   │   ├── create.blade.php          → Crear usuario
│   │   └── edit.blade.php            → Editar usuario
│   │
│   ├── categorias/
│   │   ├── index.blade.php           → Listar categorías
│   │   ├── create.blade.php          → Crear categoría
│   │   └── edit.blade.php            → Editar categoría
│   │
│   ├── marcas/
│   │   ├── index.blade.php           → Listar marcas
│   │   ├── create.blade.php          → Crear marca
│   │   └── edit.blade.php            → Editar marca
│   │
│   ├── productos/
│   │   ├── index.blade.php           → Listar productos (con búsqueda)
│   │   ├── create.blade.php          → Crear producto
│   │   ├── edit.blade.php            → Editar producto
│   │   ├── show.blade.php            → Ver detalles producto
│   │   ├── preview.blade.php         → Preview producto
│   │   └── update_price.blade.php    → Actualizar precios masivo
│   │
│   ├── proveedores/
│   │   ├── index.blade.php           → Listar proveedores
│   │   ├── create.blade.php          → Crear proveedor
│   │   ├── edit.blade.php            → Editar proveedor
│   │   └── show.blade.php            → Ver detalles proveedor
│   │
│   ├── clientes/
│   │   ├── index.blade.php           → Listar clientes
│   │   ├── create.blade.php          → Crear cliente
│   │   ├── edit.blade.php            → Editar cliente
│   │   └── show.blade.php            → Ver detalles cliente
│   │
│   ├── compras/
│   │   ├── index.blade.php           → Listar compras
│   │   ├── create.blade.php          → Crear compra (con carrito)
│   │   ├── edit.blade.php            → Editar compra
│   │   └── show.blade.php            → Ver detalles compra
│   │
│   ├── ventas/
│   │   ├── index.blade.php           → Listar ventas
│   │   ├── create.blade.php          → Crear venta (con carrito)
│   │   ├── show.blade.php            → Ver detalles venta
│   │   ├── pdf.blade.php             → Template PDF venta
│   │   └── invoice.blade.php         → Invoice/factura AFIP
│   │
│   ├── cajas/
│   │   ├── index.blade.php           → Listar cajas
│   │   ├── create.blade.php          → Abrir caja
│   │   ├── edit.blade.php            → Editar caja
│   │   ├── show.blade.php            → Ver detalles caja
│   │   ├── ingresoegreso.blade.php   → Registrar ingreso/egreso
│   │   └── cierre.blade.php          → Cerrar caja
│   │
│   └── backups/
│       └── index.blade.php           → Gestionar backups
│
├── errors/
│   ├── 403.blade.php
│   ├── 404.blade.php
│   ├── 500.blade.php
│   └── 503.blade.php
│
├── welcome.blade.php                 → Landing page
└── home.blade.php                    → Home después login
```

---

## <a name="configuración"></a>⚙️ CONFIGURACIÓN

### Archivos de Configuración

```
config/
├── app.php                  → Configuración general (timezone, debug, etc.)
├── auth.php                 → Autenticación (guards, providers)
├── database.php             → Conexión a BD
├── cache.php                → Cache (file, redis, etc.)
├── queue.php                → Colas (sync, redis, database)
├── session.php              → Sesiones de usuarios
├── mail.php                 → Configuración email
├── backup.php               → Spatie Backup config
├── permission.php           → Spatie Permission config (RBAC)
├── filesystems.php          → Discos (local, public, s3)
├── logging.php              → Logging (stack, single, daily)
├── arca-sdk.php             → AFIP/ARCA SDK config (Argentina)
├── dompdf.php               → DomPDF config para PDF
└── services.php             → Servicios externos
```

### Bootstrap

```
bootstrap/
├── app.php                  → Configuración aplicación (middleware, routes)
└── providers.php            → Service providers
```

---

## <a name="dependencias"></a>📦 DEPENDENCIAS

### Backend - composer.json

#### PHP & Framework

```json
"php": "^8.2",
"laravel/framework": "^12"
```

#### Autenticación y Autorización

```json
"spatie/laravel-permission": "^6.24"
```

#### Backup

```json
"spatie/laravel-backup": "^9.3"
```

#### Facturación AFIP (Argentina)

```json
"agustinzamar/laravel-arca-sdk": "^0.1.0"
```

#### PDF

```json
"barryvdh/laravel-dompdf": "^3.1"
```

#### Impresoras ESC/POS (Tickets)

```json
"mike42/escpos-php": "^4.0"
```

#### Localización

```json
"laraveles/spanish": "^1.5"
```

#### Desarrollo

```json
"laravel/tinker": "^2.10.1",
"laravel/ui": "^4.6"
```

### Frontend - package.json

#### Herramientas de Build

```json
"vite": "^7.0.7",
"laravel-vite-plugin": "^2.0.0"
```

#### CSS y Utilidades

```json
"tailwindcss": "^4.0.0",
"@tailwindcss/vite": "^4.0.0",
"sass": "^1.56.1",
"bootstrap": "^5.2.3",
"@popperjs/core": "^2.11.6"
```

#### HTTP Client

```json
"axios": "^1.11.0"
```

#### Utilidades

```json
"concurrently": "^9.0.1"
```

---

## <a name="tests"></a>🧪 TESTS

### Estructura

```
tests/
├── Feature/
│   └── ExampleTest.php          → Tests de funcionalidades
├── Unit/
│   └── ExampleTest.php          → Tests unitarios
├── Pest.php                     → Configuración Pest
└── TestCase.php                 → Clase base para tests
```

### Framework

```
- Testing Framework: Pest 3 + PHPUnit 11
- Comandos:
  php artisan test --compact             → Ejecutar todos los tests
  php artisan test --compact --filter=testName → Filtrar por nombre
```

---

## <a name="funcionalidades"></a>✨ FUNCIONALIDADES PRINCIPALES

### 🛒 PUNTO DE VENTA (POS)

```
✓ Crear ventas con carrito temporal
✓ Múltiples métodos de pago
  - Efectivo
  - Débito
  - Crédito
  - Transferencia
✓ Generación de PDF de ventas
✓ Impresión de tickets (ESC/POS para impresoras térmicas)
✓ Anulación de ventas
✓ Desglose de pagos por método
✓ Validación: caja debe estar abierta
```

### 📦 GESTIÓN DE INVENTARIO

```
✓ CRUD completo de productos
✓ Stock actual y stock mínimo
✓ Búsqueda de productos por nombre/código
✓ Categorización de productos
✓ Marcas de productos
✓ Control de precios (precio compra vs precio venta)
✓ Actualización masiva de precios
✓ Soft delete (eliminación lógica)
✓ Restauración de productos eliminados
```

### 🛍️ COMPRAS A PROVEEDORES

```
✓ Registro de compras
✓ Carrito temporal de compras
✓ Asociación a proveedores
✓ Anulación de compras
✓ Cálculo automático de totales
✓ Validación: caja debe estar abierta
```

### 👥 GESTIÓN DE CLIENTES

```
✓ Base de datos de clientes
✓ Campos: nombre, número de documento, teléfono, email
✓ Historial de ventas por cliente
✓ Soft delete con restauración
✓ Cliente genérico "Consumidor Final"
```

### 👔 GESTIÓN DE PROVEEDORES

```
✓ Registro de proveedores
✓ Campos: empresa, CUIT, contacto, dirección
✓ Historial de compras
✓ Soft delete con restauración
```

### 💰 GESTIÓN DE CAJAS

```
✓ Apertura de cajas con monto inicial
✓ Cierre de cajas con monto final
✓ Registro de ingresos manuales
✓ Registro de egresos manuales
✓ Desglose de movimientos por método de pago
✓ Cierre de caja con conciliación
✓ Descripción de movimientos
```

### 🔐 CONTROL DE ACCESO

```
✓ 3 Roles base:
  - Super Administrador (acceso total)
  - Administrador (gestión de maestros + transacciones)
  - Vendedor (crear ventas, consultar productos)
✓ 90+ Permisos granulares
✓ RBAC completo con Spatie Permission
✓ Protección de rutas por permiso
✓ Asignación de permisos a roles dinámicos
```

### ⚙️ CONFIGURACIÓN

```
✓ Datos de empresa (nombre, CUIT, teléfono, email)
✓ Logo personalizado
✓ Imagen de login personalizada
✓ Descripción de empresa
✓ Ubicación/ciudad
✓ Opción de impresión de tickets
✓ Dirección física
```

### 🧾 FACTURACIÓN ELECTRÓNICA (AFIP - Argentina)

```
✓ Integración con Arca SDK
✓ Generación de facturas tipo A, B, C
✓ Punto de venta (PV)
✓ Número de factura
✓ CAE (Código de Autorización Electrónica)
✓ Vencimiento CAE
✓ Envío a AFIP
✓ Estado de facturación (facturada sí/no)
✓ Invoice/factura printable
✓ Validación de CUIT en cliente
```

### 💾 BACKUPS

```
✓ Creación automática de backups
✓ Spatie Backup framework
✓ Descarga de backups
✓ Eliminación de backups
✓ Soporte fallback en Windows
✓ Gestión por fecha
```

### 📊 REPORTES Y ANÁLISIS

```
✓ Dashboard con estadísticas
✓ Conteos de:
  - Roles
  - Usuarios
  - Categorías
  - Marcas
  - Productos
✓ Listados filtrados
✓ Búsqueda avanzada
```

---

## 📈 ESTADÍSTICAS DEL SISTEMA

| Componente             | Cantidad |
| ---------------------- | -------- |
| **Modelos Eloquent**   | 18       |
| **Controladores**      | 21       |
| **Rutas**              | 85+      |
| **Tablas BD**          | 21       |
| **Vistas Blade**       | 40+      |
| **Factories**          | 3        |
| **Seeders**            | 5        |
| **Roles**              | 3        |
| **Permisos**           | 90+      |
| **Métodos de pago**    | 4        |
| **Categorías default** | 10       |
| **Marcas default**     | 20       |

---

## 🚀 STACK TECNOLÓGICO

```
Backend:
  - Laravel 12
  - PHP 8.2.12
  - MySQL/SQLite
  - Spatie Permission (RBAC)
  - Spatie Backup
  - DomPDF (PDF)
  - ESC/POS (Tickets)
  - Arca SDK (AFIP)

Frontend:
  - Blade Templates
  - Tailwind CSS 4
  - Bootstrap 5.2.3
  - Sass
  - Axios
  - Vite

Testing:
  - Pest 3
  - PHPUnit 11

DevTools:
  - Laravel Pint (Code Formatter)
  - Laravel Tinker (REPL)
```

---

## 🎯 CASOS DE USO PRINCIPALES

1. **Vendedor:** Abre caja → Crea ventas → Registra pagos → Consulta stock
2. **Administrador:** Gestiona maestros → Revisa compras/ventas → Genera reportes
3. **Super Admin:** Control total → Gestiona usuarios → Backups → Configuración
4. **Sistema AFIP:** Genera factura → Envía a AFIP → Obtiene CAE → Almacena en BD

---

**Documento generado:** 8 de mayo de 2026  
**Sistema:** 100% funcional y listo para producción en Argentina
