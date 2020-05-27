<?php

return [
    '/' => [
        'controller' => 'IndexController',
        'action' => 'index',
    ],
    '/page/' => [
        'controller' => 'PagesController',
        'action' => 'index',
        'params' => [
            'id',
        ],
    ],
];