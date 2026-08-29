@php
    $seccionPdf = $seccionPdf ?? 'completo';
@endphp
@php
    /*
     * Convierte rutas locales para wkhtmltopdf.
     * Especialmente necesario en Windows:
     * C:\Apache24\htdocs\... -> file:///C:/Apache24/htdocs/...
     */
    $pdfFileUrl = function ($path) {
        if (!$path) {
            return '';
        }

        $path = str_replace('\\', '/', $path);
        $path = str_replace(' ', '%20', $path);

        if (preg_match('/^[A-Za-z]:\//', $path)) {
            return 'file:///' . $path;
        }

        return 'file://' . $path;
    };
@endphp
@php
    $logoPath = public_path('img/logo.jpg');
    $cajaPath = public_path('img/caja-portada1.png');

    $fotoMotorPath = null;

    if ($motor && $motor->fotos && $motor->fotos->count() > 0) {
        $fotoType3 = $motor->fotos->where('type', 3)->first();

        if (
            $fotoType3 &&
            !empty($fotoType3->thumb) &&
            \Illuminate\Support\Facades\Storage::exists('public' . $fotoType3->thumb)
        ) {
            $fotoMotorPath = public_path('storage' . $fotoType3->thumb);
        }
    }

    $clienteNombre = optional($cliente)->cliente ?? 'CLIENTE NO ESPECIFICADO';

    $nombreEquipo = optional(optional($motor)->infoMotor)->nombre_equipo ?? '';
@endphp
@php
    use Carbon\Carbon;

    $logoPath = public_path('img/logo.jpg');
    $easaPath = public_path('img/easa.jpg');
    $wegPath = public_path('img/weg.png');
    $cajaPath = public_path('img/caja-portada1.png');

    $fotoMotorPath = public_path('img/default-avatar.png');

    $logoUrl = $pdfFileUrl($logoPath);
    $easaUrl = $pdfFileUrl($easaPath);
    $wegUrl = $pdfFileUrl($wegPath);

    $cover1BgPath = public_path('img/portada 1.3.png');
    $cover2BgPath = public_path('img/portada 2.1.png');

    $cover1BgUrl = $pdfFileUrl($cover1BgPath);
    $cover2BgUrl = $pdfFileUrl($cover2BgPath);

    if ($motor && $motor->fotos && $motor->fotos->count() > 0) {
        $fotoType3 = $motor->fotos->where('type', 3)->first();

        if (
            $fotoType3 &&
            !empty($fotoType3->thumb) &&
            \Illuminate\Support\Facades\Storage::exists('public' . $fotoType3->thumb)
        ) {
            $fotoMotorPath = public_path('storage' . $fotoType3->thumb);
        }
    }

    $clienteNombre = optional($cliente)->cliente ?? 'CLIENTE NO ESPECIFICADO';
    $nombreEquipo = optional(optional($motor)->infoMotor)->nombre_equipo ?? '';

    $infoCliente = optional($cliente)->info_cliente;
    $razonSocial = optional($infoCliente)->razon_social ?? '';
    $direccionFiscal = optional($infoCliente)->direccion_fiscal ?? '';
    $paisCliente = optional($cliente)->pais ?? '';
    $nitCliente = optional($infoCliente)->nit ?? '';

    $contactoPrincipal = null;

    if ($cotizacion->contactosCotizacion && $cotizacion->contactosCotizacion->count() > 0) {
        $contactoPrincipal = $cotizacion->contactosCotizacion->first();
    }

    $contactoPrincipal = null;
    $nombreContacto = '';
    $emailContacto = '';
    $puestoContacto = '';

    if ($cotizacion->contactosCotizacion && $cotizacion->contactosCotizacion->count() > 0) {
        $contactoPrincipal = $cotizacion->contactosCotizacion->first();
    }

    if ($contactoPrincipal) {
        /*
         * Caso 1: viene limpio en columnas snapshot
         */
        /*
         * Caso 1: snapshot limpio en cotizacion_contactos
         */
        if (!empty($contactoPrincipal->nombre)) {
            $nombreContacto = $contactoPrincipal->nombre;
        }

        if (!empty($contactoPrincipal->email)) {
            $emailContacto = $contactoPrincipal->email;
        }

        if (!empty($contactoPrincipal->puesto)) {
            $puestoContacto = $contactoPrincipal->puesto;
        }

        /*
         * Caso 2: el campo "contacto" trae JSON serializado
         */
        if (!$nombreContacto && !empty($contactoPrincipal->contacto)) {
            $rawContacto = $contactoPrincipal->contacto;

            if (is_string($rawContacto)) {
                $decodedContacto = json_decode($rawContacto, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decodedContacto)) {
                    $nombreContacto = $decodedContacto['contacto'] ?? ($decodedContacto['nombre'] ?? '');
                    $emailContacto = $emailContacto ?: $decodedContacto['email'] ?? '';
                    $puestoContacto = $puestoContacto ?: $decodedContacto['puesto'] ?? '';
                } else {
                    $nombreContacto = $rawContacto;
                }
            }
        }
    }

    $fechaCarta = $cotizacion->fecha_cotizacion ? Carbon::parse($cotizacion->fecha_cotizacion) : now();

    $meses = [
        1 => 'Enero',
        2 => 'Febrero',
        3 => 'Marzo',
        4 => 'Abril',
        5 => 'Mayo',
        6 => 'Junio',
        7 => 'Julio',
        8 => 'Agosto',
        9 => 'Septiembre',
        10 => 'Octubre',
        11 => 'Noviembre',
        12 => 'Diciembre',
    ];

    $fechaCartaTexto =
        'Guatemala, ' . $fechaCarta->day . ' de ' . $meses[(int) $fechaCarta->month] . ' ' . $fechaCarta->year;

    $textoPresentacion = $cotizacion->texto_presentacion ?? '';
@endphp
@php
    $itemsCotizacion = $cotizacion->itemsCotizacion ?? collect();

    $moneda = $cotizacion->moneda ?? 'GTQ';

    $simboloMoneda = $moneda === 'USD' ? '$' : 'Q';

    $mostrarConversionUsd = $moneda === 'GTQ_USD' && $cotizacion->tipo_cambio && $cotizacion->tipo_cambio > 0;

    $tipoCambio = (float) ($cotizacion->tipo_cambio ?? 0);

    $totalCotizacion = (float) ($cotizacion->total ?? $itemsCotizacion->sum('precio_total'));

    /*
     * El total de la cotización ya incluye IVA.
     * Precio sin IVA = Total / 1.12
     * IVA = Total - Precio sin IVA
     */
    $precioSinIva = round($totalCotizacion / 1.12, 2);
    $valorIva = round($totalCotizacion - $precioSinIva, 2);

    $formatoMoneda = function ($valor, $simbolo = null) use ($simboloMoneda) {
        return ($simbolo ?: $simboloMoneda) . number_format((float) $valor, 2);
    };
@endphp
@php
    $esCotizacionUnificada = (bool) ($cotizacion->es_unificada ?? false);

    $gruposItemsUnificados = collect();

    if ($esCotizacionUnificada && $cotizacion->unificadaDetalles) {
        $gruposItemsUnificados = $cotizacion->unificadaDetalles
            ->map(function ($detalle) {
                $cotizacionOrigen = $detalle->cotizacionOrigen;
                $motorOrigen = optional($cotizacionOrigen)->motor;

                $osLabel = $detalle->os_label;

                if (!$osLabel && $motorOrigen) {
                    $osLabel = trim(($motorOrigen->year ?? '') . '-' . ($motorOrigen->os ?? ''), '-');
                }

                $equipoLabel =
                    $detalle->equipo_label ?:
                    optional(optional($motorOrigen)->infoMotor)->nombre_equipo ?:
                    'Equipo cotizado';

                $potenciaLabel =
                    $detalle->potencia_label ?:
                    $motorOrigen->potencia ?? null ?:
                    optional(optional($motorOrigen)->infoMotor)->potencia ?:
                    '';

                /*
                 * Título del bloque:
                 * - Si hay OS, mostrar OS.
                 * - Si no hay OS, mostrar descripción técnica del motor/equipo.
                 */
                if ($osLabel && strtoupper($osLabel) !== 'SIN OS') {
                    $tituloGrupo = 'OS ' . $osLabel;
                } else {
                    $tituloGrupo = $equipoLabel;

                    if ($potenciaLabel) {
                        $tituloGrupo .= ' de ' . $potenciaLabel;
                    }
                }

                return [
                    'detalle_id' => $detalle->id,
                    'cotizacion_origen_id' => $detalle->cotizacion_origen_id,
                    'numero_origen' => optional($cotizacionOrigen)->numero,
                    'titulo' => $tituloGrupo,
                    'os' => $osLabel,
                    'equipo' => $equipoLabel,
                    'potencia' => $potenciaLabel,
                    'subtotal' => (float) $detalle->subtotal,
                    'items' => $detalle->items ?: collect(),
                ];
            })
            ->values();
    }
@endphp
@php
    /*
     * =========================
     * COTIZACIÓN DESDE EXCEL
     * =========================
     */

    $esCotizacionExcel = (string) ($cotizacion->tipo_cotizacion ?? '') === 'excel';

    $gruposItemsExcel = collect();

    if ($esCotizacionExcel && $cotizacion->excelGrupos) {
        $gruposItemsExcel = $cotizacion->excelGrupos
            ->map(function ($grupo) {
                $datosTecnicos = $grupo->datos_tecnicos_json ?? [];

                if (is_string($datosTecnicos)) {
                    $datosTecnicos = json_decode($datosTecnicos, true) ?: [];
                }

                if (!is_array($datosTecnicos)) {
                    $datosTecnicos = [];
                }

                $partes = [];

                $nombreEquipo = $datosTecnicos['nombre_equipo'] ?? ($grupo->nombre_equipo ?? null);

                if (!empty($nombreEquipo)) {
                    $partes[] = '"' . trim($nombreEquipo) . '"';
                }

                if (!empty($datosTecnicos['hp'] ?? null)) {
                    $hp = trim((string) $datosTecnicos['hp']);
                    $partes[] = preg_match('/[a-zA-Z]/', $hp) ? $hp : $hp . 'HP';
                }

                if (!empty($datosTecnicos['rpm'] ?? null)) {
                    $rpm = trim((string) $datosTecnicos['rpm']);
                    $partes[] = preg_match('/[a-zA-Z]/', $rpm) ? $rpm : $rpm . ' RPM';
                }

                if (!empty($datosTecnicos['voltaje'] ?? null)) {
                    $voltaje = trim((string) $datosTecnicos['voltaje']);
                    $partes[] = preg_match('/[a-zA-Z]/', $voltaje) ? $voltaje : $voltaje . ' V';
                }

                if (!empty($datosTecnicos['amperaje'] ?? null)) {
                    $amperaje = trim((string) $datosTecnicos['amperaje']);
                    $partes[] = preg_match('/[a-zA-Z]/', $amperaje) ? $amperaje : $amperaje . ' A';
                }

                if (!empty($datosTecnicos['serie'] ?? null)) {
                    $partes[] = 'Serie: ' . trim((string) $datosTecnicos['serie']);
                }

                if (!empty($datosTecnicos['modelo'] ?? null)) {
                    $partes[] = 'Modelo: ' . trim((string) $datosTecnicos['modelo']);
                }

                if (!empty($datosTecnicos['frame'] ?? null)) {
                    $partes[] = 'Frame ' . trim((string) $datosTecnicos['frame']);
                }

                if (!empty($datosTecnicos['hz'] ?? null)) {
                    $hz = trim((string) $datosTecnicos['hz']);
                    $partes[] = preg_match('/[a-zA-Z]/', $hz) ? $hz : $hz . ' Hz';
                }

                $descripcionTecnica = empty($partes) ? 'Motor' : 'Motor ' . implode(', ', $partes);

                $tituloGrupo = $grupo->nombre_equipo ?: 'Equipo cotizado';

                return [
                    'detalle_id' => $grupo->id,
                    'cotizacion_origen_id' => null,
                    'numero_origen' => null,
                    'titulo' => $tituloGrupo,
                    'os' => null,
                    'equipo' => $grupo->nombre_equipo,
                    'potencia' => $datosTecnicos['hp'] ?? null,
                    'descripcion_tecnica' => $descripcionTecnica,
                    'subtotal' => (float) $grupo->subtotal,
                    'items' => $grupo->items ?: collect(),
                ];
            })
            ->values();
    }

    $esCotizacionAgrupada = $esCotizacionUnificada || $esCotizacionExcel;

    $gruposItemsPdf = $esCotizacionExcel ? $gruposItemsExcel : $gruposItemsUnificados;
@endphp
@php
    /*
     * =========================
     * INFORMACIÓN ADICIONAL
     * =========================
     */

    $noIncluyeItems = $cotizacion->no_incluye ?? [];

    if (is_string($noIncluyeItems)) {
        $decodedNoIncluye = json_decode($noIncluyeItems, true);
        $noIncluyeItems = is_array($decodedNoIncluye) ? $decodedNoIncluye : [];
    }

    if (!is_array($noIncluyeItems)) {
        $noIncluyeItems = [];
    }

    $labelTiempoEntrega = function ($value, $otro = null) {
        $opciones = [
            'inmediata' => 'Disponibilidad inmediata',
            '24_horas' => '24 horas o menos',
            '1_2_dias' => '1-2 días hábiles',
            '2_3_dias' => '2-3 días hábiles',
            '3_4_dias' => '3-4 días hábiles',
            '4_5_dias' => '4-5 días hábiles',
            '5_7_dias' => '5-7 días hábiles',
            'a_convenir' => 'A convenir con el cliente',
            'otro' => $otro ?: 'Otro',
        ];

        return $opciones[$value] ?? 'No especificado';
    };

    $labelGarantiaTiempo = function ($value) {
        $opciones = [
            'no_aplica' => 'No aplica (N/A)',
            '30_dias' => '30 días',
            '3_meses' => '3 meses',
            '6_meses' => '6 meses',
            '1_anio' => '1 año',
            '2_anios' => '2 años',
        ];

        return $opciones[$value] ?? 'No especificado';
    };

    $labelTerminosPago = function ($value) {
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

        return $opciones[$value] ?? 'No especificado';
    };

    $tiempoEntregaTexto = $labelTiempoEntrega($cotizacion->tiempo_entrega, $cotizacion->tiempo_entrega_otro);

    $terminosPagoTexto = $labelTerminosPago($cotizacion->terminos_pago);

    $garantiaModo = $cotizacion->garantia_modo ?? 'general';

    $garantiaTexto = '';

    if ($garantiaModo === 'general') {
        if ($cotizacion->garantia_general_activa) {
            $garantiaTexto = 'Garantía general: ' . $labelGarantiaTiempo($cotizacion->garantia_general_tiempo);
        } else {
            $garantiaTexto = 'Sin garantía general especificada.';
        }
    } else {
        $garantiaTexto =
            'Garantía componentes eléctricos: ' .
            $labelGarantiaTiempo($cotizacion->garantia_electrica_tiempo) .
            '. Garantía componentes mecánicos: ' .
            $labelGarantiaTiempo($cotizacion->garantia_mecanica_tiempo) .
            '.';
    }

    $notasAdicionales = $cotizacion->notas_adicionales ?? '';
@endphp
@php
    $esCotizacionUnificada = (bool) ($cotizacion->es_unificada ?? false);

    $tituloPortada = trim($cotizacion->titulo ?? 'COTIZACIÓN');
    $subtituloPortada = trim($cotizacion->subtitulo ?? '');
    $clientePortada = '';

    if (!empty($clienteNombre)) {
        $clientePortada = $clienteNombre;
    } elseif (!empty(optional(optional($cotizacion->cliente)->info_cliente)->razon_social)) {
        $clientePortada = optional(optional($cotizacion->cliente)->info_cliente)->razon_social;
    } elseif (!empty(optional($cotizacion->cliente)->cliente)) {
        $clientePortada = optional($cotizacion->cliente)->cliente;
    }

    $tituloPartes = preg_split('/\s+/', $tituloPortada);
    $tituloLinea1 = '';
    $tituloLinea2 = '';

    if (count($tituloPartes) > 0) {
        $tituloLinea1 = array_shift($tituloPartes);
        $tituloLinea2 = implode(' ', $tituloPartes);
    }

    if (!$tituloLinea2) {
        $tituloLinea2 = $tituloLinea1;
        $tituloLinea1 = '';
    }
@endphp
@php
    $esCotizacionUnificada = (bool) ($cotizacion->es_unificada ?? false);

    /*
     * =========================
     * PORTADA 1 (NO UNIFICADA)
     * =========================
     */
    $cover1Titulo = strtoupper(trim($cotizacion->titulo ?? 'COTIZACIÓN'));
    $cover1Cliente = strtoupper(trim($clienteNombre ?? ''));
    $coverNumeroCotizacion = trim($cotizacion->numero ?? '');

    $cover1OS = '';
    $cover1EquipoDescripcion = '';
    $cover1FotoPath = null;

    /*
     * 1. Si la cotización tiene foto propia de portada,
     * usarla primero cuando no hay OS ingresada.
     */
    if (!empty($cotizacion->foto_portada)) {
        $fotoPortada = ltrim($cotizacion->foto_portada, '/');

        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($fotoPortada)) {
            $cover1FotoPath = public_path('storage/' . $fotoPortada);
        }
    }

    /*
     * 2. Si hay motor/OS, cargar datos técnicos y, si existe,
     * usar foto tipo 3 del motor.
     */
    if (!empty($cotizacion->motor)) {
        $motor = $cotizacion->motor;

        // OS
        if (!empty($motor->year) && !empty($motor->os)) {
            $cover1OS = trim($motor->year . '-' . $motor->os);
        } elseif (!empty($motor->os)) {
            $cover1OS = $motor->os;
        }

        // Descripción del equipo
        $potencia = '';
        $rpm = '';
        $volts = '';

        if (!empty(optional($motor->infoMotor)->potencia)) {
            $potencia = optional($motor->infoMotor)->potencia;
        } elseif (!empty($motor->potencia)) {
            $potencia = $motor->potencia;
        }

        if (!empty(optional($motor->infoMotor)->rpm)) {
            $rpm = optional($motor->infoMotor)->rpm;
        } elseif (!empty($motor->rpm)) {
            $rpm = $motor->rpm;
        }

        if (!empty(optional($motor->infoMotor)->volts)) {
            $volts = optional($motor->infoMotor)->volts;
        } elseif (!empty($motor->volts)) {
            $volts = $motor->volts;
        }

        $descParts = [];

        if ($potencia) {
            $descParts[] = 'Motor ' . $potencia;
        } else {
            $descParts[] = 'Motor';
        }

        if ($rpm) {
            $descParts[] = $rpm . ' RPM';
        }

        if ($volts) {
            $descParts[] = $volts . ' Volts';
        }

        $cover1EquipoDescripcion = implode(', ', $descParts);

        /*
         * Foto principal tipo 3 del motor.
         * Si quieres que la foto subida en la cotización tenga prioridad,
         * deja esta parte condicionada con !$cover1FotoPath.
         */
        if (!$cover1FotoPath && $motor->fotos && $motor->fotos->count() > 0) {
            $fotoType3 = $motor->fotos->where('type', 3)->first();

            if (
                $fotoType3 &&
                !empty($fotoType3->thumb) &&
                \Illuminate\Support\Facades\Storage::exists('public' . $fotoType3->thumb)
            ) {
                $cover1FotoPath = public_path('storage' . $fotoType3->thumb);
            }
        }
    }

    /*
     * 3. Si no hay motor, pero sí hay resumen manual del equipo,
     * usarlo como descripción.
     */
    if (!$cover1EquipoDescripcion && !empty($cotizacion->resumen_equipo)) {
        $cover1EquipoDescripcion = $cotizacion->resumen_equipo;
    }

    /*
     * 4. Cliente fallback.
     */
    if (!$cover1Cliente) {
        $cover1Cliente = strtoupper(
            trim(
                optional(optional($cotizacion->cliente)->info_cliente)->razon_social ?:
                optional($cotizacion->cliente)->cliente ?? '',
            ),
        );
    }
@endphp
@php
    $cover1FotoUrl = $cover1FotoPath ? $pdfFileUrl($cover1FotoPath) : null;
@endphp
@php
    $pdfFileUrl = function ($path) {
        if (!$path) {
            return '';
        }

        // Windows: C:\Apache24\... -> C:/Apache24/...
        $path = str_replace('\\', '/', $path);

        // Espacios en nombres como "portada 1.3.png"
        $path = str_replace(' ', '%20', $path);

        // Windows absolute path: C:/...
        if (preg_match('/^[A-Za-z]:\//', $path)) {
            return 'file:///' . $path;
        }

        // Linux absolute path: /var/www/...
        return 'file://' . $path;
    };
@endphp
@php
    $coverNumeroCotizacion = trim((string) ($cotizacion->numero ?? ''));
    $coverNumeroRequerimiento = trim((string) ($numeroRequerimiento ?? ''));
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $cotizacion->numero }}</title>
</head>

<style>
    /* =========================================================
   BASE GENERAL
========================================================= */

    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        background: #ffffff;
        color: #111111;
    }

    .page-break {
        page-break-before: always;
    }


    /* =========================================================
   PORTADA
========================================================= */

    .page {
        position: relative;
        width: 100%;
        height: 1056px;
        overflow: hidden;
        background: #ffffff;
    }

    .logo {
        position: absolute;
        top: 35px;
        left: 50%;
        width: 420px;
        margin-left: -210px;
    }

    .caja-portada {
        position: absolute;
        top: 235px;
        left: 50%;
        width: 820px;
        height: auto;
        margin-left: -410px;
    }

    .foto-equipo {
        position: absolute;
        top: 285px;
        left: 50%;
        width: 360px;
        height: 265px;
        margin-left: -180px;
        object-fit: cover;
    }

    .titulo-cotizacion {
        position: absolute;
        top: 615px;
        left: 50%;
        width: 680px;
        margin-left: -340px;
        text-align: center;
        font-size: 34px;
        font-weight: bold;
        color: #f0f4f8;
    }

    .subtitulo-cotizacion {
        position: absolute;
        top: 660px;
        left: 50%;
        width: 660px;
        margin-left: -330px;
        text-align: center;
        font-size: 24px;
        color: #f0f4f8;
    }

    .cliente {
        position: absolute;
        top: 725px;
        left: 50%;
        width: 760px;
        margin-left: -380px;
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        color: #ffffff;
        text-transform: uppercase;
    }

    .datos-title {
        position: absolute;
        top: 890px;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 27px;
        font-weight: bold;
        color: #111111;
        text-transform: uppercase;
    }

    .tabla-datos {
        position: absolute;
        top: 950px;
        left: 50%;
        width: 760px;
        margin-left: -380px;
        border-collapse: collapse;
        font-size: 10px;
        color: #344055;
    }

    .tabla-datos td {
        border: 1px solid #e7edf4;
        padding: 6px 7px;
        height: 15px;
    }

    .tabla-datos td.label {
        width: 15%;
        font-weight: bold;
        color: #1c2a3a;
        background: #f5f8fc;
    }

    .tabla-datos td.value {
        width: 18%;
        background: #ffffff;
    }

    .tabla-datos tr:nth-child(even) td.value {
        background: #f8fbff;
    }


    /* =========================================================
   CARTA DE PRESENTACION
========================================================= */

    .page-letter {
        position: relative;
        width: 100%;
        min-height: 1056px;
        background: #ffffff;
        font-family: Arial, Helvetica, sans-serif;
        color: #5f6f88;
    }

    .letter-logo {
        position: absolute;
        top: 28px;
        left: 45px;
        width: 285px;
    }

    .letter-easa {
        position: absolute;
        top: 22px;
        right: 40px;
        width: 225px;
    }

    .letter-weg {
        position: absolute;
        top: 25px;
        right: 320px;
        width: 125px;
    }

    .letter-slogan-box {
        position: absolute;
        top: 178px;
        left: -30px;
        width: 430px;
        background: #0d2a68;
        color: #ffffff;
        padding: 11px 18px 11px 42px;
        border-radius: 0 8px 8px 0;
        font-size: 14px;
        font-weight: bold;
    }

    .letter-date {
        position: absolute;
        top: 205px;
        right: 60px;
        width: 360px;
        text-align: right;
        font-size: 15px;
        color: #111111;
        text-transform: uppercase;
        font-weight: normal;
    }

    .letter-client {
        position: absolute;
        top: 305px;
        left: 60px;
        width: 760px;
        font-size: 15px;
        line-height: 1.35;
        color: #64748b;
    }

    .letter-client .cliente-nombre {
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .letter-body {
        position: absolute;
        top: 520px;
        left: 60px;
        width: 900px;
        font-size: 17px;
        line-height: 1.38;
        color: #222222;
    }

    .letter-body p {
        margin: 0 0 16px 0;
    }

    .letter-signature {
        position: absolute;
        top: 985px;
        left: 60px;
        width: 430px;
        color: #111111;
    }

    .letter-signature .saludo {
        font-size: 16px;
        margin-bottom: 36px;
    }

    .letter-signature .nombre {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 2px;
    }

    .letter-signature .puesto {
        font-size: 16px;
        font-style: italic;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .letter-signature .datos {
        font-size: 12px;
        line-height: 1.2;
    }

    .letter-signature .direccion {
        font-size: 12px;
        line-height: 1.2;
        font-style: italic;
        font-weight: bold;
        color: #1d2d7a;
    }


    /* =========================================================
   PAGINA DE ITEMS
   Importante:
   - Este bloque NO usa position:absolute.
   - El encabezado está dentro del thead.
   - wkhtmltopdf repite thead en nuevas páginas.
========================================================= */

    .page-items {
        width: 100%;
        min-height: 1056px;
        background: #ffffff;
        font-family: Arial, Helvetica, sans-serif;
        color: #1f2933;
    }

    .items-table {
        width: 88%;
        margin-left: auto;
        margin-right: auto;
        border-collapse: collapse;
        font-size: 12px;
        color: #1f2933;
    }

    .items-table thead {
        display: table-header-group;
    }

    .items-table tfoot {
        display: table-footer-group;
    }

    .items-table tr {
        page-break-inside: avoid;
    }

    .items-header-cell {
        border: none !important;
        padding: 0 0 18px 0 !important;
        background: #ffffff !important;
    }

    .items-pdf-header {
        width: 100%;
        background: #ffffff;
        padding-top: 22px;
    }

    .items-logos-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 18px;
    }

    .items-logos-table td {
        border: none !important;
        padding: 0 !important;
        vertical-align: top;
        background: #ffffff !important;
    }

    .items-logo-cme-cell {
        width: 42%;
        text-align: left;
    }

    .items-logo-certificaciones-cell {
        width: 58%;
        text-align: right;
        white-space: nowrap;
    }


    .items-logo-cme {
        width: 280px;
        display: block;
    }

    .items-logo-weg {
        width: 100px;
        display: inline-block;
        margin-top: 2px;
        margin-right: 28px;
        vertical-align: top;
    }

    .items-logo-easa {
        width: 200px;
        display: inline-block;
        vertical-align: top;
    }

    .items-slogan-box {
        margin-top: 10px;
        margin-left: -80px;
        width: 440px;
        background: #0d2a68;
        color: #ffffff;
        padding: 9px 18px 9px 85px;
        border-radius: 0 8px 8px 0;
        font-size: 13px;
        font-weight: bold;
        text-align: left;
    }

    .items-title {
        width: 100%;
        text-align: center;
        font-size: 22px;
        font-weight: bold;
        color: #111111;
        text-transform: uppercase;
        margin: 12px 0 14px 0;
    }

    .items-info-card {
        width: 100%;
        margin: 0 0 24px 0;
        padding: 10px 14px;
        border: 1px solid #d8e0ea;
        border-top: 3px solid #0d2a68;
        background: #f7f9fc;
        border-radius: 4px;
    }

    .items-info-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
        color: #44556e;
    }

    .items-info-table td {
        padding: 5px 6px;
        border: none !important;
        background: transparent !important;
        vertical-align: top;
    }

    .items-info-table td.label {
        width: 13%;
        font-weight: bold;
        color: #2f4363;
        white-space: nowrap;
    }

    .items-info-table td.value {
        width: 37%;
        color: #5b6b82;
    }

    .items-columns th {
        background: #0d2a68;
        color: #ffffff;
        border: 1px solid #0d2a68;
        padding: 8px 6px;
        font-size: 12px;
        text-align: center;
    }

    .items-table td {
        border: 1px solid #d8e0ea;
        padding: 7px 6px;
        vertical-align: top;
    }

    .items-table tbody tr:nth-child(even) td {
        background: #f7f9fc;
    }

    .item-numero {
        width: 7%;
        text-align: center;
        font-weight: bold;
    }

    .item-descripcion {
        width: 53%;
    }

    .item-cantidad {
        width: 10%;
        text-align: center;
    }

    .item-precio {
        width: 15%;
        text-align: right;
        white-space: nowrap;
    }

    .item-total {
        width: 15%;
        text-align: right;
        white-space: nowrap;
        font-weight: bold;
    }

    .item-nombre {
        font-weight: bold;
        color: #1d2f4f;
        margin-bottom: 4px;
    }

    .item-detalle {
        color: #263442;
        line-height: 1.35;
        white-space: pre-line;
    }

    .item-descuento {
        color: #9b1c1c;
    }

    .items-total-box {
        width: 88%;
        margin: 18px auto 0 auto;
        page-break-inside: avoid;
    }

    .items-total-table {
        width: 340px;
        margin-left: auto;
        border-collapse: collapse;
        font-size: 13px;
    }

    .items-total-table td {
        border: 1px solid #cfd8e3;
        padding: 8px;
    }

    .items-total-label {
        background: #eef3f8;
        font-weight: bold;
    }

    .items-total-value {
        text-align: right;
        font-weight: bold;
    }

    .items-grand-total td {
        background: #0d2a68;
        color: #ffffff;
        font-size: 15px;
        font-weight: bold;
    }

    .items-iva-table {
        width: 340px;
        margin-left: auto;
        margin-top: 8px;
        border-collapse: collapse;
        font-size: 12px;
        color: #1d2f4f;
    }

    .items-iva-table td {
        border: 1px solid #cfd8e3;
        padding: 7px 8px;
    }

    .items-iva-title td {
        background: #eef3f8;
        color: #234a9b;
        font-size: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        text-align: center;
    }

    .items-iva-label {
        background: #f7f9fc;
        font-weight: bold;
        color: #44556e;
    }

    .items-iva-value {
        text-align: right;
        font-weight: bold;
        color: #1d2f4f;
        white-space: nowrap;
    }

    /* =========================================================
   INFORMACIÓN ADICIONAL DESPUÉS DE ITEMS
========================================================= */

    .pdf-extra-info {
        width: 100%;
        margin: 0 auto;
        font-family: Arial, Helvetica, sans-serif;
        color: #263442;
        page-break-inside: avoid;
    }

    .pdf-extra-title {
        background: #0d2a68;
        color: #ffffff;
        font-size: 15px;
        font-weight: bold;
        text-transform: uppercase;
        padding: 9px 12px;
        border-radius: 4px 4px 0 0;
    }

    .pdf-extra-grid {
        border: 1px solid #d8e0ea;
        border-top: none;
        padding: 14px;
        background: #ffffff;
    }

    .pdf-extra-section {
        margin-bottom: 16px;
        page-break-inside: avoid;
    }

    .pdf-extra-section:last-child {
        margin-bottom: 0;
    }

    .pdf-section-heading {
        font-size: 13px;
        font-weight: bold;
        color: #0d2a68;
        text-transform: uppercase;
        border-bottom: 1px solid #d8e0ea;
        padding-bottom: 5px;
        margin-bottom: 8px;
    }

    .pdf-list {
        margin: 0;
        padding-left: 18px;
    }

    .pdf-list li {
        margin-bottom: 4px;
        line-height: 1.35;
        font-size: 12px;
    }

    .pdf-info-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }

    .pdf-info-table td {
        border: 1px solid #d8e0ea;
        padding: 7px 8px;
        vertical-align: top;
    }

    .pdf-info-table td.label {
        width: 24%;
        background: #f3f6fa;
        color: #2f4363;
        font-weight: bold;
    }

    .pdf-info-table td.value {
        width: 76%;
        background: #ffffff;
        color: #263442;
    }

    .pdf-notas {
        font-size: 12px;
        line-height: 1.4;
        color: #263442;
    }

    .pdf-notas p {
        margin: 0 0 8px 0;
    }

    .pdf-empty-text {
        font-size: 12px;
        color: #7a8795;
        font-style: italic;
    }

    /* =========================================================
   PÁGINA DE INFORMACIÓN ADICIONAL
========================================================= */

    .page-extra {
        width: 88%;
        margin: 0 auto;
        min-height: 1056px;
        background: #ffffff;
        font-family: Arial, Helvetica, sans-serif;
        color: #263442;
    }

    .extra-header {
        padding-top: 24px;
        margin-bottom: 38px;
    }

    .extra-logos-table {
        width: 100%;
        border-collapse: collapse;
    }

    .extra-logos-table td {
        border: none !important;
        padding: 0 !important;
        vertical-align: top;
        background: #ffffff !important;
    }

    .extra-logo-cme-cell {
        width: 42%;
        text-align: left;
    }

    .extra-logo-certificaciones-cell {
        width: 58%;
        text-align: right;
        white-space: nowrap;
    }

    .extra-logo-cme {
        width: 280px;
        display: block;
    }

    .extra-logo-weg {
        width: 100px;
        display: inline-block;
        margin-top: 2px;
        margin-right: 28px;
        vertical-align: top;
    }

    .extra-logo-easa {
        width: 200px;
        display: inline-block;
        vertical-align: top;
    }

    .extra-slogan-box {
        margin-top: 10px;
        margin-left: -80px;
        width: 440px;
        background: #0d2a68;
        color: #ffffff;
        padding: 9px 18px 9px 85px;
        border-radius: 0 8px 8px 0;
        font-size: 13px;
        font-weight: bold;
        text-align: left;
    }


    /* =========================================================
   PÁGINA TEMPORAL DE TÉRMINOS
========================================================= */
    /* =========================================================
   PÁGINAS DE TÉRMINOS Y GARANTÍAS
   Encabezado repetible para Snappy / wkhtmltopdf
========================================================= */
    /* =========================================================
   PÁGINAS DE TÉRMINOS Y GARANTÍAS
   Divididas manualmente para evitar montajes en Snappy
========================================================= */

    .page-terms {
        width: 88%;
        margin: 0 auto;
        min-height: 1056px;
        background: #ffffff;
        font-family: Arial, Helvetica, sans-serif;
        color: #263442;
        overflow: hidden;
    }

    .terms-header {
        padding-top: 24px;
        margin-bottom: 30px;
    }

    .terms-logo-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 22px;
    }

    .terms-logo-table td {
        border: none !important;
        padding: 0 !important;
        vertical-align: top;
        background: #ffffff !important;
    }

    .terms-logo-cme-cell {
        width: 42%;
        text-align: left;
    }

    .terms-logo-certificaciones-cell {
        width: 58%;
        text-align: right;
        white-space: nowrap;
    }

    .terms-logo-cme {
        width: 280px;
        display: block;
    }

    .terms-logo-weg {
        width: 100px;
        display: inline-block;
        margin-top: 2px;
        margin-right: 24px;
        vertical-align: top;
    }

    .terms-logo-easa {
        width: 200px;
        display: inline-block;
        vertical-align: top;
    }

    .terms-slogan-box {
        margin-top: 10px;
        margin-left: -80px;
        width: 440px;
        background: #0d2a68;
        color: #ffffff;
        padding: 9px 18px 9px 85px;
        border-radius: 0 8px 8px 0;
        font-size: 13px;
        font-weight: bold;
        text-align: left;
    }

    .terms-document-title {
        margin-top: 30px;
        margin-bottom: 18px;
        text-align: center;
        font-size: 19px;
        font-weight: bold;
        color: #111111;
        text-transform: uppercase;
    }

    .terms-content {
        width: 100%;
        font-size: 10px;
        line-height: 1.28;
        color: #263442;
    }

    .terms-content h3 {
        font-size: 10.8px;
        color: #0d2a68;
        text-transform: uppercase;
        margin: 9px 0 4px 0;
        padding-bottom: 3px;
        border-bottom: 1px solid #d8e0ea;
    }

    .terms-content p {
        margin: 0 0 5px 0;
        text-align: justify;
    }

    .terms-content ul {
        margin: 4px 0 8px 18px;
        padding: 0;
    }

    .terms-content li {
        margin-bottom: 2px;
        text-align: justify;
    }

    /* =========================================================
   ITEMS UNIFICADOS POR OS / EQUIPO
========================================================= */

    .unified-group-row td {
        padding: 0 !important;
        border: none !important;
        background: #ffffff !important;
    }

    .unified-group-header {
        background: #eef3f8;
        border: 1px solid #cfd8e3;
        border-left: 5px solid #0d2a68;
        padding: 10px 12px;
        margin-top: 14px;
        margin-bottom: 0;
    }

    .unified-group-title {
        font-size: 13px;
        font-weight: bold;
        color: #0d2a68;
        text-transform: uppercase;
    }

    .unified-group-subtitle {
        font-size: 10.5px;
        color: #536173;
        margin-top: 3px;
    }

    .unified-subtotal-row td {
        background: #f3f6fa !important;
        border: 1px solid #cfd8e3 !important;
        padding: 8px 7px !important;
        font-size: 12px;
        font-weight: bold;
        color: #1f2933;
    }

    .unified-subtotal-row td:first-child {
        text-align: right;
        color: #0d2a68;
    }

    .unified-subtotal-row td:last-child {
        text-align: right;
        color: #0d2a68;
        white-space: nowrap;
    }

    /* =========================================================
   PORTADA 1 - COTIZACIÓN NORMAL
========================================================= */

    .cover1-page {
        position: relative;
        width: 1020px;
        height: 1310px;
        overflow: hidden;
        page-break-after: always;
        background: #ffffff;
    }

    .cover1-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 1020px;
        height: 1310px;
        z-index: 1;

        background-image: url("{{ $cover1BgUrl }}");
        background-repeat: no-repeat;
        background-position: top left;
        background-size: 1020px 1310px;
    }

    /* TÍTULO */
    .cover1-title {
        position: absolute;
        top: 370px;
        left: 18px;
        width: 430px;
        z-index: 5;

        font-size: 45px;
        line-height: 72px;
        font-weight: 800;
        color: #21469a;
        text-transform: uppercase;
        white-space: pre-line;
    }

    /* OS */
    .cover1-os {
        position: absolute;
        top: 600px;
        left: 26px;
        width: 430px;
        z-index: 5;

        font-size: 54px;
        line-height: 74px;
        font-weight: 800;
        color: #ffffff;
        text-transform: uppercase;
    }

    /* Descripción equipo */
    .cover1-equipo {
        position: absolute;
        top: 700px;
        left: 18px;
        width: 455px;
        z-index: 5;

        font-size: 24px;
        line-height: 40px;
        font-style: italic;
        font-weight: 700;
        color: #ffffff;
        text-align: left;
    }

    /* Cliente */
    .cover1-cliente {
        position: absolute;
        top: 860px;
        left: 17px;
        width: 505px;
        z-index: 5;

        font-size: 28px;
        line-height: 32px;
        font-weight: 700;
        color: #333;
        white-space: pre-line;
    }

    /* Foto circular */
    .cover1-foto-wrap {
        position: absolute;
        top: 470px;
        left: 468px;
        width: 510px;
        height: 460px;
        z-index: 6;

        border-radius: 250px;
        /* círculo perfecto */
        overflow: hidden;

        background-repeat: no-repeat;
        background-position: center center;
        background-size: cover;
    }


    /* =========================================================
   PORTADA 2 - COTIZACIÓN UNIFICADA
   Fondo con tamaño fijo para Letter
========================================================= */

    .cover2-page {
        position: relative;
        width: 1020px;
        /* Letter aprox a 96dpi */
        height: 1310px;
        /* Letter aprox a 96dpi */
        overflow: hidden;
        page-break-after: always;
        background: #ffffff;
    }

    .cover2-bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 1020px;
        height: 1310px;
        z-index: 1;

        background-image: url("{{ $cover2BgUrl }}");
        background-repeat: no-repeat;
        background-position: top left;
        background-size: 1020px 1310px;
    }

    /* TÍTULO */
    .cover2-title-wrap {
        position: absolute;
        top: 400px;
        left: 138px;
        width: 690px;
        z-index: 5;
    }

    .cover2-title-dark {
        font-size: 76px;
        line-height: 76px;
        font-weight: 800;
        color: #234a9b;
        text-transform: uppercase;
        margin: 0 0 10px 0;
        padding: 0;
    }

    .cover2-title-light {
        font-size: 68px;
        line-height: 68px;
        font-weight: 800;
        color: #11a9da;
        text-transform: uppercase;
        margin: 0;
        padding: 0;
    }

    /* SUBTÍTULO */
    .cover2-subtitle-box {
        position: absolute;
        top: 555px;
        left: 156px;
        width: 585px;
        min-height: 85px;
        z-index: 5;

        font-size: 22px;
        line-height: 30px;
        font-weight: 700;
        color: #11a9da;
        white-space: pre-line;
    }

    /* NOMBRE DEL CLIENTE */
    .cover2-client-name {
        position: absolute;
        top: 900px;
        left: 146px;
        width: 690px;
        z-index: 5;

        font-size: 25px;
        line-height: 31px;
        font-weight: 400;
        color: #4d4d4d;
        text-transform: uppercase;
    }

    /* SIGNATURE */
    .firma-cotizacion {
        margin-top: 34px;
        font-family: Arial, Helvetica, sans-serif;
        color: #222222;
    }

    .firma-nombre {
        font-size: 22px;
        line-height: 22px;
        font-weight: 800;
        color: #222222;
        margin: 0 0 8px 0;
        padding: 0;
    }

    .firma-cargo {
        font-size: 16px;
        line-height: 18px;
        font-weight: 800;
        font-style: italic;
        color: #222222;
        margin: 0 0 10px 0;
        padding: 0;
    }

    .firma-linea {
        font-size: 14px;
        line-height: 14px;
        color: #222222;
        margin: 0 0 6px 0;
        padding: 0;
    }

    .firma-label {
        display: inline-block;
        width: 74px;
        font-weight: 800;
        color: #222222;
    }

    .firma-valor {
        font-weight: 400;
        color: #222222;
    }

    .firma-email {
        font-weight: 400;
        color: #005fd1;
        text-decoration: underline;
    }

    .firma-direccion {
        margin-top: 10px;
        font-size: 16px;
        line-height: 20px;
        font-style: italic;
        font-weight: 400;
        color: #000b7a;
    }

    .page-break {
        page-break-before: always;
    }

    /* =========================================================
   NÚMERO DE COTIZACIÓN EN PORTADA
========================================================= */
    .cover1-cotizacion-numero {
        position: absolute;
        top: 975px;
        left: 17px;
        width: 505px;
        z-index: 8;

        font-family: Arial, Helvetica, sans-serif;
        font-size: 28px;
        line-height: 32px;
        font-weight: 400;
        color: #234a9b;
    }

    .cover1-req-numero {
        position: absolute;
        top: 1015px;
        left: 17px;
        width: 505px;
        z-index: 8;

        font-family: Arial, Helvetica, sans-serif;
        font-size: 28px;
        line-height: 32px;
        font-weight: 400;
        color: #234a9b;
    }
</style>

<body>

    @if (($usarPortada ?? true) && in_array($seccionPdf ?? 'completo', ['completo', 'inicio']))

        @if ($esCotizacionUnificada)
            <div class="cover2-page">
                <div class="cover2-bg"></div>

                <div class="cover2-title-wrap">
                    @if ($tituloLinea1)
                        <div class="cover2-title-dark">
                            {{ strtoupper($tituloLinea1) }}
                        </div>
                    @endif

                    @if ($tituloLinea2)
                        <div class="cover2-title-light">
                            {{ strtoupper($tituloLinea2) }}
                        </div>
                    @endif
                </div>

                <div class="cover2-subtitle-box">
                    {{ $subtituloPortada }}
                </div>

                {{-- SOLO el nombre del cliente abajo, porque el "Cliente:" ya viene en la imagen base --}}
                <div class="cover2-client-name">
                    {{ strtoupper($clientePortada) }}
                </div>
            </div>

            {{-- <div class="page-break"></div> --}}
        @else
            <div class="cover1-page">
                <div class="cover1-bg"></div>

                <div class="cover1-title">
                    {!! nl2br(e($cover1Titulo)) !!}
                </div>

                @if ($cover1OS)
                    <div class="cover1-os">
                        {{ strtoupper($cover1OS) }}
                    </div>
                @endif

                @if ($cover1EquipoDescripcion)
                    <div class="cover1-equipo">
                        {{ $cover1EquipoDescripcion }}
                    </div>
                @endif

                @if ($cover1Cliente)
                    <div class="cover1-cliente">
                        {{ $cover1Cliente }}
                    </div>
                @endif
                @if ($coverNumeroCotizacion)
                    <div class="cover1-cotizacion-numero">
                        {{ $coverNumeroCotizacion }}
                    </div>
                @endif

                @if ($coverNumeroRequerimiento)
                    <div class="cover1-req-numero">
                        Req: {{ $coverNumeroRequerimiento }}
                    </div>
                @endif

                @if ($cover1FotoUrl)
                    <div class="cover1-foto-wrap" style="background-image: url('{{ $cover1FotoUrl }}');">
                    </div>
                @endif
            </div>

            {{--   <div class="page-break"></div> --}}
        @endif

    @endif



    @if (($usarCartaPresentacion ?? true) && in_array($seccionPdf ?? 'completo', ['completo', 'inicio']))
        <div class="page-letter">

            @if (file_exists($logoPath))
                <img src="{{ $logoUrl }}" class="letter-logo" alt="CME">
            @endif

            @if (file_exists($wegPath))
                <img src="{{ $wegUrl }}" class="letter-weg" alt="WEG">
            @endif

            @if (file_exists($easaPath))
                <img src="{{ $easaUrl }}" class="letter-easa" alt="EASA">
            @endif

            <div class="letter-slogan-box">
                Soluciones Electromecánicas de alta confiabilidad
            </div>

            <div class="letter-date">
                {{ strtoupper($fechaCartaTexto) }}
            </div>

            <div class="letter-client">
                <div>Señores</div>

                <div class="cliente-nombre">
                    {{ $clienteNombre }}
                </div>

                @if ($nombreContacto)
                    <div>
                        {{ $nombreContacto }}
                        @if ($puestoContacto)
                            - {{ $puestoContacto }}
                        @endif
                        @if ($emailContacto)
                            [{{ $emailContacto }}]
                        @endif
                    </div>
                @endif

                <br>

                @if ($razonSocial)
                    <div>{{ $razonSocial }}</div>
                @endif

                @if ($direccionFiscal)
                    <div>{{ $direccionFiscal }}</div>
                @endif

                @if ($paisCliente)
                    <div>{{ $paisCliente }}</div>
                @endif

                @if ($nitCliente)
                    <div>Nit: {{ $nitCliente }}</div>
                @endif
            </div>

            <div class="letter-body">
                {!! $textoPresentacion !!}
            </div>

            <div class="letter-signature">
                <div class="saludo">
                    Muy atentamente,
                </div>

                <div class="firma-cotizacion">
                    <div class="firma-nombre">
                        {{ $firmante['nombre'] ?? '' }}
                    </div>

                    <div class="firma-cargo">
                        {{ $firmante['cargo'] ?? '' }}
                    </div>

                    @if (!empty($firmante['email']))
                        <div class="firma-linea">
                            <span class="firma-label">E-mail:</span>
                            <a class="firma-email" href="mailto:{{ trim($firmante['email']) }}">
                                {{ trim($firmante['email']) }}
                            </a>
                        </div>
                    @endif

                    @if (!empty($firmante['celular']))
                        <div class="firma-linea">
                            <span class="firma-label">Celular:</span>
                            <span class="firma-valor">{{ $firmante['celular'] }}</span>
                        </div>
                    @endif

                    @if (!empty($firmante['oficina']))
                        <div class="firma-linea">
                            <span class="firma-label">Oficina:</span>
                            <span class="firma-valor">{{ $firmante['oficina'] }}</span>
                        </div>
                    @endif

                    @if (!empty($firmante['fax']))
                        <div class="firma-linea">
                            <span class="firma-label">Fax:</span>
                            <span class="firma-valor">{{ $firmante['fax'] }}</span>
                        </div>
                    @endif

                    @if (!empty($firmante['web']))
                        <div class="firma-linea">
                            <span class="firma-label">Web:</span>
                            <span class="firma-valor">{{ $firmante['web'] }}</span>
                        </div>
                    @endif

                    <div class="firma-direccion">
                        @if (!empty($firmante['direccion_linea_1']))
                            <div>{{ $firmante['direccion_linea_1'] }}</div>
                        @endif

                        @if (!empty($firmante['direccion_linea_2']))
                            <div>{{ $firmante['direccion_linea_2'] }}</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

    @endif


    @if (in_array($seccionPdf, ['completo', 'items']))
        <div class="page-items">

            <table class="items-table">
                <thead>
                    <tr>
                        <th colspan="5" class="items-header-cell">
                            <div class="items-pdf-header">

                                <table class="items-logos-table">
                                    <tr>
                                        <td class="items-logo-cme-cell">
                                            @if (file_exists($logoPath))
                                                <img src="{{ $logoPath }}" class="items-logo-cme" alt="CME">
                                            @endif

                                            <div class="items-slogan-box">
                                                Soluciones Electromecánicas de alta confiabilidad
                                            </div>
                                        </td>

                                        <td class="items-logo-certificaciones-cell">
                                            @if (file_exists($wegPath))
                                                <img src="{{ $wegPath }}" class="items-logo-weg" alt="WEG">
                                            @endif

                                            @if (file_exists($easaPath))
                                                <img src="{{ $easaPath }}" class="items-logo-easa" alt="EASA">
                                            @endif
                                        </td>
                                    </tr>
                                </table>

                                <div class="items-title">
                                    DETALLE DE TRABAJOS Y MATERIALES COTIZADOS
                                </div>

                                <div class="items-info-card">
                                    <table class="items-info-table">
                                        <tr>
                                            <td class="label">Cotización:</td>
                                            <td class="value">{{ $cotizacion->numero }}</td>

                                            <td class="label">Cliente:</td>
                                            <td class="value">{{ $clienteNombre }}</td>
                                        </tr>

                                        @if ($motor)
                                            <tr>
                                                <td class="label">OS:</td>
                                                <td class="value">
                                                    {{ $motor->fullos ?? ($motor->year ?? '') . '-' . ($motor->os ?? '') }}
                                                </td>

                                                <td class="label">Equipo:</td>
                                                <td class="value">{{ $nombreEquipo }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>

                            </div>
                        </th>
                    </tr>

                    <tr class="items-columns">
                        <th class="item-numero">No. Item</th>
                        <th class="item-descripcion">Descripción</th>
                        <th class="item-cantidad">Cantidad</th>
                        <th class="item-precio">Precio Unitario</th>
                        <th class="item-total">Precio Total</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($esCotizacionAgrupada)

                        @forelse($gruposItemsPdf as $grupo)
                            <tr class="unified-group-row">
                                <td colspan="5">
                                    <div class="unified-group-header">
                                        <div>
                                            <div class="unified-group-title">
                                                {{ $grupo['titulo'] }}
                                            </div>
                                            @if ($esCotizacionExcel && !empty($grupo['descripcion_tecnica']))
                                                <div style="font-size: 10px; font-weight: normal; margin-top: 2px;">
                                                    {{ $grupo['descripcion_tecnica'] }}
                                                </div>
                                            @endif
                                            @if (!$esCotizacionExcel && !empty($grupo['numero_origen']))
                                                <div style="font-size: 10px; font-weight: normal; margin-top: 2px;">
                                                    Cotización origen: {{ $grupo['numero_origen'] }}
                                                </div>
                                            @endif
                                            <div class="unified-group-subtitle">
                                                @if ($grupo['numero_origen'])
                                                    Cotización origen: {{ $grupo['numero_origen'] }}
                                                @endif

                                                @if ($grupo['equipo'])
                                                    &nbsp; | &nbsp; {{ $grupo['equipo'] }}
                                                @endif

                                                @if ($grupo['potencia'])
                                                    &nbsp; | &nbsp; {{ $grupo['potencia'] }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @forelse($grupo['items'] as $item)
                                @php
                                    $precioTotal = (float) ($item->precio_total ?? 0);
                                    $precioUnitario = (float) ($item->precio_unitario ?? 0);
                                    $esDescuento = $precioTotal < 0;
                                @endphp

                                <tr>
                                    <td class="item-numero">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="item-descripcion">
                                        <div class="item-nombre {{ $esDescuento ? 'item-descuento' : '' }}">
                                            {{ $item->nombre }}
                                        </div>

                                        @if ($item->descripcion)
                                            <div class="item-detalle">
                                                {{ $item->descripcion }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="item-cantidad">
                                        {{ number_format((float) $item->cantidad, 2) }}
                                    </td>

                                    <td class="item-precio {{ $esDescuento ? 'item-descuento' : '' }}">
                                        {{ $formatoMoneda($precioUnitario) }}
                                    </td>

                                    <td class="item-total {{ $esDescuento ? 'item-descuento' : '' }}">
                                        {{ $formatoMoneda($precioTotal) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No hay ítems registrados para este equipo.
                                    </td>
                                </tr>
                            @endforelse

                            <tr class="unified-subtotal-row">
                                <td colspan="4">
                                    Subtotal
                                    {{ $esCotizacionExcel ? $grupo['equipo'] ?? $grupo['titulo'] : $grupo['titulo'] }}
                                </td>

                                <td>
                                    {{ $formatoMoneda($grupo['subtotal']) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px;">
                                    No hay grupos registrados en esta cotización unificada.
                                </td>
                            </tr>
                        @endforelse
                    @else
                        @forelse($itemsCotizacion as $item)
                            @php
                                $precioTotal = (float) ($item->precio_total ?? 0);
                                $precioUnitario = (float) ($item->precio_unitario ?? 0);
                                $esDescuento = $precioTotal < 0;
                            @endphp

                            <tr>
                                <td class="item-numero">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="item-descripcion">
                                    <div class="item-nombre {{ $esDescuento ? 'item-descuento' : '' }}">
                                        {{ $item->nombre }}
                                    </div>

                                    @if ($item->descripcion)
                                        <div class="item-detalle">
                                            {{ $item->descripcion }}
                                        </div>
                                    @endif
                                </td>

                                <td class="item-cantidad">
                                    {{ number_format((float) $item->cantidad, 2) }}
                                </td>

                                <td class="item-precio {{ $esDescuento ? 'item-descuento' : '' }}">
                                    {{ $formatoMoneda($precioUnitario) }}
                                </td>

                                <td class="item-total {{ $esDescuento ? 'item-descuento' : '' }}">
                                    {{ $formatoMoneda($precioTotal) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 20px;">
                                    No hay ítems registrados en esta cotización.
                                </td>
                            </tr>
                        @endforelse

                    @endif
                </tbody>
            </table>

            <div class="items-total-box">
                <table class="items-total-table">
                    <tr class="items-grand-total">
                        <td>
                            {{ $mostrarDesgloseIva
                                ? ($esCotizacionAgrupada
                                    ? 'Total general (IVA incluido)'
                                    : 'Total (IVA incluido)')
                                : ($esCotizacionAgrupada
                                    ? 'Total general'
                                    : 'Total') }}
                        </td>

                        <td class="items-total-value">
                            {{ $formatoMoneda($totalCotizacion) }}
                        </td>
                    </tr>
                </table>
                @if ($mostrarDesgloseIva)
                    <table class="items-iva-table">
                        <tr class="items-iva-title">
                            <td colspan="2">
                                Desglose de IVA
                            </td>
                        </tr>

                        <tr>
                            <td class="items-iva-label">
                                Precio sin IVA
                            </td>

                            <td class="items-iva-value">
                                {{ $formatoMoneda($precioSinIva) }}
                            </td>
                        </tr>

                        <tr>
                            <td class="items-iva-label">
                                IVA 12%
                            </td>

                            <td class="items-iva-value">
                                {{ $formatoMoneda($valorIva) }}
                            </td>
                        </tr>
                    </table>
                @endif

                @if ($mostrarConversionUsd)
                    <table class="items-total-table" style="margin-top: 8px;">
                        <tr>
                            <td class="items-total-label">
                                Tipo de cambio
                            </td>
                            <td class="items-total-value">
                                Q{{ number_format($tipoCambio, 4) }} x 1 USD
                            </td>
                        </tr>

                        <tr>
                            <td class="items-total-label">
                                Total USD
                            </td>
                            <td class="items-total-value">
                                ${{ number_format($totalCotizacion / $tipoCambio, 2) }}
                            </td>
                        </tr>
                    </table>
                @endif
            </div>


        </div> {{-- cierre de page-items --}}
        <div class="page-break"></div>

        <div class="page-extra">

            <div class="extra-header">
                <table class="extra-logos-table">
                    <tr>
                        <td class="extra-logo-cme-cell">
                            @if (file_exists($logoPath))
                                <img src="{{ $logoPath }}" class="extra-logo-cme" alt="CME">
                            @endif

                            <div class="extra-slogan-box">
                                Soluciones Electromecánicas de alta confiabilidad
                            </div>
                        </td>

                        <td class="extra-logo-certificaciones-cell">
                            @if (file_exists($wegPath))
                                <img src="{{ $wegPath }}" class="extra-logo-weg" alt="WEG">
                            @endif

                            @if (file_exists($easaPath))
                                <img src="{{ $easaPath }}" class="extra-logo-easa" alt="EASA">
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="pdf-extra-info">
                <div class="pdf-extra-title">
                    Información adicional de la cotización
                </div>

                <div class="pdf-extra-grid">

                    {{-- QUÉ NO INCLUYE --}}
                    <div class="pdf-extra-section">
                        <div class="pdf-section-heading">
                            Qué no incluye
                        </div>

                        @if (count($noIncluyeItems) > 0)
                            <ul class="pdf-list">
                                @foreach ($noIncluyeItems as $itemNoIncluye)
                                    <li>{{ $itemNoIncluye }}</li>
                                @endforeach
                            </ul>
                        @else
                            <div class="pdf-empty-text">
                                No se especificaron exclusiones para esta cotización.
                            </div>
                        @endif
                    </div>

                    {{-- TIEMPO DE ENTREGA --}}
                    <div class="pdf-extra-section">
                        <div class="pdf-section-heading">
                            Tiempo de entrega
                        </div>

                        <table class="pdf-info-table">
                            <tr>
                                <td class="label">Tiempo estimado</td>
                                <td class="value">{{ $tiempoEntregaTexto }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- GARANTÍA --}}
                    <div class="pdf-extra-section">
                        <div class="pdf-section-heading">
                            Garantía
                        </div>

                        <table class="pdf-info-table">
                            <tr>
                                <td class="label">Condición</td>
                                <td class="value">{{ $garantiaTexto }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- TÉRMINOS DE PAGO --}}
                    <div class="pdf-extra-section">
                        <div class="pdf-section-heading">
                            Términos de pago
                        </div>

                        <table class="pdf-info-table">
                            <tr>
                                <td class="label">Forma de pago</td>
                                <td class="value">{{ $terminosPagoTexto }}</td>
                            </tr>

                            <tr>
                                <td class="label">Orden de compra</td>
                                <td class="value">
                                    @if ($cotizacion->cliente_debe_proveer_oc)
                                        El cliente debe proveer orden de compra para iniciar trabajos.
                                    @else
                                        No se indicó requerimiento de orden de compra para iniciar trabajos.
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>

                    {{-- NOTAS ADICIONALES --}}
                    @if (!empty($notasAdicionales))
                        <div class="pdf-extra-section">
                            <div class="pdf-section-heading">
                                Notas adicionales
                            </div>

                            <div class="pdf-notas">
                                {!! $notasAdicionales !!}
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @endif
    @if (in_array($seccionPdf, ['completo', 'terminos']) && $cotizacion->incluir_terminos_garantias)
        @if ($cotizacion->incluir_terminos_garantias)
            <div class="page-break"></div>

            <div class="page-terms">
                @include('pdfs.cotizaciones.partials.terminos-header')

                <div class="terms-content">
                    @include('pdfs.cotizaciones.partials.terminos-cotizacion-parte1')
                </div>
            </div>

            <div class="page-break"></div>

            <div class="page-terms">
                @include('pdfs.cotizaciones.partials.terminos-header')

                <div class="terms-content">
                    @include('pdfs.cotizaciones.partials.terminos-cotizacion-parte2')
                </div>
            </div>
        @endif
    @endif
</body>

</html>
