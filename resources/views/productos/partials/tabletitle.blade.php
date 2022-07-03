
@if(Auth::user()->hasRole('Admin'))
    @php $urlroute = 'productos'; @endphp
@else
    @php $urlroute = 'inventarios'; @endphp
@endif


<th class="small">
        Código

</th>
<th class="small">
            Código de Barra


</th>
<th class="small">
            Categoria

</th>
<th class="small">
            Marca

</th>
<th class="small">
            Nombre

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
