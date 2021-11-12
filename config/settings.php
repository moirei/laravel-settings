<?php

use MOIREI\Fields\Inputs\Boolean;

return [

    /*
    |--------------------------------------------------------------------------
    | Default settings configuration
    |--------------------------------------------------------------------------
    |
    */

    'defaults' => [
        'users' => [
            'notifications.enable' => Boolean::make('Enable notification')->default(false),
        ],

        'stores' => [
            'notifications.enable' => Boolean::make('Enable notification')->default(false),
        ],
    ],

];
