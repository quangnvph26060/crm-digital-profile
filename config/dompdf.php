<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Font Directory
    |--------------------------------------------------------------------------
    |
    | Define the font directory for the DomPDF library.
    |
    */

    'font_dir' => storage_path('fonts/'),

    /*
    |--------------------------------------------------------------------------
    | Font Cache Directory
    |--------------------------------------------------------------------------
    |
    | Define the font cache directory for the DomPDF library.
    |
    */

    'font_cache' => storage_path('fonts/'),

    /*
    |--------------------------------------------------------------------------
    | Default Font
    |--------------------------------------------------------------------------
    |
    | Specify the default font to be used for the PDFs.
    |
    */

    'default_font' => 'dejavusans',

    /*
    |--------------------------------------------------------------------------
    | Font Options
    |--------------------------------------------------------------------------
    |
    | Define additional options for the DomPDF font configuration.
    |
    */

    'fonts' => [
        'dejavusans' => [
            'R' => 'DejaVuSans.ttf',
            'B' => 'DejaVuSans-Bold.ttf',
        ],
    ],
];
