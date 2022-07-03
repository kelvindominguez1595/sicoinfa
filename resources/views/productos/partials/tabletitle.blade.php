
@if(Auth::user()->hasRole('Admin'))
    @php $urlroute = 'loadproducts'; @endphp
@else
    @php $urlroute = 'loadproductsother'; @endphp
@endif

<th class="small">
    <input type="hidden" name="orderglobapagination" id="orderglobapagination">
    <input type="hidden" name="nameorderglobal" id="nameorderglobal">
    <a class="titletableorder d-flex justify-content-between"
         href="#" id="codetitle"
         data-order="ASC"
         data-router="{{ $urlroute }}"
         data-nameorder="sk.code">
        Código
        <div id="codeicocontent"></div>
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between"
         href="#" id="barcodetitle"
         data-order="DESC"
         data-router="{{ $urlroute }}"
         data-nameorder="sk.barcode">
        Código de Barra
        <div id="barcodeicocontent"></div>
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between"
         href="#" id="categoriatitle"
         data-order="DESC"
         data-router="{{ $urlroute }}"
         data-nameorder="category_name">
        Categoria
        <div id="categoriaicocontent"></div>
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between"
         href="#" id="marcatitle"
         data-order="DESC"
         data-router="{{ $urlroute }}"
         data-nameorder="marca_name">
        Marca
        <div id="marcaicocontent"></div>
    </a>
</th>
<th class="small">
    <a class="titletableorder d-flex justify-content-between"
         href="#" id="nombretitle"
         data-order="DESC"
         data-router="{{ $urlroute }}"
         data-nameorder="sk.name">
        Nombre
        <div id="nombreicocontent"></div>
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
