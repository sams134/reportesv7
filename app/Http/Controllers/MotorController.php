<?php

namespace App\Http\Controllers;

use App\Models\Motor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class MotorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $motores = Motor::orderBy('year', 'desc')->orderBy('os', 'desc')->paginate(300);
        return view('motores.index', compact('motores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('motores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //


        $imagen =  $request->file('file')->store('public/imagenes');
        $url = Storage::url($imagen);
        echo $url;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function showAndSave(Motor $motor)
    {
        $userId = auth()->id();

        // Verificar si ya existe la combinación motor_id - user_id
        $exists = \App\Models\Look::where('user_id', $userId)
            ->where('motor_id', $motor->id_motor)
            ->exists();

        if ($exists) {
            // Si ya existe, opcionalmente actualizamos el timestamp
            \App\Models\Look::where('user_id', $userId)
                ->where('motor_id', $motor->id_motor)
                ->update(['updated_at' => now()]);
        } else {
            // Contar cuántos registros existen para este usuario
            $count = \App\Models\Look::where('user_id', $userId)->count();

            if ($count < 10) {
                // Si hay menos de 10, creamos un nuevo registro
                \App\Models\Look::create([
                    'motor_id' => $motor->id_motor,
                    'user_id'  => $userId,
                ]);
            } else {
                // Si ya hay 10, actualizamos el registro más antiguo
                $oldest = \App\Models\Look::where('user_id', $userId)
                    ->orderBy('created_at', 'asc')
                    ->first();

                if ($oldest) {
                    $oldest->update([
                        'motor_id' => $motor->id_motor,
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->route('motores.show', $motor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function edit(Motor $motor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motor $motor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Motor  $motor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motor $motor)
    {
        //
    }

    public function downloadPdf(Motor $motor)
    {

        $html = view('motores.contrasenia', compact('motor'))
            ->render();
        $pdf = PDF::loadHTML($html)->setOption('load-error-handling', 'ignore') // Ignora los errores de carga
            ->setOption('enable-local-file-access', true)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('javascript-delay', 5000);
        return $pdf->inline('Contrasenia.pdf');
    }

    public function downloadPdfDensidades(Motor $motor)
    {
        $user = auth()->user();
        $html = view('motores.densidadespdf')->with([
            'motor' => $motor,
            'tecnico' => $user->name,
        ])
            ->render();
        $pdf = PDF::loadHTML($html)->setOption('load-error-handling', 'ignore') // Ignora los errores de carga
            ->setOption('enable-local-file-access', true)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('javascript-delay', 5000);
        return $pdf->inline('densidades.pdf');
    }

    public function downloadPdfBalanceo(Motor $motor)
    {
        $user = auth()->user();

        // Generar la imagen en memoria y obtenerla en base64
        $left_diagram = $this->dibujarDiagrama($motor, "left");
        $right_diagram = $this->dibujarDiagrama($motor, "right");
        

        // Pasar la imagen base64 a la vista
        $html = view('motores.balanceopdf')->with([
            'motor' => $motor,
            'tecnico' => $user->name,
            'left_diagram' => $left_diagram, // Pasamos la imagen como base64
            'right_diagram' => $right_diagram, // Pasamos la imagen como base64
        ])->render();

        // Generar PDF
        $pdf = PDF::loadHTML($html)
            ->setOption('load-error-handling', 'ignore') // Ignorar errores de carga
            ->setOption('enable-local-file-access', true)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('javascript-delay', 5000);

        return $pdf->inline('balanceo.pdf');
    }
    public function downloadPdfMateriales(Motor $motor)
    {
        $user = auth()->user();

        // Pasar la imagen base64 a la vista
        $html = view('motores.materialesPdf')->with([
            'motor' => $motor,
            'tecnico' => $user->name,

        ])->render();

        // Generar PDF
        $pdf = PDF::loadHTML($html)
            ->setOption('load-error-handling', 'ignore') // Ignorar errores de carga
            ->setOption('enable-local-file-access', true)
            ->setOption('no-stop-slow-scripts', true)
            ->setOption('javascript-delay', 5000);

        return $pdf->inline('materiales.pdf');
    }



    public function dibujarDiagrama(Motor $motor, $side = "left")
    {
        // Dimensiones del lienzo
        $width = 600;
        $height = 600;

        // Centro del diagrama
        $cx = $width / 2;
        $cy = $height / 2;

        // Crear la imagen en memoria
        $image = imagecreate($width, $height);

        // Colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 200, 200, 200);
        $red = imagecolorallocate($image, 215, 0, 0);
        $green = imagecolorallocate($image, 0, 95, 0);

        // Definir tolerancia
        $tolerance = $motor->balanceo->mil_tolerance;


        // Dibujar círculos concéntricos
        for ($r = 0; $r <= 250; $r += 25) {
            imageellipse($image, $cx, $cy, $r * 2, $r * 2, $gray);
        }

        // Dibujar líneas cada 30 grados
        for ($theta = 0; $theta < 360; $theta += 30) {
            $angleRad = deg2rad($theta);
            $x2 = $cx + 250 * cos($angleRad);
            $y2 = $cy - 250 * sin($angleRad);
            imageline($image, $cx, $cy, $x2, $y2, $gray);
        }

        // Dibujar ejes principales más gruesos
        imagesetthickness($image, 3);
        imageline($image, $cx, $cy - 250, $cx, $cy + 250, $gray);
        imageline($image, $cx - 250, $cy, $cx + 250, $cy, $gray);
        imagesetthickness($image, 1); // Restaurar grosor

        for ($theta = 0; $theta < 360; $theta++) {
            $angleRad = deg2rad($theta);
            $xOuter = $cx + 250 * cos($angleRad);
            $yOuter = $cy - 250 * sin($angleRad);

            // Definir el tamaño del tick
            $tickLength = ($theta % 5 === 0) ? 10 : 5;
            $xInner = $cx + (250 - $tickLength) * cos($angleRad);
            $yInner = $cy - (250 - $tickLength) * sin($angleRad);
            imageline($image, $xInner, $yInner, $xOuter, $yOuter, $black);

            // Agregar etiquetas de ángulos cada 15°
            if ($theta % 15 === 0) {
                $labelR = 260;
                $xLabel = $cx + $labelR * cos($angleRad);
                $yLabel = $cy - $labelR * sin($angleRad);
                $label = $theta . '°';
                imagestring($image, 2, $xLabel - (strlen($label) * 3), $yLabel - 6, $label, $black);
            }
        }

        // **Dibujar líneas de balanceo con flechas**
        $puntos = [];

        if ($side === "left") {
            foreach ($motor->balanceo->balanceoSteps as $step) {
                $puntos[] = [$step->mils_left, $step->angle_left];
            }
        } else {
            foreach ($motor->balanceo->balanceoSteps as $step) {
                $puntos[] = [$step->mils_right, $step->angle_right];
            }
        }
        $max =
            max(array_merge(
                $motor->balanceo->balanceoSteps->pluck('mils_left')->toArray(),
                $motor->balanceo->balanceoSteps->pluck('mils_right')->toArray()
            ));
        for ($i = 0; $i < count($puntos) - 1; $i++) {
            list($r1, $theta1) = $puntos[$i];
            list($r2, $theta2) = $puntos[$i + 1];

            list($x1, $y1) = $this->polarToCartesian($r1, $theta1, $cx, $cy, $max * 1.2);
            list($x2, $y2) = $this->polarToCartesian($r2, $theta2, $cx, $cy, $max * 1.2);

            // Determinar color (rojo si radio >= tolerancia, verde si < tolerancia)
            $color = ($r2 < $tolerance) ? $green : $red;

            $this->dibujarLineaConFlecha($image, $x1, $y1, $x2, $y2, $color, $color);
        }

        // **Convertir la imagen a base64**
        ob_start();
        imagepng($image);
        $imageData = ob_get_contents();
        ob_end_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }
    // **Función para convertir coordenadas polares a cartesianas**
    function polarToCartesian($r, $theta, $cx, $cy, $max)
    {

        $r = $r * 250 / $max;
        $thetaRad = deg2rad($theta);
        $x = $cx + $r * cos($thetaRad);
        $y = $cy - $r * sin($thetaRad);
        return [$x, $y];
    }
    // **Función para dibujar una línea con una flecha al final**
    function dibujarLineaConFlecha(&$image, $x1, $y1, $x2, $y2, $colorLinea, $colorFlecha)
    {
        imageline($image, $x1, $y1, $x2, $y2, $colorLinea); // Línea principal

        // Calcular la dirección de la flecha
        $angle = atan2($y2 - $y1, $x2 - $x1); // Ángulo de la línea
        $arrowSize = 10; // Tamaño de la flecha

        // Calcular puntos de la flecha (triángulo apuntando en la dirección correcta)
        $xArrow1 = $x2 - $arrowSize * cos($angle + deg2rad(30));
        $yArrow1 = $y2 - $arrowSize * sin($angle + deg2rad(30));

        $xArrow2 = $x2 - $arrowSize * cos($angle - deg2rad(30));
        $yArrow2 = $y2 - $arrowSize * sin($angle - deg2rad(30));

        // Dibujar flecha como un triángulo
        imagefilledpolygon($image, [$x2, $y2, $xArrow1, $yArrow1, $xArrow2, $yArrow2], 3, $colorFlecha);
    }
}
