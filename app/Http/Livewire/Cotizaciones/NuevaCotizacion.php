<?php

namespace App\Http\Livewire\Cotizaciones;

use App\Models\Cliente;
use App\Models\Contacto;
use App\Models\Motor;
use App\Models\CotizacionRebobinadoPrecio;
use App\Models\CotizacionMantenimientoPrecio;
use App\Models\CotizacionBalanceoPrecio;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\CotizacionTextoPresentacion;
use App\Models\CotizacionCatalogoItem;
use App\Models\Config;
use App\Models\Cotizacion;
use App\Models\CotizacionContacto;
use App\Models\CotizacionItem;
use App\Models\CotizacionEncamisadoPrecio;
use App\Models\CotizacionRodamientoCatalogo;
use App\Models\CotizacionRodamientoPrecio;
use App\Models\CotizacionPruebaPrecio;
use App\Models\CotizacionUnificadaDetalle;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\CotizacionPdfAdjunto;
use App\Models\MotorAdminStatus;
use Illuminate\Validation\ValidationException;
use App\Models\MotorAdminStatusDocument;
use App\Models\CotizacionExcelGrupo;



class NuevaCotizacion extends Component
{
    use WithFileUploads;

    public $clientes, $cotDate, $cotValid;

    public $cliente_id = null;
    public $contactosSeleccionados = [];
    public $clientePreview = [
        'cliente' => '',
        'razon_social' => '',
        'direccion_fiscal' => '',
        'pais' => '',
        'nit' => '',
    ];
    public $presentaciones;
    public $presentacion_id = null;
    public $textoPresentacion = '';
    public $motor_id = null;
    public $osSeleccionadaLabel = '';
    public $equipoNoIngresadoTaller = false;
    public $motorPreview = null;
    public $usarDatosEquipo = false;
    public $resumenEquipo = '';
    public $contactosPreview = [];

    public $contactoEditId;
    public $contactoEditNombre;
    public $contactoEditPuesto;
    public $contactoEditTelefono;
    public $contactoEditEmail;

    public $itemsCotizacion = [];

    public $subtotalItems = 0;

    public $modalItemCatalogoId = null;
    public $modalItemNombre = '';
    public $modalItemDescripcion = '';
    public $modalItemCantidad = 1;
    public $modalItemPrecioUnitario = 0;
    public $modalItemEsAccion = false;
    public $tituloCotizacion = 'Oferta Presupuestaria';
    public $subtituloCotizacion = '';
    public $pdfUsarPortada = false;
    public $pdfUsarCartaPresentacion = true;

    public $numeroCotizacion = '';
    public $cotYear;
    public $cotCorrelativo;
    public $cotLetra = 'A';
    public $cotVersion = 1;

    public $monedaCotizacion = 'GTQ';
    public $tipoCambio = 7.80;

    public $cotizacionGuardadaId = null;
    public $modalItemTipo = 'general';

    public $rebobinadoHp = null;
    public $rebobinadoPolos = null;
    public $rebobinadoLibrasAlambre = null;
    public $rebobinadoInverterDuty = false;
    public $rebobinadoTipoServicio = 'solo_estator';

    public $rebobinadoCostoAdicional = 0;
    public $rebobinadoCostoPruebas = 400;

    public $mantenimientoHp = null;
    public $mantenimientoPolos = null;
    public $mantenimientoVoltaje = null;

    public $mantenimientoTipoServicio = 'solo_estator';

    public $mantenimientoCostoAdicional = 0;
    public $mantenimientoCostoPruebas = 0;

    public $balanceoHp = null;
    public $balanceoPolos = null;

    public $rodamientosCatalogo = [];

    public $encamisadoRodamientoCodigo = '';
    public $encamisadoOtroRodamiento = false;
    public $encamisadoDiametroExterior = null;

    public $encamisadoProfundo = false;
    public $encamisadoRanura = false;

    public $encamisadoPrecioBase = 0;

    public $debugDbName = '';
    public $debugRodamientosCount = 0;

    public $rodamientoCodigo = '';
    public $rodamientoSerie = '';
    public $rodamientoDiametroExterior = null;

    public $rodamientoMarca = 'SKF';
    public $rodamientoSellos = '';
    public $rodamientoJaula = '';
    public $rodamientoJuegoRadial = '';
    public $rodamientoAislamiento = '';

    public $rodamientoDesignacion = '';
    public $rodamientoReferenciasPrecio = [];

    public $pruebaTipo = 'estaticas';
    public $pruebaUbicacion = 'taller';

    public $pruebaHp = null;
    public $pruebaVoltaje = null;
    public $pruebaTensionTipo = 'BT';

    public $pruebaCantidadEquipos = 1;

    public $pruebaReferenciasPrecio = [];

    public $transporteTonelaje = null;
    public $transporteModalidad = '';
    public $transporteVehiculo = '';
    public $transportePesoReferencia = '';

    public $descuentoPorcentaje = 0;
    public $descuentoAlcance = 'principal';

    public $descuentoItemPrincipalUid = null;

    public $descuentoItemsPreview = [];
    public $descuentoTotal = 0;

    public $modoEdicion = false;
    public $cotizacionEditandoId = null;
    public $cotizacionOriginalHash = null;
    public $cotizacionTieneCambios = false;

    public $modoDuplicado = false;
    public $cotizacionDuplicadaDeId = null;
    public $cotizacionDuplicadaDeNumero = null;


    public $noIncluyeItems = [];
    public $noIncluyePersonalizado = '';

    public $noIncluyeOpcionesRapidas = [
        'No incluye suministro de rodamientos',
        'No incluye trabajos de torno',
        'No incluye encamisados de tapaderas',
        'No incluye metalizados de ejes',
        'No incluye balanceo dinámico',
        'No incluye transporte del equipo',
        'No incluye instalación y/o montaje',
        'No incluye grasa y lubricantes',
        'No incluye sensores de temperatura',
        'No incluye resistencias de calefacción',
        'No incluye carbones de aterrizaje',
    ];

    public $tiempoEntrega = '';
    public $tiempoEntregaOtro = '';

    public $garantiaModo = 'general';
    public $garantiaGeneralActiva = true;
    public $garantiaGeneralTiempo = '3_meses';
    public $garantiaElectricaTiempo = '3_meses';
    public $garantiaMecanicaTiempo = '30_dias';
    public $incluirTerminosGarantias = false;
    public $recalculandoItemsCotizacion = false;


    public $terminosPago = '';
    public $clienteDebeProveerOc = true;

    public $notasAdicionales = '';

    public $modoUnificacion = false;
    public $cotizacionesOrigenIds = [];
    public $cotizacionesOrigenResumen = [];

    public $gruposUnificados = [];
    public $totalUnificado = 0;

    public $modoAdicional = false;
    public $cotizacionBaseAdicionalId = null;
    public $cotizacionBaseAdicionalNumero = null;
    public $numeroAdicionalPreview = null;

    public $modoAdicionalUnificada = false;

    public $fotoPortadaCotizacion = null;
    public $fotoPortadaActual = null;

    public $pdfsAntesItemsUpload = [];
    public $pdfsDespuesItemsUpload = [];

    public $pdfsAntesItems = [];
    public $pdfsDespuesItems = [];

    public $pdfsAdjuntosEliminarIds = [];
    public $procesandoPdfsAdjuntos = false;
    public $guardandoCotizacion = false;

    public $modoExcel = false;
    public $gruposExcel = [];
    public $totalExcel = 0;

    public $usarNumeroRequerimiento = false;
    public $numeroRequerimiento = '';


    protected $listeners = [
        'osCotizacionSeleccionada' => 'seleccionarOsCotizacion',
        'catalogoItemCotizacionSeleccionado' => 'manejarCatalogoItemSeleccionado',
        'eliminarItemCotizacionConfirmado' => 'eliminarItemCotizacionConfirmado',
    ];

    public function mount($cotizacion = null)
    {
        $this->cargarCatalogoRodamientos();

        /*
     * MODO UNIFICACIÓN
     */
        if (request()->routeIs('admin.cotizaciones.unificar')) {
            $this->inicializarModoUnificacion(request()->query('ids'));
            return;
        }

        /*
        * MODO COTIZACIÓN DESDE EXCEL
            */
        if (request()->routeIs('admin.cotizaciones.excel')) {
            $this->inicializarModoExcel();
            return;
        }

        /*
     * MODO COTIZACIÓN ADICIONAL
     */
        if (request()->routeIs('admin.cotizaciones.adicional')) {
            $cotizacionModel = $cotizacion instanceof Cotizacion
                ? $cotizacion
                : Cotizacion::findOrFail($cotizacion);

            $this->inicializarModoAdicional($cotizacionModel);
            return;
        }

        /*
        * MODO DUPLICAR COTIZACIÓN
        */
        if (request()->routeIs('admin.cotizaciones.duplicar')) {
            $cotizacionModel = $cotizacion instanceof Cotizacion
                ? $cotizacion
                : Cotizacion::findOrFail($cotizacion);

            $this->inicializarModoDuplicado($cotizacionModel);
            return;
        }

        /*
     * MODO EDICIÓN
     */
        if ($cotizacion) {
            $cotizacionModel = $cotizacion instanceof Cotizacion
                ? $cotizacion
                : Cotizacion::findOrFail($cotizacion);

            $this->cargarCotizacionParaEditar($cotizacionModel->id);
            return;
        }

        /*
     * MODO CREACIÓN NORMAL
     */
        $this->modoEdicion = false;
        $this->cotizacionEditandoId = null;
        $this->cotizacionGuardadaId = null;

        $this->cotDate = Carbon::now()->format('d-m-Y');
        $this->cotValid = Carbon::now()->addDays(30)->format('d-m-Y');

        $this->generarNumeroCotizacionInicial();
    }


    public function render()
    {
        $clientes = Cliente::orderBy('cliente', 'asc')->get();
        $this->clientes = $clientes;
        $this->presentaciones = CotizacionTextoPresentacion::where('activo', 1)
            ->orderBy('orden', 'asc')
            ->get();

        return view('livewire.cotizaciones.nueva-cotizacion');
    }
    private function generarNumeroCotizacionInicial()
    {
        $config = Config::find(1);

        $year = $config && $config->year
            ? (int) $config->year
            : (int) Carbon::now()->format('Y');

        $this->cotYear = $year;

        $ultimoCorrelativo = Cotizacion::where('cot_year', $year)
            ->max('correlativo');

        $this->cotCorrelativo = $ultimoCorrelativo
            ? $ultimoCorrelativo + 1
            : 1;

        $this->cotLetra = 'A';
        $this->cotVersion = 1;

        $this->actualizarNumeroCotizacion();
    }
    private function actualizarNumeroCotizacion()
    {
        $yearCorto = $this->cotYear;

        $this->numeroCotizacion = 'COT'
            . $yearCorto
            . '-'
            . str_pad($this->cotCorrelativo, 4, '0', STR_PAD_LEFT)
            . '-'
            . $this->cotLetra
            . '-V'
            . $this->cotVersion;
    }
    public function updatedClienteId($value)
    {
        $this->contactosSeleccionados = [];
        $this->contactosPreview = [];

        $this->clientePreview = [
            'cliente' => '',
            'razon_social' => '',
            'direccion_fiscal' => '',
            'pais' => '',
            'nit' => '',
        ];

        if (!$value) {
            $this->emit('clienteCotizacionActualizado', $this->cliente_id);
            $this->dispatchBrowserEvent('contactos-cargados', [
                'contactos' => [],
                'selected' => [],
            ]);

            return;
        }

        $cliente = Cliente::with('info_cliente')
            ->where('id_cliente', $value)
            ->first();

        if (!$cliente) {
            return;
        }

        $this->clientePreview = [
            'cliente' => $cliente->cliente,
            'razon_social' => optional($cliente->info_cliente)->razon_social,
            'direccion_fiscal' => optional($cliente->info_cliente)->direccion_fiscal,
            'pais' => $cliente->pais,
            'nit' => optional($cliente->info_cliente)->nit,
        ];

        $this->cargarContactosParaChoices();
        $this->emit('clienteCotizacionActualizado', $this->cliente_id);
    }

    private function cargarCatalogoRodamientos()
    {
        $this->rodamientosCatalogo = DB::table('cotizacion_rodamientos_catalogo')
            ->where('activo', 1)
            ->orderBy('orden', 'asc')
            ->get()
            ->map(function ($rodamiento) {
                return [
                    'codigo' => (string) $rodamiento->codigo,
                    'serie' => (string) $rodamiento->serie,
                    'diametro_exterior_mm' => (float) $rodamiento->diametro_exterior_mm,
                ];
            })
            ->values()
            ->toArray();
    }
    public function updatedContactosSeleccionados($value)
    {
        $this->actualizarContactosPreview();

        $contactoSinEmail = Contacto::whereIn('id', $this->contactosSeleccionados)
            ->where(function ($query) {
                $query->whereNull('email')
                    ->orWhere('email', '');
            })
            ->first();

        if ($contactoSinEmail) {
            $this->cargarContactoParaEditar($contactoSinEmail->id);

            $this->dispatchBrowserEvent('abrir-modal-contacto-cotizacion');
        }
    }

    public function cargarContactoParaEditar($id)
    {
        $contacto = Contacto::findOrFail($id);

        $this->contactoEditId = $contacto->id;
        $this->contactoEditNombre = $contacto->contacto;
        $this->contactoEditPuesto = $contacto->puesto;
        $this->contactoEditTelefono = $contacto->telefono;
        $this->contactoEditEmail = $contacto->email;
    }

    public function guardarContactoCotizacion()
    {
        $this->validate([
            'contactoEditNombre' => 'required|string|max:255',
            'contactoEditPuesto' => 'nullable|string|max:255',
            'contactoEditTelefono' => 'nullable|string|max:255',
            'contactoEditEmail' => 'required|email|max:255',
        ]);

        $contacto = Contacto::findOrFail($this->contactoEditId);

        $contacto->update([
            'contacto' => $this->contactoEditNombre,
            'puesto' => $this->contactoEditPuesto,
            'telefono' => $this->contactoEditTelefono,
            'email' => $this->contactoEditEmail,
        ]);

        $this->actualizarContactosPreview();

        $this->cargarContactosParaChoices();

        $this->dispatchBrowserEvent('cerrar-modal-contacto-cotizacion');

        $this->dispatchBrowserEvent('contacto-cotizacion-actualizado');
    }

    private function cargarContactosParaChoices()
    {
        if (!$this->cliente_id) {
            $this->dispatchBrowserEvent('contactos-cargados', [
                'contactos' => [],
                'selected' => [],
            ]);

            return;
        }

        $contactos = Contacto::where('id_cliente', $this->cliente_id)
            ->orderBy('contacto', 'asc')
            ->get()
            ->map(function ($contacto) {
                return [
                    'value' => $contacto->id,
                    'label' => $contacto->contacto
                        . ($contacto->puesto ? ' - ' . $contacto->puesto : '')
                        . ($contacto->email ? ' [' . $contacto->email . ']' : ' [Sin email]'),
                ];
            })
            ->values()
            ->toArray();

        $this->dispatchBrowserEvent('contactos-cargados', [
            'contactos' => $contactos,
            'selected' => $this->contactosSeleccionados,
        ]);
    }

    private function actualizarContactosPreview()
    {
        $ids = collect($this->contactosSeleccionados)
            ->filter()
            ->values()
            ->toArray();

        if (empty($ids)) {
            $this->contactosPreview = [];
            return;
        }

        $contactos = Contacto::whereIn('id', $ids)
            ->get()
            ->keyBy('id');

        $this->contactosPreview = collect($ids)
            ->map(function ($id) use ($contactos) {
                $contacto = $contactos->get($id);

                if (!$contacto) {
                    return null;
                }

                return [
                    'id' => $contacto->id,
                    'contacto' => $contacto->contacto,
                    'puesto' => $contacto->puesto,
                    'telefono' => $contacto->telefono,
                    'email' => $contacto->email,
                ];
            })
            ->filter()
            ->values()
            ->toArray();
    }
    public function seleccionarOsCotizacion($payload)
    {
        if (($payload['tipo'] ?? null) === 'sin_ingreso') {
            $this->motor_id = null;
            $this->equipoNoIngresadoTaller = true;
            $this->osSeleccionadaLabel = $payload['label'] ?? 'Equipo no ha ingresado a taller, Oferta presupuestaria';

            $this->motorPreview = null;
            $this->usarDatosEquipo = false;
            $this->resumenEquipo = '';

            $this->usarNumeroRequerimiento = false;
            $this->numeroRequerimiento = '';

            return;
        }

        if (($payload['tipo'] ?? null) !== 'motor') {
            return;
        }

        $motor = Motor::with([
            'cliente',
            'infoMotor',
        ])
            ->where('id_motor', $payload['motor_id'])
            ->first();

        if (!$motor) {
            return;
        }

        $this->motor_id = $motor->id_motor;
        $this->equipoNoIngresadoTaller = false;
        $this->osSeleccionadaLabel = $motor->fullos;

        if ((int) $this->cliente_id !== (int) $motor->id_cliente) {
            $this->cliente_id = $motor->id_cliente;

            $this->updatedClienteId($motor->id_cliente);

            $this->dispatchBrowserEvent('cliente-cambiado-por-os', [
                'cliente' => optional($motor->cliente)->cliente,
                'os' => $motor->fullos,
            ]);
        }

        $this->cargarMotorPreview($motor);
        $this->cargarNumeroRequerimientoDesdeTablero();
    }
    private function cargarMotorPreview($motor)
    {
        $this->motorPreview = [
            'id_motor' => $motor->id_motor,
            'fullos' => $motor->fullos,

            'nombre_equipo' => optional($motor->infoMotor)->nombre_equipo,


            'marca' => $motor->marca,
            'serie' => $motor->serie,
            'modelo' => $motor->modelo,

            'potencia' => $motor->potencia,
            'volts' => $motor->volts,
            'amps' => $motor->amps,

            'rpm' => $motor->rpm,
            'pf' => $motor->pf,
            'eff' => $motor->eff,

            'hz' => $motor->hz,
            'frame' => $motor->frame,
            'phases' => $motor->phases,

            'recibido' => $motor->recibido,
            'comentarios' => $motor->comentarios,

            'status_id' => $motor->status_id,
        ];

        $this->usarDatosEquipo = $this->motorTieneDatosTecnicos($this->motorPreview);

        $this->resumenEquipo = $this->usarDatosEquipo
            ? $this->construirResumenEquipo($this->motorPreview)
            : '';
    }
    private function motorTieneDatosTecnicos($motor)
    {
        return filled($motor['potencia'])
            || filled($motor['volts'])
            || filled($motor['amps']);
    }

    public function updatedUsarDatosEquipo($value)
    {
        if (!$value) {
            $this->resumenEquipo = '';
            return;
        }

        if ($this->motorPreview) {
            $this->resumenEquipo = $this->construirResumenEquipo($this->motorPreview);
        }
    }

    private function construirResumenEquipo($motor)
    {
        $texto = 'Motor';

        if (filled($motor['nombre_equipo'])) {
            $texto .= ' ' . trim($motor['nombre_equipo']);
        }

        if (filled($motor['marca'])) {
            $texto .= ' marca ' . trim($motor['marca']);
        }

        if (filled($motor['potencia'])) {
            $texto .= ' de ' . trim($motor['potencia']);
        }

        $detalles = [];

        if (filled($motor['volts'])) {
            $detalles[] = $this->valorConUnidad($motor['volts'], 'Volts');
        }

        if (filled($motor['amps'])) {
            $detalles[] = $this->valorConUnidad($motor['amps'], 'Amps');
        }

        if (filled($motor['frame'])) {
            $detalles[] = 'Frame ' . trim($motor['frame']);
        }

        if (filled($motor['serie'])) {
            $detalles[] = 'Serie ' . trim($motor['serie']);
        }

        if (filled($motor['modelo'])) {
            $detalles[] = 'Modelo ' . trim($motor['modelo']);
        }

        if (filled($motor['rpm'])) {
            $detalles[] = 'RPM: ' . trim($motor['rpm']);
        }

        if (filled($motor['pf'])) {
            $detalles[] = 'PF: ' . trim($motor['pf']);
        }

        if (filled($motor['eff'])) {
            $detalles[] = 'EFF: ' . $this->valorConUnidad($motor['eff'], '%', false);
        }

        if (filled($motor['hz'])) {
            $detalles[] = 'HZ: ' . trim($motor['hz']);
        }

        if (filled($motor['phases'])) {
            $detalles[] = 'Fases: ' . trim($motor['phases']);
        }

        if (count($detalles) > 0) {
            $texto .= ', ' . implode(', ', $detalles);
        }

        return trim($texto) . '.';
    }



    private function valorConUnidad($valor, $unidad, $espacio = true)
    {
        $valor = trim((string) $valor);

        if ($valor === '') {
            return '';
        }

        /*
     * Si ya trae unidad, por ejemplo "460V", "254 A", "93%",
     * no duplicamos la unidad.
     */
        if (preg_match('/[a-zA-Z%]/', $valor)) {
            return $valor;
        }

        return $valor . ($espacio ? ' ' : '') . $unidad;
    }
    public function updatedPresentacionId($value)
    {
        if (!$value) {
            $this->textoPresentacion = '';

            $this->dispatchBrowserEvent('actualizar-texto-presentacion', [
                'contenido' => '',
            ]);

            return;
        }

        $presentacion = \App\Models\CotizacionTextoPresentacion::find($value);

        if (!$presentacion) {
            $this->textoPresentacion = '';

            $this->dispatchBrowserEvent('actualizar-texto-presentacion', [
                'contenido' => '',
            ]);

            return;
        }

        if ($this->modoUnificacion && !empty($presentacion->texto_unificado)) {
            $this->textoPresentacion = $presentacion->texto_unificado;
        } else {
            $this->textoPresentacion = $presentacion->contenido ?? '';
        }

        $this->dispatchBrowserEvent('actualizar-texto-presentacion', [
            'contenido' => $this->textoPresentacion,
        ]);
    }
    private function procesarTextoPresentacion($contenido)
    {
        /*
     * Por ahora solo carga el texto base.
     * Más adelante aquí podemos reemplazar variables dinámicas:
     * cliente, contacto, resumen del equipo, fecha, OS, etc.
     */

        return $contenido;
    }
    public function manejarCatalogoItemSeleccionado($payload)
    {
        $item = CotizacionCatalogoItem::find($payload['id'] ?? null);

        if (!$item) {
            return;
        }

        /*
     * Crear Nuevo Item mantiene el modal genérico actual.
     */
        if ($item->es_accion) {
            $this->abrirModalItemCotizacion($item);
            return;
        }

        /*
     * Items rápidos con modal especial.
     */
        if ($item->es_rapido && $item->categoria === 'rebobinado') {
            $this->abrirModalRebobinado($item);
            return;
        }
        if ($item->es_rapido && $item->categoria === 'mantenimiento') {
            $this->abrirModalMantenimiento($item);
            return;
        }
        if ($item->es_rapido && $item->categoria === 'balanceo') {
            $this->abrirModalBalanceo($item);
            return;
        }
        if ($item->es_rapido && $item->categoria === 'encamisado') {
            $this->abrirModalEncamisado($item);
            return;
        }
        if ($item->es_rapido && $item->categoria === 'rodamientos') {
            $this->abrirModalRodamiento($item);
            return;
        }
        if ($item->es_rapido && $item->categoria === 'pruebas') {
            $this->abrirModalPruebas($item);
            return;
        }
        if ($item->es_rapido && $item->categoria === 'transporte') {
            $this->abrirModalTransporte($item);
            return;
        }
        if ($item->es_rapido && $item->categoria === 'descuento') {
            $this->abrirModalDescuento($item);
            return;
        }

        /*
     * Los demás items rápidos todavía usan modal genérico,
     * hasta que hagamos sus modales especiales.
     */
        if ($item->es_rapido) {
            $this->abrirModalItemCotizacion($item);
            return;
        }

        /*
     * Items reales del catálogo se copian directo a la cotización.
     */
        $this->agregarItemDesdeCatalogo($item);
    }

    private function abrirModalItemCotizacion($item)
    {
        $this->modalItemTipo = 'general';

        $this->modalItemCatalogoId = $item->es_accion ? null : $item->id;
        $this->modalItemEsAccion = (bool) $item->es_accion;

        $this->modalItemNombre = $item->es_accion ? '' : $item->nombre;
        $this->modalItemDescripcion = $item->es_accion ? '' : $item->descripcion;
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = $item->es_accion ? 0 : $item->precio;

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function abrirModalMantenimiento($item)
    {
        $this->modalItemTipo = 'mantenimiento';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Mantenimiento de Motor';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->mantenimientoHp = null;
        $this->mantenimientoPolos = null;
        $this->mantenimientoVoltaje = null;

        $this->mantenimientoTipoServicio = 'solo_estator';

        $this->mantenimientoCostoAdicional = 0;
        $this->mantenimientoCostoPruebas = 0;

        $this->cargarDatosMantenimientoDesdeMotor();

        $this->actualizarDatosMantenimiento();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function abrirModalBalanceo($item)
    {
        $this->modalItemTipo = 'balanceo';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Balanceo dinámico de rotor';
        $this->modalItemDescripcion = 'Balanceo dinámico de rotor bajo norma ISO 1940 G1.0';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->balanceoHp = null;
        $this->balanceoPolos = null;

        $this->cargarDatosBalanceoDesdeMotor();

        $this->actualizarDatosBalanceo();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function abrirModalEncamisado($item)
    {
        $this->modalItemTipo = 'encamisado';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Encamisado de alojamiento';
        $this->modalItemDescripcion = '';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->encamisadoRodamientoCodigo = '';
        $this->encamisadoOtroRodamiento = false;
        $this->encamisadoDiametroExterior = null;

        $this->encamisadoProfundo = false;
        $this->encamisadoRanura = false;

        $this->encamisadoPrecioBase = 0;

        $this->debugDbName = DB::connection()->getDatabaseName();

        $this->debugRodamientosCount = DB::table('cotizacion_rodamientos_catalogo')
            ->where('activo', 1)
            ->count();



        $this->cargarCatalogoRodamientos();

        $this->actualizarDatosEncamisado();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function abrirModalRodamiento($item)
    {
        $this->modalItemTipo = 'rodamiento';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Rodamiento';
        $this->modalItemDescripcion = '';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->rodamientoCodigo = '';
        $this->rodamientoSerie = '';
        $this->rodamientoDiametroExterior = null;

        $this->rodamientoMarca = 'SKF';
        $this->rodamientoSellos = '';
        $this->rodamientoJaula = '';
        $this->rodamientoJuegoRadial = '';
        $this->rodamientoAislamiento = '';

        $this->rodamientoDesignacion = '';
        $this->rodamientoReferenciasPrecio = [];

        $this->cargarCatalogoRodamientos();

        $this->actualizarDatosRodamiento();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function abrirModalPruebas($item)
    {
        $this->modalItemTipo = 'pruebas';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Pruebas Estáticas';
        $this->modalItemDescripcion = '';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->pruebaTipo = 'estaticas';
        $this->pruebaUbicacion = 'taller';

        $this->pruebaHp = null;
        $this->pruebaVoltaje = null;
        $this->pruebaTensionTipo = 'BT';

        $this->pruebaCantidadEquipos = 1;
        $this->pruebaReferenciasPrecio = [];

        $this->cargarDatosPruebasDesdeMotor();

        $this->actualizarDatosPruebas();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function abrirModalTransporte($item)
    {
        $this->modalItemTipo = 'transporte';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Transporte';
        $this->modalItemDescripcion = '';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->transporteTonelaje = null;
        $this->transporteModalidad = '';
        $this->transporteVehiculo = '';
        $this->transportePesoReferencia = '';

        $this->actualizarDatosTransporte();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }

    private function agregarItemDesdeCatalogo($item)
    {
        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $item->id,
            'nombre' => $item->nombre,
            'descripcion' => $item->descripcion,
            'cantidad' => 1,
            'precio_unitario' => (float) $item->precio,
            'precio_total' => (float) $item->precio,
        ];

        $this->recalcularTotalesItems();
    }

    public function guardarItemDesdeModal()
    {
        if ($this->modalItemTipo === 'rebobinado') {
            return $this->guardarItemRebobinadoDesdeModal();
        }
        if ($this->modalItemTipo === 'mantenimiento') {
            return $this->guardarItemMantenimientoDesdeModal();
        }
        if ($this->modalItemTipo === 'balanceo') {
            return $this->guardarItemBalanceoDesdeModal();
        }
        if ($this->modalItemTipo === 'encamisado') {
            return $this->guardarItemEncamisadoDesdeModal();
        }
        if ($this->modalItemTipo === 'rodamiento') {
            return $this->guardarItemRodamientoDesdeModal();
        }
        if ($this->modalItemTipo === 'pruebas') {
            return $this->guardarItemPruebasDesdeModal();
        }
        if ($this->modalItemTipo === 'transporte') {
            return $this->guardarItemTransporteDesdeModal();
        }
        if ($this->modalItemTipo === 'descuento') {
            return $this->guardarItemDescuentoDesdeModal();
        }
        $this->validate([
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemCantidad' => 'required|numeric|min:0.01',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
        ]);

        $cantidad = (float) $this->modalItemCantidad;
        $precio = (float) $this->modalItemPrecioUnitario;

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio,
            'precio_total' => $cantidad * $precio,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',
            'rebobinadoHp',
            'rebobinadoPolos',
            'rebobinadoLibrasAlambre',
            'rebobinadoInverterDuty',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;
        $this->rebobinadoInverterDuty = false;

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }

    private function guardarItemRebobinadoDesdeModal()
    {
        $this->validate([
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
            'rebobinadoCostoAdicional' => 'nullable|numeric|min:0',
            'rebobinadoCostoPruebas' => 'nullable|numeric|min:0',
        ]);

        $precioRebobinado = round($this->totalRebobinadoModal(), 2);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'tipo_item' => 'rebobinado',
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => 1,
            'precio_unitario' => $precioRebobinado,
            'precio_total' => $precioRebobinado,
        ];

        $descripcionPruebas = $this->construirDescripcionPruebasRebobinado();

        $precioPruebas = round((float) $this->rebobinadoCostoPruebas, 2);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => null,
            'nombre' => 'Pruebas a Realizar',
            'descripcion' => $descripcionPruebas,
            'cantidad' => 1,
            'precio_unitario' => $precioPruebas,
            'precio_total' => $precioPruebas,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'rebobinadoHp',
            'rebobinadoPolos',
            'rebobinadoLibrasAlambre',
            'rebobinadoInverterDuty',
            'rebobinadoTipoServicio',
            'rebobinadoCostoAdicional',
            'rebobinadoCostoPruebas',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->rebobinadoTipoServicio = 'solo_estator';
        $this->rebobinadoCostoAdicional = 0;
        $this->rebobinadoCostoPruebas = 400;

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }
    private function guardarItemMantenimientoDesdeModal()
    {
        $this->validate([
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
            'mantenimientoCostoAdicional' => 'nullable|numeric|min:0',
            'mantenimientoCostoPruebas' => 'nullable|numeric|min:0',
        ]);

        $precioMantenimiento = round($this->totalMantenimientoModal(), 2);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'tipo_item' => 'mantenimiento',
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => 1,
            'precio_unitario' => $precioMantenimiento,
            'precio_total' => $precioMantenimiento,
        ];

        $descripcionPruebas = $this->construirDescripcionPruebasMantenimiento();

        $precioPruebas = round((float) $this->mantenimientoCostoPruebas, 2);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => null,
            'nombre' => 'Pruebas a Realizar',
            'tipo_item' => 'mantenimiento',
            'descripcion' => $descripcionPruebas,
            'cantidad' => 1,
            'precio_unitario' => $precioPruebas,
            'precio_total' => $precioPruebas,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'mantenimientoHp',
            'mantenimientoPolos',
            'mantenimientoVoltaje',
            'mantenimientoTipoServicio',
            'mantenimientoCostoAdicional',
            'mantenimientoCostoPruebas',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->mantenimientoTipoServicio = 'solo_estator';
        $this->mantenimientoCostoAdicional = 0;
        $this->mantenimientoCostoPruebas = 0;

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }
    private function guardarItemBalanceoDesdeModal()
    {
        $this->validate([
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
        ]);

        $precioBalanceo = round((float) $this->modalItemPrecioUnitario, 2);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => 1,
            'precio_unitario' => $precioBalanceo,
            'precio_total' => $precioBalanceo,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'balanceoHp',
            'balanceoPolos',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }
    private function guardarItemEncamisadoDesdeModal()
    {
        $this->validate([
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
            'encamisadoDiametroExterior' => 'required|numeric|min:1',
        ]);

        $precio = round((float) $this->modalItemPrecioUnitario, 2);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => 1,
            'precio_unitario' => $precio,
            'precio_total' => $precio,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'encamisadoRodamientoCodigo',
            'encamisadoOtroRodamiento',
            'encamisadoDiametroExterior',
            'encamisadoProfundo',
            'encamisadoRanura',
            'encamisadoPrecioBase',
            'rodamientosCatalogo',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }
    private function guardarItemRodamientoDesdeModal()
    {
        $this->validate([
            'rodamientoCodigo' => 'required|string',
            'rodamientoMarca' => 'required|string',
            'rodamientoDesignacion' => 'required|string|max:255',
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
        ]);

        $precio = round((float) $this->modalItemPrecioUnitario, 2);
        $moneda = $this->monedaReferenciaRodamiento();

        $this->guardarPrecioReferenciaRodamiento($precio, $moneda);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => 1,
            'precio_unitario' => $precio,
            'precio_total' => $precio,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'rodamientoCodigo',
            'rodamientoSerie',
            'rodamientoDiametroExterior',
            'rodamientoMarca',
            'rodamientoSellos',
            'rodamientoJaula',
            'rodamientoJuegoRadial',
            'rodamientoAislamiento',
            'rodamientoDesignacion',
            'rodamientoReferenciasPrecio',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->rodamientoMarca = 'SKF';
        $this->rodamientoSellos = '';
        $this->rodamientoJaula = '';
        $this->rodamientoJuegoRadial = '';
        $this->rodamientoAislamiento = '';

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }
    private function guardarItemPruebasDesdeModal()
    {
        $this->validate([
            'pruebaTipo' => 'required|string',
            'pruebaUbicacion' => 'required|string',
            'pruebaHp' => 'nullable|numeric|min:0',
            'pruebaVoltaje' => 'required|numeric|min:1',
            'pruebaCantidadEquipos' => 'required|integer|min:1',
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
        ]);

        $cantidad = $this->pruebaUbicacion === 'sitio'
            ? (int) $this->pruebaCantidadEquipos
            : 1;

        $precioUnitario = round((float) $this->modalItemPrecioUnitario, 2);
        $precioTotal = round($precioUnitario * $cantidad, 2);

        $this->guardarReferenciaPruebas($precioUnitario, $precioTotal, $cantidad);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'precio_total' => $precioTotal,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'pruebaTipo',
            'pruebaUbicacion',
            'pruebaHp',
            'pruebaVoltaje',
            'pruebaTensionTipo',
            'pruebaCantidadEquipos',
            'pruebaReferenciasPrecio',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->pruebaTipo = 'estaticas';
        $this->pruebaUbicacion = 'taller';
        $this->pruebaCantidadEquipos = 1;
        $this->pruebaTensionTipo = 'BT';

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }
    private function guardarItemTransporteDesdeModal()
    {
        $this->validate([
            'transporteTonelaje' => 'required|numeric|min:0.001',
            'modalItemNombre' => 'required|string|max:255',
            'modalItemDescripcion' => 'nullable|string',
            'modalItemPrecioUnitario' => 'required|numeric|min:0',
        ], [
            'transporteTonelaje.required' => 'Debe ingresar el peso aproximado del equipo.',
            'transporteTonelaje.min' => 'Debe ingresar un peso válido.',
            'modalItemPrecioUnitario.required' => 'Debe ingresar el precio del transporte.',
        ]);

        $precio = round((float) $this->modalItemPrecioUnitario, 2);

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,
            'cantidad' => 1,
            'precio_unitario' => $precio,
            'precio_total' => $precio,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'transporteTonelaje',
            'transporteModalidad',
            'transporteVehiculo',
            'transportePesoReferencia',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }
    private function guardarItemDescuentoDesdeModal()
    {
        $this->validate([
            'descuentoPorcentaje' => 'required|numeric|min:0.01|max:100',
            'descuentoAlcance' => 'required|in:principal,todos',
        ], [
            'descuentoPorcentaje.required' => 'Debe ingresar el porcentaje de descuento.',
            'descuentoPorcentaje.min' => 'El descuento debe ser mayor a 0%.',
            'descuentoPorcentaje.max' => 'El descuento no puede ser mayor a 100%.',
        ]);

        if ($this->descuentoAlcance === 'principal' && !$this->descuentoItemPrincipalUid) {
            $this->addError('descuentoAlcance', 'No se encontró un item principal para aplicar el descuento.');
            return;
        }

        $this->actualizarDatosDescuento();

        if ($this->descuentoTotal <= 0) {
            $this->addError('descuentoPorcentaje', 'No hay items válidos para aplicar el descuento.');
            return;
        }

        $this->itemsCotizacion[] = [
            'uid' => uniqid('item_', true),
            'catalogo_item_id' => $this->modalItemCatalogoId,
            'tipo_item' => 'descuento',

            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,

            'cantidad' => 1,
            'precio_unitario' => -1 * $this->descuentoTotal,
            'precio_total' => -1 * $this->descuentoTotal,

            'descuento_porcentaje' => (float) $this->descuentoPorcentaje,
            'descuento_alcance' => $this->descuentoAlcance,
            'descuento_item_principal_uid' => $this->descuentoAlcance === 'principal'
                ? $this->descuentoItemPrincipalUid
                : null,
        ];

        $this->reset([
            'modalItemCatalogoId',
            'modalItemNombre',
            'modalItemDescripcion',
            'modalItemCantidad',
            'modalItemPrecioUnitario',
            'modalItemEsAccion',
            'modalItemTipo',

            'descuentoPorcentaje',
            'descuentoAlcance',
            'descuentoItemPrincipalUid',
            'descuentoItemsPreview',
            'descuentoTotal',
        ]);

        $this->modalItemTipo = 'general';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->descuentoPorcentaje = 0;
        $this->descuentoAlcance = 'principal';

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('cerrar-modal-item-cotizacion');

        $this->dispatchBrowserEvent('item-cotizacion-agregado');
    }

    public function confirmarEliminarItemCotizacion($uid)
    {
        $this->dispatchBrowserEvent('confirmar-eliminar-item-cotizacion', [
            'uid' => $uid,
        ]);
    }

    public function eliminarItemCotizacionConfirmado($uid)
    {
        $uid = (string) $uid;

        $this->itemsCotizacion = collect($this->itemsCotizacion)
            ->reject(function ($item) use ($uid) {
                return (string) ($item['uid'] ?? '') === $uid;
            })
            ->values()
            ->toArray();

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('item-cotizacion-eliminado');
    }

    /*
 * Mantén este método por compatibilidad si algún botón viejo todavía lo llama.
 */
    public function eliminarItemCotizacion($index)
    {
        if (isset($this->itemsCotizacion[$index]['uid'])) {
            return $this->eliminarItemCotizacionConfirmado($this->itemsCotizacion[$index]['uid']);
        }

        unset($this->itemsCotizacion[$index]);

        $this->itemsCotizacion = array_values($this->itemsCotizacion);

        $this->recalcularTotalesItems();

        $this->dispatchBrowserEvent('item-cotizacion-eliminado');
    }

    public function updated($propertyName)
    {
        if ($this->recalculandoItemsCotizacion) {
            return;
        }

        if (strpos($propertyName, 'itemsCotizacion.') !== 0) {
            return;
        }

        if (! preg_match('/^itemsCotizacion\.\d+\.(cantidad|precio_unitario|descuento_porcentaje|descuento_alcance|descuento_item_principal_uid)$/', $propertyName)) {
            return;
        }

        $this->recalculandoItemsCotizacion = true;

        try {
            $this->recalcularTotalesItems();
        } finally {
            $this->recalculandoItemsCotizacion = false;
        }
    }

    private function recalcularTotalesItems()
    {
        $this->normalizarItemsCotizacion();

        /*
     * Primero recalculamos items normales.
     */
        foreach ($this->itemsCotizacion as $index => $item) {
            if ($this->esItemDescuento($item)) {
                $this->itemsCotizacion[$index]['tipo_item'] = 'descuento';
                continue;
            }

            $cantidad = (float) ($item['cantidad'] ?? 0);
            $precio = (float) ($item['precio_unitario'] ?? 0);

            $this->itemsCotizacion[$index]['precio_total'] = round($cantidad * $precio, 2);
        }

        /*
     * Luego recalculamos descuentos reales.
     * Si es descuento viejo sin porcentaje, lo respetamos.
     */
        foreach ($this->itemsCotizacion as $index => $item) {
            if (! $this->esItemDescuento($item)) {
                continue;
            }

            $this->itemsCotizacion[$index]['tipo_item'] = 'descuento';

            if (
                empty($item['descuento_porcentaje']) ||
                (float) $item['descuento_porcentaje'] <= 0
            ) {
                $this->itemsCotizacion[$index]['precio_unitario'] = -1 * abs((float) ($item['precio_unitario'] ?? 0));
                $this->itemsCotizacion[$index]['precio_total'] = -1 * abs((float) ($item['precio_total'] ?? 0));
                continue;
            }

            $porcentaje = (float) $item['descuento_porcentaje'];
            $alcance = $item['descuento_alcance'] ?? 'principal';
            $principalUid = $item['descuento_item_principal_uid'] ?? null;

            $itemsAfectos = $this->obtenerItemsAfectosDescuento(
                $alcance,
                $principalUid
            );

            $base = collect($itemsAfectos)->sum(function ($afecto) {
                return (float) ($afecto['precio_total'] ?? 0);
            });

            $montoDescuento = round($base * ($porcentaje / 100), 2);

            $this->itemsCotizacion[$index]['precio_unitario'] = -1 * $montoDescuento;
            $this->itemsCotizacion[$index]['precio_total'] = -1 * $montoDescuento;

            if (blank($this->itemsCotizacion[$index]['nombre'] ?? null)) {
                $this->itemsCotizacion[$index]['nombre'] = 'Descuento especial ' . $porcentaje . '%';
            }

            /*
 * No sobreescribimos la descripción si el usuario ya la editó.
 * Solo generamos descripción automática si está vacía.
 */
            if (blank($this->itemsCotizacion[$index]['descripcion'] ?? null)) {
                $this->itemsCotizacion[$index]['descripcion'] = $this->descripcionDescuento(
                    $porcentaje,
                    $itemsAfectos
                );
            }
        }

        $this->subtotalItems = collect($this->itemsCotizacion)
            ->sum(function ($item) {
                return (float) ($item['precio_total'] ?? 0);
            });
    }
    private function esItemDescuento($item): bool
    {
        $tipo = strtolower(trim((string) ($item['tipo_item'] ?? '')));

        $nombre = strtolower(trim((string) ($item['nombre'] ?? '')));

        $precioUnitario = (float) ($item['precio_unitario'] ?? 0);
        $precioTotal = (float) ($item['precio_total'] ?? 0);

        $descuentoPorcentaje = $item['descuento_porcentaje'] ?? null;

        if ($tipo === 'descuento') {
            return true;
        }

        if (
            $descuentoPorcentaje !== null &&
            $descuentoPorcentaje !== '' &&
            (float) $descuentoPorcentaje > 0 &&
            ($precioUnitario < 0 || $precioTotal < 0)
        ) {
            return true;
        }

        if (
            strpos($nombre, 'descuento') !== false &&
            ($precioUnitario < 0 || $precioTotal < 0)
        ) {
            return true;
        }

        return false;
    }
    private function normalizarItemsCotizacion(): void
    {
        foreach ($this->itemsCotizacion as $index => $item) {
            if ($this->esItemDescuento($item)) {
                $precioUnitario = abs((float) ($item['precio_unitario'] ?? 0));
                $precioTotal = abs((float) ($item['precio_total'] ?? 0));

                $this->itemsCotizacion[$index]['tipo_item'] = 'descuento';
                $this->itemsCotizacion[$index]['cantidad'] = 1;
                $this->itemsCotizacion[$index]['precio_unitario'] = -1 * $precioUnitario;
                $this->itemsCotizacion[$index]['precio_total'] = -1 * $precioTotal;

                continue;
            }

            /*
         * Defensa temporal:
         * Si un item normal quedó negativo por el bug anterior, lo regresamos a positivo.
         */
            if ((float) ($item['precio_unitario'] ?? 0) < 0) {
                $this->itemsCotizacion[$index]['precio_unitario'] = abs((float) $item['precio_unitario']);
            }

            $cantidad = (float) ($this->itemsCotizacion[$index]['cantidad'] ?? 1);
            $precio = (float) ($this->itemsCotizacion[$index]['precio_unitario'] ?? 0);

            $this->itemsCotizacion[$index]['tipo_item'] = $item['tipo_item'] ?? 'general';
            $this->itemsCotizacion[$index]['precio_total'] = round($cantidad * $precio, 2);
        }
    }
    public function updatedMonedaCotizacion($value)
    {
        if ($value === 'GTQ_USD' && (!$this->tipoCambio || $this->tipoCambio <= 0)) {
            $this->tipoCambio = 7.80;
        }
    }

    public function simboloMoneda()
    {
        return $this->monedaCotizacion === 'USD' ? '$' : 'Q';
    }

    public function mostrarConversionUsd()
    {
        return $this->monedaCotizacion === 'GTQ_USD';
    }

    public function convertirAUsd($valor)
    {
        $valor = (float) $valor;
        $tipoCambio = (float) $this->tipoCambio;

        if ($tipoCambio <= 0) {
            return 0;
        }

        return $valor / $tipoCambio;
    }
    private function prepararNumeroCotizacionParaGuardar()
    {
        if ($this->modoEdicion && $this->cotizacionEditandoId) {
            $cotizacionBase = Cotizacion::findOrFail($this->cotizacionEditandoId);

            $year = (int) $cotizacionBase->cot_year;
            $correlativo = (int) $cotizacionBase->correlativo;
            $letra = $cotizacionBase->letra ?: 'A';

            $ultimaVersion = Cotizacion::where('cot_year', $year)
                ->where('correlativo', $correlativo)
                ->where('letra', $letra)
                ->lockForUpdate()
                ->max('version');

            $version = $ultimaVersion
                ? ((int) $ultimaVersion + 1)
                : 1;

            $yearCorto = substr((string) $year, -2);

            $numero = 'COT'
                . $yearCorto
                . '-'
                . str_pad($correlativo, 4, '0', STR_PAD_LEFT)
                . '-'
                . $letra
                . '-V'
                . $version;

            $this->cotYear = $year;
            $this->cotCorrelativo = $correlativo;
            $this->cotLetra = $letra;
            $this->cotVersion = $version;
            $this->numeroCotizacion = $numero;

            return [
                'year' => $year,
                'correlativo' => $correlativo,
                'letra' => $letra,
                'version' => $version,
                'numero' => $numero,
            ];
        }
        $config = Config::find(1);

        $year = $config && $config->year
            ? (int) $config->year
            : (int) Carbon::now()->format('Y');

        $ultimoCorrelativo = Cotizacion::where('cot_year', $year)
            ->orderByDesc('correlativo')
            ->lockForUpdate()
            ->value('correlativo');

        $correlativo = $ultimoCorrelativo
            ? $ultimoCorrelativo + 1
            : 1;

        $letra = 'A';
        $version = 1;

        $yearCorto = substr((string) $year, -2);

        $numero = 'COT'
            . $yearCorto
            . '-'
            . str_pad($correlativo, 4, '0', STR_PAD_LEFT)
            . '-'
            . $letra
            . '-V'
            . $version;

        $this->cotYear = $year;
        $this->cotCorrelativo = $correlativo;
        $this->cotLetra = $letra;
        $this->cotVersion = $version;
        $this->numeroCotizacion = $numero;

        return [
            'year' => $year,
            'correlativo' => $correlativo,
            'letra' => $letra,
            'version' => $version,
            'numero' => $numero,
        ];
    }
    private function validarCotizacionAntesDeContinuar(): bool
    {
        $this->resetErrorBag();

        $this->normalizarItemsCotizacion();
        $this->recalcularTotalesItems();
        $this->asegurarContactosEnModoEdicion();
        $this->pdfsAntesItemsUpload = [];
        $this->pdfsDespuesItemsUpload = [];

        $rules = [
            'tituloCotizacion' => 'required|string|max:255',
            'subtituloCotizacion' => 'nullable|string|max:255',

            'cliente_id' => 'required',
            'contactosSeleccionados' => 'required|array|min:1',

            'cotDate' => 'required',
            'cotValid' => 'required',

            'monedaCotizacion' => 'required|string',
            'tipoCambio' => 'nullable|numeric|min:0',

            'noIncluyeItems' => 'nullable|array',
            'noIncluyeItems.*' => 'nullable|string|max:255',

            'tiempoEntrega' => 'nullable|string|max:100',
            'tiempoEntregaOtro' => 'nullable|string|max:255',

            'garantiaModo' => 'required|in:general,separada',
            'garantiaGeneralActiva' => 'boolean',
            'garantiaGeneralTiempo' => 'nullable|string|max:50',
            'garantiaElectricaTiempo' => 'nullable|string|max:50',
            'garantiaMecanicaTiempo' => 'nullable|string|max:50',
            'incluirTerminosGarantias' => 'boolean',

            'terminosPago' => 'nullable|string|max:100',
            'clienteDebeProveerOc' => 'boolean',

            'notasAdicionales' => 'nullable|string',
            'fotoPortadaCotizacion' => 'nullable|image|max:10240',
        ];

        if ($this->modoUnificacion) {
            $rules = array_merge($rules, [
                'gruposUnificados' => 'required|array|min:1',
                'gruposUnificados.*.items' => 'required|array|min:1',
                'gruposUnificados.*.items.*.nombre' => 'required|string|max:255',
                'gruposUnificados.*.items.*.descripcion' => 'nullable|string',
                'gruposUnificados.*.items.*.cantidad' => 'required|numeric|min:0.01',
                'gruposUnificados.*.items.*.precio_unitario' => 'required|numeric',
            ]);
        } elseif ($this->modoExcel) {
            $this->recalcularTotalExcel();

            $rules = array_merge($rules, [
                'gruposExcel' => 'required|array|min:1',
                'gruposExcel.*.items' => 'required|array|min:1',
                'gruposExcel.*.items.*.nombre' => 'required|string|max:255',
                'gruposExcel.*.items.*.descripcion' => 'nullable|string',
                'gruposExcel.*.items.*.cantidad' => 'required|numeric|min:0.01',
                'gruposExcel.*.items.*.precio_unitario' => 'required|numeric',
            ]);
        } else {
            $rules = array_merge($rules, [
                'itemsCotizacion' => 'required|array|min:1',
                'itemsCotizacion.*.nombre' => 'required|string|max:255',
                'itemsCotizacion.*.descripcion' => 'nullable|string',
                'itemsCotizacion.*.cantidad' => 'required|numeric|min:0.01',
                'itemsCotizacion.*.precio_unitario' => 'required|numeric',
            ]);
        }

        try {
            $this->validate($rules, [
                'tituloCotizacion.required' => 'Debe ingresar un título para la cotización.',
                'cliente_id.required' => 'Debe seleccionar un cliente.',
                'contactosSeleccionados.required' => 'Debe seleccionar al menos un contacto.',
                'contactosSeleccionados.min' => 'Debe seleccionar al menos un contacto.',

                'cotDate.required' => 'Debe ingresar la fecha de cotización.',
                'cotValid.required' => 'Debe ingresar la fecha de validez.',

                'itemsCotizacion.required' => 'Debe agregar al menos un item.',
                'itemsCotizacion.min' => 'Debe agregar al menos un item.',
                'itemsCotizacion.*.nombre.required' => 'Todos los items deben tener nombre.',
                'itemsCotizacion.*.cantidad.required' => 'Todos los items deben tener cantidad.',
                'itemsCotizacion.*.precio_unitario.required' => 'Todos los items deben tener precio unitario.',

                'gruposUnificados.required' => 'Debe existir al menos un grupo de cotización.',
                'gruposUnificados.min' => 'Debe existir al menos un grupo de cotización.',
                'gruposUnificados.*.items.required' => 'Cada grupo debe tener al menos un item.',
                'gruposUnificados.*.items.min' => 'Cada grupo debe tener al menos un item.',
                'gruposUnificados.*.items.*.nombre.required' => 'Todos los items deben tener nombre.',
                'gruposExcel.required' => 'Debe existir al menos un grupo importado desde Excel.',
                'gruposExcel.min' => 'Debe existir al menos un grupo importado desde Excel.',
                'gruposExcel.*.items.required' => 'Cada motor importado debe tener al menos un item.',
                'gruposExcel.*.items.min' => 'Cada motor importado debe tener al menos un item.',
                'gruposExcel.*.items.*.nombre.required' => 'Todos los items importados deben tener nombre.',
            ]);
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->errors());

            $primerError = collect($e->validator->errors()->toArray())
                ->flatten()
                ->first();

            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'No se puede generar la cotización',
                'text' => $primerError ?: 'Revise los campos requeridos antes de guardar la cotización.',
            ]);

            return false;
        }


        if ($this->tiempoEntrega === 'otro' && blank($this->tiempoEntregaOtro)) {
            $this->addError('tiempoEntregaOtro', 'Debe ingresar el tiempo de entrega aproximado.');
            return false;
        }

        if ($this->modoUnificacion) {
            foreach ($this->gruposUnificados as $grupoIndex => $grupo) {
                foreach (($grupo['items'] ?? []) as $itemIndex => $item) {
                    if ($this->esItemDescuento($item)) {
                        continue;
                    }

                    if ((float) ($item['precio_unitario'] ?? 0) < 0) {
                        $this->addError(
                            "gruposUnificados.$grupoIndex.items.$itemIndex.precio_unitario",
                            'El precio unitario no puede ser negativo.'
                        );

                        return false;
                    }
                }
            }
        } else {
            foreach ($this->itemsCotizacion as $index => $item) {
                if ($this->esItemDescuento($item)) {
                    $this->itemsCotizacion[$index]['tipo_item'] = 'descuento';
                    continue;
                }

                if ((float) ($item['precio_unitario'] ?? 0) < 0) {
                    $this->addError(
                        "itemsCotizacion.$index.precio_unitario",
                        'El precio unitario no puede ser negativo.'
                    );

                    return false;
                }
            }
        }

        if ($this->monedaCotizacion === 'GTQ_USD' && (!$this->tipoCambio || $this->tipoCambio <= 0)) {
            $this->addError('tipoCambio', 'Debe ingresar un tipo de cambio válido.');

            return false;
        }

        return true;
    }
    public function guardarCotizacion($generarPdf = false)
    {
        if ($this->guardandoCotizacion) {
            return;
        }

        $this->guardandoCotizacion = true;

        try {
            if (!$this->validarCotizacionAntesDeContinuar()) {
                return;
            }


            if ($this->modoUnificacion) {
                return $this->guardarCotizacionUnificada($generarPdf);
            }
            if ($this->modoExcel) {
                return $this->guardarCotizacionExcel($generarPdf);
            }

            if ($this->modoEdicion && !$this->hayCambiosEnCotizacion()) {
                /*
     * Aunque no haya cambios en texto/items, aseguramos PDFs visibles.
     * Esto cubre PDFs heredados de versión anterior.
     */
                if ($this->cotizacionEditandoId) {
                    $cotizacionActual = Cotizacion::find($this->cotizacionEditandoId);

                    if ($cotizacionActual) {
                        $this->guardarPdfsAdjuntosCotizacion($cotizacionActual);
                    }
                }

                session()->flash('success', 'No hubo cambios en la cotización.');

                if ($generarPdf) {
                    $urlPdf = route('admin.cotizaciones.downloadPdf', [
                        'cotizacion' => $this->cotizacionEditandoId,
                        'portada' => $this->pdfUsarPortada ? 1 : 0,
                    ]);

                    $this->dispatchBrowserEvent('cotizacion-pdf-listo', [
                        'url' => $urlPdf,
                    ]);

                    return;
                }

                return redirect()->route('admin.cotizaciones.index');
            }

            $cotizacion = null;

            $cotizacion = DB::transaction(function () {
                $numeroData = $this->modoAdicional
                    ? $this->prepararNumeroCotizacionAdicionalParaGuardar()
                    : $this->prepararNumeroCotizacionParaGuardar();

                $fechaCotizacion = Carbon::createFromFormat('d-m-Y', $this->cotDate)->format('Y-m-d');
                $fechaValidaHasta = Carbon::createFromFormat('d-m-Y', $this->cotValid)->format('Y-m-d');

                $fotoPortadaPath = $this->fotoPortadaActual;

                if ($this->fotoPortadaCotizacion) {
                    $fotoPortadaPath = $this->fotoPortadaCotizacion->store('cotizaciones/portadas', 'public');
                }
                $this->guardarNumeroRequerimientoEnTablero();
                $cotizacion = Cotizacion::create([
                    'numero' => $numeroData['numero'],
                    'titulo' => $this->tituloCotizacion,
                    'subtitulo' => $this->subtituloCotizacion,

                    'cot_year' => $numeroData['year'],
                    'correlativo' => $numeroData['correlativo'],
                    'letra' => $numeroData['letra'],
                    'version' => $numeroData['version'],

                    'id_cliente' => $this->cliente_id,
                    'id_motor' => $this->motor_id,
                    'equipo_no_ingresado_taller' => $this->equipoNoIngresadoTaller ? 1 : 0,

                    'mostrar_numero_requerimiento' => (
                        $this->usarNumeroRequerimiento &&
                        trim((string) $this->numeroRequerimiento) !== ''
                    ) ? 1 : 0,

                    'fecha_cotizacion' => $fechaCotizacion,
                    'fecha_valida_hasta' => $fechaValidaHasta,

                    'presentacion_id' => $this->presentacion_id,
                    'texto_presentacion' => $this->textoPresentacion,

                    'usar_datos_equipo' => $this->usarDatosEquipo ? 1 : 0,
                    'resumen_equipo' => $this->usarDatosEquipo ? $this->resumenEquipo : null,

                    'moneda' => $this->monedaCotizacion,
                    'tipo_cambio' => $this->monedaCotizacion === 'GTQ_USD'
                        ? $this->tipoCambio
                        : null,

                    'subtotal' => $this->subtotalItems,
                    'descuento' => 0,
                    'total' => $this->subtotalItems,

                    'estado' => 'borrador',
                    'no_incluye' => $this->noIncluyeItems,

                    'tiempo_entrega' => $this->tiempoEntrega,
                    'tiempo_entrega_otro' => $this->tiempoEntregaOtro,

                    'garantia_modo' => $this->garantiaModo,
                    'garantia_general_activa' => $this->garantiaGeneralActiva ? 1 : 0,
                    'garantia_general_tiempo' => $this->garantiaGeneralTiempo,
                    'garantia_electrica_tiempo' => $this->garantiaElectricaTiempo,
                    'garantia_mecanica_tiempo' => $this->garantiaMecanicaTiempo,
                    'incluir_terminos_garantias' => $this->incluirTerminosGarantias ? 1 : 0,

                    'terminos_pago' => $this->terminosPago,
                    'cliente_debe_proveer_oc' => $this->clienteDebeProveerOc ? 1 : 0,

                    'notas_adicionales' => $this->notasAdicionales,
                    'foto_portada' => $fotoPortadaPath,
                    'creado_por' => auth()->id(),
                ]);

                $this->guardarContactosCotizacionSnapshot($cotizacion);

                foreach ($this->itemsCotizacion as $index => $item) {
                    $cantidad = (float) ($item['cantidad'] ?? 0);
                    $precioUnitario = (float) ($item['precio_unitario'] ?? 0);
                    $precioTotal = round($cantidad * $precioUnitario, 2);
                    $this->recalcularTotalesItems();
                    CotizacionItem::create([
                        'cotizacion_id' => $cotizacion->id,
                        'catalogo_item_id' => $item['catalogo_item_id'] ?? null,

                        'tipo_item' => $this->esItemDescuento($item)
                            ? 'descuento'
                            : ($item['tipo_item'] ?? 'general'),

                        'nombre' => $item['nombre'],
                        'descripcion' => $item['descripcion'] ?? null,
                        'cantidad' => $item['cantidad'] ?? 1,
                        'precio_unitario' => $item['precio_unitario'] ?? 0,
                        'precio_total' => $item['precio_total'] ?? 0,

                        'descuento_porcentaje' => $item['descuento_porcentaje'] ?? null,
                        'descuento_alcance' => $item['descuento_alcance'] ?? null,
                        'descuento_item_principal_uid' => $item['descuento_item_principal_uid'] ?? null,

                        'orden' => $index + 1,
                    ]);
                }

                /*
 * PDFs adjuntos
 */
                $this->guardarPdfsAdjuntosCotizacion($cotizacion);

                return $cotizacion;
            });

            $this->cotizacionGuardadaId = $cotizacion->id;
            $this->sincronizarCotizacionConTableroAdministrativo($cotizacion);

            session()->flash('success', 'Cotización guardada correctamente.');

            if ($generarPdf) {
                $urlPdf = route('admin.cotizaciones.downloadPdf', [
                    'cotizacion' => $cotizacion->id,
                    'portada' => $this->pdfUsarPortada ? 1 : 0,
                    'carta' => $this->pdfUsarCartaPresentacion ? 1 : 0,
                ]);

                $this->dispatchBrowserEvent('cotizacion-pdf-listo', [
                    'url' => $urlPdf,
                ]);

                return;
            }

            return redirect()->route('admin.cotizaciones.index');
        } finally {
            $this->guardandoCotizacion = false;
        }
    }
    public function abrirModalOpcionesPdf()
    {
        if (! $this->validarCotizacionAntesDeContinuar()) {
            $errores = $this->getErrorBag()->toArray();

            $primerError = collect($errores)
                ->flatten()
                ->first();

            $detalleErrores = collect($errores)
                ->map(function ($mensajes, $campo) {
                    return $campo . ': ' . implode(' / ', (array) $mensajes);
                })
                ->values()
                ->implode("\n");

            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'No se puede generar la cotización',
                'text' => $primerError ?: 'Revise los campos requeridos antes de guardar la cotización.',
                'html' => $detalleErrores
                    ? nl2br(e($detalleErrores))
                    : 'Revise los campos requeridos antes de guardar la cotización.',
            ]);

            return;
        }

        $this->dispatchBrowserEvent('abrir-modal-opciones-pdf-cotizacion');
    }
    private function abrirModalRebobinado($item)
    {
        $this->modalItemTipo = 'rebobinado';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Rebobinado de Motor';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->rebobinadoHp = null;
        $this->rebobinadoPolos = null;
        $this->rebobinadoLibrasAlambre = null;
        $this->rebobinadoInverterDuty = false;
        $this->rebobinadoTipoServicio = 'solo_estator';

        $this->rebobinadoCostoAdicional = 0;
        $this->rebobinadoCostoPruebas = 400;

        $this->cargarDatosRebobinadoDesdeMotor();

        $this->actualizarDatosRebobinado();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function cargarDatosRebobinadoDesdeMotor()
    {
        if (!$this->motor_id) {
            return;
        }

        $motor = Motor::where('id_motor', $this->motor_id)->first();

        if (!$motor) {
            return;
        }

        /*
     * En tu modelo:
     * hpkw == 0 => HP
     * hpkw != 0 => KW
     */
        $hpBase = $this->normalizarNumero($motor->hp ?? null);

        if ($hpBase !== null) {
            if ((int) $motor->hpkw === 0) {
                $this->rebobinadoHp = round($hpBase, 2);
            } else {
                $this->rebobinadoHp = round($hpBase * 1.341, 2);
            }
        }

        $hz = $this->normalizarNumero($motor->hz ?? null);
        $rpm = $this->normalizarNumero($motor->rpm ?? null);

        $this->rebobinadoPolos = $this->calcularPolosMotor($hz, $rpm);
    }

    private function calcularPolosMotor($hz, $rpm)
    {
        if (!$hz || !$rpm || $rpm <= 0) {
            return null;
        }

        $polosCalculados = (120 * $hz) / $rpm;

        /*
     * Redondear al número par más cercano.
     */
        $polos = round($polosCalculados / 2) * 2;

        if ($polos < 2) {
            $polos = 2;
        }

        return (int) $polos;
    }

    private function normalizarNumero($valor)
    {
        if ($valor === null) {
            return null;
        }

        $valor = str_replace(',', '.', (string) $valor);

        if (preg_match('/[-+]?[0-9]*\.?[0-9]+/', $valor, $matches)) {
            return (float) $matches[0];
        }

        return null;
    }
    public function updatedRebobinadoHp()
    {
        $this->actualizarDatosRebobinado();
    }

    public function updatedRebobinadoPolos()
    {
        $this->actualizarDatosRebobinado();
    }

    public function updatedRebobinadoLibrasAlambre()
    {
        $this->actualizarDescripcionRebobinado();
    }

    public function updatedRebobinadoInverterDuty()
    {
        $this->actualizarDatosRebobinado();
    }

    private function actualizarDatosRebobinado()
    {
        $this->buscarPrecioRebobinado();
        $this->actualizarDescripcionRebobinado();
    }
    public function updatedRebobinadoTipoServicio()
    {
        $this->actualizarDatosRebobinado();
    }

    public function updatedRebobinadoCostoAdicional()
    {
        $this->actualizarDescripcionRebobinado();
    }

    public function updatedRebobinadoCostoPruebas()
    {
        //
    }
    public function updatedMantenimientoHp()
    {
        $this->actualizarDatosMantenimiento();
    }

    public function updatedMantenimientoPolos()
    {
        $this->actualizarDatosMantenimiento();
    }

    public function updatedMantenimientoVoltaje()
    {
        $this->actualizarDatosMantenimiento();
    }

    public function updatedMantenimientoTipoServicio()
    {
        $this->actualizarDatosMantenimiento();
    }

    public function updatedMantenimientoCostoAdicional()
    {
        $this->actualizarDescripcionMantenimiento();
    }

    public function updatedMantenimientoCostoPruebas()
    {
        //
    }
    public function updatedBalanceoHp()
    {
        $this->actualizarDatosBalanceo();
    }

    public function updatedBalanceoPolos()
    {
        $this->actualizarDatosBalanceo();
    }
    public function updatedEncamisadoRodamientoCodigo($value)
    {
        if ($value === 'OTRO') {
            $this->encamisadoOtroRodamiento = true;
            $this->encamisadoDiametroExterior = null;

            $this->actualizarDatosEncamisado();
            return;
        }

        $this->encamisadoOtroRodamiento = false;

        $rodamiento = CotizacionRodamientoCatalogo::where('codigo', $value)
            ->where('activo', 1)
            ->first();

        if ($rodamiento) {
            $this->encamisadoDiametroExterior = $rodamiento->diametro_exterior_mm;
        }

        $this->actualizarDatosEncamisado();
    }

    public function updatedEncamisadoDiametroExterior()
    {
        $this->actualizarDatosEncamisado();
    }

    public function updatedEncamisadoProfundo()
    {
        $this->actualizarDatosEncamisado();
    }

    public function updatedEncamisadoRanura()
    {
        $this->actualizarDatosEncamisado();
    }
    public function updatedRodamientoCodigo($value)
    {
        $rodamiento = DB::table('cotizacion_rodamientos_catalogo')
            ->where('codigo', $value)
            ->where('activo', 1)
            ->first();

        if ($rodamiento) {
            $this->rodamientoSerie = $rodamiento->serie;
            $this->rodamientoDiametroExterior = (float) $rodamiento->diametro_exterior_mm;
        } else {
            $this->rodamientoSerie = '';
            $this->rodamientoDiametroExterior = null;
        }

        $this->normalizarJaulaRodamiento();

        $this->actualizarDatosRodamiento();
    }

    public function updatedRodamientoMarca()
    {
        $this->actualizarDatosRodamiento();
    }

    public function updatedRodamientoSellos()
    {
        $this->actualizarDatosRodamiento();
    }

    public function updatedRodamientoJaula()
    {
        $this->actualizarDatosRodamiento();
    }

    public function updatedRodamientoJuegoRadial()
    {
        $this->actualizarDatosRodamiento();
    }

    public function updatedRodamientoAislamiento()
    {
        $this->actualizarDatosRodamiento();
    }

    public function updatedModalItemPrecioUnitario()
    {
        if ($this->modalItemTipo === 'rodamiento') {
            $this->actualizarDescripcionRodamiento();
        }
    }
    public function updatedPruebaTipo()
    {
        $this->actualizarDatosPruebas();
    }

    public function updatedPruebaUbicacion()
    {
        if ($this->pruebaUbicacion === 'taller') {
            $this->pruebaCantidadEquipos = 1;
        }

        $this->actualizarDatosPruebas();
    }

    public function updatedPruebaHp()
    {
        $this->actualizarDatosPruebas();
    }

    public function updatedPruebaVoltaje()
    {
        $this->actualizarDatosPruebas();
    }

    public function updatedPruebaCantidadEquipos()
    {
        if (!$this->pruebaCantidadEquipos || $this->pruebaCantidadEquipos < 1) {
            $this->pruebaCantidadEquipos = 1;
        }

        $this->actualizarDatosPruebas();
    }
    public function updatedTransporteTonelaje()
    {
        $this->actualizarDatosTransporte();
    }

    public function updatedTransporteModalidad()
    {
        $this->actualizarDescripcionTransporte();
    }
    public function updatedDescuentoPorcentaje()
    {
        $this->actualizarDatosDescuento();
    }

    public function updatedDescuentoAlcance()
    {
        if ($this->descuentoAlcance === 'principal' && !$this->descuentoItemPrincipalUid) {
            $this->descuentoItemPrincipalUid = $this->obtenerItemPrincipalDescuentoUid();
        }

        $this->actualizarDatosDescuento();
    }


    private function buscarPrecioRebobinado()
    {
        $hp = $this->normalizarNumero($this->rebobinadoHp);
        $polos = $this->normalizarNumero($this->rebobinadoPolos);

        if (!$hp || !$polos) {
            return;
        }

        $precio = CotizacionRebobinadoPrecio::buscarPrecio(
            $hp,
            (int) $polos,
            $this->rebobinadoInverterDuty
        )
            ->orderBy('limite_inferior_hp')
            ->first();

        if (!$precio) {
            return;
        }

        $this->rebobinadoLibrasAlambre = $precio->libras_alambre;
        $this->modalItemPrecioUnitario = $precio->precio_aprox;

        $this->aplicarCostosRebobinadoPorTipo($precio);
    }
    private function actualizarDatosMantenimiento()
    {
        $this->buscarPrecioMantenimiento();
        $this->actualizarDescripcionMantenimiento();
    }

    private function buscarPrecioMantenimiento()
    {
        $hp = $this->normalizarNumero($this->mantenimientoHp);
        $polos = $this->normalizarNumero($this->mantenimientoPolos);
        $voltaje = $this->normalizarNumero($this->mantenimientoVoltaje);

        if (!$hp || !$polos) {
            return;
        }

        $precio = CotizacionMantenimientoPrecio::buscarPrecio(
            $hp,
            (int) $polos,
            $voltaje
        )
            ->first();

        if (!$precio) {
            return;
        }

        $this->modalItemPrecioUnitario = (float) $precio->precio_aprox;

        $this->aplicarCostosMantenimientoPorTipo($precio);
    }

    private function actualizarDescripcionRebobinado()
    {
        $hp = $this->rebobinadoHp;
        $polos = $this->rebobinadoPolos;

        $hpTexto = $hp ? $hp . 'HP' : '';
        $polosTexto = $polos ? $polos . ' polos' : '';

        $titulo = 'Rebobinado de Motor';

        if ($hpTexto || $polosTexto) {
            $titulo .= ' de ';

            $partesTitulo = [];

            if ($hpTexto) {
                $partesTitulo[] = $hpTexto;
            }

            if ($polosTexto) {
                $partesTitulo[] = $polosTexto;
            }

            $titulo .= implode(', ', $partesTitulo);
        }

        if ($this->rebobinadoInverterDuty) {
            $titulo .= ', Clase H';

            $lineas = [
                $titulo,
                'Extracción de alambre en horno de pirólisis controlada',
                'Limpieza de núcleo',
                'Pruebas de Core Loss Test y Hot Spot Test',
                'Fabricación e inserción de bobinas con alambre para operación Inverter Duty clase H',
                'Colocación de cables de salida de alta temperatura clase H',
                'Cálculo de densidades eléctricas para verificación de potencia y torque',
                'Barnizado VPI clase H',
            ];
        } else {
            $titulo .= ', Clase F';

            $lineas = [
                $titulo,
                'Extracción de alambre en horno de pirólisis controlada',
                'Limpieza de núcleo',
                'Pruebas de Core Loss Test y Hot Spot Test',
                'Fabricación e inserción de bobinas',
                'Colocación de cables de salida clase F',
                'Cálculo de densidades eléctricas para verificación de potencia y torque',
                'Barnizado VPI clase H',
            ];
        }

        $trabajosAdicionales = $this->trabajosAdicionalesRebobinado();

        if (count($trabajosAdicionales) > 0) {
            $lineas[] = '';
            $lineas[] = 'Trabajos adicionales:';

            foreach ($trabajosAdicionales as $trabajo) {
                $lineas[] = $trabajo;
            }
        }

        $this->modalItemNombre = $titulo;
        $this->modalItemDescripcion = implode("\n", $lineas);
    }
    private function trabajosAdicionalesRebobinado()
    {
        return $this->trabajosAdicionalesPorTipoServicio(
            $this->rebobinadoTipoServicio
        );
    }
    private function construirDescripcionPruebasRebobinado()
    {
        $lineas = [
            'Prueba de Core Loss Test',
            'Prueba de Hot Spot Test',
            'Prueba DLRO (Micro OHM)',
            'Medición de inductancias, impedancias y Q Factor',
            'IR, Mega Ohm',
            'IP / DAR',
            'Step Voltage DC Hipot',
            'Surge Test Clásico L-L EAR',
            'Surge P-P EAR%',
        ];

        $hp = $this->normalizarNumero($this->rebobinadoHp);

        if ($hp && $hp > 200) {
            $lineas[] = 'Medición de descargas parciales';
            $lineas[] = 'Tan Delta y Cap D Factor';
        }

        $lineas = array_merge(
            $lineas,
            $this->pruebasAdicionalesPorTipoServicio($this->rebobinadoTipoServicio)
        );

        return implode("\n", $lineas);
    }
    private function aplicarCostosRebobinadoPorTipo($precio)
    {
        $costoPruebasBase = (float) $precio->costo_pruebas_estator;

        $costoTrabajosMotorCompleto = (float) $precio->costo_trabajos_motor_completo;
        $costoPruebasMotorCompleto = (float) $precio->costo_pruebas_motor_completo;

        switch ($this->rebobinadoTipoServicio) {
            case 'motor_completo':
                $this->rebobinadoCostoAdicional = $costoTrabajosMotorCompleto;
                $this->rebobinadoCostoPruebas = $costoPruebasBase + $costoPruebasMotorCompleto;
                break;

            case 'motor_reductora':
                $this->rebobinadoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_reductora;

                $this->rebobinadoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_reductora;
                break;

            case 'motor_bomba':
                $this->rebobinadoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_bomba;

                $this->rebobinadoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_bomba;
                break;

            case 'motor_ventilador':
                $this->rebobinadoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_ventilador;

                $this->rebobinadoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_ventilador;
                break;

            case 'motor_maquina':
                $this->rebobinadoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_maquina;

                $this->rebobinadoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_maquina;
                break;

            case 'solo_estator':
            default:
                $this->rebobinadoCostoAdicional = 0;
                $this->rebobinadoCostoPruebas = $costoPruebasBase;
                break;
        }
    }
    public function totalRebobinadoModal()
    {
        return (float) $this->modalItemPrecioUnitario
            + (float) $this->rebobinadoCostoAdicional;
    }

    private function cargarDatosMantenimientoDesdeMotor()
    {
        if (!$this->motor_id) {
            return;
        }

        $motor = Motor::where('id_motor', $this->motor_id)->first();

        if (!$motor) {
            return;
        }

        $hpBase = $this->normalizarNumero($motor->hp ?? null);

        if ($hpBase !== null) {
            if ((int) $motor->hpkw === 0) {
                $this->mantenimientoHp = round($hpBase, 2);
            } else {
                $this->mantenimientoHp = round($hpBase * 1.341, 2);
            }
        }

        $hz = $this->normalizarNumero($motor->hz ?? null);
        $rpm = $this->normalizarNumero($motor->rpm ?? null);

        $this->mantenimientoPolos = $this->calcularPolosMotor($hz, $rpm);

        $this->mantenimientoVoltaje = $this->normalizarNumero($motor->volts ?? null);
    }
    private function aplicarCostosMantenimientoPorTipo($precio)
    {
        $costoPruebasBase = (float) $precio->costo_pruebas_estator;

        $costoTrabajosMotorCompleto = (float) $precio->costo_trabajos_motor_completo;
        $costoPruebasMotorCompleto = (float) $precio->costo_pruebas_motor_completo;

        switch ($this->mantenimientoTipoServicio) {
            case 'motor_completo':
                $this->mantenimientoCostoAdicional = $costoTrabajosMotorCompleto;
                $this->mantenimientoCostoPruebas = $costoPruebasBase + $costoPruebasMotorCompleto;
                break;

            case 'motor_reductora':
                $this->mantenimientoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_reductora;

                $this->mantenimientoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_reductora;
                break;

            case 'motor_bomba':
                $this->mantenimientoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_bomba;

                $this->mantenimientoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_bomba;
                break;

            case 'motor_ventilador':
                $this->mantenimientoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_ventilador;

                $this->mantenimientoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_ventilador;
                break;

            case 'motor_maquina':
                $this->mantenimientoCostoAdicional =
                    $costoTrabajosMotorCompleto + (float) $precio->costo_trabajos_maquina;

                $this->mantenimientoCostoPruebas =
                    $costoPruebasBase + $costoPruebasMotorCompleto + (float) $precio->costo_pruebas_maquina;
                break;

            case 'solo_estator':
            default:
                $this->mantenimientoCostoAdicional = 0;
                $this->mantenimientoCostoPruebas = $costoPruebasBase;
                break;
        }
    }
    private function actualizarDescripcionMantenimiento()
    {
        $hp = $this->mantenimientoHp;
        $polos = $this->mantenimientoPolos;

        $hpTexto = $hp ? $hp . 'HP' : '';
        $polosTexto = $polos ? $polos . ' polos' : '';

        $titulo = $this->tituloMantenimientoPorTipo();

        $partesTitulo = [];

        if ($hpTexto) {
            $partesTitulo[] = $hpTexto;
        }

        if ($polosTexto) {
            $partesTitulo[] = $polosTexto;
        }

        if (count($partesTitulo) > 0) {
            $titulo .= ' ' . implode(', ', $partesTitulo);
        }

        $lineas = [];

        $trabajosAdicionales = $this->trabajosAdicionalesMantenimiento();

        foreach ($trabajosAdicionales as $trabajo) {
            $lineas[] = $trabajo;
        }

        $lineas = array_merge($lineas, [
            'Lavado de bobina con dieléctricos y desplazantes de humedad.',
            'Secado en horno a temperatura regulada.',
            'Re-Barnizado de bobina para aumentar capacidad dieléctrica.',
            'Revisión de conexiones y borneras.',
            'Inspección de cables de salida.',
            'Eliminación de corrosión en núcleo.',
            'Pintura externa.',
        ]);

        $this->modalItemNombre = $titulo;
        $this->modalItemDescripcion = implode("\n", $lineas);
    }
    private function tituloMantenimientoPorTipo()
    {
        switch ($this->mantenimientoTipoServicio) {
            case 'motor_completo':
                return 'Mantenimiento de Motor Completo';

            case 'motor_reductora':
                return 'Mantenimiento de Motor con Caja Reductora';

            case 'motor_bomba':
                return 'Mantenimiento de Motor con Bomba';

            case 'motor_ventilador':
                return 'Mantenimiento de Motor con Ventilador';

            case 'motor_maquina':
                return 'Mantenimiento de Motor con Máquina';

            case 'solo_estator':
            default:
                return 'Mantenimiento de Estator';
        }
    }
    private function trabajosAdicionalesMantenimiento()
    {
        return $this->trabajosAdicionalesPorTipoServicio(
            $this->mantenimientoTipoServicio
        );
    }
    private function construirDescripcionPruebasMantenimiento()
    {
        $lineas = [
            'Prueba DLRO (Micro OHM)',
            'Medición de inductancias, impedancias y Q Factor',
            'IR, Mega Ohm',
            'IP / DAR',
            'Step Voltage DC Hipot',
            'Surge Test Clásico L-L EAR',
            'Surge P-P EAR%',
        ];

        $hp = $this->normalizarNumero($this->mantenimientoHp);

        if ($hp && $hp > 200) {
            $lineas[] = 'Medición de descargas parciales';
            $lineas[] = 'Tan Delta y Cap D Factor';
        }

        $lineas = array_merge(
            $lineas,
            $this->pruebasAdicionalesPorTipoServicio($this->mantenimientoTipoServicio)
        );

        return implode("\n", $lineas);
    }
    public function totalMantenimientoModal()
    {
        return (float) $this->modalItemPrecioUnitario
            + (float) $this->mantenimientoCostoAdicional;
    }
    private function trabajosMotorCompletoBase()
    {
        return [
            'Desarmado y armado de motor',
            'Extracción e instalación de rodamientos',
        ];
    }

    private function trabajosEquipoAcoplado($tipoServicio)
    {
        switch ($tipoServicio) {
            case 'motor_reductora':
                return [
                    'Desacoplamiento de caja reductora',
                    'Limpieza general y lavado con líquidos especiales',
                    'Revisión de desgastes en engranes, piñones y coronas',
                    'Extracción e instalación de retenedores',
                    'Re-lubricación de caja reductora',
                ];

            case 'motor_bomba':
                return [
                    'Desarmado de bomba',
                    'Extracción de impulsor(es)',
                    'Limpieza de impulsor y voluta',
                    'Cambio de O-rings',
                    'Extracción e instalación de sello mecánico',
                ];

            case 'motor_ventilador':
                return [
                    'Extracción e instalación de turbina',
                    'Limpieza de turbina',
                    'Medición de deflexión de turbina',
                ];

            case 'motor_maquina':
                return [
                    'Desarmado y armado de máquina',
                    'Montaje y desmontaje de motor',
                    'Revisión de tableros de instrumentación',
                    'Limpieza de máquina en general',
                ];

            default:
                return [];
        }
    }

    private function trabajosAdicionalesPorTipoServicio($tipoServicio)
    {
        if ($tipoServicio === 'solo_estator') {
            return [];
        }

        if ($tipoServicio === 'motor_completo') {
            return $this->trabajosMotorCompletoBase();
        }

        return array_merge(
            $this->trabajosMotorCompletoBase(),
            $this->trabajosEquipoAcoplado($tipoServicio)
        );
    }
    private function pruebasMotorCompletoBase()
    {
        return [
            'Medición de ajustes mecánicos en ejes',
            'Medición de ajustes mecánicos en alojamientos',
            'Medición de cuñeros y sellos',
            'Arranque de motor a voltaje y velocidad nominal',
            'Medición de velocidad, voltajes, corrientes y potencia',
            'Prueba termográfica',
            'Análisis de vibraciones a equipo',
        ];
    }

    private function pruebasEquipoAcoplado($tipoServicio)
    {
        switch ($tipoServicio) {
            case 'motor_reductora':
                return [
                    'Medición de ajustes en ejes de salida de caja reductora',
                    'Prueba de estanqueidad a caja reductora',
                    'Medición de velocidades de salida de caja reductora',
                    'Análisis de vibraciones FFT a caja reductora',
                ];

            case 'motor_bomba':
                return [
                    'Medición de ajuste en anillo de desgaste',
                    'Medición de ajustes en eje donde asienta sello mecánico',
                    'Medición de RunOut de impulsor',
                    'Prueba de vibración a bomba',
                    'Pruebas de funcionamiento con carga y medición de presión de salida',
                ];

            case 'motor_ventilador':
                return [
                    'Pruebas de desbalance en turbina',
                    'Pruebas con carga configurada con VFD',
                    'Medición de flujo de aire en CFM',
                ];

            case 'motor_maquina':
                return [
                    'Pruebas con carga',
                    'Medición de vibraciones de todo el conjunto',
                ];

            default:
                return [];
        }
    }

    private function pruebasAdicionalesPorTipoServicio($tipoServicio)
    {
        if ($tipoServicio === 'solo_estator') {
            return [];
        }

        if ($tipoServicio === 'motor_completo') {
            return $this->pruebasMotorCompletoBase();
        }

        return array_merge(
            $this->pruebasMotorCompletoBase(),
            $this->pruebasEquipoAcoplado($tipoServicio)
        );
    }
    private function cargarDatosBalanceoDesdeMotor()
    {
        if (!$this->motor_id) {
            return;
        }

        $motor = Motor::where('id_motor', $this->motor_id)->first();

        if (!$motor) {
            return;
        }

        $hpBase = $this->normalizarNumero($motor->hp ?? null);

        if ($hpBase !== null) {
            if ((int) $motor->hpkw === 0) {
                $this->balanceoHp = round($hpBase, 2);
            } else {
                $this->balanceoHp = round($hpBase * 1.341, 2);
            }
        }

        $hz = $this->normalizarNumero($motor->hz ?? null);
        $rpm = $this->normalizarNumero($motor->rpm ?? null);

        $this->balanceoPolos = $this->calcularPolosMotor($hz, $rpm);
    }
    private function actualizarDatosBalanceo()
    {
        $this->buscarPrecioBalanceo();
        $this->actualizarDescripcionBalanceo();
    }

    private function buscarPrecioBalanceo()
    {
        $hp = $this->normalizarNumero($this->balanceoHp);
        $polos = $this->normalizarNumero($this->balanceoPolos);

        if (!$hp || !$polos) {
            return;
        }

        $precio = CotizacionBalanceoPrecio::buscarPrecio(
            $hp,
            (int) $polos
        )
            ->orderBy('limite_inferior_hp')
            ->first();

        if (!$precio) {
            return;
        }

        $this->modalItemPrecioUnitario = (float) $precio->precio_aprox;
    }

    private function actualizarDescripcionBalanceo()
    {
        $hp = $this->balanceoHp;
        $polos = $this->balanceoPolos;

        $partes = [];

        if ($hp) {
            $partes[] = $hp . 'HP';
        }

        if ($polos) {
            $partes[] = $polos . ' polos';
        }

        $this->modalItemNombre = 'Balanceo dinámico de rotor';

        if (count($partes) > 0) {
            $this->modalItemNombre .= ' ' . implode(', ', $partes);
        }

        $this->modalItemDescripcion = 'Balanceo dinámico de rotor bajo norma ISO 1940 G1.0';
    }

    private function actualizarDatosEncamisado()
    {
        $this->buscarPrecioEncamisado();
        $this->actualizarDescripcionEncamisado();
    }

    private function buscarPrecioEncamisado()
    {
        $diametro = $this->normalizarNumero($this->encamisadoDiametroExterior);

        if (!$diametro) {
            $this->encamisadoPrecioBase = 0;
            $this->modalItemPrecioUnitario = 0;
            return;
        }

        $precio = CotizacionEncamisadoPrecio::buscarPrecio($diametro)
            ->first();

        if (!$precio) {
            $this->encamisadoPrecioBase = 0;
            $this->modalItemPrecioUnitario = 0;
            return;
        }

        $this->encamisadoPrecioBase = (float) $precio->precio;

        $precioCalculado = $this->encamisadoPrecioBase;

        if ($this->encamisadoProfundo) {
            $precioCalculado *= 1.3;
        }

        if ($this->encamisadoRanura) {
            if ($diametro <= 120) {
                $precioCalculado *= 1.2;
            } else {
                $precioCalculado *= 1.15;
            }
        }

        $this->modalItemPrecioUnitario = round($precioCalculado, 2);
    }

    private function actualizarDescripcionEncamisado()
    {
        $diametro = $this->normalizarNumero($this->encamisadoDiametroExterior);

        $codigoRodamiento = $this->encamisadoRodamientoCodigo;

        $tieneCodigoRodamiento = $codigoRodamiento
            && $codigoRodamiento !== 'OTRO';

        $diametroTexto = $diametro
            ? $diametro . 'mm'
            : '';

        if ($this->encamisadoProfundo) {
            $descripcion = 'Encamisado profundo o sobredimensionado de alojamiento para rodamiento';
        } else {
            $descripcion = 'Encamisado de alojamiento para rodamiento';
        }

        if ($tieneCodigoRodamiento) {
            $descripcion .= ' No ' . $codigoRodamiento;
        }

        if ($diametroTexto) {
            $descripcion .= ' de ' . $diametroTexto;
        }

        $descripcion .= '. Alojamiento en hierro fundido con tolerancia K5, pulido 3 triángulos.';

        if ($this->encamisadoRanura) {
            $descripcion .= "\n" . 'Maquinado de ranura para seguro u O-ring.';
        }

        if ($this->encamisadoProfundo) {
            $this->modalItemNombre = 'Encamisado profundo de alojamiento';
        } else {
            $this->modalItemNombre = 'Encamisado de alojamiento';
        }

        if ($tieneCodigoRodamiento) {
            $this->modalItemNombre .= ' ' . $codigoRodamiento;
        }

        $this->modalItemDescripcion = $descripcion;
    }
    private function actualizarDatosRodamiento()
    {
        $this->construirDesignacionRodamiento();
        $this->buscarPrecioExactoRodamiento();
        $this->buscarReferenciasRodamiento();
        $this->actualizarDescripcionRodamiento();
    }

    private function construirDesignacionRodamiento()
    {
        $partes = [];

        if ($this->rodamientoMarca) {
            $partes[] = trim($this->rodamientoMarca);
        }

        if ($this->rodamientoCodigo) {
            $partes[] = trim($this->rodamientoCodigo);
        }

        if ($this->rodamientoSellos) {
            $partes[] = trim($this->rodamientoSellos);
        }

        if ($this->rodamientoJaula) {
            $partes[] = trim($this->rodamientoJaula);
        }

        if ($this->rodamientoJuegoRadial) {
            $partes[] = trim($this->rodamientoJuegoRadial);
        }

        if ($this->rodamientoAislamiento) {
            $partes[] = trim($this->rodamientoAislamiento);
        }

        $this->rodamientoDesignacion = implode(' ', array_filter($partes));
    }
    public function jaulasRodamientoDisponibles()
    {
        if (!$this->rodamientoCodigo) {
            return [''];
        }

        $codigo = strtoupper($this->rodamientoCodigo);

        if (
            str_starts_with($codigo, '600') ||
            str_starts_with($codigo, '601') ||
            str_starts_with($codigo, '602') ||
            str_starts_with($codigo, '603') ||
            str_starts_with($codigo, '620') ||
            str_starts_with($codigo, '621') ||
            str_starts_with($codigo, '622') ||
            str_starts_with($codigo, '623') ||
            str_starts_with($codigo, '630') ||
            str_starts_with($codigo, '631') ||
            str_starts_with($codigo, '632') ||
            str_starts_with($codigo, '633')
        ) {
            return ['', '/M'];
        }

        if (
            str_starts_with($codigo, 'NU2') ||
            str_starts_with($codigo, 'NU3')
        ) {
            return ['', 'ECJ', 'ECM', 'ECP'];
        }

        return [''];
    }

    private function normalizarJaulaRodamiento()
    {
        $opciones = $this->jaulasRodamientoDisponibles();

        if (!in_array($this->rodamientoJaula, $opciones)) {
            $this->rodamientoJaula = '';
        }
    }
    private function monedaReferenciaRodamiento()
    {
        return $this->monedaCotizacion === 'USD'
            ? 'USD'
            : 'GTQ';
    }
    private function buscarPrecioExactoRodamiento()
    {
        if (!$this->rodamientoCodigo || !$this->rodamientoMarca) {
            return;
        }

        $precio = CotizacionRodamientoPrecio::where('activo', 1)
            ->where('codigo_base', $this->rodamientoCodigo)
            ->where('marca', $this->rodamientoMarca)
            ->where('sellos', $this->rodamientoSellos ?: '')
            ->where('jaula', $this->rodamientoJaula ?: '')
            ->where('juego_radial', $this->rodamientoJuegoRadial ?: '')
            ->where('aislamiento', $this->rodamientoAislamiento ?: '')
            ->where('moneda', $this->monedaReferenciaRodamiento())
            ->first();

        if ($precio) {
            $this->modalItemPrecioUnitario = (float) $precio->precio;
        } else {
            $this->modalItemPrecioUnitario = 0;
        }
    }
    private function buscarReferenciasRodamiento()
    {
        if (!$this->rodamientoCodigo) {
            $this->rodamientoReferenciasPrecio = [];
            return;
        }

        $query = CotizacionRodamientoPrecio::where('activo', 1)
            ->where('codigo_base', $this->rodamientoCodigo)
            ->where('moneda', $this->monedaReferenciaRodamiento());

        if ($this->rodamientoMarca) {
            $query->where('marca', $this->rodamientoMarca);
        }

        if ($this->rodamientoDesignacion) {
            $query->where('designacion', '!=', $this->rodamientoDesignacion);
        }

        $this->rodamientoReferenciasPrecio = $query
            ->orderByDesc('updated_at')
            ->limit(10)
            ->get()
            ->map(function ($precio) {
                return [
                    'designacion' => $precio->designacion,
                    'precio' => (float) $precio->precio,
                    'moneda' => $precio->moneda,
                    'veces_usado' => $precio->veces_usado,
                    'fecha' => optional($precio->updated_at)->format('d/m/Y'),
                ];
            })
            ->toArray();
    }
    private function actualizarDescripcionRodamiento()
    {
        if (!$this->rodamientoDesignacion) {
            $this->modalItemNombre = 'Rodamiento';
            $this->modalItemDescripcion = '';
            return;
        }

        $this->modalItemNombre = 'Rodamiento ' . $this->rodamientoDesignacion;

        $descripcion = 'Suministro de rodamiento ' . $this->rodamientoDesignacion . '.';

        if ($this->rodamientoDiametroExterior) {
            $descripcion .= "\n" . 'Diámetro exterior: ' . $this->rodamientoDiametroExterior . ' mm.';
        }

        $this->modalItemDescripcion = $descripcion;
    }
    private function guardarPrecioReferenciaRodamiento($precio, $moneda)
    {
        $registro = CotizacionRodamientoPrecio::where('codigo_base', $this->rodamientoCodigo)
            ->where('marca', $this->rodamientoMarca)
            ->where('sellos', $this->rodamientoSellos ?: '')
            ->where('jaula', $this->rodamientoJaula ?: '')
            ->where('juego_radial', $this->rodamientoJuegoRadial ?: '')
            ->where('aislamiento', $this->rodamientoAislamiento ?: '')
            ->where('moneda', $moneda)
            ->first();

        if ($registro) {
            $registro->update([
                'serie' => $this->rodamientoSerie,
                'designacion' => $this->rodamientoDesignacion,
                'precio' => $precio,
                'veces_usado' => $registro->veces_usado + 1,
                'activo' => 1,
            ]);

            return;
        }

        CotizacionRodamientoPrecio::create([
            'codigo_base' => $this->rodamientoCodigo,
            'serie' => $this->rodamientoSerie,
            'marca' => $this->rodamientoMarca,
            'sellos' => $this->rodamientoSellos ?: '',
            'jaula' => $this->rodamientoJaula ?: '',
            'juego_radial' => $this->rodamientoJuegoRadial ?: '',
            'aislamiento' => $this->rodamientoAislamiento ?: '',
            'designacion' => $this->rodamientoDesignacion,
            'precio' => $precio,
            'moneda' => $moneda,
            'veces_usado' => 1,
            'activo' => 1,
        ]);
    }
    private function cargarDatosPruebasDesdeMotor()
    {
        if (!$this->motor_id) {
            return;
        }

        $motor = Motor::where('id_motor', $this->motor_id)->first();

        if (!$motor) {
            return;
        }

        $hpBase = $this->normalizarNumero($motor->hp ?? null);

        if ($hpBase !== null) {
            if ((int) $motor->hpkw === 0) {
                $this->pruebaHp = round($hpBase, 2);
            } else {
                $this->pruebaHp = round($hpBase * 1.341, 2);
            }
        }

        $this->pruebaVoltaje = $this->normalizarNumero($motor->volts ?? null);
    }
    private function actualizarDatosPruebas()
    {
        $this->calcularTensionPruebas();
        $this->actualizarDescripcionPruebas();
        $this->buscarReferenciasPruebas();
    }

    private function calcularTensionPruebas()
    {
        $voltaje = $this->normalizarNumero($this->pruebaVoltaje);

        $this->pruebaTensionTipo = ($voltaje && $voltaje > 1000)
            ? 'MT'
            : 'BT';
    }
    private function labelTipoPrueba($tipo = null)
    {
        $tipo = $tipo ?: $this->pruebaTipo;

        return match ($tipo) {
            'estaticas' => 'Pruebas Estáticas',
            'dinamicas' => 'Pruebas Dinámicas',
            'vibraciones' => 'Pruebas de Vibraciones',
            'termografia' => 'Termografía',
            default => 'Pruebas',
        };
    }

    private function labelUbicacionPrueba()
    {
        return $this->pruebaUbicacion === 'sitio'
            ? 'en sitio'
            : 'en taller';
    }

    private function labelTensionPrueba()
    {
        return $this->pruebaTensionTipo === 'MT'
            ? 'Media tensión'
            : 'Baja tensión';
    }
    private function actualizarDescripcionPruebas()
    {
        $nombre = $this->labelTipoPrueba()
            . ' '
            . $this->labelUbicacionPrueba();

        if ($this->pruebaVoltaje) {
            $nombre .= ' ' . $this->pruebaVoltaje . 'V';
        }

        if ($this->pruebaHp) {
            $nombre .= ' ' . $this->pruebaHp . 'HP';
        }

        if ($this->pruebaUbicacion === 'sitio' && $this->pruebaCantidadEquipos > 1) {
            $nombre .= ' - ' . $this->pruebaCantidadEquipos . ' equipos';
        }

        $this->modalItemNombre = $nombre;

        $this->modalItemDescripcion = implode("\n", $this->lineasDescripcionPruebas());
    }
    private function lineasDescripcionPruebas()
    {
        $lineas = [];

        switch ($this->pruebaTipo) {
            case 'estaticas':
                $lineas = [
                    'Medición de capacitancia a carcaza, Cap D Factor y Tan Delta',
                    'Medición de balance de impedancias e inductancias',
                    'Medición de Q Factor',
                    'Medición de Micro Ohm, balance resistivo (DLRO)',
                    'Medición de aislamiento a tierra (IR)',
                    'Medición de IP (Índice de polarización) / DAR (Índice de absorción dieléctrica)',
                    'Prueba de voltaje a pasos (Step Voltage DC Hipot)',
                    'Prueba de Surge Clásico L-L EAR%',
                    'Prueba de Surge P-P EAR%',
                    'Prueba de descargas parciales',
                ];
                break;

            case 'dinamicas':
                $lineas = [
                    'Medición de voltajes Ph1, Ph2, Ph3, neutro, % desbalance, THD, Crest Factor, total y RMS',
                    'NEMA Derate, HVF',
                    'Medición de corrientes Ph1, Ph2, Ph3, % carga, % desbalance, THD y Crest Factor',
                    'Medición de impedancias real e imaginaria',
                    'Medición de potencia activa, reactiva y aparente',
                    'Medición de factor de potencia',
                    'Medición de torque y potencia mecánica',
                    'Medición de eficiencia',
                    'Medición de componentes simétricas',
                    'Medición de fasores',
                    'Medición con osciloscopio de potencia de V/dt e I/dt',
                    'FFT de voltajes y potencias',
                    'Medición de armónicos hasta el 50avo armónico',
                    'Medición instantánea de potencia y FFT de potencia',
                    'Medición de vibraciones mecánicas a través de red eléctrica (DMOD)',
                    'Medición instantánea de corrientes y voltajes en arranque (Inrush Current)',
                    'Medición de corrientes en rotor, inducción y bandas laterales de rotor',
                    'Medición de excentricidad dinámica y estática de rotor',
                ];
                break;

            case 'vibraciones':
                $lineas = [
                    'Medición global de vibración triaxial RMS bajo norma ISO 20816',
                    'Medición global de aceleraciones oscilantes',
                    'Medición global de aceleraciones envolvente',
                    'Medición FFT de velocidades, aceleraciones oscilantes y envolventes',
                    'Medición de Crest Factor',
                ];
                break;

            case 'termografia':
                $lineas = [
                    'Medición termográfica de motor',
                    'Medición termográfica de cajas de rodamientos',
                    'Medición termográfica de estator',
                    'Medición termográfica de acoplamiento',
                    'Medición termográfica de caja de conexiones',
                    'Medición termográfica de cables',
                    'Medición termográfica de gabinete de conexiones',
                ];
                break;
        }

        return $lineas;
    }
    public function totalPruebasModal()
    {
        $cantidad = $this->pruebaUbicacion === 'sitio'
            ? (int) $this->pruebaCantidadEquipos
            : 1;

        if ($cantidad < 1) {
            $cantidad = 1;
        }

        return round((float) $this->modalItemPrecioUnitario * $cantidad, 2);
    }
    private function buscarReferenciasPruebas()
    {
        if (!$this->pruebaTipo || !$this->pruebaUbicacion) {
            $this->pruebaReferenciasPrecio = [];
            return;
        }

        $voltaje = $this->normalizarNumero($this->pruebaVoltaje);
        $cantidad = (int) ($this->pruebaCantidadEquipos ?: 1);

        $query = CotizacionPruebaPrecio::where('activo', 1)
            ->where('prueba_tipo', $this->pruebaTipo)
            ->where('ubicacion', $this->pruebaUbicacion)
            ->where('tension_tipo', $this->pruebaTensionTipo)
            ->where('moneda', $this->monedaReferenciaPruebas());

        if ($this->cliente_id) {
            $query->orderByRaw(
                'CASE WHEN cliente_id = ? THEN 0 ELSE 1 END',
                [$this->cliente_id]
            );
        }

        if ($voltaje) {
            $query->orderByRaw(
                'ABS(COALESCE(voltaje, 0) - ?) ASC',
                [$voltaje]
            );
        }

        if ($this->pruebaUbicacion === 'sitio') {
            $query->orderByRaw(
                'ABS(COALESCE(cantidad_equipos, 1) - ?) ASC',
                [$cantidad]
            );
        }

        $referencias = $query
            ->orderByDesc('updated_at')
            ->limit(80)
            ->get();

        $resultado = [];
        $conteoPorCliente = [];

        foreach ($referencias as $referencia) {
            $clienteKey = $referencia->cliente_id
                ? 'cliente_' . $referencia->cliente_id
                : 'sin_cliente_' . $referencia->id;

            if (!isset($conteoPorCliente[$clienteKey])) {
                $conteoPorCliente[$clienteKey] = 0;
            }

            if ($conteoPorCliente[$clienteKey] >= 4) {
                continue;
            }

            $conteoPorCliente[$clienteKey]++;

            $resultado[] = [
                'cliente' => $referencia->cliente_nombre ?: 'Sin cliente',
                'nombre' => $referencia->nombre,
                'hp' => (float) $referencia->hp,
                'voltaje' => (float) $referencia->voltaje,
                'cantidad_equipos' => (int) $referencia->cantidad_equipos,
                'precio_unitario' => (float) $referencia->precio_unitario,
                'precio_total' => (float) $referencia->precio_total,
                'moneda' => $referencia->moneda,
                'fecha' => optional($referencia->updated_at)->format('d/m/Y'),
            ];

            if (count($resultado) >= 10) {
                break;
            }
        }

        $this->pruebaReferenciasPrecio = $resultado;
    }

    private function monedaReferenciaPruebas()
    {
        return $this->monedaCotizacion === 'USD'
            ? 'USD'
            : 'GTQ';
    }
    private function guardarReferenciaPruebas($precioUnitario, $precioTotal, $cantidad)
    {
        $clienteNombre = null;

        if ($this->cliente_id) {
            $cliente = Cliente::where('id_cliente', $this->cliente_id)->first();
            $clienteNombre = optional($cliente)->cliente;
        }

        CotizacionPruebaPrecio::create([
            'cliente_id' => $this->cliente_id,
            'cliente_nombre' => $clienteNombre,

            'cotizacion_id' => $this->cotizacionGuardadaId,

            'prueba_tipo' => $this->pruebaTipo,
            'ubicacion' => $this->pruebaUbicacion,
            'tension_tipo' => $this->pruebaTensionTipo,

            'hp' => $this->pruebaHp,
            'voltaje' => $this->pruebaVoltaje,
            'cantidad_equipos' => $cantidad,

            'nombre' => $this->modalItemNombre,
            'descripcion' => $this->modalItemDescripcion,

            'precio_unitario' => $precioUnitario,
            'precio_total' => $precioTotal,

            'moneda' => $this->monedaReferenciaPruebas(),

            'activo' => 1,
        ]);
    }
    private function actualizarDatosTransporte()
    {
        $this->calcularModalidadTransporte();
        $this->actualizarDescripcionTransporte();
    }

    private function calcularModalidadTransporte()
    {
        $tonelaje = $this->normalizarNumero($this->transporteTonelaje);

        if (!$tonelaje) {
            $this->transporteModalidad = '';
            $this->transporteVehiculo = '';
            $this->transportePesoReferencia = '';
            return;
        }

        /*
     * 70 lb equivalen aproximadamente a 0.032 toneladas métricas.
     * Usamos 0.035 como margen práctico.
     */
        if ($tonelaje < 0.035) {
            $this->transporteModalidad = 'moto';
            $this->transporteVehiculo = 'moto';
            $this->transportePesoReferencia = 'peso menor de 70 lb';
            return;
        }

        if ($tonelaje >= 0.035 && $tonelaje <= 2.5) {
            $this->transporteModalidad = 'pickup';
            $this->transporteVehiculo = 'Pickup o Camioncito';
            $this->transportePesoReferencia = 'peso máximo 2.5 Ton';
            return;
        }

        if ($tonelaje > 2.5 && $tonelaje <= 7) {
            $this->transporteModalidad = 'camion_grua';
            $this->transporteVehiculo = 'Camión Grúa';
            $this->transportePesoReferencia = 'peso máximo 7 Ton';
            return;
        }

        $this->transporteModalidad = 'plataforma';
        $this->transporteVehiculo = 'Plataforma o Lowboy';
        $this->transportePesoReferencia = 'peso mayor a 7 Ton';
    }
    private function actualizarDescripcionTransporte()
    {
        if (!$this->transporteVehiculo) {
            $this->modalItemNombre = 'Transporte';
            $this->modalItemDescripcion = 'Traslado ida y vuelta hacia su planta.';
            return;
        }

        $this->modalItemNombre = 'Transporte en ' . $this->transporteVehiculo;

        $this->modalItemDescripcion = 'Traslado ida y vuelta hacia su planta, utilizando '
            . $this->transporteVehiculo
            . ', '
            . $this->transportePesoReferencia
            . '.';
    }
    private function abrirModalDescuento($item)
    {
        $this->modalItemTipo = 'descuento';

        $this->modalItemCatalogoId = $item->id;
        $this->modalItemEsAccion = false;

        $this->modalItemNombre = 'Descuento Especial';
        $this->modalItemDescripcion = '';
        $this->modalItemCantidad = 1;
        $this->modalItemPrecioUnitario = 0;

        $this->descuentoPorcentaje = 0;
        $this->descuentoAlcance = 'principal';
        $this->descuentoItemPrincipalUid = $this->obtenerItemPrincipalDescuentoUid();

        $this->descuentoItemsPreview = [];
        $this->descuentoTotal = 0;

        $this->actualizarDatosDescuento();

        $this->dispatchBrowserEvent('abrir-modal-item-cotizacion');
    }
    private function obtenerItemPrincipalDescuentoUid()
    {
        foreach ($this->itemsCotizacion as $item) {
            if (($item['tipo_item'] ?? null) === 'rebobinado') {
                return $item['uid'];
            }
        }

        foreach ($this->itemsCotizacion as $item) {
            if (($item['tipo_item'] ?? null) === 'mantenimiento') {
                return $item['uid'];
            }
        }

        /*
     * Fallback por nombre, útil si hay items creados antes de agregar tipo_item.
     */
        foreach ($this->itemsCotizacion as $item) {
            $nombre = strtolower($item['nombre'] ?? '');

            if (str_contains($nombre, 'rebobinado') || str_contains($nombre, 'mantenimiento')) {
                return $item['uid'];
            }
        }

        return null;
    }
    private function actualizarDatosDescuento()
    {
        $porcentaje = $this->normalizarNumero($this->descuentoPorcentaje);

        if (!$porcentaje || $porcentaje <= 0) {
            $this->descuentoItemsPreview = [];
            $this->descuentoTotal = 0;
            $this->modalItemPrecioUnitario = 0;
            $this->modalItemDescripcion = '';
            return;
        }

        $itemsAfectos = $this->obtenerItemsAfectosDescuento(
            $this->descuentoAlcance,
            $this->descuentoItemPrincipalUid
        );

        $preview = [];
        $totalDescuento = 0;

        foreach ($itemsAfectos as $item) {
            $precioOriginal = (float) ($item['precio_total'] ?? 0);

            if ($precioOriginal <= 0) {
                continue;
            }

            $descuento = round($precioOriginal * ($porcentaje / 100), 2);
            $precioConDescuento = round($precioOriginal - $descuento, 2);

            $preview[] = [
                'uid' => $item['uid'],
                'nombre' => $item['nombre'],
                'precio_original' => $precioOriginal,
                'precio_con_descuento' => $precioConDescuento,
                'diferencia' => $descuento,
            ];

            $totalDescuento += $descuento;
        }

        $this->descuentoItemsPreview = $preview;
        $this->descuentoTotal = round($totalDescuento, 2);

        $this->modalItemPrecioUnitario = -1 * $this->descuentoTotal;
        $this->modalItemNombre = 'Descuento especial ' . $porcentaje . '%';

        $this->modalItemDescripcion = $this->descripcionDescuento(
            $porcentaje,
            $itemsAfectos
        );
    }
    private function obtenerItemsAfectosDescuento($alcance, $itemPrincipalUid = null)
    {
        $items = collect($this->itemsCotizacion)
            ->filter(function ($item) {
                return ($item['tipo_item'] ?? null) !== 'descuento'
                    && (float) ($item['precio_total'] ?? 0) > 0;
            });

        if ($alcance === 'todos') {
            return $items->values()->toArray();
        }

        if (!$itemPrincipalUid) {
            return [];
        }

        return $items
            ->filter(function ($item) use ($itemPrincipalUid) {
                return ($item['uid'] ?? null) === $itemPrincipalUid;
            })
            ->values()
            ->toArray();
    }
    private function descripcionDescuento($porcentaje, $itemsAfectos)
    {
        if ($this->descuentoAlcance === 'todos') {
            return 'Descuento especial aplicado a cliente preferente de '
                . $porcentaje
                . '%, aplicado a toda la cotización.';
        }

        $item = collect($itemsAfectos)->first();

        $nombreItem = $item['nombre'] ?? 'item principal';

        return 'Descuento especial aplicado a cliente preferente de '
            . $porcentaje
            . '%, aplicado únicamente al '
            . $nombreItem
            . '.';
    }
    public function ordenarItemsCotizacion($ordenUids)
    {
        if (!is_array($ordenUids)) {
            return;
        }

        $itemsPorUid = collect($this->itemsCotizacion)
            ->keyBy('uid');

        $itemsOrdenados = [];

        foreach ($ordenUids as $uid) {
            if ($itemsPorUid->has($uid)) {
                $itemsOrdenados[] = $itemsPorUid->get($uid);
            }
        }

        foreach ($this->itemsCotizacion as $item) {
            if (!in_array($item['uid'], $ordenUids)) {
                $itemsOrdenados[] = $item;
            }
        }

        $this->itemsCotizacion = array_values($itemsOrdenados);

        $this->recalcularTotalesItems();
    }


    private function cargarPdfsAdjuntosCotizacion($cotizacion)
    {
        $cotizacionFuente = $this->obtenerCotizacionFuentePdfsAdjuntos($cotizacion);

        $cotizacionFuente->loadMissing(['pdfsAntesItems', 'pdfsDespuesItems']);

        $this->pdfsAntesItems = $cotizacionFuente->pdfsAntesItems
            ->map(function ($pdf) {
                return [
                    'uuid' => 'db-' . $pdf->id,
                    'id' => $pdf->id,
                    'cotizacion_id' => $pdf->cotizacion_id,
                    'nombre_original' => $pdf->nombre_original,
                    'path' => $pdf->path,
                    'mime_type' => $pdf->mime_type,
                    'size_bytes' => $pdf->size_bytes,
                    'orden' => $pdf->orden,
                    'nuevo' => false,
                ];
            })
            ->values()
            ->toArray();

        $this->pdfsDespuesItems = $cotizacionFuente->pdfsDespuesItems
            ->map(function ($pdf) {
                return [
                    'uuid' => 'db-' . $pdf->id,
                    'id' => $pdf->id,
                    'cotizacion_id' => $pdf->cotizacion_id,
                    'nombre_original' => $pdf->nombre_original,
                    'path' => $pdf->path,
                    'mime_type' => $pdf->mime_type,
                    'size_bytes' => $pdf->size_bytes,
                    'orden' => $pdf->orden,
                    'nuevo' => false,
                ];
            })
            ->values()
            ->toArray();
    }
    private function obtenerCotizacionFuentePdfsAdjuntos(Cotizacion $cotizacion): Cotizacion
    {
        /*
     * Si esta cotización ya tiene PDFs propios, usamos esta.
     */
        $tienePdfsPropios = CotizacionPdfAdjunto::where('cotizacion_id', $cotizacion->id)->exists();

        if ($tienePdfsPropios) {
            return $cotizacion;
        }

        /*
     * Si no tiene PDFs propios, buscamos una versión anterior
     * del mismo grupo cot_year + correlativo + letra que sí tenga PDFs.
     */
        $cotizacionFuenteId = CotizacionPdfAdjunto::query()
            ->join('cotizaciones', 'cotizaciones.id', '=', 'cotizacion_pdfs_adjuntos.cotizacion_id')
            ->where('cotizaciones.cot_year', $cotizacion->cot_year)
            ->where('cotizaciones.correlativo', $cotizacion->correlativo)
            ->where('cotizaciones.letra', $cotizacion->letra)
            ->where('cotizaciones.id', '<>', $cotizacion->id)
            ->orderByDesc('cotizaciones.version')
            ->value('cotizaciones.id');

        if ($cotizacionFuenteId) {
            return Cotizacion::find($cotizacionFuenteId) ?: $cotizacion;
        }

        return $cotizacion;
    }


    // editar



    private function cargarCotizacionParaEditar($cotizacionId)
    {
        $cotizacion = Cotizacion::findOrFail($cotizacionId);
        $this->cargarPdfsAdjuntosCotizacion($cotizacion);

        $this->modoEdicion = true;
        $this->cotizacionEditandoId = $cotizacion->id;
        $this->cotizacionGuardadaId = $cotizacion->id;

        /*
     * Número / versión actual.
     */
        $this->numeroCotizacion = $cotizacion->numero;
        $this->cotYear = $cotizacion->cot_year;
        $this->cotCorrelativo = $cotizacion->correlativo;
        $this->cotLetra = $cotizacion->letra;
        $this->cotVersion = $cotizacion->version;

        /*
     * Encabezado.
     */
        $this->tituloCotizacion = $cotizacion->titulo;
        $this->subtituloCotizacion = $cotizacion->subtitulo;

        $this->fotoPortadaActual = $cotizacion->foto_portada;
        $this->fotoPortadaCotizacion = null;

        $this->usarNumeroRequerimiento = (bool) ($cotizacion->mostrar_numero_requerimiento ?? false);

        $this->numeroRequerimiento = '';

        if ($cotizacion->id_motor) {
            $this->numeroRequerimiento = $this->obtenerNumeroRequerimientoDesdeTablero($cotizacion->id_motor) ?? '';
        }

        /*
     * Cliente.
     */
        $this->cliente_id = $cotizacion->id_cliente;

        if ($this->cliente_id) {
            $this->updatedClienteId($this->cliente_id);
        }

        /*
     * Fechas.
     */
        $this->cotDate = $cotizacion->fecha_cotizacion
            ? Carbon::parse($cotizacion->fecha_cotizacion)->format('d-m-Y')
            : Carbon::now()->format('d-m-Y');

        $this->cotValid = $cotizacion->fecha_valida_hasta
            ? Carbon::parse($cotizacion->fecha_valida_hasta)->format('d-m-Y')
            : Carbon::now()->addDays(30)->format('d-m-Y');

        /*
     * Contactos snapshot de la cotización.
     */
        $this->contactosSeleccionados = CotizacionContacto::where('cotizacion_id', $cotizacion->id)
            ->orderBy('id')
            ->pluck('contacto_id')
            ->filter()
            ->values()
            ->toArray();

        $this->actualizarContactosPreview();
        $this->cargarContactosParaChoices();

        /*
     * Motor / equipo.
     */
        $this->motor_id = $cotizacion->id_motor;
        $this->equipoNoIngresadoTaller = (bool) $cotizacion->equipo_no_ingresado_taller;

        if ($this->motor_id) {
            $motor = Motor::with([
                'cliente',
                'infoMotor',
            ])
                ->where('id_motor', $this->motor_id)
                ->first();

            if ($motor) {
                $this->osSeleccionadaLabel = $motor->fullos;
                $this->cargarMotorPreview($motor);
            }
        } else {
            $this->motorPreview = null;
            $this->osSeleccionadaLabel = $this->equipoNoIngresadoTaller
                ? 'Equipo no ha ingresado a taller, Oferta presupuestaria'
                : '';
        }

        /*
     * Respeta lo guardado en la cotización.
     * Ojo: cargarMotorPreview() genera resumen automático,
     * por eso sobrescribimos después con el snapshot guardado.
     */
        $this->usarDatosEquipo = (bool) $cotizacion->usar_datos_equipo;
        $this->resumenEquipo = $cotizacion->resumen_equipo ?? '';

        /*
     * Presentación.
     */
        $this->presentacion_id = $cotizacion->presentacion_id;
        $this->textoPresentacion = $cotizacion->texto_presentacion ?? '';

        $this->dispatchBrowserEvent('actualizar-texto-presentacion', [
            'contenido' => $this->textoPresentacion,
        ]);

        /*
     * Moneda.
     */
        $this->monedaCotizacion = $cotizacion->moneda ?? 'GTQ';
        $this->tipoCambio = $cotizacion->tipo_cambio ?: 7.80;
        // adicionales

        $this->noIncluyeItems = $cotizacion->no_incluye ?: [];

        $this->tiempoEntrega = $cotizacion->tiempo_entrega ?? '';
        $this->tiempoEntregaOtro = $cotizacion->tiempo_entrega_otro ?? '';

        $this->garantiaModo = $cotizacion->garantia_modo ?? 'general';
        $this->garantiaGeneralActiva = (bool) $cotizacion->garantia_general_activa;
        $this->garantiaGeneralTiempo = $cotizacion->garantia_general_tiempo ?? '3_meses';
        $this->garantiaElectricaTiempo = $cotizacion->garantia_electrica_tiempo ?? '3_meses';
        $this->garantiaMecanicaTiempo = $cotizacion->garantia_mecanica_tiempo ?? '30_dias';
        $this->incluirTerminosGarantias = (bool) $cotizacion->incluir_terminos_garantias;

        $this->terminosPago = $cotizacion->terminos_pago ?? '';
        $this->clienteDebeProveerOc = (bool) $cotizacion->cliente_debe_proveer_oc;

        $this->notasAdicionales = $cotizacion->notas_adicionales ?? '';

        $this->dispatchBrowserEvent('actualizar-notas-adicionales-cotizacion', [
            'contenido' => $this->notasAdicionales,
        ]);


        /*
 * Si esta cotización fue creada desde Excel,
 * debe cargarse agrupada por motor, no como tabla normal.
 */
        if ((string) $cotizacion->tipo_cotizacion === 'excel') {
            $this->modoExcel = true;
            $this->modoUnificacion = false;
            $this->modoAdicional = false;
            $this->modoDuplicado = false;

            $this->itemsCotizacion = [];

            $this->cargarGruposExcelParaEditar($cotizacion);

            $this->recalcularTotalExcel();

            $this->subtotalItems = $this->totalExcel;

            $this->cotizacionOriginalHash = $this->generarHashEstadoCotizacion();

            return;
        }

        /*

        // adicionales
        
    
                

     * Items snapshot.
     */
        $this->itemsCotizacion = $cotizacion->itemsCotizacion
            ->sortBy('orden')
            ->values()
            ->map(function ($item) {
                return [
                    'uid' => 'db_item_' . $item->id . '_' . Str::uuid(),

                    'cotizacion_item_id' => $item->id,
                    'catalogo_item_id' => $item->catalogo_item_id,
                    'tipo_item' => $item->tipo_item ?? null,

                    'nombre' => $this->limpiarTextoParaLivewire($item->nombre),
                    'descripcion' => $this->limpiarTextoParaLivewire($item->descripcion),

                    'cantidad' => (float) ($item->cantidad ?? 1),
                    'precio_unitario' => (float) ($item->precio_unitario ?? 0),
                    'precio_total' => (float) ($item->precio_total ?? 0),

                    'descuento_porcentaje' => isset($item->descuento_porcentaje)
                        ? (float) $item->descuento_porcentaje
                        : null,

                    'descuento_alcance' => $item->descuento_alcance ?? null,
                    'descuento_item_principal_uid' => null,
                ];
            })
            ->toArray();

        $this->recalcularTotalesItems();

        /*
     * Hash del estado original para saber si hubo cambios.
     */
        $this->cotizacionOriginalHash = $this->generarHashEstadoCotizacion();
    }
    private function obtenerEstadoComparableCotizacion()
    {
        return [
            'tituloCotizacion' => trim((string) $this->tituloCotizacion),
            'subtituloCotizacion' => trim((string) $this->subtituloCotizacion),

            'cliente_id' => (int) $this->cliente_id,
            'contactosSeleccionados' => collect($this->contactosSeleccionados)
                ->map(fn($id) => (int) $id)
                ->values()
                ->toArray(),

            'cotDate' => $this->cotDate,
            'cotValid' => $this->cotValid,

            'motor_id' => $this->motor_id ? (int) $this->motor_id : null,
            'equipoNoIngresadoTaller' => (bool) $this->equipoNoIngresadoTaller,

            'presentacion_id' => $this->presentacion_id ? (int) $this->presentacion_id : null,
            'textoPresentacion' => trim((string) $this->textoPresentacion),

            'usarDatosEquipo' => (bool) $this->usarDatosEquipo,
            'resumenEquipo' => trim((string) $this->resumenEquipo),

            'monedaCotizacion' => $this->monedaCotizacion,
            'tipoCambio' => (float) $this->tipoCambio,
            'noIncluyeItems' => array_values($this->noIncluyeItems),

            'tiempoEntrega' => $this->tiempoEntrega,
            'tiempoEntregaOtro' => trim((string) $this->tiempoEntregaOtro),

            'garantiaModo' => $this->garantiaModo,
            'garantiaGeneralActiva' => (bool) $this->garantiaGeneralActiva,
            'garantiaGeneralTiempo' => $this->garantiaGeneralTiempo,
            'garantiaElectricaTiempo' => $this->garantiaElectricaTiempo,
            'garantiaMecanicaTiempo' => $this->garantiaMecanicaTiempo,
            'incluirTerminosGarantias' => (bool) $this->incluirTerminosGarantias,

            'terminosPago' => $this->terminosPago,
            'clienteDebeProveerOc' => (bool) $this->clienteDebeProveerOc,

            'notasAdicionales' => trim((string) $this->notasAdicionales),

            'itemsCotizacion' => collect($this->itemsCotizacion)
                ->map(function ($item) {
                    return [
                        'catalogo_item_id' => $item['catalogo_item_id'] ?? null,
                        'tipo_item' => $item['tipo_item'] ?? null,
                        'nombre' => trim((string) ($item['nombre'] ?? '')),
                        'descripcion' => trim((string) ($item['descripcion'] ?? '')),
                        'cantidad' => (float) ($item['cantidad'] ?? 0),
                        'precio_unitario' => (float) ($item['precio_unitario'] ?? 0),
                        'precio_total' => (float) ($item['precio_total'] ?? 0),
                    ];
                })
                ->values()
                ->toArray(),
            'pdfsAntesItems' => $this->normalizarPdfsAdjuntosParaHash($this->pdfsAntesItems),
            'pdfsDespuesItems' => $this->normalizarPdfsAdjuntosParaHash($this->pdfsDespuesItems),
            'pdfsAdjuntosEliminarIds' => array_values($this->pdfsAdjuntosEliminarIds),
        ];
    }

    /* duplicar */

    private function inicializarModoDuplicado(Cotizacion $cotizacionBase)
    {
        if ((bool) $cotizacionBase->es_unificada) {
            abort(403, 'Por ahora no se permite duplicar cotizaciones unificadas.');
        }

        $cotizacionBase->load([
            'cliente.info_cliente',
            'contactosCotizacion',
            'itemsCotizacion',
        ]);

        /*
     * Estados del componente.
     */
        $this->modoDuplicado = true;
        $this->modoEdicion = false;
        $this->modoAdicional = false;
        $this->modoUnificacion = false;

        $this->cotizacionEditandoId = null;
        $this->cotizacionGuardadaId = null;
        $this->cotizacionOriginalHash = null;
        $this->cotizacionTieneCambios = false;

        $this->cotizacionDuplicadaDeId = $cotizacionBase->id;
        $this->cotizacionDuplicadaDeNumero = $cotizacionBase->numero;

        /*
     * Nuevo número de cotización.
     */
        $this->cotDate = Carbon::now()->format('d-m-Y');
        $this->cotValid = Carbon::now()->addDays(30)->format('d-m-Y');

        $this->generarNumeroCotizacionInicial();

        /*
     * Cliente.
     */
        $this->cliente_id = $cotizacionBase->id_cliente;

        if ($this->cliente_id) {
            $this->updatedClienteId($this->cliente_id);
        }

        /*
     * Encabezado.
     */
        $this->tituloCotizacion = $cotizacionBase->titulo;
        $this->subtituloCotizacion = $cotizacionBase->subtitulo;

        /*
     * Contactos.
     */
        $this->contactosSeleccionados = CotizacionContacto::where('cotizacion_id', $cotizacionBase->id)
            ->orderBy('id')
            ->pluck('contacto_id')
            ->filter()
            ->values()
            ->toArray();

        $this->actualizarContactosPreview();
        $this->cargarContactosParaChoices();

        /*
     * OS / motor:
     * NO copiamos id_motor.
     * La duplicada queda como oferta preliminar para que puedas escoger otra OS
     * o dejarla sin ingreso a taller.
     */
        $this->motor_id = null;
        $this->equipoNoIngresadoTaller = true;
        $this->motorPreview = null;
        $this->osSeleccionadaLabel = 'Equipo no ha ingresado a taller, Oferta presupuestaria';

        /*
     * Datos del equipo:
     * Copiamos el resumen porque puede servir para motores similares,
     * pero no queda amarrado a la OS original.
     */
        $this->usarDatosEquipo = (bool) $cotizacionBase->usar_datos_equipo;
        $this->resumenEquipo = $cotizacionBase->resumen_equipo ?? '';

        /*
     * Presentación.
     */
        $this->presentacion_id = $cotizacionBase->presentacion_id;
        $this->textoPresentacion = $cotizacionBase->texto_presentacion ?? '';

        $this->dispatchBrowserEvent('actualizar-texto-presentacion', [
            'contenido' => $this->textoPresentacion,
        ]);

        /*
     * Moneda y condiciones.
     */
        $this->monedaCotizacion = $cotizacionBase->moneda ?? 'GTQ';
        $this->tipoCambio = $cotizacionBase->tipo_cambio ?: 7.80;

        $this->noIncluyeItems = $cotizacionBase->no_incluye ?: [];

        $this->tiempoEntrega = $cotizacionBase->tiempo_entrega ?? '';
        $this->tiempoEntregaOtro = $cotizacionBase->tiempo_entrega_otro ?? '';

        $this->garantiaModo = $cotizacionBase->garantia_modo ?? 'general';
        $this->garantiaGeneralActiva = (bool) $cotizacionBase->garantia_general_activa;
        $this->garantiaGeneralTiempo = $cotizacionBase->garantia_general_tiempo ?? '3_meses';
        $this->garantiaElectricaTiempo = $cotizacionBase->garantia_electrica_tiempo ?? '3_meses';
        $this->garantiaMecanicaTiempo = $cotizacionBase->garantia_mecanica_tiempo ?? '30_dias';
        $this->incluirTerminosGarantias = (bool) $cotizacionBase->incluir_terminos_garantias;

        $this->terminosPago = $cotizacionBase->terminos_pago ?? '';
        $this->clienteDebeProveerOc = (bool) $cotizacionBase->cliente_debe_proveer_oc;

        $this->notasAdicionales = $cotizacionBase->notas_adicionales ?? '';

        $this->dispatchBrowserEvent('actualizar-notas-adicionales-cotizacion', [
            'contenido' => $this->notasAdicionales,
        ]);

        /*
     * Foto de portada:
     * NO se copia.
     */
        $this->fotoPortadaCotizacion = null;
        $this->fotoPortadaActual = null;
        $this->pdfUsarPortada = false;

        /*
     * Items.
     */
        $this->itemsCotizacion = CotizacionItem::where('cotizacion_id', $cotizacionBase->id)
            ->orderBy('orden')
            ->get()
            ->map(function ($item) {
                $precioTotal = (float) $item->precio_total;

                $tipoItem = $item->getAttribute('tipo_item');

                if (! $tipoItem) {
                    $tipoItem = $precioTotal < 0 ? 'descuento' : 'general';
                }

                return [
                    'uid' => uniqid('item_', true),
                    'catalogo_item_id' => $item->catalogo_item_id,
                    'tipo_item' => $tipoItem,

                    'nombre' => $item->nombre,
                    'descripcion' => $item->descripcion,

                    'cantidad' => (float) $item->cantidad,
                    'precio_unitario' => (float) $item->precio_unitario,
                    'precio_total' => $precioTotal,

                    'descuento_porcentaje' => $item->getAttribute('descuento_porcentaje'),
                    'descuento_alcance' => $item->getAttribute('descuento_alcance'),
                    'descuento_item_principal_uid' => $item->getAttribute('descuento_item_principal_uid'),
                ];
            })
            ->values()
            ->toArray();

        $this->recalcularTotalesItems();

        /*
     * PDFs adjuntos:
     * Sí se copian como referencia inicial.
     * Al guardar la nueva cotización, deben copiarse físicamente a la carpeta
     * de la nueva cotización si ya tienes aplicado el Storage::copy().
     */
        $this->pdfsAntesItems = [];
        $this->pdfsDespuesItems = [];
        $this->pdfsAntesItemsUpload = [];
        $this->pdfsDespuesItemsUpload = [];
        $this->pdfsAdjuntosEliminarIds = [];

        $this->cargarPdfsAdjuntosCotizacion($cotizacionBase);
    }

    private function normalizarPdfsAdjuntosParaHash(array $items): array
    {
        return collect($items)
            ->map(function ($pdf) {
                return [
                    'id' => $pdf['id'] ?? null,
                    'uuid' => $pdf['uuid'] ?? null,
                    'nombre_original' => $pdf['nombre_original'] ?? '',
                    'path' => $pdf['path'] ?? '',
                    'orden' => (int) ($pdf['orden'] ?? 0),
                    'nuevo' => (bool) ($pdf['nuevo'] ?? false),
                ];
            })
            ->values()
            ->toArray();
    }
    private function generarHashEstadoCotizacion()
    {
        return md5(json_encode($this->obtenerEstadoComparableCotizacion()));
    }

    private function hayCambiosEnCotizacion()
    {
        if (!$this->modoEdicion) {
            return true;
        }

        return $this->generarHashEstadoCotizacion() !== $this->cotizacionOriginalHash;
    }

    // que NO INCLUYE
    public function abrirModalNoIncluye()
    {
        $this->dispatchBrowserEvent('abrir-modal-no-incluye-cotizacion');
    }

    public function agregarNoIncluyeRapido($index)
    {
        if (!isset($this->noIncluyeOpcionesRapidas[$index])) {
            return;
        }

        $this->agregarNoIncluye($this->noIncluyeOpcionesRapidas[$index]);
    }

    public function agregarNoIncluyePersonalizado()
    {
        $this->validate([
            'noIncluyePersonalizado' => 'required|string|max:255',
        ], [
            'noIncluyePersonalizado.required' => 'Ingrese una descripción.',
        ]);

        $this->agregarNoIncluye($this->noIncluyePersonalizado);

        $this->noIncluyePersonalizado = '';
    }

    private function agregarNoIncluye($texto)
    {
        $texto = trim((string) $texto);

        if ($texto === '') {
            return;
        }

        if (stripos($texto, 'No incluye') !== 0) {
            $texto = 'No incluye ' . lcfirst($texto);
        }

        if (!in_array($texto, $this->noIncluyeItems)) {
            $this->noIncluyeItems[] = $texto;
        }
    }

    public function eliminarNoIncluye($index)
    {
        if (!isset($this->noIncluyeItems[$index])) {
            return;
        }

        unset($this->noIncluyeItems[$index]);

        $this->noIncluyeItems = array_values($this->noIncluyeItems);
    }

    // garantía
    public function abrirModalGarantiaCotizacion()
    {
        $this->dispatchBrowserEvent('abrir-modal-garantia-cotizacion');
    }
    public function labelTiempoEntrega()
    {
        $opciones = [
            'inmediata' => 'Disponibilidad inmediata',
            '24_horas' => '24 horas o menos',
            '1_2_dias' => '1-2 días hábiles',
            '2_3_dias' => '2-3 días hábiles',
            '3_4_dias' => '3-4 días hábiles',
            '4_5_dias' => '4-5 días hábiles',
            '5_7_dias' => '5-7 días hábiles',
            'a_convenir' => 'A convenir con el cliente',
            'otro' => $this->tiempoEntregaOtro,
        ];

        return $opciones[$this->tiempoEntrega] ?? 'No especificado';
    }

    public function labelGarantiaTiempo($value)
    {
        $opciones = [
            '30_dias' => '30 días',
            '3_meses' => '3 meses',
            '6_meses' => '6 meses',
            '1_anio' => '1 año',
            '2_anios' => '2 años',
        ];

        return $opciones[$value] ?? 'No especificado';
    }

    public function labelTerminosPago()
    {
        $opciones = [
            '100_anticipado' => '100% Anticipado',
            '50_50_entrega' => '50% Anticipo, 50% contra entrega',
            '50_50_30_credito' => '50% Anticipo, 50% 30 días crédito',
            '100_contra_entrega' => '100% Contra entrega',
            '15_credito' => '15 días crédito',
            '30_credito' => '30 días crédito',
            '45_credito' => '45 días crédito',
            '60_credito' => '60 días crédito',
        ];

        return $opciones[$this->terminosPago] ?? 'No especificado';
    }


    // Unificacion de cotizaciones
    private function inicializarModoUnificacion($idsParam)
    {
        $ids = collect(explode(',', (string) $idsParam))
            ->map(fn($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($ids->count() < 2) {
            abort(404);
        }

        $cotizaciones = Cotizacion::with([
            'cliente',
            'motor.infoMotor',
            'contactosCotizacion',
            'itemsCotizacion',
        ])
            ->whereIn('id', $ids)
            ->get()
            ->sortBy(function ($cotizacion) use ($ids) {
                return array_search($cotizacion->id, $ids->toArray());
            })
            ->values();

        if ($cotizaciones->count() !== $ids->count()) {
            abort(404);
        }

        $clientes = $cotizaciones
            ->pluck('id_cliente')
            ->filter()
            ->unique()
            ->values();

        if ($clientes->count() !== 1) {
            abort(403, 'Las cotizaciones seleccionadas no pertenecen al mismo cliente.');
        }
        $monedas = $cotizaciones
            ->pluck('moneda')
            ->filter()
            ->unique()
            ->values();

        if ($monedas->count() > 1) {
            $this->dispatchBrowserEvent('swal-error', [
                'title' => 'Monedas diferentes',
                'text' => 'Solo puede unificar cotizaciones con la misma moneda.',
            ]);

            return;
        }

        $this->modoUnificacion = true;
        $this->modoEdicion = false;

        $this->cotizacionesOrigenIds = $ids->toArray();

        $this->cotizacionesOrigenResumen = $cotizaciones
            ->map(function ($cotizacion) {
                return [
                    'id' => $cotizacion->id,
                    'numero' => $cotizacion->numero,
                    'os' => $this->labelOsCotizacionOrigen($cotizacion),
                    'equipo' => $this->labelEquipoCotizacionOrigen($cotizacion),
                    'potencia' => $this->labelPotenciaCotizacionOrigen($cotizacion),
                    'subtotal' => (float) $cotizacion->total,
                ];
            })
            ->toArray();

        /*
     * Número nuevo para la cotización unificada.
     */
        $this->cotDate = Carbon::now()->format('d-m-Y');
        $this->cotValid = Carbon::now()->addDays(30)->format('d-m-Y');
        $this->generarNumeroCotizacionInicial();

        /*
     * Cliente.
     */
        $this->cliente_id = $clientes->first();

        if ($this->cliente_id) {
            $this->updatedClienteId($this->cliente_id);
        }

        /*
     * Título default: título de la primera cotización.
     */
        $primera = $cotizaciones->first();

        $this->tituloCotizacion = $primera->titulo ?: 'Cotización unificada';

        /*
     * Subtítulo default: resumen de OS/equipos.
     */
        $this->subtituloCotizacion = $this->generarSubtituloUnificado($cotizaciones);



        $this->presentacion_id = $primera->presentacion_id;

        if ($this->presentacion_id) {
            $this->updatedPresentacionId($this->presentacion_id);
        }
        /*

        
     * Merge de contactos sin repetir.
     * Por ahora usamos contacto_id. Luego podemos hacerlo más robusto por email.
     */
        $this->contactosSeleccionados = $cotizaciones
            ->flatMap(function ($cotizacion) {
                return $cotizacion->contactosCotizacion
                    ? $cotizacion->contactosCotizacion->pluck('contacto_id')
                    : collect();
            })
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $this->actualizarContactosPreview();
        $this->cargarContactosParaChoices();

        $this->cargarCondicionesUnificadas($cotizaciones);
        $this->cargarGruposUnificados($cotizaciones);
    }
    private function labelOsCotizacionOrigen($cotizacion)
    {
        if (!$cotizacion->motor) {
            return 'Sin OS';
        }

        if (!empty($cotizacion->motor->fullos)) {
            return $cotizacion->motor->fullos;
        }

        return trim(($cotizacion->motor->year ?? '') . '-' . ($cotizacion->motor->os ?? ''), '-');
    }

    private function labelEquipoCotizacionOrigen($cotizacion)
    {
        if (!$cotizacion->motor) {
            return 'Equipo no ingresado a taller';
        }

        return optional($cotizacion->motor->infoMotor)->nombre_equipo
            ?: ($cotizacion->motor->equipo ?? 'Equipo');
    }

    private function labelPotenciaCotizacionOrigen($cotizacion)
    {
        if (!$cotizacion->motor) {
            return '';
        }

        return $cotizacion->motor->potencia
            ?? optional($cotizacion->motor->infoMotor)->potencia
            ?? $cotizacion->motor->hp
            ?? $cotizacion->motor->kw
            ?? '';
    }

    private function generarSubtituloUnificado($cotizaciones)
    {
        $partes = $cotizaciones
            ->map(function ($cotizacion) {
                $os = $this->labelOsCotizacionOrigen($cotizacion);
                $equipo = $this->labelEquipoCotizacionOrigen($cotizacion);
                $potencia = $this->labelPotenciaCotizacionOrigen($cotizacion);

                $texto = $os;

                if ($equipo) {
                    $texto .= ' ' . $equipo;
                }

                if ($potencia) {
                    $texto .= ' de ' . $potencia;
                }

                return $texto;
            })
            ->filter()
            ->values();

        return 'Intervención de ' . $partes->implode(', ');
    }
    private function limpiarTextoParaLivewire($value)
    {
        if ($value === null) {
            return null;
        }

        $value = (string) $value;

        if (!mb_check_encoding($value, 'UTF-8')) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8, ISO-8859-1, Windows-1252');
        }

        return preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $value);
    }
    private function cargarGruposUnificados($cotizaciones)
    {
        $this->gruposUnificados = $cotizaciones
            ->map(function ($cotizacion) {
                $items = $cotizacion->itemsCotizacion
                    ->map(function ($item) {
                        return [
                            'uid' => uniqid('item_unificado_', true),

                            'cotizacion_item_id' => $item->id,
                            'catalogo_item_id' => $item->catalogo_item_id,

                            'tipo_item' => $item->precio_total < 0 ? 'descuento' : ($item->tipo_item ?? 'general'),

                            'nombre' => $item->nombre,
                            'descripcion' => $item->descripcion,

                            'cantidad' => (float) $item->cantidad,
                            'precio_unitario' => (float) $item->precio_unitario,
                            'precio_total' => (float) $item->precio_total,

                            'orden' => (int) $item->orden,
                        ];
                    })
                    ->values()
                    ->toArray();

                $subtotal = collect($items)->sum('precio_total');

                return [
                    'cotizacion_id' => $cotizacion->id,
                    'numero' => $cotizacion->numero,

                    'os' => $this->labelOsCotizacionOrigen($cotizacion),
                    'equipo' => $this->labelEquipoCotizacionOrigen($cotizacion),
                    'potencia' => $this->labelPotenciaCotizacionOrigen($cotizacion),

                    'moneda' => $cotizacion->moneda ?? 'GTQ',
                    'tipo_cambio' => $cotizacion->tipo_cambio,

                    'items' => $items,
                    'subtotal' => $subtotal,
                ];
            })
            ->values()
            ->toArray();

        $this->recalcularTotalUnificado();
    }
    public function recalcularItemUnificado($grupoIndex, $itemIndex)
    {
        if (!isset($this->gruposUnificados[$grupoIndex]['items'][$itemIndex])) {
            return;
        }

        $cantidad = (float) ($this->gruposUnificados[$grupoIndex]['items'][$itemIndex]['cantidad'] ?? 0);
        $precioUnitario = (float) ($this->gruposUnificados[$grupoIndex]['items'][$itemIndex]['precio_unitario'] ?? 0);

        $this->gruposUnificados[$grupoIndex]['items'][$itemIndex]['precio_total'] = round($cantidad * $precioUnitario, 2);

        $this->recalcularSubtotalGrupoUnificado($grupoIndex);
        $this->recalcularTotalUnificado();
    }

    private function recalcularSubtotalGrupoUnificado($grupoIndex)
    {
        if (!isset($this->gruposUnificados[$grupoIndex])) {
            return;
        }

        $this->gruposUnificados[$grupoIndex]['subtotal'] = collect($this->gruposUnificados[$grupoIndex]['items'])
            ->sum(function ($item) {
                return (float) ($item['precio_total'] ?? 0);
            });
    }

    public function recalcularTotalUnificado()
    {
        $this->totalUnificado = collect($this->gruposUnificados)
            ->sum(function ($grupo) {
                return (float) ($grupo['subtotal'] ?? 0);
            });

        $this->subtotalItems = round($this->totalUnificado, 2);
    }
    public function agregarItemUnificado($grupoIndex)
    {
        if (!isset($this->gruposUnificados[$grupoIndex])) {
            return;
        }

        $this->gruposUnificados[$grupoIndex]['items'][] = [
            'uid' => uniqid('item_unificado_', true),

            'cotizacion_item_id' => null,
            'catalogo_item_id' => null,
            'tipo_item' => 'general',

            'nombre' => 'Nuevo ítem',
            'descripcion' => '',
            'cantidad' => 1,
            'precio_unitario' => 0,
            'precio_total' => 0,

            'orden' => count($this->gruposUnificados[$grupoIndex]['items']) + 1,
        ];

        $this->recalcularSubtotalGrupoUnificado($grupoIndex);
        $this->recalcularTotalUnificado();
    }

    public function eliminarItemUnificado($grupoIndex, $itemIndex)
    {
        if (!isset($this->gruposUnificados[$grupoIndex]['items'][$itemIndex])) {
            return;
        }

        unset($this->gruposUnificados[$grupoIndex]['items'][$itemIndex]);

        $this->gruposUnificados[$grupoIndex]['items'] = array_values($this->gruposUnificados[$grupoIndex]['items']);

        foreach ($this->gruposUnificados[$grupoIndex]['items'] as $index => &$item) {
            $item['orden'] = $index + 1;
        }

        $this->recalcularSubtotalGrupoUnificado($grupoIndex);
        $this->recalcularTotalUnificado();
    }
    private function cargarCondicionesUnificadas($cotizaciones)
    {
        $this->mergeNoIncluyeUnificado($cotizaciones);
        $this->mergeTiempoEntregaUnificado($cotizaciones);
        $this->mergeGarantiaUnificada($cotizaciones);
        $this->mergeTerminosPagoUnificado($cotizaciones);
        $this->mergeNotasAdicionalesUnificadas($cotizaciones);
    }
    private function mergeNoIncluyeUnificado($cotizaciones)
    {
        $items = [];

        foreach ($cotizaciones as $cotizacion) {
            $noIncluye = $this->normalizarNoIncluyeDesdeDb($cotizacion->no_incluye);

            foreach ($noIncluye as $item) {
                $texto = trim((string) $item);

                if ($texto === '') {
                    continue;
                }

                if (stripos($texto, 'No incluye') !== 0) {
                    $texto = 'No incluye ' . lcfirst($texto);
                }

                $key = mb_strtolower($texto);

                $items[$key] = $texto;
            }
        }

        $this->noIncluyeItems = array_values($items);
    }
    private function normalizarNoIncluyeDesdeDb($value): array
    {
        if (is_array($value)) {
            return array_values($value);
        }

        if (is_string($value) && trim($value) !== '') {
            $decoded = json_decode($value, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return array_values($decoded);
            }

            return [$value];
        }

        return [];
    }
    private function mergeTiempoEntregaUnificado($cotizaciones)
    {
        $ranking = [
            'inmediata' => 1,
            '24_horas' => 2,
            '1_2_dias' => 3,
            '2_3_dias' => 4,
            '3_4_dias' => 5,
            '4_5_dias' => 6,
            '5_7_dias' => 7,
            'a_convenir' => 8,
            'otro' => 9,
        ];

        $seleccionado = '';
        $maxRank = 0;
        $otroTexto = '';

        foreach ($cotizaciones as $cotizacion) {
            $valor = $cotizacion->tiempo_entrega;

            if (!$valor) {
                continue;
            }

            $rank = $ranking[$valor] ?? 0;

            if ($rank > $maxRank) {
                $maxRank = $rank;
                $seleccionado = $valor;
                $otroTexto = $cotizacion->tiempo_entrega_otro ?? '';
            }
        }

        $this->tiempoEntrega = $seleccionado;
        $this->tiempoEntregaOtro = $seleccionado === 'otro' ? $otroTexto : '';
    }
    private function mergeTerminosPagoUnificado($cotizaciones)
    {
        $ranking = [
            '100_anticipado' => 1,
            '50_50_entrega' => 2,
            '50_50_30_credito' => 3,
            '100_contra_entrega' => 4,
            '15_credito' => 5,
            '30_credito' => 6,
            '45_credito' => 7,
            '60_credito' => 8,
        ];

        $seleccionado = '';
        $maxRank = 0;

        foreach ($cotizaciones as $cotizacion) {
            $valor = $cotizacion->terminos_pago;

            if (!$valor) {
                continue;
            }

            $rank = $ranking[$valor] ?? 0;

            if ($rank > $maxRank) {
                $maxRank = $rank;
                $seleccionado = $valor;
            }
        }

        $this->terminosPago = $seleccionado;

        /*
     * Si cualquiera requiere OC, la unificada también la requiere.
     */
        $this->clienteDebeProveerOc = $cotizaciones
            ->contains(function ($cotizacion) {
                return (bool) $cotizacion->cliente_debe_proveer_oc;
            });
    }
    private function mergeGarantiaUnificada($cotizaciones)
    {
        $ranking = [
            '30_dias' => 1,
            '3_meses' => 2,
            '6_meses' => 3,
            '1_anio' => 4,
            '2_anios' => 5,
        ];

        $hayGarantiaSeparada = $cotizaciones->contains(function ($cotizacion) {
            return $cotizacion->garantia_modo === 'separada';
        });

        $incluirTerminos = $cotizaciones->contains(function ($cotizacion) {
            return (bool) $cotizacion->incluir_terminos_garantias;
        });

        $this->incluirTerminosGarantias = $incluirTerminos;

        if ($hayGarantiaSeparada) {
            $this->garantiaModo = 'separada';

            $this->garantiaElectricaTiempo = $this->maxGarantiaTiempo(
                $cotizaciones,
                $ranking,
                'electrica'
            );

            $this->garantiaMecanicaTiempo = $this->maxGarantiaTiempo(
                $cotizaciones,
                $ranking,
                'mecanica'
            );

            return;
        }

        $this->garantiaModo = 'general';

        $hayGarantiaActiva = $cotizaciones->contains(function ($cotizacion) {
            return (bool) $cotizacion->garantia_general_activa;
        });

        $this->garantiaGeneralActiva = $hayGarantiaActiva;

        $this->garantiaGeneralTiempo = $this->maxGarantiaTiempo(
            $cotizaciones,
            $ranking,
            'general'
        );
    }
    private function maxGarantiaTiempo($cotizaciones, array $ranking, string $tipo)
    {
        $seleccionado = '30_dias';
        $maxRank = 0;

        foreach ($cotizaciones as $cotizacion) {
            if ($tipo === 'general') {
                $valor = $cotizacion->garantia_general_tiempo;
            } elseif ($tipo === 'electrica') {
                $valor = $cotizacion->garantia_modo === 'separada'
                    ? $cotizacion->garantia_electrica_tiempo
                    : $cotizacion->garantia_general_tiempo;
            } else {
                $valor = $cotizacion->garantia_modo === 'separada'
                    ? $cotizacion->garantia_mecanica_tiempo
                    : $cotizacion->garantia_general_tiempo;
            }

            if (!$valor) {
                continue;
            }

            $rank = $ranking[$valor] ?? 0;

            if ($rank > $maxRank) {
                $maxRank = $rank;
                $seleccionado = $valor;
            }
        }

        return $seleccionado;
    }
    private function mergeNotasAdicionalesUnificadas($cotizaciones)
    {
        $html = '';

        foreach ($cotizaciones as $cotizacion) {
            $notas = trim((string) $cotizacion->notas_adicionales);

            if ($notas === '') {
                continue;
            }

            $os = $this->labelOsCotizacionOrigen($cotizacion);

            $html .= '<p><strong>Notas complementarias ' . e($os) . '</strong></p>';
            $html .= $notas;
            $html .= '<br>';
        }

        $this->notasAdicionales = $html;

        $this->dispatchBrowserEvent('actualizar-notas-adicionales-cotizacion', [
            'contenido' => $this->notasAdicionales,
        ]);
    }
    private function guardarCotizacionUnificada($generarPdf = false)
    {
        $this->recalcularTotalUnificado();

        $cotizacion = DB::transaction(function () {
            $numeroData = $this->prepararNumeroCotizacionParaGuardar();

            $fechaCotizacion = Carbon::createFromFormat('d-m-Y', $this->cotDate)->format('Y-m-d');
            $fechaValidaHasta = Carbon::createFromFormat('d-m-Y', $this->cotValid)->format('Y-m-d');
            $fotoPortadaPath = $this->fotoPortadaActual;

            if ($this->fotoPortadaCotizacion) {
                $fotoPortadaPath = $this->fotoPortadaCotizacion->store('cotizaciones/portadas', 'public');
            }

            $cotizacion = Cotizacion::create([
                'numero' => $numeroData['numero'],
                'titulo' => $this->tituloCotizacion,
                'subtitulo' => $this->subtituloCotizacion,

                'cot_year' => $numeroData['year'],
                'correlativo' => $numeroData['correlativo'],
                'letra' => $numeroData['letra'],
                'version' => $numeroData['version'],

                'id_cliente' => $this->cliente_id,

                /*
             * Una unificada puede tener varios motores.
             * Por eso dejamos id_motor en null.
             */
                'id_motor' => null,
                'equipo_no_ingresado_taller' => 0,

                'fecha_cotizacion' => $fechaCotizacion,
                'fecha_valida_hasta' => $fechaValidaHasta,

                'presentacion_id' => $this->presentacion_id,
                'texto_presentacion' => $this->textoPresentacion,

                'usar_datos_equipo' => 0,
                'resumen_equipo' => null,

                'moneda' => $this->monedaCotizacion,
                'tipo_cambio' => $this->monedaCotizacion === 'GTQ_USD'
                    ? $this->tipoCambio
                    : null,

                'subtotal' => $this->totalUnificado,
                'descuento' => 0,
                'total' => $this->totalUnificado,

                'no_incluye' => $this->noIncluyeItems,

                'tiempo_entrega' => $this->tiempoEntrega,
                'tiempo_entrega_otro' => $this->tiempoEntrega === 'otro'
                    ? $this->tiempoEntregaOtro
                    : null,

                'garantia_modo' => $this->garantiaModo,
                'garantia_general_activa' => $this->garantiaGeneralActiva ? 1 : 0,
                'garantia_general_tiempo' => $this->garantiaGeneralTiempo,
                'garantia_electrica_tiempo' => $this->garantiaElectricaTiempo,
                'garantia_mecanica_tiempo' => $this->garantiaMecanicaTiempo,
                'incluir_terminos_garantias' => $this->incluirTerminosGarantias ? 1 : 0,

                'terminos_pago' => $this->terminosPago,
                'cliente_debe_proveer_oc' => $this->clienteDebeProveerOc ? 1 : 0,

                'notas_adicionales' => $this->notasAdicionales,
                'foto_portada' => $fotoPortadaPath,

                'estado' => 'borrador',
                'tipo_cotizacion' => 'unificada',
                'es_unificada' => 1,

                'creado_por' => auth()->id(),
            ]);


            /*
         * Contactos:
         * reutiliza el mismo método/bloque que ya usas para guardar contactos
         * en una cotización normal.
         */
            $this->guardarContactosCotizacionSnapshot($cotizacion);

            /*
         * Detalles e ítems agrupados.
         */
            foreach ($this->gruposUnificados as $grupoIndex => $grupo) {
                $detalle = CotizacionUnificadaDetalle::create([
                    'cotizacion_unificada_id' => $cotizacion->id,
                    'cotizacion_origen_id' => $grupo['cotizacion_id'],
                    'orden' => $grupoIndex + 1,

                    'os_label' => $grupo['os'] ?? null,
                    'equipo_label' => $grupo['equipo'] ?? null,
                    'potencia_label' => $grupo['potencia'] ?? null,

                    'subtotal' => (float) ($grupo['subtotal'] ?? 0),
                ]);

                foreach (($grupo['items'] ?? []) as $itemIndex => $item) {
                    CotizacionItem::create([
                        'cotizacion_id' => $cotizacion->id,

                        'cotizacion_unificada_detalle_id' => $detalle->id,
                        'cotizacion_origen_item_id' => $item['cotizacion_item_id'] ?? null,

                        'catalogo_item_id' => $item['catalogo_item_id'] ?? null,
                        'tipo_item' => $item['tipo_item'] ?? 'general',

                        'nombre' => $item['nombre'],
                        'descripcion' => $item['descripcion'] ?? null,

                        'cantidad' => (float) ($item['cantidad'] ?? 0),
                        'precio_unitario' => (float) ($item['precio_unitario'] ?? 0),
                        'precio_total' => (float) ($item['precio_total'] ?? 0),

                        'orden' => $itemIndex + 1,
                    ]);
                }
            }

            $this->guardarPdfsAdjuntosCotizacion($cotizacion);
            return $cotizacion;
        });

        $this->cotizacionGuardadaId = $cotizacion->id;

        session()->flash('success', 'Cotización unificada guardada correctamente.');

        if ($generarPdf) {
            $urlPdf = route('admin.cotizaciones.downloadPdf', [
                'cotizacion' => $cotizacion->id,
                'portada' => $this->pdfUsarPortada ? 1 : 0,
                'carta' => $this->pdfUsarCartaPresentacion ? 1 : 0,
            ]);

            $this->dispatchBrowserEvent('cotizacion-pdf-listo', [
                'url' => $urlPdf,
            ]);

            return;
        }

        return redirect()->route('admin.cotizaciones.index');
    }
    private function guardarContactosCotizacionSnapshot($cotizacion)
    {
        $contactos = Contacto::whereIn('id', $this->contactosSeleccionados)
            ->get()
            ->keyBy('id');

        foreach ($this->contactosSeleccionados as $contactoId) {
            $contacto = $contactos->get($contactoId);

            if (!$contacto) {
                continue;
            }

            CotizacionContacto::create([
                'cotizacion_id' => $cotizacion->id,
                'contacto_id' => $contacto->id,
                'nombre' => $contacto->contacto,
                'puesto' => $contacto->puesto,
                'telefono' => $contacto->telefono,
                'email' => $contacto->email,
            ]);
        }
    }

    /*
    * Cotizacion adicional
    */
    private function inicializarModoAdicional(Cotizacion $cotizacionBase)
    {
        if ((bool) $cotizacionBase->es_unificada) {
            $this->inicializarModoAdicionalUnificada($cotizacionBase);
            return;
        }
        $cotizacionBase->load([
            'cliente.info_cliente',
            'motor.infoMotor',
            'motor.fotos',
            'contactosCotizacion',
        ]);

        $this->modoAdicional = true;
        $this->modoEdicion = false;
        $this->modoUnificacion = false;

        $this->cotizacionEditandoId = null;
        $this->cotizacionGuardadaId = null;

        $this->cotizacionBaseAdicionalId = $cotizacionBase->id;
        $this->cotizacionBaseAdicionalNumero = $cotizacionBase->numero;

        /*
     * Fechas nuevas.
     */
        $this->cotDate = Carbon::now()->format('d-m-Y');
        $this->cotValid = Carbon::now()->addDays(30)->format('d-m-Y');

        /*
     * Número preview: mismo año/correlativo, siguiente letra, V1.
     */
        $this->numeroAdicionalPreview = $this->generarNumeroAdicionalPreview($cotizacionBase);
        $this->numeroCotizacion = $this->numeroAdicionalPreview;

        /*
     * Cliente.
     */
        $this->cliente_id = $cotizacionBase->id_cliente;

        if ($this->cliente_id) {
            $this->updatedClienteId($this->cliente_id);
        }

        /*
     * Contactos: copiar snapshot de contactos de la cotización base.
     */
        $this->contactosSeleccionados = $cotizacionBase->contactosCotizacion
            ? $cotizacionBase->contactosCotizacion->pluck('contacto_id')->filter()->unique()->values()->toArray()
            : [];

        $this->actualizarContactosPreview();
        $this->cargarContactosParaChoices();

        /*
     * Motor / OS.
     */
        $this->motor_id = $cotizacionBase->id_motor;

        if ($this->motor_id) {
            /*
         * Si tienes un método específico para seleccionar motor, úsalo.
         * Por ejemplo: seleccionarMotor($id), cargarMotor($id), cargarMotorSeleccionado($id).
         * Si no, dejamos el id_motor y cargamos preview de forma básica más abajo.
         */
            if (method_exists($this, 'seleccionarMotor')) {
                $this->seleccionarMotor($this->motor_id);
            } elseif (method_exists($this, 'cargarMotorSeleccionado')) {
                $this->cargarMotorSeleccionado($this->motor_id);
            }
        }

        /*
     * Título y subtítulo.
     */
        $this->tituloCotizacion = 'Cotización Adicional';
        $this->subtituloCotizacion = $cotizacionBase->subtitulo;

        /*
     * Intentar usar plantilla de presentación "cotizacion_adicional".
     */
        $presentacionAdicional = \App\Models\CotizacionTextoPresentacion::where('slug', 'cotizacion_adicional')
            ->where('activo', 1)
            ->first();

        if ($presentacionAdicional) {
            $this->presentacion_id = $presentacionAdicional->id;
            $this->updatedPresentacionId($this->presentacion_id);
        } else {
            $this->presentacion_id = $cotizacionBase->presentacion_id;
            $this->textoPresentacion = $cotizacionBase->texto_presentacion;
        }

        /*
     * Moneda.
     */
        $this->monedaCotizacion = $cotizacionBase->moneda ?? 'GTQ';
        $this->tipoCambio = $cotizacionBase->tipo_cambio;

        /*
     * Datos de equipo.
     */
        $this->usarDatosEquipo = (bool) $cotizacionBase->usar_datos_equipo;
        $this->resumenEquipo = $cotizacionBase->resumen_equipo;

        /*
     * Condiciones comerciales iguales a la original.
     */
        $this->noIncluyeItems = $this->normalizarNoIncluyeDesdeDb($cotizacionBase->no_incluye);

        $this->tiempoEntrega = $cotizacionBase->tiempo_entrega ?? '';
        $this->tiempoEntregaOtro = $cotizacionBase->tiempo_entrega_otro ?? '';

        $this->garantiaModo = $cotizacionBase->garantia_modo ?? 'general';
        $this->garantiaGeneralActiva = (bool) $cotizacionBase->garantia_general_activa;
        $this->garantiaGeneralTiempo = $cotizacionBase->garantia_general_tiempo ?? '3_meses';
        $this->garantiaElectricaTiempo = $cotizacionBase->garantia_electrica_tiempo ?? '3_meses';
        $this->garantiaMecanicaTiempo = $cotizacionBase->garantia_mecanica_tiempo ?? '30_dias';
        $this->incluirTerminosGarantias = (bool) $cotizacionBase->incluir_terminos_garantias;

        $this->terminosPago = $cotizacionBase->terminos_pago ?? '';
        $this->clienteDebeProveerOc = (bool) $cotizacionBase->cliente_debe_proveer_oc;

        /*
     * Nota automática.
     */
        $this->notasAdicionales = '<p><strong>Cotización con trabajos y repuestos adicionales no cotizados previamente en la cotización No: '
            . e($cotizacionBase->numero)
            . '.</strong></p>';

        $this->dispatchBrowserEvent('actualizar-notas-adicionales-cotizacion', [
            'contenido' => $this->notasAdicionales,
        ]);

        /*
     * Ítems vacíos.
     */
        $this->itemsCotizacion = [];
        $this->subtotalItems = 0;

        /*
     * No debe tomar hash de edición.
     */
        $this->cotizacionOriginalHash = null;
    }
    private function generarNumeroAdicionalPreview(Cotizacion $cotizacionBase)
    {
        $letra = $this->siguienteLetraCotizacion($cotizacionBase);

        return $this->formatearNumeroCotizacion(
            $cotizacionBase->cot_year,
            $cotizacionBase->correlativo,
            $letra,
            1
        );
    }

    private function prepararNumeroCotizacionAdicionalParaGuardar()
    {
        $cotizacionBase = Cotizacion::findOrFail($this->cotizacionBaseAdicionalId);

        $letra = $this->siguienteLetraCotizacion($cotizacionBase);

        $numero = $this->formatearNumeroCotizacion(
            $cotizacionBase->cot_year,
            $cotizacionBase->correlativo,
            $letra,
            1
        );

        $this->numeroCotizacion = $numero;
        $this->numeroAdicionalPreview = $numero;

        return [
            'numero' => $numero,
            'year' => $cotizacionBase->cot_year,
            'correlativo' => $cotizacionBase->correlativo,
            'letra' => $letra,
            'version' => 1,
        ];
    }

    private function siguienteLetraCotizacion(Cotizacion $cotizacionBase)
    {
        $letras = Cotizacion::where('cot_year', $cotizacionBase->cot_year)
            ->where('correlativo', $cotizacionBase->correlativo)
            ->pluck('letra')
            ->filter()
            ->map(fn($letra) => strtoupper(trim($letra)))
            ->unique()
            ->values();

        if ($letras->isEmpty()) {
            return 'B';
        }

        $maxAscii = $letras
            ->map(fn($letra) => ord(substr($letra, 0, 1)))
            ->max();

        $siguienteAscii = max($maxAscii + 1, ord('B'));

        return chr($siguienteAscii);
    }

    private function formatearNumeroCotizacion($year, $correlativo, $letra, $version)
    {
        $year2 = substr((string) $year, -2);
        $correlativo4 = str_pad((int) $correlativo, 4, '0', STR_PAD_LEFT);

        return 'COT' . $year2 . '-' . $correlativo4 . '-' . strtoupper($letra) . '-V' . (int) $version;
    }
    public function eliminarFotoPortadaCotizacion()
    {
        if ($this->fotoPortadaActual && Storage::disk('public')->exists($this->fotoPortadaActual)) {
            Storage::disk('public')->delete($this->fotoPortadaActual);
        }

        $this->fotoPortadaActual = null;
        $this->fotoPortadaCotizacion = null;
    }
    public function updatedPdfsAntesItemsUpload()
    {
        if ($this->procesandoPdfsAdjuntos) {
            return;
        }

        $this->procesarUploadsPdfsCotizacion('antes_items');
    }

    public function updatedPdfsDespuesItemsUpload()
    {
        if ($this->procesandoPdfsAdjuntos) {
            return;
        }

        $this->procesarUploadsPdfsCotizacion('despues_items');
    }

    private function procesarUploadsPdfsCotizacion($seccion)
    {
        if ($this->procesandoPdfsAdjuntos) {
            return;
        }

        $this->procesandoPdfsAdjuntos = true;

        $uploadProperty = $seccion === 'antes_items'
            ? 'pdfsAntesItemsUpload'
            : 'pdfsDespuesItemsUpload';

        $listProperty = $seccion === 'antes_items'
            ? 'pdfsAntesItems'
            : 'pdfsDespuesItems';

        try {
            $files = $this->{$uploadProperty};

            if (empty($files)) {
                return;
            }

            if (!is_array($files)) {
                $files = [$files];
            }

            $this->validate([
                $uploadProperty . '.*' => 'file|mimes:pdf|max:25600',
            ], [
                $uploadProperty . '.*.mimes' => 'Solo puede cargar archivos PDF.',
                $uploadProperty . '.*.max' => 'Cada PDF no debe superar 25 MB.',
            ]);

            foreach ($files as $file) {
                if (!is_object($file) || !method_exists($file, 'getClientOriginalName')) {
                    continue;
                }

                $nombreOriginal = $file->getClientOriginalName();
                $size = $file->getSize();

                /*
             * Huella básica para evitar que Livewire agregue el mismo archivo
             * varias veces si el input dispara más de un update.
             */
                $fingerprint = md5($seccion . '|' . $nombreOriginal . '|' . $size);

                $yaExisteEnLista = collect($this->{$listProperty})
                    ->contains(function ($item) use ($fingerprint) {
                        return ($item['upload_fingerprint'] ?? null) === $fingerprint
                            && !empty($item['nuevo']);
                    });

                if ($yaExisteEnLista) {
                    continue;
                }

                $path = $file->storeAs(
                    'cotizaciones/pdf-adjuntos/tmp',
                    Str::uuid() . '.pdf',
                    'public'
                );

                $this->{$listProperty}[] = [
                    'uuid' => (string) Str::uuid(),
                    'id' => null,
                    'cotizacion_id' => null,
                    'nombre_original' => $nombreOriginal,
                    'path' => $path,
                    'mime_type' => $file->getMimeType(),
                    'size_bytes' => $size,
                    'orden' => count($this->{$listProperty}) + 1,
                    'nuevo' => true,
                    'upload_fingerprint' => $fingerprint,
                ];
            }
        } finally {
            /*
         * Importante: se limpia mientras el candado todavía está activo,
         * para que el reset del input no dispare otro procesamiento.
         */
            $this->{$uploadProperty} = [];

            $this->dispatchBrowserEvent('limpiar-input-pdfs-cotizacion', [
                'seccion' => $seccion,
            ]);

            $this->procesandoPdfsAdjuntos = false;
        }
    }

    public function actualizarOrdenPdfsAdjuntosCotizacion($seccion, $uuids)
    {
        $listProperty = $seccion === 'antes_items'
            ? 'pdfsAntesItems'
            : 'pdfsDespuesItems';

        $actuales = collect($this->{$listProperty})->keyBy('uuid');

        $ordenados = [];

        foreach ($uuids as $uuid) {
            if ($actuales->has($uuid)) {
                $ordenados[] = $actuales->get($uuid);
            }
        }

        foreach ($this->{$listProperty} as $item) {
            if (!in_array($item['uuid'], $uuids)) {
                $ordenados[] = $item;
            }
        }

        foreach ($ordenados as $index => &$item) {
            $item['orden'] = $index + 1;
        }

        $this->{$listProperty} = array_values($ordenados);
    }
    public function confirmarEliminarPdfAdjuntoCotizacion($seccion, $uuid)
    {
        $this->dispatchBrowserEvent('confirmar-eliminar-pdf-adjunto-cotizacion', [
            'seccion' => $seccion,
            'uuid' => $uuid,
        ]);
    }

    public function eliminarPdfAdjuntoCotizacion($seccion, $uuid)
    {
        $listProperty = $seccion === 'antes_items'
            ? 'pdfsAntesItems'
            : 'pdfsDespuesItems';

        $nuevoListado = [];

        foreach ($this->{$listProperty} as $item) {
            if ($item['uuid'] !== $uuid) {
                $nuevoListado[] = $item;
                continue;
            }

            /*
         * Si el PDF pertenece a la cotización actual, sí lo marcamos para borrar.
         * Si pertenece a una versión anterior, solo lo quitamos del listado actual:
         * no se copiará a la nueva versión, pero no destruimos el historial.
         */
            if (
                !empty($item['id']) &&
                !empty($item['cotizacion_id']) &&
                (int) $item['cotizacion_id'] === (int) $this->cotizacionEditandoId
            ) {
                $this->pdfsAdjuntosEliminarIds[] = $item['id'];
            } elseif (
                empty($item['id']) &&
                !empty($item['path']) &&
                Storage::disk('public')->exists($item['path'])
            ) {
                Storage::disk('public')->delete($item['path']);
            }
        }

        foreach ($nuevoListado as $index => &$item) {
            $item['orden'] = $index + 1;
        }

        $this->{$listProperty} = array_values($nuevoListado);
        $this->dispatchBrowserEvent('pdf-adjunto-cotizacion-eliminado');
    }
    private function guardarPdfsAdjuntosCotizacion($cotizacion)
    {
        /*
     * Eliminar PDFs marcados.
     */

        if (!empty($this->pdfsAdjuntosEliminarIds)) {
            $pdfsEliminar = CotizacionPdfAdjunto::whereIn('id', $this->pdfsAdjuntosEliminarIds)->get();

            foreach ($pdfsEliminar as $pdf) {
                if ($pdf->path && Storage::disk('public')->exists($pdf->path)) {
                    Storage::disk('public')->delete($pdf->path);
                }

                $pdf->delete();
            }

            $this->pdfsAdjuntosEliminarIds = [];
        }

        $this->guardarPdfsAdjuntosPorSeccion($cotizacion, 'antes_items', $this->pdfsAntesItems);
        $this->guardarPdfsAdjuntosPorSeccion($cotizacion, 'despues_items', $this->pdfsDespuesItems);
    }

    private function guardarPdfsAdjuntosPorSeccion($cotizacion, $seccion, array $items)
    {
        foreach ($items as $index => $item) {
            $orden = $index + 1;

            /*
         * CASO 1:
         * PDF existente de esta misma cotización.
         * Solo actualizamos orden.
         */
            if (
                !empty($item['id']) &&
                !empty($item['cotizacion_id']) &&
                (int) $item['cotizacion_id'] === (int) $cotizacion->id
            ) {
                CotizacionPdfAdjunto::where('id', $item['id'])
                    ->where('cotizacion_id', $cotizacion->id)
                    ->update([
                        'orden' => $orden,
                        'updated_at' => now(),
                    ]);

                continue;
            }

            /*
 * CASO 2:
 * PDF existente de una versión anterior.
 * Lo copiamos físicamente para esta nueva versión.
 * No compartimos el mismo path entre versiones.
 */
            if (
                !empty($item['id']) &&
                !empty($item['path']) &&
                empty($item['nuevo'])
            ) {
                $sourcePath = ltrim($item['path'], '/');

                if (!Storage::disk('public')->exists($sourcePath)) {
                    continue;
                }

                $finalDir = 'cotizaciones/' . $cotizacion->id . '/pdf-adjuntos';
                $finalPath = $finalDir . '/' . Str::uuid() . '.pdf';

                Storage::disk('public')->makeDirectory($finalDir);
                Storage::disk('public')->copy($sourcePath, $finalPath);

                CotizacionPdfAdjunto::create([
                    'cotizacion_id' => $cotizacion->id,
                    'seccion' => $seccion,
                    'nombre_original' => $item['nombre_original'] ?? 'documento.pdf',
                    'path' => $finalPath,
                    'mime_type' => $item['mime_type'] ?? 'application/pdf',
                    'size_bytes' => $item['size_bytes'] ?? null,
                    'orden' => $orden,
                    'uploaded_by' => auth()->id(),
                ]);

                continue;
            }

            /*
         * CASO 3:
         * PDF nuevo subido en tmp.
         */
            if (empty($item['path'])) {
                continue;
            }

            $tmpPath = ltrim($item['path'], '/');

            if (!Storage::disk('public')->exists($tmpPath)) {
                continue;
            }

            $finalDir = 'cotizaciones/' . $cotizacion->id . '/pdf-adjuntos';
            $finalPath = $finalDir . '/' . Str::uuid() . '.pdf';

            Storage::disk('public')->makeDirectory($finalDir);

            Storage::disk('public')->copy($tmpPath, $finalPath);
            Storage::disk('public')->delete($tmpPath);

            CotizacionPdfAdjunto::create([
                'cotizacion_id' => $cotizacion->id,
                'seccion' => $seccion,
                'nombre_original' => $item['nombre_original'] ?? 'documento.pdf',
                'path' => $finalPath,
                'mime_type' => $item['mime_type'] ?? 'application/pdf',
                'size_bytes' => $item['size_bytes'] ?? null,
                'orden' => $orden,
                'uploaded_by' => auth()->id(),
            ]);
        }
    }
    private function sincronizarCotizacionConTableroAdministrativo(Cotizacion $cotizacion): void
    {
        if (! $cotizacion->id_motor) {
            return;
        }

        MotorAdminStatus::updateOrCreate(
            [
                'id_motor' => $cotizacion->id_motor,
            ],
            [
                'cotizacion_estado' => 'cotizado',
                'cotizacion_id' => $cotizacion->id,
                'cotizacion_fecha' => $cotizacion->fecha_cotizacion ?: now(),
                'updated_by' => auth()->id(),
            ]
        );
    }

    public function guardarCotizacionDesdeModalPdf($usarPortada = false, $usarCartaPresentacion = true)
    {
        $this->pdfUsarPortada = (bool) $usarPortada;
        $this->pdfUsarCartaPresentacion = (bool) $usarCartaPresentacion;

        return $this->guardarCotizacion(true);
    }
    private function asegurarContactosEnModoEdicion(): void
    {
        if (! $this->modoEdicion || ! $this->cotizacionEditandoId) {
            return;
        }

        if (! empty($this->contactosSeleccionados)) {
            return;
        }

        $contactos = CotizacionContacto::where('cotizacion_id', $this->cotizacionEditandoId)
            ->orderBy('id')
            ->pluck('contacto_id')
            ->filter()
            ->values()
            ->toArray();

        if (empty($contactos)) {
            return;
        }

        $this->contactosSeleccionados = $contactos;

        $this->actualizarContactosPreview();

        $this->cargarContactosParaChoices();
    }
    public function debugValidacionCotizacion()
    {
        $resultado = $this->validarCotizacionAntesDeContinuar();

        dd([
            'resultado' => $resultado,
            'errores' => $this->getErrorBag()->toArray(),
            'estado' => [
                'tituloCotizacion' => $this->tituloCotizacion,
                'cliente_id' => $this->cliente_id,
                'contactosSeleccionados' => $this->contactosSeleccionados,
                'cotDate' => $this->cotDate,
                'cotValid' => $this->cotValid,
                'itemsCotizacion_count' => count($this->itemsCotizacion),
                'tiempoEntrega' => $this->tiempoEntrega,
                'tiempoEntregaOtro' => $this->tiempoEntregaOtro,
                'monedaCotizacion' => $this->monedaCotizacion,
                'tipoCambio' => $this->tipoCambio,
                'pdfsAntesItems_count' => count($this->pdfsAntesItems),
                'pdfsDespuesItems_count' => count($this->pdfsDespuesItems),
                'pdfsAdjuntosEliminarIds' => $this->pdfsAdjuntosEliminarIds,
            ],
        ]);
    }

    /* excel */
    private function inicializarModoExcel()
    {
        $payload = session('cotizacion_excel_payload');

        if (!$payload || empty($payload['grupos'])) {
            session()->flash('error', 'No hay datos de Excel cargados para crear la cotización.');
            redirect()->route('admin.cotizaciones.index')->send();
            return;
        }

        $this->modoExcel = true;
        $this->modoUnificacion = false;
        $this->modoAdicional = false;
        $this->modoDuplicado = false;
        $this->modoEdicion = false;

        $this->cotizacionEditandoId = null;
        $this->cotizacionGuardadaId = null;

        $this->cotDate = Carbon::now()->format('d-m-Y');
        $this->cotValid = Carbon::now()->addDays(30)->format('d-m-Y');

        $this->generarNumeroCotizacionInicial();

        $this->tituloCotizacion = 'Oferta Presupuestaria';
        $this->subtituloCotizacion = 'Cotización de varios equipos';

        $this->motor_id = null;
        $this->equipoNoIngresadoTaller = true;
        $this->osSeleccionadaLabel = 'Cotización generada desde Excel';
        $this->motorPreview = null;
        $this->usarDatosEquipo = false;
        $this->resumenEquipo = '';

        $this->fotoPortadaCotizacion = null;
        $this->fotoPortadaActual = null;
        $this->pdfUsarPortada = false;

        $this->gruposExcel = $payload['grupos'];
        $this->totalExcel = (float) ($payload['total'] ?? 0);

        $this->itemsCotizacion = [];
        $this->subtotalItems = $this->totalExcel;
    }
    public function recalcularItemExcel($grupoIndex, $itemIndex)
    {
        if (! isset($this->gruposExcel[$grupoIndex]['items'][$itemIndex])) {
            return;
        }

        $cantidad = (float) ($this->gruposExcel[$grupoIndex]['items'][$itemIndex]['cantidad'] ?? 0);
        $precioUnitario = (float) ($this->gruposExcel[$grupoIndex]['items'][$itemIndex]['precio_unitario'] ?? 0);

        $this->gruposExcel[$grupoIndex]['items'][$itemIndex]['precio_total'] = round($cantidad * $precioUnitario, 2);

        $this->recalcularSubtotalGrupoExcel($grupoIndex);
        $this->recalcularTotalExcel();
    }

    private function recalcularSubtotalGrupoExcel($grupoIndex)
    {
        if (! isset($this->gruposExcel[$grupoIndex])) {
            return;
        }

        $this->gruposExcel[$grupoIndex]['subtotal'] = collect($this->gruposExcel[$grupoIndex]['items'] ?? [])
            ->sum(function ($item) {
                return (float) ($item['precio_total'] ?? 0);
            });
    }

    public function recalcularTotalExcel()
    {
        foreach ($this->gruposExcel as $grupoIndex => $grupo) {
            $this->recalcularSubtotalGrupoExcel($grupoIndex);
        }

        $this->totalExcel = collect($this->gruposExcel)
            ->sum(function ($grupo) {
                return (float) ($grupo['subtotal'] ?? 0);
            });

        $this->subtotalItems = round($this->totalExcel, 2);
    }

    public function agregarItemExcel($grupoIndex)
    {
        if (! isset($this->gruposExcel[$grupoIndex])) {
            return;
        }

        $this->gruposExcel[$grupoIndex]['items'][] = [
            'uid' => uniqid('item_excel_', true),
            'catalogo_item_id' => null,
            'tipo_item' => 'general',
            'nombre' => 'Nuevo ítem',
            'descripcion' => '',
            'cantidad' => 1,
            'precio_unitario' => 0,
            'precio_total' => 0,
            'descuento_porcentaje' => null,
            'descuento_alcance' => null,
            'descuento_item_principal_uid' => null,
            'orden' => count($this->gruposExcel[$grupoIndex]['items'] ?? []) + 1,
        ];

        $this->recalcularSubtotalGrupoExcel($grupoIndex);
        $this->recalcularTotalExcel();
    }

    public function eliminarItemExcel($grupoIndex, $itemIndex)
    {
        if (! isset($this->gruposExcel[$grupoIndex]['items'][$itemIndex])) {
            return;
        }

        unset($this->gruposExcel[$grupoIndex]['items'][$itemIndex]);

        $this->gruposExcel[$grupoIndex]['items'] = array_values($this->gruposExcel[$grupoIndex]['items']);

        foreach ($this->gruposExcel[$grupoIndex]['items'] as $index => &$item) {
            $item['orden'] = $index + 1;
        }

        $this->recalcularSubtotalGrupoExcel($grupoIndex);
        $this->recalcularTotalExcel();
    }
    private function guardarCotizacionExcel($generarPdf = false)
    {
        $this->recalcularTotalExcel();

        $cotizacion = DB::transaction(function () {
            $numeroData = $this->prepararNumeroCotizacionParaGuardar();

            $fechaCotizacion = Carbon::createFromFormat('d-m-Y', $this->cotDate)->format('Y-m-d');
            $fechaValidaHasta = Carbon::createFromFormat('d-m-Y', $this->cotValid)->format('Y-m-d');

            $fotoPortadaPath = $this->fotoPortadaActual;

            if ($this->fotoPortadaCotizacion) {
                $fotoPortadaPath = $this->fotoPortadaCotizacion->store('cotizaciones/portadas', 'public');
            }

            $cotizacion = Cotizacion::create([
                'numero' => $numeroData['numero'],
                'titulo' => $this->tituloCotizacion,
                'subtitulo' => $this->subtituloCotizacion,

                'cot_year' => $numeroData['year'],
                'correlativo' => $numeroData['correlativo'],
                'letra' => $numeroData['letra'],
                'version' => $numeroData['version'],

                'id_cliente' => $this->cliente_id,
                'id_motor' => null,
                'equipo_no_ingresado_taller' => 1,

                'fecha_cotizacion' => $fechaCotizacion,
                'fecha_valida_hasta' => $fechaValidaHasta,

                'presentacion_id' => $this->presentacion_id,
                'texto_presentacion' => $this->textoPresentacion,

                'usar_datos_equipo' => 0,
                'resumen_equipo' => null,

                'moneda' => $this->monedaCotizacion,
                'tipo_cambio' => $this->monedaCotizacion === 'GTQ_USD'
                    ? $this->tipoCambio
                    : null,

                'subtotal' => $this->totalExcel,
                'descuento' => 0,
                'total' => $this->totalExcel,

                'estado' => 'borrador',
                'no_incluye' => $this->noIncluyeItems,

                'tiempo_entrega' => $this->tiempoEntrega,
                'tiempo_entrega_otro' => $this->tiempoEntrega === 'otro'
                    ? $this->tiempoEntregaOtro
                    : null,

                'garantia_modo' => $this->garantiaModo,
                'garantia_general_activa' => $this->garantiaGeneralActiva ? 1 : 0,
                'garantia_general_tiempo' => $this->garantiaGeneralTiempo,
                'garantia_electrica_tiempo' => $this->garantiaElectricaTiempo,
                'garantia_mecanica_tiempo' => $this->garantiaMecanicaTiempo,
                'incluir_terminos_garantias' => $this->incluirTerminosGarantias ? 1 : 0,

                'terminos_pago' => $this->terminosPago,
                'cliente_debe_proveer_oc' => $this->clienteDebeProveerOc ? 1 : 0,

                'notas_adicionales' => $this->notasAdicionales,
                'foto_portada' => $fotoPortadaPath,

                'tipo_cotizacion' => 'excel',
                'es_unificada' => 0,

                'creado_por' => auth()->id(),
            ]);

            $this->guardarContactosCotizacionSnapshot($cotizacion);

            foreach ($this->gruposExcel as $grupoIndex => $grupo) {
                $grupoDb = CotizacionExcelGrupo::create([
                    'cotizacion_id' => $cotizacion->id,
                    'nombre_equipo' => $grupo['nombre_equipo'] ?? ('Equipo ' . ($grupoIndex + 1)),
                    'datos_tecnicos_json' => $grupo['datos_tecnicos'] ?? [],
                    'subtotal' => (float) ($grupo['subtotal'] ?? 0),
                    'orden' => $grupoIndex + 1,
                ]);

                foreach (($grupo['items'] ?? []) as $itemIndex => $item) {
                    CotizacionItem::create([
                        'cotizacion_id' => $cotizacion->id,
                        'cotizacion_excel_grupo_id' => $grupoDb->id,

                        'catalogo_item_id' => $item['catalogo_item_id'] ?? null,
                        'tipo_item' => $item['tipo_item'] ?? 'general',

                        'nombre' => $item['nombre'],
                        'descripcion' => $item['descripcion'] ?? null,
                        'cantidad' => (float) ($item['cantidad'] ?? 1),
                        'precio_unitario' => (float) ($item['precio_unitario'] ?? 0),
                        'precio_total' => (float) ($item['precio_total'] ?? 0),

                        'descuento_porcentaje' => $item['descuento_porcentaje'] ?? null,
                        'descuento_alcance' => $item['descuento_alcance'] ?? null,
                        'descuento_item_principal_uid' => $item['descuento_item_principal_uid'] ?? null,

                        'orden' => $itemIndex + 1,
                    ]);
                }
            }

            $this->guardarPdfsAdjuntosCotizacion($cotizacion);

            return $cotizacion;
        });

        $this->cotizacionGuardadaId = $cotizacion->id;

        session()->forget('cotizacion_excel_payload');

        session()->flash('success', 'Cotización desde Excel guardada correctamente.');

        if ($generarPdf) {
            $urlPdf = route('admin.cotizaciones.downloadPdf', [
                'cotizacion' => $cotizacion->id,
                'portada' => $this->pdfUsarPortada ? 1 : 0,
            ]);

            $this->dispatchBrowserEvent('cotizacion-pdf-listo', [
                'url' => $urlPdf,
            ]);

            return;
        }

        return redirect()->route('admin.cotizaciones.index');
    }
    private function cargarGruposExcelParaEditar(Cotizacion $cotizacion): void
    {
        $grupos = CotizacionExcelGrupo::with('items')
            ->where('cotizacion_id', $cotizacion->id)
            ->orderBy('orden')
            ->get();

        $this->gruposExcel = $grupos
            ->map(function ($grupo) {
                $datosTecnicos = $grupo->datos_tecnicos_json;

                if (is_string($datosTecnicos)) {
                    $datosTecnicos = json_decode($datosTecnicos, true) ?: [];
                }

                if (! is_array($datosTecnicos)) {
                    $datosTecnicos = [];
                }

                $items = $grupo->items
                    ->map(function ($item) {
                        $precioTotal = (float) $item->precio_total;

                        $tipoItem = $item->getAttribute('tipo_item');

                        if (! $tipoItem) {
                            $tipoItem = $precioTotal < 0 ? 'descuento' : 'general';
                        }

                        return [
                            'uid' => 'db-item-excel-' . $item->id,
                            'id' => $item->id,
                            'catalogo_item_id' => $item->catalogo_item_id,
                            'tipo_item' => $tipoItem,

                            'nombre' => $item->nombre,
                            'descripcion' => $item->descripcion,

                            'cantidad' => (float) $item->cantidad,
                            'precio_unitario' => (float) $item->precio_unitario,
                            'precio_total' => $precioTotal,

                            'descuento_porcentaje' => $item->getAttribute('descuento_porcentaje'),
                            'descuento_alcance' => $item->getAttribute('descuento_alcance'),
                            'descuento_item_principal_uid' => $item->getAttribute('descuento_item_principal_uid'),

                            'orden' => $item->orden,
                        ];
                    })
                    ->values()
                    ->toArray();

                return [
                    'uid' => 'db-grupo-excel-' . $grupo->id,
                    'id' => $grupo->id,
                    'nombre_equipo' => $grupo->nombre_equipo,
                    'datos_tecnicos' => $datosTecnicos,
                    'descripcion_tecnica' => $this->descripcionTecnicaGrupoExcel(
                        $datosTecnicos,
                        $grupo->nombre_equipo
                    ),
                    'items' => $items,
                    'subtotal' => (float) $grupo->subtotal,
                ];
            })
            ->values()
            ->toArray();
    }
    private function descripcionTecnicaGrupoExcel(array $datos, $nombreFallback = null): string
    {
        $partes = [];

        $nombreEquipo = $datos['nombre_equipo'] ?? $nombreFallback;

        if (filled($nombreEquipo)) {
            $partes[] = '"' . trim($nombreEquipo) . '"';
        }

        if (filled($datos['hp'] ?? null)) {
            $partes[] = $this->valorConUnidadGrupoExcel($datos['hp'], 'HP', false);
        }

        if (filled($datos['rpm'] ?? null)) {
            $partes[] = $this->valorConUnidadGrupoExcel($datos['rpm'], 'RPM');
        }

        if (filled($datos['voltaje'] ?? null)) {
            $partes[] = $this->valorConUnidadGrupoExcel($datos['voltaje'], 'V');
        }

        if (filled($datos['amperaje'] ?? null)) {
            $partes[] = $this->valorConUnidadGrupoExcel($datos['amperaje'], 'A');
        }

        if (filled($datos['serie'] ?? null)) {
            $partes[] = 'Serie: ' . trim($datos['serie']);
        }

        if (filled($datos['modelo'] ?? null)) {
            $partes[] = 'Modelo: ' . trim($datos['modelo']);
        }

        if (filled($datos['frame'] ?? null)) {
            $partes[] = 'Frame ' . trim($datos['frame']);
        }

        if (filled($datos['hz'] ?? null)) {
            $partes[] = $this->valorConUnidadGrupoExcel($datos['hz'], 'Hz');
        }

        if (empty($partes)) {
            return 'Motor';
        }

        return 'Motor ' . implode(', ', $partes);
    }
    private function valorConUnidadGrupoExcel($valor, string $unidad, bool $espacio = true): string
    {
        $valor = trim((string) $valor);

        if ($valor === '') {
            return '';
        }

        if (preg_match('/[a-zA-Z%]/', $valor)) {
            return $valor;
        }

        return $valor . ($espacio ? ' ' : '') . $unidad;
    }
    private function cargarNumeroRequerimientoDesdeTablero()
    {
        $this->numeroRequerimiento = '';

        if (!$this->motor_id) {
            return;
        }

        $numero = $this->obtenerNumeroRequerimientoDesdeTablero($this->motor_id);

        if ($numero) {
            $this->numeroRequerimiento = $numero;
        }
    }

    private function obtenerNumeroRequerimientoDesdeTablero($motorId): ?string
    {
        /*
     * AJUSTAR AQUÍ si el campo real del tablero administrativo
     * no es jobs.value_campo1.
     */
        $numero = DB::table('jobs')
            ->where('id_motor', $motorId)
            ->whereNotNull('value_campo1')
            ->where('value_campo1', '<>', '')
            ->orderByDesc('id')
            ->value('value_campo1');

        return $numero ? trim((string) $numero) : null;
    }
    public function updatedUsarNumeroRequerimiento($value)
    {
        if (!$value) {
            $this->numeroRequerimiento = '';
        }
    }

    private function guardarNumeroRequerimientoEnTablero(): void
    {
        if (!$this->motor_id) {
            return;
        }

        /*
     * Si el switch está apagado, no guardamos nada.
     * Tampoco borramos datos históricos del tablero.
     */
        if (!$this->usarNumeroRequerimiento) {
            return;
        }
        if (!$this->usarNumeroRequerimiento) {
            return;
        }

        $numero = trim((string) $this->numeroRequerimiento);

        if ($numero === '') {
            return;
        }

        /*
     * AJUSTAR AQUÍ si el campo real del tablero administrativo
     * no es jobs.value_campo1.
     */
        $job = DB::table('jobs')
            ->where('id_motor', $this->motor_id)
            ->orderByDesc('id')
            ->first();

        if (!$job) {
            return;
        }

        DB::table('jobs')
            ->where('id', $job->id)
            ->update([
                'value_campo1' => $numero,
                'updated_at' => now(),
            ]);
    }
}
