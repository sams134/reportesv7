<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="row g-3 mb-3">
        <div class="col-xxl-6 col-lg-12">
          <div class="card h-100">
            <div class="bg-holder bg-card" style="background-image:url(../assets/img/icons/spot-illustrations/corner-3.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-header z-index-1">
              <h5 class="text-primary">Bienvenido {{$user->name}} </h5>
              <h6 class="text-600">Acá te presentamos algunos links que podrían ayudarte</h6>
            </div>
            <div class="card-body z-index-1">
              <div class="row g-2 h-100 align-items-end">
                <div class="col-sm-6 col-md-5">
                  <div class="d-flex position-relative">
                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-cogs text-primary"></span></div>
                    <div class="flex-1"><a class="stretched-link" href="#!">
                        <h6 class="text-800 mb-0">Motores - Ordenes de Servicio</h6>
                      </a>
                      <p class="mb-0 fs--2 text-500">Vea los equipos ingresados a reparación</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-5">
                  <div class="d-flex position-relative">
                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-balance-scale-left text-warning"></span></div>
                    <div class="flex-1"><a class="stretched-link" href="#!">
                        <h6 class="text-800 mb-0">Ver Balanceos</h6>
                      </a>
                      <p class="mb-0 fs--2 text-500">Vea los ultimos equipos balanceados </p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-5">
                  <div class="d-flex position-relative">
                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-wind text-danger"></span></div>
                    <div class="flex-1"><a class="stretched-link" href="#!">
                        <h6 class="text-800 mb-0">Ver Metalizados</h6>
                      </a>
                      <p class="mb-0 fs--2 text-500">Ordenes de metalizado en frío</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-5">
                  <div class="d-flex position-relative">
                    <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-record-vinyl text-info"></span></div>
                    <div class="flex-1"><a class="stretched-link" href="#!">
                        <h6 class="text-800 mb-0">Ver Trabajos de Torno</h6>
                      </a>
                      <p class="mb-0 fs--2 text-500">Vea, encamisados, rectificaciones, cambios de eje</p>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 col-md-5">
                    <div class="d-flex position-relative">
                      <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><span class="fas fa-laptop text-default"></span></div>
                      <div class="flex-1"><a class="stretched-link" href="#!">
                          <h6 class="text-800 mb-0">Ver Pruebas PDMA</h6>
                        </a>
                        <p class="mb-0 fs--2 text-500">Pruebas PDMA</p>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-md-6">
          <div class="card h-100">
            <div class="card-header d-flex flex-between-center">
              <h5 class="mb-0">Tecnicos Trabajando</h5><a class="btn btn-link btn-sm px-0" href="#!">Report<span class="fas fa-chevron-right ms-1 fs--2"> </span></a>
            </div>
            <div class="card-body">
              <p class="fs--1 text-600">Vea que porcentaje de tecnicos tienen trabajo <br /> o vea reporte de equipos trabajando</p>
              <div class="progress mb-3 rounded-pill" style="height: 6px;">
                <div class="progress-bar bg-progress-gradient rounded-pill" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
              <p class="mb-0 text-primary">75% completed</p>
              <p class="mb-0 fs--2 text-500">Jan 1st to 30th</p>
            </div>
          </div>
        </div>
        <div class="col-xxl-3 col-md-6">
          <div class="card h-100">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col">
                  <p class="mb-1 fs--2 text-500">Upcoming schedule</p>
                  <h5 class="text-primary fs-0">Falcon discussion</h5>
                </div>
                <div class="col-auto">
                  <div class="bg-soft-primary px-3 py-3 rounded-circle text-center" style="width:60px;height:60px;">
                    <h5 class="text-primary mb-0 d-flex flex-column mt-n1"><span>09</span><small class="text-primary fs--2 lh-1">MAR</small></h5>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-body d-flex align-items-end">
              <div class="row g-3 justify-content-between">
                <div class="col-10 mt-0">
                  <p class="fs--1 text-600 mb-0">The very first general meeting for planning Falcon’s design and development roadmap</p>
                </div>
                <div class="col-auto">
                  <button class="btn btn-success w-100 fs--1" type="button"><span class="fas fa-video me-2"></span>Join meeting</button>
                </div>
                <div class="col-auto ps-0">
                  <div class="avatar-group avatar-group-dense">
                    <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                      <img class="rounded-circle" src="../assets/img/team/1-thumb.png" alt="" />

                    </div>
                    <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                      <img class="rounded-circle" src="../assets/img/team/2-thumb.png" alt="" />

                    </div>
                    <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                      <img class="rounded-circle" src="../assets/img/team/3-thumb.png" alt="" />

                    </div>
                    <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                      <div class="avatar-name rounded-circle "><span>+50</span></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
   
</x-app-layout>