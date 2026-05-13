<?php

use Horde\Trean\Controller\BrowseByTagController;
use Horde\Trean\Controller\DeleteBookmarkController;
use Horde\Trean\Controller\SaveBookmarkController;

$mapper->buildRoute(uri: '/b/save', name: 'SaveBookmark')
    ->withController(SaveBookmarkController::class)
    ->add();

$mapper->buildRoute(uri: '/b/delete', name: 'DeleteBookmark')
    ->withController(DeleteBookmarkController::class)
    ->add();

$mapper->buildRoute(uri: '/tag/:tag', name: 'BrowseByTag')
    ->withController(BrowseByTagController::class)
    ->add();
