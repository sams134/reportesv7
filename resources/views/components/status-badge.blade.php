@props(['status_id' => -1 ])
@switch($status_id)
    @case(-1)
    @case(null)
        <span class="badge badge-soft-warning">No Asignado</span>
        @break
    @case(0)
        <span class="badge badge-soft-danger">No Autorizado</span>
        @break
    @case(1)
        <span class="badge badge-soft-primary">Diagnóstico</span>
        @break
    @case(2)
        <span class="badge badge-soft-info">Diagnóstico pendiente de autorización</span>
        @break
    @case(3)
        <span class="badge badge-soft-info">Autorizado Parcial / Ver Pendientes</span>
        @break
    @case(4)
        <span class="badge badge-soft-success">Autorizado Completamente</span>
        @break
    @case(5)
        <span class="badge badge-soft-warning">Retrasado</span>
        @break
    @case(6)
        <span class="badge badge-soft-dark">Garantía</span>
        @break
    @case(7)
        <span class="badge badge-soft-danger">Emergencia</span>
        @break
    @case(8)
        <span class="badge badge-soft-danger">Alta Emergencia</span>
        @break
    @case(9)
        <span class="badge badge-soft-success">Finalizado</span>
        @break
    @case(10)
        <span class="badge badge-soft-warning">En Traslado</span>
        @break
    @case(11)
        <span class="badge badge-soft-secondary">Entregado sin reparación</span>
        @break
    @case(12)
        <span class="badge badge-soft-info">EPF</span>
        @break
    @case(13)
        <span class="badge badge-soft-warning">Aceptación, Pendiente Facturación</span>
        @break
    @case(14)
        <span class="badge badge-soft-warning">Facturado, Pendiente de pago</span>
        @break
    @case(15)
        <span class="badge badge-soft-success">Pagado</span>
        @break
    @default
        {{$status_id}}
@endswitch

