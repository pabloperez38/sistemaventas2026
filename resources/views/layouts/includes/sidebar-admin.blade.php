 <div class="sidebar-menu">
     <ul class="menu">
         <li class="sidebar-title">Menu</li>

         <li class="sidebar-item {{ request()->routeIs('home', 'admin.index') ? 'active' : '' }}">
             <a href="{{ route('admin.index') }}" class='sidebar-link'>
                 <i class="bi bi-house-fill"></i>
                 <span>Inicio</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->routeIs('admin.cajas.*') ? 'active' : '' }}">
             <a href="{{ route('admin.cajas.index') }}" class='sidebar-link'>
                 <i class="bi bi-cash-stack"></i>
                 <span>Cajas</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
             <a href="{{ route('admin.roles.index') }}" class='sidebar-link'>
                 <i class="bi bi-shield-check"></i>
                 <span>Roles</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">
             <a href="{{ route('admin.usuarios.index') }}" class='sidebar-link'>
                 <i class="bi bi-people-fill"></i>
                 <span>Usuarios</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.categorias.*') ? 'active' : '' }}">
             <a href="{{ route('admin.categorias.index') }}" class='sidebar-link'>
                 <i class="bi bi-tags"></i>
                 <span>Categorías</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.marcas.*') ? 'active' : '' }}">
             <a href="{{ route('admin.marcas.index') }}" class='sidebar-link'>
                 <i class="bi bi-bookmark-star"></i>
                 <span>Marcas</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.proveedores.*') ? 'active' : '' }}">
             <a href="{{ route('admin.proveedores.index') }}" class='sidebar-link'>
                 <i class="bi bi-truck"></i>
                 <span>Proveedores</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.compras.*') ? 'active' : '' }}">
             <a href="{{ route('admin.compras.index') }}" class='sidebar-link'>
                 <i class="bi bi-cart-check"></i>
                 <span>Compras</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.productos.*') ? 'active' : '' }}">
             <a href="{{ route('admin.productos.index') }}" class='sidebar-link'>
                 <i class="bi bi-box-seam"></i>
                 <span>Productos</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.clientes.*') ? 'active' : '' }}">
             <a href="{{ route('admin.clientes.index') }}" class='sidebar-link'>
                 <i class="bi bi-person-badge"></i>
                 <span>Clientes</span>
             </a>
         </li>

         <li class="sidebar-item {{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}">
             <a href="{{ route('admin.ventas.index') }}" class='sidebar-link'>
                 <i class="bi bi-currency-dollar"></i>
                 <span>Ventas</span>
             </a>
         </li>

         <li class="sidebar-title">Ajustes</li>

         <li class="sidebar-item {{ request()->routeIs('admin.configuracion.*') ? 'active' : '' }}">
             <a href="{{ route('admin.configuracion.index') }}" class='sidebar-link'>
                 <i class="bi bi-gear-fill"></i>
                 <span>Configuración</span>
             </a>
         </li>

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
