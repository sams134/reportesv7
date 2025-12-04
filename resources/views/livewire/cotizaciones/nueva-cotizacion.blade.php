<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <x-pretty-card>
        <h2>Nueva Cotización</h2>
    </x-pretty-card>


    <div class="card border-primary shadow-sm mb-3"
     x-data="{ open: true }">
    <!-- CABECERA -->
    <div class="card-header bg-light d-flex justify-content-between align-items-center"
         @click="open = !open"
         style="cursor: pointer;">
        <span class="fw-semibold">
            Business address and contact details, title, summary, and logo
        </span>

        <!-- Icono flecha (puedes usar bootstrap icons, fontawesome, o texto) -->
        <span
            class="ms-2"
            :class="open ? 'rotate-180' : ''"
            style="transition: transform 0.2s;">
            ▾
        </span>
    </div>

    <!-- CONTENIDO -->
    <div class="card-body" x-show="open" x-transition x-cloak>
        <div class="row align-items-start">

            <!-- Columna: LOGO -->
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <img src="{{ asset('img/logo.jpg') }}" alt="Logo" class="img-fluid" style="max-height: 150px;">
                <div class="mt-2">
                    <a href="#" class="text-primary">Remove logo</a>
                </div>
            </div>

            <!-- Columna: TÍTULO + SUMMARY -->
            <div class="col-md-4 mb-3 mb-md-0">
                <input type="text"
                       class="form-control form-control-lg mb-2"
                       placeholder="Oferta Presupuestaria.">

                <input type="text"
                       class="form-control"
                       placeholder="Summary (e.g. project name, description of esti)">
            </div>

            <!-- Columna: DATOS DE LA EMPRESA -->
            <div class="col-md-4 text-md-end text-start">
                <strong>Amir S.A</strong><br>
                23 avenida 28-46 zona 5<br>
                Guatemala, Guatemala 01005<br>
                Guatemala<br>
                Phone: 2331-1596<br>
                Mobile: 5207-6235<br>
                www.cmeamir.com<br>
                <a href="#" class="text-primary fw-semibold">
                    Edit your business address and contact details
                </a>
            </div>
        </div>
    </div>
</div>

</div>
