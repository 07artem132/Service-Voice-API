<?php

return [
    'connection' => [
        'timeout' => 1,
        'blocking' => 0,
        'nickname' => 'API' . random_int(0, 10), //Иногда возникает проблема с nickname is already in use
        'flags' => 'use_offline_as_virtual',
    ],
    'icon' => [
        'storage' => 'public',
        'path' => '/teamspeak3/icon/',
    ]
];