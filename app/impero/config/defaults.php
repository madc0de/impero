<?php

use Pckg\Mail\Service\Mail\Handler\Command;

return [
    'pckg'    => [
        'auth' => [
            'gates'     => [
                [
                    'provider' => 'frontend',
                    'tags'     => ['auth:in'],
                    'redirect' => 'login',
                ],
            ],
            'tags'      => [
                'auth:in' => function() {
                    return auth()->isLoggedIn();
                },
            ],
            'providers' => [
                'frontend' => [
                    'type'           => \Pckg\Auth\Service\Provider\Database::class,
                    'entity'         => \Pckg\Auth\Entity\Users::class,
                    'hash'           => '', // fill this in env.php on each server
                    'version'        => 'secure',
                    'forgotPassword' => true,
                    'userGroup'      => 'status_id',
                ],
            ],
        ],
        'mail' => [
            'handler' => Command::class,
        ],
    ],
    'rollbar' => [
        'access_token' => 'af5cdf8a51284be0b3fd2d3af59a62f2',
    ],
    'site'    => [
        'contact' => [
            'email' => 'impero@foobar.si',
            'name'  => '/impero',
        ],
    ],
];