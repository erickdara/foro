<?php
/**
 * Build a configuration array to pass to `Hybridauth\Hybridauth`
 *
 * Set the Authorization callback URL to https://path/to/hybridauth/examples/example_07/callback.php
 * Understandably, you need to replace 'path/to/hybridauth' with the real path to this script.
 */
$config = [
    'callback' => 'http://localhost/Foro/App/Auth/callback.php',
    'providers' => [

        'Google' => [
            'enabled' => true,
            'keys' => [
                'key' => '78280605947-5b83n49acaot3ndt7rmjo9ikctjvmg6c.apps.googleusercontent.com',
                'secret' => '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',
            ],
            'includeEmail' => true,
        ],

        // 'Yahoo' => ['enabled' => true, 'keys' => ['key' => '...', 'secret' => '...']],
        // 'Facebook' => ['enabled' => true, 'keys' => ['id' => '...', 'secret' => '...']],
        // 'Twitter' => ['enabled' => true, 'keys' => ['key' => '...', 'secret' => '...']],
        // 'Instagram' => ['enabled' => true, 'keys' => ['id' => '...', 'secret' => '...']],

    ],
];
