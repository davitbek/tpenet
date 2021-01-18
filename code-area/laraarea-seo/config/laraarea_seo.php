<?php

return [
    'web' => [
        'route' => [
            'as' => 'admin.',
            'middleware' => ['web', 'auth'],
            'prefix' => 'admin/'
        ],
        'view' => [
            'path' => 'admin'
        ]
    ],
    'uri' => [
        'prefix' => '{locale}/'
    ],
    'parameter' => [
        'required' => '{*}', // for vue js :*
//        'optional' => '{*?}' // when not set optional the it will be consider like optional and after *?
    ]
];
