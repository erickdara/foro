<?php
/**
 * Build a configuration array to pass to `Hybridauth\Hybridauth`
 */

$config = [
    /**
     * Set the Authorization callback URL to https://path/to/hybridauth/examples/example_06/callback.php.
     * Understandably, you need to replace 'path/to/hybridauth' with the real path to this script.
     */
    'callback' => 'http://localhost/Foro/example_06/callback.php',
    'providers' => [
        'Twitter' => [
            'enabled' => true,
            'keys' => [
                'key' => 'r1TpqNVJ4CvHaIsHNu10ALvsX',
                'secret' => 'VRMqNLLIpBgGSYyZUsg6BowoELs4sZtFSxcY5p6r2Rh6yTnhak',
            ],
        ],
        'LinkedIn' => [
            'enabled' => true,
            'keys' => [
                'id' => '...',
                'secret' => '...',
            ],
        ],
        'Facebook' => [
            'enabled' => true,
            'keys' => [
                'id' => '464ccdbcb7657881d051219256aa8123',
                'secret' => '...',
            ],
        ],
    ],
];
