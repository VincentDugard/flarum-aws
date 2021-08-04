<?php

/*
 * This file is part of askvortsov/flarum-azure.
 *
 * Copyright (c) 2021 Alexander Skvortsov.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Askvortsov\FlarumAzure;

use Flarum\Extend;
use Flarum\Filesystem\AwsDriver;

return [
    (new Extend\Filesystem)->driver('azure', AwsDriver::class)
];
