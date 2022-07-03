
@foreach($listNoti as $item )
    <a href="{{ url('/bandejaNotificaciones?notificacion_id='.$item->id) }}"
       style="text-decoration: none; color: #000000;" >

        <div class="card border-bottom shadow-sm mb-2
        @if($notyid == $item->id)
        bg-secondary text-white
        @endif
         @if(verifiedCountState($item->id) == "VISTO")
         @else fw-bold bg-primary bg-opacity-25 @endif"
        >
            <div class="card-body">

                <div class="row mb-2">
                    <div class="col-6">
                        <i class="fas fa-history"></i> Historial
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <div>                        
                            <i class="fas fa-clock"></i>
                            {{ timeAgo($item->created_at) }}
                        </div>
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-12  ">
                        {{  $item->comentario ?? 'Hay Productos con nuevos Precios' }}
                    </div>
                </div>
            </div>
        </div>
    </a>
@endforeach
