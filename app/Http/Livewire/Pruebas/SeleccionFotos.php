<?php

namespace App\Http\Livewire\Pruebas;

use App\Models\Foto;
use App\Models\Motor;
use App\Models\TipoFoto;
use Livewire\Component;

class SeleccionFotos extends Component
{
    public $motor;
    public $titulos = []; // foto_id => titulo
    public $tipos_foto = []; // todos los tipos disponibles
    public $fotoTipos = []; // foto_id => type

    protected $listeners = [
        'save-all-titulos' => 'saveAllTitulos',
        'borrarFoto' => 'borrarFoto',
    ];


    public function mount(Motor $motor)
    {

        $this->motor = $motor->load('fotos');
        $this->tipos_foto = TipoFoto::all()->pluck('type', 'id')->toArray();

        foreach ($this->motor->fotos as $f) {
            $this->titulos[$f->id] = $f->titulo ?? '';
            $this->fotoTipos[$f->id] = $f->type ?? null;
        }
    }
    public function render()
    {
        return view('livewire.pruebas.seleccion-fotos');
    }
    public function toggleAddToReport($fotoId)
    {
        $foto = Foto::findOrFail($fotoId);

        // (opcional) Autoriza que la foto pertenezca a este motor
        if ($foto->id_motor !== $this->motor->id_motor) {
            abort(403);
        }

        $foto->addToReport = $foto->addToReport ? 0 : 1;
        $foto->save();

        // Recarga la relación para reflejar el cambio en la vista
        $this->motor->load('fotos');
    }
    public function saveTitulo($fotoId)
    {
        if (!array_key_exists($fotoId, $this->titulos)) return;

        $foto = Foto::find($fotoId);
        if (!$foto || $foto->id_motor !== $this->motor->id_motor) return;

        // opcional: validación básica
        $value = trim((string) $this->titulos[$fotoId]);
        $value = mb_substr($value, 0, 191); // si tu columna es varchar(191)

        $foto->titulo = $value;
        $foto->save();

        // refresca relación por si usas los datos en otros lados
        $this->motor->load('fotos');
    }

    public function saveAllTitulos()
    {
        // guarda en lote lo que esté en $this->titulos
        foreach ($this->titulos as $fotoId => $value) {
            $foto = Foto::find($fotoId);
            if (!$foto || $foto->id_motor !== $this->motor->id_motor) continue;

            $value = trim((string) $value);
            $value = mb_substr($value, 0, 191);

            if ($foto->titulo !== $value) {
                $foto->titulo = $value;
                $foto->save();
            }
        }
        $this->motor->load('fotos');
    }
    public function updateTipo($fotoId)
    {
        if (!array_key_exists($fotoId, $this->fotoTipos)) return;

        $foto = Foto::find($fotoId);
        if (!$foto || $foto->id_motor !== $this->motor->id_motor) return;

        $foto->type = $this->fotoTipos[$fotoId];
        $foto->save();

        $this->motor->load('fotos');
    }
    public function borrarFoto($fotoId)
    {
        $foto = Foto::find($fotoId);
        if (!$foto || $foto->id_motor !== $this->motor->id_motor) return;

        // Borra archivo físico si quieres
        if ($foto->ruta && file_exists(public_path('storage/' . $foto->ruta))) {
            unlink(public_path('storage/' . $foto->ruta));
        }

        $foto->delete();

        $this->motor->load('fotos');

        $this->emit('fotoBorrada');
    }
}
