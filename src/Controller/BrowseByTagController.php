<?php

declare(strict_types=1);

/**
 * Copyright 2012-2026 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file LICENSE for license information (BSD). If you did not
 * receive this file, see http://www.horde.org/licenses/bsdl.php.
 *
 * @category Horde
 * @license  http://www.horde.org/licenses/bsdl.php BSD
 * @package  Trean
 */

namespace Horde\Trean\Controller;

use Horde;
use Horde\Core\Controller\Traits\HtmlResponseTrait;
use Horde\Core\Controller\Traits\RedirectResponseTrait;
use Horde_Notification_Handler;
use Horde_PageOutput;
use Horde_View_Topbar;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Trean;
use Trean_TagBrowser;
use Trean_Tagger;
use Trean_View_BookmarkList;

/**
 * PSR-15 controller for browsing bookmarks by tag.
 *
 * @category Horde
 * @license  http://www.horde.org/licenses/bsdl.php BSD
 * @package  Trean
 */
class BrowseByTagController implements RequestHandlerInterface
{
    use HtmlResponseTrait;
    use RedirectResponseTrait;

    public function __construct(
        private readonly Trean_Tagger $tagger,
        private readonly Horde_Notification_Handler $notification,
        private readonly Horde_PageOutput $pageOutput,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $route = $request->getAttribute('route', []);
        $tag = urldecode($route['tag'] ?? '');

        $tagBrowser = new Trean_TagBrowser($this->tagger, $tag);
        $view = new Trean_View_BookmarkList(null, $tagBrowser);

        if ($GLOBALS['conf']['content_index']['enabled']) {
            $topbar = $GLOBALS['injector']->getInstance(Horde_View_Topbar::class);
            $topbar->search = true;
            $topbar->searchAction = Horde::url('search.php');
        }

        Trean::addFeedLink();
        $title = sprintf(_("Tagged with %s"), $tag);

        Horde::startBuffer();
        $this->pageOutput->header(['title' => $title]);
        $this->notification->notify(['listeners' => 'status']);
        echo $view->render($title);
        $this->pageOutput->footer();
        $html = Horde::endBuffer();

        return $this->htmlResponse($html);
    }
}
