<?php

declare(strict_types=1);
/**
 * Trean configuration class factory
 *
 * Creates instances of the TreanConfig class.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(TreanConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Trean;

use Horde\Core\Config\ConfigLoader;
use Horde\Injector\Injector;

class TreanConfigFactory
{
    public function __construct(private Injector $injector) {}

    public function create(): TreanConfig
    {
        $state = $this->injector->get(ConfigLoader::class)->load('trean');
        return new TreanConfig($state->toArray());
    }
}
