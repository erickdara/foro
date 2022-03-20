<?php

$config = [

    'callback' => "http://localhost/Foro/App/Auth/callback.php",
    //'callback' => "http://localhost/Foro/App/Auth/Auth.php",

    'providers' => [
        'Twitter' => [
            'enabled' => true,
            'keys' => [
                'key' => 'r1TpqNVJ4CvHaIsHNu10ALvsX',
                'secret' => 'VRMqNLLIpBgGSYyZUsg6BowoELs4sZtFSxcY5p6r2Rh6yTnhak',
            ],
            "includeEmail" => true,
        ],

        'Facebook' => [
            'enabled' => true,
            'keys' => [
                'id' => '427082155860894',
                'secret' => '464ccdbcb7657881d051219256aa8123',
            ],
            "scope" => "email",
        ],

        'Google' => [
            'enabled' => true,
            'keys' => ['id' => '78280605947-5b83n49acaot3ndt7rmjo9ikctjvmg6c.apps.googleusercontent.com', 'secret' => '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'],
        ],
    ],
];
