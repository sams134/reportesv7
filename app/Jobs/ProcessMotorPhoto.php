<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Models\Motor;

class ProcessMotorPhoto implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $tempPath,
        public string $originalName,
        public int $motorId,
        public int $userId,
    ){}

    public function handle(): void
    {
        $motor = Motor::findOrFail($this->motorId);

        // Procesar imagen
        $image = Image::make($this->tempPath)->orientate();
        $image->resize(2048, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        $extension  = pathinfo($this->originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid('img_', true).'.'.$extension;
        $folder     = "/uploads/{$motor->fullos}/Fotos/Proceso";
        $path       = "$folder/$uniqueName";

        Storage::disk('public')->put($path, (string) $image->encode());

        // Guardar en BD
        $motor->fotos()->create([
            'titulo'   => $uniqueName,
            'foto'     => $path,
            'thumb'    => $path, // si creas miniaturas reales, cámbialo
            'type'     => 2,
            'user_id'  => $this->userId,
        ]);
    }
}
?>