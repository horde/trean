<?php

use Horde\Core\Middleware\DefaultStack;
use Horde\Trean\Controller\BrowseByTagController;
use Horde\Trean\Controller\DeleteBookmarkController;
use Horde\Trean\Controller\SaveBookmarkController;

$mapper->buildRoute(uri: '/b/save', name: 'SaveBookmark')
    ->withController(SaveBookmarkController::class)
    ->withMiddleware(DefaultStack::get())
    ->add();

$mapper->buildRoute(uri: '/b/delete', name: 'DeleteBookmark')
    ->withController(DeleteBookmarkController::class)
    ->withMiddleware(DefaultStack::get())
    ->add();

$mapper->buildRoute(uri: '/tag/:tag', name: 'BrowseByTag')
    ->withController(BrowseByTagController::class)
    ->withMiddleware(DefaultStack::get())
    ->add();
