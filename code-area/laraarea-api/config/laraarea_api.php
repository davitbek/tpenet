<?php

$root = last(explode(DIRECTORY_SEPARATOR, app()->basePath()));

return [
    'translation_path' => 'laraarea_api',
    'query_params' => [
        'auth' => [
            'username' => 'email',
            'password' => 'password',
            'current_password' => 'current_password',
            'login_token' => 'login_token',
            'remember_me' => 'remember_me',
            'refresh_token' => 'refresh_token',
            'remember_days' => 'remember_days',
            'reset' => 'email',
            'reset_token' => 'token',
            'get_access_tokens' => 'get_access_tokens',
        ]
    ],
    'auth' => [
        'table' => 'users',
        'scope' => [
            'criteria' => [
                // key => value
                // status => 1
                // is_admin => 1
            ],
            'error-message' => 'Some error message'
        ],
        'reset_table' => 'password_resets',
        'remember_me_days' => 30
    ],
    'error_codes' => [
        // @TODO delete some codes
        'un_categorized' => 1,
        'header_missed' => 2,
        'access_token_expired' => 3,
        'access_token_invalid' => 4,
        'access_token' => 5,
        'attempt' => 6,
        'incorrect_password' => 7,
        'invalid_email' => 8,
        'validation' => 9,
        'not_found' => 10,
    ],
    'messages' => [
        'invalid_user_credentials' => 'The user credentials were incorrect',
        'auth_failure' => 'Auth Failure',
        'invalid_email_or_token' => 'Email or token is invalid',
        'user_with_this_credentials_deleted' => 'User with this credentials is deleted',
        'unknown_error' => 'Unknown error occurred please try again',
        'current_password_is_wrong' => 'Current Password is wrong',
        'token_expired' => 'Token expired',
        'reset_password' => 'Passwod reseted successfully'
    ],
    'docs' => [
        'all' => '_db',
        'root' => 'storage' . DIRECTORY_SEPARATOR . 'api_docs',
        'base_docs_path' => 'docs',
        'resource_path' => 'resources'
    ],
    'production' => 'production',
    'root_paths' => [
        'model-factory' => 'database' . DIRECTORY_SEPARATOR . 'factories'
    ],
    'root_namespaces' => [
        // @TODO dynamically
        'controller' => 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR . 'HTTP' . DIRECTORY_SEPARATOR . 'Controllers',
        'request-handler' => 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR . 'HTTP' . DIRECTORY_SEPARATOR . 'RequestHandlers',
        'resource' => 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR . 'HTTP' . DIRECTORY_SEPARATOR . 'Resources',
        'response' => 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR . 'HTTP' . DIRECTORY_SEPARATOR . 'Responses',
        'model' => 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR . 'Models' ,
        'service' => 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR . 'Services',
        'validator' => 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR . 'Validators',
    ],
    'suffix' => [
        // @TODO dynamically
        'controller' => 'Controller',
        'request-handler' => 'RequestHandler',
        'resource' => 'Resource',
        'model' => '',
        'service' => 'Service',
        'validator' => 'Validator',
        'response' => 'Response',
        'model-factory' => 'Factory',
    ],
    'http_codes' => [
        'validation' => '422' // incoming in laravel json status code
    ],
    'storage' => [
        'disk' => 'local',
        'disks' => [
            'local' => [
                'domain' => 'public',
            ],
            'public' => [
                'domain' => '',
            ],
            's3' => [
                'domain' => 'api' . DIRECTORY_SEPARATOR . $root,
                'tables' => [
                ],
                'temporary_url' => true,
                'minutes' => 10,
            ]
        ]
    ],
    'aliases' => [
        'index' => [
//            'resource' => [
//                'alias_name' => [
//                    // here options
//                ]
//            ]
        ],
        'show' => [
//            'resource' => [
//                'alias_name' => [
//                    // here options
//                ]
//            ]
        ]
    ],
    'strong-aliases' => [
        'index' => [
//            'resource' => [
//                'alias_name' => [
//                    // here options
//                ]
//            ]
        ],
        'show' => [
//            'resource' => [
//                'alias_name' => [
//                    // here options
//                ]
//            ]
        ]
    ]
];