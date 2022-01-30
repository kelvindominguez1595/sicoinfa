<ul class="navbar-nav ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ url('home') }}">
            <i class="fas fa-home"></i> Home
        </a>
    </li>
    @if(Auth::user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="">
                <i class="fas fa-cash-register"></i> Facturar
            </a>
        </li>
        <li class="nav-item dropdown dropdown-pull-right">
            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-boxes"></i>
                Producto
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                <li><a class="dropdown-item" href=""><i class="fas fa-tags"></i> Marcas</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-sitemap"></i> Categorías</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-ruler"></i> Medidas</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-user-tag"></i> Proveedores</a></li>
                <li><a class="dropdown-item" href="{{ url('productos') }}"><i class="fas fa-store-alt"></i> Productos</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-list"></i> Lista de Entrada de Productos</a></li>

            </ul>
        </li>
        <li class="nav-item dropdown dropdown-pull-right">
            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-industry"></i>
                Sucursal
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                <li><a class="dropdown-item" href=""><i class="fas fa-industry"></i> Sucursales</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-shipping-fast"></i> Abastecer sucursal</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="">
                <i class="fas fa-address-book"></i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="">
                <i class="fas fa-user-tie"></i> Empleados
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="">
                <i class="fas fa-users"></i> Usuarios
            </a>
        </li>
        <li class="nav-item dropdown dropdown-pull-right">
            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-print"></i>
                Reportes
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                <li><a class="dropdown-item" href=""><i class="fas fa-file-csv"></i> Reporte DET</a></li>

            </ul>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('productos') }}">
                <i class="fas fa-boxes"></i> Productos
            </a>
        </li>
    @endif
    <li class="nav-item dropdown dropdown-pull-right">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img
                src="https://mdbcdn.b-cdn.net/img/new/avatars/2.webp"
                class="rounded-circle"
                height="25"
                alt="Black and White Portrait of a Man"
                loading="lazy"
            />  {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configuración</a></li>
            <li><a class="dropdown-item" href="#">


                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('Cerrar Sesión') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </a></li>
        </ul>
    </li>
</ul>
