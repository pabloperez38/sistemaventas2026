 <div class="sidebar-menu">
     <ul class="menu">
         <li class="sidebar-title">Menu</li>

         <li class="sidebar-item  {{ request()->is('admin') ? 'active' : '' }}">
             <a href="{{ url('/admin') }}" class='sidebar-link'>
                 <i class="bi bi-house-fill"></i>
                 <span>Inicio</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->is('admin/rol*') ? 'active' : '' }} ">
             <a href="{{ url('/admin/roles') }}" class='sidebar-link'>
                 <i class="bi bi-shield-check"></i>
                 <span>Roles</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->is('admin/usuario*') ? 'active' : '' }} ">
             <a href="{{ url('/admin/usuarios') }}" class='sidebar-link'>
                 <i class="bi bi-people-fill"></i>
                 <span>Usuarios</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->is('admin/categoria*') ? 'active' : '' }} ">
             <a href="{{ url('/admin/categorias') }}" class='sidebar-link'>
                 <i class="bi bi-tags"></i>
                 <span>Categorías</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->is('admin/marcas*') ? 'active' : '' }} ">
             <a href="{{ url('/admin/marcas') }}" class='sidebar-link'>
                 <i class="bi bi-bookmark-star"></i>
                 <span>Marcas</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->is('admin/proveedores*') ? 'active' : '' }} ">
             <a href="{{ url('/admin/proveedores') }}" class='sidebar-link'>
                 <i class="bi bi-truck"></i>
                 <span>Proveedores</span>
             </a>
         </li>
         <li class="sidebar-item {{ request()->is('admin/producto*') ? 'active' : '' }} ">
             <a href="{{ url('/admin/productos') }}" class='sidebar-link'>
                 <i class="bi bi-box-seam"></i>
                 <span>Productos</span>
             </a>
         </li>
         <li class="sidebar-title">Ajustes</li>

         <li class="sidebar-item {{ request()->is('admin/configuracion*') ? 'active' : '' }}">
             <a href="{{ url('/admin/configuracion') }}" class='sidebar-link'>
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

                     <a href="account" class="submenu-link">Perfil</a>

                 </li>
                 <li class="submenu-item">

                     <a href="account" class="submenu-link">Seguridad</a>

                 </li>

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
