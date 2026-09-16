<?php

declare(strict_types=1);
/**
 * Trean configuration class
 *
 * Provides access to the Trean configuration settings.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(TreanConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Trean;

use Horde\Core\Config\State;
use Horde\Injector\Attribute\Factory;

#[Factory(factory: TreanConfigFactory::class, method: 'create')]
class TreanConfig extends State {}
