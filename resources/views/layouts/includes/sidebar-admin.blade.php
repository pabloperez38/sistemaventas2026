<div class="sidebar-menu">
    <ul class="menu">

        <li class="sidebar-title">Menu</li>

        <!-- 🔹 Inicio -->
        <li class="sidebar-item {{ request()->routeIs('home', 'admin.index') ? 'active' : '' }}">
            <a href="{{ route('admin.index') }}" class='sidebar-link'>
                <i class="bi bi-house-fill"></i>
                <span>Inicio</span>
            </a>
        </li>

        <!-- 🔹 Caja -->
        <li class="sidebar-item {{ request()->routeIs('admin.cajas.*') ? 'active' : '' }}">
            <a href="{{ route('admin.cajas.index') }}" class='sidebar-link'>
                <i class="bi bi-cash-stack"></i>
                <span>Cajas</span>
            </a>
        </li>

        <!-- 🔹 Comercial -->
        <li class="sidebar-item has-sub {{ request()->routeIs('admin.ventas.*', 'admin.compras.*') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-graph-up"></i>
                <span>Comercial</span>
            </a>

            <ul class="submenu">
                <li class="submenu-item {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.ventas.index') }}" class="submenu-link">
                        Ventas
                    </a>
                </li>

                <li class="submenu-item {{ request()->routeIs('admin.compras.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.compras.index') }}" class="submenu-link">
                        Compras
                    </a>
                </li>
            </ul>
        </li>

        <!-- 🔹 Personas -->
        <li
            class="sidebar-item has-sub {{ request()->routeIs('admin.usuarios.*', 'admin.clientes.*', 'admin.proveedores.*') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-people-fill"></i>
                <span>Personas</span>
            </a>

            <ul class="submenu">

                <li class="submenu-item {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.usuarios.index') }}" class="submenu-link">
                        Usuarios
                    </a>
                </li>

                <li class="submenu-item {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.clientes.index') }}" class="submenu-link">
                        Clientes
                    </a>
                </li>

                <li class="submenu-item {{ request()->routeIs('admin.proveedores.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.proveedores.index') }}" class="submenu-link">
                        Proveedores
                    </a>
                </li>

            </ul>
        </li>

        <!-- 🔹 Productos -->
        <li
            class="sidebar-item has-sub {{ request()->routeIs('admin.productos.*', 'admin.categorias.*', 'admin.marcas.*') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-box-seam"></i>
                <span>Productos</span>
            </a>

            <ul class="submenu">

                <li class="submenu-item {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.productos.index') }}" class="submenu-link">
                        Productos
                    </a>
                </li>

                <li class="submenu-item {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categorias.index') }}" class="submenu-link">
                        Categorías
                    </a>
                </li>

                <li class="submenu-item {{ request()->routeIs('admin.marcas.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.marcas.index') }}" class="submenu-link">
                        Marcas
                    </a>
                </li>

                 <li class="submenu-item {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
                    <a href="{{ route('admin.productos.updatePrice') }}" class="submenu-link">
                        Actualizar precios
                    </a>
                </li>

            </ul>
        </li>

        <!-- 🔹 Seguridad -->
        <li class="sidebar-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
            <a href="{{ route('admin.roles.index') }}" class='sidebar-link'>
                <i class="bi bi-shield-check"></i>
                <span>Roles</span>
            </a>
        </li>

        <!-- 🔹 Backups -->
        <li class="sidebar-item {{ request()->routeIs('admin.backups.*') ? 'active' : '' }}">
            <a href="{{ route('admin.backups.index') }}" class='sidebar-link'>
                <i class="bi bi-hdd"></i>
                <span>Backups</span>
            </a>
        </li>

        <li class="sidebar-title">Ajustes</li>

        <!-- 🔹 Config -->
        <li class="sidebar-item {{ request()->routeIs('admin.configuracion.*') ? 'active' : '' }}">
            <a href="{{ route('admin.configuracion.index') }}" class='sidebar-link'>
                <i class="bi bi-gear-fill"></i>
                <span>Configuración</span>
            </a>
        </li>

        <!-- 🔹 Usuario -->
        <li class="sidebar-item has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-person-circle"></i>
                <span>{{ Auth::user()->name }}</span>
            </a>

            <ul class="submenu">
                <li class="submenu-item">
                    <a href="{{ route('logout') }}" class="submenu-link"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Cerrar sesión
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="post" style="display: none">
                        @csrf
                        @method('POST')
                    </form>
                </li>
            </ul>
        </li>

    </ul>
</div>
