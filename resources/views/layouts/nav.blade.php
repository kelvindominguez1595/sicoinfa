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
                <li><a class="dropdown-item" href="{{ url('ingresos') }}"><i class="fas fa-dolly"></i> Ingreso de facturas</a></li>
                <li><a class="dropdown-item" href="{{ url('marcas') }}"><i class="fas fa-tags"></i> Marcas</a></li>
                <li><a class="dropdown-item" href="{{ url('categorias') }}"><i class="fas fa-sitemap"></i> Categorías</a></li>
                <li><a class="dropdown-item" href="{{ url('medidas') }}"><i class="fas fa-ruler"></i> Medidas</a></li>
                <li><a class="dropdown-item" href="{{ url('proveedores') }}"><i class="fas fa-user-tag"></i> Proveedores</a></li>
                <li><a class="dropdown-item" href="{{ route('productos.create') }}"><i class="fas fa-plus"></i> Nuevo producto</a></li>
                <li><a class="dropdown-item" href="{{ url('productos') }}"><i class="fas fa-store-alt"></i> Productos</a></li>
                <li><a class="dropdown-item" href="{{ url('historialcompras') }}"><i class="fas fa-list"></i> Históricos de Compra</a></li>

            </ul>
        </li>
        <li class="nav-item dropdown dropdown-pull-right">
            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-industry"></i>
                Sucursal
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                <li><a class="dropdown-item" href="{{ url('sucursales') }}"><i class="fas fa-industry"></i> Sucursales</a></li>
                <li><a class="dropdown-item" href="#"><i class="fas fa-shipping-fast"></i> Abastecer sucursal</a></li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ url('clientes') }}">
                <i class="fas fa-address-book"></i> Clientes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ url('empleados') }}">
                <i class="fas fa-user-tie"></i> Empleados
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ url('usuarios') }}">
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
                <li><a class="dropdown-item" href="{{ url('/porcentaje') }}"><i class="fas fa-file-csv"></i> Porcentaje</a></li>
                <li><a class="dropdown-item" href="{{ url('/rendimiento') }}"><i class="fas fa-file-csv"></i> Rendimiento de Venta Por Producto</a></li>
                <li><a class="dropdown-item" href="{{ url('/promedio') }}"><i class="fas fa-file-csv"></i> Promedios</a></li>
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('inventarios') }}">
                <i class="fas fa-boxes"></i> Productos
            </a>
        </li>
    @endif
    <li class="nav-item dropdown dropdown-pull-right">
        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

            @isset(Auth::user()->picture)
                @if (file_exists(asset('/images/usuarios/'.Auth::user()->picture)))
                    <img
                        src="/images/logoFerreteria.png"
                        class="rounded-circle"
                        height="25"
                        alt="Avatar"
                        loading="lazy"
                    />
                    @else
                    <img
                        src="{{ asset('/images/usuarios/'.Auth::user()->picture) }}"
                        class="rounded-circle"
                        height="25"
                        alt="Avatar"
                        loading="lazy"
                    />
                @endif
            @else
                <img
                    src="/images/logoFerreteria.png"
                    class="rounded-circle"
                    height="25"
                    alt="Avatar"
                    loading="lazy"
                />
            @endisset

        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li class="border-bottom"><label class="ms-4 mb-2">{{ Auth::user()->name }}</label></li>
            <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fas fa-cog"></i> Configuración</a></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    {{ __('Cerrar Sesión') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
            </li>
        </ul>
    </li>
</ul>
