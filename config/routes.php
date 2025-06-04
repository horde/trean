<?php

/**
 * Setup default routes
 */
$mapper->connect(
    '/b/save',
    [
        'controller' => 'SaveBookmark',
    ]
);

$mapper->connect(
    '/b/delete',
    [
        'controller' => 'DeleteBookmark',
    ]
);

$mapper->connect(
    '/tag/:tag',
    [
        'controller' => 'BrowseByTag',
    ]
);
