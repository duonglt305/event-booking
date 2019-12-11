<?php
return [
    'client_id' => 'AS_VJ8gHDqG9wKJhgrzyYvZvYWwnfAGOmjYEzPP8iPJNhC4zm64i3w3cjnbbz88oVMSxm-OUiyWs-n8r',
    'secret' =>  'EF2b_mkyVJompwK0RqD5_rdrv-LZA-XOL7mEdtnHBlRnolpFEnHsk_j-9q3Fm3pSqmdV9E6WkqZeq-A5',
    'settings' => [
        'mode' => env('PAYPAL_MODE'),
        'http.ConnectionTimeOut' => 30,
        'log.logEnabled' => true,
        'log.FileName' => storage_path() . '/logs/paypal.log',
        'log.LogLevel' => 'FINE'
    ],
];
