
@if(Auth::user()->hasRole('Admin'))
    @php $urlroute = 'productos'; @endphp
@else
    @php $urlroute = 'inventarios'; @endphp
@endif

<th class="small">
    <form action="{{ $urlroute }}" method="get" id="frmtitlecode">
        <div class="d-none">
                <input type="text" name="codigo" value="{{ $codigo }}">
                <input type="text" name="codbarra" value="{{ $codbarra }}">
                <input type="text" name="categoria" value="{{$categoria}}">
                <input type="text" name="marca" value="{{$marca}}">
                <input type="text" name="nombre" value="{{ $nombre }}">
                <select name="almacen" data-almacen="{{$almacen}}">
                    <option value="todos" @if($almacen=="todos") selected @endif>Todos</option>
                    @foreach ($almaceneslist as $item)
                        <option value="{{ $item->id }}" @if($almacen==$item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
                <select name="pages">
                    <option value="25"  @if ($pages == 25) selected @endif>25</option>
                    <option value="50"  @if ($pages == 50) selected @endif>50</option>
                    <option value="100"  @if ($pages == 100) selected @endif>100</option>
                </select>
                <select name="estado">
                    <option value="activos" @if ($estado == 'activos') selected @endif>Activos</option>
                    <option value="inactivos" @if ($estado == 'inactivos') selected @endif>Inactivos</option>
                </select>
        </div>
            <input type="hidden" name="orderby" value="{{ $ordertitleres != '' ? $ordertitleres : 'ASC'}}">
            <input type="hidden" name="nameorder" value="sk.code">
            <input type="hidden" name="page" id="page" value="{{ $data->currentPage() }}">
            <a class="titletableorder d-flex justify-content-between"
                href="#" onclick="document.getElementById('frmtitlecode').submit()">
                Código
                @if ($ordertitleres != '')
                    @if ($nameorder === 'sk.code')
                        @if ($ordertitleres === 'DESC')
                            <i class="fas fa-caret-down"></i>
                        @else
                            <i class="fas fa-caret-up"></i>
                        @endif
                    @endif
                @endif
            </a>
    </form>
</th>
<th class="small">
    <form action="{{ $urlroute }}" method="get" id="frmtitlebarcode">
        <div class="d-none">
                <input type="text" name="codigo" value="{{ $codigo }}">
                <input type="text" name="codbarra" value="{{ $codbarra }}">
                <input type="text" name="categoria" value="{{$categoria}}">
                <input type="text" name="marca" value="{{$marca}}">
                <input type="text" name="nombre" value="{{ $nombre }}">
                <select name="almacen" data-almacen="{{$almacen}}">
                    <option value="todos" @if($almacen=="todos") selected @endif>Todos</option>
                    @foreach ($almaceneslist as $item)
                        <option value="{{ $item->id }}" @if($almacen==$item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
                <select name="pages">
                    <option value="25"  @if ($pages == 25) selected @endif>25</option>
                    <option value="50"  @if ($pages == 50) selected @endif>50</option>
                    <option value="100"  @if ($pages == 100) selected @endif>100</option>
                </select>
                <select name="estado">
                    <option value="activos" @if ($estado == 'activos') selected @endif>Activos</option>
                    <option value="inactivos" @if ($estado == 'inactivos') selected @endif>Inactivos</option>
                </select>
        </div>
            <input type="hidden" name="orderby" value="{{ $ordertitleres != '' ? $ordertitleres : 'DESC'}}">
            <input type="hidden" name="nameorder" value="sk.barcode">
            <input type="hidden" name="page" id="page" value="{{ $data->currentPage() }}">
            <a class="titletableorder d-flex justify-content-between"
                href="#" onclick="document.getElementById('frmtitlebarcode').submit()">
                Código de Barra
                @if ($ordertitleres != '')
                    @if ($nameorder === 'sk.barcode')
                        @if ($ordertitleres === 'DESC')
                            <i class="fas fa-caret-down"></i>
                        @else
                            <i class="fas fa-caret-up"></i>
                        @endif
                    @endif
                @endif
            </a>
    </form>
</th>
<th class="small">
    <form action="{{ $urlroute }}" method="get" id="frmtitlecategoria">
        <div class="d-none">
                <input type="text" name="codigo" value="{{ $codigo }}">
                <input type="text" name="codbarra" value="{{ $codbarra }}">
                <input type="text" name="categoria" value="{{$categoria}}">
                <input type="text" name="marca" value="{{$marca}}">
                <input type="text" name="nombre" value="{{ $nombre }}">
                <select name="almacen" data-almacen="{{$almacen}}">
                    <option value="todos" @if($almacen=="todos") selected @endif>Todos</option>
                    @foreach ($almaceneslist as $item)
                        <option value="{{ $item->id }}" @if($almacen==$item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
                <select name="pages">
                    <option value="25"  @if ($pages == 25) selected @endif>25</option>
                    <option value="50"  @if ($pages == 50) selected @endif>50</option>
                    <option value="100"  @if ($pages == 100) selected @endif>100</option>
                </select>
                <select name="estado">
                    <option value="activos" @if ($estado == 'activos') selected @endif>Activos</option>
                    <option value="inactivos" @if ($estado == 'inactivos') selected @endif>Inactivos</option>
                </select>
        </div>
            <input type="hidden" name="orderby" value="{{ $ordertitleres != '' ? $ordertitleres : 'DESC'}}">
            <input type="hidden" name="nameorder" value="c.name">
            <input type="hidden" name="page" id="page" value="{{ $data->currentPage() }}">
            <a class="titletableorder d-flex justify-content-between"
                href="#" onclick="document.getElementById('frmtitlecategoria').submit()">
                Categoría
                @if ($ordertitleres != '')
                        @if ($nameorder === 'c.name')
                            @if ($ordertitleres === 'DESC')
                            <i class="fas fa-caret-down"></i>
                            @else
                            <i class="fas fa-caret-up"></i>
                        @endif
                    @endif
                @endif
            </a>
    </form>
</th>
<th class="small">
    <form action="{{ $urlroute }}" method="get" id="frmtitlemarca">
        <div class="d-none">
                <input type="text" name="codigo" value="{{ $codigo }}">
                <input type="text" name="codbarra" value="{{ $codbarra }}">
                <input type="text" name="categoria" value="{{$categoria}}">
                <input type="text" name="marca" value="{{$marca}}">
                <input type="text" name="nombre" value="{{ $nombre }}">

                <select name="almacen" data-almacen="{{$almacen}}">
                    <option value="todos" @if($almacen=="todos") selected @endif>Todos</option>
                    @foreach ($almaceneslist as $item)
                        <option value="{{ $item->id }}" @if($almacen==$item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>

                <select name="pages">
                    <option value="25"  @if ($pages == 25) selected @endif>25</option>
                    <option value="50"  @if ($pages == 50) selected @endif>50</option>
                    <option value="100"  @if ($pages == 100) selected @endif>100</option>
                </select>

                <select name="estado">
                    <option value="activos" @if ($estado == 'activos') selected @endif>Activos</option>
                    <option value="inactivos" @if ($estado == 'inactivos') selected @endif>Inactivos</option>
                </select>

        </div>
            <input type="hidden" name="orderby" value="{{ $ordertitleres != '' ? $ordertitleres : 'DESC'}}">
            <input type="hidden" name="nameorder" value="man.name">
            <input type="hidden" name="page" id="page" value="{{ $data->currentPage() }}">
            <a class="titletableorder d-flex justify-content-between"
                href="#" onclick="document.getElementById('frmtitlemarca').submit()">
                Marca
                @if ($ordertitleres != '')
                    @if ($nameorder === 'man.name')
                        @if ($ordertitleres === 'DESC')
                            <i class="fas fa-caret-down"></i>
                        @else
                            <i class="fas fa-caret-up"></i>
                        @endif
                    @endif
                @endif
            </a>
    </form>
</th>
<th class="small">
    <form action="{{ $urlroute }}" method="get" id="frmtitlename">
        <div class="d-none">
                <input type="text" name="codigo" value="{{ $codigo }}">
                <input type="text" name="codbarra" value="{{ $codbarra }}">
                <input type="text" name="categoria" value="{{$categoria}}">
                <input type="text" name="marca" value="{{$marca}}">
                <input type="text" name="nombre" value="{{ $nombre }}">

                <select name="almacen" data-almacen="{{$almacen}}">
                    <option value="todos" @if($almacen=="todos") selected @endif>Todos</option>
                    @foreach ($almaceneslist as $item)
                        <option value="{{ $item->id }}" @if($almacen==$item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>

                <select name="pages">
                    <option value="25"  @if ($pages == 25) selected @endif>25</option>
                    <option value="50"  @if ($pages == 50) selected @endif>50</option>
                    <option value="100"  @if ($pages == 100) selected @endif>100</option>
                </select>

                <select name="estado">
                    <option value="activos" @if ($estado == 'activos') selected @endif>Activos</option>
                    <option value="inactivos" @if ($estado == 'inactivos') selected @endif>Inactivos</option>
                </select>

        </div>
            <input type="hidden" name="orderby" value="{{ $ordertitleres != '' ? $ordertitleres : 'DESC'}}">
            <input type="hidden" name="nameorder" value="sk.name">
            <input type="hidden" name="page" id="page" value="{{ $data->currentPage() }}">

            <a class="titletableorder d-flex justify-content-between"
                href="#" onclick="document.getElementById('frmtitlename').submit()">
                Nombre
                @if ($ordertitleres != '')
                    @if ($nameorder === 'sk.name')
                        @if ($ordertitleres === 'DESC')
                            <i class="fas fa-caret-down"></i>
                            @else
                            <i class="fas fa-caret-up"></i>
                        @endif
                    @endif
                @endif
            </a>
    </form>
</th>
<th class="small">
    Cantidad
</th>
<th class="small">
    Unidad
</th>
<th class="small">
    P/Venta
</th>
<th class="small">
    Costo
</th>
<th class="small">Imagen</th>
@if(Auth::user()->hasRole('Admin'))
<th class="small">Ajuste</th>
@endif
