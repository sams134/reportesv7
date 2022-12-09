<x-guest-layout>
    <div class="col-sm-10 col-md-6 px-sm-0 align-self-center mx-auto py-5">
        <div class="row justify-content-center g-0">
          <div class="col-lg-9 col-xl-8 col-xxl-6">
            <div class="card">
              <div class="card-header bg-circle-shape bg-shape text-center p-2"><a class="font-sans-serif fw-bolder fs-4 z-index-1 position-relative link-light light" href="#">Clinica de Motores Electricos</a></div>
              <div class="card-body p-4">
                <div class="row flex-between-center">
                  <div class="col-auto">
                    <h3>Ingreso</h3>
                  </div>
                  <div class="col-auto fs--1 text-600"><span class="mb-0 fw-semi-bold">Nuevo Usuario?</span> <span><a href="../../../pages/authentication/split/register.html">Solicite un usuario</a></span></div>
                </div>
                <x-jet-validation-errors class="mb-3 rounded-0" />

            @if (session('status'))
                <div class="alert alert-success mb-3 rounded-0" role="alert">
                    {{ session('status') }}
                </div>
            @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                  <div class="mb-3">
                    <label class="form-label" for="split-login-email">Usuario</label>
                    <input class="form-control {{ $errors->has('identity') ? 'is-invalid' : '' }}" id="split-login-email" type="text"  name="identity" :value="old('identity')" required />
                  </div>
                  <div class="mb-3">
                    <div class="d-flex justify-content-between">
                      <label class="form-label" for="split-login-password">Password</label>
                    </div>
                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="split-login-password" type="password" name="password" required autocomplete="current-password"/>
                  </div>
                  <div class="row flex-between-center">
                    <div class="col-auto">
                      <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox"  id="remember_me" name="remember" />
                        <label class="form-check-label mb-0" for="split-checkbox">Recuerdame</label>
                      </div>
                    </div>
                    <div class="col-auto">
                        @if (Route::has('password.request'))
                            <a class="fs--1" href="{{ route('password.request') }}">Olvid&oacute; su Contraseña?</a>
                        @endif
                    </div>
                  </div>
                  <div class="mb-3">
                    <button class="btn btn-primary d-block w-100 mt-3" type="submit" name="submit">Inicie Sesión</button>
                  </div>
                </form>
                <div class="position-relative mt-4">
                  <hr class="bg-300" />
                  <div class="divider-content-center">o inicie sesion con</div>
                </div>
                <div class="row g-2 mt-2">
                  <div class="col-sm-6"><a class="btn btn-outline-google-plus btn-sm d-block w-100" href="#"><span class="fab fa-google-plus-g me-2" data-fa-transform="grow-8"></span> google</a></div>
                  <div class="col-sm-6"><a class="btn btn-outline-facebook btn-sm d-block w-100" href="#"><span class="fab fa-facebook-square me-2" data-fa-transform="grow-8"></span> facebook</a></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
</x-guest-layout>