@if (count($data)<=0) <tr>
    <td colspan="11">No hay resultados</td>
</tr>
@else
    <form id="form-updated" method="post" name="formulario1">
        @csrf
        @foreach ($data as $item)
            <tr>
                <td class="small">{{ $item->code }}</td>
                <td class="small">{{ $item->barcode }}</td>
                <td class="small">{{ $item->category_name }}</td>
                <td class="small">{{ $item->marca_name }}</td>
                <td class="small">
                    @if(Auth::user()->hasRole('Admin'))
                        <a href="{{ url("actualizaringresos",[$item->id, !isset($item->branch_offices_id) ? 1 : $item->branch_offices_id])}}">
                            {!! $item->name !!}
                        </a>
                    @else
                        {!! $item->name !!}
                    @endif
                </td>
                <td class="small"> {{ $item->cantidadnew }}</td>
                <td class="small"> {{ $item->medida_name }}</td>
                <td class="small">
                    <!-- precionuevo -->
                    @isset($item->description)
                        <a
                            href="#"
                            tabindex="0"
                            role="button"
                            data-bs-placement="left"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover focus"
                            title="Detalles"
                            data-bs-html="true"
                            data-bs-content='<div><?php echo $item->description ?></div>'
                        >
                            @isset($item->precioventa)
                                ${{number_format($item->precioventa,2)}}
                            @else
                                ${{number_format($item->sale_price,2)}}
                            @endisset
                        </a>
                    @else
                        @isset($item->precioventa)
                            ${{number_format($item->precioventa,2)}}
                        @else
                            ${{number_format($item->sale_price,2)}}
                        @endisset
                    @endisset

                </td>
                <td class="text-center">
                    @if(isset($item->costoconiva))
                        @php $costo = number_format($item->costoconiva,4); @endphp
                        <a
                            href="#"
                            tabindex="0"
                            role="button"
                            data-bs-placement="left"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover focus"
                            title="Costo (IVA Incluido)"
                            data-bs-html="true"
                            data-bs-content='<div> ${{ $costo }}</div>'
                        >
                            <i class="fas fa-eye"></i>
                        </a>
                    @elseif(isset($item->cost_c_iva))
                        @php $costo = number_format($item->cost_c_iva,4); @endphp
                        <a
                            href="#"
                            tabindex="0"
                            role="button"
                            data-bs-placement="left"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover focus"
                            title="Costo (IVA Incluido)"
                            data-bs-html="true"
                            data-bs-content='<div> ${{ $costo }}</div>'
                        >
                            <i class="fas fa-eye"></i>
                        </a>
                    @else
                        $0.00
                    @endisset
                </td>
                <td width="20px">
                    @if (!empty($item->image))
                    <img
                        class="imgzoom"
                        id="imgzoom"
                        src="/images/productos/{{$item->image}}"
                        width="20px"
                        height="20px"
                        data-pathimage="/images/productos/{{$item->image}}"
                        />
                    @else
                    <div class="masonry-thumbs grid-container grid-5" data-big="2"
                    data-lightbox="gallery"></div>
                    @endif


                </td>
                @if(Auth::user()->hasRole('Admin'))
                    <td>
                        <input type="hidden" name="idProducto[]" value="{{ $item->id }}"><input
                            type="number" name="update_quantity[]" id="update_quantity"
                            class="cantidad" style="width: 70px">
                    </td>
                @endif
            </tr>
        @endforeach
        <button type="button" id="Updated_canti" class="d-none"></button>
    </form>
@endif
