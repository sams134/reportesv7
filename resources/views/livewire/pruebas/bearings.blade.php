<div>
    <x-pretty-card title="Hay Rodamientos?">
        <div class="form-check form-switch">
            <input class="form-check-input" id="flexSwitchCheckDefault" type="checkbox" />
            <label class="form-check-label" for="flexSwitchCheckDefault">Solo Estator o rodamientos no aparecen</label>
        </div>
    </x-pretty-card>
    <x-form-card title="Rodamiento Lado Carga">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h3>Usado <i class="far fa-check-square " style="font-size:18px;color:#f7d83f"></i></h3>
                <label for="lado_carga">Escoja Rodamiento lado carga</label>
                <select class="form-select" aria-label="Default select example" wire:model="bearings.0.rodamiento_id">
                    <option selected="">Escoja Rodamiento</option>
                    @foreach ($rodamientos as $rodamiento)
                        <option value="{{ $rodamiento->id }}">{{ $rodamiento->designacion }}</option>
                    @endforeach
                </select>
                @error('bearings.0.rodamiento_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="sellos">Escoja Sellos</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault1" type="radio" name="flexRadioDefault"
                            wire:model="bearings.0.sellos" value="1" />
                        <label class="form-check-label" for="flexRadioDefault1">Ninguno</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault2" type="radio" name="flexRadioDefault"
                            wire:model="bearings.0.sellos" value="2" />
                        <label class="form-check-label" for="flexRadioDefault2">ZZ</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault3" type="radio" name="flexRadioDefault"
                            wire:model="bearings.0.sellos" value="3" />
                        <label class="form-check-label" for="flexRadioDefault3">2RS</label>
                    </div>
                </div>
                @error('bearings.0.sellos')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Juego Radial</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play1" type="radio" name="radial_play"
                            wire:model="bearings.0.juego_radial" value="1" />
                        <label class="form-check-label" for="radial_play1">Normal (C2)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play2" type="radio" name="radial_play"
                            wire:model="bearings.0.juego_radial" value="2" />
                        <label class="form-check-label" for="radial_play2">C3</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play3" type="radio" name="radial_play"
                            wire:model="bearings.0.juego_radial" value="3" />
                        <label class="form-check-label" for="radial_play3">C4</label>
                    </div>
                </div>
                @error('bearings.0.juego_radial')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Jaula</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage1" type="radio" name="cage"
                            wire:model="bearings.0.jaula" value="1" />
                        <label class="form-check-label" for="cage1">Normal (J)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage2" type="radio" name="cage"
                            wire:model="bearings.0.jaula" value="2" />
                        <label class="form-check-label" for="cage2">Bronze (M)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage3" type="radio" name="cage"
                            wire:model="bearings.0.jaula" value="3" />
                        <label class="form-check-label" for="cage3">Poliamida (P)</label>
                    </div>
                </div>
                @error('bearings.0.jaula')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Aislamiento">Aislamiento</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated" type="radio" name="insulated"
                            wire:model="bearings.0.aislado" value="1" />
                        <label class="form-check-label" for="insulated">Sin Aislamiento</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated2" type="radio" name="insulated"
                            wire:model="bearings.0.aislado" value="2" />
                        <label class="form-check-label" for="insulated">Aislado</label>
                    </div>
                </div>
                @error('bearings.0.aislado')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Marca">Escoja Marca</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.0.rodamiento_marca_id">
                    <option selected="">Escoja Marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                    @endforeach
                </select>
                @error('bearings.0.rodamiento_marca_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Grasa</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.0.grasa_id">
                    <option selected="">Escoja Grasa</option>
                    @foreach ($grasas as $grasa)
                        <option value="{{ $grasa->id }}">{{ $grasa->name }}</option>
                    @endforeach
                </select>
                @error('bearings.0.grasa_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">RPM motor (valor m&aacute;s alto)</label>
                <input class="form-control" id="exampleFormControlInput1" type="number" step="1" placeholder="{{$motor->rpm}}" wire:model="rpm"/>
                @error('rpm')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <button class="btn btn-{{ !$bearings[0]['ajuste'] ? 'primary' : 'warning' }} me-1 mt-3"
                    type="button" wire:click="saveBearing(0)">
                    @if ($bearings[0]['ajuste'])
                        Actualizar Rodamiento
                    @else
                        Guardar Rodamiento
                    @endif
                </button>
                <h4 class="mt-2">
                    {{ $bearings[0]['designacion'] != '' ? 'Designacion: ' . $bearings[0]['designacion'] : '' }}</h4>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex justify-between">
                    <h3 class="flex-1">Nuevo</h3>
                    <button class=" btn-falcon-default ms-0 mb-1 btn-sm" type="button" style="height: 30px"
                        wire:click="copy_carga(0,1)">Copiar rodamiento usado
                    </button><br>
                </div>


                <label for="lado_carga">Escoja Rodamiento lado carga</label>
                <select class="form-select" aria-label="Default select example"
                    wire:model="bearings.1.rodamiento_id">
                    <option selected="">Escoja Rodamiento</option>
                    @foreach ($rodamientos as $rodamiento)
                        <option value="{{ $rodamiento->id }}">{{ $rodamiento->designacion }}</option>
                    @endforeach
                </select>
                @error('bearings.1.rodamiento_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="sellos">Escoja Sellos</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault1_2" type="radio"
                            name="flexRadioDefault_2" wire:model="bearings.1.sellos" value="1" />
                        <label class="form-check-label" for="flexRadioDefault1">Ninguno</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault2_2" type="radio"
                            name="flexRadioDefault_2" wire:model="bearings.1.sellos" value="2" />
                        <label class="form-check-label" for="flexRadioDefault2">ZZ</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault3_2" type="radio"
                            name="flexRadioDefault_2" wire:model="bearings.1.sellos" value="3" />
                        <label class="form-check-label" for="flexRadioDefault3">2RS</label>
                    </div>
                </div>
                @error('bearings.1.sellos')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Juego Radial</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play1" type="radio" name="radial_play_2"
                            wire:model="bearings.1.juego_radial" value="1" />
                        <label class="form-check-label" for="radial_play1">Normal (C2)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play2" type="radio" name="radial_play_2"
                            wire:model="bearings.1.juego_radial" value="2" />
                        <label class="form-check-label" for="radial_play2">C3</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play3" type="radio" name="radial_play_2"
                            wire:model="bearings.1.juego_radial" value="3" />
                        <label class="form-check-label" for="radial_play3">C4</label>
                    </div>
                </div>
                @error('bearings.1.juego_radial')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Jaula</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage1" type="radio" name="cage_2"
                            wire:model="bearings.1.jaula" value="1" />
                        <label class="form-check-label" for="cage1">Normal (J)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage2" type="radio" name="cage_2"
                            wire:model="bearings.1.jaula" value="2" />
                        <label class="form-check-label" for="cage2">Bronze (M)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage3" type="radio" name="cage_2"
                            wire:model="bearings.1.jaula" value="3" />
                        <label class="form-check-label" for="cage3">Poliamida (P)</label>
                    </div>
                </div>
                @error('bearings.1.jaula')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Aislamiento">Aislamiento</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated1" type="radio" name="insulated_2"
                            wire:model="bearings.1.aislado" value="1" />
                        <label class="form-check-label" for="insulated1">Sin Aislamiento</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated2" type="radio" name="insulated_2"
                            wire:model="bearings.1.aislado" value="2" />
                        <label class="form-check-label" for="insulated2">Aislado</label>
                    </div>
                </div>
                @error('bearings.1.aislado')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Marca">Escoja Marca</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.1.rodamiento_marca_id">
                    <option selected="">Escoja Marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                    @endforeach
                </select>
                @error('bearings.1.rodamiento_marca_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Grasa</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.1.grasa_id">
                    <option selected="">Escoja Grasa</option>
                    @foreach ($grasas as $grasa)
                        <option value="{{ $grasa->id }}">{{ $grasa->name }}</option>
                    @endforeach
                </select>
                @error('bearings.1.grasa_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
               
                @if ($bearings[1]['bearing'])
                    <h5 class="mt-2">Medidas Externas Rodamiento</h5>
                    <div class="input-group mb-3"><span class="input-group-text" id="">@ 0°</span>
                        <input class="form-control" type="number" step="0.001"
                            placeholder="{{ number_format($bearings[1]['bearing']['diametro_externo'], 3) }}"
                            aria-describedby="basic-addon1" wire:model="bearings.1.p" />
                    </div>
                    @error('bearings.1.p')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                    @if ($bearings[1]['bearing']['diametro_externo'] > 100)
                        <div class="input-group mb-3"><span class="input-group-text" id="">@ 120°</span>
                            <input class="form-control" type="number" step="0.001"
                                placeholder="{{ number_format($bearings[1]['bearing']['diametro_externo'], 3) }}"
                                aria-describedby="basic-addon1" wire:model="bearings.1.q" />
                        </div>
                        @error('bearings.1.q')
                            <span class="error" style="color: red">{{ $message }}</span>
                        @enderror
                    @endif
                    @if ($bearings[1]['bearing']['diametro_externo'] > 200)
                        <div class="input-group mb-3"><span class="input-group-text" id="">@ 240°</span>
                            <input class="form-control" type="number" step="0.001"
                                placeholder="{{ number_format($bearings[1]['bearing']['diametro_externo'], 3) }}"
                                aria-describedby="basic-addon1" wire:model="bearings.1.r" />
                        </div>
                    @endif
                    @error('bearings.1.r')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                    <h5 class="mt-2">Medidas Internas Rodamiento</h5>
                    <div class="input-group mb-3"><span class="input-group-text" id="">@ 0°</span>
                        <input class="form-control" type="number" step="0.001"
                            placeholder="{{ number_format($bearings[1]['bearing']['diametro_interno'], 3) }}"
                            aria-describedby="basic-addon1" wire:model="bearings.1.s" />
                    </div>
                    @error('bearings.1.s')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                    <div class="input-group mb-3"><span class="input-group-text" id="">@ 120°</span>
                        <input class="form-control" type="number" step="0.001"
                            placeholder="{{ number_format($bearings[1]['bearing']['diametro_interno'], 3) }}"
                            aria-describedby="basic-addon1" wire:model="bearings.1.t" />
                    </div>
                    @error('bearings.1.t')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                @endif

                <button class="btn btn-{{ !$bearings[1]['ajuste'] ? 'primary' : 'warning' }} me-1 mt-3"
                    type="button" wire:click="saveBearing(1)">
                    @if ($bearings[1]['ajuste'])
                        Actualizar Rodamiento
                    @else
                        Guardar Rodamiento
                    @endif
                </button>
                @error('rpm')
                <span class="error" style="color: red">{{ $message }}</span><br>
            @enderror
                <h4 class="mt-2">
                    {{ $bearings[1]['designacion'] != '' ? 'Designacion: ' . $bearings[1]['designacion'] : '' }}</h4>
            </div>
        </div>
    </x-form-card>
    <x-form-card title="Rodamiento Lado Opuesto">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h3>Usado <i class="far fa-check-square " style="font-size:18px;color:#f7d83f"></i></h3>
                <label for="lado_carga">Escoja Rodamiento lado opuesto</label>
                <select class="form-select" aria-label="Default select example"
                    wire:model="bearings.2.rodamiento_id">
                    <option selected="">Escoja Rodamiento</option>
                    @foreach ($rodamientos as $rodamiento)
                        <option value="{{ $rodamiento->id }}">{{ $rodamiento->designacion }}</option>
                    @endforeach
                </select>
                @error('bearings.2.rodamiento_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="sellos">Escoja Sellos</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault1_2" type="radio"
                            name="flexRadioDefault_3" wire:model="bearings.2.sellos" value="1" />
                        <label class="form-check-label" for="flexRadioDefault1_2">Ninguno</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault2_2" type="radio"
                            name="flexRadioDefault_3" wire:model="bearings.2.sellos" value="2" />
                        <label class="form-check-label" for="flexRadioDefault2_2">ZZ</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault3_2" type="radio"
                            name="flexRadioDefault_3" wire:model="bearings.2.sellos" value="3" />
                        <label class="form-check-label" for="flexRadioDefault3_2">2RS</label>
                    </div>
                </div>
                @error('bearings.2.sellos')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Juego Radial</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play1_2" type="radio" name="radial_play_3"
                            wire:model="bearings.2.juego_radial" value="1" />
                        <label class="form-check-label" for="radial_play1">Normal (C2)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play2_2" type="radio" name="radial_play_3"
                            wire:model="bearings.2.juego_radial" value="2" />
                        <label class="form-check-label" for="radial_play2">C3</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play3_2" type="radio" name="radial_play_3"
                            wire:model="bearings.2.juego_radial" value="3" />
                        <label class="form-check-label" for="radial_play3">C4</label>
                    </div>
                </div>
                @error('bearings.2.juego_radial')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Jaula</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage1_2" type="radio" name="cage_3"
                            wire:model="bearings.2.jaula" value="1" />
                        <label class="form-check-label" for="cage1">Normal (J)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage2_2" type="radio" name="cage_3"
                            wire:model="bearings.2.jaula" value="2" />
                        <label class="form-check-label" for="cage2">Bronze (M)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage3_2" type="radio" name="cage_3"
                            wire:model="bearings.2.jaula" value="3" />
                        <label class="form-check-label" for="cage3">Poliamida (P)</label>
                    </div>
                </div>
                @error('bearings.2.jaula')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Aislamiento">Aislamiento</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated1_3" type="radio" name="insulated_3"
                            wire:model="bearings.2.aislado" value="1" />
                        <label class="form-check-label" for="insulated1">Sin Aislamiento</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated2_3" type="radio" name="insulated_3"
                            wire:model="bearings.2.aislado" value="2" />
                        <label class="form-check-label" for="insulated2">Aislado</label>
                    </div>
                </div>
                @error('bearings.2.aislado')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Marca">Escoja Marca</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.2.rodamiento_marca_id">
                    <option selected="">Escoja Marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                    @endforeach
                </select>
                @error('bearings.2.rodamiento_marca_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Grasa</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.2.grasa_id">
                    <option selected="">Escoja Grasa</option>
                    @foreach ($grasas as $grasa)
                        <option value="{{ $grasa->id }}">{{ $grasa->name }}</option>
                    @endforeach
                </select>
                @error('bearings.2.grasa_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
               
                <button class="btn btn-{{ !$bearings[2]['ajuste'] ? 'primary' : 'warning' }} me-1 mt-3"
                    type="button" wire:click="saveBearing(2)">
                    @if ($bearings[2]['ajuste'])
                        Actualizar Rodamiento
                    @else
                        Guardar Rodamiento
                    @endif
                </button>
                @error('rpm')
                <span class="error" style="color: red">{{ $message }}</span><br>
            @enderror
                <h4 class="mt-2">
                    {{ $bearings[2]['designacion'] != '' ? 'Designacion: ' . $bearings[2]['designacion'] : '' }}</h4>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex justify-between">
                    <h3 class="flex-1">Nuevo</h3>
                    <button class=" btn-falcon-default ms-0 mb-1 btn-sm" type="button" style="height: 30px"
                        wire:click="copy_carga(2,3)">Copiar rodamiento usado
                    </button><br>
                </div>


                <label for="lado_carga">Escoja Rodamiento lado opuesto</label>
                <select class="form-select" aria-label="Default select example"
                    wire:model="bearings.3.rodamiento_id">
                    <option selected="">Escoja Rodamiento</option>
                    @foreach ($rodamientos as $rodamiento)
                        <option value="{{ $rodamiento->id }}">{{ $rodamiento->designacion }}</option>
                    @endforeach
                </select>
                @error('bearings.3.rodamiento_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="sellos">Escoja Sellos</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault1" type="radio"
                            name="flexRadioDefault_4" wire:model="bearings.3.sellos" value="1" />
                        <label class="form-check-label" for="flexRadioDefault1">Ninguno</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault2" type="radio"
                            name="flexRadioDefault_4" wire:model="bearings.3.sellos" value="2" />
                        <label class="form-check-label" for="flexRadioDefault2">ZZ</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="flexRadioDefault3" type="radio"
                            name="flexRadioDefault_4" wire:model="bearings.3.sellos" value="3" />
                        <label class="form-check-label" for="flexRadioDefault3">2RS</label>
                    </div>
                </div>
                @error('bearings.3.sellos')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Juego Radial</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play1" type="radio" name="radial_play_4"
                            wire:model="bearings.3.juego_radial" value="1" />
                        <label class="form-check-label" for="radial_play1">Normal (C2)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play2" type="radio" name="radial_play_4"
                            wire:model="bearings.3.juego_radial" value="2" />
                        <label class="form-check-label" for="radial_play2">C3</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="radial_play3" type="radio" name="radial_play_4"
                            wire:model="bearings.3.juego_radial" value="3" />
                        <label class="form-check-label" for="radial_play3">C4</label>
                    </div>
                </div>
                @error('bearings.3.juego_radial')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Jaula</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage1" type="radio" name="cage_4"
                            wire:model="bearings.3.jaula" value="1" />
                        <label class="form-check-label" for="cage1">Normal (J)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage2" type="radio" name="cage_4"
                            wire:model="bearings.3.jaula" value="2" />
                        <label class="form-check-label" for="cage2">Bronze (M)</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="cage3" type="radio" name="cage_4"
                            wire:model="bearings.3.jaula" value="3" />
                        <label class="form-check-label" for="cage3">Poliamida (P)</label>
                    </div>
                </div>
                @error('bearings.3.jaula')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Aislamiento">Aislamiento</label>
                <div class="d-flex">
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated1_4" type="radio" name="insulated_4"
                            wire:model="bearings.3.aislado" value="1" />
                        <label class="form-check-label" for="insulated1">Sin Aislamiento</label>
                    </div>
                    <div class="form-check mx-2">
                        <input class="form-check-input" id="insulated2_4" type="radio" name="insulated_4"
                            wire:model="bearings.3.aislado" value="2" />
                        <label class="form-check-label" for="insulated2">Aislado</label>
                    </div>
                </div>
                @error('bearings.3.aislado')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Marca">Escoja Marca</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.3.rodamiento_marca_id">
                    <option selected="">Escoja Marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{ $marca->id }}">{{ $marca->name }}</option>
                    @endforeach
                </select>
                @error('bearings.3.rodamiento_marca_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                <label for="Juego">Escoja Grasa</label>
                <select class="form-select form-select-sm" aria-label="Default select example"
                    wire:model="bearings.3.grasa_id">
                    <option selected="">Escoja Grasa</option>
                    @foreach ($grasas as $grasa)
                        <option value="{{ $grasa->id }}">{{ $grasa->name }}</option>
                    @endforeach
                </select>
                @error('bearings.3.grasa_id')
                    <span class="error" style="color: red">{{ $message }}</span><br>
                @enderror
                
                @if ($bearings[3]['bearing'])
                    <h5 class="mt-2">Medidas Externas Rodamiento</h5>
                    <div class="input-group mb-3"><span class="input-group-text" id="">@ 0°</span>
                        <input class="form-control" type="number" step="0.0001"
                            placeholder="{{ number_format($bearings[3]['bearing']['diametro_externo'], 3) }}"
                            aria-describedby="basic-addon1" wire:model="bearings.3.p" />
                    </div>
                    @error('bearings.3.p')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                    @if ($bearings[3]['bearing']['diametro_externo'] > 100)
                        <div class="input-group mb-3"><span class="input-group-text" id="">@ 120°</span>
                            <input class="form-control" type="number" step="0.0001"
                                placeholder="{{ number_format($bearings[3]['bearing']['diametro_externo'], 3) }}"
                                aria-describedby="basic-addon1" wire:model="bearings.3.q" />
                        </div>
                        @error('bearings.3.q')
                            <span class="error" style="color: red">{{ $message }}</span>
                        @enderror
                    @endif
                    @if ($bearings[3]['bearing']['diametro_externo'] > 200)
                        <div class="input-group mb-3"><span class="input-group-text" id="">@ 240°</span>
                            <input class="form-control" type="number" step="0.0001"
                                placeholder="{{ number_format($bearings[3]['bearing']['diametro_externo'], 3) }}"
                                aria-describedby="basic-addon1" wire:model="bearings.3.r" />
                        </div>
                    @endif
                    @error('bearings.3.r')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                    <h5 class="mt-2">Medidas Externas Rodamiento</h5>
                    <div class="input-group mb-3"><span class="input-group-text" id="">@ 0°</span>
                        <input class="form-control" type="number" step="0.001"
                            placeholder="{{ number_format($bearings[3]['bearing']['diametro_interno'], 3) }}"
                            aria-describedby="basic-addon1" wire:model="bearings.3.s" />
                    </div>
                    @error('bearings.3.s')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                    <div class="input-group mb-3"><span class="input-group-text" id="">@ 120°</span>
                        <input class="form-control" type="number" step="0.001"
                            placeholder="{{ number_format($bearings[3]['bearing']['diametro_interno'], 3) }}"
                            aria-describedby="basic-addon1" wire:model="bearings.3.t" />
                    </div>
                    @error('bearings.3.t')
                        <span class="error" style="color: red">{{ $message }}</span>
                    @enderror
                @endif
                <button class="btn btn-{{ !$bearings[3]['ajuste'] ? 'primary' : 'warning' }} me-1 mt-3"
                    type="button" wire:click="saveBearing(3)">
                    @if ($bearings[3]['ajuste'])
                        Actualizar Rodamiento
                    @else
                        Guardar Rodamiento
                    @endif
                </button>
                @error('rpm')
                <span class="error" style="color: red">{{ $message }}</span><br>
            @enderror
                <h4 class="mt-2">
                    {{ $bearings[3]['designacion'] != '' ? 'Designacion: ' . $bearings[3]['designacion'] : '' }}</h4>
            </div>
        </div>
    </x-form-card>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.on('beraring_updated', (title, subtitle) => {
                Swal.fire({
                    title: title,
                    text: subtitle,
                    icon: "success"
                });
            });
        });
    </script>
</div>
