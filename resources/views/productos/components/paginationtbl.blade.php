<div class="d-flex justify-content-between mt-3" id="pagination">
    <div>Mostrando {{ $data->firstItem() }}  a  {{ $data->lastItem() }} de {{ $data->total() }} registros.</div>
    <div>
        {!! $data->links(); !!}
    </div>
</div>
