<?php

namespace App\Http\Livewire\Balanceo;

use App\Models\Balanceo;
use App\Models\BalanceoArt;
use App\Models\Motor;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBalanceo extends Component
{
    use WithFileUploads;
    public Motor $motor;
    public $editing = false;
    public $artes = [], $lines = [];
    public $art_id = null, $informeBalanceoFile = null; // Inicializa la variable art_id
    public $selected_art = "", $reading_error = 0, $comments = "", $item_weight = "";

    //campos db
    public $dateText = "", $service_speed = "", $balancing_speed = "", $grade = "", $gin_initial_right = "", $gin_initial_left = "";
    public $gin_final_right = "", $gin_final_left = "";
    public $key_drive_wide = "", $key_drive_thick = "", $key_drive_length = "";
    public $key_rear_wide = "", $key_rear_thick = "", $key_rear_length = "";
    public $runs = 2;
    public $milsInitialLeft = 0, $milsInitialRight = 0, $milsFinalLeft = 0, $milsFinalRight = 0;   // mils inicial y final. Guardados por separado para colocarlos al inicio y al final $milsLeft etc
    public $angleInitialLeft = 0, $angleInitialRight = 0, $angleFinalLeft = 0, $angleFinalRight = 0;
    public $milsLeft = [], $milsRight = [], $angleLeft = [], $angleRight = [];
    public $left_radius = "", $right_radius = "", $dimensionA = "", $dimensionB = "";
    public $milTolerance = 0.3;

    protected $listeners = ['artCreated' => 'updateArtGallery'];

    protected $rules = [
        'dateText' => 'required',
        'service_speed' => 'required',
        'balancing_speed' => 'required',
        'grade' => 'required',
        'gin_initial_right' => 'required',
        'gin_initial_left' => 'required',
        'gin_final_right' => 'required',
        'gin_final_left' => 'required',
        'milsLeft' => 'required',
        'milsRight' => 'required',
        'angleLeft' => 'required',
        'angleRight' => 'required',
        'left_radius' => 'required',
        'right_radius' => 'required',
        'dimensionA' => 'required',
        'dimensionB' => 'required',
        'art_id' => 'required',
        'item_weight' => 'required',
    ];

    public function mount(Motor $motor)
    {
        
        $this->motor = $motor;
        if ($this->motor->balanceo()->exists()) {
            $this->editing = true;
            $this->art_id = $this->motor->balanceo->balanceos_arts_id;
            $this->dateText = $this->motor->balanceo->date;
            $this->service_speed = $this->motor->balanceo->service_speed;
            $this->comments = $this->motor->balanceo->comments;
            $this->balancing_speed = $this->motor->balanceo->balancing_speed;
            $this->left_radius = $this->motor->balanceo->left_radius;
            $this->right_radius = $this->motor->balanceo->right_radius;
            $this->dimensionA = $this->motor->balanceo->dimensionA;
            $this->dimensionB = $this->motor->balanceo->dimensionB;
            $this->gin_initial_right = $this->motor->balanceo->gin_initial_right;
            $this->gin_initial_left = $this->motor->balanceo->gin_initial_left;
            $this->gin_final_right = $this->motor->balanceo->gin_final_right;
            $this->gin_final_left = $this->motor->balanceo->gin_final_left;
            $this->key_drive_wide = $this->motor->balanceo->key_drive_wide;
            $this->key_drive_thick = $this->motor->balanceo->key_drive_thick;
            $this->key_drive_length = $this->motor->balanceo->key_drive_long;
            $this->key_rear_wide = $this->motor->balanceo->key_rear_wide;
            $this->key_rear_thick = $this->motor->balanceo->key_rear_thick;
            $this->key_rear_length = $this->motor->balanceo->key_rear_long;
            $this->grade = $this->motor->balanceo->grade;
            $this->item_weight = $this->motor->balanceo->item_weight;
            $this->runs = $this->motor->balanceo->balanceoSteps->count();
            $this->milsLeft = $this->motor->balanceo->balanceoSteps->pluck('mils_left')->toArray();
            $this->milsRight = $this->motor->balanceo->balanceoSteps->pluck('mils_right')->toArray();
            $this->angleLeft = $this->motor->balanceo->balanceoSteps->pluck('angle_left')->toArray();
            $this->angleRight = $this->motor->balanceo->balanceoSteps->pluck('angle_right')->toArray();

            $this->milsInitialLeft = $this->milsLeft[0];
            $this->milsInitialRight = $this->milsRight[0];
            $this->milsFinalLeft = $this->milsLeft[$this->runs - 1];
            $this->milsFinalRight = $this->milsRight[$this->runs - 1];

            $this->angleInitialLeft = $this->angleLeft[0];
            $this->angleInitialRight = $this->angleRight[0];
            $this->angleFinalLeft = $this->angleLeft[$this->runs - 1];
            $this->angleFinalRight = $this->angleRight[$this->runs - 1];

        }
        $this->updateArtGallery();
    }
    public function selectImage($id)
    {
        $this->art_id = $id; // Actualiza el art_id cuando se hace clic en una imagen
    }

    public function updateArtGallery()
    {
        $this->artes = BalanceoArt::orderBy('id', 'desc')->get();
    }
    public function updatedInformeBalanceoFile()
    {
        $this->validate([
            'informeBalanceoFile' => 'file|max:1024',
        ]);


        $fileContent = file_get_contents($this->informeBalanceoFile->getRealPath());


        $this->extractDate($fileContent);
        $this->extractSpeed($fileContent);
        $this->extractBalancingSpeed($fileContent);
        $this->extractComments($fileContent);
        $this->extractWeight($fileContent);
        $this->extractGrade($fileContent);
        $this->extractUnbalance($fileContent);
        $this->extractResidualUnbalance($fileContent);
        $this->extractDriveKeyDimensions($fileContent);
        $this->extractRearKeyDimensions($fileContent);
        $this->extractMils($fileContent);
        $this->insertBalancingData();
    }

    public function updatedRuns()
    {
        $this->insertBalancingData();
        $this->render();
    }
    // Función que extrae la fecha después de "Date:"
    private function extractDate($content)
    {
        $datePosition = strpos($content, 'Date:');
        if ($datePosition !== false) {
            $dateString = trim(substr($content, $datePosition + 5, 10)); // La fecha tiene 10 caracteres
            $this->dateText = $dateString . " ";
        } else {
            $this->reading_error = 1;
        }


        $datePosition = strpos($content, 'Time:');
        if ($datePosition !== false) {
            $dateString = trim(substr($content, $datePosition + 5, 12)); // La hora tiene 10 caracteres
            $this->dateText .= $dateString;
        } else {
            $this->reading_error = 1;
        }
    }

    // Función para extraer la velocidad después de "Item operating speed:"
    private function extractSpeed($content)
    {

        $speedPosition = strpos($content, 'Item operating speed:');
        if ($speedPosition !== false) {

            $speedLine = trim(substr($content, $speedPosition + 22)); // 22 es el tamaño de "Item operating speed:"
            preg_match('/\d+(\.\d+)?/', $speedLine, $matches); // Extrae el número (incluyendo decimales si los hay)

            if (!empty($matches)) {
                $this->service_speed = $matches[0]; // Asigna el número encontrado
            }
        } else {
            $this->reading_error = 1;
        }
    }
    private function extractBalancingSpeed($content)
    {
        // Busca la cadena "Balancing RPM:"
        $rpmPosition = strpos($content, 'Balancing RPM:');

        if ($rpmPosition !== false) {
            // Extrae el texto después de "Balancing RPM:"
            $rpmLine = trim(substr($content, $rpmPosition + 15)); // 15 es el tamaño de "Balancing RPM:"

            // Se espera que el número esté al principio de la línea
            preg_match('/\d+(\.\d+)?/', $rpmLine, $matches); // Extrae el número (incluyendo decimales si los hay)

            if (!empty($matches)) {
                $this->balancing_speed = $matches[0]; // Asigna el número encontrado
            }
        } else {
            $this->reading_error = 1;
        }
    }
    private function extractComments($content)
    {
        // Busca la cadena "Item balanced:"
        $commentsPosition = strpos($content, 'Item balanced:');

        if ($commentsPosition !== false) {
            // Extrae el texto después de "Item balanced:"
            $commentsLine = trim(substr($content, $commentsPosition + 14)); // 14 es el tamaño de "Item balanced:"

            // Busca la cadena "Balancing specification" para terminar de leer los comentarios
            $balancingSpecPosition = strpos($commentsLine, 'Balancing specification');

            // Si se encuentra "Balancing specification", corta el comentario antes de esa línea
            if ($balancingSpecPosition !== false) {
                $commentsLine = substr($commentsLine, 0, $balancingSpecPosition); // Corta antes de "Balancing specification"
            }

            $this->comments = trim($commentsLine); // Asigna el texto encontrado
        } else {
            $this->reading_error = 1;
        }
    }
    private function extractWeight($content)
    {
        // Busca la cadena "Item weight:"
        $weightPosition = strpos($content, 'Item weight:');

        if ($weightPosition !== false) {
            // Extrae el texto después de "Item weight:"
            $weightLine = trim(substr($content, $weightPosition + 12)); // 12 es el tamaño de "Item weight:"

            // Se espera que el número esté antes de " lb", así que lo extraemos
            preg_match('/\d+(\.\d+)?/', $weightLine, $matches); // Extrae el número (incluyendo decimales si los hay)

            if (!empty($matches)) {
                $this->item_weight = $matches[0]; // Asigna el número encontrado
            }
        } else {
            $this->reading_error = 1;
        }
    }
    private function extractGrade($content)
    {
        // Busca la cadena "Balancing grade:"
        $gradePosition = strpos($content, 'Balancing grade:');

        if ($gradePosition !== false) {
            // Extrae el texto después de "Balancing grade:"
            $gradeLine = trim(substr($content, $gradePosition + 16)); // 16 es el tamaño de "Balancing grade:"

            // Se espera que el número esté al principio de la línea
            preg_match('/\d+(\.\d+)?/', $gradeLine, $matches); // Extrae el número (incluyendo decimales si los hay)

            if (!empty($matches)) {
                $this->grade = $matches[0]; // Asigna el número encontrado
            }
        } else {
            $this->reading_error = 1;
        }
    }
    private function extractUnbalance($content)
    {
        // Busca la cadena "Beginning unbalance:"
        $content = explode('Beginning unbalance: ', $content)[1];
        $content = explode('Residual unbalance:', $content)[0];
        $content = explode(' ', $content);
        $gin = [];
        foreach ($content as $index => $word) {
            if (strpos($word, 'g-in,') !== false) {
                $gin[] = $content[$index - 1];
            }
        }
        $this->gin_initial_right = $gin[0];
        $this->gin_initial_left = $gin[1];
    }
    private function extractResidualUnbalance($content)
    {
        // Busca la cadena "Beginning unbalance:"
        $content = explode('Residual unbalance: ', $content)[1];
        $content = explode('This item is balanced to:', $content)[0];
        $content = explode(' ', $content);
        $gin = [];
        foreach ($content as $index => $word) {
            if (strpos($word, 'g,') !== false) {
                $gin[] = $content[$index - 1];
            }
        }
        $this->gin_final_right = $gin[0];
        $this->gin_final_left = $gin[1];
    }
    public function extractDriveKeyDimensions($content)
    {
        $content = explode('Drive End: ', $content)[1];
        $content = explode('long', $content)[0];
        $content = explode(' ', $content);
        $gin = [];
        foreach ($content as $index => $word) {
            if (strpos($word, 'in') !== false) {
                $gin[] = $content[$index - 1];
            }
        }
        $this->key_drive_wide = $gin[0];
        $this->key_drive_thick = $gin[1];
        $this->key_drive_length = $gin[2];
    }
    public function extractRearKeyDimensions($content)
    {
        $content = explode('Rear End: ', $content)[1];
        $content = explode('long', $content)[0];
        $content = explode(' ', $content);
        $gin = [];
        foreach ($content as $index => $word) {
            if (strpos($word, 'in') !== false) {
                $gin[] = $content[$index - 1];
            }
        }
        $this->key_rear_wide = $gin[0];
        $this->key_rear_thick = $gin[1];
        $this->key_rear_length = $gin[2];
    }
    public function extractMils($content)
    {
        $content = explode('Right End ', $content)[1];
        $content = explode('Beginning unbalance:', $content)[0];
        $content = explode(' ', $content);
        //dd($content);
        $mils = [];
        foreach ($content as $index => $word) {
            if (strpos($word, 'Mils:') !== false) {
                $mils[] = (float) $content[$index + 3];
            }
        }
        $angles = [];
        $flag = false;
        foreach ($content as $index => $word) {

            if (($flag) && ($content[$index] !== "")) {
                $angles[] = (float)$content[$index];
                $flag = false;
            }
            if (strpos($word, 'Angle:') !== false) {
                $flag = true;
            }
        }
        $this->milsInitialRight = $mils[0];
        $this->milsInitialLeft = $mils[2];
        $this->milsFinalRight = $mils[1];
        $this->milsFinalLeft = $mils[3];

        $this->angleInitialRight = $angles[0];
        $this->angleInitialLeft = $angles[2];
        $this->angleFinalRight = $angles[1];
        $this->angleFinalLeft = $angles[3];
    }


    public function insertBalancingData()
    {
        // Inicializa los arrays con el número de posiciones especificado por $runs
        $this->milsLeft = array_fill(0, $this->runs, 0);
        $this->milsRight = array_fill(0, $this->runs, 0);
        $this->angleLeft = array_fill(0, $this->runs, 0);
        $this->angleRight = array_fill(0, $this->runs, 0);

        // Asigna los valores iniciales y finales a las posiciones correspondientes
        $this->milsLeft[0] = $this->milsInitialLeft;
        $this->milsLeft[$this->runs - 1] = $this->milsFinalLeft;

        $this->milsRight[0] = $this->milsInitialRight;
        $this->milsRight[$this->runs - 1] = $this->milsFinalRight;

        $this->angleLeft[0] = $this->angleInitialLeft;
        $this->angleLeft[$this->runs - 1] = $this->angleFinalLeft;

        $this->angleRight[0] = $this->angleInitialRight;
        $this->angleRight[$this->runs - 1] = $this->angleFinalRight;
    }

    public function autofill()
    {
        if ($this->milsInitialRight == 0 && $this->milsInitialLeft == 0) {
            $this->milsInitialLeft = mt_rand(200, 300) / 100;
            $this->milsInitialRight = mt_rand(200, 300) / 100;
            $this->angleInitialLeft = mt_rand(0, 359);
            $this->angleInitialRight = mt_rand(0, 359);

            $this->milsFinalLeft = mt_rand(10, 40) / 100;
            $this->milsFinalRight = mt_rand(10, 40) / 100;
            $this->angleFinalLeft = mt_rand(0, 359);
            $this->angleFinalRight = mt_rand(0, 359);
        }
        $this->insertBalancingData();

        if ($this->runs > 2) {
            for ($i = 1; $i < $this->runs - 1; $i++) {
                $this->milsLeft[$i] = $this->milsInitialLeft + ($this->milsFinalLeft - $this->milsInitialLeft) * ($i / ($this->runs - 1));
                $this->milsRight[$i] = $this->milsInitialRight + ($this->milsFinalRight - $this->milsInitialRight) * ($i / ($this->runs - 1));
                $this->angleLeft[$i] = mt_rand(0, 359);
                $this->angleRight[$i] = mt_rand(0, 359);
            }
        }
    }

    public function saveBalanceo()
    {
        $this->validate();

        $balanceo = Balanceo::create([
            'date' => $this->dateText,
            'service_speed' => number_format((float)$this->service_speed, 3, '.', ''),
            'comments' => $this->comments,
            'balancing_speed' => number_format((float)$this->balancing_speed, 3, '.', ''),
            'left_radius' => number_format((float)$this->left_radius, 3, '.', ''),
            'right_radius' => number_format((float)$this->right_radius, 3, '.', ''),
            'dimensionA' => number_format((float)$this->dimensionA, 3, '.', ''),
            'dimensionB' => number_format((float)$this->dimensionB, 3, '.', ''),
            'gin_initial_right' => number_format((float)$this->gin_initial_right, 3, '.', ''),
            'gin_initial_left' => number_format((float)$this->gin_initial_left, 3, '.', ''),
            'gin_final_right' => number_format((float)$this->gin_final_right, 3, '.', ''),
            'gin_final_left' => number_format((float)$this->gin_final_left, 3, '.', ''),
            'key_drive_wide' => number_format((float)$this->key_drive_wide, 2, '.', ''),
            'key_drive_thick' => number_format((float)$this->key_drive_thick, 2, '.', ''),
            'key_drive_long' => number_format((float)$this->key_drive_length, 2, '.', ''),
            'key_rear_wide' => number_format((float)$this->key_rear_wide, 2, '.', ''),
            'key_rear_thick' => number_format((float)$this->key_rear_thick, 2, '.', ''),
            'key_rear_long' => number_format((float)$this->key_rear_length, 2, '.', ''),
            'grade' => number_format((float)$this->grade, 2, '.', ''),
            'motor_id' => $this->motor->id_motor,
            'item_weight' => number_format((float)$this->item_weight, 2, '.', ''),
            'balanceos_arts_id' => $this->art_id,
            'mil_tolerance' => $this->milTolerance,
        ]);

        foreach ($this->milsLeft as $index => $mils) {
            $balanceo->balanceoSteps()->create([
                'mils_left' => $mils,
                'mils_right' => $this->milsRight[$index],
                'angle_left' => $this->angleLeft[$index],
                'angle_right' => $this->angleRight[$index],
            ]);
        }
        $this->emit('balanceoCreated');
    }

    public function updateBalanceo()
    {
        $this->validate();

        $this->motor->balanceo->update([
            'date' => $this->dateText,
            'service_speed' => number_format((float)$this->service_speed, 3, '.', ''),
            'comments' => $this->comments,
            'balancing_speed' => number_format((float)$this->balancing_speed, 3, '.', ''),
            'left_radius' => number_format((float)$this->left_radius, 3, '.', ''),
            'right_radius' => number_format((float)$this->right_radius, 3, '.', ''),
            'dimensionA' => number_format((float)$this->dimensionA, 3, '.', ''),
            'dimensionB' => number_format((float)$this->dimensionB, 3, '.', ''),
            'gin_initial_right' => number_format((float)$this->gin_initial_right, 3, '.', ''),
            'gin_initial_left' => number_format((float)$this->gin_initial_left, 3, '.', ''),
            'gin_final_right' => number_format((float)$this->gin_final_right, 3, '.', ''),
            'gin_final_left' => number_format((float)$this->gin_final_left, 3, '.', ''),
            'key_drive_wide' => number_format((float)$this->key_drive_wide, 2, '.', ''),
            'key_drive_thick' => number_format((float)$this->key_drive_thick, 2, '.', ''),
            'key_drive_long' => number_format((float)$this->key_drive_length, 2, '.', ''),
            'key_rear_wide' => number_format((float)$this->key_rear_wide, 2, '.', ''),
            'key_rear_thick' => number_format((float)$this->key_rear_thick, 2, '.', ''),
            'key_rear_long' => number_format((float)$this->key_rear_length, 2, '.', ''),
            'grade' => number_format((float)$this->grade, 2, '.', ''),
            'item_weight' => number_format((float)$this->item_weight, 2, '.', ''),
            'balanceos_arts_id' => $this->art_id,
            'mil_tolerance' => $this->milTolerance,
        ]);

        $this->motor->balanceo->balanceoSteps()->delete();
        foreach ($this->milsLeft as $index => $mils) {
            $this->motor->balanceo->balanceoSteps()->create([
                'mils_left' => $mils,
                'mils_right' => $this->milsRight[$index],
                'angle_left' => $this->angleLeft[$index],
                'angle_right' => $this->angleRight[$index],
            ]);
        }
        $this->emit('balanceoUpdated');
    }

    public function viewPdf()
    {
        
        if (!$this->editing)
            $this->saveBalanceo();
        else
            $this->updateBalanceo();

        return redirect()->route('motores.downloadPdfBalanceo', $this->motor);
    }


    public function render()
    {
        if ($this->art_id) {
            $this->selected_art = BalanceoArt::find($this->art_id)->image;
        }
        return view('livewire.balanceo.create-balanceo');
    }
}
