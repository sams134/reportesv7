
@props(['status_id' => -1, ])
@switch($status_id)
    @case(-1)
    <span class="badge badge-soft-warning">No Asignado</span>
        @break
    @case(1)
    <span class="badge badge-soft-primary">Diagnostico</span>
        @break
    @case(1)
        <span class="badge badge-soft-primary">Pend. Autorización</span>
    @break
    @default
        {{$status_id}}
@endswitch
