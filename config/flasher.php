<?php

return [
    'default' => 'flasher',

    'root_script' => true,

    'auto_render' => true,

    'scripts' => [],

    'styles' => [],

    'options' => [
        'position' => 'bottom-right',
        'timeout'  => 5000,
    ],

    'plugins' => [
        'flasher' => [
            'scripts' => ['/vendor/flasher/flasher.min.js'],
            'styles'  => ['/vendor/flasher/flasher.min.css'],
            'options' => [],
        ],
    ],

    'filter_criteria' => [],

    'presets' => [],

    'middleware' => [],

    'translate' => false,
];
