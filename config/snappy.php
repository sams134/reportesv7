<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */

    'pdf' => [
        'enabled'  => true,
        'binary'   => env('WKHTML_PDF_BINARY', '/usr/local/bin/wkhtmltopdf'),
        'timeout'  => 180,       // espera hasta 120s antes de abortar
        'options'  => [
            // tamaño de página carta
            'page-size'      => 'Letter',

            // sin márgenes
            'margin-top'     => '0mm',
            'margin-bottom'  => '0mm',
            'margin-left'    => '0mm',
            'margin-right'   => '0mm',

            // otros ajustes que ya tenías
            'load-error-handling'   => 'ignore',
            'enable-local-file-access' => true,
            'no-stop-slow-scripts'     => true,
            'javascript-delay'         => 5000,

            // si quieres optimizar imágenes:
            'lowquality'    => false,
            'dpi'            => 300,   // usa 300 DPI en lugar del default 96
            'image-dpi'     => 300,
            'image-quality' => 300,
        ],
        'env' => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTML_IMG_BINARY', '/usr/local/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
