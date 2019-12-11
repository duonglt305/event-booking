<?php

return [
    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'attendees',
        ],
    ],

    'providers' => [
        'attendees' => [
            'driver' => 'eloquent',
            'model' => \DG\Dissertation\Api\Models\Attendee::class
        ],
    ],
    'verification' => [
        'attendees' => [
            'expire' => 30,
        ]
    ]
];
