<?php

declare(strict_types=1);

/*
 * This file is part of the Faker package.
 *
 * (c) Oskar Stark <oskarstark@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Faker\Rector\FakerPropertyToMethodCallRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withRules([FakerPropertyToMethodCallRector::class])
    ->withConfiguredRule(FakerPropertyToMethodCallRector::class, [
        'name',
        'email',
        'address',
    ]);
