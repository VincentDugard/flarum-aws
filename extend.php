<?php

namespace VincentDugard\FlarumAws;

use Flarum\Extend;

return [
    (new Extend\Filesystem)->driver('aws', AwsDriver::class)
];
