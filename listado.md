# Listado Detallado del Sistema

## Módulos y Funcionalidad

**Administración / Dashboard**
- Ruta: `GET /admin`
- Muestra totales de roles, usuarios, categorías, marcas y productos.

**Configuración de Empresa**
- Rutas: `GET /admin/configuracion`, `PUT /admin/configuracion`
- Datos: nombre, dirección, teléfono, email, descripción, CUIT, ciudad, logo, imagen de login, impresión de ticket.
- Archivos subidos se guardan en `storage` público y reemplazan el anterior.

**Roles y Permisos**
- Rutas: `GET /admin/roles`, `GET /admin/roles/create`, `POST /admin/roles`, `GET /admin/roles/{role}/edit`, `PUT /admin/roles/{role}`, `DELETE /admin/roles/{role}`
- Permisos: `GET /admin/roles/{role}/permisos`, `PUT /admin/roles/{role}/update_permisos`
- Agrupa permisos por módulo (configuración, roles, usuarios, categorías, marcas, productos, proveedores, compras, clientes, ventas, cajas).

**Usuarios**
- Rutas: `GET /admin/usuarios`, `GET /admin/usuarios/create`, `POST /admin/usuarios`, `GET /admin/usuarios/{id}`, `GET /admin/usuarios/{id}/edit`, `PUT /admin/usuarios/{id}`, `DELETE /admin/usuarios/{id}`
- Alta con rol, validación de email único, password mínimo con confirmación.
- No permite eliminar el usuario principal (id=1).

**Categorías**
- Rutas: `GET /admin/categorias`, `GET /admin/categorias/create`, `POST /admin/categorias`, `GET /admin/categorias/{id}/edit`, `PUT /admin/categorias/{id}`, `DELETE /admin/categorias/{id}`, `GET /categorias/{id}/restore`
- Soft delete con cascada lógica sobre productos.

**Marcas**
- Rutas: `GET /admin/marcas`, `GET /admin/marcas/create`, `POST /admin/marcas`, `GET /admin/marcas/{id}/edit`, `PUT /admin/marcas/{id}`, `DELETE /admin/marcas/{id}`, `GET /marcas/{id}/restore`
- Soft delete con cascada lógica sobre productos.

**Productos**
- Rutas: `GET /admin/productos`, `GET /admin/productos/create`, `POST /admin/productos`, `GET /admin/productos/{id}/show`, `GET /admin/productos/{id}/edit`, `PUT /admin/productos/{id}`, `DELETE /admin/productos/{id}`, `GET /productos/restaurar/{id}`
- Búsqueda por nombre o código, paginación 10.
- Campos clave: código, categoría, marca, precios, stock, stock mínimo.
- Soft delete y flag `activo`.

**Proveedores**
- Rutas: `GET /admin/proveedores`, `GET /admin/proveedores/create`, `POST /admin/proveedores`, `GET /admin/proveedores/{id}`, `GET /admin/proveedores/{id}/edit`, `PUT /admin/proveedores/{id}`, `DELETE /admin/proveedores/{id}`, `GET /proveedores/restaurar/{id}`
- Campos: empresa, CUIT, nombre, teléfono, email, dirección.
- Soft delete y flag `activo`.

**Clientes**
- Rutas: `GET /admin/clientes`, `GET /admin/clientes/create`, `POST /admin/clientes`, `GET /admin/clientes/{id}`, `GET /admin/clientes/{id}/edit`, `PUT /admin/clientes/{id}`, `DELETE /admin/clientes/{id}`, `GET /clientes/restaurar/{id}`
- Campos: nombre, documento, teléfono, email.
- Soft delete.

**Compras**
- Rutas: `GET /admin/compras`, `GET /admin/compras/create`, `POST /admin/compras`, `GET /admin/compras/{id}`, `PUT /admin/compras/{id}/anular`
- Carrito temporal: `POST /admin/compras/create/tmp`, `DELETE /admin/compras/create/tmp/{id}`, `POST /admin/compras/actualizar-precio`
- Al guardar: crea compra + detalle, actualiza stock y precio de compra, registra egreso en caja.
- Anulación: revierte stock, marca compra inactiva y registra ingreso compensatorio en caja.

**Ventas**
- Rutas: `GET /admin/ventas`, `GET /admin/ventas/create`, `POST /admin/ventas`, `GET /admin/ventas/{id}`, `PUT /admin/ventas/{id}/anular`, `GET /admin/ventas/pdf/{id}`
- Carrito temporal: `POST /admin/ventas/create/tmp`, `DELETE /admin/ventas/create/tmp/{id}`, `POST /admin/ventas/actualizar-precio`
- Multipago: acepta varios métodos y montos; solo efectivo impacta caja.
- Validación: total pagado debe cubrir el total de la venta.
- Anulación: devuelve stock, marca venta inactiva, registra egreso en caja, límite 7 días.
- PDF con total en letras.
- Ticket físico por ESC/POS si está activada la impresión en configuración.

**Caja**
- Rutas: `GET /admin/cajas`, `GET /admin/cajas/create`, `POST /admin/cajas`, `GET /admin/cajas/{id}`, `GET /admin/cajas/{id}/edit`, `PUT /admin/cajas/{id}`, `GET /admin/cajas/{id}/ingreso-egreso`, `POST /admin/cajas/{id}/ingreso-egreso`, `GET /admin/cajas/{id}/cerrar`, `POST /admin/cajas/{id}/cierre`
- Apertura/cierre de caja, movimientos manuales y detalle de saldos.
- Totales por método: efectivo, débito, crédito, transferencia.

**Backups**
- Rutas: `GET /admin/backups`, `POST /admin/backups/create`, `GET /admin/backups/{file}/download`, `DELETE /admin/backups/{file}/delete`
- Usa Spatie Backup con fallback por ejecución directa de `php.exe`.

## Modelos y Relaciones
- `User` pertenece a roles (Spatie) y se usa en ventas como vendedor.
- `Categoria` tiene muchos `Producto` (soft delete en cascada lógica).
- `Marca` tiene muchos `Producto` (soft delete en cascada lógica).
- `Producto` pertenece a `Categoria` y `Marca`, tiene stock y precios.
- `Proveedor` tiene muchas `Compra`.
- `Cliente` tiene muchas `Venta`.
- `Compra` tiene muchos `DetalleCompra`, pertenece a `Proveedor` y a `Caja`.
- `Venta` tiene muchos `DetalleVenta`, pertenece a `Cliente`, a `User` y a `Caja`.
- `Pago` pertenece a `Venta` y referencia un `MetodoPago`.
- `Caja` tiene muchos `MovimientoCaja`, `Venta` y `Compra`.
- `MovimientoCaja` tiene muchos `MovimientoCajaMetodo`.

## Vistas
- Backend en `resources/views/admin/*` por módulo.
- Auth en `resources/views/auth/*`.

## Observaciones
- Existe ruta `GET /admin/test-ticket` pero no hay método `testTicket` en `VentaController`.
- Controladores sin uso: `DetalleCompraController`, `DetalleVentaController`, `MovimientoCajaController`.
