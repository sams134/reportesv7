<x-app-layout>
   @section('css')
   
   @endsection
    <x-pretty-card>
        <h2>Ingreso de nuevo equipo</h2>
      Crea una nueva orden de servicio.
    </x-pretty-card>
    <div class="row">
        <div class="col-12 col-lg-6">
            <x-form-card title="Informacion de Cliente">
               Formulario info cliente
            </x-form-card>
        </div>
        <div class="col-12 col-lg-6">
            <x-form-card title="Informacion del Equipo">
               Formulario info equipo
            </x-form-card>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-6">
            <x-form-card title="Inventario Equipo">
               Formulario info cliente
            </x-form-card>
        </div>
        <div class="col-12 col-lg-6">
            <x-form-card title="Trabajos a realizar">
               Formulario info equipo
            </x-form-card>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <x-form-card title="Fotografias">
               {{--  <form action="{{route('motores.store')}}" method="POST" class="mb-7" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group mb-2">
                        <input type="file" name="foto" id="" accept="image/*">
                        @error('foto')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Enviar</button>
                    </form> --}}
                    <form action="{{route('motores.store')}}" method="POST"class="dropzone dropzone-multiple p-0" id="my-awesome-dropzone" data-dropzone="data-dropzone" data-options="">
                       
                        <div class="dz-message" data-dz-message="data-dz-message"> <img class="me-2" src="../../../assets/img/icons/cloud-upload.svg" width="25" alt="" />Drop your files here</div>
                        <div class="dz-preview dz-preview-multiple m-0 d-flex flex-column">
                          <div class="d-flex media mb-3 pb-3 border-bottom btn-reveal-trigger"><img class="dz-image" src="../../../assets/img/generic/image-file-2.png" alt="..." data-dz-thumbnail="data-dz-thumbnail" />
                            <div class="flex-1 d-flex flex-between-center">
                              <div>
                                <h6 data-dz-name="data-dz-name"></h6>
                                <div class="d-flex align-items-center">
                                  <p class="mb-0 fs--1 text-400 lh-1" data-dz-size="data-dz-size"></p>
                                  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>
                                </div><span class="fs--2 text-danger" data-dz-errormessage="data-dz-errormessage"></span>
                              </div>
                              <div class="dropdown font-sans-serif">
                                <button class="btn btn-link text-600 btn-sm dropdown-toggle btn-reveal dropdown-caret-none" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fas fa-ellipsis-h"></span></button>
                                <div class="dropdown-menu dropdown-menu-end border py-2"><a class="dropdown-item" href="#!" data-dz-remove="data-dz-remove">Remove File</a></div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
            </x-form-card>
        </div>
        
    </div>
   @section('js')
     
   @endsection
</x-app-layout>