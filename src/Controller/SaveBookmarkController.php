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
use Horde\Core\Controller\Traits\JsonResponseTrait;
use Horde\Core\Controller\Traits\RedirectResponseTrait;
use Horde_Exception;
use Horde_Notification_Handler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Trean_Bookmarks;

/**
 * PSR-15 controller for saving (updating) a bookmark.
 *
 * @category Horde
 * @license  http://www.horde.org/licenses/bsdl.php BSD
 * @package  Trean
 */
class SaveBookmarkController implements RequestHandlerInterface
{
    use JsonResponseTrait;
    use RedirectResponseTrait;

    public function __construct(
        private readonly Trean_Bookmarks $bookmarks,
        private readonly Horde_Notification_Handler $notification,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $params = (array) $request->getParsedBody();

        try {
            $bookmark = $this->bookmarks->getBookmark((int) ($params['bookmark'] ?? 0));
            $oldUrl = $bookmark->url;
            $bookmark->url = $params['bookmark_url'] ?? '';
            $bookmark->title = $params['bookmark_title'] ?? '';
            $bookmark->description = $params['bookmark_description'] ?? '';
            $bookmark->tags = $params['treanBookmarkTags'] ?? '';

            if ($oldUrl != $bookmark->url) {
                $bookmark->http_status = '';
            }

            $bookmark->save();
            $result = ['data' => 'saved'];
        } catch (Horde_Exception $e) {
            $this->notification->push(
                sprintf(_("There was an error saving the bookmark: %s"), $e->getMessage()),
                'horde.error'
            );
            $result = ['error' => $e->getMessage()];
        }

        if (($params['format'] ?? '') === 'json') {
            return $this->jsonResponse($result);
        }

        $url = Horde::verifySignedUrl($params['url'] ?? '');
        if (!$url) {
            $url = (string) Horde::url('browse.php', true);
        }

        return $this->redirect($url);
    }
}
