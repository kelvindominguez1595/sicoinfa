
@php
    $params = '&codigo='.$codigo.'&codbarra='.$codbarra.'&categoria='.$categoria.'&marca='.$marca.'&nombre='.$nombre.'&almacen='.$almacen.'&pages='.$pages.'&estado='.$estado;
@endphp
@if(Auth::user()->hasRole('Admin'))
    @php $urlroute = 'productosold'; @endphp
@else
    @php $urlroute = 'inventarios'; @endphp
@endif
<th class="small">
    <a class="titletableorder d-flex justify-content-between" href="{{ url($urlroute.'?titletable=codigo&orderby='.$ordervali.$params) }}">
        Código
        @if($nametitle == 'codigo')
            @if($ordervali == 'ASC')
                <i class="fas fa-caret-up"></i>
            @else
                <i class="fas fa-caret-down"></i>
            @endif
        @else
            <i class="fas fa-caret-down"></i>
        @endif
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between" href="{{ url($urlroute.'?titletable=barra&orderby='.$ordervali.$params) }}">
            Código de Barra
        @if($nametitle == 'barra')
            @if($ordervali == 'ASC')
                <i class="fas fa-caret-up"></i>
            @else
                <i class="fas fa-caret-down"></i>
            @endif
        @else
            <i class="fas fa-caret-down"></i>
        @endif
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between" href="{{ url($urlroute.'?titletable=categoria&orderby='.$ordervali.$params) }}">
            Categoria
        @if($nametitle == 'categoria')
            @if($ordervali == 'ASC')
                <i class="fas fa-caret-up"></i>
            @else
                <i class="fas fa-caret-down"></i>
            @endif
        @else
            <i class="fas fa-caret-down"></i>
        @endif
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between" href="{{ url($urlroute.'?titletable=marca&orderby='.$ordervali.$params) }}">
            Marca
        @if($nametitle == 'marca')
            @if($ordervali == 'ASC')
                <i class="fas fa-caret-up"></i>
            @else
                <i class="fas fa-caret-down"></i>
            @endif
        @else
            <i class="fas fa-caret-down"></i>
        @endif
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between" href="{{ url($urlroute.'?titletable=nombre&orderby='.$ordervali.$params) }}">
            Nombre
        @if($nametitle == 'nombre')
            @if($ordervali == 'ASC')
                <i class="fas fa-caret-up"></i>
            @else
                <i class="fas fa-caret-down"></i>
            @endif
        @else
            <i class="fas fa-caret-down"></i>
        @endif
    </a>
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
