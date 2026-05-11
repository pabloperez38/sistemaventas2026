<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles principales del sistema
        $superAdmin = Role::firstOrCreate(['name' => 'Super Administrador']);
        $admin = Role::firstOrCreate(['name' => 'Administrador']);
        $vendedor = Role::firstOrCreate(['name' => 'Vendedor']);

        // Permisos
        // Configuración
        Permission::create(['name' => 'Ver Configuración'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Configuración'])->syncRoles($superAdmin);

        // Roles
        Permission::create(['name' => 'Ver Roles'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Roles'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Roles'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Roles'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Permisos Roles'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Actualizar Permisos Roles'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Roles'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Roles'])->syncRoles($superAdmin);

        // Usuarios
        Permission::create(['name' => 'Ver Usuarios'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Usuarios'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Usuarios'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Ver Detalles Usuarios'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Usuarios'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Usuarios'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Usuarios'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Restaurar Usuarios'])->syncRoles($superAdmin);

        // Categorias
        Permission::create(['name' => 'Ver Categorías'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Categorías'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Categorías'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Categorías'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Categorías'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Categorías'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Restaurar Categorías'])->syncRoles($superAdmin);

        // Marcas
        Permission::create(['name' => 'Ver Marcas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Marcas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Marcas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Marcas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Marcas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Marcas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Restaurar Marcas'])->syncRoles($superAdmin);

        // Productos
        Permission::create(['name' => 'Ver Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Ver Detalles Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Restaurar Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Actualizar Precios Productos'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Acción Actualizar Precios Productos'])->syncRoles($superAdmin);

        // Proveedores
        Permission::create(['name' => 'Ver Proveedores'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Proveedores'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Proveedores'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Ver Detalles Proveedores'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Proveedores'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Proveedores'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Proveedores'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Restaurar Proveedores'])->syncRoles($superAdmin);

        // Compras
        Permission::create(['name' => 'Ver Compras'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Compras'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Compras'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Ver Detalles Compras'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Anular Compras'])->syncRoles($superAdmin);

        // Clientes
        Permission::create(['name' => 'Ver Clientes'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Clientes'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Clientes'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Ver Detalles Clientes'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Clientes'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Clientes'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Clientes'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Restaurar Clientes'])->syncRoles($superAdmin);

        // Ventas
        Permission::create(['name' => 'Ver Ventas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Ventas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Ventas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Ver Detalles Ventas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Imprimir Ventas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Anular Ventas'])->syncRoles($superAdmin);

        // Cajas
        Permission::create(['name' => 'Ver Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Crear Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Ver Detalles Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Editar Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Editar Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Ingreso/Egreso Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Ingreso/Egreso Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Formulario Cierre Cajas'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Guardar Cierre Cajas'])->syncRoles($superAdmin);

        // Backups
        Permission::create(['name' => 'Ver Listado de Backups'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Crear Backups'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Descargar Backups'])->syncRoles($superAdmin);
        Permission::create(['name' => 'Eliminar Backups'])->syncRoles($superAdmin);

        // Facturación AFIP
        Permission::create(['name' => 'Facturación Elctrónica'])->syncRoles($superAdmin, $vendedor);
        Permission::create(['name' => 'Ver Facturación AFIP'])->syncRoles($superAdmin, $vendedor);
        Permission::create(['name' => 'Formulario Crear Facturación AFIP'])->syncRoles($superAdmin, $vendedor);
        Permission::create(['name' => 'Guardar Facturación AFIP'])->syncRoles($superAdmin, $vendedor);
        Permission::create(['name' => 'Ver Detalles Facturación AFIP'])->syncRoles($superAdmin, $vendedor);
        Permission::create(['name' => 'Imprimir Facturación AFIP'])->syncRoles($superAdmin, $vendedor);
        Permission::create(['name' => 'Anular Facturación AFIP'])->syncRoles($superAdmin, $vendedor);
        Permission::create(['name' => 'Invoice'])->syncRoles($superAdmin, $vendedor);
    }
}
