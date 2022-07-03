<ul class="navbar-nav ms-auto navbar-nav-scroll" style="--bs-scroll-height: 100px;">
    <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="{{ url('home') }}">
            <i class="fas fa-home"></i> Home
        </a>
    </li>
    @if(Auth::user()->hasRole('admin'))
        {{-- <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ url('/productosearchajax') }}">
                <i class="fas fa-cash-register"></i> Productos AJAX
            </a>
        </li> --}}
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
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ url('deudas') }}">
                <i class="fas fa-hand-holding-usd"></i> Deudas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ url('Reportes') }}">
                <i class="fas fa-print"></i> Reportes
            </a>
        </li>

    @else
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ url('inventarios') }}">
                <i class="fas fa-boxes"></i> Productos
            </a>
        </li>
    @endif

    <li class="nav-item dropdown dropdown-pull-right">
        <a class="nav-link" href="#" id="showNotifications" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="badge rounded-pill bg-primary position-relative">
                <span class="fas fa-bell"></span>
                @php
                    $count = 0;
                    @endphp
                @foreach(listNotification() as $item)
                    @if(verifiedCountState($item->id) == "VISTO")
                        @else
                        @php
                            $count += 1;
                            $count++;
                        @endphp
                     @endif

                @endforeach
                @if($count > 0)
                    <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle">
                             <span class="visually-hidden">New alerts</span>
                    </span>
                @endif
            </div>
        </a>

        <ul class="dropdown-menu" aria-labelledby="showNotifications">
            <li class="">
                <ul class=" scrollable-menu">
                    @foreach(listNotification() as $item)
                        <li >
                            @if(verifiedCountState($item->id) == "VISTO")
                                <a class="dropdown-item mt-1" href="{{ url('/bandejaNotificaciones?notificacion_id='.$item->id) }}">
                                    <i class="fas fa-store-alt"></i>
                                    <span class="fs-6 "> {{  $item->comentario ?? 'Hay Productos con nuevos Precios' }}</span>
                                    <br>
                                    <span class="ms-4 fst-italic"> <i class="far fa-clock"></i> {{ timeAgo($item->created_at) }}</span>
                                </a>
                            @else
                                <a class="dropdown-item bg-primary bg-opacity-25  mt-1" href="{{ url('/bandejaNotificaciones?notificacion_id='.$item->id) }}">
                                    <i class="fas fa-store-alt"></i>
                                    <span class="fs-6 fw-bold">{{  $item->comentario ?? 'Hay Productos con nuevos Precios' }}</span>
                                    <br>
                                    <span class="ms-4 fst-italic fw-bold"> <i class="far fa-clock"></i> {{ timeAgo($item->created_at) }}</span>
                                </a>
                            @endif

                        </li>
                    @endforeach
                </ul>

            </li>
            <li>
                <a class="dropdown-item text-center text-primary border-top  mt-1" href="{{url('/bandejaNotificaciones')}}">
                    Ver todo
                </a>
            </li>
        </ul>
    </li>

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
