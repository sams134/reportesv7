@props(['active' => 1, ])

<div class="card theme-wizard mb-5">
    <div class="card-header bg-light pt-3 pb-2">
        <ul class="nav justify-content-between nav-wizard">
            <li class="nav-item"><a class="nav-link active fw-semi-bold" wire:click="gotoStep(0)" href="#bootstrap-wizard-tab1"
                    data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                        class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="far fa-address-card"></span></span></span><span
                        class="d-none d-md-block mt-1 fs--1">Datos del Cliente</span></a></li>
            <li class="nav-item"><a class="nav-link fw-semi-bold" wire:click="gotoStep(1)" href="#bootstrap-wizard-tab2"
                    data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                        class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="fas fa-list"></span></span></span><span
                        class="d-none d-md-block mt-1 fs--1">Datos del Equipo</span></a></li>
            <li class="nav-item"><a class="nav-link fw-semi-bold" wire:click="gotoStep(2)" href="#bootstrap-wizard-tab3"
                    data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                        class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="fas fa-clipboard-list"></span></span></span><span
                        class="d-none d-md-block mt-1 fs--1">Inventario de Partes</span></a></li>
            <li class="nav-item"><a class="nav-link fw-semi-bold" wire:click="gotoStep(3)" href="#bootstrap-wizard-tab4"
                    data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                        class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="fas fa-photo-video"></span></span></span><span
                        class="d-none d-md-block mt-1 fs--1">Fotografias Ingreso</span></a></li>
            <li class="nav-item"><a class="nav-link fw-semi-bold" wire:click="gotoStep(4)" href="#bootstrap-wizard-tab5"
                    data-bs-toggle="tab" data-wizard-step="data-wizard-step"><span
                        class="nav-item-circle-parent"><span class="nav-item-circle"><span
                                class="fas fa-thumbs-up"></span></span></span><span
                        class="d-none d-md-block mt-1 fs--1">Revision Final </span></a></li>
        </ul>
    </div>
    <div class="card-body py-4">
        <div class="tab-content">
            <div class="tab-pane @if ($active==1) active @endif px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1"
                id="bootstrap-wizard-tab1">
                {{$tab1}}
            </div>
            <div class="tab-pane @if ($active==2) active @endif px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab2"
                id="bootstrap-wizard-tab2">
                {{$tab2}}
            </div>
            <div class="tab-pane @if ($active==3) active @endif px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab3"
                id="bootstrap-wizard-tab3">
                {{$tab3}}
            </div>
            <div class="tab-pane @if ($active==4) active @endif px-sm-3 px-md-5" role="tabpanel" aria-labelledby="bootstrap-wizard-tab4"
                id="bootstrap-wizard-tab4">
                {{$tab4}}
            </div>
            <div class="tab-pane  px-sm-3 px-md-5" role="tabpanel"
                aria-labelledby="bootstrap-wizard-tab5" id="bootstrap-wizard-tab5">
             
                {{$tab5}}
               
               
            </div>
        </div>
    </div>
    <div class="card-footer bg-light">
        <div class="px-sm-3 px-md-5">
            <ul class="pager wizard list-inline mb-0">
                <li class="previous">
                    <button class="btn btn-link ps-0" type="button"><span class="fas fa-chevron-left me-2"
                            data-fa-transform="shrink-3"></span>Anterior</button>
                </li>
                <li class="end">
                    <button class="btn btn-primary px-5 px-sm-6 d-none" type="submit">Guardar Equipo<span
                            class="fa fa-save ms-2" data-fa-transform="shrink-3"> </span></button>
                </li>
                <li class="next">
                    <button class="btn btn-primary px-5 px-sm-6" type="submit">Siguiente<span
                            class="fas fa-chevron-right ms-2" data-fa-transform="shrink-3"> </span></button>
                </li>
               
            </ul>
        </div>
    </div>
</div>